import { Controller, Get, Post, Put, Delete, Body, Param, Query, UseGuards, ParseIntPipe } from '@nestjs/common';
import { RevistasService } from './revistas.service';
import { CreateRevistaDto } from './dto/create-revista.dto';
import { UpdateRevistaDto } from './dto/update-revista.dto';
import { JwtAuthGuard } from '../auth/guards/jwt-auth.guard';
import { RolesGuard } from '../auth/guards/roles.guard';
import { Roles } from '../auth/decorators/roles.decorator';
import { Role } from '../users/enums/role.enum';

@Controller('revistas')
export class RevistasController {
  constructor(private readonly revistasService: RevistasService) {}

  @Post()
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(Role.ADMIN)
  create(@Body() createRevistaDto: CreateRevistaDto) {
    return this.revistasService.create(createRevistaDto);
  }

  @Get()
  findAll(
    @Query('q') q?: string,
    @Query('tema') tema?: string,
    @Query('cuartil') cuartil?: string,
    @Query('idioma') idioma?: string,
    @Query('puntuacionMin') puntuacionMin?: number,
    @Query('recomendacionMin') recomendacionMin?: number,
    @Query('indexacionId') indexacionId?: number,
    @Query('orden') orden?: string,
    @Query('limit') limit?: number,
    @Query('offset') offset?: number,
  ) {
    return this.revistasService.findAll({
      q,
      tema,
      cuartil,
      idioma,
      puntuacionMin,
      recomendacionMin,
      indexacionId,
      orden,
      limit,
      offset,
    });
  }

  @Get(':id')
  findOne(@Param('id', ParseIntPipe) id: number) {
    return this.revistasService.findOne(id);
  }

  @Put(':id')
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(Role.ADMIN)
  update(@Param('id', ParseIntPipe) id: number, @Body() updateRevistaDto: UpdateRevistaDto) {
    return this.revistasService.update(id, updateRevistaDto);
  }

  @Delete(':id')
  @UseGuards(JwtAuthGuard, RolesGuard)
  @Roles(Role.ADMIN)
  remove(@Param('id', ParseIntPipe) id: number) {
    return this.revistasService.remove(id);
  }
}
