import { Entity, PrimaryGeneratedColumn, Column, ManyToMany } from 'typeorm';
import { Revista } from './revista.entity';

@Entity('indexaciones')
export class Indexacion {
  @PrimaryGeneratedColumn()
  id: number;

  @Column({ type: 'varchar', length: 100 })
  indexacion: string;

  @ManyToMany(() => Revista, (revista) => revista.indexaciones)
  revistas: Revista[];
}
