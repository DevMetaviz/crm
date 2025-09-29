<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Allowance;
use App\Models\inventory;
use App\Models\Customer;
use App\Models\country;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Account;
use App\Models\Configuration;
use PDF;

class SalemanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function config_commission()
    {
        $men=Employee::sales_man();
        $items=inventory::where('department_id','1')->where('status','like','1')->orderBy('item_name')->get();
        return view('employee.salesman.config',compact('men','items'));
    }

    public function config_commission_customer_wise()
    {
        $men=Employee::sales_man();
        $items=inventory::where('department_id','1')->where('status','like','1')->orderBy('item_name')->get();
        //$customers=Customer::where('so_id',$so_id)->where('status','1')->get();
        return view('employee.salesman.customer_wise_config',compact('men','items'));
    }

    public function so_customers(Request $request)
    {
        $so_id = $request->so_id;
   
        
        $customers=Employee::find($so_id)->customers;

        return response()->json($customers, 200);
    }

    
    public function salesman_sales(Request $request)
    {   
        $from=$request->from;
         $to=$request->to;
         $salesman_id=$request->salesman_id;

         $salesman=Employee::find($salesman_id);

          $men=Employee::sales_man();
          $config=array('from'=>$from,'to'=>$to,'salesman_id'=>$salesman_id);

         if($salesman=='')
          return view('employee.salesman.sales',compact('men','config'));

    
         
        return view('employee.salesman.sales',compact('men','config','salesman'));
    }

    public function salesman_sales_report(Request $request)
    {   
        $from=$request->from;
         $to=$request->to;
         $salesman_id=$request->salesman_id;

         $salesman=Employee::find($salesman_id);

        
          $config=array('from'=>$from,'to'=>$to,'salesman_id'=>$salesman_id);

         
             $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

             $data = [
            
            'salesman'=>$salesman,
            'config'=>$config,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
             
         view()->share('employee.salesman.sales_ledger',$data);
        $pdf = PDF::loadView('employee.salesman.sales_ledger', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('employee.salesman.sales_ledger.pdf');

    
    }



    

     


}
