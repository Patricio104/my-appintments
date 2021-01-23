<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Speciality;
use App\Appointment;
use Carbon\Carbon;
use App\Interfaces\ScheduleServiceInterface;
use Validator;
use App\CancelledAppointment;

class AppointmentController extends Controller
{
	public function index() {

		$role = auth()->user()->role;
		//Admin -> all
		// doctor
		if($role == 'admin'){
			$pendingAppointments = Appointment::where('status', 'Reservada')
				->paginate(10);
			$confirmedAppointments = Appointment::where('status', 'Confirmada')
				->paginate(10);
			$oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
				->paginate(10);	
		}elseif($role == 'doctor'){
			$pendingAppointments = Appointment::where('status', 'Reservada')
				->where('doctor_id', auth()->id())
				->paginate(10);
			$confirmedAppointments = Appointment::where('status', 'Confirmada')
				->where('doctor_id', auth()->id())
				->paginate(10);
			$oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
				->where('doctor_id', auth()->id())
				->paginate(10);	

		}elseif($role == 'patient'){
			//Patient
			$pendingAppointments = Appointment::where('status', 'Reservada')
				->where('patient_id', auth()->id())
				->paginate(10);
			$confirmedAppointments = Appointment::where('status', 'Confirmada')
				->where('patient_id', auth()->id())
				->paginate(10);
			$oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
				->where('patient_id', auth()->id())
				->paginate(10);	
		}

		return view('appointments.index', 
			compact(
				'pendingAppointments', 'confirmedAppointments', 'oldAppointments',
				'role'
			)
		);
	}

	public function show(Appointment $appointment){
		$role = auth()->user()->role;
		return view('appointments.show', compact('appointment', 'role'));
	}


    public function create(ScheduleServiceInterface $scheduleService){
    	$specialities = Speciality::all();

    	$specialityId= old('speciality_id');
    	if ($specialityId) {
    		$speciality = Speciality::find($specialityId);
    		$doctors = $speciality->users;
    	}else{
    		$doctors = collect();
    	}

    	$scheduledDate = old('scheduled_date');
    	$doctorId = old('docotr_id');
    	if ($scheduledDate && $doctorId) {
    		$intervals = $scheduleService->getAvailableIntervals($date, $doctorId);
    	}else{
    		$intervals = null;
    	}
    	
    	return view('appointments.create', compact('specialities', 'doctors', 'intervals'));
    } 

    public function store(Request $request, ScheduleServiceInterface $scheduleService){
		$rules = [
				'description' => 'required',
				'speciality_id' => 'exists:specialities,id',
				'doctor_id' => 'exists:users,id',
				'scheduled_time' => 'required'
			];

		$messages = [
			'scheduled_time.required' => 'Por favor seleccione una hora válida para su cita'
		];	

		$validator = Validator::make($request->all(), $rules, $messages);	

		$validator->after(function($validator) use ($request, $scheduleService){

			$date=$request->input('scheduled_date');
			$doctorId=$request->input('doctor_id');
			$scheduled_time=$request->input('scheduled_time');

			if ($date && $doctorId && $scheduled_time) {
				$start = new Carbon($scheduled_time);
			}else{
				return;
			}

			if(!$scheduleService->isAvailableInterval($date, $doctorId, $start)){
				$validator->errors()
						->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro paciente');
			}			
		});

		if ($validator->fails()) {
			return back()
					->withErrors($validator)
					->withInput();
		}

    	$data = $request->only([
	    	'description',
	    	'speciality_id',
	    	'doctor_id',
	    	'scheduled_date',
	    	'scheduled_time',
	    	'type']);
	    $data['patient_id'] = auth()->id();

	    $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
	    $data['scheduled_time'] = $carbonTime->format('H:i:s');
	    Appointment::create($data);	
	    $notification = 'La cita se ha registrado corractamente';
	    return back()->with(compact('notification'));
	    //return redirect('/appointments');
    }

    public function showCancelForm(Appointment $appointment){
    	if($appointment->status == 'Confirmada'){
    		$role = auth()->user()->role;
    		return view('appointments.cancel', compact('appointment', 'role'));
    	}
    		
    	return redirect('/appointments');
    }

    public function postCancel(Appointment $appointment, Request $request){

    	if($request->has('justification')){
    		$cancellation = new CancelledAppointment();
    		$cancellation->justification = $request->input('justification');
    		$cancellation->cancelled_by = auth()->id();

    	    $appointment->cancellation()->save($cancellation);
    	}

    	$appointment->status = 'Cancelada';
    	$appointment->save();//update

    	$notification = 'La cita se ha cancelado correctamente';
    	return redirect('/appointments')->with(compact('notification'));
    }

    public function postConfirm(Appointment $appointment){

    	

    	$appointment->status = 'Confirmada';
    	$appointment->save();//update

    	$notification = 'La cita se ha confirmado correctamente';
    	return redirect('/appointments')->with(compact('notification'));
    }
}
