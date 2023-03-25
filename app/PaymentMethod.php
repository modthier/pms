<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{

	protected $table = "payment_methods";
    
    public function orderRequest()
    {
    	return $this->hasMany(OrderRequest::class);
    }
}
