<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasereturn_ledger extends Model  //for store issuance record
{
    use HasFactory;

    protected $table = 'purchase_return_item';
     
    public function item()
    {
        return $this->belongsTo(inventory::class,'item_id');
    }

    public function purchase_stock()
    {
        return $this->belongsTo(purchase_ledger::class,'purchase_stock_id');
    }


    public function purchasereturn()
    {
        return $this->belongsTo(Purchasereturn::class,'return_id');
    }

    


}
