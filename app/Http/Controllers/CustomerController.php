<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\country;
use App\Models\inventory;
use App\Models\Deliverychallan;
use App\Models\outgoing_stock;
use App\Models\Employee;
use App\Models\Account;
use App\Models\rate_type;
use App\Models\Configuration;
use App\Models\Transection;
use App\Models\City;
use PDF;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers=Customer::orderBy('name')->get();
        return view('customer.list',compact('customers'));
    }


    public function getCustomerInfo(Request $request)
    {
    $customer = Customer::findOrFail($request->customer_id);
    $info = $customer->info();
    
   

    return response()->json([
            'success' => true,
            'data' => $info
        ]);

  }

    

    public function print_list()
    {
        $customers=Customer::orderBy('name')->get();

           
           $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


        $data = [
            
        
            'customers'=>$customers,
          
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
       
           view()->share('customer.report.customers_list',$data);
        $pdf = PDF::loadView('customer.report.customers_list', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('customer.report.customers_list.pdf');

        
    }
public function receivable_list()
    {
        $customers=Customer::orderBy('name')->get();
        return view('customer.receivable_list',compact('customers'));
    }

    public function print_receivable_list()
    {
        $customers=Customer::orderBy('name')->get();

           
           $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


        $data = [
            
        
            'customers'=>$customers,
          
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
       
           view()->share('customer.report.receivable_list',$data);
        $pdf = PDF::loadView('customer.report.receivable_list', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('customer.report.receivable_list.pdf');

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        $countries=country::with('provinces','provinces.regions','provinces.regions.districts','provinces.regions.districts.cities','provinces.regions.districts.cities.territories')->orderBy('sort_order','asc')->get();
        $sos=Employee::sales_man();
        $types = rate_type::get();
        $cities=City::orderBy('name')->get();

        return view('customer.create',compact('countries','types','sos','cities'));
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

        $customer=new Customer;

        $customer->name=$request->name;
        //$customer->vendor_type_id=$request->type;
        $customer->phone=$request->phone;

        $customer->contact=$request->contact;
        $customer->mobile=$request->mobile;
         $customer->contact2=$request->contact2;
        $customer->mobile2=$request->mobile2;

        $customer->email=$request->email;

        $customer->credit_days=$request->credit_days; 
        $customer->credit_limits=$request->credit_limits; 

        $customer->address=$request->address;
        $customer->rate_type_id=$request->type_id;
        //$customer->sort_order=$request->sort_order;
        $customer->status=$status;
         $customer->cnic=$request->cnic; 
        $customer->ntn=$request->ntn;
        $customer->zip_code=$request->zip_code;
         $customer->so_id=$request->so_id;

         $customer->country_id=$request->country;
         $customer->state_id=$request->state;
         $customer->region_id=$request->region;
         $customer->district_id=$request->district;
         $customer->city_id=$request->city;
         $customer->territory_id=$request->territory;

        $customer->save();
        //customer sale account add
        

        $debtor_acc_id='186';
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
          $acc->name=$customer->name;
          $acc->type='detail';
          $acc->opening_balance=0;
          $acc->remarks='';

          $acc->status='1';

          $acc->save();
//set customer account id
          $customer->account_id=$acc->id;
           $customer->save();


           //customer dms account add
        

        // $debtor_acc_id='434';
        // $debtor_acc=Account::find($debtor_acc_id);

        // $sub=Account::where('super_id',$debtor_acc_id)->orderBy('code','desc')->first();
        //   $num='';  $code=$debtor_acc['code'].'-';
        // if($sub=='' || $sub==null)
        // {
        //     $num='00001';
        // }
        // else
        // {
        

        //       $let=explode($code, $sub['code']);

        //       $num=$let[1] + 1 ;

        //       $num=sprintf('%05d', $num);
        //   }

        //   $code=$code. $num;

                

           
//         $acc=new Account;
//           $acc->super_id=$debtor_acc_id;
//           $acc->code=$code;
//           $acc->name=$customer->name;
//           $acc->type='detail';
//           $acc->opening_balance=0;
//           $acc->remarks='';

//           $acc->status='1';

//           $acc->save();
// //set customer account id
//           $customer->mid_sale_account_id=$acc->id;
//            $customer->save();


        return redirect(url('edit/customer/'.$customer['id']))->with('success','Customer Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $countries=country::with('provinces','provinces.regions','provinces.regions.districts','provinces.regions.districts.cities','provinces.regions.districts.cities.territories')->orderBy('sort_order','asc')->get();
        $sos=Employee::sales_man();
        $types = rate_type::get();
        $cities=City::orderBy('name')->get();
        return view('customer.edit',compact('sos','countries','customer','types','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $status=$request->status;
        if($status=='')
            $status=0;

        $customer=Customer::find($request->id);

        $customer->name=$request->name;
        //$customer->vendor_type_id=$request->type;
        $customer->phone=$request->phone;
        
        $customer->contact=$request->contact;
        $customer->mobile=$request->mobile;
         $customer->contact2=$request->contact2;
        $customer->mobile2=$request->mobile2;
        
        $customer->email=$request->email;
         $customer->credit_days=$request->credit_days; 
         $customer->credit_limits=$request->credit_limits; 
         $customer->rate_type_id=$request->type_id;
        $customer->address=$request->address;
        //$customer->sort_order=$request->sort_order;
        $customer->status=$status;
        $customer->cnic=$request->cnic;
        $customer->ntn=$request->ntn;
        $customer->zip_code=$request->zip_code;
          $customer->so_id=$request->so_id;

          $customer->country_id=$request->country;
         $customer->state_id=$request->state;
         $customer->region_id=$request->region;
         $customer->district_id=$request->district;
         $customer->city_id=$request->city;
         $customer->territory_id=$request->territory;
         
        $customer->save();

        $acc=Account::find($customer['account_id']);
          
          $acc->name=$customer->name;
         
          $acc->save();

//           $acc=Account::find($customer['mid_sale_account_id']);
//           if($acc!='')
//           {  
//             $acc->name=$customer->name;
//              $acc->save();
//            }
//       else
//       {
//        //customer dms account add
        

//         $debtor_acc_id='434';
//         $debtor_acc=Account::find($debtor_acc_id);

//         $sub=Account::where('super_id',$debtor_acc_id)->orderBy('code','desc')->first();
//           $num='';  $code=$debtor_acc['code'].'-';
//         if($sub=='' || $sub==null)
//         {
//             $num='00001';
//         }
//         else
//         {
        

//               $let=explode($code, $sub['code']);

//               $num=$let[1] + 1 ;

//               $num=sprintf('%05d', $num);
//           }

//           $code=$code. $num;

                

           
//         $acc=new Account;
//           $acc->super_id=$debtor_acc_id;
//           $acc->code=$code;
//           $acc->name=$customer->name;
//           $acc->type='detail';
//           $acc->opening_balance=0;
//           $acc->remarks='';

//           $acc->status='1';

//           $acc->save();
// //set customer account id
//           $customer->mid_sale_account_id=$acc->id;
//            $customer->save();


//       }


        return redirect()->back()->with('success','Customer Updated!');
    }

    public function customer_store()
    {
         $customers=Customer::orderBy('name')->where('status','1')->get();
        return view('customer.customer_store',compact('customers'));
    }

    public function customer_stock(Request $request)
    {
        $customer_id=$request->customer_id;
        $from=$request->from;
        $to=$request->to;

         $customer=Customer::find($customer_id);

            
         $products=$customer->current_stock_list($from,$to);

         


         $customers=Customer::orderBy('name')->where('status','1')->get();

        return view('customer.customer_store',compact('customers','products','customer','from','to'));
    }

    public function print_customer_stock(Request $request)
    {
        $customer_id=$request->customer_id;
        $from=$request->from;
        $to=$request->to;

         $customer=Customer::find($customer_id);

            
         $products=$customer->current_stock_list($from,$to);
         
           $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


        $data = [
            
            'products'=>$products,
            'customer'=>$customer,
            'from'=>$from,
            'to'=>$to,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
       
           view()->share('customer.report.customer_store',$data);
        $pdf = PDF::loadView('customer.report.customer_store', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('customer.report.customer_store.pdf');
        
         


         //$customers=Customer::orderBy('name')->where('status','1')->get();

        //return view('customer.customer_store',compact('products','customer','from','to'));
    }


    public function customer_store_detail(Request $request)
    {
        

        $customer_id=$request->customer_id;
        $from=$request->from;
         $to=$request->to;
         
         $customers=Customer::orderBy('name')->where('status','1')->get();

             if($customer_id=='')
              {  return view('customer.customer_store_detail',compact('customers')); }

         $customer=Customer::find($customer_id);

            $stocks=$customer->customer_store_detail($from,$to);

          return view('customer.customer_store_detail',compact('stocks','customers','customer','from','to'));
    }

    public function customer_store_summary(Request $request)
    {          
         $customer_id=$request->customer_id;
         $from=$request->from;
         $to=$request->to;
         
         $customers=Customer::orderBy('name')->where('status','1')->get();

             if($customer_id=='')
              {  return view('customer.customer_store_summary',compact('customers')); }

         $customer=Customer::find($customer_id);
         $challans=$customer->customer_store_summary($from,$to);
          return view('customer.customer_store_summary',compact('customers','customer','challans','from','to'));
    }

    public function customer_receivable(Request $request)
    {          
         $customer_id=$request->customer_id;
         $from=$request->from;
         $to=$request->to;
         $detail=$request->detail;

          if($detail=='')
           $detail=0;
         
         $customers=Customer::orderBy('name')->where('status','1')->get();

             if($customer_id=='')
              {  return view('customer.customer_receivable',compact('customers')); }

         $customer=Customer::find($customer_id);
         $ledger=$customer->customer_receivable($from,$to,$detail);
          return view('customer.customer_receivable',compact('customers','customer','ledger','from','to','detail'));
    }

    public function print_customer_receivable(Request $request)
    {          
         $customer_id=$request->customer_id;
         $from=$request->from;
         $to=$request->to;
         $detail=$request->detail;

          if($detail=='')
           $detail=0;

         
         $customers=Customer::orderBy('name')->where('status','1')->get();

             // if($customer_id=='')
             //  {  return view('customer.customer_receivable',compact('customers')); }

         $customer=Customer::find($customer_id);
          $ledger=$customer->customer_receivable($from,$to,$detail);
         
           $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

         $account=Account::find($customer['mid_sale_account_id']);
       
        $config=array('from'=>$from,'to'=>$to,'account'=>$account,'detail'=>$detail);

        $data = [
            
            'config'=>$config,
              'ledger'=>$ledger,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
       
           view()->share('customer.report.customer_receivable',$data);
        $pdf = PDF::loadView('customer.report.customer_receivable', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('customer.report.customer_receivable.pdf');

    }


    public function config_rate()
    {
        $products= inventory::where('department_id','1')->select('id','item_name','item_code')->orderBy('item_name')->get();
        return view('customer.rate.rate',compact('products'));
    }

    public function config_rate_save(Request $request)
    {

        $items_id=$request->items_id;

        //print_r(json_encode($items_id));die;
       //$bts=$request->bts;
       $values=$request->values;

        $type = new rate_type;

        $type->text=$request->text;
        
        
        $type->save();

        for($i=0;$i<count($items_id);$i++)
            {
                if($values[$i]=='')
                    continue;
         $type->items()->attach($items_id[$i] , [ 'value' => $values[$i]  ]);

           }

       return redirect()->back()->with('success','Rate saved!');
    }

    public function config_rate_list()
    {

        $types = rate_type::get();
        return view('customer.rate.rate_type_list',compact('types'));
    }

    public function config_rate_type_edit(rate_type $type)
    {
        $products= inventory::where('department_id','1')->select('id','item_name','item_code')->orderBy('item_name')->get();
        return view('customer.rate.rate_type_edit',compact('products','type'));
    }

    public function config_rate_type_update(Request $request)
    {

        $items_id=$request->items_id;

        //print_r(json_encode($items_id));die;
       
       //$bts=$request->bts;
       $values=$request->values;


        $type =rate_type::find($request->id);

        $type->text=$request->text;
        
        
        
        $type->save();

    
              $rel=array();
            for($i=0;$i<count($items_id);$i++)
            {  
                if($values[$i]=='')
                    continue;

                $pivot=array(  'value' => $values[$i]  );

                $let=array( $items_id[$i].'' =>$pivot );

                $rel=$rel+$let;
           }

           $type->items()->sync($rel);

       return redirect()->back()->with('success','Rate updated!');
    }

    public function get_rate(Request $request)
    {
        

          $customer_id=$request->customer_id;
          $item_id=$request->item_id;

        
          $customer=Customer::find($customer_id);
            $rate=$customer->getRate($item_id); 

        return response()->json($rate, 200);
            
          

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
