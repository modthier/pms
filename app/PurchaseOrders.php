<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PurchaseOrders extends Model
{
    

    protected $fillable = [
        'total_price' , 'quantity'
    ];
	
    protected $table = "purchase_order";


    public function stock()
    {
    	return $this->belongsTo(Stock::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
