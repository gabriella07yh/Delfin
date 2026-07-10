import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository, In } from 'typeorm';
import { Revista, Tema, Cuartil, Idioma } from './entities/revista.entity';
import { Indexacion } from './entities/indexacion.entity';
import { CreateRevistaDto } from './dto/create-revista.dto';
import { UpdateRevistaDto } from './dto/update-revista.dto';

@Injectable()
export class RevistasService {
  constructor(
    @InjectRepository(Revista)
    private revistasRepository: Repository<Revista>,
    @InjectRepository(Indexacion)
    private indexacionesRepository: Repository<Indexacion>,
  ) {}

  async create(createRevistaDto: CreateRevistaDto): Promise<Revista> {
    const { indexacionIds, ...revistaData } = createRevistaDto;
    const revista = this.revistasRepository.create(revistaData);

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
      .leftJoinAndSelect('revista.indexaciones', 'indexacion');

    if (filters.q) {
      query.andWhere(
        '(revista.tituloRevista LIKE :q OR revista.descripcion LIKE :q)',
        { q: `%${filters.q}%` }
      );
    }

    if (filters.tema) {
      query.andWhere('revista.tema = :tema', { tema: filters.tema });
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
      relations: { indexaciones: true },
    });
    if (!revista) {
      throw new NotFoundException(`Revista con ID ${id} no encontrada`);
    }
    return revista;
  }

  async update(id: number, updateRevistaDto: UpdateRevistaDto): Promise<Revista> {
    const { indexacionIds, ...revistaData } = updateRevistaDto;
    const revista = await this.findOne(id);

    Object.assign(revista, revistaData);

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
    const countIndexaciones = await this.indexacionesRepository.count();
    let indexes: Indexacion[] = [];
    if (countIndexaciones === 0) {
      const names = ['Scopus', 'PubMed', 'Web of Science', 'SciELO', 'DOAJ', 'Latindex', 'Redalyc'];
      for (const name of names) {
        const idx = this.indexacionesRepository.create({ indexacion: name });
        indexes.push(await this.indexacionesRepository.save(idx));
      }
      console.log('Seeded indexaciones successfully.');
    } else {
      indexes = await this.indexacionesRepository.find();
    }

    const countRevistas = await this.revistasRepository.count();
    if (countRevistas === 0) {
      const sampleRevistas = [
        {
          tituloRevista: 'Salud Pública de México',
          tema: Tema.SALUD,
          cuartil: Cuartil.Q2,
          idioma: Idioma.ESPANOL,
          costo: 0,
          puntuacion: 5,
          nivelRecomendacion: 4,
          descripcion: 'Una de las revistas de salud pública más importantes de México y Latinoamérica. Fundada en 1959, pública investigación sobre problemas de salud de la población.',
          enlace: 'https://saludpublica.mx',
          indexationNames: ['Scopus', 'PubMed', 'SciELO', 'Latindex'],
        },
        {
          tituloRevista: 'IEEE Transactions on Software Engineering',
          tema: Tema.TECNOLOGIA,
          cuartil: Cuartil.Q1,
          idioma: Idioma.INGLES,
          costo: 2300,
          puntuacion: 5,
          nivelRecomendacion: 5,
          descripcion: 'Focuses on software engineering, methods, process, and quality. A premier journal in the field.',
          enlace: 'https://ieeexplore.ieee.org',
          indexationNames: ['Scopus', 'Web of Science'],
        },
        {
          tituloRevista: 'Revista Iberoamericana de Educación',
          tema: Tema.EDUCACION,
          cuartil: Cuartil.Q3,
          idioma: Idioma.ESPANOL,
          costo: 0,
          puntuacion: 4,
          nivelRecomendacion: 4,
          descripcion: 'Revista de educación editada por la OEI. Fomenta el intercambio de reformas estructurales educativas en toda Latinoamérica.',
          enlace: 'https://rieoei.org',
          indexationNames: ['DOAJ', 'Latindex', 'Redalyc'],
        },
      ];

      for (const sample of sampleRevistas) {
        const { indexationNames, ...revistaData } = sample;
        const revista = this.revistasRepository.create(revistaData);
        revista.indexaciones = indexes.filter(idx => indexationNames.includes(idx.indexacion));
        await this.revistasRepository.save(revista);
      }
      console.log('Seeded sample revistas successfully.');
    }
  }
}
