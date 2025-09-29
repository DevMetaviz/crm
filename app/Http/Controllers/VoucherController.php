<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Account;
use App\Models\Transection;
use App\Models\Company;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use PDF;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers=Voucher::where('category','voucher')->orderBy('created_at','desc')->get();
        
        return view('voucher.history',compact('vouchers'));
    }

    public function index_new($category,Request $request)
    {

      $from=date("Y-m-d");  $to=date("Y-m-d");
//echo $request->from;die;
      if($request->from!='')
        $from=$request->from;

    if($request->to!='')
        $to=$request->to;

       $query=Voucher::query();

       $query->where('category',$category);

       if($request->voucher_no!='')
        { $query->where('voucher_no', 'LIKE' , '%'.$request->voucher_no.'%'); }

        if($from!='')
        { $query->where('voucher_date', '>=', $from); }
        if($to!='')
        { $query->where('voucher_date', '<=', $to); }

        if($request->company_id!='')
        { $query->where('company_id', $request->company_id); }

        if($request->branch_id!='')
        { $query->where('branch_id',  $request->branch_id); }

    if($request->status!='')
        { $query->where('status', $request->status); }

       $sort_by='updated_at';

        if($request->sort_by!='')
        { $sort_by=$request->sort_by; }
              
        $vouchers=$query->orderBy($sort_by,'desc')->get();

         
        
        return view('voucher.history_new',compact('vouchers','category','from','to'));
    }

    public function show_new($type,Voucher $voucher)
    {
           return view ('voucher.show_new',compact('voucher'));
    }

    public function create_new($type,Voucher $voucher)
    {

        /****
        $acc=Account::find(294);

        $ts=Transection::where('account_id',294)->get();
          $i=1;
        foreach($ts as $t){

             echo $i.' = '.$t['voucher']['voucher_no'].'<br>';

             $voucher=$t['voucher'];

             foreach ($voucher->transections as $trans) {
            $trans->delete();
        }
        $voucher->delete();

             $i++;
        }
die;
          

        
        *******/
          $voucher_type=27;  $category='';

          if(isset($voucher['id']) && $voucher->category!=$category )
          {
            
             //return redirect('voucher/'.$category.'/'.$voucher['id'].'/edit')->withErrors(['error'=>'Invalid voucher!']);
            $type=$voucher->category;
         }

           if($type=='payment'){
               $voucher_type=27;  $category='payment';
           }
           elseif($type=='receipt'){
            $voucher_type=28;  $category='receipt';
           }
           elseif($type=='expense'){
            $voucher_type=27; $category='expense';
           }

           

        
        $voucher_type=Configuration::find($voucher_type);
         $voucher_type_code=$voucher_type['attributes'];

          $doc_no=$voucher_type_code."-".Date("y")."-".Date("m")."-";
           $num=1;
            $find=Voucher::where('voucher_type_id',$voucher_type['id'])->where('voucher_no','like',$doc_no.'%')->orderBy('voucher_no','desc')->first();

         
         if($find=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $find['voucher_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }


        $cashes=Account::where('super_id',119)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $banks=Account::where('super_id',120)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();


        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

         $companies=Company::with('branches')->get();

           $branches=[];

      if(!isset($voucher['id']))
        {
            $voucher=new Voucher;
           $voucher->voucher_no=$doc_no;
           //$voucher->pay_method='cash';
         }
         else{
            $branches = $voucher->company_id > 0 
                      ? Branch::where('company_id', $voucher->company_id)->get()
                      : collect();
         }

         
         //echo json_encode($category);die;
         return view ('voucher.voucher_new',compact('voucher','category','accounts','cashes','banks','companies','branches'));
    }

    public function store_new(Request $request)
{
    $validated = $request->validate([
        'voucher_no' => 'required|unique:vouchers,voucher_no',
        'voucher_date' => 'required|date',
        'category' => 'required|in:payment,receipt,expense',
       // 'main_account_id' => 'required|exists:accounts,id',
        //'accounts.*.account_id' => 'required|exists:accounts,id',
        //'accounts.*.amount' => 'required|numeric|min:1',
        'proofs.*' => 'image|mimes:jpg,jpeg,png|max:2048'
    ], [
    'voucher_no.required'   => 'Voucher number is required.',
    'voucher_no.unique'     => 'This voucher number is already in use.',
    'category.in'           => 'Category must be either payment, receipt, or expense.',
    'proofs.*.image'        => 'Each proof file must be an image.',
    'proofs.*.mimes'        => 'Proofs must be jpg, jpeg, or png.',
    'proofs.*.max'          => 'Proofs must not exceed 2MB.',
]
); 



        $status = $request->status ?? '0';

        $pay_method=$request->pay_method;
        $pay_to=$request->pay_to;
        $category=$request->category;   
          
        

                if ($category === 'receipt') {
                    $voucher_type_id = $pay_method === 'cash' ? 28 : 30;
                } else {
                    $voucher_type_id = $pay_method === 'cash' ? 27 : 29;
                }

       $notes=$request->notes; 
        

            $all_denominations = [5000, 1000, 500, 100, 50, 20, 10, 'coin'];

            $denominations   = [];
            $note_qty        = [];

            foreach ($all_denominations as $deno) {
            $denominations[] = $notes[$deno]['denomination'] ?? 0;
            $note_qty[]      = $notes[$deno]['quantity'] ?? 0;
            }

            $denominations_txt = implode(',', $denominations);
            $note_qty_txt      = implode(',', $note_qty);



    // Save Voucher
    $voucher = Voucher::create([
        'voucher_type_id' => $voucher_type_id,
        'voucher_no' => $validated['voucher_no'],
        'voucher_date' => $validated['voucher_date'],
        'pay_method' => $pay_method,
       'remarks' => $request->remarks,
       'status' => 0,
       'category' => $category,
       'denominations' => $denominations_txt,
       'notes' => $note_qty_txt,
       'company_id' => $request->company_id,
       'branch_id' => $request->branch_id,
       'user_id' => Auth::id(),
       'updated_by' => Auth::id(),
    ]);

    

    // Save Accounts
    /*foreach ($request->accounts as $acc) {
        $voucher->entries()->create([
            'account_id' => $acc['account_id'],
            'amount' => $acc['amount'],
        ]);
    }*/

           $accounts=$request->accounts;

           foreach($accounts as $account )
            {

                if($category=='receipt')
                { $debit=0; $credit=$account['amount']; }
                 else
                { $debit=$account['amount']; $credit=0; }


         $voucher->accounts()->attach($account['account_id'] , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $account['remarks'] , 'cheque_no' => $account['cheque_no'] ,'cheque_date'=>$account['cheque_date'] ,'debit'=>$debit ,'credit'=>$credit  ]);


               
               if($category=='receipt')
              { $debit=$account['amount']; $credit=0; }
              else
               { $debit=0; $credit=$account['amount']; }


          $voucher->accounts()->attach($pay_to , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $account['remarks']  , 'cheque_no' => $account['cheque_no'],'cheque_date'=>$account['cheque_date'] ,'debit'=>$debit ,'credit'=>$credit  ]);
            
           }


    if ($request->hasFile('proofs')) {
    foreach ($request->file('proofs') as $file) {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('proofs'), $filename);

        $voucher->files()->create([
            'path' => 'proofs/' . $filename
        ]);
    }
}



    $msg=ucfirst($category).' saved successfully.';

    return redirect()->back()->with(['success'=>$msg,'voucher_id'=>$voucher['id'] ]);   


}

public function update_new(Request $request, $id)
{
    $voucher = Voucher::findOrFail($id);

    // validate
    $validated = $request->validate([
        'voucher_no'   => 'required|unique:vouchers,voucher_no,' . $voucher->id,
        'voucher_date' => 'required|date',
        'category'     => 'required|in:payment,receipt,expense',
        'proofs.*'     => 'image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'voucher_no.required'   => 'Voucher number is required.',
        'voucher_no.unique'     => 'This voucher number is already in use.',
        'category.in'           => 'Category must be either payment, receipt, or expense.',
        'proofs.*.image'        => 'Each proof file must be an image.',
        'proofs.*.mimes'        => 'Proofs must be jpg, jpeg, or png.',
        'proofs.*.max'          => 'Proofs must not exceed 2MB.',
    ]);

    $status     = $request->status ?? '0';
    $pay_method = $request->pay_method;
    $pay_to     = $request->pay_to;
    $category   = $request->category;

    // voucher type id
    if ($category === 'receipt') {
        $voucher_type_id = $pay_method === 'cash' ? 28 : 30;
    } else {
        $voucher_type_id = $pay_method === 'cash' ? 27 : 29;
    }

    // denominations + notes
    $all_denominations = [5000, 1000, 500, 100, 50, 20, 10, 'coin'];
    $denominations     = [];
    $note_qty          = [];

    foreach ($all_denominations as $deno) {
        $denominations[] = $request->notes[$deno]['denomination'] ?? 0;
        $note_qty[]      = $request->notes[$deno]['quantity'] ?? 0;
    }

    // update voucher
    $voucher->update([
        'voucher_type_id' => $voucher_type_id,
        'voucher_no'      => $validated['voucher_no'],
        'voucher_date'    => $validated['voucher_date'],
        'pay_method'      => $pay_method,
        'remarks'         => $request->remarks,
        //'status'          => $status,
        'category'        => $category,
        'denominations'   => implode(',', $denominations),
        'notes'           => implode(',', $note_qty),
        'company_id'      => $request->company_id,
        'branch_id'       => $request->branch_id,
        'updated_by' => Auth::id(),
        
    ]);

    
    $transections=$voucher->transections;
            $no=0;
        
       
          
           foreach ($request->accounts as $i=>$account) 
           {


            if ($category == 'receipt') {
            $debit = 0; 
            $credit = $account['amount'];
        } else {
            $debit = $account['amount']; 
            $credit = 0;
        }

                   if($no < count($transections))
                $item=$transections[$no];
                  else
                  $item=new Transection;

                $item->voucher_id=$voucher['id'];
                $item->account_id=$account['account_id'];
                $item->account_voucherable_id=$voucher['id'];
                $item->account_voucherable_type='App\Models\Voucher';
                $item->transection_date=$voucher['voucher_date'];
                $item->remarks=$account['remarks'];
                $item->cheque_no=$account['cheque_no'];
                $item->cheque_date=$account['cheque_date'];
                $item->debit=$debit;
                $item->credit=$credit;
                $item->save();
                  $no++;


               if ($category == 'receipt') {
            $debit = $account['amount']; 
            $credit = 0;
        } else {
            $debit = 0; 
            $credit = $account['amount'];
        }


                     if($no < count($transections))
                $item1=$transections[$no];
                  else
                  $item1=new Transection;
                $item1->voucher_id=$voucher['id'];
                $item1->account_id=$pay_to;
                $item1->account_voucherable_id=$voucher['id'];
                $item1->account_voucherable_type='App\Models\Voucher';
                $item1->transection_date=$voucher['voucher_date'];
                $item1->remarks=$account['remarks'];
                $item1->cheque_no=$account['cheque_no'];
                $item1->cheque_date=$account['cheque_date'];
                $item1->debit=$debit;
                $item1->credit=$credit;
                $item1->save();
                $no++;
              
           }

            
          
            
           for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }


   

    // handle proofs
    if ($request->hasFile('proofs')) {
        foreach ($request->file('proofs') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('proofs'), $filename);

            $voucher->files()->create([
                'path' => 'proofs/' . $filename
            ]);
        }
    }

    $msg = ucfirst($category) . ' updated successfully.';

    return redirect()->back()->with(['success' => $msg, 'voucher_id' => $voucher->id]);
}

  public function destroy_new(Voucher $voucher)
    {
        
        $category=$voucher->category;

        foreach ($voucher->transections as $trans) {
            $trans->delete();
        }
        $voucher->delete();

       
        return redirect(url('voucher/'.$category.'/create'))->with('success', ucfirst($category).' Deleted!');
       
    }



    public function voucher_types()
    {
        $types=Configuration::where('type','like','voucher_type')->get();

        return view('voucher.voucher_type',compact('types'));
    }

    public function voucher_type_save(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';

        $depart=new Configuration;

        $depart->name=$request->get('name');
        $depart->type='voucher_type';
        $depart->attributes=$request->get('code');
        $depart->description=$request->get('remarks');
    

        $depart->status=$status;

       

        $depart->save();

     return redirect()->back()->with('success','Voucher Type Added!');
    }

    public function edit_voucher_type($id)
    {
        $types=Configuration::where('type','like','voucher_type')->get();

        $type=Configuration::find($id);

        return view('voucher.edit_voucher_type',compact('types','type'));
    }

    public function voucher_type_update(Request $request)
    {
        $status=$request->get('status');

        if($status=='')
            $status='0';

        $depart=Configuration::find($request->get('id'));

        $depart->name=$request->get('name');
        $depart->type='voucher_type';
        $depart->attributes=$request->get('code');
        $depart->description=$request->get('remarks');
    

        $depart->status=$status;

       

        $depart->save();

     return redirect()->back()->with('success','Voucher Type Updated!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_sub_accounts=Account::where('type','sub_sub')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();
        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $types=Configuration::where('type','like','voucher_type')->where('status',1)->get();

         return view ('voucher.voucher',compact('sub_sub_accounts','accounts','types'));
    }

    public function get_voucher_no(Request $request)
    {
          $voucher_type_id=$request->voucher_type;
         $voucher_type=Configuration::find($voucher_type_id);
         $voucher_type_code=$voucher_type['attributes'];
          
           $voucher_date=$request->voucher_date;
            $let=explode('-', $voucher_date);
            $month=$let[1];
            $year=$let[0];

          $doc_no=$voucher_type_code."-".Date("y",strtotime($voucher_date))."-".$month."-";
           $num=1;

           $voucher=Voucher::where('voucher_type_id',$voucher_type['id'])->where('voucher_no','like',$doc_no.'%')->orderBy('voucher_no','desc')->first();

         
         if($voucher=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $voucher['voucher_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
            //voucher type will use in Voucher
         $data=array('doc_no'=>$doc_no,'voucher_type'=>$voucher_type);

        return response()->json($data, 200);


    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chln=Voucher::where('voucher_no',$request->voucher_no)->first();
            if($chln!='')
             return redirect()->back()->with('error','Voucher no. already existed!');
         
        $sub_accounts_id=$request->sub_accounts_id;

       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;

        $debit=$request->debit;
        $credit=$request->credit;

         
         $status=$request->status;
        if($status=='')
            $status='0';

        $voucher=new Voucher;

         $voucher->voucher_type_id=$request->voucher_type;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->status=$status;
        $voucher->category='voucher';
        
        $voucher->save();
            
            for($i=0;$i<count($accounts_id);$i++)
            {
         $voucher->accounts()->attach($accounts_id[$i] , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date' => $voucher['voucher_date'] , 'remarks' => $remarks[$i] , 'cheque_no' => $cheque_no[$i] ,'cheque_date'=>$cheque_date[$i] ,'debit'=>$debit[$i] ,'credit'=>$credit[$i]  ]);
           }

           
        
        return redirect()->back()->with(['success'=>'Voucher genrated!','voucher_id'=>$voucher['id'] ]);
         return redirect('/edit/voucher/'.$voucher['id'])->with('success','Voucher genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        $sub_sub_accounts=Account::where('type','sub_sub')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();
        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $types=Configuration::where('type','like','voucher_type')->where('status',1)->get();

         return view ('voucher.edit_voucher',compact('voucher','sub_sub_accounts','accounts','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sub_accounts_id=$request->sub_accounts_id;

       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;

        $debit=$request->debit;
        $credit=$request->credit;
        $pivot_ids=$request->pivots_id;
         
         $status=$request->status;
        if($status=='')
            $status='0';

        $voucher=Voucher::find($request->id);

         $voucher->voucher_type_id=$request->voucher_type;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->status=$status;
        $voucher->category='voucher';

        $voucher->save();
    

           $items=Transection::where('account_voucherable_id',$voucher['id'])->where('account_voucherable_type','App\Models\Voucher')->whereNotIn('id',$pivot_ids)->get();

        foreach ($items as $tr) {
                $tr->delete();
        }

           for ($i=0;$i<count($accounts_id);$i++)
           {
                 if($pivot_ids[$i]!=0)
                 $item=Transection::find($pivot_ids[$i]);
                  else
                  $item=new Transection;

                $item->voucher_id=$voucher['id'];
                $item->account_id=$accounts_id[$i];

                $item->account_voucherable_id=$voucher['id'];
                $item->account_voucherable_type='App\Models\Voucher';
                $item->transection_date=$voucher['voucher_date'];
                $item->remarks=$remarks[$i];
                $item->cheque_no=$cheque_no[$i];
                $item->cheque_date=$cheque_date[$i];
                $item->debit=$debit[$i];
            
                $item->credit=$credit[$i];
                $item->save();
           }

          return redirect()->back()->with('success','Voucher updated!');
         
    }

    public function print_voucher(Voucher $voucher)
    {

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        
        $data = [
            
            'voucher'=>$voucher,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        
           view()->share('voucher.voucher_report',$data);
        $pdf = PDF::loadView('voucher.voucher_report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('voucher.voucher_report.pdf');

         
    }

    public function print_voucher1(Voucher $voucher)
    {

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        
        $data = [
            
            'voucher'=>$voucher,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        
           view()->share('voucher.voucher_report1',$data);
        $pdf = PDF::loadView('voucher.voucher_report1', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('voucher.voucher_report1.pdf');

         
    }

    public function print_voucher2(Voucher $voucher)
    {

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        
        $data = [
            
            'voucher'=>$voucher,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        
           view()->share('voucher.voucher_report2',$data);
        $pdf = PDF::loadView('voucher.voucher_report2', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('voucher.voucher_report2.pdf');

         
    }

    public function create_payment()
    {

         $voucher_type=Configuration::find(27);
         $voucher_type_code=$voucher_type['attributes'];

        

          $doc_no=$voucher_type_code."-".Date("y")."-".Date("m")."-";
           $num=1;
           $voucher=Voucher::where('voucher_type_id',$voucher_type['id'])->where('voucher_no','like',$doc_no.'%')->orderBy('voucher_no','desc')->first();

         
         if($voucher=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $voucher['voucher_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }


        $cashes=Account::where('super_id',119)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();


        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        

         return view ('voucher.payment_create',compact('cashes','accounts','doc_no'));
    }

    public function store_payment(Request $request)
    {
        
       $chln=Voucher::where('voucher_no',$request->voucher_no)->first();
            if($chln!='')
             return redirect()->back()->with('error','Voucher no. already existed!');

       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;

        $amount=$request->amount;
                 
         $status=$request->status;
        if($status=='')
            $status='0';

        $pay_method=$request->pay_method;
        $pay_from=$request->pay_from;
          
          if($pay_method=='cash')
          { $voucher_type_id=27; }
          elseif($pay_method=='bank')
            { $voucher_type_id=29; }
       //print_r(json_encode($pay_from));die;
        $voucher=new Voucher;

         $voucher->voucher_type_id=$voucher_type_id;
         $voucher->pay_method=$pay_method;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->remarks=$request->reference;
        $voucher->status=$status;
        $voucher->category='payment';
        
        $voucher->save();
            
            $net_amount=0; //$cheque_no1=''; $cheque_date1='';
            for($i=0; $i<count($accounts_id); $i++)
            {
         $voucher->accounts()->attach($accounts_id[$i] , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $remarks[$i] , 'cheque_no' => $cheque_no[$i] ,'cheque_date'=>$cheque_date[$i] ,'debit'=>$amount[$i] ,'credit'=>0  ]);

          $voucher->accounts()->attach($pay_from , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $remarks[$i] , 'cheque_no' => $cheque_no[$i] ,'cheque_date'=>$cheque_date[$i] ,'debit'=>0 ,'credit'=>$amount[$i]  ]);

         
             // $net_amount +=$amount[$i] ; 
             // $cheque_no1 =$cheque_no1 .','. $cheque_no[$i] ;
             //  $cheque_date1 =$cheque_date1 .','. $cheque_date[$i] ;
             
           }

           //$cheque_no1=substr($cheque_no1,1);
                 //$cheque_date1=substr($cheque_date1,1);

          

         return redirect()->back()->with(['success'=>'Payment genrated!','payment_id'=>$voucher['id'] ]);
         return redirect('/edit/payment/'.$voucher['id'])->with('success','Payment genrated!');
    }

    public function index_payment()
    {
        $vouchers=Voucher::where('category','payment')->orderBy('voucher_date','desc')->get();
        
        return view('voucher.payment_history',compact('vouchers'));
    }

    public function edit_payment(Voucher $voucher)
    {
        $cashes=[];
        if($voucher['pay_method']=='cash')
        $cashes=Account::where('super_id',119)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();
         if($voucher['pay_method']=='bank')
        $cashes=Account::where('super_id',120)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $pay_from=$voucher['accounts']->where('pivot.credit','<>',0)->first();
        //$transections=$voucher['accounts']->where('pivot.debit','<>',0);

        $debit_transections=$voucher['accounts']->where('pivot.debit','<>',0);
        $credit_transection=$voucher['accounts']->where('pivot.credit','<>',0)->first();
        
        $payment=array('id'=>$voucher['id'] , 'voucher_no'=>$voucher['voucher_no'] , 'voucher_date'=>$voucher['voucher_date'] , 'pay_method'=>$voucher['pay_method'] ,'status'=>$voucher['status'] ,'reference'=>$voucher['remarks'] , 'pay_from'=>$pay_from['id'] , 'debit_transections'=>$debit_transections, 'credit_transection'=>$credit_transection  );

        

         return view ('voucher.edit_payment',compact('payment','cashes','accounts'));
    }

    public function update_payment(Request $request)
    {
        

       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;

        $amount=$request->amount;
        $pivot_ids=$request->pivots_id;
        $credit_pivot_id=$request->credit_pivot_id;
//print_r(json_encode($cheque_no));die;
         
         $status=$request->status;
        if($status=='')
            $status='0';

        $pay_method=$request->pay_method;
        $pay_from=$request->pay_from;
          
          if($pay_method=='cash')
          { $voucher_type_id=27; }
          elseif($pay_method=='bank')
            { $voucher_type_id=29; }

        $voucher=Voucher::find($request->id);

         $voucher->voucher_type_id=$voucher_type_id;
         $voucher->pay_method=$pay_method;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->remarks=$request->reference;
        $voucher->status=$status;
        $voucher->category='payment';
        
        $voucher->save();
            
        

          $transections=$voucher->transections;
            $no=0;

               $net_amount=0; $cheque_no1=''; $cheque_date1='';
           for ($i=0;$i<count($accounts_id);$i++)
           {
                 if($no < count($transections))
                 $item=$transections[$no];
                  else
                  $item=new Transection;

                $item->voucher_id=$voucher['id'];
                $item->account_id=$accounts_id[$i];
                $item->account_voucherable_id=$voucher['id'];
                $item->account_voucherable_type='App\Models\Voucher';
                $item->transection_date=$voucher['voucher_date'];
                $item->remarks=$remarks[$i];
                $item->cheque_no=$cheque_no[$i];
                $item->cheque_date=$cheque_date[$i];
                $item->debit=$amount[$i];
                $item->credit=0;
                $item->save();
                $no++;
            

                if($no < count($transections))
                $item1=$transections[$no];
                  else
                  $item1=new Transection;

                $item1->voucher_id=$voucher['id'];
                $item1->account_id=$pay_from;
                $item1->account_voucherable_id=$voucher['id'];
                $item1->account_voucherable_type='App\Models\Voucher';
                $item1->transection_date=$voucher['voucher_date'];
                $item1->remarks=$remarks[$i];
                $item1->cheque_no=$cheque_no[$i];
                $item1->cheque_date=$cheque_date[$i]; 
                $item1->debit=0;
                $item1->credit=$amount[$i];
                $item1->save();

                $no++;
                
           }

      

           for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }
            


         return redirect()->back()->with('success','Payment updated!');
         
    }


    public function create_receipt()
    {

         $voucher_type=Configuration::find(28);
         $voucher_type_code=$voucher_type['attributes'];

       

          $doc_no=$voucher_type_code."-".Date("y")."-".Date("m")."-";
           $num=1;
            $voucher=Voucher::where('voucher_type_id',$voucher_type['id'])->where('voucher_no','like',$doc_no.'%')->orderBy('voucher_no','desc')->first();
//print_r(json_encode($voucher));die;
         
         if($voucher=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $voucher['voucher_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }


        $cashes=Account::where('super_id',119)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();


        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        

         return view ('voucher.receipt_create',compact('cashes','accounts','doc_no'));
    }

    public function store_receipt(Request $request)
    {
        
       $chln=Voucher::where('voucher_no',$request->voucher_no)->first();
            if($chln!='')
             return redirect()->back()->with('error','Voucher no. already existed!');

       $accounts=$request->accounts;
       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;

        $amount=$request->amount;
        
//print_r(json_encode($cheque_no));die;
         
         $status=$request->status;
        if($status=='')
            $status='0';

        $pay_method=$request->pay_method;
        $pay_to=$request->pay_to;
          
          if($pay_method=='cash')
          { $voucher_type_id=28; }
          elseif($pay_method=='bank')
            { $voucher_type_id=30; }


        $all_denominations = [5000,1000,500,100,50,20,10,'coin'];

        $notes=$request->notes; 

        $denominations=[]; $note_qty=[];  $denominations_txt=''; $note_qty_txt='';

        foreach($all_denominations as $deno){

            if($notes[$deno]['denomination']!=''){
               $denominations[]=$notes[$deno]['denomination'];
            }
            else{
                $denominations[]=0;
            }
            
            if($notes[$deno]['quantity']!=''){
               $note_qty[]=$notes[$deno]['quantity'];
            }
            else{
                $note_qty[]=0;
            }
        }

        if(count($denominations)>0)
            $denominations_txt=implode(',', $denominations);

        if(count($note_qty)>0)
            $note_qty_txt=implode(',', $note_qty);

          // echo json_encode($note_qty_txt);die;

        $voucher=new Voucher;

         $voucher->voucher_type_id=$voucher_type_id;
         $voucher->pay_method=$pay_method;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->remarks=$request->reference;
        $voucher->status=$status;
        $voucher->category='receipt';


        $voucher->denominations=$denominations_txt;
        $voucher->notes=$note_qty_txt;

        $voucher->company_id=$request->company_id;
        $voucher->branch_id=$request->branch_id;

         $voucher->user_id = Auth::id();
        
        $voucher->save();
            
            $net_amount=0; 

            /*for($i=0; $i<count($accounts_id); $i++)
            {
         $voucher->accounts()->attach($accounts_id[$i] , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $remarks[$i] , 'cheque_no' => $cheque_no[$i] ,'cheque_date'=>$cheque_date[$i] ,'debit'=>0 ,'credit'=>$amount[$i]  ]);

          $voucher->accounts()->attach($pay_to , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $remarks[$i] , 'cheque_no' => $cheque_no[$i] ,'cheque_date'=>$cheque_date[$i] ,'debit'=>$amount[$i] ,'credit'=>0  ]);
            
           }*/

           foreach($accounts as $account )
            {
         $voucher->accounts()->attach($account['account_id'] , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $account['remarks'] , 'cheque_no' => $account['cheque_no'] ,'cheque_date'=>$account['cheque_date'] ,'debit'=>0 ,'credit'=>$account['amount']  ]);

          $voucher->accounts()->attach($pay_to , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $account['remarks']  , 'cheque_no' => $account['cheque_no'],'cheque_date'=>$account['cheque_date'] ,'debit'=>$account['amount'] ,'credit'=>0  ]);
            
           }

          
         return redirect()->back()->with(['success'=>'Receipt genrated!','receipt_id'=>$voucher['id'] ]);
         return redirect('/edit/receipt/'.$voucher['id'])->with('success','Receipt genrated!');
    }

    public function index_receipt()
    {
        $vouchers=Voucher::where('category','receipt')->orderBy('voucher_date','desc')->get();
        
        return view('voucher.receipt_history',compact('vouchers'));
    }

    public function edit_receipt(Voucher $voucher)
    {
        $cashes=[];
        if($voucher['pay_method']=='cash')
        $cashes=Account::where('super_id',119)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();
         if($voucher['pay_method']=='bank')
        $cashes=Account::where('super_id',120)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $pay_to=$voucher['accounts']->where('pivot.debit','<>',0)->first();
        $transections=$voucher['accounts']->where('pivot.credit','<>',0);

        $debit_transection=$voucher['accounts']->where('pivot.debit','<>',0)->first();
        $credit_transections=$voucher['accounts']->where('pivot.credit','<>',0);
        //print_r( json_encode( $transections ) );die;
        $payment=array('id'=>$voucher['id'] , 'voucher_no'=>$voucher['voucher_no'] , 'voucher_date'=>$voucher['voucher_date'] , 'pay_method'=>$voucher['pay_method'] ,'status'=>$voucher['status'] ,'reference'=>$voucher['remarks'] , 'pay_to'=>$pay_to['id'] , 'credit_transections'=>$credit_transections, 'debit_transection'=>$debit_transection  );

        

         return view ('voucher.edit_receipt',compact('payment','cashes','accounts'));
    }


    public function update_receipt(Request $request)
    {
        

       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;

        $amount=$request->amount;
        $pivot_ids=$request->pivots_id;
        $debit_pivot_id=$request->debit_pivot_id;
//print_r(json_encode($cheque_no));die;
         
         $status=$request->status;
        if($status=='')
            $status='0';

        $pay_method=$request->pay_method;
        $pay_to=$request->pay_to;
          
          if($pay_method=='cash')
          { $voucher_type_id=28; }
          elseif($pay_method=='bank')
            { $voucher_type_id=30; }


        $voucher=Voucher::find($request->id);

         $voucher->voucher_type_id=$voucher_type_id;
         $voucher->pay_method=$pay_method;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->remarks=$request->reference;
        $voucher->status=$status;
        $voucher->category='receipt';
        
        $voucher->save();

         $transections=$voucher->transections;
            $no=0;
        
         $net_amount=0; $cheque_no1=''; $cheque_date1='';
          
           for ($i=0;$i<count($accounts_id);$i++)
           {
                   if($no < count($transections))
                $item=$transections[$no];
                  else
                  $item=new Transection;

                $item->voucher_id=$voucher['id'];
                $item->account_id=$accounts_id[$i];
                $item->account_voucherable_id=$voucher['id'];
                $item->account_voucherable_type='App\Models\Voucher';
                $item->transection_date=$voucher['voucher_date'];
                $item->remarks=$remarks[$i];
                $item->cheque_no=$cheque_no[$i];
                $item->cheque_date=$cheque_date[$i];
                $item->debit=0;
                $item->credit=$amount[$i];
                $item->save();
                  $no++;


                     if($no < count($transections))
                $item1=$transections[$no];
                  else
                  $item1=new Transection;
                $item1->voucher_id=$voucher['id'];
                $item1->account_id=$pay_to;
                $item1->account_voucherable_id=$voucher['id'];
                $item1->account_voucherable_type='App\Models\Voucher';
                $item1->transection_date=$voucher['voucher_date'];
                $item1->remarks=$remarks[$i];
                $item1->cheque_no=$cheque_no[$i];
                $item1->cheque_date=$cheque_date[$i];
                $item1->debit=$amount[$i];
                $item1->credit=0;
                $item1->save();
                $no++;
              
           }

            
          
            
           for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }
    

                       
           

         return redirect()->back()->with('success','Receipt updated!');
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        
        $category=$voucher->category;

        foreach ($voucher->transections as $trans) {
            $trans->delete();
        }
        $voucher->delete();

        if($category=='expense')
        return redirect(url('expense/create'))->with('success','Expense Deleted!');
        elseif($category=='payment')
        return redirect(url('payment/create'))->with('success','Payment Deleted!');
        elseif($category=='receipt')
        return redirect(url('receipt/create'))->with('success','Receipt Deleted!');
        elseif($category=='voucher')
        return redirect(url('voucher/create'))->with('success','Voucher Deleted!');
    }

    //expense start functions

    public function create_expense()
    {

         $voucher_type=Configuration::find(27);
         $voucher_type_code=$voucher_type['attributes'];

       

          $doc_no=$voucher_type_code."-".Date("y")."-".Date("m")."-";
           $num=1;

            $voucher=Voucher::where('voucher_type_id',$voucher_type['id'])->where('voucher_no','like',$doc_no.'%')->orderBy('voucher_no','desc')->first();

         
         if($voucher=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $voucher['voucher_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }


        $cashes=Account::where('super_id',119)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();


        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        

         return view ('voucher.expense_create',compact('cashes','accounts','doc_no'));
    }

    public function store_expense(Request $request)
    {
        
       $chln=Voucher::where('voucher_no',$request->voucher_no)->first();
            if($chln!='')
             return redirect()->back()->with('error','Voucher no. already existed!');

       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;

        $amount=$request->amount;
                 
         $status=$request->status;
        if($status=='')
            $status='0';

        $pay_method=$request->pay_method;
        $pay_from=$request->pay_from;
          
          if($pay_method=='cash')
          { $voucher_type_id=27; }
          elseif($pay_method=='bank')
            { $voucher_type_id=29; }
       //print_r(json_encode($pay_from));die;
        $voucher=new Voucher;

         $voucher->voucher_type_id=$voucher_type_id;
         $voucher->pay_method=$pay_method;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->remarks=$request->reference;
        $voucher->status=$status;
        $voucher->category='expense';
        
        $voucher->save();
            
            $net_amount=0;
            for($i=0; $i<count($accounts_id); $i++)
            {
         $voucher->accounts()->attach($accounts_id[$i] , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $remarks[$i] , 'cheque_no' => $cheque_no[$i] ,'cheque_date'=>$cheque_date[$i] ,'debit'=>$amount[$i] ,'credit'=>0  ]);

        $voucher->accounts()->attach($pay_from , ['account_voucherable_id'=>$voucher['id'],'account_voucherable_type'=>'App\Models\Voucher', 'transection_date'=>$voucher['voucher_date'], 'remarks' => $remarks[$i] , 'cheque_no' => $cheque_no[$i] ,'cheque_date'=>$cheque_date[$i] ,'debit'=>0 ,'credit'=>$amount[$i]   ]);
             
           }

      
          
         return redirect()->back()->with(['success'=>'Expense genrated!','expense_id'=>$voucher['id'] ]);
         return redirect('/edit/expense/'.$voucher['id'])->with('success','Expense added!');
    }

    public function index_expense()
    {
        $vouchers=Voucher::where('category','expense')->orderBy('voucher_date','desc')->get();
        
        return view('voucher.expense_history',compact('vouchers'));
    }

    public function edit_expense(Voucher $voucher)
    {
        $cashes=[];
        if($voucher['pay_method']=='cash')
        $cashes=Account::where('super_id',119)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();
         if($voucher['pay_method']=='bank')
        $cashes=Account::where('super_id',120)->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $accounts=Account::with('super_account','super_account.account_type')->where('type','detail')->where('status',1)->orderBy('name','asc')->orderBy('created_at','desc')->get();

        $pay_from=$voucher['accounts']->where('pivot.credit','<>',0)->first();

        $debit_transections=$voucher['accounts']->where('pivot.debit','<>',0);
        $credit_transection=$voucher['accounts']->where('pivot.credit','<>',0)->first();
        
        $payment=array('id'=>$voucher['id'] , 'voucher_no'=>$voucher['voucher_no'] , 'voucher_date'=>$voucher['voucher_date'] , 'pay_method'=>$voucher['pay_method'] ,'status'=>$voucher['status'] ,'reference'=>$voucher['remarks'] , 'pay_from'=>$pay_from['id'] , 'debit_transections'=>$debit_transections ,'credit_transection'=>$credit_transection );

        

         return view ('voucher.edit_expense',compact('payment','cashes','accounts'));
    }

    public function update_expense(Request $request)
    {
        

       $accounts_id=$request->accounts_id;
       $remarks=$request->remarks;
        $cheque_no=$request->cheque_no;
        $cheque_date=$request->cheque_date;
        $amount=$request->amount;
        $pivot_ids=$request->pivots_id;
         $credit_pivot_id=$request->credit_pivot_id;
//print_r(json_encode($cheque_no));die;
         
         $status=$request->status;
        if($status=='')
            $status='0';

        $pay_method=$request->pay_method;
        $pay_from=$request->pay_from;
          
          if($pay_method=='cash')
          { $voucher_type_id=27; }
          elseif($pay_method=='bank')
            { $voucher_type_id=29; }

        $voucher=Voucher::find($request->id);

         $voucher->voucher_type_id=$voucher_type_id;
         $voucher->pay_method=$pay_method;
        $voucher->voucher_date=$request->voucher_date;
        $voucher->voucher_no=$request->voucher_no;
        $voucher->remarks=$request->reference;
        $voucher->status=$status;
        $voucher->category='expense';
        
        $voucher->save();
            
           



           $transections=$voucher->transections;
            $no=0;

             

           for ($i=0;$i<count($accounts_id);$i++)
           {
                 if($no < count($transections))
                 $item=$transections[$no];
                  else
                  $item=new Transection;

                $item->voucher_id=$voucher['id'];
                $item->account_id=$accounts_id[$i];
                $item->account_voucherable_id=$voucher['id'];
                $item->account_voucherable_type='App\Models\Voucher';
                $item->transection_date=$voucher['voucher_date'];
                $item->remarks=$remarks[$i];
                $item->cheque_no=$cheque_no[$i];
                $item->cheque_date=$cheque_date[$i];
                $item->debit=$amount[$i];
                $item->credit=0;
                $item->save();
                 $no++;

                if($no < count($transections))
                 $item1=$transections[$no];
                  else
                  $item1=new Transection;

                $item1->voucher_id=$voucher['id'];
                $item1->account_id=$pay_from;
                $item1->account_voucherable_id=$voucher['id'];
                $item1->account_voucherable_type='App\Models\Voucher';
                $item1->transection_date=$voucher['voucher_date'];
                $item1->remarks=$remarks[$i];
                $item1->cheque_no=$cheque_no[$i];
                $item1->cheque_date=$cheque_date[$i];
                $item1->debit=0;
                $item1->credit=$amount[$i];
                $item1->save(); 

                $no++; 
                
           }

            for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }


                      

         return redirect()->back()->with('success','Expense updated!');
         
    }

    //end expense funtions
}
