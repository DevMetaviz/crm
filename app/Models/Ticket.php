<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class Ticket extends Model
{
    use HasFactory;
      
    protected $appends = ['total_production','stock_current_qty'];

    public function estimated_material()
    {
        return $this->belongsToMany(inventory::class,'ticket_estimated','ticket_id','item_id')->withPivot('id','type','is_mf','assay','grn_no','qc_no','stage_id','unit','std_qty','quantity','pack_size','sort_order')->withTimestamps();
    }

     public function raw_material()
    {
        return $this->ticket_estimated->where('type','raw');
    }
 public function packing_material()
    {
        return $this->ticket_estimated->where('type','packing');
    }

    public function get_std_id()
    {
        return 0;
        $i=$this['plan']['products']->where('pivot.product_id',$this['inventory_id'])->first();
        return $i['pivot']['std_id'];
    }


    public function ticket_estimated()
    {
        return $this->hasMany(ticket_estimated::class);
    }

    public function plan()
    {
        return $this->belongsTo(Productionplan::class,'plan_id');
    }

    public function getProcedure()
    {
      //$prod=$this['plan']['products']->where('pivot.product_id',$this['inventory_id'])->first();
      //$std=ProductionStandard::find($prod['pivot']['std_id']);
      $procedure_id=inventory::find($this['inventory_id'])->procedure_id;
      $procedure=Procedure::with('processes','processes.sub_stages')->find($procedure_id);
       return $procedure;
    }



    public function product()
    {
        return $this->belongsTo(inventory::class,'inventory_id');
    }

    public function productions()
    {
        return $this->hasMany(Production::class,'ticket_id','id');
    }

    public function getTotalProductionAttribute()
    {
      return $this->productions->sum(function($t){ 
               return $t->qty * $t->pack_size; 
            });
    }

     public function getAvailQty()
    {
      return 0;
       $let=$this->plan->products->where('id',$this->inventory_id)->first();
          $total_available_qty=$let['pivot']['quantity'];

       $made_qty=Ticket::where('plan_id','like',$this->plan_id)->where('inventory_id','like',$this->inventory_id)->sum('quantity');
                $rem_qty=$total_available_qty-$made_qty;

                      $rem_qty+=$this->quantity;
             return $rem_qty;
      }


    public function getStockCurrentQtyAttribute()
    {
        $in_qty=$this->total_production;
              

        $challans=outgoing_stock::where('item_id',$this->inventory_id)->where('batch_no',$this->batch_no)->sum(\DB::raw('qty * pack_size'));
                
                
                
        $sale_return=salereturn_ledger::where('item_id',$this->inventory_id)->where('batch_no',$this->batch_no)->sum(\DB::raw('qty * pack_size'));



        $rem=$in_qty + $sale_return - $challans ;

       

        return $rem;
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class,'batch_no','batch_no');
    }

    public function issuances()
    {
        return $this->hasMany(Issuance::class,'batch_no','batch_no');
    }

    public function issued_items()
    {
        return $this->hasManyThrough( item_issuance::class , Issuance::class);
    }

    public function item_issued_qty($item_id,$stage_id='-1')
    {
        $t=0;
        foreach ($this->issuances as $issue) {
          foreach ($issue->item_list->where('item_id',$item_id) as $key ) {
            $q=$key['quantity'] * $key['pack_size'];
            $t= $t + $q;
          }
        }
        return $t;
    }



    public function stages()
    {
        return $this->belongsToMany(Process::class,'ticket_process','ticket_id','process_id')->withPivot('id','type','super_id','is_performed')->withTimestamps();
    }


    public function getTicketProcessesold()
    {
        $plan_product=$this->plan->products->where('id','like',$this->product->id)->first();
        $std_id=$plan_product['pivot']['std_id'];
        //$this->product;
        //print_r(json_encode($plan_product));die;
         //$std_id=$this->product->pivot->std_id;
        $std_stages=ProductionStandard::find($std_id)->procedure->processes;

        //stages
          
                
                $stages=array();
        foreach ($std_stages as $stg ) {

            $parameters=array();
        foreach ($stg->parameters as $key) {
            $parameter=array('id'=>$key['id'],'name'=>$key['name'],'sort_order'=>$key['pivot']['sort_order']);
            array_push($parameters, $parameter);
        }
          $sort_col  = array_column($parameters, 'sort_order');
          array_multisort($sort_col,SORT_ASC,$parameters);
          //$parameters->orderBy('sort_order');   
        $stage=array('id'=>$stg['id'],'process_name'=>$stg['process_name'],'sort_order'=>$stg['pivot']['sort_order'],'qc_required'=>$stg['pivot']['qc_required'],'parameters'=>$parameters);
            array_push($stages, $stage);
        }
        //end stages
      
      //print_r(json_encode($stages));die;
        return $stages;
    }

    public function getTicketProcesses()
    {
      $super_processes=ticket_process::where('ticket_id',$this->id)->where('super_id',0)->get();
      $processes=array();
        foreach ($super_processes as $super) {

        $process_parameters=ticket_parameter::where('ticket_process_id',$super['id'])->get();
        $parameters=array();
        foreach ($process_parameters as $key ) {
            $parameter=array('id'=>$key['parameter_id'],'name'=>$key['parameter_name'],'sort_order'=>$key['sort_order'],'value'=>$key['value']);
            array_push($parameters, $parameter);
        }
        
         $sub_processes=$this->getTicketSubProcesses($super['id']);

            $process=array('id'=>$super['id'],'super_id'=>$super['super_id'],'process_name'=>$super['process_name'],'sort_order'=>$super['sort_order'],'qc_required'=>$super['qc_required'],'parameters'=>$parameters,'sub_processes'=>$sub_processes);
            array_push($processes, $process);
        }

        return $processes;
    }

    public function getTicketSubProcesses($sub_process_id)
    {
      $super_processes=ticket_process::where('super_id',$sub_process_id)->get();
      $processes=array();
        foreach ($super_processes as $super) {

        $process_parameters=ticket_parameter::where('ticket_process_id',$super['id'])->get();
        $parameters=array();
        foreach ($process_parameters as $key ) {
            $parameter=array('id'=>$key['parameter_id'],'name'=>$key['parameter_name'],'sort_order'=>$key['sort_order'],'value'=>$key['value']);
            array_push($parameters, $parameter);
        }
        
         $sub_processes=array();

         $let_sub_processes=ticket_process::where('super_id',$super['id'])->get();
         if(count($let_sub_processes)!=0)
         {
            $sub_processes=$this->getTicketSubProcesses($super['id']);
         }

            $process=array('id'=>$super['id'],'super_id'=>$super['super_id'],'process_name'=>$super['process_name'],'sort_order'=>$super['sort_order'],'qc_required'=>$super['qc_required'],'parameters'=>$parameters,'sub_processes'=>$sub_processes);
            array_push($processes, $process);
        }

        return $processes;
    }

    //  public function processes()
    // {
    //     return $this->belongsToMany(Process::class,'ticket_process','ticket_id','process_id')->withPivot('process_name','sort_order','qc_required')->withTimestamps();
    // }

    //  public function sub_processes()
    // {
    //     return $this->belongsToMany(Process::class,'ticket_sub_process','ticket_process_id','sub_process_id')->withPivot('process_name','sort_order','qc_required')->withTimestamps();
    // }

    //  public function parameters()
    // {
    //     return $this->belongsToMany(Parameter::class,'ticket_parameter','ticket_id','parameter_id')->withPivot('stage_id','unit','quantity','pack_size')->withTimestamps();
    // }

     public function opening_qty($from='')
    {   

      if($from == '')
      {
       
              return 0;
           
           
      }
      else
      {   
         $qty=$this->closing_qty( date('Y-m-d', strtotime($from. '-1 days')) );
           return $qty;   
      }
    }

    public function closing_qty($to='')
    {
       


                $sale_qty = outgoing_stock::where('item_id',$this->inventory_id)->where('batch_no',$this->batch_no)->whereHas('challan', function($q) use($to){

                if($to!='')
                  { $q->where('challan_date', '<=', $to); }
                    $q->where('activeness','1');

                })->get()->sum(function($t){ 
              
             return $t->qty * $t->pack_size;

                  });

        
           
                $sale_return_qty=salereturn_ledger::where('item_id',$this->inventory_id)->where('batch_no',$this->batch_no)->whereHas('sale_return', function($q) use($to){
               
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));



              $production=$this->productions()->where(function($q) use($to){

         

            if($to!='')
                $q->where('production_date','<=',$to);

               })->where('activeness','1')->sum(\DB::raw('qty * pack_size'));
        
          //print_r(json_encode($production));die;


        $rem=$production + $sale_return_qty - $sale_qty ;

       $rem= round($rem,3);

       return $rem;
    }


    public function stock_detail($from='',$to='')
    {
            
       $opening_qty=$this->opening_qty( $from );
       $closing_qty=$this->closing_qty( $to );

        $sale_qty = outgoing_stock::where('item_id',$this->inventory_id)->where('batch_no',$this->batch_no)->whereHas('challan', function($q) use($from,$to){

                  if($from!='')
                  { $q->where('challan_date', '>=', $from); }

                if($to!='')
                  { $q->where('challan_date', '<=', $to); }
                    $q->where('activeness','1');

                })->sum(\DB::raw('qty * pack_size'));

        
           
                $sale_return_qty=salereturn_ledger::where('item_id',$this->inventory_id)->where('batch_no',$this->batch_no)->whereHas('sale_return', function($q) use($from,$to){
                if($from!='')
                  $q->where('doc_date', '>=', $from);
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));

              $production=$this->productions()->where(function($q) use($from,$to){

              if($from!='')
                $q->where('production_date','>=',$from);

            if($to!='')
                $q->where('production_date','<=',$to);

               })->where('activeness','1')->sum(\DB::raw('qty * pack_size'));



        //$rem=$in_qty + $add_adjustment - $issue_qty -$purchase_return_qty - $less_adjustment;

      

       $stock=array('opening_qty'=>$opening_qty,'dc_qty'=>$sale_qty,'sale_return_qty'=>$sale_return_qty,'production'=>$production,'closing_qty'=>$closing_qty);

        //$amount = outgoing_stock::select(outgoing_stock::raw('sum(quantity * pack_size) as total'))->first();

        return $stock;
    }


}
