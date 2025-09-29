<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Transection;


class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
         $vendors=Vendor::where('activeness','like','1')->orderBy('sort_order','asc')->get();

         $number="AST-".Date("y")."-";
        $num=1;

         $in=Asset::select('id','number')->where('number','like',$number.'%')->orderBy('number','desc')->latest()->first();
         if($in=='')
         {
              $let=sprintf('%03d', $num);
              $number=$number. $let;
         }
         else
         {
            $let=explode($number , $in['number']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $number=$number. $let;
         }

        return view('asset.create',compact('vendors','number'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $active=$request->activeness;
        if($active=='')
            $active=0;

        $asset=new Asset;

        $asset->name=$request->name;
        $asset->number=$request->number;
        $asset->category_id=$request->category_id;
        $asset->type_id=$request->type_id;
         $asset->brand=$request->brand;
        $asset->model=$request->model;
        $asset->serial_no=$request->serial_no;
        $asset->condition_id=$request->condition_id;
        $asset->status_id=$request->status_id;
        $asset->location_id=$request->location_id;
        $asset->manufacture=$request->manufacture;
        $asset->vendor_id=$request->vendor_id;
         $asset->purchase_date=$request->purchase_date;
        $asset->purchase_price=$request->purchase_price;
        $asset->current_value=$request->current_value;
        $asset->warranty_expire=$request->warranty_expire;
        $asset->wh_tax=$request->wh_tax;

        $asset->description=$request->description;
        $asset->activeness=$active;
        
        $asset->save();

        $customer_acc=Vendor::find($request->vendor_id)->account_id;
        $trans=new Transection;

           $trans->account_voucherable_id=$asset->id;
           $trans->account_voucherable_type='App\Models\Asset';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks="Asset Purchase : ".$asset['number'];
           $trans->debit=0;
           $trans->credit=$asset->purchase_price;
           $trans->save();

           if($request->wh_tax!='')
               {
               $customer_acc=Vendor::find($request->vendor_id)->account_id;
              $remarks='Tax Deduction against Asset Purchasing:'.$asset->number;
              $tax=$asset->with_hold_tax_amount(); 
                   $trans=new Transection;
           $trans->account_voucherable_id=$asset->id;
           $trans->account_voucherable_type='App\Models\Asset';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=$tax;
           $trans->credit=0;
           $trans->save();
           }

           

        return redirect()->back()->with('success','Asset Added!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        //
    }
}
