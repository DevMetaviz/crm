<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item_issuance extends Model  //for store issuance record
{
    use HasFactory;

    protected $table = 'item_issuance';

    protected $appends =['rate'];
     
    public function item()//for master article in standard
    {
        return $this->belongsTo(inventory::class,'item_id');
    }

    public function request_item()//for master article in standard
    {
        return $this->belongsTo(requisition_item::class,'request_item_id');
    }

    public function issuance()//for master article in standard
    {
        return $this->belongsTo(Issuance::class,'issuance_id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class,'grn_no','grn_no');
    }

    public function getRateAttribute()
    {
        $rate=0;

              if($this->grn_no!='')
              {
                // $purchase=$this->stock->grn->purchase;
                // $item=$purchase->items->where('id',$this->item_id)->first();
                // $rate=$purchase->rate($this->item_id,$item['pivot']['id']);
                $rate=$this->stock->rate;
              }

      return $rate;
    }


}
