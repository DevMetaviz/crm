<?php

namespace App\Http\Controllers;

use App\Models\ProdDemand;
use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\Configuration;
use PDF;

class ProdDemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demands= ProdDemand::orderBy('doc_no','desc')->get();
          return view('production.demand.index',compact('demands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $code='PD-'.Date("y")."-";

        
        $num=1;

         $demand=ProdDemand::select('id','doc_no')->where('doc_no','like',$code.'%')->orderBy('doc_no','desc')->latest()->first();
         if($demand=='')
         {
              $let=sprintf('%03d', $num);
              $code=$code. $let;
         }
         else
         {
            $let=explode($code , $demand['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $code=$code. $let;
         }


      $products=inventory::with('unit')->where('department_id','1')->where('activeness','like','active')->orderBy('item_name','asc')->get();
        
        return view('production.demand.create',compact('products','code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activeness=$request->activeness;
        if($activeness=='')
            $activeness=0;

        $demand=new ProdDemand;
         
         $demand->doc_no=$request->doc_no;
        $demand->doc_date=$request->doc_date;
        // $demand->from=$request->from;
        // $demand->to=$request->to;

        $demand->product_id=$request->product_id;
        $demand->qty=$request->qty;
        
        $demand->remarks=$request->remarks;

        $demand->activeness=$activeness;
        $demand->save();

        

        
         
         return redirect('edit/production-demand/'.$demand['id'])->with('success','Production demand genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProdDemand  $prodDemand
     * @return \Illuminate\Http\Response
     */
    public function show(ProdDemand $prodDemand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProdDemand  $prodDemand
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdDemand $demand)
    {
         $products=inventory::with('unit')->where('department_id','1')->where('activeness','like','active')->orWhere('id',$demand['product_id'])->orderBy('item_name','asc')->get();
        
        return view('production.demand.edit',compact('products','demand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProdDemand  $prodDemand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
          $activeness=$request->activeness;
        if($activeness=='')
            $activeness=0;

        $demand=ProdDemand::find($request->id);
         
         $demand->doc_no=$request->doc_no;
        $demand->doc_date=$request->doc_date;
        $demand->product_id=$request->product_id;
        $demand->qty=$request->qty;
        
        $demand->remarks=$request->remarks;

        $demand->activeness=$activeness;
        $demand->save();

         
         
         return redirect('edit/production-demand/'.$demand['id'])->with('success','Sale production updated!');
    }

    public function demand_print(ProdDemand $demand)
    {
       
        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
           
        $data = [
            
            'demand'=>$demand,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
       
        
           view()->share('production.demand.demand_report',$data);
        $pdf = PDF::loadView('production.demand.demand_report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('demand_report.pdf');

      //return view('purchase.edit_purchase',compact('vendors','inventories','departments','purchase','grn','expenses'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdDemand  $prodDemand
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdDemand $demand)
    {
        //$challan=::where('order_id',$order['id'])->first();


            if($demand['plan']!='')
             return redirect()->back()->withErrors(['error'=>'Delete Plan first, than demand!']);

         
         $demand->delete();

        return redirect(url('production-demand'))->with('success','Demand Deleted!');
    }
}
