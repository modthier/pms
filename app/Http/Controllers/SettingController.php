<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::all();

        return view('setting.index')->with('setting',$setting);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('setting.create',['metaTitle' => 'Set Pharmacy Name']);
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
            'tel' => 'required',
            'address' => 'required'
        ]);

        $setting = new Setting;

        $setting->pharmacy_name = $request->name;
        $setting->address = $request->address;
        $setting->tel = $request->tel;
     


        if ($setting->save()) {
            $request->session()->flash('success','Pharmacy Name successfully Saved');
            return redirect()->route('setting.index');
        }else {
            return redirect()->route('setting.create');
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
        $setting = Setting::findOrFail($id);
        return view('setting.edit',['metaTitle' => 'Update Pharmacy Name'])->with('setting',$setting);
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
            'name' => 'required',
            'tel' => 'required',
            'address' => 'required'
        ]);

        $setting = Setting::findOrFail($id);

        $setting->pharmacy_name  = $request->name;
        $setting->address = $request->address;
        $setting->tel = $request->tel;
              

        if ($setting->save()) {
            $request->session()->flash('success','Pharmacy Name successfully Updated');
            return redirect()->route('setting.index');
        }else {
            return redirect()->route('setting.edit',$setting->id);
        }


    }

    
   
}
