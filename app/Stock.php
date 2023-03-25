<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use DB;

class Stock extends Model
{

    
    
    protected $table = "stock";

    protected $guarded = [];

    public function orderRequest()
    {
    	return $this->belongsToMany(OrderRequest::class,'drug_orders')
                    ->withPivot('quantity')
                    ->withPivot('id')
                    ->withPivot('price')
                    ->withPivot('discount')
                    ->withPivot('purchasing_price')
                    ->withTimeStamps();
    }


    public function purchaseOrder()
    {
    	return $this->hasOne(PurchaseOrders::class);
    }


    public function drug()
    {
    	return $this->belongsTo(Drug::class,'drug_id','id');
    }


    public function returnedItems()
    {
        return $this->hasMany(ReturnedItems::class);
    }


    public function expiredStock()
    {
        return $this->hasOne(ExpiredStock::class);
    }

    public function checkAvilable($id,$quantity)
    {
    	$stock = $this->where('id',$id)->first();

        $errors = [];

    	if($stock->quantity_per_unit < $quantity)
        {
            $errors['more'] = 1;
            $errors['message'] = "Sold quantity is more than avilable quantity for ".$stock->drug->trade_name;
        }else {
            $errors['more'] = 0;
            $errors['message'] = "";
        }

        return $errors;
        
    }
}
