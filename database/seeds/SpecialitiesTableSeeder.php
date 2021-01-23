<?php

use Illuminate\Database\Seeder;
use App\Speciality;
use App\User;

class SpecialitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$specialities =[
    		'Oftamología',
    		'Pediatría',
    		'Neurogía'
    	];

    	foreach ($specialities as $specialityName) {
    		$speciality = Speciality::create([
    			'name' => $specialityName
    		]);

            $speciality->users()->saveMany(
            factory(User::class, 3)->states('doctor')->make()
            );
    	}

        User::find(3)->specialities()->save($speciality);
        
    }
}
