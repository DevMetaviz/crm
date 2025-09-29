<?php

namespace App\Http\Controllers;

use App\Models\return_note;
use Illuminate\Http\Request;
use App\Models\Stock;


class ReturnNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes= return_note::orderBy('doc_no','desc')->get();
        return view('stock.return_note_list',compact('notes'));
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

    public function create_return_note($stock_id)
    {
        $stock=Stock::find($stock_id);

        $doc_no="RN-".Date("y")."-";
        $num=1;

         $order=return_note::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
         if($order=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $order['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

        return view('stock.return_note',compact('stock','doc_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $active='0';
        if($request->active != '')
            $active='1';
        $return='0';
        if($request->returned != '')
            $return='1';
        
        $re=new return_note;
        $re->stock_id=$request->stock_id;
        $re->doc_no=$request->doc_no;
        $re->doc_date=$request->doc_date;
        $re->unit=$request->unit;
        $re->pack_size=$request->pack_size;
        $re->qty=$request->rejected_qty;
        $re->remarks=$request->remarks;
        $re->activeness=$active;
        $re->returned=$return;

        $re->save();

        return redirect(url('edit/return-note/'.$re->id))->with('success','Return note added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\return_note  $return_note
     * @return \Illuminate\Http\Response
     */
    public function show(return_note $return_note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\return_note  $return_note
     * @return \Illuminate\Http\Response
     */
    public function edit(return_note $return_note)
    {
        return view('stock.edit_return_note',compact('return_note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\return_note  $return_note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $active='0';
        if($request->active != '')
            $active='1';
        $return='0';
        if($request->returned != '')
            $return='1';
        
        $re= return_note::find($request->return_id);
        $re->stock_id=$request->stock_id;
        $re->doc_no=$request->doc_no;
        $re->doc_date=$request->doc_date;
        $re->unit=$request->unit;
        $re->pack_size=$request->pack_size;
        $re->qty=$request->rejected_qty;
        $re->remarks=$request->remarks;
        $re->activeness=$active;
        $re->returned=$return;

        $re->save();

        return redirect()->back()->with('success','Return note updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\return_note  $return_note
     * @return \Illuminate\Http\Response
     */
    public function destroy(return_note $return_note)
    {
        //
    }
}
