<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\ExpiredStock;
use DB;

class ExpiredStockController extends Controller
{
 	
	public function index()
	{
		$expiredStock =  ExpiredStock::orderBy('created_at','desc')->paginate(20);

		$total_price = DB::table('expired_stocks as es')
				->select(DB::raw('sum(es.expired_quantity * es.purchasing_price) as total_price'))
				->get()->first();

		return view('expiredStock.index',['metaTitle' => 'Expired Stock'])
				->with([
					'expiredStocks' => $expiredStock ,
					'total_price' => $total_price->total_price
				]);
	}

    public function moveToExpiry(Stock $stock)
    {
    	

    	$expiredStock = new ExpiredStock;

    	$data = [
    	   'stock_id' => $stock->id ,
    	   'expired_quantity' => $stock->quantity_per_unit,
		   'purchasing_price' => $stock->purchasing_price
    	];

		

		$expiredStock->create($data);   
		
		$q = 0;

    	$stock->update([
    		'quantity_per_unit' => $q
    	]); 	

    	return redirect()->route('expiredStock.index');
    }


    public function returnTostock($id)
    {

    	$expiredStock =  ExpiredStock::findOrFail($id);
    		
    	$stock = Stock::findOrFail($expiredStock->stock_id);

    	$stock->update([
    		'quantity_per_unit' => $expiredStock->expired_quantity
    	]);

    	ExpiredStock::destroy($id); 

    	return redirect()->route('expiredStock.index');
    }
}
