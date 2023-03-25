<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrugUnit;

class DrugUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit = DrugUnit::orderBy('id','asc')->paginate(20);

        return view('units.index',['metaTitle' => 'All Drug Units'])->with('units',$unit);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('units.create',['metaTitle' => 'Add Drug Unit']);
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
            'name' => 'required'
        ]);


        $name = $request->name;

        $unit = new DrugUnit();
        $unit->name = $name;
        
        
        if ($unit->save()) {
            $request->session()->flash('success','Unit has been Saved');
            return redirect()->route('drugUnits.create');
        }else {
            return redirect()->route('drugUnits.create');
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
        $drugUnit = DrugUnit::findOrFail($id);

        return view('units.edit',['metaTitle' => 'Update Drug Units'])->with('drugUnit',$drugUnit);
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
            'name' => 'required'
        ]);

        $drugUnit = DrugUnit::findOrFail($id);

        $drugUnit->name = $request->name;

        if ($drugUnit->save()) {
            $request->session()->flash('success','Drug Unit has been Updated');
            return redirect()->route('drugUnits.index');
        }else {
            return redirect()->route('drugUnits.edit',$drugUnit->id);
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
        //
    }
}
