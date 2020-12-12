<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
}); 

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Speclialitys
Route::get('/specialities', 'SpecialityController@index');
Route::get('/specialities/create', 'SpecialityController@create');// Form registro
Route::get('/specialities/{speciality}/edit', 'SpecialityController@edit');
Route::post('/specialities', 'SpecialityController@store');// envio del form
Route::put('/specialities/{speciality}', 'SpecialityController@update');
Route::delete('/specialities/{speciality}', 'SpecialityController@destroy');

// Doctors
Route::resource('doctors', 'DoctorController');

//Pacients

