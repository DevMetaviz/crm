<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts=Shift::orderBy('created_at')->get();
        return view('shift.index',compact('shifts'));
    }

    public function define_shift()
    {
        
        $leaves=LeaveType::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('shift.create',compact('leaves'));
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
        $let_shifts=Shift::where('shift_name','=',$request->get('shift_name') )->get();
        if(count($let_shifts)!=0)
        {
    
             return back()->withInput()->withErrors(['msg'=> 'Shift already exists']);
        }

        $shift=new Shift;
        
        $shift->shift_name=$request->get('shift_name');
        $shift->start_time=$request->get('start_time');
        $shift->end_time=$request->get('end_time');
        $shift->relaxation=$request->get('relaxation');
        $shift->overtime_start=$request->get('overtime_start');

         $shift->attendance=$request->get('attendance');
          $shift->late_deduction=$request->get('late_deduction');
        // if($request->get('offdays'))
        // $shift->offdays=implode(",",$request->get('offdays'));
        // if($request->get('alter_offdays'))
        // $shift->alter_offdays=implode(",",$request->get('alter_offdays'));
        $shift->save();
        
        $leaves=LeaveType::where('activeness','like','active')->orderBy('sort_order','asc')->get();
    
        foreach ($leaves as $leave) {
            
                $allowed_leave=$request->get($leave['id']);

            

                if($allowed_leave!='')
               {
                    $shift->leave_types()->attach($leave['id'] , ['allowed_leave' => $allowed_leave ]);
                }
        }
    

     return redirect()->back()->with('success','Shift Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
         $allowed_leave=array();
         foreach ($shift['leave_types'] as $le) {

              $attributes= $le['pivot']['allowed_leave'] ;

             $label=$le['pivot']['leave_type_id'].'_';
             $let=array( $label=>$attributes );
             
             $allowed_leave=array_merge($allowed_leave,$let);
               //print_r($let);//die;
             // array_push($allowed_leave, $label=>$attributes  )
            
         }//die;
        // print_r($allowed_leave);die;
        $leaves=LeaveType::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('shift.edit',compact('shift','allowed_leave','leaves'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {    
        $let_shifts=Shift::where('id','!=',$shift['id'])->where('shift_name','=',$request->get('shift_name') )->get();
        if(count($let_shifts)!=0)
        {
             
             return back()->withErrors(['msg'=> 'Shift already exists']);
        }
        $shift->shift_name=$request->get('shift_name');
        $shift->start_time=$request->get('start_time');
        $shift->end_time=$request->get('end_time');
        $shift->relaxation=$request->get('relaxation');
        $shift->overtime_start=$request->get('overtime_start');

        $shift->attendance=$request->get('attendance');
          $shift->late_deduction=$request->get('late_deduction');


        // if($request->get('offdays'))
        // {
        //     $shift->offdays=implode(",",$request->get('offdays'));
        //  }
        // else
        // {
        //    $shift->offdays=''; 
        // }
        // if($request->get('alter_offdays'))
        // {
        //     $shift->alter_offdays=implode(",",$request->get('alter_offdays'));
        // }
        // else
        // {
        //    $shift->alter_offdays=''; 
        // }
        $shift->save();
         $shift->leave_types()->detach();


         $leaves=LeaveType::where('activeness','like','active')->orderBy('sort_order','asc')->get();
    
        foreach ($leaves as $leave) {
            
                $allowed_leave=$request->get($leave['id']);

                

                if($allowed_leave!='')
               {
                   // $shift->leave_types()->attach($leave['id'] , ['attributes' => json_encode($attributes) ]);
                    $shift->leave_types()->attach($leave['id'] , ['allowed_leave' => $allowed_leave ]);
                }
        }

     return redirect()->back()->with('success','Shift Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        //
    }
}
