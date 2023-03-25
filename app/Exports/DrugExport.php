<?php

namespace App\Exports;

use App\Drug;
use Maatwebsite\Excel\Concerns\FromCollection;

class DrugExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Drug::all();
    }
}
