<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cyberduck\LaravelExcel\Contract\SerialiserInterface;
use App\PurchaseOrders;

class PODetailsReport implements  SerialiserInterface
{
    public function getData($data)
    {
        $row = [];

        $row[] = $data->trade_name;
        $row[] = $data->generic_name;
        $row[] = (double) $data->total_price;
        $row[] = (int) $data->quantity;

        return $row;
    }

    public function getHeaderRow()
    {
        return [
            
            'Trade Name',
            'Generic Name',
            'Total Price' ,
            'Quantity'
        ];
    }
}
