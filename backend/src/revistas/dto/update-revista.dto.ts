import { IsString, IsNotEmpty, IsEnum, IsOptional, IsNumber, IsInt, Min, Max, IsArray } from 'class-validator';
import { Tema, Cuartil, Idioma } from '../entities/revista.entity';

export class UpdateRevistaDto {
  @IsString()
  @IsOptional()
  tituloRevista?: string;

  @IsEnum(Tema)
  @IsOptional()
  tema?: Tema;

  @IsEnum(Cuartil)
  @IsOptional()
  cuartil?: Cuartil;

  @IsEnum(Idioma)
  @IsOptional()
  idioma?: Idioma;

  @IsNumber()
  @IsOptional()
  costo?: number;

  @IsInt()
  @Min(1)
  @Max(5)
  @IsOptional()
  puntuacion?: number;

  @IsInt()
  @Min(1)
  @Max(5)
  @IsOptional()
  nivelRecomendacion?: number;

  @IsString()
  @IsOptional()
  descripcion?: string;

  @IsString()
  @IsOptional()
  enlace?: string;

  @IsArray()
  @IsOptional()
  indexacionIds?: number[];
}
