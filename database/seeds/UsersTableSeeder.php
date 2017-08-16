<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'ci' => str_random(10),
            'nombre' => 'Administrador',
            'apellido' => str_random(10),
            'tipo' => 'Administrador',
            'login' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        DB::table('users')->insert([
            'ci' => str_random(10),
            'nombre' => 'Juan',
            'apellido' => 'Vasquez',
            'tipo' => 'Tecnico',
            'login' => 'tecnico',
            'password' => bcrypt('tecnico'),
        ]);
        DB::table('users')->insert([
            'ci' => '123456',
            'nombre' => 'Jose',
            'apellido' => 'Perez',
            'tipo' => 'Productor',
            'login' => '123456',
            'password' => bcrypt('123456'),
        ]);
    }
}
