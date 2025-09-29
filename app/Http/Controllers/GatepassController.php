<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use Illuminate\Http\Request;
use App\Models\gatepass_item;
use App\Models\Configuration;
use PDF;

class GatepassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passes=Gatepass::orderBy('created_at')->get();

        return view('admin.gate_pass_history',compact('passes'));

    }

     public function get_pass_no(Request $request)
    {
        $type=$request->type;
        $doc_no=Gatepass::getDocNo($type);

        return response()->json($doc_no, 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $doc_no=Gatepass::getDocNo('outward');
        return view('admin.gatepass',compact('doc_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chln=Gatepass::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);
         $items=$request->items;

       
       $units=$request->units;
        $qtys=$request->qtys;
        $rmrks=$request->rmrks;

         
         $active=$request->active;
        if($active=='')
            $active='0';

        $order=new Gatepass;

        $order->doc_no=$request->doc_no;
        $order->doc_date=$request->doc_date;
        
        
        $order->activeness=$active;
        $order->type=$request->type;
        $order->returnable=$request->returnable;
        $order->name=$request->name;
         $order->vehicle=$request->vehicle;
         $order->time_out=$request->time_out;
         $order->time_in=$request->time_in;
        $order->remarks=$request->remarks;

        $order->save();
            
            for($i=0;$i<count($items);$i++)
            {
                 $or=new gatepass_item;

               $or->gatepass_id=$order['id']; 
               $or->item=$items[$i];
               $or->qty=$qtys[$i];
               $or->unit=$units[$i];
               $or->remarks=$rmrks[$i];

               $or->save(); 
           }

         return redirect(url('edit/gate-pass/'.$order['id']))->with('success','Gatepass genrated!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gatepass  $gatepass
     * @return \Illuminate\Http\Response
     */
    public function show(Gatepass $gatepass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gatepass  $gatepass
     * @return \Illuminate\Http\Response
     */
    public function edit(Gatepass $pass)
    {
        return view('admin.edit_gatepass',compact('pass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gatepass  $gatepass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $chln=Gatepass::where('id','<>',$request->id)->where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Pass No. already existed!']);
         $items=$request->items;
          $ids=$request->ids;
       
       $units=$request->units;
        $qtys=$request->qtys;
        $rmrks=$request->rmrks;

         
         $active=$request->active;
        if($active=='')
            $active='0';

        $order=Gatepass::find($request->id);

        $order->doc_no=$request->doc_no;
        $order->doc_date=$request->doc_date;
        
        
        $order->activeness=$active;
        $order->type=$request->type;
        $order->returnable=$request->returnable;
        $order->name=$request->name;
         $order->vehicle=$request->vehicle;
         $order->time_out=$request->time_out;
         $order->time_in=$request->time_in;
        $order->remarks=$request->remarks;

        $order->save();

        $let=gatepass_item::whereNotIn('id',$ids)->get();
           foreach ($let as $key ) {
               $key->delete();
           }
            
            for($i=0;$i<count($items);$i++)
            {
                 if($ids[$i]!=0)
                 $or=gatepass_item::find($ids[$i]);
                 else
                 $or=new gatepass_item;

               $or->gatepass_id=$order['id']; 
               $or->item=$items[$i];
               $or->qty=$qtys[$i];
               $or->unit=$units[$i];
               $or->remarks=$rmrks[$i];

               $or->save(); 
           }

         return redirect()->back()->with('success','Gatepass updated!');
    }

     public function print_gatepass(Gatepass $pass)
    {
        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'pass'=>$pass,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.order_pdf',compact('order','name','address','logo'));
           view()->share('admin.pass_pdf',$data);
        $pdf = PDF::loadView('admin.pass_pdf', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('admin.pass_pdf.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gatepass  $gatepass
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gatepass $gatepass)
    {
        //
    }
}
