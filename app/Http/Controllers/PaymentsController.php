<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Account;
use DB;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::orderBy('created_at','desc')->paginate(20);

        return view('payment.index',['metaTitle' => "All Payments"])->with('payments',$payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::all();
        return view('payment.create',['metaTitle' => "Add Payment"])->with('accounts',$accounts);
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
            'account_id' => 'required|exists:accounts,id',
            'beneficiary' => 'required',
            'check_number' => 'required|unique:App\Payment',
            'amount' => 'required',
            'due_date' => 'required'
        ]);

        $payment = new Payment;

        $payment->account_id = $request->account_id;
        $payment->beneficiary  = $request->beneficiary;
        $payment->check_number = $request->check_number;
        $payment->amount = $request->amount;
        $payment->due_date = $request->due_date;
        $payment->status = $request->status;



        if ($payment->save()) {
            $request->session()->flash('success','Payment has been Saved');
            return redirect()->route('payments.index');
        }else {
            return redirect()->route('payments.create');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $accounts = Account::all();
        return view('payment.edit')->with(['payment' => $payment , 'accounts' => $accounts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request,[
            'account_id' => 'required|exists:accounts,id',
            'beneficiary' => 'required',
            'check_number' => 'required',
            'amount' => 'required',
            'due_date' => 'required'
        ]);

        $payment =  Payment::findOrFail($id);

        $payment->account_id = $request->account_id;
        $payment->beneficiary  = $request->beneficiary;
        $payment->check_number = $request->check_number;
        $payment->amount = $request->amount;
        $payment->due_date = $request->due_date;



        if ($payment->save()) {
            $request->session()->flash('success','Payment has been Saved');
            return redirect()->route('payments.index');
        }else {
            return redirect()->route('payments.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $payment = Payment::findOrFail($id);

       $payment->delete();

       return redirect()->route('payments.index');
    }


    public function pay($id)
    {
        $payment = Payment::findOrFail($id);

        $status = 1;
        $payment->update([
            'status' => $status
        ]);

        return redirect()->route('payments.index');
    }


    public function cancel($id)
    {
        $payment = Payment::findOrFail($id);

        $status = 2;
        $payment->update([
            'status' => $status
        ]);

        return redirect()->route('payments.index');
    }


    public function search(Request $request)
    {
        if (
            $request->has('date_from') or 
            $request->has('date_to') or 
            $request->has('status')
           ) 
        {
            $results = Payment::with(['account'])
                      ->whereBetween('due_date',[$request->date_from,$request->date_to])
                      ->Where('status',$request->status)
                      ->paginate(20);

                  
                  
        }else {
            $result = 0;
        }

        return view('payment.search')->with('results',$results);
    }
}
