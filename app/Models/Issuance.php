<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    use HasFactory;

     public function items()
    {
        return $this->belongsToMany(inventory::class,'item_issuance','issuance_id','item_id')->withPivot('id','request_item_id','grn_no','batch_no','qc_no','stage_id','unit','req_quantity','quantity','pack_size')->withTimestamps();
    }

    public function item_list()
    {
        return $this->hasMany(item_issuance::class , 'issuance_id' , 'id');
    }

    public function returns()
    {
        return $this->hasMany(issue_return::class , 'issuance_id' , 'id');
    }

    public function department()
    {
        return $this->belongsTo(InventoryDepartment::class,'department_id');
    }

    public function plan()
    {
        return $this->belongsTo(Productionplan::class,'plan_id');
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class,'requisition_id');
    }

    public function ticket()
    {
             return $this->belongsTo('App\Models\Ticket','batch_no','batch_no');
    }

    public function issuance_item()
    {
             return $this->hasMany('App\Models\item_issuance','issuance_id','id');
    }


    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }


}
