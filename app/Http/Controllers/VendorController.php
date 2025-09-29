<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\country;
use App\Models\VendorType;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Configuration;
use App\Models\City;
use PDF;

class VendorController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors=Vendor::orderBy('sort_order','asc')->get();

        return view('Vendor.index',compact('vendors'));
    }

    public function get_vendor(Request $request)
    {
        $vendor=Vendor::find($request->vendor_id);
      return $vendor;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor_types=VendorType::where('status','like','1')->orderBy('sort_order','asc')->get();

        $countries=country::select('id','name')->orderBy('sort_order','asc')->get();

        $accounts=Account::where('type','sub_sub')->where('super_id','38')->orderBy('name','asc')->orderBy('created_at','desc')->get()->sortBy('code')->sortBy('sub_sub_account.name');

        $cities=City::orderBy('name')->get();

        return view('Vendor.create',compact('vendor_types','accounts','countries','cities'));
       
    }

    public function vendor_type()
    {
        //
    
        $vendor_types=VendorType::orderBy('sort_order','asc')->get();

        return view('Vendor.type',compact('vendor_types'));
    }

    public function vendor_type_save(Request $request)
    {
          $status=$request->status;
        if($status=='')
            $status='0';

        $type=new VendorType;
    
         $type->text=$request->get('text');
         $type->description=$request->get('description');
          $type->sort_order=$request->get('sort_order');
         $type->status=$status;
        $type->save();

        return redirect()->back()->with('success','Vendor Type Added!');
    }

    public function vendor_type_edit($type_id)
    {
        //
    
        $vendor_types=VendorType::orderBy('sort_order','asc')->get();

        $type=VendorType::find($type_id);
        //print_r(json_encode($type));die;

        return view('Vendor.edit_vendor_type',compact('type','vendor_types'));
    }

    public function vendor_type_update(Request $request)
    {
        $status=$request->status;
        if($status=='')
            $status='0';

         $type=VendorType::find($request->id);
    
         $type->text=$request->get('text');
         $type->description=$request->get('description');
          $type->sort_order=$request->get('sort_order');
         $type->status=$status;
        $type->save();

        return redirect()->back()->with('success','Vendor Type Updated!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status=$request->status;
        if($status=='')
            $status=0;

        $vendor=new Vendor;

        $vendor->name=$request->name;
        $vendor->vendor_type_id=$request->type;
        $vendor->phone=$request->phone;
        $vendor->mobile=$request->mobile;
        $vendor->email=$request->email;
        
        $vendor->address=$request->address;
        //$vendor->sort_order=$request->sort_order;

        $vendor->bank1=$request->bank1;
        $vendor->account_title1=$request->account_title1;
        $vendor->account_no1=$request->account_no1;
        $vendor->bank2=$request->bank2;
        $vendor->account_title2=$request->account_title2;
        $vendor->account_no2=$request->account_no2;          


        $vendor->status=$status;
        $vendor->cnic=$request->cnic;
        $vendor->city_id=$request->city_id;
        $vendor->ntn_number=$request->ntn_number;
        $vendor->salestax_num=$request->salestax_num;
        $vendor->comment=$request->comment;

        $vendor->save();

        $debtor_acc_id=$request->creditor_account_type;

        $debtor_acc=Account::find($debtor_acc_id);

        $sub=Account::where('super_id',$debtor_acc_id)->orderBy('code','desc')->first();
          $num='';  $code=$debtor_acc['code'].'-';
        if($sub=='' || $sub==null)
        {
            $num='00001';
        }
        else
        {
        

              $let=explode($code, $sub['code']);

              $num=$let[1] + 1 ;

              $num=sprintf('%05d', $num);
          }

          $code=$code. $num;

                

           
        $acc=new Account;
          $acc->super_id=$debtor_acc_id;
          $acc->code=$code;
          $acc->name=$vendor->name;
          $acc->type='detail';
          $acc->opening_balance=0;
          $acc->remarks='';

          $acc->status='1';

          $acc->save();
//set customer account id
          $vendor->account_id=$acc->id;
           $vendor->save();

        return redirect()->back()->with('success','Vendor Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $vendor_types=VendorType::where('status','like','1')->orderBy('sort_order','asc')->get();

        $countries=country::select('id','name')->orderBy('sort_order','asc')->get();

        $accounts=Account::where('type','sub_sub')->where('super_id','38')->orderBy('name','asc')->orderBy('created_at','desc')->get()->sortBy('code')->sortBy('sub_sub_account.name');

        $cities=City::orderBy('name')->get();

        return view('Vendor.edit',compact('vendor','accounts','vendor_types','countries','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $status=$request->status;
        if($status=='')
            $status=0;

       if($vendor['name'] != $request->name )
        {
            $acc=Account::find($vendor->account_id); 
             $acc->name=$request->name;
             $acc->save();
         }
          
        if($vendor['account']['super_id'] != $request->creditor_account_type )
        {
         $debtor_acc_id=$request->creditor_account_type;

         $debtor_acc=Account::find($debtor_acc_id);

        $sub=Account::where('super_id',$debtor_acc_id)->orderBy('code','desc')->first();
          $num='';  $code=$debtor_acc['code'].'-';
        if($sub=='' || $sub==null)
        {
            $num='00001';
        }
        else
        {
        

              $let=explode($code, $sub['code']);

              $num=$let[1] + 1 ;

              $num=sprintf('%05d', $num);
          }

          $code=$code. $num;

           $acc=Account::find($vendor->account_id);
           $acc->super_id=$debtor_acc_id;
           $acc->code=$code;
            $acc->save();

            
        }

        $vendor->name=$request->name;
        $vendor->vendor_type_id=$request->type;
        $vendor->phone=$request->phone;
        $vendor->mobile=$request->mobile;
        $vendor->email=$request->email;
        
        $vendor->address=$request->address;
        //$vendor->sort_order=$request->sort_order;

         $vendor->bank1=$request->bank1;
        $vendor->account_title1=$request->account_title1;
        $vendor->account_no1=$request->account_no1;
        $vendor->bank2=$request->bank2;
        $vendor->account_title2=$request->account_title2;
        $vendor->account_no2=$request->account_no2; 
        
        $vendor->status=$status;
         $vendor->cnic=$request->cnic;
         $vendor->city_id=$request->city_id;
        $vendor->ntn_number=$request->ntn_number;
        $vendor->salestax_num=$request->salestax_num;
        $vendor->comment=$request->comment;

        $vendor->save();

        

        return redirect()->back()->with('success','Vendor Updated!');
    }

    public function payable_list()
    {
        $customers=Vendor::orderBy('name')->get();
        return view('Vendor.reports.payable_list',compact('customers'));
    }

    public function print_payable_list()
    {
        $customers=Vendor::orderBy('name')->get();

           
           $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


        $data = [
            
        
            'customers'=>$customers,
          
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
       
           view()->share('Vendor.reports.payable_list_print',$data);
        $pdf = PDF::loadView('Vendor.reports.payable_list_print', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('Vendor.reports.payable_list_print.pdf');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
