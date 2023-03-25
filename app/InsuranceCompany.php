<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceCompany extends Model
{
    use SoftDeletes;
    protected $table = "insurance_companies";

    protected $fillable = ['name','deduct_rate','price_value'];

   

    public function orderRequest()
    {
        return $this->belongsToMany(OrderRequest::class,'insurance_order_request')
                    ->withPivot('id')
                    ->withPivot('insurance_company_id')
                    ->withPivot('order_request_id')
                    ->withPivot('deduct_value')
                    ->withPivot('deduct_rate')
                    ->withTimeStamps();
    }


    public function payments()
    {
        return $this->hasMany(InsurancePayment::class);
    }

    public function invoices()
    {
        return $this->hasMany(InsuranceInvoice::class);
    }




    
}
