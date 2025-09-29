<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;

    public function provinces()
    {
        return $this->hasMany(Province::class,'country_id');
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

    public static function active_countries()
    {
        
        
        $countries = country::where('status','1')->orderBy('sort_order', 'asc')->get();

        return $countries;        
    }



}
