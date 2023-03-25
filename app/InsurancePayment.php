<?php

namespace App;
use DB;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class InsurancePayment extends Model
{
    protected $guarded = [];
    
    public function Insurancecompany()
    {
        return $this->belongsTo(InsuranceCompany::class,'insurance_company_id','id');
    }


    public function totalClaim($id)
    {
        $total = DB::table('insurance_order_request as orp')
        ->select([
           DB::raw('sum(orp.deduct_value) as deduct_total') , 
           DB::raw('sum(or.total_price) as actual_total') , DB::raw('sum(orp.added_value) as added_value')
        ])
        ->leftJoin('order_request as or','orp.order_request_id','or.id')
        ->leftJoin('insurance_companies as ic','orp.insurance_company_id','ic.id')
        ->whereBetween('orp.created_at',[Carbon::now()->startOfYear(),
          Carbon::now()->endOfYear()])
        ->where('orp.insurance_company_id',$id)
        ->get()->first();

        return $total;
    }
}
