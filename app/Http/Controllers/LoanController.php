<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Employee;
use App\Models\loan_installment;

class LoanController extends Controller
{
    //

    public function index()
    {
        $loans=Loan::orderBy('doc_no','desc')->get();
        return view('loan.index',compact('loans'));
    }

    public function create(Request $request)
    {
        $employees=Employee::where('activeness','active')->orderBy('name')->get();

        $doc_no="LR-".Date("y")."-";
        $num=1;

         $loan=Loan::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
         if($loan=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $loan['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

        return view('loan.request',compact('doc_no','employees'));
    }

    public function store(Request $request)
    {   
        $ln=Loan::where('doc_no',$request->request_no)->first();
            if($ln!='')
             return redirect()->back()->withErrors(['error'=>'Request No. already existed!']);

        $active=0; $paid=0; $status=0;
        if($request->active=='1')
            $active=1;
        if($request->paid=='1')
            $paid=1;

        if($request->status=='1')
            $status=1;
        elseif($request->status=='2')
            $status=2;

        $loan=new Loan;
        $loan->doc_no=$request->request_no;
        $loan->request_date=$request->request_date;
        $loan->loan_type=$request->loan_type;
        $loan->loan_amount=$request->loan_amount;
        $loan->employee_id=$request->employee_id;
        $loan->emp_remarks=$request->emp_remarks;
        $loan->activeness=$active;
        $loan->is_paid=$paid;
        $loan->approved_amount=$request->approved_amount;
        $loan->authorized_by=$request->authorized_by;
        $loan->remarks=$request->remarks;
        $loan->status=$status;
        $loan->save();

        $amounts=$request->amounts;
        $months=$request->months;


        for ($i=0; $i < count($amounts) ; $i++) {
         
          if($loan->loan_type=='Short Term')
          {
             if($months[$i]=='')
                break;
          }

        $instal=new loan_installment;
        $instal->loan_id=$loan->id;
        $instal->amount=$amounts[$i];
        $instal->month=$months[$i];
        $instal->is_deducted=0;
        $instal->save();

        }
        
        
        
        return redirect()->back()->with('success','Request Genrated!');
    }

    public function edit($doc_no)
    {
        $employees=Employee::where('activeness','active')->orderBy('name')->get();

        $loan=Loan::where('doc_no',$doc_no)->first();

        return view('loan.edit',compact('loan','employees'));
    }

    public function update(Request $request)
    {
        
        $active=0; $paid=0; $status=0;
        if($request->active=='1')
            $active=1;
        if($request->paid=='1')
            $paid=1;

        if($request->status=='1')
            $status=1;
        elseif($request->status=='2')
            $status=2;

        $loan= Loan::find($request->id);
        //$loan->doc_no=$request->request_no;
        $loan->request_date=$request->request_date;
        $loan->loan_type=$request->loan_type;
        $loan->loan_amount=$request->loan_amount;
        $loan->employee_id=$request->employee_id;
        $loan->emp_remarks=$request->emp_remarks;
        $loan->activeness=$active;
        $loan->is_paid=$paid;
        $loan->approved_amount=$request->approved_amount;
        $loan->authorized_by=$request->authorized_by;
        $loan->remarks=$request->remarks;
        $loan->status=$status;
        $loan->save();

        $amounts=$request->amounts;
        $months=$request->months;

         $installs=$loan['installments']; $n=0;
        for ($i=0; $i < count($amounts) ; $i++) {
         
          if($loan->loan_type=='Short Term')
          {
             if($months[$i]=='')
                break;
          }
           
           if($n<count($installs))
           $instal=loan_installment::find($installs[$n]['id']);
           else
             $instal=new loan_installment;
        $instal->loan_id=$loan->id;
        $instal->amount=$amounts[$i];
        $instal->month=$months[$i];
        $instal->is_deducted=0;
        $instal->save();
           $n++;
        }

        for($i=$n; $i<count($installs) ;$i++)
        {
           $instal=loan_installment::find($installs[$i]['id']);
           $instal->delete(); 
           
        }
        
        
        
        return redirect()->back()->with('success','Request Updated!');
    }


}
