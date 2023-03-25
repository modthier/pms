<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cyberduck\LaravelExcel\Contract\SerialiserInterface;
use App\OrderRequest;

class InsuranceReport implements  SerialiserInterface
{
    public function getData($data)
    {
        $row = [];

        $row[] = $data->name;
        $row[] = (double) $data->deduct_rate."%";
        if($data->price_value){
            $row[] = (double) ($data->deduct_value - $data->added_value);
        }else {
            $row[] = (double) $data->deduct_value;
        }
       
        $row[] = (double) $data->claim;
        if($data->price_value){
            $row[] = (double) ($data->deduct_value - $data->added_value) + $data->claim ;
        }else {
            $row[] = (double) $data->deduct_value + $data->claim;
        }
        $row[] = $data->created_at;

        return $row;
    }

    public function getHeaderRow()
    {
        return [
            
            'Name',
            'Deduct Rate' ,
            'Deduct Value',
            'Claim',
            'Actual Price',
            'Created At'
        ];
    }
}