import { Entity, PrimaryGeneratedColumn, Column, CreateDateColumn } from 'typeorm';

export enum TipoProblema {
  REVISTA = 'Revista',
  COMENTARIO = 'Comentario',
  PROBLEMA = 'Problema',
}

@Entity('sugerencias')
export class Sugerencia {
  @PrimaryGeneratedColumn()
  id: number;

  @Column({
    name: 'tipo_problema',
    type: 'enum',
    enum: TipoProblema,
  })
  tipoProblema: TipoProblema;

  @Column({ type: 'varchar', length: 80 })
  nombre: string;

  @Column({ type: 'varchar', length: 200, default: '' })
  enlace: string;

  @Column({ type: 'text' })
  detalles: string;

  @CreateDateColumn({
    name: 'fecha_envio',
    type: 'datetime',
    default: () => 'CURRENT_TIMESTAMP',
  })
  fechaEnvio: Date;
}
