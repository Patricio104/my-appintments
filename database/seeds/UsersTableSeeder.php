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
    	User::create([
        'name' => 'Patrick Juárez',
        'email' => 'pa@gmail.com',
        'password' => bcrypt('12345678'), // password
        'dni' =>'87654321',
        'address' => '',
        'phone' => '',
        'role' => 'admin'
    ]);

        factory(User::class, 50)->create();
    }
}
