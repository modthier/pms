<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedItems extends Model
{
    protected $table = "returned_items";

    public function stock()
    {
    	return $this->belongsTo(Stock::class);
    }


    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
