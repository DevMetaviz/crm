<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;


     protected $fillable = [
        'hr_gol_marketing',
        'hr_gol_all',
        'hr_gol_special',
        'hr_sqr_marketing',
        'hr_sqr_all',
        'hr_sqr_special',
        'cr_marketing1',
        'cr_all1',
        'cr_special1',
        'cr_marketing2',
        'cr_all2',
        'cr_special2',
        'ss_gol_marketing',
        'ss_gol_all',
        'ss_gol_special',
        'ss_sqr_marketing',
        'ss_sqr_all',
        'ss_sqr_special',
        'user_id',
    ];

   

    

}
