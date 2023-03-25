<?php

namespace App\Http\Controllers;

use App\Drug;
use App\DrugOrder;
use App\OrderRequest;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function showAddItem($id)
    {
        $order = OrderRequest::findOrFail($id);
        return view('sales.addSales')
            ->with([
                'order' => $order,
            ]);
    }

    public function storeItem(Request $request,$id)
    {
        $this->validate($request,[
            'items' => 'required'
        ]);

       $OrderRequest = OrderRequest::findOrFail($id);
       $arr = array();
       $q = new Stock();
       
       $errors = [];


       foreach ($request->items as $id=>$quantity) {
           $check = $q->checkAvilable($id,$quantity['quantity']);
           if($check['more']) {
              $errors[] = $check['message'];
           }
       }

       if(!empty($errors)){  
          return back()->with('errs', $errors);
       }


       foreach ($request->items as $id=>$quantity) {
        array_push($arr, [$id => ['quantity' => $quantity['quantity'],'price' => $request->input('price'.$id) ,
        'purchasing_price' => $request->input('purchasing_price_'.$id) , 'discount' => $request->input('discount'.$id) ]] );
    
       }

       DB::beginTransaction();
       try {
        foreach ($arr as $a) {
            $OrderRequest->stock()->attach($a);
        }
        

        $discount = DrugOrder::where('order_request_id',$OrderRequest->id)->sum('discount');
        $total_items = DrugOrder::where('order_request_id',$OrderRequest->id)->sum('quantity');
         // new quantity
        
         $OrderRequest->update([
          'total_price' => $OrderRequest->total_price + $request->total,
          'discount' => $discount,
          'total_items' => $total_items
         ]);
       
  
        foreach ($request->items as $id=>$quantity) {
              $stock = Stock::findOrFail($id);
  
              $new_stock = $stock->quantity_per_unit - $quantity['quantity'];
              
              $stock->update([
              'quantity_per_unit' => $new_stock
              ]);
        }


        DB::commit();
        return redirect()->route('DrugRequests.show',$OrderRequest->id);
       } catch (\Throwable $th) {

            DB::rollBack();
            return back()->with('errs',['Error Happend Try A gain']);
       }
       
     
    }


    public function getDrugs(Request $request)
    {
    
       if($request->search == ''){
        $drugs = Drug::has('stocks')->limit(5)->get();
       }else {
        $drugs = Drug::has('stocks')
                  ->where('trade_name','like','%'.$request->search.'%')
                  ->orWhere('generic_name','like','%'.$request->search.'%')
                  ->get();
       }

       $response = array();
        foreach ($drugs as $drug) {
           $response[] = array(
              'id' => $drug->id ,
              'text' => $drug->trade_name.' - '.$drug->generic_name
           );
       }

       echo json_encode($response);
    }
}
