<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OrderRequest;
use App\ReturnedItems;
use App\Stock;
use App\DrugOrder;
use Auth;


class ReturnedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returns = ReturnedItems::with('stock')->orderBy('id','asc')->paginate(20);
        

        return view('ReturnedItems.index',['metaTitle' => 'Purchase returns'])->with('returns',$returns);
    }

    public function returnItem($id)
    {
        $drugOrder = DrugOrder::findOrFail($id);

        $order = OrderRequest::findOrFail($drugOrder->order_request_id);

        $stock = Stock::findOrFail($drugOrder->stock_id);

        $soldItems =  $order->stock()->count();

        if ($soldItems > 1) {
            

            $new_stock = $stock->quantity_per_unit + $drugOrder->quantity;
              
            $stock->update([
              'quantity_per_unit' => $new_stock
            ]);

            $subTotal = $drugOrder->quantity * $stock->selling_price;
            $new_total = $order->total_price - $subTotal;
            $total_items = $order->total_items - $drugOrder->quantity;

            $order->update([
                'total_price' => $new_total,
                'total_items' => $total_items
            ]);


            $returned = new ReturnedItems();
            $returned->stock_id = $stock->id;
            $returned->user()->associate(Auth::id());
            $returned->quantity_returned = $drugOrder->quantity;
            $returned->save();

            $drugOrder->delete();

            return redirect()->route('DrugRequests.show',$order->id);
            
        }else {

            $new_stock = $stock->quantity_per_unit + $drugOrder->quantity;
              
            $stock->update([
              'quantity_per_unit' => $new_stock
            ]);


            $returned = new ReturnedItems();
            $returned->stock_id = $stock->id;
            $returned->user()->associate(Auth::id());
            $returned->quantity_returned = $drugOrder->quantity;
            $returned->save();

            $order->stock()->detach();
            $order->delete();

            return redirect()->route('DrugRequests.index');
        }

    }


     public function returnOrder($id)
    {
         $orders = OrderRequest::findOrFail($id);

       
    
        foreach ($orders->stock as $stock) {
           $new_stock = $stock->quantity_per_unit + $stock->pivot->quantity;
          
           $stock->update([
            'quantity_per_unit' => $new_stock
           ]);

           
           $returned = new ReturnedItems();
           $returned->stock_id = $stock->id;
           $returned->user()->associate(Auth::id());
           $returned->quantity_returned = $stock->pivot->quantity;
           $returned->save();

        }

        $orders->stock()->detach();
        $orders->delete();

        return redirect()->route('ReturnedItems.index');
    }

    public function returnInc($id)
   {
       $drugOrder = DrugOrder::findOrFail($id);

        $order = OrderRequest::findOrFail($drugOrder->order_request_id);

        $stock = Stock::findOrFail($drugOrder->stock_id);

        $soldItems =  $order->stock()->count();

        if ($soldItems > 1) {
            

            $new_stock = $stock->quantity_per_unit + $drugOrder->quantity;
              
            $stock->update([
              'quantity_per_unit' => $new_stock
            ]);

            $subTotal = $drugOrder->price;
            $new_total = $order->total_price - $subTotal;
            $total_items = $order->total_items - $drugOrder->quantity;
            
          

            $order->update([
                'total_price' => $new_total,
                'total_items' => $total_items
            ]);

            
            



            $returned = new ReturnedItems();
            $returned->stock_id = $stock->id;
            $returned->user()->associate(Auth::id());
            $returned->quantity_returned = $drugOrder->quantity;
            $returned->save();

            $drugOrder->delete();

            return redirect()->route('insurancePointOfSale.show',$order->id);
            
        }else {

            $new_stock = $stock->quantity_per_unit + $drugOrder->quantity;
              
            $stock->update([
              'quantity_per_unit' => $new_stock
            ]);


            $returned = new ReturnedItems();
            $returned->stock_id = $stock->id;
            $returned->user()->associate(Auth::id());
            $returned->quantity_returned = $drugOrder->quantity;
            $returned->save();

            $order->stock()->detach();
            $order->patient()->detach();
            $order->delete();

            return redirect()->route('pos.InsuranceSalesReport');
        }
   }


    
}
