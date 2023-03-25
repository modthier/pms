<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrders;
use App\OrderRequest;
use App\Stock;
use App\Expense;
use DB;
use Carbon\Carbon;

class SummaryController extends Controller
{
    
    public function index()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $today = Carbon::today();
        $total = DB::table('drug_orders')
                ->selectRaw('sum(purchasing_price * quantity) as totalPurchases , sum(price) as totalSales')
                ->first();

         // discount totals
        $total_discount = OrderRequest::sum('discount');

        $discount_today = OrderRequest::whereDate('created_at',$today)
                          ->sum('discount');
        $discount_week = OrderRequest::whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                          ->sum('discount');
        $discount_month = OrderRequest::whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                         ->sum('discount');
        
        // discount end total


        // expense totals
        $expense_total = Expense::sum('value');
        $expense_today = Expense::whereDate('created_at',$today)
                          ->sum('value');
        $expense_week = Expense::whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                          ->sum('value');
        $expense_month = Expense::whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                         ->sum('value');

        // expense end total

        //expired stock
        $expired_total_all = DB::table('expired_stocks as es')
				->select(DB::raw('sum(es.expired_quantity * es.purchasing_price) as total_price'))
				->get()->first()->total_price;

        $expired_total_today = DB::table('expired_stocks as es')
				->select(DB::raw('sum(es.expired_quantity * es.purchasing_price) as total_price'))
                ->whereDate('es.created_at',$today)
				->get()->first()->total_price;

        
        $expired_total_week = DB::table('expired_stocks as es')
				->select(DB::raw('sum(es.expired_quantity * es.purchasing_price) as total_price'))
                ->whereBetween('es.created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
				->get()->first()->total_price;

        
        $expired_total_month = DB::table('expired_stocks as es')
				->select(DB::raw('sum(es.expired_quantity * es.purchasing_price) as total_price'))
                ->whereBetween('es.created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
				->get()->first()->total_price;
        //
        
        $total_today = DB::table('drug_orders')
                    ->selectRaw('sum(purchasing_price * quantity) as totalPurchases , sum(price) as totalSales')
                    ->whereDate('created_at',$today)
                    ->first();
                    

        $total_week = DB::table('drug_orders')
                    ->selectRaw('sum(purchasing_price * quantity) as totalPurchases , sum(price) as totalSales')
                    ->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
                    ->first();
          
        $total_month = DB::table('drug_orders')
                    ->selectRaw('sum(purchasing_price * quantity) as totalPurchases , sum(price) as totalSales')
                    ->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                    ->first();

        $stock_bonus = Stock::sum('bonus');

        
          

        return view('summary.index',['metaTitle' => "Summary Report"])
          ->with([
          'total' => $total ,
              'total_today' => $total_today,
              'total_week' => $total_week ,
              'total_month' => $total_month,
              'expense_total' => $expense_total,
              'expense_today' => $expense_today,
              'expense_week' => $expense_week,
              'expense_month' => $expense_month,
              'expired_total_all' => $expired_total_all,
              'expired_total_today' => $expired_total_today ,
              'expired_total_week' => $expired_total_week,
              'expired_total_month' => $expired_total_month,
              'total_discount' => $total_discount,
              'discount_today' => $discount_today,
              'discount_week' => $discount_week,
              'discount_month' => $discount_month,
              'stock_bonus' => $stock_bonus,
              ]
          );
    }



    public function summaryByDates(Request $request)
    {
        if ($request->has('date_from') and $request->has('date_to')) {
            

        $total = DB::table('drug_orders')
    	            ->selectRaw('sum(purchasing_price * quantity) as totalPurchases , sum(price) as totalSales')
                  ->whereRaw('Date(created_at) between ? and ?',[$request->date_from,$request->date_to])
                  ->first();
        $expense_total = Expense::whereRaw('Date(created_at) between ? and ?',[$request->date_from,$request->date_to])
                          ->sum('value');

        $expired_total = DB::table('expired_stocks as es')
				->select(DB::raw('sum(es.expired_quantity * es.purchasing_price) as total_price'))
                ->whereRaw('Date(es.created_at) between ? and ?',[$request->date_from,$request->date_to])
				->get()->first()->total_price;


        $discount_total = OrderRequest::whereRaw('Date(created_at) between ? and ?',[$request->date_from,$request->date_to])
                          ->sum('discount');
        

        $stock_bonus = Stock::whereRaw('Date(created_at) between ? and ?',[$request->date_from,$request->date_to])
        ->sum('bonus');

            
        }else {
            $total = 0;
            $expense_total = 0;
            $expired_total = 0;
            
        }
       
         return view ('summary.dateSearch',['metaTitle' => 'Summary By Dates'])
           ->with([
            'total' => $total ,
            'expense_total' => $expense_total,
            'expired_total' => $expired_total,
            'discount_total' => $discount_total,
            'stock_bonus' => $stock_bonus
        ]);
    }

}
