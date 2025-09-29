<?php

namespace App\Http\Controllers;

use App\Models\Allowance;

use App\Models\Employee;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allowances=Allowance::orderBy('created_at')->get();
        return view('Allowance.allowances',compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $active=$request->get('activeness');
        if($active=='')
            $active=0;

        $allowance=new Allowance;

        $allowance->text=$request->get('text');
        $allowance->type=$request->get('type');
         //$allowance->type1=$request->get('type1');
         $allowance->sort_order=$request->get('sort_order');
         $allowance->activeness=$active;

        $allowance->save();

     return redirect()->back()->with('success','Allowance Added!');
    }

     public function store_employee_allowance(Request $request)
    {
        $user=Employee::find($request->get('employee_id'));
          //print_r(count ($user->allowances ) );die;
        //$allowance->text=$request->get('text');
        //$allowance->type=$request->get('type');
        $ids = [$request->get('allowance_id')];
         $user->allowances()->attach($request->get('allowance_id') , ['type' => $request->get('type'), 'amount' => $request->get('amount')]);

       return redirect()->back()->with('success','Employee Updated!');

     //return redirect()->back()->with('success','Allowance Added!');
    }

    public function delete_employee_allowance(Request $request)
    {
        $user=Employee::find($request->get('employee_id'));
          //print_r(count ($user->allowances ) );die;
        //$allowance->text=$request->get('text');
        //$allowance->type=$request->get('type');
        $ids = [$request->get('allowance_id')];
         $user->allowances()->detach($request->get('allowance_id') );

       return redirect()->back()->with('success','Employee Updated!');

     //return redirect()->back()->with('success','Allowance Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allowance $allowance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allowance $allowance)
    {
        //
    }
}
