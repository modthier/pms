<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethod;
use App\Stock;
use App\OrderRequest;
use App\Setting;
use App\InsuranceReport;
use App\InsuranceCompany;
use Exporter;
use Auth;
use DB;
use Carbon\Carbon;

class PointOfSaleInsuranceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drugOrder.create_insurance',['metaTitle'=>'Insurance Point Of Sale'])
        	->with([
        		'payments' => PaymentMethod::all(),
                'companies' => InsuranceCompany::all()
        	]);
    }


    public function getItemByScanner(Request $request)
    {
            $today = date('Y-m-d');
            $scanner = $request->get('scanner');
            $insurance_id = $request->get('insurance_id');
            $insurance = InsuranceCompany::findOrFail($insurance_id);
            $price_value = $insurance->price_value;
            $pst = $request->get('pst');
            $data = DB::table('stock as s')
                        ->select([
                          's.id', 'd.trade_name','s.selling_price','s.quantity_per_unit','s.exp',
                          's.insurance_selling_price','s.purchasing_price'
                        ])
                        ->leftJoin('drugs as d','s.drug_id','=','d.id')
                        ->where('s.barcode' ,$scanner)
                        ->where('s.exp','>' ,$today)
                        ->where('s.quantity_per_unit','>',0)
                        ->get();
              $output = "";
              if ($data->count() == 1) {
              foreach ($data as $row) {
                $output .= <<<EOT
                      <tr>  
                          <td>$row->trade_name - $row->exp</td>
                          <td>
                            <input name="items[$row->id][quantity]" type="number" class="form-control quantity_ins" min-value="1" value="1"
                            data-id="$row->id" data-incp ="$row->insurance_selling_price" 
                            data-incpv="$price_value" 
                            data-price="$row->selling_price" id="qu$row->id" data-avl="$row->quantity_per_unit">
                          </td>
                        <td>
                          <input type="number" class="form-control price_ins" 
                          data-id="$row->id" data-avl="$row->quantity_per_unit" id="price$row->id" name="price$row->id" 
                          value="$row->selling_price">
                        </td>
            EOT;
              if ($price_value) {
                $added_value = $row->selling_price - $row->insurance_selling_price ;
                if($added_value > 0) {
                  $value = $added_value   + ($row->insurance_selling_price * ($pst/100)) ;
                }else {
                  $value = $row->insurance_selling_price * ($pst/100);
              }   
              $output .= <<<EOT
              <td>
              <input type="text" class="form-control deduction_value" id="deduction_value_$row->id" 
              name="deduction_value_$row->id" value="$value">
              </td>
          EOT;
              }else {
                $dv = $row->selling_price * ($pst/100);
                $output .= <<<EOT
                  <td>
                    <input type="text" class="form-control deduction_value other"
                        id="deduction_value_$row->id" name="deduction_value_$row->id" 
                        value="$dv">
                </td>
                EOT;
              }
            $output .= <<<EOT
                      
                        <td>
                          <input type="number" class="form-control deduction_rate" 
                          name="deduction_rate_$row->id" 
                          value="$pst" disabled>
                      </td>
                      <td>
                            <input type="number" class="form-control sub_total" id="sub_total_$row->id" 
                            name="sub_total_$row->id" 
                            value="$row->selling_price">
                      </td>
                      <td>
                        <button data-stock-id="$row->id" class="btn btn-danger delete-item"><span class="fas fa-trash-alt"></span></button>
                      </td>
                    </tr>
                        <input type="hidden" class="form-control" id="com_insurance_price_$row->id" name="com_insurance_price_$row->id"
                        value="$row->insurance_selling_price">
                        <input type="hidden" class="form-control" id="purchasing_price_$row->id" name="purchasing_price_$row->id"
                        value="$row->purchasing_price">
                EOT;
                

          }
        }else {
          $output = "";
          foreach ($data as $row) {
              if ($price_value) {
                $added_value = $row->selling_price - $row->insurance_selling_price ;
                if($added_value > 0) {
                  $value = $added_value   + ($row->insurance_selling_price * ($pst/100)) ;
                }else {
                  $value = $row->insurance_selling_price * ($pst/100);
                }
              }else {
                  $value = $row->selling_price * ($pst/100);
              }
              $output .= "<tr>";
              $output .= "<td>{$row->trade_name}</td>";
              $output .= "<td>{$row->exp}</td>";
              $output .= "<td><button class='btn btn-primary add-item-inc' data-id='{$row->id}'
                 data-selling_price='{$row->selling_price}' 
                 data-quantity_per_unit='{$row->quantity_per_unit}'
                 data-exp='{$row->exp}'
                 data-fv='{$value}'
                 data-pst = '{$pst}'
                 data-isp = '$row->insurance_selling_price'
                 data-pp = '$row->purchasing_price'
                 data-pv = '$price_value'
                 data-trade_name='{$row->trade_name}'>
                  Add Item</button></td>";
              $output .= "</tr>";
          }
        }

        $result = [
            'count' => $data->count(),
            'data'=> $output,'id' => $row->id,
            'price' => $data->first()->selling_price,
            'insurance_selling_price' => $data->first()->insurance_selling_price,
            'price_value' => $price_value
          ];

        return response()->json($result);
    }



    public function getItemById(Request $request)
    {

       $today = date('Y-m-d');
       $stockId = $request->get('stockId');
       $insurance_id = $request->get('insurance_id');
       $insurance = InsuranceCompany::findOrFail($insurance_id);
       $price_value = $insurance->price_value;
       $pst = $request->get('pst');
       $data = DB::table('stock as s')
                  ->select([
                    's.id', 'd.trade_name','s.selling_price','s.quantity_per_unit','s.exp',
                    's.insurance_selling_price','s.purchasing_price'
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('s.exp','>' ,$today)
                  ->where('s.id' ,$stockId)
                  ->where('s.quantity_per_unit','>',0)
                  ->get();
                  $output = "";
                  foreach ($data as $row) {
                       $output .= <<<EOT
                              <tr>  
                                 <td>$row->trade_name - $row->exp</td>
                                 <td>
                                    <input name="items[$row->id][quantity]" type="number" class="form-control quantity_ins" min-value="1" value="1"
                                    data-id="$row->id" data-incp ="$row->insurance_selling_price" 
                                    data-incpv="$price_value" 
                                    data-price="$row->selling_price" id="qu$row->id" data-avl="$row->quantity_per_unit">
                                 </td>
                                <td>
                                  <input type="number" class="form-control price_ins" 
                                  data-id="$row->id" data-avl="$row->quantity_per_unit" id="price$row->id" name="price$row->id" 
                                  value="$row->selling_price">
                                </td>
                    EOT;
                      if ($price_value) {
                        $added_value = $row->selling_price - $row->insurance_selling_price ;
                        if($added_value > 0) {
                          $value = $added_value   + ($row->insurance_selling_price * ($pst/100)) ;
                        }else {
                          $value = $row->insurance_selling_price * ($pst/100);
                      }   
                      $output .= <<<EOT
                      <td>
                      <input type="text" class="form-control deduction_value" id="deduction_value_$row->id" 
                      name="deduction_value_$row->id" value="$value">
                      </td>
                  EOT;
                     }else {
                      $dv = $row->selling_price * ($pst/100);
                      $output .= <<<EOT
                        <td>
                          <input type="text" class="form-control deduction_value other"
                              id="deduction_value_$row->id" name="deduction_value_$row->id" 
                              value="$dv">
                      </td>
                      EOT;
                      }
                    $output .= <<<EOT
                             
                               <td>
                                 <input type="number" class="form-control deduction_rate" 
                                 name="deduction_rate_$row->id" 
                                 value="$pst" disabled>
                              </td>
                              <td>
                                   <input type="number" class="form-control sub_total" id="sub_total_$row->id" 
                                   name="sub_total_$row->id" 
                                   value="$row->selling_price">
                              </td>
                              <td>
                                <button data-stock-id="$row->id" class="btn btn-danger delete-item"><span class="fas fa-trash-alt"></span></button>
                              </td>
                            </tr>
                                <input type="hidden" class="form-control" id="com_insurance_price_$row->id" name="com_insurance_price_$row->id"
                                value="$row->insurance_selling_price">
                                <input type="hidden" class="form-control" id="purchasing_price_$row->id" name="purchasing_price_$row->id"
                                value="$row->purchasing_price">
                       EOT;
                       

                  }
          
                  $result = [
                           'data' => $output 
                          ];
          
                  return response()->json($result);
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

       $added_value = 0;
       $stock = new Stock;

       $company = InsuranceCompany::findOrFail($request->company_id);
       
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
              array_push($arr, [$id => ['quantity' => $quantity['quantity'],'price' => $request->input('sub_total_'.$id) , 'discount' => 0, 
                 'insurance_price' => $request->input('com_insurance_price_'.$id),'purchasing_price' => $request->input('purchasing_price_'.$id)]] );
              if($company->price_value){
              $added_value += (($request->input('price'.$id) * $quantity['quantity']) - ($request->input('com_insurance_price_'.$id) * $quantity['quantity'])  );
              }else {
                $added_value += 0;
              }
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
            $OrderRequest->is_insured = 1;

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

            
            $OrderRequest->insurance()
              ->attach($request->company_id,[
                'deduct_value' => $request->total_dedcut ,
                'deduct_rate' => $company->deduct_rate,
                'added_value' => $added_value
              ]);
            

            


            DB::commit(); 
            return redirect()->route('insurancePointOfSale.show',$OrderRequest->id);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('insurancePointOfSale.create');
            
        }

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

        $company = InsuranceCompany::findOrFail($orders->insurance->first()->pivot->insurance_company_id);
        $price_value = $company->price_value;
        
        
        return view('patient.patient_order',['metaTitle' => trans('body.salesReportDetails')])
        ->with(['orders' => $orders , 'setting' => $setting , 'price_value' => $price_value]);
    }
    

    public function export(Request $request) 
    {
        if ($request->action == "export") {
          $FileName = "InsuranceReport.xlsx";
          $company = InsuranceCompany::findOrFail($request->insurance_company_id);
          if($company->price_value){
          $query = DB::table('insurance_order_request as orp')
                    ->select([
                      'ic.name' , 'orp.deduct_rate' ,
                       'orp.deduct_value' , 'orp.added_value' , 'oq.total_price' , 'orp.created_at' ,
                        DB::raw('(oq.total_price - orp.deduct_value)   as claim'),
                        'ic.price_value' 
                    ])
                    ->leftJoin('insurance_companies as ic','orp.insurance_company_id','ic.id')
                    ->leftJoin('order_request as oq','oq.id','orp.order_request_id')
                    ->where('orp.insurance_company_id',$request->insurance_company_id)
                    ->whereRaw('Date(orp.created_at) between ? and ?',[$request->date_from,$request->date_to])
                    ->orderBy('orp.created_at','desc')
                    ->get();
          }else {
          $query = DB::table('insurance_order_request as orp')
                    ->select([
                      'ic.name' , 'orp.deduct_rate' ,
                       'orp.deduct_value' , 'orp.added_value' , 'oq.total_price' , 'orp.created_at' ,
                        DB::raw('(oq.total_price - orp.deduct_value) as claim') , 'ic.price_value'
                    ])
                    ->leftJoin('insurance_companies as ic','orp.insurance_company_id','ic.id')
                    ->leftJoin('order_request as oq','oq.id','orp.order_request_id')
                    ->where('orp.insurance_company_id',$request->insurance_company_id)
                    ->whereRaw('Date(orp.created_at) between ? and ?',[$request->date_from,$request->date_to])
                    ->orderBy('orp.created_at','desc')
                    ->get();
          }
          $serialiser = new InsuranceReport;
          $excel = Exporter::make('Excel');
          $excel->load($query);
          $excel->setSerialiser($serialiser);
          return $excel->stream($FileName);
        }else {
          $total = DB::table('insurance_order_request as orp')
          ->select([
            'ic.id' ,'ic.price_value', 'orp.added_value' ,
             DB::raw('(oq.total_price - orp.deduct_value) as claim')
          ])
            ->leftJoin('insurance_companies as ic','orp.insurance_company_id','ic.id')
            ->leftJoin('order_request as oq','oq.id','orp.order_request_id')
            ->where('orp.insurance_company_id',$request->insurance_company_id)
            ->whereRaw('Date(orp.created_at) between ? and ?',[$request->date_from,$request->date_to])
            ->orderBy('orp.created_at','desc')
            ->get();

          if ($total->isEmpty()) {
            return view('invoices.nodata');
            }else {
              if($total->first()->claim > 0){
                
                return view('invoices.create')->with([
                    'insurance' => $total,
                    'date_from' => $request->date_from,
                    'date_to' => $request->date_to,
                    'companies' => InsuranceCompany::all(),
                ]);
            }else{
              return view('invoices.nodata');
            }
          }
         
        }
        
    }


     public function InsuranceReport()
    {

        $orders =  DB::table('insurance_order_request as orp')
                ->select([
                  'or.id','ic.name', DB::raw('u.name as username') , 'orp.deduct_rate'  , 'orp.deduct_value' , 'or.total_price' ,
                  'or.created_at' , DB::raw('(or.total_price - orp.deduct_value) as claim')
                  
                ])
                ->leftJoin('order_request as or','orp.order_request_id','or.id')
                ->leftJoin('users as u','u.id','or.user_id')
                ->leftJoin('insurance_companies as ic','orp.insurance_company_id','ic.id')
                ->paginate(20);

        $summary = DB::table('insurance_order_request as orp')
                   ->select([
                      'ic.name' , DB::raw('sum(orp.deduct_value) as deduct_total') , 
                      DB::raw('sum(or.total_price) as actual_total') , DB::raw('sum(orp.added_value) as added_value')
                   ])
                   ->leftJoin('order_request as or','orp.order_request_id','or.id')
                   ->leftJoin('insurance_companies as ic','orp.insurance_company_id','ic.id')
                   ->whereBetween('orp.created_at',[Carbon::now()->startOfMonth(),
                     Carbon::now()->endOfMonth()])
                   ->groupBy('orp.insurance_company_id')
                   ->get();
        
        return view('orders.insuranceReport',['metaTitle' => 'Insurance Report'])
               ->with([
                'orders' => $orders ,
                'companies' => InsuranceCompany::all() ,
                'summary' => $summary
                ]);
    }



}
