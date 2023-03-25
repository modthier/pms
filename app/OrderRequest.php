<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    protected $table = "order_request";

    

    protected $fillable = [
        'total_price' , 'total_items' ,'discount'
    ];

    protected $appends = ['claim'];


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class,'paymentMethod_id','id');
    }


    public function stock()
    {
    	return $this->belongsToMany(Stock::class,'drug_orders')
    				->withPivot('quantity')
                    ->withPivot('id')
                    ->withPivot('price')
                    ->withPivot('discount')
                    ->withPivot('purchasing_price')
    				->withTimeStamps();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }



    public function insurance()
    {
        return $this->belongsToMany(InsuranceCompany::class,'insurance_order_request')
            ->withPivot('id')
            ->withPivot('insurance_company_id')
            ->withPivot('order_request_id')
            ->withPivot('deduct_value')
            ->withPivot('deduct_rate')
            ->withTimeStamps();
    }


    public function getClaimAttribute()
    {
       return  $this->total_price - $this->insurance->first()->pivot->deduct_value;
    }
}
