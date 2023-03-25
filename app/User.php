<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active' , 'shift_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userShift()
    {
       return $this->belongsTo(Shift::class,'shift_id');
    }


    public function OrderRequests()
    {
        return $this->hasMany(OrderRequest::class);
    }


    public function purchaseOrder()
    {
        return $this->hasMany(PurchaseOrders::class);
    }


    public function shifts()
    {
        return $this->belongsToMany(Shift::class)
        ->withPivot('loggedout_at')
        ->withTimeStamps()->orderBy('created_at','desc');
    }


    public function returnedItems()
    {
        return $this->hasMany(ReturnedItems::class);
    }


    public function requests()
    {
        return $this->hasMany(UserRequest::class);
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function hasRole ($role)
    {
        if ($this->role()->where('name',$role)->first()) {
            return true;
        }

        return false;
    }


    
}
