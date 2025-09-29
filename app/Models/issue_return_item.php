<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class issue_return_item extends Model
{
    use HasFactory;

    protected $table = 'issue_return_items';

    protected $appends =['rate'];
     
    public function item()
    {
        return $this->belongsTo(inventory::class,'item_id');
    }

    public function issue_item()
    {
        return $this->belongsTo(item_issuance::class,'issue_item_id');
    }

    public function return()
    {
        return $this->belongsTo(issue_return::class,'issue_return_id');
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
