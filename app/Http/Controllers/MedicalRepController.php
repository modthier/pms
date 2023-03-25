<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MedicalRep;
use App\Company;

class MedicalRepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reps = MedicalRep::orderBy('id','asc')->paginate(20);

        return view('reps.index',['metaTitle' => 'All Medical Representative'])->with('reps',$reps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::all();
        return view('reps.create',['metaTitle' => 'Add Medical Representative'])->with('companies',$company);
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
            'name' => 'required',
            'phone' => 'required|digits:10|AlphaNum'
        ]);


        $med = new MedicalRep();
        $med->name = $request->name;
        $med->phone = $request->phone;
        $med->company()->associate($request->company_id);

        if ($med->save()) {
            $request->session()->flash('success','Medical Representative has been Saved');
            return redirect()->route('MedicalRep.create');
        }else {
            return redirect()->route('MedicalRep.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
