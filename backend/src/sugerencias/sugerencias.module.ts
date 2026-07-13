import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { Sugerencia } from './entities/sugerencia.entity';
import { SugerenciasService } from './sugerencias.service';
import { SugerenciasController } from './sugerencias.controller';
import { AuthModule } from '../auth/auth.module';

@Module({
  imports: [
    TypeOrmModule.forFeature([Sugerencia]),
    AuthModule,
  ],
  controllers: [SugerenciasController],
  providers: [SugerenciasService],
  exports: [SugerenciasService],
})
export class SugerenciasModule {}
