<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugOrder extends Model
{
    protected $table = "drug_orders";

    protected $guarded = [];
    public function user()
    {
    	return $this->blongsTo(User::class);
    }
}
