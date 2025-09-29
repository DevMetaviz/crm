<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'grn_inventory';
    protected $appends = ['is_opening_stock','rate','is_purchased','stock_current_qty'];

    public function grn()
    {
        return $this->belongsTo(Grn::class,'grn_id','id');
    }

    public function item()
    {
        return $this->belongsTo(inventory::class);
    }



    public function origin()
    {
        return $this->belongsTo('App\Models\Origin');
    }

    public function return_note()
    {
        return $this->hasOne(return_note::class,'stock_id');
    }

    public function qa_samplings()
    {
        return $this->morphMany(sampling::class,'samplable');
    }

    public function purchase()
    {

        return $this->hasOne('App\Models\purchase_ledger','stock_id','id');
    }

    public function is_under_qc()
    {
      $qc=$this->qa_samplings;
              $is_under_qc=0;
           foreach ($qc as $k) {

           if($k['qc_report']=='')
            $is_under_qc=1;  continue;
             
           }
           return $is_under_qc;
    }

    public static function getStock($stock_id)
    {
        $key=Stock::find($stock_id);

         $k= $key['item'];

           $location=''; $color=''; $size=''; $uom='';
           if($k['department']!='')
            $location=$k['department']['name'];
            $item_code=$k['item_code'];
            $item_name=$k['item_name'];
            $item_id=$k['id'];

            if($k['unit']!='')
            $uom=$k['unit']['name'];
            if($k['color']!='')
            $color=$k['color']['name'];
              if($k['size']!='')
            $size=$k['size']['name'];

            
            $unit=$key['unit'];
            $rec_qty=$key['rec_quantity'];
          
            $app_qty=$key['approved_qty'];

            //$gross_qty=$rec_qty-$rej_qty;
            $pack_size=$key['pack_size'];
            
            // if($rej_qty=='')
            //     $rej_qty=0;

            $total_qty=$app_qty * $pack_size ;

            $vendor_name=''; $vendor_id='';

            if($key['grn']!='')
            {
        $vendor_id=$key['grn']['vendor_id'];
        if($vendor_id!='')
        $vendor_name=$key['grn']['vendor']['name'];
          }

         $origin='';
         if($key['origin_id']!='')
            $origin=$key['origin']['name'];

           //$rem_stock_qty=Stock::getQuantityInStock($stock_id);
           $rem_stock_qty=$k->closing_stock(['grn_no'=>$key['grn_no']]);

           //print_r(json_encode($stock_qty));die;

           $doc_date='';
           if($key['grn']!='')
            $doc_date=$key['grn']['doc_date'];

            $stock=array('stock_id'=>$key['id'],'rec_date'=>$doc_date,'vendor_id'=>$vendor_id,'vendor_name'=>$vendor_name,'department'=>$location,'item_id'=>$item_id,'item_code'=>$item_code,'item_name'=>$item_name,'uom'=>$uom,'color'=>$color,'size'=>$size,'unit'=>$unit,'rec_qty'=>$rec_qty,'qty'=>$app_qty,'pack_size'=>$pack_size,'total_qty'=>$total_qty,'grn_no'=>$key['grn_no'],'batch_no'=>$key['batch_no'],'mfg_date'=>$key['mfg_date'],'exp_date'=>$key['exp_date'],'no_of_container'=>$key['no_of_container'],'type_of_container'=>$key['type_of_container'],'origin_id'=>$key['origin_id'],'origin'=>$origin,'closing_qty'=>$rem_stock_qty,'rate'=>$key['rate']);

            return $stock;
    }

    public function getStockCurrentQtyAttribute()
    {
              $qty=Stock::getQuantityInStock($this->id);
            

              return $qty;
    }

    public static function getQuantityInStock($stock_id)
    {
          $grn=Stock::find($stock_id)->grn_no;
       $in_qty=Stock::find($stock_id)->approved_qty * Stock::find($stock_id)->pack_size;
        $out_qty = item_issuance::where('grn_no',$grn)->get()->sum(function($t){ 
             return $t->quantity * $t->pack_size; 
                  });

        $in_qty1 = issue_return_item::where('grn_no',$grn)->get()->sum(function($t){ 
             return $t->qty * $t->pack_size; 
                  });
        
        $ret_qty=0;
          $pur=Stock::find($stock_id)->purchase;
          if($pur!='')
            {

        $ret_qty = Purchasereturn_ledger::where('purchase_stock_id',$pur['id'])->get()->sum(function($t){ 
             return $t->quantity * $t->pack_size; 
                  });
             }

              $add_adjustment=adjusted_item::where('grn_no',$grn)->where('type','add stock')->sum(\DB::raw('qty * pack_size'));

                $less_adjustment=adjusted_item::where('grn_no',$grn)->where('type','less stock')->sum(\DB::raw('qty * pack_size'));


        $rem=$in_qty+ $in_qty1 + $add_adjustment - $out_qty -$ret_qty - $less_adjustment;

       $rem= round($rem,3);

        //$amount = outgoing_stock::select(outgoing_stock::raw('sum(quantity * pack_size) as total'))->first();

        return $rem;
    }

    public static function getItemStocks($item_id)
    {
        $stks=Stock::where('item_id',$item_id)->get()->where('is_purchased','true');
        
        $stocks = array( );
        
        foreach ($stks as $stk ) {
            $stock=Stock::getStock($stk['id']);

            array_push($stocks, $stock);
        }

        return $stocks;
        
    }

    public function getIsPurchasedAttribute()
    {
          if($this->is_opening_stock==true  )
          { 
            if($this->item->rate != '' || $this->item->rate != null )
              return true;
            else
              return false;
          }

              $purchase=$this->grn->purchase;
              //print_r(json_encode($purchase));die;
              if($purchase=='')
                return false;

              $item=$purchase->items->where('id',$this->item_id)->where('pivot.stock_id',$this->id)->first();
              if($item=='')
                return false;
            

              return true;
    }

    public function getRateAttribute()
    {     

       if($this->is_opening_stock==true )
          {  
            return $this->item->rate;  
          }

            $purchase=$this->grn->purchase;
            //print_r(json_encode($this->grn));die;
            if($this->grn->purchase=='' || $this->grn->purchase==null)
                return 0;

              //print_r(json_encode($purchase));die;
              $item=$purchase->items->where('id',$this->item_id)->where('pivot.stock_id',$this->id)->first();

              if($item=='')
                return 0;
              
              $rate=$purchase->rate($this->item_id,$item['pivot']['id']);

              return $rate;
    }

    public function opening_qty($from='')
    {   
     
        if( $from == '' && $this->is_opening_stock==true )
      {
        return $this->approved_qty;
      }
      elseif( $from == '' && $this->is_opening_stock==true )
      {
            return 0;
      }
      else
      {
           $qty=$this->closing_qty( date('Y-m-d', strtotime($from. '-1 days')) );
           return $qty;
      }
      // elseif( $from != '' && $this->is_opening_stock==true )
      // {
      //      $qty=$this->closing_qty( date('Y-m-d', strtotime($from. '-1 days')) );
      //      return $qty;
      // }
      
      // elseif( $from != ''  )
      // {
      //   $qty=$this->closing_qty( date('Y-m-d', strtotime($from. '-1 days')) );
      //      return $qty;
      // }

      // if($this->grn != '')
      // {
      //   $rec_date=$this->grn->doc_date;
      //       if( $rec_date > $from)
      //         return 0;
           
      //      $qty=$this->closing_qty( date('Y-m-d', strtotime($from. '-1 days')) );
      //      return $qty;
      // }
      // else
      // {
      //       return $this->approved_qty;
      // }
    }

    public function closing_qty($to='')
    {
        $in_qty=0;

        if($to=='')
        {
            $in_qty=$this->approved_qty;
        }
        else
        {

            if($this->grn != '')
           {
                $rec_date=$this->grn->doc_date;
               if( $rec_date >= $to)
                $in_qty=0;
                else
                $in_qty=$this->approved_qty;
           
            
             }
            else
               {
                   $in_qty=$this->approved_qty;
               }

        }

       $issue_qty = item_issuance::where('grn_no',$this->id)->whereHas('issuance', function($q) use($to){

                  if($to!='')
                  { $q->where('issuance_date', '<=', $to); }
                    $q->where('issued','1');

                   })->get()->sum(function($t){ 
              
                  return $t->quantity * $t->pack_size;

                  });

                   $purchase_return_qty=0;
          $pur=$this->purchase;
          if($pur!='')
            {

        
        $purchase_return_qty = Purchasereturn_ledger::where('purchase_stock_id',$pur['id'])->whereHas('purchasereturn', function($q) use($to){
               if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('posted',1);
                })->get()->sum(function($t){ 
             return $t->quantity * $t->pack_size; 
                  });
                 }

              $add_adjustment=adjusted_item::where('grn_no',$this->id)->where('type','add stock')->whereHas('adjustment', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
          
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));

                $less_adjustment=adjusted_item::where('grn_no',$this->id)->where('type','less stock')->whereHas('adjustment', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
               
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));


        $rem=$in_qty + $add_adjustment - $issue_qty -$purchase_return_qty - $less_adjustment;

       $rem= round($rem,3);

       return $rem;
    }


    public function stock_detail($from='',$to='')
    {

       $opening_qty=$this->opening_qty( $from );
       $closing_qty=$this->closing_qty( $to );

       $purchase_qty=Stock::where('id',$this->id)->where('is_active','1')->whereHas('grn', function($q) use($from,$to){
                 if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                    $q->where('posted','post');
                })->sum(\DB::raw('approved_qty * pack_size'));
       //print_r(json_encode($purchase_qty));die;
       //


        $issue_qty = item_issuance::where('stock_id',$this->id)->whereHas('issuance', function($q) use($from,$to){

                  if($from!='')
                  { $q->where('issuance_date', '>=', $from); }

                if($to!='')
                  { $q->where('issuance_date', '<=', $to); }
                    $q->where('issued','1');

                })->get()->sum(function($t){ 
              
             return $t->quantity * $t->pack_size;

                  });
        
           //$grn=Stock::find($stock_id)->grn_no;
           
           $purchase_return_qty=0;
          $pur=$this->purchase;
          if($pur!='')
            {
        $purchase_return_qty = Purchasereturn_ledger::where('purchase_stock_id',$pur['id'])->whereHas('purchasereturn', function($q) use($from,$to){
               if($from!='')
                  $q->where('doc_date', '>=', $from);
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('posted',1);
                })->get()->sum(function($t){ 
             return $t->quantity * $t->pack_size; 
                  });
              }

              $add_adjustment=adjusted_item::where('grn_no',$this->id)->where('type','add stock')->whereHas('adjustment', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));

                $less_adjustment=adjusted_item::where('grn_no',$this->id)->where('type','less stock')->whereHas('adjustment', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));


        //$rem=$in_qty + $add_adjustment - $issue_qty -$purchase_return_qty - $less_adjustment;

      

       $stock=array('opening_qty'=>$opening_qty,'purchase_qty'=>$purchase_qty,'issue_qty'=>$issue_qty,'purchase_return_qty'=>$purchase_return_qty,'add_adjustment'=>$add_adjustment,'less_adjustment'=>$less_adjustment,'closing_qty'=>$closing_qty);

        //$amount = outgoing_stock::select(outgoing_stock::raw('sum(quantity * pack_size) as total'))->first();

        return $stock;
    }


    public static function group_by_stock_detail($item_id,$batch_no,$from='',$to='')
    {

       $opening_qty=Stock::group_by_stock_opening_qty($item_id,$batch_no,$from);
       $closing_qty=Stock::group_by_stock_closing_qty($item_id,$batch_no,$to);

       $purchase_qty=Stock::where('item_id',$item_id)->where('batch_no',$batch_no)->where('is_active','1')->whereHas('grn', function($q) use($from,$to){
                 if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                    $q->where('posted','post');
                })->sum(\DB::raw('approved_qty * pack_size'));
       //print_r(json_encode($purchase_qty));die;
       //


        // $issue_qty = item_issuance::where('item_id',$item_id)->whereHas('issuance', function($q) use($from,$to){

        //           if($from!='')
        //           { $q->where('issuance_date', '>=', $from); }

        //         if($to!='')
        //           { $q->where('issuance_date', '<=', $to); }
        //             $q->where('issued','1');

        //         })->get()->sum(function($t){ 
              
        //      return $t->quantity * $t->pack_size;

        //           });
        
           //$grn=Stock::find($stock_id)->grn_no;
        
        $purchase_return_qty = Purchasereturn_ledger::where('item_id',$item_id)->whereHas('stock', function($q) use($batch_no){
            
                  $q->where('batch_no', $batch_no);
            
                })->whereHas('purchasereturn', function($q) use($from,$to){
               if($from!='')
                  $q->where('doc_date', '>=', $from);
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('posted',1);
                })->get()->sum(function($t){ 
             return $t->quantity * $t->pack_size; 
                  });

                $sale_qty = outgoing_stock::where('item_id',$item_id)->where('batch_no',$batch_no)->whereHas('challan', function($q) use($from,$to){

                  if($from!='')
                  { $q->where('challan_date', '>=', $from); }

                if($to!='')
                  { $q->where('challan_date', '<=', $to); }
                    $q->where('activeness','1');

                })->sum(\DB::raw('qty * pack_size'));

        
           
                $sale_return_qty=salereturn_ledger::where('item_id',$item_id)->where('batch_no',$batch_no)->whereHas('sale_return', function($q) use($from,$to){
                if($from!='')
                  $q->where('doc_date', '>=', $from);
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));


              // $add_adjustment=adjusted_item::where('stock_id',$this->id)->where('type','add stock')->whereHas('adjustment', function($q) use($from,$to){
              //   if($from!='')
              //     { $q->where('doc_date', '>=', $from); }
              //   if($to!='')
              //     { $q->where('doc_date', '<=', $to); }
              //   $q->where('activeness',1);
              //   })->sum(\DB::raw('qty * pack_size'));

                // $less_adjustment=adjusted_item::where('stock_id',$this->id)->where('type','less stock')->whereHas('adjustment', function($q) use($from,$to){
                // if($from!='')
                //   { $q->where('doc_date', '>=', $from); }
                // if($to!='')
                //   { $q->where('doc_date', '<=', $to); }
                // $q->where('activeness',1);
                // })->sum(\DB::raw('qty * pack_size'));


        //$rem=$in_qty + $add_adjustment - $issue_qty -$purchase_return_qty - $less_adjustment;

      

       $stock=array('opening_qty'=>$opening_qty,'purchase_qty'=>$purchase_qty,'dc_qty'=>$sale_qty,'purchase_return_qty'=>$purchase_return_qty,'sale_return_qty'=>$sale_return_qty,'closing_qty'=>$closing_qty);

        //$amount = outgoing_stock::select(outgoing_stock::raw('sum(quantity * pack_size) as total'))->first();

        return $stock;
    }

    public static function group_by_stock_opening_qty($item_id,$batch_no,$from='')
    {
         if($from=='')
           {
              $open=Stock::where('grn_id','0')->where('item_id',$item_id)->where('batch_no',$batch_no)->sum(\DB::raw('approved_qty * pack_size'));

              return $open;
           }
          else
          $qty=Stock::group_by_stock_closing_qty($item_id,$batch_no, date('Y-m-d', strtotime($from. '-1 days')) );
           return $qty;
    }

    public static function group_by_stock_closing_qty($item_id,$batch_no,$to='')
    {


      $open=Stock::where('grn_id','0')->where('item_id',$item_id)->where('batch_no',$batch_no)->sum(\DB::raw('approved_qty * pack_size'));


       $purchase_qty=Stock::where('item_id',$item_id)->where('batch_no',$batch_no)->where('is_active','1')->whereHas('grn', function($q) use($to){
                
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                    $q->where('posted','post');
                })->sum(\DB::raw('approved_qty * pack_size'));
       
        $purchase_return_qty = Purchasereturn_ledger::where('item_id',$item_id)->whereHas('stock', function($q) use($batch_no){
            
                  $q->where('batch_no', $batch_no);
            
                })->whereHas('purchasereturn', function($q) use($to){
                    if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('posted',1);
                })->get()->sum(function($t){ 
             return $t->quantity * $t->pack_size; 
                  });

                $sale_qty = outgoing_stock::where('item_id',$item_id)->where('batch_no',$batch_no)->whereHas('challan', function($q) use($to){

              

                if($to!='')
                  { $q->where('challan_date', '<=', $to); }
                    $q->where('activeness','1');

                })->sum(\DB::raw('qty * pack_size'));

        
           
                $sale_return_qty=salereturn_ledger::where('item_id',$item_id)->where('batch_no',$batch_no)->whereHas('sale_return', function($q) use($to){
               
                if($to!='')
                  $q->where('doc_date', '<=', $to);
                $q->where('activeness',1);
                })->sum(\DB::raw('qty * pack_size'));


             

        $rem=$open+$purchase_qty + $sale_return_qty - $sale_qty -$purchase_return_qty ;

    

        return $rem;
    }


    public function getIsOpeningStockAttribute()
    { 

      if($this->grn_id==0 || $this->grn_id=='' || $this->grn_id==null)
        return true;
      else
        return false;

    }


}
