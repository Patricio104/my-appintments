<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Speciality;

class SpecialityController extends Controller
{
    public function doctors(Speciality $Speciality){
    	return $Speciality->users()->get([
    		'users.id', 'users.name'
    	]);
    }
}
