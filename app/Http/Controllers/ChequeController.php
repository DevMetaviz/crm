<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Customer;
use App\Models\Account;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

         /*$accounts = Account::whereHas('cheques')
                ->orderBy('name')
                ->get();*/

                $account = Account::find(1003);

    
    //$account_id = $request->account_id ?? $accounts->first()->id ?? null;


          $cheques = collect();

         $totalAmount = 0;

        

         $closing_balance=0;

  
        $cheques = Cheque::latest()
                         ->paginate(20)
                         ->withQueryString();

        $totalAmount = Cheque::sum('amount');

       

        if(isset($account['id']))
        $closing_balance=$account->closing_balance('');
    

        return view('cheques.index', compact('cheques','totalAmount','account','closing_balance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::where('status','1')->get();

        $account = Account::find(1003); 
        
        return view('cheques.form', compact('customers','account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
             'account_id'   => 'required|exists:accounts,id',
            'cheque_number' => 'required|unique:cheques,cheque_number,' . ($cheque->id ?? 'NULL') . ',id',
            'cheque_date'   => 'required|date',
            'amount'        => 'required|numeric|min:0',
            //'status'        => 'required|in:pending,cleared,bounced',
            'remarks'       => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();

        Cheque::create($data);

        return redirect()->route('cheques.index')->with('success', 'Cheque saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function show(Cheque $cheque)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function edit(Cheque $cheque)
    {
         $customers = Customer::where('status','1')->get();

        $account = Account::find(1003);
       
        return view('cheques.form', compact('cheque', 'customers','account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cheque $cheque)
    {
        $data = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
              'account_id'   => 'required|exists:accounts,id',
            'cheque_number' => 'required|string|max:50',
            'cheque_date'   => 'required|date',
            'amount'        => 'required|numeric|min:0',
            //'status'        => 'required|in:pending,cleared,bounced',
            'remarks'       => 'nullable|string',
        ]);
          
        $cheque->update($data);

        return redirect()->route('cheques.index')->with('success', 'Cheque updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cheque $cheque)
    {
        $cheque->delete();
        return redirect()->route('cheques.index')->with('success', 'Cheque deleted successfully.');
    }
}
