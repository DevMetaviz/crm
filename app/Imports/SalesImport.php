<?php

namespace App\Imports;

use App\Models\Deliverychallan;
use App\Models\outgoing_stock;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\sale_stock;
use App\Models\inventory;
use App\Models\Transection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
      $date='';
               
               // if(strtotime($row['date'])){
               //      $new_date_format = date('Y-m-d', strtotime($row['date']));
               //              $new_date=explode(" ", $new_date_format);
               //          $date=$new_date[0];
               //        //print_r($date);
               //       }
               //       else
               //       {
          $dt=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(  $row['date'] );
               $date=$dt->format('Y-m-d');
            
             //}
                     
             $customer=$row['customer']; $customer_id='';
             $invoice_no=$row['doc_no'];
            $item_id=$row['item_id'];
            $batch_no=$row['batch'];
            $rate=$row['rate'];
            $qty=$row['qty'];   
//print_r($customer);die;
             $c=Customer::where('name',$customer)->first();
                         
              if(!(isset($c['id'])))
              {   
                $c=new Customer; 

                 $c->name=$customer;

                 $c->mobile='0';
                 $c->mid_sale_account_id='0';
                 $c->account_id='0';
                 $c->activeness='1';
                 $c->save();
                 $customer_id=$c['id'];
              }
               else
               { $customer_id=$c['id'];  }
//return ;
              $s=Sale::where('invoice_no','like',$invoice_no)->first();
               
               if($s!='')
                $invoice_id=$s['id'];
              else{
                $s=new Sale;
                 $s->invoice_no=$invoice_no;
                 $s->invoice_date=$date;
                 $s->customer_id=$customer_id;
                 $s->activeness=1;
                 $s->save();
                  $invoice_id=$s['id'];
              }

                 
                 $new=new sale_stock;
                 $new->invoice_id=$invoice_id;
                 $new->item_id=$item_id;
                 $new->unit='loose';
                 $new->qty=$qty;
                 $new->pack_size=1;
                  $new->mrp=500;
                   $new->batch_no=$batch_no;
                    $new->discount_type='flat';
                     $new->discount_factor=$rate;
                      $new->tax=0;
                 $new->save();


                      

                      // $a=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like',$row['status'])->first();
                      // if($a=='')
                      // $a=new Attendance;
                      //  $a->dailyattendance_id=$att['id'];
                      // $a->time=$time;
                      // $a->status=$row['status'];

                      // $a->save();

                      return ;
    }
    
}
