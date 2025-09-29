<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    use HasFactory;


    public function items()
    {
        return $this->belongsToMany(inventory::class,'grn_inventory','grn_id','item_id')->withPivot('id','variant_id','unit','av_qty','av_rack_qty','qty','rec_quantity','pack_size','unit_weight','unit_feet','rack','rack_qty','loading_sq','approved_qty','rej_quantity','batch_no','mfg_date','exp_date','grn_no','is_active','is_sampled')->withTimestamps();
    }

    public function stock_items()
    {
        return $this->hasMany('App\Models\Stock','grn_id');
    }

    

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function order()
    {
        return $this->belongsTo(Purchaseorder::class,'order_id');
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class,'grn_id','id');
    }

    public function total_quantity()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty'] ;
            //$total += $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
        }

        return $total ;
    }

     public function total_weight()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            
            $total += $item['pivot']['qty'] * $item['pivot']['unit_weight'] ;
        }

        return $total ;
    }




}
