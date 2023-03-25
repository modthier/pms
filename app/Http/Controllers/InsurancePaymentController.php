<?php

namespace App\Http\Controllers;

use App\InsurancePayment;
use App\InsuranceCompany;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class InsurancePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $summary = DB::table('insurance_payments as ips')
                 ->select(
                    [ 
                       'ic.id' , 'ic.name' , DB::raw('sum(value) as total_payments')
                    ])

                 ->leftJoin('insurance_companies as ic','ic.id','ips.insurance_company_id')
                 ->whereBetween('ips.created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
                 ->groupBy('ips.insurance_company_id')
                 ->get();
        
        
        $totalClaim = new InsurancePayment;
        return view('insurance_payment.index',['metaTitle' => 'Insurance Payments'])->with([
            'payments' => InsurancePayment::orderBy('id','desc')->paginate(20) ,
            'summary' => $summary,
            'totalClaim' => $totalClaim,
            'companies' => InsuranceCompany::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        return view('insurance_payment.create')->with(['companies' => InsuranceCompany::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'insurance_id' => 'required',
            'value' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        
        $data = [
            'insurance_company_id' => $request->insurance_id,
            'value' => $request->value,
            'month' => $request->month,
            'year' => $request->year
        ];

        if(InsurancePayment::create($data)) {
            $request->session()->flash('success','Payment  has been Saved');
            return redirect()->route('InsurancePayment.index');
        }else {
            $request->session()->flash('error','Something Wrong Happend');
            return redirect()->route('InsurancePayment.create')->withInputs();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InsurancePayment  $insurancePayment
     * @return \Illuminate\Http\Response
     */
    public function show(InsurancePayment $insurancePayment)
    {
        return view('insurance_payment.show')->with([
            'payment' => $insurancePayment
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InsurancePayment  $insurancePayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = InsurancePayment::findOrFail($id);
        return view('insurance_payment.edit')->with([
            'payment' => $payment,
            'companies' => InsuranceCompany::all() ,
            'year' => date('Y')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsurancePayment  $insurancePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'insurance_id' => 'required',
            'value' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        $insurancePayment = InsurancePayment::findOrFail($id);

        $data = [
            'insurance_company_id' => $request->insurance_id,
            'value' => $request->value,
            'month' => $request->month,
            'year' => $request->year
        ];

        if($insurancePayment->update($data)) {
            $request->session()->flash('success','Payment  has been Updated');
            return redirect()->route('InsurancePayment.index');
        }else {
            $request->session()->flash('error','Something Wrong Happend');
            return redirect()->route('InsurancePayment.edit',$insurancePayment->id)->withInputs();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InsurancePayment  $insurancePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsurancePayment $insurancePayment)
    {
        if($insurancePayment->delete()){
            $request->session()->flash('success','Payment  has been deleted');
            return redirect()->route('InsurancePayment.index');
        }
        
    }


    public function search(Request $request)
    {
        
        $summary = DB::table('insurance_payments as ips')
                 ->select(
                    [ 
                       'ic.id' , 'ic.name' , DB::raw('sum(value) as total_payments')
                    ])

                 ->leftJoin('insurance_companies as ic','ic.id','ips.insurance_company_id')
                 ->whereBetween('ips.created_at',[$request->date_from,$request->date_to])
                 ->groupBy('ips.insurance_company_id')
                 ->get();
        
        $payments = InsurancePayment::whereBetween('created_at',[$request->date_from,$request->date_to])
                    ->orderBy('id','desc')->paginate(20);
        
        $totalClaim = new InsurancePayment;
        return view('insurance_payment.search',['metaTitle' => 'Payments Report'])->with([
            'payments' => $payments,
            'summary' => $summary,
            'totalClaim' => $totalClaim,
            'companies' => InsuranceCompany::all()
        ]);   
    }
}
