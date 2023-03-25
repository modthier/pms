<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalRep extends Model
{

	protected $fillable = [
        'name' , 'phone' , 'company_id' 
    ];

    public function company()
    {
    	return $this->belongsTo(Company::class);
    }

    public function Drugs()
    {
    	return $this->hasMany(Drug::class);
    }


}
