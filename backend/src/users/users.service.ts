import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { User } from './entities/user.entity';
import * as bcrypt from 'bcrypt';
import { Role } from './enums/role.enum';

@Injectable()
export class UsersService {
  constructor(
    @InjectRepository(User)
    private usersRepository: Repository<User>,
  ) {}

  async findByCorreo(correo: string): Promise<User | null> {
    return this.usersRepository.findOne({ where: { correo } });
  }

  async findById(id: number): Promise<User | null> {
    return this.usersRepository.findOne({ where: { id } });
  }

  async create(userData: Partial<User>): Promise<User> {
    const user = new User();
    Object.assign(user, userData);
    if (user.password) {
      const salt = await bcrypt.genSalt();
      user.password = await bcrypt.hash(user.password, salt);
    }
    return this.usersRepository.save(user);
  }

  // Seeder helper to ensure default admin and user exist
  async seedUsers(): Promise<void> {
    const adminEmail = 'admin@example.com';
    const userEmail = 'user@example.com';

    const adminExists = await this.findByCorreo(adminEmail);
    if (!adminExists) {
      await this.create({
        nombre: 'Admin Delfin',
        correo: adminEmail,
        password: 'adminpassword',
        rol: Role.ADMIN,
      });
      console.log('Seeded admin user: admin@example.com / adminpassword');
    }

    const userExists = await this.findByCorreo(userEmail);
    if (!userExists) {
      await this.create({
        nombre: 'Usuario Regular',
        correo: userEmail,
        password: 'userpassword',
        rol: Role.USER,
      });
      console.log('Seeded regular user: user@example.com / userpassword');
    }
  }
}
