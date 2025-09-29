<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(country::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

     public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function territories()
    {
        return $this->hasMany(Territory::class);
    }


}
