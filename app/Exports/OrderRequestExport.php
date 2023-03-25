<?php

namespace App\Exports;

use App\OrderRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderRequestExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrderRequest::all();
    }
}
