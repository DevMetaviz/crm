<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requisition_item extends Model  //for store issuance record
{
    use HasFactory;

    protected $table = 'inventory_requisition';

    protected $appends = ['issued_qty'];
     
    public function item()
    {
        return $this->belongsTo(inventory::class,'item_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class,'stage_id');
    }

    public function Requisition()
    {
        return $this->belongsTo(Requisition::class,'requisition_id');
    }

    public function getIssuedQtyAttribute()
    {
      $requisition_id=$this->requisition_id;

      return 0;
    }

    




    


}
