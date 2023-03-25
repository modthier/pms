<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cyberduck\LaravelExcel\Contract\SerialiserInterface;
use App\PurchaseOrders;

class SalesReport implements  SerialiserInterface
{
    public function getData($data)
    {
        $row = [];

        $row[] = $data->trade_name;
        $row[] = (double) $data->price;
        $row[] = (int) $data->quantity;
        $row[] = $data->created_at;

        return $row;
    }

    public function getHeaderRow()
    {
        return [
            
            'Trade Name',
            'Total Price' ,
            'Quantity',
            'Created_At'
        ];
    }
}
