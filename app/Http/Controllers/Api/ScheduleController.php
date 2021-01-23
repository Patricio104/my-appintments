<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ScheduleServiceInterface;
use App\WorkDay;
use Carbon\Carbon;

class ScheduleController extends Controller
{
     public function hours(Request $request, ScheduleServiceInterface $scheduleService){
    	//dd($request->all());
        
    	$rules = [
    		'date' => 'required|date_format:"Y-m-d"',
    		'doctor_id' => 'required|exists:users,id'
    	];

    	$this->validate($request, $rules);

    	$date = $request->input('date');    	
    	$doctorId = $request->input('doctor_id');

        return $scheduleService->getAvailableIntervals($date, $doctorId);

    }

    
}
