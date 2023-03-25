<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

	protected $table = "shifts";
    
    public function users()
    {
    	return belongsToMany(User::class)
    	->withPivot('loggedout_at')
    	->withTimeStamps()->orderBy('created_at','desc');
    }


    public function ShiftUser()
    {
    	return $this->hasMany(User::class);
    }
}
