<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cyberduck\LaravelExcel\Contract\SerialiserInterface;
use App\Stock;

class Serialisers implements  SerialiserInterface
{
    public function getData($data)
    {
        $row = [];

        $row[] = $data->id;
        $row[] = $data->drug->trade_name;
        $row[] = $data->drug->generic_name;
        $row[] = $data->barcode;
        $row[] = (double) $data->purchasing_price;
        $row[] = (double) $data->selling_price ;
        $row[] = $data->quantity_per_unit;
        $row[] = $data->exp;

        return $row;
    }

    public function getHeaderRow()
    {
        return [
            'ID',
            'Trade Name',
            'Generic Name',
            'Barcode',
            'Purchasing Price',
            'Selling Price',
            'Quantity Per Unit',
            'Expire Date'
        ];
    }
}
