<?php

namespace App\Exports;

use App\PurchaseOrders;
use Maatwebsite\Excel\Concerns\FromCollection;

class PurchaseOrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PurchaseOrders::all();
    }
}
