<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderRequestExport;
use App\OrderRequest;
use App\DrugOrder;
use App\Stock;
use App\User;
use App\ReturnedItems;
use Carbon\Carbon;
use App\Setting;
use App\Shift;
use App\PaymentMethod;
use App\SalesReport;
use Exception;
use Exporter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DrugRequestController extends Controller
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

        $user = User::findOrFail(Auth::id());
        $role = $user->role_id;
        $today = Carbon::today();
        if ($role == 1) {
            $orders = OrderRequest::orderBy('id','desc')->paginate(20);
            $total_today = DB::table('order_request')->whereDate('created_at',$today)->sum('total_price');
            //$inc_total_today = DB::table('insurance_order_request')->whereDate('created_at',$today)->sum('deduct_value');
        }else {
            
            $orders = OrderRequest::where('user_id',Auth::id())->orderBy('id','desc')->paginate(20);
            $total_today = DB::table('order_request')
                ->where('user_id',Auth::id())
                ->whereDate('created_at',$today)
                
                ->sum('total_price');

            // $inc_total_today = DB::table('insurance_order_request as inc')
            //                 ->leftJoin('order_request as r','r.id','=','inc.order_request_id')
            //                 ->whereDate('inc.created_at',$today)
            //                 ->where('r.user_id',Auth::id())
            //                 ->sum('deduct_value');
        }


        

        $total = DB::table('order_request')->sum('total_price');
        //$inc_total = DB::table('insurance_order_request')->sum('deduct_value');

        
        $total_week = DB::table('order_request')
        ->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('total_price');

        // $inc_total_week = DB::table('insurance_order_request')
        //               ->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
        //               ->sum('deduct_value');

        $total_month = DB::table('order_request')
                      ->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
                      ->sum('total_price');

        // $inc_total_month = DB::table('insurance_order_request')
        //                   ->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])
        //                   ->sum('deduct_value');
        
        $total_by_payments = DB::table('order_request as o')
                    ->select(DB::raw('p.method , sum(o.total_items) as total_items,sum(o.total_price) as total_price'))
                    ->leftJoin('payment_methods as p','p.id','o.paymentMethod_id')
                    ->groupBy('o.paymentMethod_id')
                    ->whereDate('o.created_at',$today)
                    ->get();

        
        
        return view ('orders.index',['metaTitle' => 'Sales Report'])
           ->with([
            'orders' => $orders ,
             'total' => $total,
             'total_today' => $total_today,
             'total_week' => $total_week,
             'total_month' => $total_month,
             'total_by_payments' => $total_by_payments,
         ]);
    }


    public function getUserSales($id)
    {

        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $user = User::findOrFail($id);
        $orderRequests = $user->OrderRequests()->orderBy('created_at','desc')->paginate(10);

        $today = Carbon::today();
        $total_today = $user->OrderRequests()->whereDate('created_at',$today)->sum('total_price');
        $total_week = $user->OrderRequests()->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('total_price');

        $total_month = $user->OrderRequests()->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('total_price');
        

        return view ('drugOrder.user')->with(
            [
                'orderRequests' => $orderRequests,
                'user' => $user,
                'total_today' => $total_today,
                'total_week' => $total_week,
                'total_month' => $total_month
            ]);
    }


    public function dateSearch(Request $request)
    {
        if ($request->has('date_from') and $request->has('date_to')) {
            $result = 
            OrderRequest::whereRaw('Date(created_at) between ? and ?',[$request->date_from,$request->date_to])->paginate(20);

            $total = OrderRequest::whereRaw('Date(created_at) between ? and ?',[$request->date_from,$request->date_to])->sum('total_price');

        }else {
            $result = [];
            $total = 0;
        }

         return view ('orders.dateSearch',['metaTitle' => 'Sales Report Between Two Dates'])
           ->with(['results' => $result , 'total' => $total , 
            'date_from' => $request->date_from , 'date_to' => $request->date_to ]);
    }


    public function receiptNumber(Request $request)
    {
         if ($request->has('receipt_number')) {

            $result = OrderRequest::where('uniqid','=',$request->receipt_number)->paginate(20);
            $total = OrderRequest::where('uniqid','=',$request->receipt_number)->sum('total_price');
         }else {
            $result = []; 
            $total = 0;
         }

         return view ('orders.receipt',['metaTitle' => 'Search By Receipt Number '])
           ->with(['results' => $result , 'total' => $total]);
    } 


    public function tradeName(Request $request)
    {
         if ($request->has('trade_name')) {
            $result = DB::table('order_request as os')
                ->select([
                    'os.*','u.name','d.trade_name'
                ])
                ->leftJoin('drug_orders as dd','os.id','=','dd.order_request_id')
                ->leftJoin('stock as s','s.id','=','dd.stock_id')
                ->leftJoin('drugs as d','d.id','=','s.drug_id')
                ->leftJoin('users as u','u.id','=','os.user_id')
                ->where('d.trade_name','like','%'.$request->trade_name.'%')
                ->orderBy('os.created_at','desc')
                ->paginate(10);
            
            
         }else {
            $result = []; 
            $total = 0;
         }

         return view ('orders.tradeName',['metaTitle' => 'Search By Trade Name '])
           ->with(['results' => $result]);
    } 



    public function hourlySalesReport(Request $request)
    {
        $result = DB::table('order_request')
                ->whereBetween(DB::raw('time(created_at)')
                    ,[$request->start_time,$request->end_time])
                ->where(DB::raw('date(created_at)'),$request->start_date)
                ->where('user_id',Auth::id())
                ->sum('total_price');
        
        
        
        return view('orders.hourlySalesReport')->with('total',$result);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = OrderRequest::findOrFail($id);
        $setting = Setting::all()->first();
        
        
        return view('orders.show',['metaTitle' => trans('body.salesReportDetails')])->with(['orders' => $orders , 'setting' => $setting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orders = OrderRequest::findOrFail($id);
        $payments = PaymentMethod::all();
        
        return view('orders.edit')
                ->with([
                    'orders' => $orders ,
                    'payments' => $payments
                ]);
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
            'items' => 'required|array'
        ]);


        

        $orders = OrderRequest::findOrFail($id);

        foreach ($orders->stock as $stock) {
           $new_stock = $stock->quantity_per_unit + $stock->pivot->quantity;
           $stock->update([
            'quantity_per_unit' => $new_stock
           ]);
        }

        $orders->stock()->detach();
        $orders->delete();


       $arr = array();
       $discount = 0;

       $stock = new Stock;
       
       $errors = [];
       foreach ($request->items as $id=>$quantity) {
           $check = $stock->checkAvilable($id,$quantity['quantity']);
           if($check['more']) {
              $errors[] = $check['message'];
           }
       }

       if(!empty($errors)){
          
          return back()->with('errs', $errors);
       }
       
       foreach ($request->items as $id=>$quantity) {
        array_push($arr, [$id => ['quantity' => $quantity['quantity'],'price' => $request->input('sub_total_'.$id) ,
        'purchasing_price' => $request->input('purchasing_price_'.$id) , 'discount' => $request->input('discount'.$id)]] );
       
        $discount += $request->input('discount'.$id);
        }

    


        $OrderRequest = new OrderRequest();
      

        DB::beginTransaction();

        try {

            $total_quantity = 0;
            foreach ($request->items as $id=>$quantity) {
              $total_quantity = $total_quantity + $quantity['quantity'];
             }

            $OrderRequest->user()->associate(Auth::id());
            $OrderRequest->total_price = $request->total;
            $OrderRequest->total_items = $total_quantity;
            $OrderRequest->uniqid = uniqid();
            $OrderRequest->discount = $discount;
            $OrderRequest->paymentMethod_id = $request->method_id;
            $OrderRequest->save();

            foreach ($arr as $a) {
               $OrderRequest->stock()->attach($a);
            }
    
            foreach ($request->items as $id=>$quantity) {
               $stock = Stock::findOrFail($id);

               $new_stock = $stock->quantity_per_unit - $quantity['quantity'];
               
               $stock->update([
                'quantity_per_unit' => $new_stock
               ]);
            }

            DB::commit(); 
            return redirect()->route('DrugRequests.show',
                $OrderRequest->id);
                
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('DrugOrders.create');
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
        $orders = OrderRequest::findOrFail($id);

        foreach ($orders->stock as $stock) {
           $new_stock = $stock->quantity_per_unit + $stock->pivot->quantity;
           
           $stock->update([
            'quantity_per_unit' => $new_stock
           ]);
        }

        $orders->stock()->detach();
        $orders->insurance()->detach();
        $orders->delete();

        return redirect()->route('DrugRequests.index');

    }



    public function mostSoldItems()
    {
        $result = DB::table('drug_orders as o')
                     ->selectRaw('o.stock_id , d.trade_name , d.generic_name ,count(d.trade_name) as count')
                     ->join('stock as s','s.id','o.stock_id')
                     ->join('drugs as d','d.id','s.drug_id')
                     ->orderBy('count','desc')
                     ->groupBy('o.stock_id')
                     ->paginate(20);
        return view('orders.mostSold')->with('results',$result);
    }


    public function export() 
    {
        $FileName = "SalesReport.xlsx";
        $query =   DB::table('drug_orders as o')
                     ->select(['d.trade_name' , 'o.price' , 'o.quantity', 'o.created_at'])
                     ->leftJoin('stock as s','s.id','o.stock_id')
                     ->leftJoin('drugs as d','d.id','s.drug_id')
                     ->get();

        
        
        $serialiser = new SalesReport;
        $excel = Exporter::make('Excel');
        $excel->load($query);
        $excel->setSerialiser($serialiser);
        return $excel->stream($FileName);
        //return Excel::download(new OrderRequestExport, 'OrderRequest.xlsx');
    }


    public function dailyTotal($id)
    {
        $user = User::findOrFail($id);
        $result = DB::table('order_request')
                  ->select(
                    DB::raw('sum(total_price) as total,date(created_at) as created_at') 
                    
                  )
                  ->where('user_id',$id)
                  ->groupBy(DB::raw('date(created_at)'))
                  ->orderBy('created_at','desc')
                  ->paginate(20);
       
       return view('users.dailyTotal',['metaTitle' => 'Daily Sales Report'])->with(['results' => $result , 'user' => $user]);

    }
}
