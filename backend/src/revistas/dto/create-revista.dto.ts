import { IsString, IsNotEmpty, IsEnum, IsOptional, IsNumber, IsInt, Min, Max, IsArray, IsBoolean } from 'class-validator';
import { Cuartil, Idioma } from '../entities/revista.entity';

export class CreateRevistaDto {
  @IsString()
  @IsNotEmpty({ message: 'El título de la revista es requerido' })
  tituloRevista: string;

  @IsInt({ message: 'El ID del tema principal debe ser un número entero' })
  @IsNotEmpty({ message: 'El tema principal es requerido' })
  temaPrincipalId: number;

  @IsArray()
  @IsOptional()
  @IsInt({ each: true, message: 'Cada ID de tema adicional debe ser un número entero' })
  temasAdicionalesIds?: number[];

  @IsEnum(Cuartil, { message: 'El cuartil debe ser un valor válido' })
  @IsOptional()
  cuartil?: Cuartil;

  @IsEnum(Idioma, { message: 'El idioma debe ser un valor válido' })
  idioma: Idioma;

  @IsNumber({}, { message: 'El costo debe ser un número decimal válido' })
  @IsOptional()
  costo?: number;

  @IsBoolean({ message: 'El campo openAccess debe ser un valor booleano' })
  @IsOptional()
  openAccess?: boolean;

  @IsBoolean({ message: 'El campo arbitrada debe ser un valor booleano' })
  @IsOptional()
  arbitrada?: boolean;

  @IsInt({ message: 'La puntuación debe ser un número entero' })
  @Min(0)
  @Max(5)
  @IsOptional()
  puntuacion?: number;

  @IsInt({ message: 'El nivel de recomendación debe ser un número entero' })
  @Min(0)
  @Max(5)
  @IsOptional()
  nivelRecomendacion?: number;

  @IsString()
  @IsNotEmpty({ message: 'La descripción es requerida' })
  descripcion: string;

  @IsString()
  @IsOptional()
  enlace?: string;

  @IsArray()
  @IsOptional()
  @IsInt({ each: true, message: 'Cada ID de indexación debe ser un número entero' })
  indexacionIds?: number[];
}
