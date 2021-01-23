<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Appointment;
use App\User;

$factory->define(Appointment::class, function (Faker $faker) {
	$doctorsIds = User::doctors()->pluck('id');
	$patientsIds = User::patients()->pluck('id');

	$date = $faker->dateTimeBetween('-1 years', 'now');
	$scheduled_date = $date->format('Y-m-d');
	$scheduled_time = $date->format('H:i:s');

	$types = ['Consulta', 'Examen', 'Operación'];
	$statuses = ['Atendida', 'Cancelada'];//'Reservada', 'Confirmada'

    return [
        'description' => $faker->sentence(5),
        'speciality_id' => $faker->numberBetween(1, 3),
        'doctor_id' => $faker->randomElement($doctorsIds),
        'patient_id' => $faker->randomElement($patientsIds),
        'scheduled_date' => $scheduled_date,
        'scheduled_time' => $scheduled_time,
        'type' => $faker->randomElement($types),
        'status' => $faker->randomElement($statuses)
    ];
});
