import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { Revista } from './entities/revista.entity';
import { Indexacion } from './entities/indexacion.entity';
import { RevistasService } from './revistas.service';
import { RevistasController } from './revistas.controller';
import { AuthModule } from '../auth/auth.module';

@Module({
  imports: [
    TypeOrmModule.forFeature([Revista, Indexacion]),
    AuthModule,
  ],
  controllers: [RevistasController],
  providers: [RevistasService],
  exports: [RevistasService, TypeOrmModule],
})
export class RevistasModule {}
