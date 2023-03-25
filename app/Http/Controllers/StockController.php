<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;
use App\Drug;
use App\PurchaseOrders;
use App\Stock;
use Auth;
use Exporter;
use App\Serialisers;
use DataTables;
use App\DrugItemType;
use App\DrugUnit;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $unit = DrugUnit::all();
        $type = DrugItemType::all();
        $stocks = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','d.generic_name','s.barcode',
                      's.purchasing_price','s.selling_price','s.quantity_per_unit',
                      's.bonus' , 's.bonus_pst',
                      's.exp' , DB::raw("ROUND (DATEDIFF(s.exp, CURRENT_DATE()) / 30.4167 , 1)  AS rem ")
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('quantity_per_unit' ,'>' , 0)
                  ->orderBy('rem' , 'desc')
                  ->paginate(20);

        $total_price = DB::table('stock')
                  ->select([
                     DB::raw('sum(purchasing_price * quantity_per_unit) as total_price')
                  ])
                  ->where('quantity_per_unit' ,'>' , 0)
                  ->first();
        




        return view('stock.index',['metaTitle' => trans('body.availableStock')])
            ->with([
                'stocks' => $stocks, 
                'total_price' => $total_price ,
                'units' => $unit,
                'types' => $type
            ]);
    }



    public function search(Request $request)
    {

     
     
        if ($request->has('q')) {
            $request->flashOnly('q');
            $result  = DB::table('stock as s')
                     ->select([
                     's.id', 'd.trade_name','d.generic_name','s.barcode',
                      's.purchasing_price','s.selling_price','s.quantity_per_unit',
                      's.exp'
                    ])
                    ->leftJoin('drugs as d','s.drug_id','=','d.id')
                    ->where('d.trade_name','like',"%".$request->q."%")
                    ->orWhere('d.generic_name','like',"%".$request->q."%")
                    ->orWhere('s.barcode','=',$request->q)
                    ->where('quantity_per_unit' ,'>' , 0)
                    ->orderBy('s.id' , 'desc')
                    ->paginate(20);

           
        }else {
            $result = [];
        }
       
        return view('stock.search')->with('results',$result);
    }



    public function stockHistory()
    {
        $stocks = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','d.generic_name',
                      's.purchasing_price','s.selling_price','s.quantity_per_unit',
                      's.exp','s.created_at'
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('quantity_per_unit' ,'=' , 0)
                  ->orderBy('s.created_at' , 'desc')
                  ->paginate(20);

        return view('stock.history',compact('stocks'),['metaTitle' => trans('body.stockHistory')]);
    }



    public function getCount(Request $request)
    {
        $drug_id = $request->get('drug_id');
        $data = DB::table('drugs')
                   ->where('id',$drug_id)
                   ->first();
        echo $data->count_per_unit;
    }


    public function updatePrice(Request $request){
        
        
        $this->validate($request,[

            'stock_id' => 'required',
            'pst' => 'required'

        ]);

       


        foreach ($request->stock_id as $id) {

            Stock::where('id',$id)
            ->update(
            [
              'purchasing_price' => $request->input('purchasing_price_'.$id),  
              'selling_price' => 
               DB::raw($request->input('purchasing_price_'.$id).' + ( ( '.$request->pst.' / 100) 
            * '.$request->input('purchasing_price_'.$id).')') , 'pst' => $request->pst]);
        }
        
        $request->session()->flash('success','Stock  has been updated');
        return back();


    }


    public function stockCheck(Request $request)
    {
            
            $results  = DB::table('stock as s')
                     ->select([
                      's.id', 'd.trade_name','i.type','u.name',
                      's.purchasing_price','s.selling_price','s.quantity_per_unit',
                      's.exp','s.pst','s.count_per_unit','quantity'
                    ])
                    ->leftJoin('drugs as d','s.drug_id','=','d.id')
                    ->leftJoin('drug_units as u','u.id','=','d.unit_id')
                    ->leftJoin('drug_item_types as i','i.id','=','d.item_type_id')
                    ->leftJoin('purchase_order as po','po.stock_id','=','s.id')
                    ->where('d.item_type_id',$request->item_type_id)
                    ->where('d.unit_id',$request->unit_id)
                    ->where('quantity_per_unit' ,'>' , 0);

            if($request->has('drug_id') && !empty($request->drug_id)){
                $results = $results->where('s.drug_id',$request->drug_id)->get();
            }else {
                $results = $results->get();
            }



            return view('stock.check')->with([
              'results' => $results ,
              'item_type_id' => $request->item_type_id ,
              'unit_id' => $request->unit_id

            ]);

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drug = Drug::all();

        return view('stock.create',['metaTitle' => 'Add Stock'])->with('drugs',$drug);
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

            'drug_id' => 'required',
            'exp' => 'required|after:today',
            'quantity' => 'required',
            'total_price' => 'required',
            'quantity_per_unit' => 'required',
            'purchasing_price' => 'required',
            'selling_price' => 'required',
            'count_per_unit' => 'required',
            'bonus' => 'required',
            'pst' => 'required'

        ]);


        $purchaseOrder = new PurchaseOrders();
        $stock = new Stock();

        DB::beginTransaction();

        try {



            $stock->drug()->associate($request->drug_id);
            $stock->barcode = $request->barcode;
            $stock->purchasing_price = $request->purchasing_price;
            $stock->selling_price = $request->selling_price;
            $stock->quantity_per_unit = $request->quantity_per_unit;
            $stock->exp = $request->exp;
            $stock->count_per_unit = $request->count_per_unit;
            $stock->pst = $request->pst;
            $stock->patch_number = $request->patch_number;
            $stock->bonus = $request->bonus;
            $stock->bonus_pst = $request->bonus_pst;
            $stock->save();

            $purchaseOrder->total_price = $request->total_price;
            $purchaseOrder->quantity = $request->quantity;
            $purchaseOrder->stock()->associate($stock->id);
            $purchaseOrder->user()->associate(Auth::id());
            $purchaseOrder->save();

            DB::commit();

            $request->session()->flash('success','Stock  has been Saved');
            return redirect()->route('stocks.create');
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('error','Some Error Happend');
            return redirect()->withInputs()->route('stocks.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAddToStockForm($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.addToStock',['metaTitle' => 'Add To Existing Stock'])
                ->with('stock',$stock);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);

        $drugs = Drug::all();

        return view('stock.edit')->with(['stock' => $stock ,'drugs' => $drugs]);
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

            'drug_id' => 'required',
            'exp' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
            'quantity_per_unit' => 'required',
            'purchasing_price' => 'required',
            'selling_price' => 'required',
            'count_per_unit' => 'required',
            'bonus' => 'required',
            'bonus_pst' => 'required',
        ]);


        $stock = Stock::findOrFail($id);

        

        DB::beginTransaction();

        try {
            
            $stock->drug()->associate($request->drug_id);
            $stock->barcode = $request->barcode;
            $stock->purchasing_price = $request->purchasing_price;
            $stock->selling_price = $request->selling_price;
            $stock->quantity_per_unit = $request->quantity_per_unit;
            $stock->exp = $request->exp;
            $stock->count_per_unit = $request->count_per_unit;
            $stock->pst = $request->pst;
            $stock->patch_number = $request->patch_number;
            $stock->bonus = $request->bonus;
            $stock->bonus_pst = $request->bonus_pst;
            $stock->save();


            DB::commit();

            $request->session()->flash('success','Stock  has been Updated');
            return redirect()->route('stocks.edit',$stock->id);
           
        } catch (Exception $e) {

           DB::rollBack();

           $request->session()->flash('error','Something Wrong Happend');
           return redirect()->route('stocks.edit',$stock->id);
        }
    }


    public function updatAddedStock(Request $request, $id)
    {
        $this->validate($request,[
            'quantity' => 'required',
            'total_price' => 'required',
            'quantity_per_unit' => 'required',
        ]);

        $stock = Stock::findOrFail($id);

        $quantity_per_unit= $stock->quantity_per_unit + $request->quantity_per_unit;
        $quantity = $stock->purchaseOrder->quantity + $request->quantity;
        $total_price = $stock->purchaseOrder->total_price + $request->total_price;

        

        DB::beginTransaction();

        try {
            $stock->update([
                'quantity_per_unit' => $quantity_per_unit
            ]);

             $stock->purchaseOrder->update([
                'total_price' =>  $total_price,
                'quantity' => $quantity
             ]);

             DB::commit();

             $request->session()->flash('success','Stock Added Successfully');
             return redirect()->route('stocks.showAddToStockForm',$stock->id);

        } catch (Exception $e) {
           DB::rollBack();

           $request->session()->flash('error','Something Wrong Happend');
           return redirect()->route('stocks.showAddToStockForm',$stock->id);
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
        $stock = Stock::findOrFail($id);

        if ($stock->orderRequest()->first()) {
            $stock->orderRequest()->first()->delete();
        }
        
        $stock->returnedItems()->delete();
        $stock->purchaseOrder()->delete();
        $stock->delete();

        return redirect()->route('stocks.index');
    }


    public function export() 
    {
        $FileName = "stock.xlsx";
        $query =   Stock::all()->where('quantity_per_unit' ,'>' , 0);
        
        $serialiser = new Serialisers;
        $excel = Exporter::make('Excel');
        $excel->load($query);
        $excel->setSerialiser($serialiser);
        return $excel->stream($FileName);
            // return Excel::download(new StockExport, 'stock.xlsx');
    }
}
