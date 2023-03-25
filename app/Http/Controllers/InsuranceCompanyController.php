<?php

namespace App\Http\Controllers;

use App\InsuranceCompany;
use Illuminate\Http\Request;


class InsuranceCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = InsuranceCompany::orderBy('id','desc')->paginate(20);
        return view('insurance.index')->with('companies',$companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('insurance.create');
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
            'name' => 'required|unique:App\InsuranceCompany',
            'deduct_rate' => 'required',
            'price_value' => 'required'
        ]);

        $company = new InsuranceCompany;

        $company->name = $request->name;
        $company->deduct_rate = $request->deduct_rate;
        $company->price_value = $request->price_value;

        if($company->save()) {
            $request->session()->flash('success','Insurance Company saved succesfully');
            return redirect()->route('insuranceCompany.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InsuranceCompany  $insuranceCompany
     * @return \Illuminate\Http\Response
     */
    public function show(InsuranceCompany $insuranceCompany)
    {
        $insuranceCompany = $insuranceCompany->get();
        return view('insurance.show',compact('insuranceCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InsuranceCompany  $insuranceCompany
     * @return \Illuminate\Http\Response
     */
    public function edit(InsuranceCompany $insuranceCompany)
    {
        return view('insurance.edit',compact('insuranceCompany'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsuranceCompany  $insuranceCompany
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsuranceCompany $insuranceCompany)
    {
         $this->validate($request,[
            'name' => 'required',
            'deduct_rate' => 'required',
            'price_value' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'deduct_rate' => $request->deduct_rate ,
            'price_value' => $request->price_value
        ];
        
        if($insuranceCompany->update($data)) {
            $request->session()->flash('success','Insurance Company updated succesfully');
            return redirect()->route('insuranceCompany.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InsuranceCompany  $insuranceCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsuranceCompany $insuranceCompany)
    {
        $insuranceCompany->delete();
        return redirect()->route('insuranceCompany.index');

    }
}
