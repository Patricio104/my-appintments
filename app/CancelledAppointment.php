<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{//belongsTo Cancellation N - 1 User hasMany
    public function cancelled_by(){// canccell_by_id
    	return $this->belongsTo(User::class);
    }
}
