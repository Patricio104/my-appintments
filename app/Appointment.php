<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
    	'description',
    	'speciality_id',
    	'doctor_id',
    	'patient_id',
    	'scheduled_date',
    	'scheduled_time',
    	'type'
    ];

    // N $appointment->5speciality 1
    public function speciality()
    {
    	return $this->belongsTo(speciality::class);
    }

    // N $appointment -> doctor 1
    public function doctor(){
    	return $this->belongsTo(User::class);
    }

    // N $appointment -> ptient 1
    public function patient(){
		return $this->belongsTo(User::class);
    }

    // Appointment hasOne 1-1/0 belongTo CancelledAppointment
    //$appointment->cancelation->justification
    public function cancellation(){
        return $this->hasOne(CancelledAppointment::class);
    }

    //Accesor
    //$appointment -> scheduled_time_12
    public function getScheduledTime12Attribute(){
    	return (new Carbon($this->scheduled_time))->format('g:i A');
    }

}
