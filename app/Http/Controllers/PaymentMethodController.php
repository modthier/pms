<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Http\Request;


class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = PaymentMethod::orderBy('id','desc')->paginate();

        return view('paymentsMethod.index')->with('payments',$payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paymentsMethod.create');
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
            'method' => 'required'
        ]);


        

        $payment = new PaymentMethod();
        $payment->method = $request->method;
        
        
        if ($payment->save()) {
            $request->session()->flash('success','Payment method has been Saved');
            return redirect()->route('paymentMethod.index');
        }else {
            return redirect()->route('paymentMethod.create');
        }
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {

        return view('paymentsMethod.edit')->with('payment',$paymentMethod);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $this->validate($request,[
            'method' => 'required'
        ]);
        
        $paymentMethod->method = $request->method;
        
        
        if ($paymentMethod->update()) {
            $request->session()->flash('success','Payment method has been Updated');
            return redirect()->route('paymentMethod.index');
        }else {
            return redirect()->route('paymentMethod.edit',$paymentMethod->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
