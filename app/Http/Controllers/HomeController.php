<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Stock;
use App\DrugOrder;
use App\Drug;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::today();
        $month = 3;
        $drugCount = Drug::count();
        $staffCount = User::where('active',1)->count();
        $stockCount = Stock::where('quantity_per_unit','>',0)->count();
        $soldCount = DrugOrder::count();
        $homeStocks = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','d.generic_name','s.barcode',
                      's.purchasing_price','s.selling_price','s.quantity_per_unit',
                      's.exp', DB::raw("ROUND (DATEDIFF(s.exp, CURRENT_DATE()) / 30.4167 , 1)  AS rem ")
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('quantity_per_unit' ,'>' , 0)
                  ->where(DB::raw(DB::raw("ROUND (DATEDIFF(s.exp, CURRENT_DATE()) / 30.4167 , 1)")) , '<=' , $month)
                  ->orderBy('rem' , 'desc')
                  ->paginate(20);

        $week = 7;
        // $homePayment =
                  //  DB::table('payments')
                  // ->where('status' , 0)
                  // ->where(DB::raw(DB::raw("DATEDIFF(due_date, CURRENT_DATE())")) , '<=' , $week)
                  // ->where('due_date','>=',$today)
                  // ->orderBy('due_date','desc')
                  // ->paginate(20);
        $homePayment = DB::table('payments')
                  ->where('status' , 0)
                  ->where(DB::raw(DB::raw("DATEDIFF(due_date, CURRENT_DATE())")) , '<=' , $week)
                  ->where('due_date','>=',$today)
                  ->orderBy('due_date','desc')
                  ->paginate(20);
       
        
        return view('home')
        ->with([
            'drugCount'=> $drugCount,
            'staffCount' => $staffCount,
            'stockCount' => $stockCount,
            'soldCount' => $soldCount,
            'homeStocks' => $homeStocks,
            'homePayment' => $homePayment
        ]);
    }
}
