import { IsString, IsNotEmpty, IsEnum, IsOptional, IsNumber, IsInt, Min, Max, IsArray } from 'class-validator';
import { Tema, Cuartil, Idioma } from '../entities/revista.entity';

export class CreateRevistaDto {
  @IsString()
  @IsNotEmpty({ message: 'El título de la revista es requerido' })
  tituloRevista: string;

  @IsEnum(Tema, { message: 'El tema debe ser un valor válido' })
  tema: Tema;

  @IsEnum(Cuartil, { message: 'El cuartil debe ser un valor válido' })
  @IsOptional()
  cuartil?: Cuartil;

  @IsEnum(Idioma, { message: 'El idioma debe ser un valor válido' })
  idioma: Idioma;

  @IsNumber({}, { message: 'El costo debe ser un número decimal válido' })
  @IsOptional()
  costo?: number;

  @IsInt({ message: 'La puntuación debe ser un número entero' })
  @Min(1)
  @Max(5)
  puntuacion: number;

  @IsInt({ message: 'El nivel de recomendación debe ser un número entero' })
  @Min(1)
  @Max(5)
  nivelRecomendacion: number;

  @IsString()
  @IsNotEmpty({ message: 'La descripción es requerida' })
  descripcion: string;

  @IsString()
  @IsOptional()
  enlace?: string;

  @IsArray()
  @IsOptional()
  indexacionIds?: number[];
}
