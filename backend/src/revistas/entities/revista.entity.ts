import { Entity, PrimaryGeneratedColumn, Column, ManyToMany, ManyToOne, JoinColumn, JoinTable } from 'typeorm';
import { Indexacion } from './indexacion.entity';
import { Tema } from './tema.entity';

export enum Cuartil {
  Q1 = 'Q1',
  Q2 = 'Q2',
  Q3 = 'Q3',
  Q4 = 'Q4',
  SIN_ASIGNAR = 'SIN ASIGNAR',
}

export enum Idioma {
  ESPANOL = 'Espanol',
  INGLES = 'Ingles',
  PORTUGUES = 'Portugues',
  FRANCES = 'Frances',
  OTRO = 'Otro',
}

@Entity('revistas')
export class Revista {
  @PrimaryGeneratedColumn()
  id: number;

  @Column({ name: 'titulo_revista', type: 'varchar', length: 300 })
  tituloRevista: string;

  @ManyToOne(() => Tema, (tema) => tema.revistasPrimarias, { nullable: false, onDelete: 'RESTRICT' })
  @JoinColumn({ name: 'id_tema' })
  temaPrincipal: Tema;

  @ManyToMany(() => Tema, (tema) => tema.revistasAdicionales, { cascade: true })
  @JoinTable({
    name: 'revista_tema',
    joinColumn: { name: 'id_revista', referencedColumnName: 'id' },
    inverseJoinColumn: { name: 'id_tema', referencedColumnName: 'id' },
  })
  temasAdicionales: Tema[];

  @Column({
    type: 'enum',
    enum: Cuartil,
    default: Cuartil.SIN_ASIGNAR,
  })
  cuartil: Cuartil;

  @Column({
    type: 'enum',
    enum: Idioma,
  })
  idioma: Idioma;

  @Column({ type: 'decimal', precision: 10, scale: 2, default: 0 })
  costo: number;

  @Column({ name: 'open_access', type: 'boolean', default: false })
  openAccess: boolean;

  @Column({ type: 'boolean', default: false })
  arbitrada: boolean;

  @Column({ type: 'tinyint', unsigned: true, default: 0 })
  puntuacion: number;

  @Column({ name: 'nivel_recomendacion', type: 'tinyint', unsigned: true, default: 0 })
  nivelRecomendacion: number;

  @Column({ type: 'text' })
  descripcion: string;

  @Column({ type: 'varchar', length: 2083, nullable: true })
  enlace: string;

  @ManyToMany(() => Indexacion, (indexacion) => indexacion.revistas, { cascade: true })
  @JoinTable({
    name: 'revista_indexacion',
    joinColumn: { name: 'id_revista', referencedColumnName: 'id' },
    inverseJoinColumn: { name: 'id_indexacion', referencedColumnName: 'id' },
  })
  indexaciones: Indexacion[];
}
