<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{

    
    
    protected $table = "drugs";
    

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }


    public function drugUnit()
    {
    	return $this->belongsTo(DrugUnit::class,'unit_id','id');
    }


    public function drugItemType()
    {
    	return $this->belongsTo(DrugItemType::class,'item_type_id','id');
    }

   
}
