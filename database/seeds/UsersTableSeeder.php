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
//        DB::table('users')->insert([
//            'ci' => str_random(10),
//            'nombre' => 'Administrador',
//            'apellido' => str_random(10),
//            'tipo' => 'Administrador',
//            'login' => 'admin',
//            'password' => bcrypt('admin'),
//        ]);
//        DB::table('users')->insert([
//            'ci' => str_random(10),
//            'nombre' => 'Juan',
//            'apellido' => 'Vasquez',
//            'tipo' => 'Tecnico',
//            'login' => 'tecnico',
//            'password' => bcrypt('tecnico'),
//        ]);
//        DB::table('users')->insert([
//            'ci' => '123456',
//            'nombre' => 'Jose',
//            'apellido' => 'Perez',
//            'tipo' => 'Productor',
//            'login' => '123456',
//            'password' => bcrypt('123456'),
//        ]);
        $faker = Faker\Factory::create();

        for($i = 0; $i < 10; $i++) {
            $rand = rand(100000,999999);
            DB::table('users')->insert([
                'ci' => $rand,
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'tipo' => 'Tecnico',
                'telefono' => $faker->numberBetween($min = 4000000, $max = 4999999),
                'direccion' => $faker->streetAddress,
                'login' => $faker->userName,
                'password' => bcrypt('tecnico')
            ]);
        }
        for($i = 0; $i < 10; $i++) {
            $rand = rand(100000,999999);
            DB::table('users')->insert([
                'ci' => $rand,
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'tipo' => 'Productor',
                'telefono' => $faker->numberBetween($min = 4000000, $max = 4999999),
                'direccion' => $faker->streetAddress,
                'login' => $rand,
                'password' => bcrypt($rand)
            ]);
        }
    }
}
