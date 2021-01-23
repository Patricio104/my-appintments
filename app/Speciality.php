<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Speciality extends Model
{
    public function users(){
    	return $this->belongsToMany(User::class)->withTimestamps();
    }
}
