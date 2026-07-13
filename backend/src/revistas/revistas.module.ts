import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { Revista } from './entities/revista.entity';
import { Indexacion } from './entities/indexacion.entity';
import { Tema } from './entities/tema.entity';
import { RevistasService } from './revistas.service';
import { RevistasController } from './revistas.controller';
import { TemasService } from './temas.service';
import { TemasController } from './temas.controller';
import { AuthModule } from '../auth/auth.module';

@Module({
  imports: [
    TypeOrmModule.forFeature([Revista, Indexacion, Tema]),
    AuthModule,
  ],
  controllers: [RevistasController, TemasController],
  providers: [RevistasService, TemasService],
  exports: [RevistasService, TemasService, TypeOrmModule],
})
export class RevistasModule {}
