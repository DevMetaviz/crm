<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class,'role_user');
    }

    public function rights()
    {
        return $this->belongsToMany(Right::class,'role_right','role_id','right_id')->withTimestamps();
    }

    



}
