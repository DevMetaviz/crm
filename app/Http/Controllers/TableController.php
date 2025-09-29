<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\table_column;
use App\Models\Process;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables=Table::get();

        return view('production.table_list',compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('production.table',compact('processes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $active=0;
                 if($request->activeness!='')
                    $active=$request->activeness;

                $table=new Table;
                $table->name=$request->name;
               
               $table->identity=$request->identity;
               $table->process_id=$request->process_id;
               $table->no_of_rows=$request->no_of_rows;
               $table->sort_order=$request->sort_order;
         
        
               $table->remarks=$request->remarks;
               $table->activeness=$active;
               $table->save();
              
              $headings=$request->headings;
              $types=$request->types;
              $footer_types=$request->footer_types;
              $footer_texts=$request->footer_texts;
              $sort_orders=$request->sort_orders;

              if($headings!='')
              {
                 for ($i=0 ; $i < count($headings) ; $i++) { 
                     
                      $col=new table_column;
                      $col->table_id=$table->id;
                $col->heading=$headings[$i];
               
               $col->type=$types[$i];
               
               $col->footer_type=$footer_types[$i];
         
        
               $col->footer_text=$footer_texts[$i];
               $col->sort_order=$sort_orders[$i];
               $col->save();

                 }
              }

               

               return redirect()->back()->with('success','Table saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
      $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('production.table_edit',compact('table','processes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $active=0;
                 if($request->activeness!='')
                    $active=$request->activeness;

                $table=Table::find($request->table_id);
                $table->name=$request->name;
               
               $table->identity=$request->identity;

               $table->no_of_rows=$request->no_of_rows;
               
               $table->sort_order=$request->sort_order;

               $table->process_id=$request->process_id;
         
        
               $table->remarks=$request->remarks;
               $table->activeness=$active;
               $table->save();
              
              $col_ids=$request->col_ids;
              $headings=$request->headings;
              $types=$request->types;
              $footer_types=$request->footer_types;
              $footer_texts=$request->footer_texts;
              $sort_orders=$request->sort_orders;
            
              $lets=table_column::where( 'table_id',$table['id'] )->whereNotIn('id', $col_ids )->get();
   //print_r(json_encode($col_ids).' '.json_encode($lets));die;
              foreach ($lets as $key ) {
                  $key->delete();
              }

              //print_r(json_encode($let));die;

              if($headings!='')
              {
                 for ($i=0 ; $i < count($headings) ; $i++) { 
                     
                    if( $col_ids[$i] != 0 )
                     $col=table_column::find($col_ids[$i]);
                    else
                      $col=new table_column;

                      $col->table_id=$table->id;
                $col->heading=$headings[$i];
               
               $col->type=$types[$i];
               
               $col->footer_type=$footer_types[$i];
         
        
               $col->footer_text=$footer_texts[$i];
               $col->sort_order=$sort_orders[$i];
               $col->save();

                 }
              }

               

               return redirect()->back()->with('success','Table updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        //
    }
}
