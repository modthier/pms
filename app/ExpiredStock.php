<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpiredStock extends Model
{
    protected $table = "expired_stocks";

    protected $fillable = ['stock_id','expired_quantity','purchasing_price'];


     public function stock()
    {
    	return $this->belongsTo(Stock::class);
    }
}
