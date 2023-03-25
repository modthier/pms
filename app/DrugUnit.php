<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugUnit extends Model
{
    protected $table = "drug_units";

    protected $fillable = [
      'name' 
    ];

    public function drugs()
    {
    	return $this->hasMany(Drug::class);
    }
}
