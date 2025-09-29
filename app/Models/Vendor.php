<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function vendor_type()
    {
        return $this->belongsTo(VendorType::class,'vendor_type_id','id');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    
    public function purchaseorders()
    {
        return $this->hasMany('App\Models\Purchasedemand');
    }
    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase');
    }

    public function purchasereturns()
    {
        return $this->hasMany('App\Models\Purchasereturn');
    }
}
