<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseOrdersExport;
use DB;
use App\PurchaseOrders;
use App\User;
use App\PurchaseOrdersReport;
use App\PODetailsReport;
use Exporter;

class PurchaseOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pos = DB::table('purchase_order as po')
                  ->select([
                     'po.id','po.total_price','po.quantity', 'd.trade_name',
                     'd.generic_name','u.name'
                  ])
                  ->leftJoin('stock as s','po.stock_id','=','s.id')
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->leftJoin('users as u','po.user_id','=','u.id')
                  ->orderBy('po.id' , 'desc')
                  ->paginate(20);

        

        $total_price = PurchaseOrders::sum('total_price');
        $retailPrice = DB::table('stock as s')
                    ->select([
                        DB::raw('sum(po.total_price + ((po.total_price/100) * s.pst) )as sum')
                    ])
                    ->leftJoin('purchase_order as po','po.stock_id','s.id')
                    ->first();
        $sum = $retailPrice->sum;
       
        return view('po.index',compact('pos'),['metaTitle' => trans('body.PurchaseOrders')])
                ->with([
                    'total_price' => $total_price,
                    'sum' => $sum
                ]);

        
    }


    public function getUserPO($id)
    {
        $user = User::findOrFail($id);
        $purchaseOrders = $user->purchaseOrder()->orderBy('created_at','desc')->paginate(10);

        return view ('po.user')->with(['purchaseOrders' => $purchaseOrders,'user' => $user]);
    }


    public function search(Request $request)
    {
        if ($request->has('q')) {
            $request->flashOnly('q');
         $result =  DB::table('purchase_order as po')
                  ->select([
                     'po.id','po.total_price','po.quantity', 'd.trade_name',
                     'd.generic_name','u.name'
                  ])
                  ->leftJoin('stock as s','po.stock_id','=','s.id')
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->leftJoin('users as u','po.user_id','=','u.id')
                  ->where('d.trade_name','like',"%".$request->q."%")
                  ->orWhere('d.generic_name','like',"%".$request->q."%")
                  ->orWhere('u.name','like',"%".$request->q."%")
                  ->orderBy('po.id' , 'desc')
                  ->paginate(20);

           
        }else {
            $result = [];
        }

        
        return view('po.search')->with('results',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


    public function export() 
    {
        return Excel::download(new PurchaseOrdersExport, 'PurchaseOrders.xlsx');
    }


    public function exportReport() 
    {
        $FileName = "PurchaseOrders.xlsx";
        $query =   DB::table('purchase_order as po')
                   ->select(DB::raw('d.trade_name , SUM(po.total_price) as total_price , SUM(po.quantity) as total_quantity'))
                   ->leftJoin('stock as s','po.stock_id','=','s.id')
                   ->leftJoin('drugs as d','s.drug_id','=','d.id')
                   ->groupBy('s.drug_id')
                   ->get();
        
       
        
        $PurchaseOrdersReport = new PurchaseOrdersReport;
        $excel = Exporter::make('Excel');
        $excel->load($query);
        $excel->setSerialiser($PurchaseOrdersReport);
        return $excel->stream($FileName);
    }


    public function exportDetailsReport()
    {
        $FileName = "PurchaseOrdersDetails.xlsx";
        $pos = DB::table('purchase_order as po')
                  ->select([
                     'po.id','po.total_price','po.quantity', 'd.trade_name',
                     'd.generic_name','u.name'
                  ])
                  ->leftJoin('stock as s','po.stock_id','=','s.id')
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->leftJoin('users as u','po.user_id','=','u.id')
                  ->orderBy('po.id' , 'desc')
                  ->get();

        $PODetailsReport = new PODetailsReport;
        $excel = Exporter::make('Excel');
        $excel->load($pos);
        $excel->setSerialiser($PODetailsReport);
        return $excel->stream($FileName);
    }
}
