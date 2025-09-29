<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public function with_hold_tax_amount()
    {
      $amount=$this->purchase_price;
      $tax=$this->wh_tax;

      $t= round( $tax/100 * $amount ,2);

      return $t;
      
    }

}
