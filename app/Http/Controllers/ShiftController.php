<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;
use Auth;
use App\User;
use DB;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::all();

        return view('shift.index',['metaTitle' => 'All Shifts'])->with('shifts',$shifts);
    }


    public function getUserShitf($id)
    {
        $user = User::findOrFail($id);
        $shifts = DB::table('users as u')
                  ->select([
                     's.shift', 'su.created_at','su.loggedout_at'
                  ])
                  ->leftJoin('shift_user as su','u.id','=','su.user_id')
                  ->leftJoin('shifts as s','s.id','=','su.shift_id')
                  ->where('u.id' ,'=' , $user->id)
                  ->orderBy('su.created_at' , 'desc')
                  ->paginate(10);

        return view ('shift.user')->with(['shifts' => $shifts,'user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shift.create',['metaTitle' => 'Add Shift']);
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
            'shift' => 'required',
            'begin' => 'required',
            'end' => 'required'
        ]);


        $shift = new Shift();

        $shift->shift = $request->shift;
        $shift->begin = $request->begin;
        $shift->end = $request->end;

        if ($shift->save()) {
            $request->session()->flash('success','Shift  has been Saved');
            return redirect()->route('Shifts.index');
        }else {
            return redirect()->route('Shifts.create');
            
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);

        return view ('shift.edit',['metaTitle' => 'Update Shift'])->with('shift',$shift);
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
            'shift' => 'required',
            'begin' => 'required',
            'end' => 'required'
        ]);
        
        $shift = Shift::findOrFail($id);

        $shift->shift = $request->shift;
        $shift->begin = $request->begin;
        $shift->end = $request->end;

        if ($shift->save()) {
            $request->session()->flash('success','Shift has been Updated');
            return redirect()->route('Shifts.index');
        }else {
            return redirect()->route('Shifts.edit',$shift->id);
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
