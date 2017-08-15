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
    }
}
