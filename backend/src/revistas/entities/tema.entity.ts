import { Entity, PrimaryGeneratedColumn, Column, OneToMany, ManyToMany } from 'typeorm';
import { Revista } from './revista.entity';

@Entity('temas')
export class Tema {
  @PrimaryGeneratedColumn()
  id: number;

  @Column({ type: 'varchar', length: 100, unique: true })
  tema: string;

  @OneToMany(() => Revista, (revista) => revista.temaPrincipal)
  revistasPrimarias: Revista[];

  @ManyToMany(() => Revista, (revista) => revista.temasAdicionales)
  revistasAdicionales: Revista[];
}
