<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceInvoice extends Model
{
    
    protected $guarded = [];

    public function insurance()
    {
        return $this->belongsTo(InsuranceCompany::class,'insurance_company_id','id');
    }
}
