<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\OrderRequest;
use App\DrugOrder;
use App\Stock;
use App\Client;
use App\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DrugOrderController extends Controller
{
    

     public function getItemByScanner(Request $request,Response $response)
    {
       $today = date('Y-m-d');
       $scanner = $request->get('scanner');
       $data = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','s.selling_price','s.quantity_per_unit','s.exp'
                     ,'s.barcode','s.purchasing_price'
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('s.barcode' ,$scanner)
                  ->where('s.exp','>' ,$today)
                  ->where('s.quantity_per_unit','>',0)
                  ->get();
        
        
        if ($data->count() == 1) {
            $output = "";
            foreach ($data as $row) {
                $output .= <<<EOT
                    <tr>
                        <td>$row->trade_name - $row->exp</td>
                        <td><input name="items[$row->id][quantity]" type="number" class="form-control quantity" min-value="1" value="1" data-id="$row->id" data-price="$row->selling_price" id="qu$row->id" data-avl="$row->quantity_per_unit">
                        </td>
                        <td>
                          <input type="number" class="form-control order_selling_price" id="price$row->id" 
                          data-id="$row->id" name="price$row->id" value="$row->selling_price" readonly>
                        </td>
                        <td><input type="number" id="discount_$row->id"  class="discount form-control" name="discount$row->id" 
                        data-id="$row->id" data-price="$row->selling_price"  min-value="0" value="0" />
                        </td>
                        <td><input type="number" class="form-control sub_total" id="sub_total_$row->id" 
                          name="sub_total_$row->id" value="$row->selling_price">
                        </td>
                        <td><button data-stock-id="$row->id" class="btn btn-danger delete-item"><span class="fas fa-trash-alt"></span></button>
                        </td>
                        <input type="hidden" class="form-control purchasing_price" id="purchasing_price_$row->id" 
                          name="purchasing_price_$row->id" value="$row->purchasing_price">
                        
                    </tr>
              EOT;
           }

        }else {
          $output = "";
          foreach ($data as $row) {
              $output .= "<tr>";
              $output .= "<td>{$row->trade_name}</td>";
              $output .= "<td>{$row->exp}</td>";
              $output .= "<td><button class='btn btn-primary add-item' data-id='{$row->id}'
                 data-selling_price='{$row->selling_price}' 
                 data-quantity_per_unit='{$row->quantity_per_unit}'
                 data-exp='{$row->exp}'
                 data-trade_name='{$row->trade_name}'>
                  Add Item</button></td>";
              $output .= "</tr>";
          }
        }

        if($data->count() > 0) {
            $result = [
                'count' => $data->count(),
                'data'=> $output,
                'id' => $row->id,
                'avl' => $data->first()->quantity_per_unit,
                'price' => $data->first()->selling_price,  
            ];


            
        }else {
           $result = [
                'count' => 0,
                'data'=> $output,
                'id' => null,
                'avl' => 0,
                'price' => 0
            ];

        }

        return response()->json($result);
           
    }



    public function getItemById(Request $request)
    {

       $today = date('Y-m-d');
       $stockId = $request->get('stockId');
       $data = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','s.selling_price','s.quantity_per_unit','s.exp' ,
                     's.barcode' , 's.purchasing_price'
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('s.exp','>' ,$today)
                  ->where('s.id' ,$stockId)
                  ->where('s.quantity_per_unit','>',0)
                  ->get();
        $output = "";
        if ($data->count() > 0) {
            foreach ($data as $row) {
                $output .= <<<EOT
                    <tr>
                        <td>$row->trade_name - $row->exp</td>
                        <td><input name="items[$row->id][quantity]" type="number" class="form-control quantity"
                         min-value="1" value="1" data-id="$row->id" data-price="$row->selling_price" 
                         id="qu$row->id" data-avl="$row->quantity_per_unit">
                        </td>
                        <td>
                          <input type="number" class="form-control order_selling_price" id="price$row->id" 
                          data-id="$row->id" name="price$row->id" value="$row->selling_price" readonly>
                        </td>
                        <td><input type="number" id="discount_$row->id"  class="discount form-control" name="discount$row->id" 
                        data-id="$row->id" data-price="$row->selling_price"  min-value="0" value="0" />
                        </td>
                        <td><input type="number" class="form-control sub_total" id="sub_total_$row->id" 
                          name="sub_total_$row->id" value="$row->selling_price">
                        </td>
                        <td><button data-stock-id="$row->id" class="btn btn-danger delete-item"><span class="fas fa-trash-alt"></span></button>
                        </td>
                        <input type="hidden" class="form-control purchasing_price" id="purchasing_price_$row->id" 
                        name="purchasing_price_$row->id" value="$row->purchasing_price">

                    </tr>
              EOT;
            }
        }


        $result = [
             'price' => $data->first()->selling_price ,
             'data' => $output,
             'avl' => $data->first()->quantity_per_unit,
        ];
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $payments = PaymentMethod::all();
        return view('drugOrder.create',['metaTitle' => trans('body.pointOfSale')])
              ->with([
                'payments' => $payments
              ]);
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
            'items' => 'required|array'
        ]);

      
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
              array_push($arr, [$id => ['quantity' => $quantity['quantity'],'price' => $request->input('price'.$id) ,
              'purchasing_price' => $request->input('purchasing_price_'.$id) , 'discount' => $request->input('discount'.$id) ]] );
             
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
            return redirect()->route('DrugRequests.show',$OrderRequest->id);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('DrugOrders.create');
            
        }

    }


    public function getStock(Request $request)
    {
       $today = date('Y-m-d');

       if($request->search == ''){
        $stocks = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','d.generic_name','s.exp','s.patch_number'
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('quantity_per_unit' ,'>' , 0)
                  ->where('s.exp','>' ,$today)
                  ->orderBy('s.id' , 'desc')
                  ->orderBy('s.exp','desc')
                  ->limit(5)
                  ->get();
       }else {
        $stocks = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','d.generic_name','s.exp','s.patch_number'
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('quantity_per_unit' ,'>' , 0)
                  ->where('s.exp','>' ,$today)
                  ->where('d.trade_name','like','%'.$request->search.'%')
                  ->orderBy('s.id' , 'desc')
                  ->orderBy('s.exp','desc')
                  ->get();
       }

       $response = array();

       foreach ($stocks as $stock) {
           $response[] = array(
              'id' => $stock->id ,
              'text' => $stock->trade_name.' - '.$stock->generic_name.' - '.$stock->exp.
                        ' - '.$stock->patch_number
           );
       }

       echo json_encode($response);
       
        
    }


    public function showEditItem($id)
    {
        $order = DrugOrder::findOrFail($id);
        $stock = Stock::findOrFail($order->stock_id);
        return view('orders.editItem',['metaTitle' => 'Edit Sales Item'])
                 ->with([
                    'order' => $order , 
                    'stock' => $stock  
                 ]);
    }


    public function updateItem(Request $request , $id)
    {
        $this->validate($request,[
            'items' => 'required|array'
        ]);

        
        $order = DrugOrder::findOrFail($id);
        $currentStock = Stock::findOrFail($order->stock_id);
        $OrderRequest = OrderRequest::findOrFail($order->order_request_id);
      
       $arr = array();
       $discount = 0;

       $stock = new Stock;
       
       $errors = [];
       if($currentStock->exp < Carbon::today()){
        $errors[] = 'Sorry This Drug is expired';
       }

       foreach ($request->items as $id=>$quantity) {
           $check = $stock->checkAvilable($id,$quantity['quantity']);
           if($check['more']) {
              $errors[] = $check['message'];
           }
       }

       if(!empty($errors)){  
          return back()->with('errs', $errors);
       }


        DB::beginTransaction();

        try {

           $currentStock->update(['quantity_per_unit' => $order->quantity + $currentStock->quantity_per_unit]);
           $totalDeffrence = $OrderRequest->total_price - ($order->price * $order->quantity);
           $itemTotal = $request->total;

           // update item
           $order->update([
                'quantity' => $request->items[$currentStock->id]['quantity'],
                'discount' => $request->input('discount'.$currentStock->id)
           ]);

           $discount = DrugOrder::where('order_request_id',$order->order_request_id)->sum('discount');
           $total_items = DrugOrder::where('order_request_id',$order->order_request_id)->sum('quantity');
           // new quantity
           $new = $currentStock->quantity_per_unit - $request->items[$currentStock->id]['quantity'];

           $currentStock->update(['quantity_per_unit' => $new ]);

           $OrderRequest->update([
                'total_price' => $totalDeffrence + $itemTotal,
                'discount' => $discount,
                'total_items' => $total_items
           ]);

           
           

          DB::commit();
         // dd("discount : ".$discount,"total items : ".$total_items,"new quantity: ".$new,"total diffrance : ".$totalDeffrence ,
         //  "new total :".($totalDeffrence + $itemTotal),$currentStock->quantity_per_unit);
          return redirect()->route('DrugRequests.show',$OrderRequest->id);
        } catch (\Throwable $th) {
            throw $th;
             DB::rollBack();
             return back()->with('errs' , $errors);
        }
    }

    
}
