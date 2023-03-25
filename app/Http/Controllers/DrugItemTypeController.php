<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrugItemType;

class DrugItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugItem = DrugItemType::orderBy('id','asc')->paginate(20);

        return view('drugItems.index',['metaTitle' => 'All Drug Types'])->with('types',$drugItem);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drugItems.create',['metaTitle' => 'Add Drug Type']);
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

        $drugItem = new DrugItemType();

        $drugItem->type = $name;
        
        
        if ($drugItem->save()) {
            $request->session()->flash('success','Drug Type has been Saved');
            return redirect()->route('drugTypes.create');
        }else {
            return redirect()->route('drugTypes.create');
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
        $drugItem = DrugItemType::findOrFail($id);

        return view('drugItems.edit')->with('drugItem',$drugItem);
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
        $drugItem = DrugItemType::findOrFail($id);

        $drugItem->type = $request->type;

        if ($drugItem->save()) {
            $request->session()->flash('success','Drug Type has been Updated');
            return redirect()->route('drugTypes.index');
        }else {
            return redirect()->route('drugTypes.edit',$drugItem->id);
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
