<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugItemType extends Model
{
    protected $table = "drug_item_types";

    protected $fillable = [
      'type' 
    ];

    public function drugs()
    {
    	return $this->hasMany(Drug::class,'drug_item_type_id','id');
    }
}
