<?php

namespace App\Http\Controllers;

use App\Models\Goods_Yield;
use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\InventoryDepartment;
use App\Models\Productionplan;
use App\Models\yield_detail;
use App\Models\Transection;
use App\Models\Configuration;
use PDF;

class GoodsYieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yields=Goods_Yield::orderBy('created_at','desc')->get();

        return view('production.transfer.index',compact('yields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plns=Productionplan::doesntHave('transfer_note')->get();

             $plans=[];
            foreach ($plns as $pn) {

                $pkings=$pn['product']['packings'];

                $packings=[];
            foreach ($pkings as $pk) {

                array_push($packings, $pk['packing']);
            }


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'mrp'=>$pn['mrp'],'pack_size'=>$pn['product']['pack_size'],'packing'=>$packings];

              array_push($plans, $plan);
            }
        
        return view('production.transfer.create',compact('plans'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yield=new Goods_Yield;
         $yield->plan_id=$request->plan_id;
         $yield->qa_sample=$request->qa_sample;
         $yield->qc_sample=$request->qc_sample;
         $yield->cost_price=$request->cost_price;
         $yield->remarks=$request->remarks;
        $yield->save();

        $tran_date=$request->tran_date;
        $unit=$request->unit;
        $qty=$request->qty;
        $pack_size=$request->pack_size;

        $item=inventory::find($yield->plan->product_id);
        $depart=InventoryDepartment::find($item['department_id'])->account_id;

        for ($i=0; $i < count($tran_date) ; $i++) { 
             $dt=new yield_detail;
         $dt->yield_id=$yield->id;
         $dt->transfer_date=$tran_date[$i];
         $dt->unit=$unit[$i];
         $dt->qty=$qty[$i];
         $dt->pack_size=$pack_size[$i];
        $dt->save();
        

        $qty=$dt['qty'] * $dt['pack_size'];
        $amount=$yield->cost_price * $qty;
        
         $trans=new Transection;
           $trans->account_voucherable_id=$dt->id;
           $trans->account_voucherable_type='App\Models\yield_detail';
           $trans->account_id=$depart;
          // $trans->corporate_id=$item['id'];
           $trans->remarks='Transfer Note '.$item['item_name'].' :( '.$qty.'x'.$yield->cost_price.')';
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();

          }

         return redirect(url('/edit/transfer-note/'.$yield['id']))->with('success','Transfer Note genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function show(Goods_Yield $goods_Yield)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function edit(Goods_Yield $yield)
    {
        $plns=Productionplan::doesntHave('transfer_note')->orWhere('id',$yield['plan_id'])->get();

             $plans=[];
            foreach ($plns as $pn) {

                $pkings=$pn['product']['packings'];

                $packings=[];
            foreach ($pkings as $pk) {

                array_push($packings, $pk['packing']);
            }


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'mrp'=>$pn['mrp'],'pack_size'=>$pn['product']['pack_size'],'packing'=>$packings];

              array_push($plans, $plan);
            }
        
        return view('production.transfer.edit',compact('plans','yield'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $yield=Goods_Yield::find($request->id);
         $yield->plan_id=$request->plan_id;
         $yield->qa_sample=$request->qa_sample;
         $yield->qc_sample=$request->qc_sample;
          $yield->cost_price=$request->cost_price;
         $yield->remarks=$request->remarks;
        $yield->save();

        $tran_date=$request->tran_date;
        $unit=$request->unit;
        $qty=$request->qty;
        $pack_size=$request->pack_size;
           
       $items=$yield->yield_items;
       $no=0;

       $item=inventory::find($yield->plan->product_id);
        $depart=InventoryDepartment::find($item['department_id'])->account_id;
       
        for ($i=0; $i < count($tran_date) ; $i++) { 

             if($no < count($items))
          $dt=$items[$no];
          else
             $dt=new yield_detail;

         $dt->yield_id=$yield->id;
         $dt->transfer_date=$tran_date[$i];
         $dt->unit=$unit[$i];
         $dt->qty=$qty[$i];
         $dt->pack_size=$pack_size[$i];
        $dt->save();
        
         $transections=$dt->transections;
          $k=0;
        $qty1=$dt['qty'] * $dt['pack_size'];
          $amount=$yield->cost_price * $qty1;

          if($k < count($transections))
            { $trans=$transections[$k]; }
            else
            $trans=new Transection;
           $trans->account_voucherable_id=$dt->id;
           $trans->account_voucherable_type='App\Models\yield_detail';
           $trans->account_id=$depart;
          // $trans->corporate_id=$item['id'];
         $trans->remarks='Transfer Note '.$item['item_name'].' :( '.$qty1.'x'.$yield->cost_price.')';
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();
          $k++;
           for($j=$k; $j < count($transections); $j++ )
           {
             
               $transections[$j]->delete();
           }



        $no++;
        }

        for($i=$no; $i < count($items); $i++ )
           {
               $transections=$items[$i]->transections;
               foreach ($transections as $key ) {
                    $key->delete();

               }
            $items[$i]->delete();
           }
                 
           
         return redirect()->back()->with('success','Transfer Note Updated!');

    }

     public function print(Goods_Yield $yield)
    {
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'plan'=>$yield['plan'],
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.challan_pdf',compact('data'));
           view()->share('production.transfer.report',$data);
        $pdf = PDF::loadView('production.transfer.report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($yield['id'].'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goods_Yield $yield)
    {
        
           foreach($yield->yield_items as $it )
           {
            foreach($it->transections as $trans )
           {
               $trans->delete();
           }
           }
          
            foreach($yield->yield_items as $it )
           {
               $it->delete();           
         }


         $yield->delete();

        return redirect(url('/transfer-note'))->with('success','Transfer Note Deleted!');
    }
}
