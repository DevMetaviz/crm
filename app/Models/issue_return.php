<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class issue_return extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'issue_return_items','issue_return_id','item_id')->withPivot('id','issue_item_id','grn_no','stage_id','unit','qty','pack_size')->withTimestamps();
    }

    public function item_list()
    {
        return $this->hasMany(issue_return_item::class , 'issue_return_id' , 'id');
    }

    public function department()
    {
        return $this->belongsTo(InventoryDepartment::class,'department_id');
    }

    public function plan()
    {
        return $this->belongsTo(Productionplan::class,'plan_id');
    }

    public function issuance()
    {
        return $this->belongsTo(Issuance::class,'issuance_id');
    }

    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }
}
