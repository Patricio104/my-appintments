<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // id 1
    	User::create([
            'name' => 'Patrick Juárez',
            'email' => 'pa@gmail.com',
            'password' => bcrypt('12345678'), // password
            'role' => 'admin'
        ]);

        //id 2
        User::create([
            'name' => 'Paciente Test',
            'email' => 'patient@gmail.com',
            'password' => bcrypt('12345678'), // password
            'role' => 'patient'
        ]);
        //id 3
        User::create([
            'name' => 'Médico Test',
            'email' => 'doctor@gmail.com',
            'password' => bcrypt('12345678'), // password
            'role' => 'doctor'
        ]);

        factory(User::class, 50)->states('patient')->create();
    }
}
