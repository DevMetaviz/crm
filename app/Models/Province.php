<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(country::class,'country_id','id');
    }

   

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function territories()
    {
        return $this->hasMany(Territory::class);
    }

    public static function active_provinces()
    {
        
        
        $provinces = Province::where('status','like','1')->orderBy('sort_order', 'asc')->get();

        return $provinces;        
    }


}
