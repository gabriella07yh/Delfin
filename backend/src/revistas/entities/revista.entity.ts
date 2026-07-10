import { Entity, PrimaryGeneratedColumn, Column, ManyToMany, JoinTable } from 'typeorm';
import { Indexacion } from './indexacion.entity';

export enum Tema {
  TECNOLOGIA = 'Tecnología',
  EDUCACION = 'Educación',
  MULTIDISCIPLINARIA = 'Multidisciplinaria',
  SALUD = 'Salud',
}

export enum Cuartil {
  Q1 = 'Q1',
  Q2 = 'Q2',
  Q3 = 'Q3',
  Q4 = 'Q4',
  SIN_ASIGNAR = 'SIN ASIGNAR',
}

export enum Idioma {
  ESPANOL = 'Español',
  INGLES = 'Inglés',
  PORTUGUES = 'Portugués',
  FRANCES = 'Francés',
  OTRO = 'Otro',
}

@Entity('revistas')
export class Revista {
  @PrimaryGeneratedColumn()
  id: number;

  @Column({ name: 'titulo_revista', type: 'varchar', length: 100 })
  tituloRevista: string;

  @Column({
    type: 'enum',
    enum: Tema,
  })
  tema: Tema;

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

  @Column({ type: 'tinyint', unsigned: true })
  puntuacion: number;

  @Column({ name: 'nivel_recomendacion', type: 'tinyint', unsigned: true })
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
