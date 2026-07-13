import { Injectable, BadRequestException, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Tema } from './entities/tema.entity';
import { Revista } from './entities/revista.entity';

@Injectable()
export class TemasService {
  constructor(
    @InjectRepository(Tema)
    private temasRepository: Repository<Tema>,
    @InjectRepository(Revista)
    private revistasRepository: Repository<Revista>,
  ) {}

  async findAll(): Promise<Tema[]> {
    return this.temasRepository.find({ order: { tema: 'ASC' } });
  }

  async create(temaName: string): Promise<Tema> {
    const existing = await this.temasRepository.findOne({ where: { tema: temaName } });
    if (existing) {
      throw new BadRequestException('El tema ya existe');
    }
    const nuevo = this.temasRepository.create({ tema: temaName });
    return this.temasRepository.save(nuevo);
  }

  async remove(id: number): Promise<void> {
    const tema = await this.temasRepository.findOne({ where: { id } });
    if (!tema) {
      throw new NotFoundException(`Tema con ID ${id} no encontrado`);
    }

    // Check if any journals are associated with this theme as primary theme
    const countPrincipal = await this.revistasRepository.count({
      where: { temaPrincipal: { id } },
    });

    // Check if any journals are associated with this theme as additional theme
    const countAdicional = await this.revistasRepository.createQueryBuilder('revista')
      .leftJoin('revista.temasAdicionales', 'tema')
      .where('tema.id = :id', { id })
      .getCount();

    if (countPrincipal > 0 || countAdicional > 0) {
      throw new BadRequestException('No se puede eliminar el tema porque tiene revistas asociadas');
    }

    await this.temasRepository.remove(tema);
  }
}
