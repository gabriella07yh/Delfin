import { Injectable, NotFoundException, BadRequestException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository, In } from 'typeorm';
import { Revista, Cuartil, Idioma } from './entities/revista.entity';
import { Indexacion } from './entities/indexacion.entity';
import { Tema } from './entities/tema.entity';
import { CreateRevistaDto } from './dto/create-revista.dto';
import { UpdateRevistaDto } from './dto/update-revista.dto';

@Injectable()
export class RevistasService {
  constructor(
    @InjectRepository(Revista)
    private revistasRepository: Repository<Revista>,
    @InjectRepository(Indexacion)
    private indexacionesRepository: Repository<Indexacion>,
    @InjectRepository(Tema)
    private temasRepository: Repository<Tema>,
  ) {}

  async create(createRevistaDto: CreateRevistaDto): Promise<Revista> {
    const { indexacionIds, temaPrincipalId, temasAdicionalesIds, ...revistaData } = createRevistaDto;

    const revista = this.revistasRepository.create(revistaData);

    // Resolve primary theme
    const temaPrincipal = await this.temasRepository.findOne({ where: { id: temaPrincipalId } });
    if (!temaPrincipal) {
      throw new NotFoundException(`Tema principal con ID ${temaPrincipalId} no encontrado`);
    }
    revista.temaPrincipal = temaPrincipal;

    // Resolve additional themes
    if (temasAdicionalesIds && temasAdicionalesIds.length > 0) {
      revista.temasAdicionales = await this.temasRepository.findBy({
        id: In(temasAdicionalesIds),
      });
    }

    // Resolve indexations
    if (indexacionIds && indexacionIds.length > 0) {
      revista.indexaciones = await this.indexacionesRepository.findBy({
        id: In(indexacionIds),
      });
    }

    return this.revistasRepository.save(revista);
  }

  async findAll(filters: {
    q?: string;
    tema?: string;
    cuartil?: string;
    idioma?: string;
    puntuacionMin?: number;
    recomendacionMin?: number;
    indexacionId?: number;
    orden?: string;
    limit?: number;
    offset?: number;
  }): Promise<{ data: Revista[]; total: number }> {
    const query = this.revistasRepository.createQueryBuilder('revista')
      .leftJoinAndSelect('revista.indexaciones', 'indexacion')
      .leftJoinAndSelect('revista.temaPrincipal', 'temaPrincipal')
      .leftJoinAndSelect('revista.temasAdicionales', 'temaAdicional');

    if (filters.q) {
      query.andWhere(
        '(revista.tituloRevista LIKE :q OR revista.descripcion LIKE :q OR temaPrincipal.tema LIKE :q OR temaAdicional.tema LIKE :q)',
        { q: `%${filters.q}%` }
      );
    }

    if (filters.tema) {
      query.andWhere(
        '(temaPrincipal.tema = :tema OR temaAdicional.tema = :tema)',
        { tema: filters.tema }
      );
    }

    if (filters.cuartil) {
      query.andWhere('revista.cuartil = :cuartil', { cuartil: filters.cuartil });
    }

    if (filters.idioma) {
      query.andWhere('revista.idioma = :idioma', { idioma: filters.idioma });
    }

    if (filters.puntuacionMin) {
      query.andWhere('revista.puntuacion >= :puntuacionMin', {
        puntuacionMin: Number(filters.puntuacionMin),
      });
    }

    if (filters.recomendacionMin) {
      query.andWhere('revista.nivelRecomendacion >= :recomendacionMin', {
        recomendacionMin: Number(filters.recomendacionMin),
      });
    }

    if (filters.indexacionId) {
      query.andWhere((qb) => {
        const subQuery = qb.subQuery()
          .select('ri.id_revista')
          .from('revista_indexacion', 'ri')
          .where('ri.id_indexacion = :indexacionId')
          .getQuery();
        return 'revista.id IN ' + subQuery;
      });
      query.setParameter('indexacionId', Number(filters.indexacionId));
    }

    const orden = filters.orden || 'puntuacion';
    if (orden === 'titulo') {
      query.orderBy('revista.tituloRevista', 'ASC');
    } else if (orden === 'costo') {
      query.orderBy('revista.costo', 'ASC');
    } else if (orden === 'recomendacion') {
      query.orderBy('revista.nivelRecomendacion', 'DESC');
    } else {
      query.orderBy('revista.puntuacion', 'DESC');
    }

    const limit = Number(filters.limit) || 10;
    const offset = Number(filters.offset) || 0;
    query.skip(offset).take(limit);

    const [data, total] = await query.getManyAndCount();
    return { data, total };
  }

  async findOne(id: number): Promise<Revista> {
    const revista = await this.revistasRepository.findOne({
      where: { id },
      relations: { indexaciones: true, temaPrincipal: true, temasAdicionales: true },
    });
    if (!revista) {
      throw new NotFoundException(`Revista con ID ${id} no encontrada`);
    }
    return revista;
  }

  async update(id: number, updateRevistaDto: UpdateRevistaDto): Promise<Revista> {
    const { indexacionIds, temaPrincipalId, temasAdicionalesIds, ...revistaData } = updateRevistaDto;
    const revista = await this.findOne(id);

    Object.assign(revista, revistaData);

    if (temaPrincipalId !== undefined) {
      const temaPrincipal = await this.temasRepository.findOne({ where: { id: temaPrincipalId } });
      if (!temaPrincipal) {
        throw new NotFoundException(`Tema principal con ID ${temaPrincipalId} no encontrado`);
      }
      revista.temaPrincipal = temaPrincipal;
    }

    if (temasAdicionalesIds !== undefined) {
      if (temasAdicionalesIds.length > 0) {
        revista.temasAdicionales = await this.temasRepository.findBy({
          id: In(temasAdicionalesIds),
        });
      } else {
        revista.temasAdicionales = [];
      }
    }

    if (indexacionIds !== undefined) {
      if (indexacionIds.length > 0) {
        revista.indexaciones = await this.indexacionesRepository.findBy({
          id: In(indexacionIds),
        });
      } else {
        revista.indexaciones = [];
      }
    }

    return this.revistasRepository.save(revista);
  }

  async remove(id: number): Promise<void> {
    const revista = await this.findOne(id);
    await this.revistasRepository.remove(revista);
  }

  async seedRevistas(): Promise<void> {
    // Seed indexaciones
    const countIndexaciones = await this.indexacionesRepository.count();
    let indexes: Indexacion[] = [];
    const indexationNames = [
      'Scopus', 'PubMed', 'Web of Science', 'SciELO', 'DOAJ', 'Latindex', 'Redalyc',
      'CINAHL', 'Catálogos académicos', 'Catálogos institucionales', 'Catálogos regionales',
      'Catálogos universitarios', 'Cochrane', 'Conahcyt', 'Dialnet', 'Directorios académicos',
      'EMBASE', 'ESCI', 'Google Scholar', 'IMBIOMED', 'Index Medicus', 'Lilacs', 'MEDLINE',
      'MIAR', 'Medigraphic', 'Portal institucional universitario', 'PsycINFO', 'PubMed Central',
      'PubMed/MEDLINE', 'SCImago', 'SciELO México', 'ScienceDirect'
    ];

    if (countIndexaciones === 0) {
      for (const name of indexationNames) {
        const idx = this.indexacionesRepository.create({ indexacion: name });
        indexes.push(await this.indexacionesRepository.save(idx));
      }
      console.log('Seeded indexaciones successfully.');
    } else {
      indexes = await this.indexacionesRepository.find();
    }

    // Seed temas
    const countTemas = await this.temasRepository.count();
    let temas: Tema[] = [];
    const themeNames = [
      'Agricultural and Biological Sciences',
      'Arts and Humanities',
      'Biochemistry, Genetics and Molecular Biology',
      'Business, Management and Accounting',
      'Chemical Engineering',
      'Chemistry',
      'Computer Science',
      'Decision Sciences',
      'Dentistry',
      'Earth and Planetary Sciences',
      'Economics, Econometrics and Finance',
      'Energy',
      'Engineering',
      'Environmental Science',
      'Health Professions',
      'Immunology and Microbiology',
      'Materials Science',
      'Mathematics',
      'Medicine',
      'Multidisciplinary',
      'Neuroscience',
      'Nursing',
      'Pharmacology, Toxicology and Pharmaceutics',
      'Physics and Astronomy',
      'Psychology',
      'Social Sciences',
      'Veterinary'
    ];

    if (countTemas === 0) {
      for (const name of themeNames) {
        const t = this.temasRepository.create({ tema: name });
        temas.push(await this.temasRepository.save(t));
      }
      console.log('Seeded temas successfully.');
    } else {
      temas = await this.temasRepository.find();
    }

    // Seed sample revistas
    const countRevistas = await this.revistasRepository.count();
    if (countRevistas === 0) {
      const sampleRevistas = [
        {
          tituloRevista: 'Salud Pública de México',
          cuartil: Cuartil.Q2,
          idioma: Idioma.ESPANOL,
          costo: 0,
          openAccess: true,
          arbitrada: true,
          puntuacion: 5,
          nivelRecomendacion: 4,
          descripcion: 'Una de las revistas de salud pública más importantes de México y Latinoamérica. Fundada en 1959, pública investigación sobre problemas de salud de la población.',
          enlace: 'https://saludpublica.mx',
          temaPrincipalName: 'Medicine',
          temasAdicionalesNames: ['Health Professions'],
          indexationNames: ['Scopus', 'PubMed', 'SciELO', 'Latindex'],
        },
        {
          tituloRevista: 'IEEE Transactions on Software Engineering',
          cuartil: Cuartil.Q1,
          idioma: Idioma.INGLES,
          costo: 2300,
          openAccess: false,
          arbitrada: true,
          puntuacion: 5,
          nivelRecomendacion: 5,
          descripcion: 'Focuses on software engineering, methods, process, and quality. A premier journal in the field.',
          enlace: 'https://ieeexplore.ieee.org',
          temaPrincipalName: 'Computer Science',
          temasAdicionalesNames: ['Engineering'],
          indexationNames: ['Scopus', 'Web of Science'],
        },
        {
          tituloRevista: 'Revista Iberoamericana de Educación',
          cuartil: Cuartil.Q3,
          idioma: Idioma.ESPANOL,
          costo: 0,
          openAccess: true,
          arbitrada: true,
          puntuacion: 4,
          nivelRecomendacion: 4,
          descripcion: 'Revista de educación editada por la OEI. Fomenta el intercambio de reformas estructurales educativas en toda Latinoamérica.',
          enlace: 'https://rieoei.org',
          temaPrincipalName: 'Social Sciences',
          temasAdicionalesNames: ['Arts and Humanities'],
          indexationNames: ['DOAJ', 'Latindex', 'Redalyc'],
        },
      ];

      for (const sample of sampleRevistas) {
        const { indexationNames, temaPrincipalName, temasAdicionalesNames, ...revistaData } = sample;
        const revista = this.revistasRepository.create(revistaData);

        // Find primary theme
        const primary = temas.find(t => t.tema === temaPrincipalName);
        if (primary) {
          revista.temaPrincipal = primary;
        }

        // Find additional themes
        if (temasAdicionalesNames && temasAdicionalesNames.length > 0) {
          revista.temasAdicionales = temas.filter(t => temasAdicionalesNames.includes(t.tema));
        }

        // Find indexations
        if (indexationNames && indexationNames.length > 0) {
          revista.indexaciones = indexes.filter(idx => indexationNames.includes(idx.indexacion));
        }

        await this.revistasRepository.save(revista);
      }
      console.log('Seeded sample revistas successfully.');
    }
  }
}
