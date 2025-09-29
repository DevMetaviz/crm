<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\InventoryDepartment;
use App\Models\InventoryCategory;
use App\Models\rate_type;
use App\Models\Deliverychallan;
use App\Models\Configuration;
use App\Models\Quotation;
use App\Models\order_item;
use App\Models\Company;
use App\Models\Branch;
use App\Models\inventory;
use Illuminate\Support\Facades\Auth;
use App\Models\Rate;
use App\Models\booking_item;
use App\Models\Purchaseorder;
use PDF;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         /*$orders = Booking::query();


         $orders = $orders->whereRaw('(
            (SELECT COALESCE(SUM(weight), 0) FROM booking_items WHERE booking_id = bookings.id) 
            - 
            (SELECT COALESCE(SUM(total_weight), 0) FROM purchaseorders WHERE booking_id = bookings.id)
        ) > 0');

        if(isset($request['status']) && $request['status']!='')
        {
            if($request['status']==1){
                

            }

        }

         $orders = $orders->orderBy('doc_no','desc')->get();*/

         //$orders = booking_item::with('booking')->join('bookings', 'bookings.id', '=', 'booking_items.booking_id');


         /*$orders = $orders->whereRaw('(
            (SELECT COALESCE(SUM(weight), 0) FROM booking_items WHERE booking_id = bookings.id) 
            - 
            (SELECT COALESCE(SUM(total_weight), 0) FROM purchaseorders WHERE booking_id = bookings.id)
        ) > 0');*/

        

         //$orders = $orders->orderBy('booking.doc_no','desc')->select('booking_items.*')->get();

        //$it=Purchaseorder::where('booking_id',1)->get();

       

   

            $orders = booking_item::with(['booking'])
            ->join('bookings', 'bookings.id', '=', 'booking_items.booking_id')
            ->orderBy('bookings.doc_no', 'desc')
            ->get()
            ->filter(function ($bookingItem) {
                return $bookingItem->received_weight() < $bookingItem->weight;
            });
        

        return view('purchase.booking.index',compact('orders'));
    }

    public function get_vendor_pending_bookings(Request $request)
    {

        $vendor_id=$request->vendor_id;

        

        /*$bookings = Booking::with('categories')->where('vendor_id', $vendor_id)
        ->whereRaw('(
            (SELECT COALESCE(SUM(weight), 0) FROM booking_items WHERE booking_id = bookings.id) 
            - 
            (SELECT COALESCE(SUM(total_weight), 0) FROM purchaseorders WHERE booking_id = bookings.id)
        ) > 0')
        ->get();*/

        $bookings = Booking::with(['categories'])->where('vendor_id', $vendor_id)
    ->hasPendingItems()
    ->orderBy('doc_no', 'desc')
    ->get();
    
    

                        
    return response()->json([
            'success' => true,
            'data' => $bookings
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors=Vendor::where('status','1')->get();
        $companies=Company::with('branches')->get();


        $doc_no="PB-".Date("y")."-";
        $num=1;

         $order=Booking::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
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

        $categories=InventoryCategory::orderBy('name','asc')->get();

          $items=inventory::getItems();

          
       
           $order = new Booking(); 
             $order->doc_no = $doc_no;
             

             $branches=[];


            

        return view('purchase.booking.booking',compact('vendors','companies','order','categories','items','branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chln=Booking::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);



         $category_id=$request->category_id;

       
        $disc=$request->disc;
        $weight=$request->weight;
        $remarks=$request->item_remarks;
        

         
         $status=1;
          
            

        $order=new Booking;

        $order->doc_no=$request->doc_no;
        $order->doc_date=$request->doc_date;

       
        
        $order->status=$status;
      
        $order->vendor_id=$request->vendor_id;
        $order->remarks=$request->remarks;

         $order->user_id = Auth::id();

      
        $order->company_id=$request->company_id;
        $order->branch_id=$request->branch_id;
        

        $order->save();
            
            for($i=0;$i<count($category_id);$i++)
            {
                if(!$category_id[$i]>0)
                    continue;


             $order->categories()->attach($category_id[$i] , ['discount' => $disc[$i] , 'weight' => $weight[$i] ,'remarks'=>$remarks[$i] ]);

           }

          
           $order->total_weight=$order->total_weight();

            $order->save();

           

           $msg='Booking created!';


         return redirect()->back()->with('success',$msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $purchase_booking)
    { 
         $order=$purchase_booking;
        
         $vendors=Vendor::where('status','1')->orWhere('id',$order['vendor_id'])->get();
          $companies=Company::with('branches')->get();
        $categories=InventoryCategory::orderBy('name','asc')->get();

        $items=inventory::getItems();

        $branches = $order->company_id > 0 
        ? Branch::where('company_id', $order->company_id)->get()
        : collect();


        

        

        return view('purchase.booking.booking', compact('order','vendors','companies','categories','items','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $category_id=$request->category_id;

        $pivots_id=$request->pivots_id;
        $disc=$request->disc;
        $weight=$request->weight;
        $remarks=$request->item_remarks;
        

         
         //$status=1;


        $order=Booking::find($request->id);

        $order->doc_no=$request->doc_no;
        $order->doc_date=$request->doc_date;
        
        //$order->status=$status;
      
        $order->vendor_id=$request->vendor_id;
        $order->remarks=$request->remarks;

      
        $order->company_id=$request->company_id;
        $order->branch_id=$request->branch_id;


        $order->save();
                  

    $items=booking_item::where('booking_id',$order['id'])->whereNotIn('id',$pivots_id)->get();

        foreach ($items as $tr) {
            $tr->delete();
        }

           for ($i=0;$i<count($category_id);$i++)
           {

                if(!$category_id[$i]>0)
                    continue;

              


                 if($pivots_id[$i]!=0)
                 $item=booking_item::find($pivots_id[$i]);
                  else
                  $item=new booking_item;

                $item->booking_id=$order['id'];
                $item->category_id=$category_id[$i];
                $item->discount=$disc[$i];
                $item->weight=$weight[$i];
                $item->remarks=$remarks[$i];
                
                $item->save();
           }

           
            $order->total_weight=$order->total_weight();

            $order->save();

            

           $msg='Booking Updated!';

           

                  return redirect()->back()->with('success',$msg);
    }

    public function booking_report(Booking $booking)
    {    
    
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'order'=>$booking,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.order_pdf',compact('order','name','address','logo'));
           view()->share('purchase.booking.order_pdf',$data);
        $pdf = PDF::loadView('purchase.booking.order_pdf', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('purchase.booking.order_pdf.pdf');
    }

    

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $purchase_booking)
    {   
          $order=$purchase_booking;
       
         $challan=Purchaseorder::where('booking_id',$order['id'])->first();


            if($challan!='')
             return redirect()->back()->withErrors(['error'=>'Delete PO first, then booking!']);

         $order->categories()->detach();
         $order->delete();

        return redirect(url('purchase-bookings/create'))->with('success','Booking Deleted!');
    }
}
