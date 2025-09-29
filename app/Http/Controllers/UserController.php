<?php

namespace App\Http\Controllers;

use App\Models\Allowance;

use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use Session;
use App\Models\Configuration;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\inventory;
use App\Models\sale_stock;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderBy('name')->get();
        return view('user.users',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_user()
    {
        $roles=Role::where('status','like','1')->orderBy('sort_order','asc')->get();
        $employees=Employee::where('status','like','1')->doesntHave('user')->orderBy('name','asc')->get();

        return view('user.user',compact('roles','employees'));
    }

    public function save_user(Request $request)
    {
        $user=User::where('login_name','like',$request->get('user_login') )->first();
        if($user!='')
        {
            return  redirect()->back()->with('error','This user login name already exist!');
        }

        $status=$request->get('status');
        if($status=='')
            $status='0';

         $roles=$request->get('roles');
         //print_r(json_encode($roles));die;

        $user=New User;
        $user->name=$request->get('name');
        $user->password=Hash::make($request->password);
        $user->login_name=$request->get('user_login');
        $user->employee_id=$request->get('employee_id');
        $user->status=$status;
        $user->save();

        $user->roles()->attach($roles);

        return redirect()->back()->with('success','User Added!');
    }

    public function edit_user(User $user)
    {
        $roles=Role::where('status','like','1')->orderBy('sort_order','asc')->get();
        $employees=Employee::where('status','like','1')->doesntHave('user')->orWhere('id',$user['employee_id'])->orderBy('name','asc')->get();

        return view('user.edit_user',compact('user','roles','employees'));
    }

    public function update_user(Request $request)
    {
        $user=User::where('id','<>',$request->id)->where('login_name','like',$request->get('user_login') )->first();
        if($user!='')
        {
            return  redirect()->back()->with('error','This user login name already exist!');
        }

        $status=$request->get('status');
        if($status=='')
            $status='0';

         $roles=$request->get('roles');
         //print_r(json_encode($roles));die;

        $user=User::find($request->id);
        $user->name=$request->get('name');

        if($request->password!='')
        $user->password=Hash::make($request->password);
    
        $user->login_name=$request->get('user_login');
        $user->employee_id=$request->get('employee_id');
        $user->status=$status;
        $user->save();


           $user->roles()->sync($roles);

        return redirect()->back()->with('success','User Updated!');
    }


    public function dashboard()
    {

        $name=Configuration::company_full_name();
        $short_name=Configuration::company_short_name();
        $abbreviation=Configuration::company_abbreviation();
        $factory_address=Configuration::company_factory_address();
        
        

        $order_detail=Order::order_details();
      
          $today = date("Y-m-d");

         $account=Account::find(120);

         $bank_balance=$account->balance($today);

         $account=Account::find(119);

         $cash_balance=$account->balance($today);

         $account=Account::find(1003);

         $cheques_in_hand=$account->balance(''); 

         $balances=['bank'=>$bank_balance,'cash'=>$cash_balance, 'cheques_in_hand'=>$cheques_in_hand];

            $sale_detail=Sale::sale_detail();

            //$days_compare=Sale::sale_detail_comparison();

            $cash_sale_detail=Sale::sale_detail(['invoice_type'=>'cash']);

             $items=inventory::getItems(['minimum_qty'=>1]);

            //$sale_detail=['today'=>$sale_detail['today'],'cash'=>$cash_balance];


             $year = now()->year;

$topCustomersYear = Sale::selectRaw('customer_id, SUM(total_amount) as total_sales')
    ->whereYear('doc_date', $year)
    ->groupBy('customer_id')
    ->orderByDesc('total_sales')
    ->take(5)
    ->with('customer:id,name')
    ->get()
    ->map(function ($row) {
        return [
            'name' => $row->customer->name,
            'total_sales' => $row->total_sales,
        ];
    });


$topCustomersMonth = Sale::selectRaw('customer_id, SUM(total_amount) as total_sales')
    ->whereYear('doc_date', now()->year)
    ->whereMonth('doc_date', now()->month)
    ->groupBy('customer_id')
    ->orderByDesc('total_sales')
    ->take(5)
    ->with('customer:id,name')
    ->get()
    ->map(function ($row) {
        return [
            'name' => $row->customer->name,
            'total_sales' => $row->total_sales,
        ];
    });


    $topItemsYear = sale_stock::top_sale_items(['year' => now()->year]);

     $topItemsMonth = sale_stock::top_sale_items([
    'year' => now()->year,
    'month' => now()->month
]);


      $customers = Customer::select('id','account_id','name')->with('account')->where('status','1')->get();

$topBalanceCustomers = $customers->map(function($customer) {
    return [
        'id'       => $customer->id,
        'name'     => $customer->name,
        'balance'  => $customer->account ? $customer->account->balance(now()->toDateString()) : 0,
    ];
})->sortByDesc('balance')->take(5);




    /*$totalReceivables = DB::table('customers')
    ->join('accounts', 'customers.account_id', '=', 'accounts.id')
    ->leftJoin('account_voucher', 'account_voucher.account_id', '=', 'accounts.id')
    ->selectRaw('SUM(COALESCE(accounts.opening_balance,0) + (SUM(account_voucher.debit) - SUM(account_voucher.credit))) as balance')
    ->groupBy('accounts.id','accounts.opening_balance')
    ->get()
    ->sum('balance');

    $totalPayables = DB::table('vendors')
    ->join('accounts', 'vendors.account_id', '=', 'accounts.id')
    ->leftJoin('account_voucher', 'account_voucher.account_id', '=', 'accounts.id')
    ->selectRaw('SUM(COALESCE(accounts.opening_balance,0) + (SUM(account_voucher.debit) - SUM(account_voucher.credit))) as balance')
    ->groupBy('accounts.id','accounts.opening_balance')
    ->get()
    ->sum('balance');  ,'totalReceivables','total_payables'
*/


      return view('dashboard',compact('order_detail','balances','sale_detail','cash_sale_detail','short_name','abbreviation','items','topCustomersYear','topCustomersMonth','topBalanceCustomers','topItemsYear','topItemsMonth'));
        
    }

    // DashboardController.php
public function salesChartData(Request $request)
{
    $type = $request->get('type', 'weekly');
    $data = Sale::sale_detail_comparison(['range' => $type]);

    if ($type == 'weekly') {
        return response()->json([
            'labels' => $data->pluck('day_name'),
            'totals' => $data->pluck('total')
        ]);
    }

    if ($type == 'monthly') {
        return response()->json([
            'labels' => $data->pluck('month_name'),
            'totals' => $data->pluck('total')
        ]);
    }

    if ($type == 'yearly') {
        return response()->json([
            'labels' => $data->pluck('year'),
            'totals' => $data->pluck('total')
        ]);
    }
}



    public function login()
    {

       

        if (Auth::check()) {
             return redirect()->intended('dashboard');
          }
        
        
 $name=Configuration::company_full_name();
        $short_name=Configuration::company_short_name();
        $abbreviation=Configuration::company_abbreviation();
        $factory_address=Configuration::company_factory_address();

      return view('login',compact('short_name'));
        
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('login_name', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
        else
        {
            return redirect()->back()->with('error','Invalid Login!');
        }
    }

    public function logout(Request $request)
    {

        //print_r(json_encode($request));die;
        
          //Session::flush();
        $request->session()->invalidate();

         $request->session()->regenerateToken();
           Auth::logout();
      return redirect()->intended('login');
        
    }

    public function create_role()
    {
        $roles=Role::orderBy('sort_order','asc')->get();
        return view('user.role',compact('roles'));
    }

    public function save_role(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';

        $role=New Role;
        $role->name=$request->get('name');
        $role->sort_order=$request->get('sort_order');
        $role->status=$status;
        $role->save();

        return redirect()->back()->with('success','Role Added!');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

     
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
