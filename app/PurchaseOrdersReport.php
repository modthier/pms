<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cyberduck\LaravelExcel\Contract\SerialiserInterface;
use App\PurchaseOrders;

class PurchaseOrdersReport implements  SerialiserInterface
{
    public function getData($data)
    {
        $row = [];

        $row[] = $data->trade_name;
        $row[] = (double) $data->total_price;
        $row[] = (int) $data->total_quantity;

        return $row;
    }

    public function getHeaderRow()
    {
        return [
            
            'Trade Name',
            'Total Price',
            'Total Quantity'
        ];
    }
}
