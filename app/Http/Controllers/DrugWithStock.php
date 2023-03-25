<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrugItemType;
use App\DrugUnit;
use DB;
use App\Drug;
use App\PurchaseOrders;
use App\Stock;
use Auth;

class DrugWithStock extends Controller
{
    

    public function getQuantity()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {

        $unit = DrugUnit::all();
        $type = DrugItemType::all();
        return view('drugs.createDrugWithStock',['metaTitle' => 'Add Drug With Stock'])
                ->with(['units' => $unit , 'types' => $type]);
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
            'trade_name' => 'required',
            'generic_name' => 'required',
            'item_type_id' => 'required',
            'unit_id' => 'required',
            'company_id' => 'required',
            'count_per_unit' => 'required',
            'exp' => 'required|after:today',
            'quantity' => 'required',
            'total_price' => 'required',
            'quantity_per_unit' => 'required',
            'purchasing_price' => 'required',
            'selling_price' => 'required',
            'insurance_selling_price' => 'required'

        ]);

        $drug = new Drug();
        $purchaseOrder = new PurchaseOrders();
        $stock = new Stock();

        DB::beginTransaction();

        try {

            $drug->trade_name = $request->trade_name;
            $drug->generic_name = $request->generic_name;
            $drug->drugItemType()->associate($request->item_type_id);
            $drug->drugUnit()->associate($request->unit_id);
           
            $drug->save();

            $stock->drug()->associate($drug->id);
            $stock->barcode = $request->barcode;
            $stock->purchasing_price = $request->purchasing_price;
            $stock->selling_price = $request->selling_price;
            $stock->insurance_selling_price = $request->insurance_selling_price;
            $stock->quantity_per_unit = $request->quantity_per_unit;
            $stock->exp = $request->exp;
            $stock->count_per_unit = $request->count_per_unit;
            $stock->pst = $request->profit_margin;
            $stock->patch_number = $request->patch_number;
            $stock->save();

            $purchaseOrder->total_price = $request->total_price;
            $purchaseOrder->quantity = $request->quantity;
            $purchaseOrder->stock()->associate($stock->id);
            $purchaseOrder->user()->associate(Auth::id());
            $purchaseOrder->save();

            DB::commit();   

            $request->session()->flash('success','Drug  has been Saved');
            return redirect()->route('DrugWithStock.create');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->withInputs()->route('DrugWithStock.create');
        }
    }

    
}
