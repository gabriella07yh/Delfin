import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Sugerencia, TipoProblema } from './entities/sugerencia.entity';
import { CreateSugerenciaDto } from './dto/create-sugerencia.dto';

@Injectable()
export class SugerenciasService {
  constructor(
    @InjectRepository(Sugerencia)
    private sugerenciasRepository: Repository<Sugerencia>,
  ) {}

  async findAll(tipo?: TipoProblema): Promise<Sugerencia[]> {
    const query = this.sugerenciasRepository.createQueryBuilder('sugerencia');
    if (tipo) {
      query.where('sugerencia.tipoProblema = :tipo', { tipo });
    }
    query.orderBy('sugerencia.fechaEnvio', 'DESC');
    return query.getMany();
  }

  async create(dto: CreateSugerenciaDto): Promise<Sugerencia> {
    const sugerencia = this.sugerenciasRepository.create(dto);
    return this.sugerenciasRepository.save(sugerencia);
  }

  async remove(id: number): Promise<void> {
    const sugerencia = await this.sugerenciasRepository.findOne({ where: { id } });
    if (!sugerencia) {
      throw new NotFoundException(`Sugerencia con ID ${id} no encontrada`);
    }
    await this.sugerenciasRepository.remove(sugerencia);
  }
}
