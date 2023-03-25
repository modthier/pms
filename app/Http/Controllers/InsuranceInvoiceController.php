<?php

namespace App\Http\Controllers;

use App\InsuranceInvoice;
use App\InsuranceCompany;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class InsuranceInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $summary = DB::table('insurance_invoices as inv')
                   ->select ('inc.name' ,DB::raw('sum(inv.amount_due) as amount_due') ,
                    DB::raw('sum(inv.amount_paid) as amount_paid') )
                   ->leftJoin('insurance_companies as inc','inc.id','inv.insurance_company_id')
                   ->groupBy(DB::raw('inv.insurance_company_id'))
                   ->whereBetween('inv.created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
                   ->get();
        

                   
        return view('invoices.index',['metaTitle' => 'Insurance Invoices'])
            ->with([
                'invoices' => InsuranceInvoice::orderBy('id','desc')->paginate(20),
                'companies' => InsuranceCompany::all(),
                'summary' => $summary,
            ]);
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
            'date_from' => 'required',
            'date_to' => 'required',
            'amount_duo' => 'required',
        ]);

        $invoice = InsuranceInvoice::where('insurance_company_id',$request->insurance_id)
                    ->where('date_from',$request->date_from)
                    ->where('date_to',$request->date_to)
                    ->get()->count();

        if($invoice > 0) {
            return back()->withErrors('Invoice Allready created before');
        }

        $data = [
            'insurance_company_id' => $request->insurance_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'amount_due' => $request->amount_duo,
        ];

        if (InsuranceInvoice::create($data)) {
            $request->session()->flash('success','Insurance invoice created successfully');
            return redirect()->route('InsuranceInvoice.index');
        }else{
            return back()->withErrors();
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InsuranceInvoice  $insuranceInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $insuranceInvoice = InsuranceInvoice::findOrFail($id);
        return view('invoices.edit')->with([
            'insuranceInvoice' => $insuranceInvoice,
            'companies' => InsuranceCompany::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsuranceInvoice  $insuranceInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsuranceInvoice $insuranceInvoice)
    {
        $this->validate($request,[
            'insurance_id' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'amount_duo' => 'required',
        ]);


        $data = [
            'insurance_company_id' => $request->insurance_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'amount_due' => $request->amount_duo,
        ];

        if ($insuranceInvoice->update($data)) {
            $request->session()->flash('success','Insurance invoice updated successfully');
            return redirect()->route('InsuranceInvoice.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InsuranceInvoice  $insuranceInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsuranceInvoice $insuranceInvoice)
    {
        $insuranceInvoice->delete();
        $request->session()->flash('success','Insurance invoice deleted successfully');
        return redirect()->route('InsuranceInvoice.index');
    }


    public function search(Request $request)
    {
        $search = InsuranceInvoice::where('insurance_company_id',$request->insurance_company_id)
                   ->where('date_from',$request->date_from)
                   ->where('date_to',$request->date_to)
                   ->get();
        return view('invoices.search')->with([
            'search' => $search,
            'companies' => InsuranceCompany::all(),
        ]);
    }


    public function balanceInvoice(Request $request,$id){
        $this->validate($request,[
            'amount_paid' => 'required'
        ]);

        $insuranceInvoice =  InsuranceInvoice::findOrFail($id);
        $data = [
            'amount_paid' => $request->amount_paid
        ];

        if ($insuranceInvoice->update($data)) {
            $request->session()->flash('success','Insurance invoice Balanced successfully');
            return redirect()->route('InsuranceInvoice.index');
        }
    }


    
    public function editBalance($id)
    {
        $insuranceInvoice =  InsuranceInvoice::findOrFail($id);
        return view('invoices.editBalance')->with([
            'invoice' => $insuranceInvoice
        ]);
    }
    
}
