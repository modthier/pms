<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Item;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
        $today = Carbon::today();

        $expenses = Expense::orderBy('id','desc')->paginate(20);
        $total_today = Expense::whereDate('created_at',$today)->sum('value');
        $total_week =  Expense::whereBetween('created_at',[Carbon::now()->startOfWeek(),
                       Carbon::now()->endOfWeek()])->sum('value');
        $total_month = Expense::whereBetween('created_at',[Carbon::now()->startOfMonth(),
                       Carbon::now()->endOfMonth()])->sum('value');
        return view('expense.index',['metaTitle' => 'Expenses'])->with([
            'expenses' => $expenses ,
            'total_today' => $total_today ,
            'total_week' => $total_week,
            'total_month' => $total_month
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expense.create')->with('items',Item::all());
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
            'item_id' => 'required',
            'value' => 'required'
        ]);

        $errors = [];
        $item = Item::findOrFail($request->item_id);
        $user = User::findOrFail(Auth::id());

        
        
        if ($item->permission == 'Admin') {
           if ($user->role->name == 'User') {
            return back()->withErrors("You don't have Permission to add Expense of ".$item->item);
           }
        }


        $expense = new Expense;

        $expense->item()->associate($request->item_id);
        $expense->value = $request->value;
        $expense->comment = $request->comment;

        if($expense->save()) {
            $request->session()->flash('success','Expense  has been Saved');
            return redirect()->route('expense.index');
        }else {
            $request->session()->flash('error','Something Wrong Happend');
            return redirect()->route('expense.index');
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return view('expense.show')->with('expense',$expense);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        return view('expense.edit')
        ->with([
            'expense' => $expense ,
            'items' => Item::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $this->validate($request,[
            'item_id' => 'required',
            'value' => 'required'
        ]);

        $errors = [];
        $item = Item::findOrFail($request->item_id);
        $user = User::findOrFail(Auth::id());

        
        
        if ($item->permission == 'Admin') {
           if ($user->role->name == 'User') {
            return back()->withErrors("You don't have Permission to update Expense of ".$item->item);
           }
        }

        $data = [
            'item_id' => $request->item_id,
            'value' => $request->value ,
            'comment' => $request->comment
        ];

        if($expense->update($data)) {
            $request->session()->flash('success','Expense  has been Updated');
            return redirect()->route('expense.index');
            
        }else {
            $request->session()->flash('error','Something Wrong Happend');
            return redirect()->route('expense.edit',$expense->id);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expense.index');
    }
}
