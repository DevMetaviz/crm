<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionStandard extends Model
{
    use HasFactory;

    public function procedure()
    {
        return $this->belongsTo('App\Models\Procedure');
    }

    public function items()
    {
        return $this->belongsToMany(inventory::class,'item_production_standard','std_id','item_id')->withPivot('id','type','is_mf','stage_id','unit','quantity','pack_size','sort_order')->withTimestamps();
    }

    public function standard_items()
    {
        return $this->hasMany(standard_item::class);
    }

    

    public function master_article()
    {

        return $this->belongsTo(inventory::class,'master_article_id');
    }

}
