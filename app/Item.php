<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];
    
    public function expenses()
    {
       return $this->hasMany(Expense::class);
    }
}
