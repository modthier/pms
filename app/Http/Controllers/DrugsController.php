<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DrugExport;
use App\DrugItemType;
use App\DrugUnit;
use DB;
use App\Drug;
use APP\Stock;
use App\Charts\DrugChart;


class DrugsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drug = Drug::orderBy('id','asc')->paginate(20);

       
        return view('drugs.index',['metaTitle' => trans('body.allDrugs')])->with('drugs',$drug);
    }


    public function search(Request $request)
    {
        if ($request->has('q')) {
            $request->flashOnly('q');
            $result = Drug::
                       with(['drugUnit','drugItemType','stocks'])
            		  ->where('generic_name','like', "%".$request->q."%")
            		  ->orWhere('trade_name','like',"%".$request->q."%")
                      ->paginate(20);
        }else {
            $result = [];
        }

        
        return view('drugs.search',['metaTitle' => "Drug Search : ".$request->q])
              ->with('results',$result);
    }


    public function fetch(Request $request)
    {
        $company_id = $request->get('company_id');
        $data = DB::table('medical_reps')
                   ->where('company_id',$company_id)
                   ->get();
        $output = "";
        foreach ($data as $row) {
            $output .= '<option value="'.$row->id.'">'
                     .$row->name.'</option>';   
        }

        echo $output;
    }


    public function check(Request $request)
    {
        $trade_name = $request->get('trade_name');
        $data = DB::table('drugs')
                   ->where('trade_name',$trade_name)
                   ->count();
        if ($data > 0) {
            echo "not unique";
        }else {
            echo "unique";
        }
    }


    public function expired()
    {
        $month = 3;
        $homeStocks = DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','d.generic_name','s.barcode',
                      's.purchasing_price','s.selling_price','s.quantity_per_unit',
                      's.exp', DB::raw("ROUND (DATEDIFF(s.exp, CURRENT_DATE()) / 30.4167 , 1)  AS rem ")
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->where('quantity_per_unit' ,'>' , 0)
                  ->where(DB::raw("ROUND (DATEDIFF(s.exp, CURRENT_DATE()) / 30.4167 , 1)") , '<=' , $month)
                  ->where(DB::raw("ROUND (DATEDIFF(s.exp, CURRENT_DATE()) / 30.4167 , 1)") , '>' , 0)
                  ->orderBy('rem' , 'desc')
                  ->paginate(20);

        return view('expired.index')->with('homeStocks',$homeStocks);
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
        return view('drugs.create',['metaTitle' => 'Add Drug'])->with('units',$unit)
                ->with('types',$type);


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
            'trade_name' => 'required|unique:App\Drug',
            'generic_name' => 'required',
            'item_type_id' => 'required',
            'unit_id' => 'required'
            
        ]);


        

        $drug = new Drug();

        $drug->trade_name = $request->trade_name;
        $drug->generic_name = $request->generic_name;
        $drug->drugItemType()->associate($request->item_type_id);
        $drug->drugUnit()->associate($request->unit_id);
        
        
        
        if ($drug->save()) {
            $request->session()->flash('success','Drug  has been Saved');
            return redirect()->route('drugs.index');
        }else {
            return redirect()->route('drugs.create');
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
        $drug = Drug::findOrFail($id);
        
        return view('drugs.show')->with('drug',$drug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        

        $drug = Drug::findOrFail($id);

        $units = DrugUnit::all();

        $types = DrugItemType::all();

       


        return view('drugs.edit')
               ->with([
                'drug' => $drug ,
                'units' => $units,
                'types' => $types
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
            'trade_name' => 'required',
            'generic_name' => 'required',
            'item_type_id' => 'required',
            'unit_id' => 'required'
        ]);

        $drug = Drug::findOrFail($id);

        $drug->trade_name = $request->trade_name;
        $drug->generic_name = $request->generic_name;
        $drug->drugItemType()->associate($request->item_type_id);
        $drug->drugUnit()->associate($request->unit_id);
        

        if ($drug->save()) {
            $request->session()->flash('success','Drug  has been Updated');
            return redirect()->route('drugs.edit',$drug->id);
        }else {
            $request->session()->flash('error','Something Wrong Happend');
            return redirect()->route('drugs.edit',$drug->id);
            
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
        
        $drug = Drug::findOrFail($id);
        $drug->delete();

        return redirect()->route('drugs.index');
    }


    public function export() 
    {
        return Excel::download(new DrugExport, 'drugs.xlsx');
    }
}
