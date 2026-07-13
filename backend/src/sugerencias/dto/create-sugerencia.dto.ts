import { IsString, IsNotEmpty, IsEnum, IsOptional } from 'class-validator';
import { TipoProblema } from '../entities/sugerencia.entity';

export class CreateSugerenciaDto {
  @IsEnum(TipoProblema, { message: 'El tipo de problema debe ser un valor válido' })
  tipoProblema: TipoProblema;

  @IsString()
  @IsNotEmpty({ message: 'El nombre es requerido' })
  nombre: string;

  @IsString()
  @IsOptional()
  enlace?: string;

  @IsString()
  @IsNotEmpty({ message: 'Los detalles son requeridos' })
  detalles: string;
}
