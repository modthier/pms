<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payments";

    protected $fillable = [
        'status'
    ];


    public function account()
    {
    	return $this->belongsTo(Account::class);
    }
}
