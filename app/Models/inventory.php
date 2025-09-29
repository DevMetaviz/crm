<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    use HasFactory;

    
   // protected $appends =['current_stock','batches','grns','lpr'];

     //protected $appends = ['department_name','packs','colors','uom'];

     // protected $hidden = ['packings', 'color_ids', 'department'];

    protected $appends = ['category_name','full_name'];



    public function getFullNameAttribute()
    {
        return $this->item_code.' '.$this->item_name;
    }

    public function getDepartmentNameAttribute()
    {
        return $this->department ? $this->department->name : null;
    }
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : null;
    }
    
    public function getColorsAttribute()
    {
    //return $this->hasMany('App\Models\InventoryColor', 'id', 'color_ids')
      //  ->whereIn('id', explode(',', $this->color_ids));

        $ids = array_filter(explode(',', $this->color_ids));

    return InventoryColor::select('id','name')->whereIn('id', $ids)->orderBy('name')->get();

   }

     public function getPacksAttribute ()
    {

        //return $this->hasMany('App\Models\Packings','item_id');

        $ids = array_filter(explode(',', $this->packings));

         return  $ids;
    }

     public function getUomAttribute()
    {
        return $this->unit ? $this->unit->name : null;
    }

      public static function getItems($config=[])
    {

        
         //$items = inventory::select('id','department_id','item_name','item_code','packings','color_ids')->where('status','1')->orderBy('id','desc')->get();
          
       

        $query = inventory::where('status', '1');

            if (isset($config['minimum_qty']) && $config['minimum_qty'] == 1) {
                $query->where('minimal','>', 0);
                      
            }

            if (isset($config['category_id']) && $config['category_id'] > 0) {
                $query->where('category_id', $config['category_id']);
                      
            }

        $items=$query->orderBy('item_name','asc')->get();


        $items->map(function ($item) use ($config) {
        if (isset($config['minimum_qty']) && $config['minimum_qty'] == 1) {
            $item->closing_qty = $item->closing_stock(); // add as extra property
        }
        return $item;
    });


         if (isset($config['minimum_qty']) && $config['minimum_qty'] == 1) {
        $items = $items->filter(function ($item) {
            return $item->closing_qty < $item->minimal;
        });
    }

         return $items;

        /*return self::where('status', '1')
            ->orderBy('item_name', 'asc')
            ->get()
            ->map(function ($it) {
                return [
                    'id'              => $it->id,
                    'category_id'   => $it->category_id,
                    'item_name'       => $it->item_name,
                    'item_code'       => $it->item_code,
                    'department_name' => $it->department_name,
                    'packs'           => $it->packs,
                    //'colors'          => $it->colors,
                    //'uom'          => $it->uom,
                ];
            });*/
    }

    public static function getVariantItems_old()
{
    $items = self::where('status', '1')
        ->orderBy('item_name', 'asc')
        ->get();

    $variants = collect();

    foreach ($items as $it) {
        $packs = $it->packs;
        $colors = $it->colors;

        if ($colors && count($colors) > 0) {
            // Add each color variant
            foreach ($colors as $color) {
                $variants->push([
                    'id'              => $it->id,
                    'department_id'   => $it->department_id,
                    'item_name'       => $it->item_name,
                    'item_code'       => $it->item_code,
                    'department_name' => $it->department_name,
                    'packs'           => $packs,
                     'uom'          => $it->uom,
                    'color_id'        => $color->id,
                    'color'           => $color->name,
                ]);
            }
        } else {
            // No colors → add a single null color row
            $variants->push([
                'id'              => $it->id,
                'department_id'   => $it->department_id,
                'item_name'       => $it->item_name,
                'item_code'       => $it->item_code,
                'department_name' => $it->department_name,
                'packs'           => $packs,
                    'uom'          => $it->uom,
                'color_id'        => null,
                'color'           => null,
            ]);
        }
    }

    return $variants->values();
}

 public static function getVariantItems($config=[])
{
    $let_items = self::where('status', '1')
        ->orderBy('item_name', 'asc')
        ->get();

    $items = collect();

    foreach ($let_items as $it) {
        $packs = $it->packs;
        $variants = $it->variants;

        if ($variants && count($variants) > 0) {
            // Add each color variant
            foreach ($variants as $variant) {  
                $items->push([
                    'id'              => $it->id,
                    'department_id'   => $it->department_id,
                    'item_name'       => $it->item_name,
                    'item_code'       => $it->item_code,
                    'department_name' => $it->department_name,
                    'mrp'       => $it->mrp,
                    'packs'           => $packs,
                     'uom'          => $it->uom,
                     'variant_id'     => $variant->id,
                     'variant_items'  => $variant->get_variant_items(),
                ]);
            }
        } else {
            // No colors → add a single null color row
            $items->push([
                'id'              => $it->id,
                'department_id'   => $it->department_id,
                'item_name'       => $it->item_name,
                'item_code'       => $it->item_code,
                'department_name' => $it->department_name,
                'mrp'       => $it->mrp,
                'packs'           => $packs,
                    'uom'          => $it->uom,
                'variant_id'        => 0
                
            ]);
        }
        
       
    }

    return $items->values();
}

 public function department()
    {

        return $this->belongsTo('App\Models\InventoryDepartment');
    }
     public function sub_category()
    {
        return $this->belongsTo('App\Models\InventoryType','sub_category_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\InventoryCategory');
    }


    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function variants()
    {

        return $this->hasMany('App\Models\Variant','item_id');
    }

    public function getVariants($variant_id)
    {
            $variant=Variant::find($variant_id);

           $variants=[];
             if(isset($variant['id']))
            $variants=$variant->get_variant_items();

        return $variants;   
         }

/*********/


public function grnItems()
    {
        return $this->hasMany(Stock::class, 'item_id');
    }

    public function deliveryItems()//outgoing_stock_list
    {
        return $this->hasMany(outgoing_stock::class, 'item_id');
    }

    // Closing Qty (total stock)
    public function closingStock()
    {
        $in = $this->grnItems()->sum('qty');
        $out = $this->outgoing_stock_list()->sum('qty');


        return $in - $out;
    }

    // Rack wise closing stock
public function closingStockByRack()
{
    $racks = [];

    // 1) Add GRNs (in)
    foreach ($this->grnItems()->whereHas('grn', fn($q) => $q->where('status','1'))->get() as $row) {
        $rackList = explode(',', $row->rack);
        $qtyList  = explode(',', $row->rack_qty);

        foreach ($rackList as $i => $rack) {

             $rack=trim($rack);
            $qty = (int)($qtyList[$i] ?? 0);
            $racks[$rack] = ($racks[$rack] ?? 0) + $qty;
        }
    }

    // 2) Subtract Deliveries (out)
    foreach ($this->deliveryItems()->whereHas('challan', fn($q) => $q->where('status','1'))->get() as $row) {
        $rackList = explode(',', $row->rack);
        $qtyList  = explode(',', $row->rack_qty);

        foreach ($rackList as $i => $rack) {
            $rack=trim($rack);

            $qty = (int)($qtyList[$i] ?? 0);
            $racks[$rack] = ($racks[$rack] ?? 0) - $qty;
        }
    }

    return array_filter($racks, fn($q) => $q != 0);
}

public function getQtyWithRack()
    {
          $info=[];
   
    
    
   
      $rackStock = $this->closingStockByRack();

                               //$rack = implode(',', array_keys($rackStock));     
                                 //$rack_qty = implode(',', array_values($rackStock));
      $rack_qty=[]; $rack_qty_txt='';

      foreach($rackStock as $key=>$val){

       $rack_qty[] = $key.'='.$val;   

      }

      if(count($rack_qty)>0)
      $rack_qty_txt=implode(',' , $rack_qty);

     $qty = $this->closingStock();

        $info['total_qty']=$qty;

           
           
        $info['rack_qty']=$rack_qty_txt;


    return $info;
        

  }


/**********/
    public function item_opening(){

      if($this->stock_id=='')
        return 0;

      //$stock=Stock::where('grn_id',0)->where('item_id',$this->id)->first();

      $stock=Stock::find($this->stock_id);

      return $stock;

    }

    public function grn_stocks()
    {

        return $this->hasMany('App\Models\Stock','item_id');
    }



    

    public function packings1()
    {

        //return $this->packings()->select('packing')->orderBy('packing','asc')->get()->pluck('packing')->toArray();
    }



    
    

    public function account()
    {

        return $this->belongsTo('App\Models\Account','account_id');
    }

    public function cgs_account()
    {

        return $this->belongsTo('App\Models\Account','cgs_account_id');
    }

    public function sale_account()
    {

        return $this->belongsTo('App\Models\Account','sale_account_id');
    }

   
    public function gtin()
    {

        return $this->belongsTo('App\Models\Gtin','gtin_id');
    }

    

    public function small_unit()
    {
        return $this->belongsTo('App\Models\Unit','small_unit_id');
    }

    public function origin()
    {
        return $this->belongsTo('App\Models\Origin');
    }

    public function size()
    {
        return $this->belongsTo('App\Models\InventorySize');
    }

    public function gage()
    {
        return $this->belongsTo('App\Models\Gage');
    }

    public function shape()
    {
        return $this->belongsTo('App\Models\Shape');
    }

    /*public function color()
    {
        //return $this->belongsTo('App\Models\InventoryColor');
    }*/

    public function procedure()
    {

        return $this->belongsTo('App\Models\Procedure','procedure_id');
    }

    
    

    public function purchase_demands()
    {
        return $this->belongsToMany(Purchasedemand::class,'inventory_purchasedemand')->withPivot('unit','quantity','pack_size')->withTimestamps();
    }

    public function purchase_orders()
    {
        return $this->belongsToMany(Purchaseorder::class,'inventory_purchaseorder')->withPivot('unit','quantity','pack_size','current_rate','pack_rate','discount','tax')->withTimestamps();
    }

    public function receivings()
    {
        return $this->belongsToMany(Grn::class,'grn_inventory','item_id','grn_id')->withPivot('unit','quantity','rec_quantity','pack_size','approved_qty','rej_quantity','batch_no','mfg_date','exp_date','grn_no')->withTimestamps();
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class,'inventory_purchase')->withPivot('stock_id','unit','quantity','pack_size','current_rate','pack_rate','discount','tax')->withTimestamps();
    }

    public function purchase_list()
    {
        return $this->hasMany(purchase_ledger::class,'item_id','id');
    }

    public function getLprAttribute()
    { 
      //$lpr=0;
      return $this->last_purchase_rate();
    }

    public function last_purchase_rate()
    {    
       

      $rate=0;

          if(isset($this->purchase_list->sortByDesc('invoice.doc_date')->first()->rate) )
            $rate=$this->purchase_list->sortByDesc('invoice.doc_date')->first()->rate;

         return $rate;
    }

    public function purchasereturns()
    {
        return $this->belongsToMany(Purchasereturn::class,'purchase_return_item','item_id','return_id')->withPivot('purchase_stock_id','unit','p_qty','quantity','pack_size','current_rate','pack_rate','discount','tax')->withTimestamps();
    }

    public function production_standards()
    {
        return $this->belongsToMany(ProductionStandard::class,'item_production_standard','item_id','std_id')->withPivot('type','stage_id','unit','quantity','pack_size','sort_order')->withTimestamps();
    }

    public function plans()
    {
        return $this->hasMany(Productionplan::class,'product_id');
    }

    public function production_plans()
    {
        return $this->belongsToMany(Productionplan::class,'plan_product','product_id','plan_id')->withPivot('std_id','unit','quantity','pack_size')->withTimestamps();
    }

    public function yields()
    {
      return $this->hasManyThrough(Goods_Yield::class, Productionplan::class,'product_id','plan_id','id','id');
    }

    public function adjustments()
    {
        return $this->belongsToMany(Stockadjustment::class,'adjustment_item','item_id','adjustment_id')->withPivot('grn_no','batch_no','type','unit','qty','pack_size','rate')->withTimestamps();
    }

    

    public function total_quantity()
    {
           $total=0;

        if($this->item_opening()!=0)
        $total=$this->item_opening()->approved_qty;

            foreach ($this->grns as $grn) {
                 
                 $app_qty=$grn['pivot']['approved_qty'];
                 $rec_qty=$grn['pivot']['rec_quantity'];
                 $rej_qty=$grn['pivot']['rej_quantity'];
                 $pack_size=$grn['pivot']['pack_size'];
                 $gross_qty=$rec_qty-$rej_qty;
                 $total_qty=$app_qty * $pack_size;

                 $total +=$total_qty ;

                 }

                 return $total; 

    }

     public function master_production_standards()//for master article in standard
    {
        return $this->hasMany(ProductionStandard::class,'master_article_id','id');
    }

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class,'ticket_estimated','item_id','ticket_id')->withPivot('type','assay','grn_no','qc_no','stage_id','unit','std_qty','quantity','pack_size','sort_order')->withTimestamps();
        
    }

    



    // public function productions()
    // {
    //     return $this->hasMany(Production::class,'item_id');
    // }

    public function product_tickets()
    {
        return $this->hasMany(Ticket::class,'inventory_id');
    }

    public function open_tickets()
    {
        return $this->hasMany(Ticket::class,'inventory_id')->where('batch_close','0');
    }

     public function requisitions()
    {
        return $this->belongsToMany(Requisition::class,'inventory_requisition','item_id','requisition_id')->withPivot('stage_id','unit','quantity','approved_qty','pack_size')->withTimestamps();
    }

    public function issuances()
    {
        return $this->belongsToMany(Issuance::class,'item_issuance','item_id','issuance_id')->withPivot('id','grn_no','batch_no','stage_id','unit','req_quantity','quantity','pack_size')->withTimestamps();
    }

    public function item_issuances()
    {
      return $this->hasMany(item_issuance::class,'item_id','id');
      
    }

    public function item_issue_returns()
    {
      return $this->hasMany(issue_return_item::class,'item_id','id');
      
    }

    public function quantity_status2($from='' , $to='')
    {
        
    }

    public function quantity_status1($stock='' )
    {
        
    }

    public function quantity_status( )
    {
        $status='';
        $closing_stock=$this->closing_stock();
        $minimal=$this->minimal;
        $optimal=$this->optimal;
        $maximal=$this->maximal;

        if($minimal=='')
          $minimal=0;
        if($maximal=='')
          $minimal=0;
        if($optimal=='')
          $optimal=0;

        $optimal1=($optimal - $minimal) / 6;
           
        $optimal2=($maximal - $optimal) / 6;

            if($closing_stock <= $minimal )
                 $status='minimal';
            elseif($closing_stock >= $maximal )
                 $status='maximal';
          
          return $status;
    }

    public function item_available_balance($from='',$to='')
    {
        $records=$this->item_history($from,$to);
          
          $count=count($records);
           
           $balance=0;
           if($count>0)
          $balance=$records[$count-1]['balance'];

          return $balance;

    }

    public function getCurrentStockAttribute()
    {
        $total=$this->closing_stock();
          
          

          return $total;

    }


    public function closing_stock($criteria=[])
    {
      $to=''; $batch_no=''; $grn_no='';
            
         // print_r($criteria);die;
            if(isset($criteria['to']))
              $to=$criteria['to'];

            if(isset($criteria['grn_no']))
              $grn_no=$criteria['grn_no'];

            if(isset($criteria['batch_no']))
              $batch_no=$criteria['batch_no'];

            //if grn_no has that batch_no also
             $batches=Stock::where('item_id',$this->id)->where('batch_no',$batch_no)->select('grn_no')->distinct()->pluck('grn_no')->toArray();


      $opening=$this->item_opening();

      $open_value=0;

          if(isset($opening->approved_qty))
                {  
                  
                  if($grn_no!='')
                  {if($opening->grn_no==$grn_no)
                  $open_value=$opening['approved_qty'];}
                  elseif($batch_no!='')
                  {if($opening->batch_no==$batch_no)
                  $open_value=$opening['approved_qty'];}
                  else
                    $open_value=$opening['approved_qty'];

                  }

            $grn_stocks=0; $issuances=0; $issue_return=0; $pros=0; $challans=0;
            $add_adjustment=0; $less_adjustment=0; $purchase_return=0; $sale_return=0;
             
             

           
              // $pros=$this->productions()->where(function($q) use($to,$batch_no){
              // if($to!='')
              //   $q->where('production_date','<=',$to);
              // if($batch_no!='')
              //   $q->where('batch_no',$batch_no);

              //  })->where('status','1')->sum(\DB::raw('qty * pack_size'));
                 
              //    if($this->yield!='')
              //    {
              // $pros=$this->yields->whereHas('plan',function($q) use($batch_no){
              //     if($batch_no!='')
              //      $q->where('batch_no',$batch_no);

              //  })->yield_items()->where(function($q) use($to,$batch_no){
              // if($to!='')
              //   $q->where('transfer_date','<=',$to);
              //  })->sum(\DB::raw('qty * pack_size'));

              //   }


          
                
                   $pros=yield_detail::whereHas('yield.plan',function($q) use ($batch_no){
                    $q->where('product_id',$this->id);
                     if($batch_no!='')
                      $q->where('batch_no',$batch_no);
                   })->where(function($q) use($to){
              if($to!='')
                $q->where('transfer_date','<=',$to);
               })->sum(\DB::raw('qty * pack_size'));

              //    $y=  $it->yields->yield_items->where(function($q) use($to){
              // if($to!='')
              //   $q->where('transfer_date','<=',$to);
              //  })->sum(\DB::raw('qty * pack_size'));

              //print_r(json_encode($y));die;
             

            

              $grn_stocks=Stock::where('item_id',$this->id)->where('is_active','1')->whereHas('grn', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                
                    $q->where('status','1');
                })->where( function($q) use($grn_no,$batch_no){
                if($grn_no!='')
                  { $q->where('grn_no', $grn_no); }
                if($batch_no!='')
                $q->where('batch_no',$batch_no);
              
                })->sum(\DB::raw('qty'));//'approved_qty * pack_size'

                $id=''; $p_id=0;
              if($grn_no!='')
              {
                 $stk=Stock::where('grn_no',$grn_no)->first();
                   if(isset($stk['id']))
                    $id=$stk['id'];
                         
                  if(isset($stk['purchase']['id']))
                    $p_id=$stk['purchase']['id'];
               }


               
              $purchase_return=Purchasereturn_ledger::whereHas('purchasereturn', function($q) use($to){
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                
                $q->where('status',1);
                })->where('item_id',$this->id)->where(function($q) use($grn_no,$p_id){
                    
                    if($grn_no!='')
                     $q->where('purchase_stock_id',$p_id);  

                })->sum(\DB::raw('qty'));//'quantity * pack_size'
//print_r(json_encode( $purchase_return));die;

               //for adjustment
            
                
                  
               $add_adjustment=adjusted_item::whereHas('adjustment', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->where('item_id',$this->id)->where( function($q) use($batches,$batch_no,$grn_no){
                

                if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
               if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
              if($batch_no!='')
                 $q->orWhere('batch_no',$batch_no);

                    
                })->where('type','add stock')->sum(\DB::raw('qty * pack_size'));

                $less_adjustment=adjusted_item::whereHas('adjustment', function($q) use($to){
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('status',1);
                })->where('item_id',$this->id)->where( function($q) use($batches,$batch_no,$grn_no){
                

                if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
                if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
              if($batch_no!='')
                 $q->orWhere('batch_no',$batch_no);

                    
                })->where('type','less stock')->sum(\DB::raw('qty * pack_size'));
                  
        
             

             $challans=$this->outgoing_stock_list()->whereHas('challan', function($q) use($to,$batch_no){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                if($batch_no!='')
                $q->where('batch_no',$batch_no);
                    $q->where('status','1');
                })->sum(\DB::raw('qty')); //'qty * pack_size'
                
                
                
                $sale_return=salereturn_ledger::whereHas('sale_return', function($q) use($to,$batch_no){
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                if($batch_no!='')
                $q->where('batch_no',$batch_no);
                $q->where('status',1);
                })->where('item_id',$this->id)->sum(\DB::raw('qty')); //'qty * pack_size'

              
    
              

                $issuances=$this->item_issuances()->whereHas('issuance', function($q) use($to){
                if($to!='')
                  { $q->where('issuance_date', '<=', $to); }
                    $q->where('issued','1');
                })->where( function($q) use($batches,$batch_no,$grn_no){
                

                if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
               if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
              if($batch_no!='')
                 $q->orWhere('batch_no',$batch_no);

                    
                })->sum(\DB::raw('quantity * pack_size'));

                $issue_return=$this->item_issue_returns()->whereHas('return', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                    $q->where('returned','1');
                })->where( function($q) use($batches,$batch_no,$grn_no){
                

                if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
               if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
              // if($batch_no!='')
              //    $q->orWhere('batch_no',$batch_no);

                    
                })->sum(\DB::raw('qty * pack_size'));


              

          $close=($open_value+$grn_stocks + $pros + $add_adjustment + $sale_return + $issue_return) - ($issuances + $challans+$less_adjustment+$purchase_return);

          //print_r($grn_stocks.' '.$pros.' '.$issuances.' '.$challans);die;

          return round($close,4);

    }

    public function opening_stock($criteria=[])
    {
      $from='';  $batch_no=''; $grn_no='';
            
         // print_r($criteria);die;
            if(isset($criteria['from']))
              $from=$criteria['from'];

            if(isset($criteria['batch_no']))
              $batch_no=$criteria['batch_no'];

            if(isset($criteria['grn_no']))
              $grn_no=$criteria['grn_no'];

        $opening=$this->item_opening();

        $open=0;

      if($from=='')
        {
          if(isset($opening->approved_qty))
                { 
                   if($grn_no!='')
                   {
                       if($opening->grn_no==$grn_no)
                     $open= $opening['approved_qty'];
                     else
                      $open=0;
                   }
                  elseif($batch_no!='')
                  {  if($opening->batch_no==$batch_no)
                     $open= $opening['approved_qty'];
                     else
                      $open=0;
                   }
                  else
                     $open = $opening['approved_qty'];

                    }
          else
          $open= 0;
        }

        else
        {
          $open=$this->closing_stock( ['to'=> date('Y-m-d', strtotime($from. '-1 days')) , 'batch_no'=> $batch_no , 'grn_no'=>$grn_no ]);
        }
 

          return $open;
    }

    
    public function item_history($criteria=[])
    {
          
          $from='';  $to='';
            
            if(isset($criteria['from']))
              $from=$criteria['from']; 
            
        
            if(isset($criteria['to']))
              $to=$criteria['to'];


          $grn_stocks=Stock::where('item_id',$this->id)->where('is_active','1')->whereHas('grn', function($q) use($from,$to){
             if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                    $q->where('status','1');
                })->get();       
             

              $issuances=$this->item_issuances()->whereHas('issuance', function($q) use($from,$to){
                 if($from!='')
                  { $q->where('issuance_date', '>=', $from); }
                if($to!='')
                  { $q->where('issuance_date', '<=', $to); }
                    $q->where('issued','1');
                })->get();

               $issue_returns=$this->item_issue_returns()->whereHas('return', function($q) use($from,$to){
                 if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                    $q->where('returned','1');
                })->get();

          

          // $pros=$this->productions()->where(function($q) use($from,$to){
          //       if($from!='')
          //         { $q->where('production_date', '>=', $from); }
          //     if($to!='')
          //       $q->where('production_date','<=',$to);

          //    })->where('status','1')->get();

          $pros=yield_detail::whereHas('yield.plan',function($q){
                    $q->where('product_id',$this->id);
                     // if($batch_no!='')
                     //  $q->where('batch_no',$batch_no);
                   })->where(function($q) use($from,$to){
                    if($from!='')
                  { $q->where('transfer_date', '>=', $from); }
              if($to!='')
                $q->where('transfer_date','<=',$to);
               })->get();


          $challans=$this->outgoing_stock_list()->whereHas('challan', function($q) use($from,$to){
             if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                    $q->where('status','1');
                })->get();

          $adjustments=adjusted_item::whereHas('adjustment', function($q) use($to,$from){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->where('item_id',$this->id)->get();

         

          $purchase_returns=Purchasereturn_ledger::whereHas('purchasereturn', function($q) use($to,$from){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->where('item_id',$this->id)->get();

          $sale_returns=salereturn_ledger::whereHas('sale_return', function($q) use($to,$from){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->where('item_id',$this->id)->get();

                
          
          $records=array();
          foreach ($grn_stocks as $grn ) {
              
              $record=array('type'=>'grn','stock_id'=>'','doc_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'','customer_name'=>'');

                $record['stock_id']=$grn['id'];
                $record['grn_id']=$grn['grn_id'];
                $record['item_id']=$grn['item_id'];
                //$record['unit']=$grn['unit'];
                //$record['pack_size']=$grn['pack_size'];

                $record['rack']=$grn['rack'];
                $record['rack_qty']=$grn['rack_qty'];

                $record['grn_no']=$grn['grn_no'];
                $record['doc_no']=$grn['grn']['doc_no'];
                $record['in_qty']=$grn['qty'];  //$grn['approved_qty']*$grn['pack_size'];
                $record['doc_date']=$grn['grn']['doc_date'];

                if($grn['grn']['vendor_id']!='')
                     $record['customer_name']=$grn['grn']['vendor']['name'];

                array_push($records, $record);
                
          }

          foreach ($issuances as $grn ) {
              
              $record=array('type'=>'issuance','stock_id'=>'','doc_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','stock_grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'','production_item'=>'','grn_no'=>'');

                $record['issuance_id']=$grn['issuance_id'];
                $record['item_id']=$grn['item_id'];
            
                //$record['unit']=$grn['unit'];
                //$record['pack_size']=$grn['pack_size'];
            
                $record['doc_no']=$grn['issuance']['issuance_no'];
                $record['out_qty']=$grn['quantity']*$grn['pack_size'];
                $record['doc_date']=$grn['issuance']['issuance_date'];
                $record['grn_no']=$grn['grn_no'];

                if(isset($grn['issuance']['plan']['batch_no']))
                   $record['batch_no']=$grn['issuance']['plan']['batch_no'];

                 if(isset($grn['issuance']['plan']['product']['item_name']))
                   $record['production_item']=$grn['issuance']['plan']['product']['item_name'];

                array_push($records, $record);
                
          }

          foreach ($issue_returns as $grn ) {
              
              $record=array('type'=>'issuance-return','stock_id'=>'','doc_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','stock_grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'','production_item'=>'','grn_no'=>'');

                $record['doc_id']=$grn['issue_return_id'];
                $record['item_id']=$grn['item_id'];
            
                //$record['unit']=$grn['unit'];
                //$record['pack_size']=$grn['pack_size'];
            
                $record['doc_no']=$grn['return']['doc_no'];
                $record['in_qty']=$grn['qty']*$grn['pack_size'];
                $record['doc_date']=$grn['return']['doc_date'];
                $record['grn_no']=$grn['grn_no'];

                if(isset($grn['return']['plan']['batch_no']))
                   $record['batch_no']=$grn['return']['plan']['batch_no'];

                 if(isset($grn['return']['plan']['product']['item_name']))
                   $record['production_item']=$grn['return']['plan']['product']['item_name'];

                array_push($records, $record);
                
          }

   
          foreach ($pros as $grn ) {
              
              $record=array('type'=>'production','plan_id'=>'','doc_id'=>'','yield_id'=>'','stock_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','stock_grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'');

                if(isset($grn['yield']['plan']))
                $record['plan_id']=$grn['yield']['plan_id'];
                 $record['yield_id']=$grn['yield']['id'];
                $record['item_id']=$grn['yield']['plan']['product_id'];
            
                //$record['unit']=$grn['unit'];
                //$record['pack_size']=$grn['pack_size'];
                //if(isset($grn['ticket']))
                $record['doc_no']=$grn['yield']['plan']['plan_no'];
                $record['in_qty']=$grn['qty']*$grn['pack_size'];
                $record['doc_date']=$grn['transfer_date'];
                 $record['batch_no']=$grn['yield']['plan']['batch_no'];


                array_push($records, $record);
                
          }

          foreach ($challans as $grn ) {
              
              $record=array('type'=>'challan','doc_id'=>'','challan_id'=>'','plan_id'=>'','yield_id'=>'','stock_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','stock_grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','customer_name'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'');

                
                $record['challan_id']=$grn['challan_id'];
                 
                $record['item_id']=$grn['item_id'];
            
                //$record['unit']=$grn['unit'];
                //$record['pack_size']=$grn['pack_size'];
                //if(isset($grn['ticket']))

                 $record['rack']=$grn['rack'];
                $record['rack_qty']=$grn['rack_qty'];

                $record['doc_no']=$grn['challan']['doc_no'];
                $record['out_qty']=$grn['qty']; //*$grn['pack_size'];
                $record['doc_date']=$grn['challan']['doc_date'];
                 $record['batch_no']=$grn['batch_no'];

                 if($grn['challan']['customer_id']!='')
                     $record['customer_name']=$grn['challan']['customer']['name'];

//print_r(json_encode($grn));die;
                array_push($records, $record);
                
          }

          foreach ($adjustments as $grn ) {
              
              $record=array('type'=>'adjustment','doc_id'=>'','challan_id'=>'','plan_id'=>'','yield_id'=>'','stock_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','stock_grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'');

                $record['adjustment_id']=$grn['adjustment']['id'];
                $record['doc_no']=$grn['adjustment']['doc_no'];
                 
                $record['doc_date']=$grn['adjustment']['doc_date'];
            
                $qty=$grn['qty']*$grn['pack_size'];
                if($grn['type']=='add stock')
                  $record['in_qty']=$qty;
              if($grn['type']=='less stock')
                $record['out_qty']=$qty;
              
                 

                array_push($records, $record);
                
          }

          foreach ($purchase_returns as $grn ) {
              
              $record=array('type'=>'purchase_return','doc_id'=>'','challan_id'=>'','plan_id'=>'','yield_id'=>'','stock_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','customer_name'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'');

                $record['doc_id']=$grn['purchasereturn']['id'];
                $record['doc_no']=$grn['purchasereturn']['doc_no'];
                 
                $record['doc_date']=$grn['purchasereturn']['doc_date'];
            
                $qty=$grn['qty']; //*$grn['pack_size'];
              
                $record['out_qty']=$qty;

                if($grn['purchasereturn']['vendor_id']!='')
                     $record['customer_name']=$grn['purchasereturn']['vendor']['name'];

                   if(isset($grn['purchase_stock']['stock']))
                     $record['grn_no']=$grn['purchase_stock']['stock']['grn_no'];
              
                 

                array_push($records, $record);
                
          }

          foreach ($sale_returns as $grn ) {
              
              $record=array('type'=>'sale_return','doc_id'=>'','challan_id'=>'','plan_id'=>'','yield_id'=>'','stock_id'=>'','grn_id'=>'','issuance_id'=>'','item_id'=>'','unit'=>'','pack_size'=>'','stock_grn_no'=>'','doc_no'=>'','batch_no'=>'','in_qty'=>'0','out_qty'=>'0','doc_date'=>'','customer_name'=>'','opening_qty'=>'0','balance'=>'','adjustment_id'=>'');

                $record['doc_id']=$grn['sale_return']['id'];
                $record['doc_no']=$grn['sale_return']['doc_no'];
                 
                $record['doc_date']=$grn['sale_return']['doc_date'];

                $record['batch_no']=$grn['batch_no'];
            
                $qty=$grn['qty']; //*$grn['pack_size'];
              
                $record['in_qty']=$qty;
              
                 if($grn['sale_return']['customer_id']!='')
                     $record['customer_name']=$grn['sale_return']['customer']['name'];

                array_push($records, $record);
                
          }

             
            $sort_col  = array_column($records, 'doc_date');
           array_multisort($sort_col,SORT_ASC,$records);
             
             if($from=='' && count($records) > 0 )
                  $from=$records[0]['doc_date'];
              if($to=='' && count($records) > 0 )
                  $to=$records[count($records)-1]['doc_date'];

          $items=array();
      //print_r(json_encode($records));die;

          $opening=$this->opening_stock(['from'=>$from]);

           for ($i=0; $i < count($records) ; $i++) { 

            $open=0;
              
            if($i==0)
            {
              
              $open=$opening;
            }
            else
              { $open=$records[$i]['opening_qty'];  }
               
               
               $in=$records[$i]['in_qty'];
               $out=$records[$i]['out_qty'];
               $balance=$records[$i]['balance'];

               $balance=$open + $in  - $out;
               
               $records[$i]['balance']=$balance; 
                
                $nxt=$i + 1 ;
                $count=count($records);
                if($nxt!=$count)
                $records[$nxt]['opening_qty']=$balance;

                if($records[$i]['doc_date'] >= $from && $records[$i]['doc_date'] <= $to  )
                  array_push($items, $records[$i] );

           } //die;

           
          
          return $items;
          
    }


    public function item_detail_transections($criteria=[])
    {
           $from='';$to=''; $batch_no=''; $grn_no='';
            
            if(isset($criteria['from']))
              $from=$criteria['from'];

            if(isset($criteria['to']))
              $to=$criteria['to'];

            if(isset($criteria['batch_no']))
              $batch_no=$criteria['batch_no'];

            if(isset($criteria['grn_no']))
              $grn_no=$criteria['grn_no'];
             
             //if grn_no has that batch_no also
             $batches=Stock::where('item_id',$this->id)->where('batch_no',$batch_no)->select('grn_no')->distinct()->pluck('grn_no')->toArray();

            $grn_stocks=0; $issuances=0; $issue_return=0; $pros=0; $challans=0;
            $add_adjustment=0; $less_adjustment=0; $purchase_return=0; $sale_return=0;
             
             

              $grn_stocks=Stock::where('item_id',$this->id)->where('is_active','1')->whereHas('grn', function($q) use($from,$to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                  if($from!='')
                   $q->where('doc_date','>=',$from);
                 
                    $q->where('status','1');
                })->where(function($q) use($batch_no,$grn_no){

                      if($grn_no!='')
                    $q->where('grn_no',$grn_no);
                        if($batch_no!='')
                     $q->where('batch_no',$batch_no);

                })->sum(\DB::raw('qty')); //'approved_qty * pack_size'
          
             $id=''; $p_id=0;
              if($grn_no!='')
              {
                $stk=Stock::where('grn_no',$grn_no)->first();
                   if($stk!='')
                    $id=$stk['id'];

                  if(isset($stk['purchase']['id']))
                    $p_id=$stk['purchase']['id'];
               }
              //print_r($p_id);die; 
              $purchase_return=Purchasereturn_ledger::whereHas('purchasereturn', function($q) use($from,$to){
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                if($from!='')
                $q->where('doc_date','>=',$from);
              
                $q->where('status',1);
                })->where('item_id',$this->id)->where(function($k) use($grn_no,$id,$p_id){

                  if( $grn_no!='')
                   $k->where('purchase_stock_id',$p_id);

                })->sum(\DB::raw('qty'));  // * pack_size
                //print_r(json_encode($stk['purchase']));die; 
   //print_r(json_encode($purchase_return));die; 

               //for adjustment
            

               $add_adjustment=adjusted_item::whereHas('adjustment', function($q) use($from,$to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                if($from!='')
                $q->where('doc_date','>=',$from);
                $q->where('status',1);
                })->where('item_id',$this->id)->where( function($q) use($batches,$batch_no,$grn_no){
                

                if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
              if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
              if($batch_no!='')
                 $q->orWhere('batch_no',$batch_no);

                    
                })->where('type','add stock')->sum(\DB::raw('qty * pack_size'));

                $less_adjustment=adjusted_item::whereHas('adjustment', function($q) use($from,$to){
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                if($from!='')
                $q->where('doc_date','>=',$from);
             
                $q->where('status',1);
                })->where( function($q) use($batches,$batch_no,$grn_no){
                

                if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
              if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
              if($batch_no!='')
                 $q->orWhere('batch_no',$batch_no);

                    
                })->where('item_id',$this->id)->where('type','less stock')->sum(\DB::raw('qty * pack_size'));


             if($grn_no=='')
             {
              // $pros=$this->productions()->where(function($q) use($from,$to,$batch_no){

              // if($to!='')
              //   $q->where('production_date','<=',$to);
              // if($from!='')
              //   $q->where('production_date','>=',$from);
              // if($batch_no!='')
              //   $q->where('batch_no',$batch_no);

              //  })->where('status','1')->sum(\DB::raw('qty * pack_size'));

              $pros=yield_detail::whereHas('yield.plan',function($q) use ($batch_no){
                    $q->where('product_id',$this->id);
                      if($batch_no!='')
                       $q->where('batch_no',$batch_no);
                   })->where(function($q) use($from,$to){
                    if($from!='')
                  { $q->where('transfer_date', '>=', $from); }
              if($to!='')
                $q->where('transfer_date','<=',$to);
               })->sum(\DB::raw('qty * pack_size'));



             $challans=$this->outgoing_stock_list()->whereHas('challan', function($q) use($from,$to,$batch_no){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                if($from!='')
                $q->where('doc_date','>=',$from);
              if($batch_no!='')
                $q->where('batch_no',$batch_no);
                    $q->where('status','1');
                })->sum(\DB::raw('qty'));//'qty * pack_size'
                
               // print_r(json_encode($challans));die;
                
                $sale_return=salereturn_ledger::whereHas('sale_return', function($q) use($from,$to,$batch_no){
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                if($from!='')
                $q->where('doc_date','>=',$from);
              if($batch_no!='')
                $q->where('batch_no',$batch_no);
                $q->where('status',1);
                })->where('item_id',$this->id)->sum(\DB::raw('qty')); // * pack_size

              }//end if
               

                $issuances=$this->item_issuances()->whereHas('issuance', function($q) use($from,$to){
                if($to!='')
                  { $q->where('issuance_date', '<=', $to); }
                if($from!='')
                $q->where('issuance_date','>=',$from);
              
              
                    $q->where('issued','1');
                })->where(function($q) use($batches,$batch_no,$grn_no){
                 
                 
              if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
                if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
                if($batch_no!='')
                 $q->orWhere('batch_no',$batch_no);

                })->sum(\DB::raw('quantity * pack_size'));

                $issue_return=$this->item_issue_returns()->whereHas('return', function($q) use($from,$to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                if($from!='')
                $q->where('doc_date','>=',$from);
              
              
                    $q->where('returned','1');
                })->where(function($q) use($batches,$batch_no,$grn_no){
                 
                 
              if(count($batches)>0)
                $q->whereIn('grn_no',$batches);
                if($grn_no!='')
                 $q->orWhere('grn_no',$grn_no);
                // if($batch_no!='')
                //  $q->orWhere('batch_no',$batch_no);

                })->sum(\DB::raw('qty * pack_size'));



              

          $detail=array('grn_qty'=>$grn_stocks , 'production_qty'=>$pros , 'add_adjustment'=>$add_adjustment , 'sale_return'=> $sale_return , 'issue_qty'=>$issuances, 'issue_return_qty'=>$issue_return , 'dc_qty'=>$challans , 'less_adjustment'=>$less_adjustment, 'purchase_return'=>$purchase_return);

          //print_r($grn_stocks.' '.$pros.' '.$issuances.' '.$challans);die;

          return $detail;

    }

    public function parameters()
    {
        return $this->morphMany(Parameter::class, 'parameterable')->orderBY('sort_order','asc');
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_item','item_id','order_id')->withPivot('quotation_item_id','unit','qty','pack_size')->withTimestamps();
    }

    public function delivery_challans()
    {
        return $this->belongsToMany(Deliverychallan::class,'delivery_item','item_id','challan_id')->withPivot('id','transection_id','unit','qty','pack_size','mrp','batch_no','expiry_date','business_type','discount_type','discount_factor','tax')->withTimestamps();
    }

    public function outgoing_stock_list() //delivery challan
    {
        return $this->hasMany('App\Models\outgoing_stock','item_id','id');
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class,'item_sale','item_id','invoice_id')->withPivot('id','unit','qty','pack_size','mrp','batch_no','expiry_date','discount_type','discount_factor','tax')->withTimestamps();
    }

    public function sale_returns()
    {
        return $this->belongsToMany(Salereturn::class,'sale_return_item','item_id','return_id')->withPivot('id','sale_stock_id','unit','qty','pack_size','mrp','business_type','batch_no','expiry_date','discount_type','discount_factor','tax')->withTimestamps();
    }

    public function sale_stock_list()// sale
    {
        return $this->hasMany('App\Models\sale_stock','item_id','id');
    }

    public function current_stock_list()// all stock which have qty>0
    {
        


        $stocks='';
         
      if($this->department_id==1 && $this->is_manufactured==1)
             {
        $stocks=$this->product_tickets->where('total_production','>',0)->where('stock_current_qty','>',0);
          }
          else
          {
        $stocks=$this->grn_stocks->where('stock_current_qty','>',0);

            }


        return $stocks ;
    }

    public function stock_list($groupBy='')// all stock production+grn
    {
         $stocks='';

      if($this->department_id==1 && $this->is_manufactured==1)
             {
        $stocks=$this->product_tickets->where('total_production','>',0);
          }
          else
          {
            if($groupBy!='')
        $stocks=Stock::where('item_id',$this->id)->selectRaw('item_id,id,approved_qty,pack_size,grn_no,batch_no,sum(pack_size*approved_qty) as total_qty')->groupBy('item_id',$groupBy)->get();
             else
               $stocks=$this->grn_stocks;

            }


        return $stocks ;
    }

    public function getBatches()
    {
         //$stocks=Stock::where('item_id',$this->id)->where('batch_no','<>','')->select('batch_no')->distinct()->pluck('batch_no')->toArray();
          
      //$ticks=Production::where('item_id',$this->id)->select('batch_no')->distinct()->pluck('batch_no')->toArray();

      $ticks=Productionplan::where('product_id',$this->id)->where('batch_no','<>',null)->select('batch_no')->distinct()->pluck('batch_no')->toArray();


          //$challans=outgoing_stock::where('item_id',$this->id)->where('batch_no','<>','')->select('batch_no')->distinct()->pluck('batch_no')->toArray();
                
                
          //$sale_return=salereturn_ledger::where('item_id',$this->id)->where('batch_no','<>','')->select('batch_no')->distinct()->pluck('batch_no')->toArray();

          //$purchase_return=Purchasereturn_ledger::where('item_id',$this->id)->select('batch_no')->distinct()->pluck('batch_no')->toArray();

               //$adjust=adjusted_item::where('item_id',$this->id)->select('batch_no')->distinct()->pluck('batch_no')->toArray();

               //  $less_adjustment=adjusted_item::whereHas('adjustment', function($q) use($from,$to){
               //  if($to!='')
               //    $q->where('doc_date', '<=', $to);
               //  if($from!='')
               //  $q->where('doc_date','>=',$from);
               //  $q->where('status',1);
               //  })->where('item_id',$this->id)->where('type','less stock')->sum(\DB::raw('qty * pack_size'));



          //$all=array_merge($ticks,$stocks,$challans,$sale_return,$adjust);
          //$all=array_merge($ticks,$stocks);
            $all=array_merge($ticks);
        
               $all=array_unique($all);
          return $all;
    }

    public function getGrnsAttribute()
    {
        $batches=$this->getGrns() ;
         
         $new=array();
          foreach ($batches as $bt) {
             $closing=$this->closing_stock(['grn_no'=>$bt]);
              if($closing>0)
              {
                  $sum=$this->getStockSumarry(['grn_no'=>$bt]);
                $grn_no='';
                if(isset($sum['grn_no']))
                  $grn_no=$sum['grn_no'];
            array_push($new, ['batch_no'=>$sum['batch_no'],'grn_no'=>$grn_no,'qty'=>$closing,'mrp'=>$sum['mrp'],'exp_date'=>$sum['exp_date']]);
             }
           }
          return $new;

    }

    public function getBatchesAttribute()
    {
        $batches=$this->getBatches() ;
         
         $new=array();
          foreach ($batches as $bt) {
             $closing=$this->closing_stock(['batch_no'=>$bt]);
             if($closing>0)
             {
              
              $sum=$this->getStockSumarry(['batch_no'=>$bt]);
                $grn_no=''; $mrp=''; $exp='';
                if(isset($sum['grn_no']))
                  $grn_no=$sum['grn_no'];

                if(isset($sum['mrp']))
                  $mrp=$sum['mrp'];

                if(isset($sum['exp_date']))
                  $exp=$sum['exp_date'];
                
              array_push($new, ['batch_no'=>$bt,'grn_no'=>$grn_no,'qty'=>$closing,'mrp'=>$mrp,'exp_date'=>$exp]);
             
            }
          }
          return $new;

    }

    public function getCurrentGrnsExcept($grs)
    {
        $batches=$this->getGrns() ;
         
     
         $new=array();
          foreach ($batches as $bt) {
             $closing=$this->closing_stock(['grn_no'=>$bt]);

             $bool=false;
               $in=in_array($bt, $grs);
               if($in==1)
                $bool=true;
             //print_r($grns);die;
               // foreach ($grs as $key ) {
               // print_r($key);die;
               //   if(strcmp( $key,$bt))
               //  {$bool=true;}
               // }
               

              if($closing>0 || $bool==true)
              {
                  $sum=$this->getStockSumarry(['grn_no'=>$bt]);
                $grn_no='';
                if(isset($sum['grn_no']))
                  $grn_no=$sum['grn_no'];
            array_push($new, ['batch_no'=>$sum['batch_no'],'grn_no'=>$grn_no,'qty'=>$closing,'mrp'=>$sum['mrp'],'exp_date'=>$sum['exp_date']]);
             }
           }
          return $new;

    }

    public function getCurrentBatchesExcept($bts)
    {
        $batches=$this->getBatches() ;
         
         $new=array();
          foreach ($batches as $bt) {
             $closing=$this->closing_stock(['batch_no'=>$bt]);

             $bool=false;
               $in=in_array($bt, $bts);
               if($in==1)
                $bool=true;

             if($closing>0 || $bool==true)
             {
              
              $sum=$this->getStockSumarry(['batch_no'=>$bt]);
                $grn_no=''; $mrp=''; $exp='';
                if(isset($sum['grn_no']))
                  $grn_no=$sum['grn_no'];

                if(isset($sum['mrp']))
                  $mrp=$sum['mrp'];

                if(isset($sum['exp_date']))
                  $exp=$sum['exp_date'];
                
              array_push($new, ['batch_no'=>$bt,'grn_no'=>$grn_no,'qty'=>$closing,'mrp'=>$mrp,'exp_date'=>$exp]);
             
            }
          }
          return $new;

    }



    public function getCurrentBatches()
    {
         $batches=$this->getBatches() ;
         
         $new=array();
          foreach ($batches as $bt) {
             $closing=$this->closing_stock(['batch_no'=>$bt]);
             if($closing>0)
             array_push($new, $bt);
          }
          return $new;
    }

    public function getCurrentGrns()
    {
         $grns=$this->getGrns() ;
         
          $new=array();
          foreach ($grns as $gn) {
            $closing=$this->closing_stock(['grn_no'=>$gn]);
            if($closing>0)
             array_push($new, $gn);
          }

          return $new;
    }

    public function getStockDetail($criteria=[])
    {    
      $batch_no=''; $grn_no='';

      if(isset($criteria['batch_no']))
        $batch_no=$criteria['batch_no'];

      if(isset($criteria['grn_no']))
        $grn_no=$criteria['grn_no'];

         $stock=Stock::where('item_id',$this->id)->where(function($q) use($batch_no,$grn_no){
           if($batch_no!='')
            $q->where('batch_no',$batch_no);
            if($grn_no!='')
            $q->where('grn_no',$grn_no);
         })->first();

         if(!is_null( $stock))
           return $stock;
          
          if($grn_no=='')
          {
          $tick=Production::where('item_id',$this->id)->where('batch_no',$batch_no)->first();
            if($tick!='')
          return $tick;
          }

        return [];
      }

      public  function getStockSumarry($criteria=[])
    {    
      $batch_no=''; $grn_no=''; 

      if(isset($criteria['batch_no']))
        $batch_no=$criteria['batch_no'];

      if(isset($criteria['grn_no']))
        $grn_no=$criteria['grn_no'];

        
         $stock=Stock::where('item_id',$this->id)->where(function($q) use($batch_no,$grn_no){
           if($batch_no!='')
            $q->where('batch_no',$batch_no);
            if($grn_no!='')
            $q->where('grn_no',$grn_no);
         })->first();
    
         if(!is_null( $stock))
         {
            $let=array('grn_no'=>$stock['grn_no'],'batch_no'=>$stock['batch_no'],'mrp'=>$stock['mrp'],'exp_date'=>$stock['exp_date']);
             return $let;
        }
          
          if($grn_no=='')
          {
          $tick=Productionplan::where('product_id',$this->id)->where('batch_no',$batch_no)->first();
            if($tick!='')
          return ['mrp'=>$tick['mrp'],'batch_no'=>$tick['batch_no'],'exp_date'=>$tick['exp_date'] ];
          }

        return [];
      }

    
    public function getGrns()
    {
         $stocks=Stock::where('item_id',$this->id)->where('grn_no','<>',null)->orderBy('grn_no','asc')->get()->pluck('grn_no')->toArray();

          $all=array_merge($stocks);
            
          return $all;
    }

    public function item_stocks_with_detail($from,$to,$expired)
    {
                  
              $stocks=array();
              
              if($this->department_id==1 && $this->is_manufactured==1)
             {

              $stks=$this->stock_list();

                   foreach ($stks as $stk ) {

              $let=$stk->stock_detail($from,$to);

                  // $arrayName = array('' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] , );
                
                 $today = date("Y-m-d");
                $expire = $stk['exp_date']; //from database

                $today_time = strtotime($today);
                 $expire_time = strtotime($expire);
                  $futureDate=date('Y-m-d', strtotime('+1 year'));
                    
                    if($expired!='' && $expired=='expired')
                  {
                    if ($expire_time > $today_time) { 
                      $let1=array_merge(['batch_no'=>$stk['batch_no'],'exp_date'=>$stk['exp_date'] ],$let);
                  array_push($stocks, $let1);
                   }
                 }

                  elseif($expired!='' && $expired=='near_expiry')
                   {
                    if ($expire_time > $futureDate) { 
                     $let1=array_merge(['batch_no'=>$stk['batch_no'],'exp_date'=>$stk['exp_date'] ],$let);
                  array_push($stocks, $let1);
                   }
                 }
                 else
                 {
                  $let1=array_merge(['batch_no'=>$stk['batch_no'],'exp_date'=>$stk['exp_date'] ],$let);
                  array_push($stocks, $let1);
                 }

                  

                 }
          }
          elseif( ( $this->department_id=='1' && $this->type_id=='6' ) || ( $this->department_id=='1' && $this->type_id=='7' )   )
          {      

               $opening=$this->opening_stock( $from );
                 $closing=$this->closing_stock($to);

                 $stk=$this->item_detail_transections($from,$to);

                  
                  $purchase_qty=$stk['production_qty']+$stk['add_adjustment']+$stk['grn_qty'];

                 $let=array('opening_qty'=>$opening,'dc_qty'=>$stk['dc_qty'],'sale_return_qty'=>$stk['sale_return'],'purchase_qty'=>$purchase_qty,'purchase_return_qty'=>$stk['purchase_return'],'closing_qty'=>$closing);
                  
                  array_push($stocks, $let);
              
          }
          elseif($this->department_id==1 )
          {
              $stks=$this->stock_list('batch_no');

            //$let=$stks->groupBy('batch_no')->get();
            foreach ($stks as $key ) {

              $let=Stock::group_by_stock_detail($key['item_id'],$key['batch_no'],$from,$to);

              $let=array_merge(['batch_no'=>$key['batch_no'],'exp_date'=>$key['exp_date']],$let);

               array_push($stocks, $let);

              //print_r(json_encode($let));
            }
               //die;

              
          }
          else
          {
            $stks=$this->stock_list();
             foreach ($stks as $stk ) {

              $stks=$this->stock_list();


              $let=$stk->stock_detail($from,$to);

                  // $arrayName = array('' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] ,'' =>$let[''] , );

                  $let1=array_merge(['grn_no'=>$stk['grn_no'],'exp_date'=>$stk['exp_date']],$let);
                  array_push($stocks, $let1);

                 }
            }



          

         return $stocks;
    }

    public function item_batch_detail($batch_no,$expired)
    {
                  
             //$pros=$this->productions()->where('batch_no',$batch_no)->where('status','1')->sum(\DB::raw('qty * pack_size'));

             $pros=yield_detail::whereHas('yield.plan',function($q) use ($batch_no){
                    $q->where('product_id',$this->id);
                     if($batch_no!='')
                      $q->where('batch_no',$batch_no);
                   })->sum(\DB::raw('qty * pack_size'));


             $challans=$this->outgoing_stock_list()->where('batch_no',$batch_no)->sum(\DB::raw('qty * pack_size'));
                
               // print_r(json_encode($challans));die;
                
                $sale_return=salereturn_ledger::where('item_id',$this->id)->where('batch_no',$batch_no)->sum(\DB::raw('qty * pack_size'));

             // $grn_stocks=Stock::where('item_id',$this->id)->where('is_active','1')->whereHas('grn', function($q) use(){
             //    if($to!='')
             //      { $q->where('doc_date', '<=', $to); }
             //      if($from!='')
             //       $q->where('doc_date','>=',$from);
             //        $q->where('posted','post');
             //    })->sum(\DB::raw('approved_qty * pack_size'));

             //  $purchase_return=Purchasereturn_ledger::whereHas('purchasereturn', function($q) use($from,$to){
             //    if($to!='')
             //      $q->where('doc_date', '<=', $to);
             //    if($from!='')
             //    $q->where('doc_date','>=',$from);
             //    $q->where('posted',1);
             //    })->where('item_id',$this->id)->sum(\DB::raw('quantity * pack_size'));


               //for adjustment
            

               // $add_adjustment=adjusted_item::whereHas('adjustment', function($q) use($from,$to){
               //  if($to!='')
               //    { $q->where('doc_date', '<=', $to); }
               //  if($from!='')
               //  $q->where('doc_date','>=',$from);
               //  $q->where('status',1);
               //  })->where('item_id',$this->id)->where('type','add stock')->sum(\DB::raw('qty * pack_size'));

               //  $less_adjustment=adjusted_item::whereHas('adjustment', function($q) use($from,$to){
               //  if($to!='')
               //    $q->where('doc_date', '<=', $to);
               //  if($from!='')
               //  $q->where('doc_date','>=',$from);
               //  $q->where('status',1);
               //  })->where('item_id',$this->id)->where('type','less stock')->sum(\DB::raw('qty * pack_size'));


             $tk=Productionplan::where('batch_no',$batch_no)->first();
             if($tk!='')
              $exp=$tk['exp_date'];
            else
              $exp='';
          
             $total=$pros-$challans+$sale_return;
         return ['exp_date'=>$exp,'current'=>$total];
    }

         public function get_cost_rate($batch_no)
    {
      $rate=0;
        $prods=Production::where('item_id',$this->id)->where('batch_no',$batch_no)->first();
         $prods=Productionplan::where('product_id',$this->id)->where('batch_no',$batch_no)->first();

           if(isset($prods['transfer_note']['cost_price']))
            $rate= $prods['transfer_note']['cost_price'];

        $stk=Stock::where('item_id',$this->id)->where('batch_no',$batch_no)->first();

        
                         
                  if(isset($stk['purchase']['rate']))
                    $rate=$stk['purchase']['rate'];
                  
                  return $rate;
    }

}
