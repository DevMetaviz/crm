<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDepartment extends Model
{
    use HasFactory;

    public function inventories()
    {
        return $this->hasMany('App\Models\inventory','department_id');
    }


    public function demands()
    {
        return $this->hasMany('App\Models\Purchasedemand','department_id');
    }


    public function requisitions()
    {
             return $this->hasMany('App\Models\Requisition','department_id');
    }

    public function issuances()
    {
             return $this->hasMany('App\Models\Issuance','department_id');
    }

    public static function departments_with_items()
    {
        $departs=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->select('id','name')->get();

      $departments=[];
       foreach ($departs as $dpt) {
         
         
             
         $its=inventory::where('department_id',$dpt['id'])->where('status','like','1')->get();
            $items=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom];

             array_push($items, $it);
         }

         $dt=['id'=>$dpt['id'],'name'=>$dpt['name'],'items'=>$items];

         array_push($departments, $dt);
       }

       return $departments;
    }

    public static function departments_with_items_with_qty($criteria='')
    {   
        $grs=[]; $batches='';
        if(isset($criteria['grs']))
           { $grs=$criteria['grs'];   }
            
        $departs=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->select('id','name')->get();

      $departments=[];
       foreach ($departs as $dpt) {
         
         
             
         $its=inventory::where('department_id',$dpt['id'])->where('status','like','1')->get();
            $items=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];
                
                $qty=$key->closing_stock();
                  $batches=$key['batches'];
                  

                   // if($grns==0)
                   // {
                   //  $grns=$key['grns']; 
                   //    }
                  // else
                  // {
                     $grns=$key->getCurrentGrnsExcept($grs);
                  // }
//print_r($grns);die;

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom , 'qty'=>$qty,'batches'=>$batches , 'grns'=>$grns];

             array_push($items, $it);
         }

         $dt=['id'=>$dpt['id'],'name'=>$dpt['name'],'items'=>$items];

         array_push($departments, $dt);
       }

       return $departments;
    }
    
}
