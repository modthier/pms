<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = "accounts";

    public function payments()
    {
    	return $this->hasMany(Payment::class);
    }
}
