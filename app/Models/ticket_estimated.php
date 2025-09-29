<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_estimated extends Model
{
    use HasFactory;
     protected $table = 'ticket_estimated';

     public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

      public function ticket()
    {

        return $this->belongsTo('App\Models\Ticket','ticket_id');
    }
  public function process()
    {

        return $this->belongsTo('App\Models\Process','stage_id');
    }

    


}
