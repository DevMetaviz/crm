<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ticket_process;
use App\Models\Ticket;
use PDF;

class ProductionReportController extends Controller
{
    


    public function ticket_stage_report($ticket_id,$stage_id,$process_identity)
    {
        $ticket_id=$ticket_id;
        $process_id=$stage_id;

        $ticket_process=ticket_process::where('ticket_id',$ticket_id)->where('process_id',$process_id)->where('super_id',0)->first();
        
        $data = [
            
            'ticket_process'=>$ticket_process
        
        ];

       
         //if($process_identity=='granulation')
         $filename='production.reports.'.$process_identity;

         //return view($filename,compact('ticket_process'));

           view()->share($filename,$data);
        $pdf = PDF::loadView($filename , $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($filename.'.pdf');
     

        
    }

    public function master($ticket_id)
    {
        $ticket_id=$ticket_id;
        

        $ticket=Ticket::find($ticket_id);
        
        $data = [
            
            'ticket'=>$ticket
        
        ];

       
         //if($process_identity=='granulation')
         $filename='production.reports.master';

         //return view($filename,compact('ticket_process'));

           view()->share($filename,$data);
        $pdf = PDF::loadView($filename , $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($filename.'.pdf');
     

        
    }






}

