<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\Saledemand;
use App\Models\Configuration;
use PDF;

class SaledemandController extends Controller
{
    

    public function index(Request $request)
    {
                       
             
          $demands= Saledemand::orderBy('doc_no','desc')->get();
         

          return view('sale.demand.index',compact('demands'));
    }

    public function create()
    {
    	$code='SD-'.Date("y")."-";

    	
        $num=1;

         $demand=Saledemand::select('id','doc_no')->where('doc_no','like',$code.'%')->orderBy('doc_no','desc')->latest()->first();
         if($demand=='')
         {
              $let=sprintf('%03d', $num);
              $code=$code. $let;
         }
         else
         {
            $let=explode($code , $demand['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $code=$code. $let;
         }


      $products=inventory::with('unit')->where('department_id','1')->where('status','like','1')->orderBy('item_name','asc')->get();
        
        return view('sale.demand.create',compact('products','code'));
    }


        public function store(Request $request)
    {
        $activeness=$request->activeness;
        if($activeness=='')
            $activeness=0;

        $demand=new Saledemand;
         
         $demand->doc_no=$request->doc_no;
        $demand->doc_date=$request->doc_date;
        $demand->from=$request->from;
        $demand->to=$request->to;
        
        $demand->remarks=$request->remarks;

        $demand->activeness=$activeness;
        $demand->save();

        $items_id=$request->items_id;
        $qtys=$request->qtys;

        for($i=0;$i<count($items_id);$i++)
            {
         $demand->items()->attach($items_id[$i] , [ 'qty' => $qtys[$i]  ]);
           }
         
         return redirect('edit/sale-demand/'.$demand['id'])->with('success','Sale demand genrated!');

    }

    public function edit(Saledemand $demand)
    {
        
         
      $products=inventory::with('unit')->where('department_id','1')->where('status','like','1')->orWhere('id',$demand['product_id'])->orderBy('item_name','asc')->get();
        
        return view('sale.demand.edit',compact('products','demand'));

    }

    public function update(Request $request)
    {    

      
        $activeness=$request->activeness;
        if($activeness=='')
            $activeness=0;

        $demand=Saledemand::find($request->id);
         
         $demand->doc_no=$request->doc_no;
        $demand->doc_date=$request->doc_date;
        $demand->from=$request->from;
        $demand->to=$request->to;
        
        $demand->remarks=$request->remarks;

        $demand->activeness=$activeness;
        $demand->save();

          $items_id=$request->items_id;
        $qtys=$request->qtys;

        $rel=array();

           if($items_id)
            {
            for($i=0;$i<count($items_id);$i++)
            {

              $pivot=array( 'qty' => $qtys[$i]  );

                $let=array( $items_id[$i].'' =>$pivot );

                $rel=$rel+$let;  
                
            }
            }

           $demand->items()->sync($rel);
         
         return redirect('edit/sale-demand/'.$demand['id'])->with('success','Sale demand updated!');

    }

    public function demand_print(Saledemand $demand)
    {
       
        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

        $data = [
            
            'demand'=>$demand,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
       
        
           view()->share('sale.demand.demand_report',$data);
        $pdf = PDF::loadView('sale.demand.demand_report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('demand_report.pdf');

      //return view('purchase.edit_purchase',compact('vendors','inventories','departments','purchase','grn','expenses'));
    }








}
