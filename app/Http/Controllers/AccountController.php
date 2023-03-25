<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::orderBy('created_at','desc')->paginate(20);

        return view('account.index',['metaTitle' => "All Bank Accounts"])->with('accounts',$accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.create',['metaTitle' => "Add Bank Account"]);
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

        $account = new Account;

        $account->name = $request->name;

        if ($account->save()) {
            $request->session()->flash('success','Account has been Saved');
            return redirect()->route('accounts.index');
        }else {
            return redirect()->route('accounts.create');
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
        $account = Account::findOrFail($id);

        return view('account.edit',['metaTitle' => "Update Bank Accounts"])->with('account',$account);
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

        $account =  Account::findOrFail($id);

        $account->name = $request->name;

        if ($account->save()) {
            $request->session()->flash('success','Account has been Saved');
            return redirect()->route('accounts.index');
        }else {
            return redirect()->route('accounts.edit',$account->id);
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
