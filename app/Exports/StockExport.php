<?php

namespace App\Exports;

use App\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class StockExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('stock as s')
                  ->select([
                     's.id', 'd.trade_name','d.generic_name','s.barcode',
                      's.purchasing_price','s.selling_price','s.quantity_per_unit',
                      's.exp' , DB::raw("ROUND (DATEDIFF(s.exp, CURRENT_DATE()) / 30.4167 , 1)  AS rem ")
                  ])
                  ->leftJoin('drugs as d','s.drug_id','=','d.id')
                  ->orderBy('rem' , 'desc')
                  ->get();
    }
}
