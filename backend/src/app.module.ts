import { Module, OnModuleInit } from '@nestjs/common';
import { ConfigModule, ConfigService } from '@nestjs/config';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { UsersModule } from './users/users.module';
import { AuthModule } from './auth/auth.module';
import { RevistasModule } from './revistas/revistas.module';
import { User } from './users/entities/user.entity';
import { Revista } from './revistas/entities/revista.entity';
import { Indexacion } from './revistas/entities/indexacion.entity';
import { UsersService } from './users/users.service';
import { RevistasService } from './revistas/revistas.service';

@Module({
  imports: [
    ConfigModule.forRoot({
      isGlobal: true,
    }),
    TypeOrmModule.forRootAsync({
      imports: [ConfigModule],
      inject: [ConfigService],
      useFactory: (configService: ConfigService) => ({
        type: 'mysql',
        host: configService.get<string>('DB_HOST') || 'localhost',
        port: configService.get<number>('DB_PORT') || 3306,
        username: configService.get<string>('DB_USERNAME') || 'root',
        password: configService.get<string>('DB_PASSWORD') || '',
        database: configService.get<string>('DB_DATABASE') || 'revistas',
        entities: [User, Revista, Indexacion],
        synchronize: true, // Auto-creates database schema based on entities
      }),
    }),
    UsersModule,
    AuthModule,
    RevistasModule,
  ],
  controllers: [AppController],
  providers: [AppService],
})
export class AppModule implements OnModuleInit {
  constructor(
    private readonly usersService: UsersService,
    private readonly revistasService: RevistasService,
  ) {}

  async onModuleInit() {
    console.log('Initializing database seeds...');
    try {
      await this.usersService.seedUsers();
      await this.revistasService.seedRevistas();
      console.log('Database seeding finished successfully.');
    } catch (error) {
      console.error('Error during database seeding:', error);
    }
  }
}
