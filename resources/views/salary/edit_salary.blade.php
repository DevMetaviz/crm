
@extends('layout.master')
@section('title', 'Monthly Salary')
@section('header-css')

<style type="text/css">
  #salary_table th {
    position: -webkit-sticky; // this is for all Safari (Desktop & iOS), not for Chrome
    position: sticky;
    top: 0;
    z-index: 10; // any positive value, layer order is global
    background: #fff;
}
</style>
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

     <form role="form" method="post" action="{{url('update-month-salary')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Generate Salaries</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('salary/history')}}"><span class="fas fa-edit">&nbsp</span>History</a>
            <a class="btn" href="{{url('make-salary')}}"><span class="fas fa-edit">&nbsp</span>New</a>

            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/salary/report/'.$salary_doc['id'])}}" class="dropdown-item">Print</a></li>
                        </ul>
                  </div>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Generate Salaries</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Salary Sheet</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <div class="row">
                   
                   <div class="col-md-12">
                   <input type="hidden" name="id" value="{{$salary_doc['id']}}">
                  <label>Doc No</label>
                <input type="text" name="doc_no" id="doc_no" readonly value="{{$salary_doc['doc_no']}}"/>

                <label>Salary Date</label>
                <input type="date" name="doc_date" id="doc_date"  value="{{$salary_doc['doc_date']}}"/> 
                  

                <label>Month</label>
                <input type="month" name="salary_month" id="salary_month" readonly value="{{$salary_doc['month']}}"/>

                 
                     
                   </div>
                </div>
                

                  


              <div class="table-responsive p-0" style="height: 400px;">
              <table id="salary_table" class="table table-bordered table-hover table-head-fixed text-nowrap" style="">
                  
                  
                
                  <thead>
                 <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Current Salary</th>
                     <th>Attendance (Days)</th>
                    <th>Late Comming (Days)</th>
                    <th>Late Fine</th>
                    <th>Overtime(Hrs.)</th>
                    <th>Overtime Amount</th>
                    <th>Earned Salary</th>
                    
                    
                        @foreach($allowances as $all)
                          <th>{{$all['text']}}</th>
                        @endforeach
                     <th>Gross Salary</th>

                        @foreach($deductions as $all)
                          <th>{{$all['text']}}</th>
                        @endforeach
                    
                    <th>Penality Charges</th>
                      <th>I Tax</th>
                    <th>Net Salary</th>
                    <th>Loan Deduction</th>
                    
                    <th>Payable Salary</th>
                   
                    
                  </tr>

                  </thead>
                  <tbody>
                    <?php $sr=1; ?>
                    @if(isset($departments))
                        @foreach($departments as $depart)
                              <tr><td><b>@if($depart['department']==''){{'No Departrment'}}@else {{$depart['department']['name']}} @endif</b>
                               
                              </td></tr>

                               @foreach($depart['employees'] as $emp)
                                   <tr>

                                    <?php $salary=$salary_doc->salary($emp['id']); ?>
                   <input type="hidden" name="salary_ids[]" value="{{$salary['id']}}">

                  <td>{{$sr}}<input type="hidden" name="employee_ids[]" value="{{$emp['id']}}"></td>
                     <td>{{$emp['name']}}</td>
                     <td>@if($emp['designation']!=''){{$emp['designation']['name']}}@endif</td>

                     <td><input type="number" id="{{'basic_salary_'.$emp['id']}}" style="border: none;max-width:100px;" name="basic_salaries[]" value="{{$salary['current_salary']}}" onchange="set('{{$emp['id']}}')" ></td>

                     <td><input type="number" step="any" id="{{'att_days_'.$emp['id']}}" style="border: none;max-width:100px;" name="att_days[]" value="{{$salary['attendance_days']}}" onchange="set('{{$emp['id']}}')" ></td>

                     <td><input type="number" step="any" id="{{'lates_'.$emp['id']}}" style="border: none;max-width:50px;" name="lates[]" value="{{$salary['late_coming_days']}}" onchange="set('{{$emp['id']}}')"></td>

                      <td><input type="number" step="any"  id="{{'late_fine_'.$emp['id']}}" style="border: none;max-width:100px;" name="late_fines[]" value="{{$salary['late_fine']}}" onchange="set('{{$emp['id']}}')"></td>
                    
                     <td><input type="number" step="any"  id="{{'overtime_'.$emp['id']}}" style="border: none;max-width:100px;" name="overtime_hours[]" value="{{$salary['overtime']}}" onchange="set('{{$emp['id']}}')"></td>

                     <td><input type="number" step="any"  id="{{'overtime_amount_'.$emp['id']}}" style="border: none;max-width:100px;" name="overtime_amounts[]" value="{{$salary['overtime_amount']}}" onchange="set('{{$emp['id']}}')"></td>

                     <td><input type="number" step="any"  id="{{'earned_salary_'.$emp['id']}}" style="border: none;max-width:100px;" name="earned_salary[]" value="{{$salary['earned_salary']}}" onchange="set('{{$emp['id']}}')"></td>

                     @foreach($allowances as $all)
                          <td>
                           <?php
                            $amount=''; 
                            if($salary['allowances'] !='' )
                             {
                             $let=$salary['allowances']->where('id',$all['id'])->first();
                                  if($let!='')
                                    $amount=$let['pivot']['amount'];
                             }
                             ?>
                          
                             <input type="number" step="any"  id="{{'alow_'.$all['id'].'_'.$emp['id']}}" style="border: none;max-width:100px;" name="{{'allowances_'.$all['id'].'[]'}}" value="{{$amount}}" onchange="set('{{$emp['id']}}')">
                            
                          </td>
                        @endforeach

                        <td><input type="number" step="any"  id="{{'gross_'.$emp['id']}}" style="border: none;max-width:100px;" name="gross[]" value="{{$salary['gross_salary']}}" onchange="set('{{$emp['id']}}')"></td>

                        @foreach($deductions as $all)
                          <td>
                           <?php
                            $amount=''; 
                            if($salary['deductions'] !='' )
                             {
                                 $let=$salary['deductions']->where('id',$all['id'])->first();
                                  if($let!='')
                                    $amount=$let['pivot']['amount'];

                             }
                             ?>
                          
                             <input type="number" step="any" id="{{'ded_'.$all['id'].'_'.$emp['id']}}" style="border: none;max-width:100px;" name="{{'deductions_'.$all['id'].'[]'}}" value="{{$amount}}" onchange="set('{{$emp['id']}}')">
                            
                          </td>
                        @endforeach
                     
                      <td><input type="number" step="any" id="{{'penality_amount_'.$emp['id']}}" style="border: none;max-width:100px;" name="penality[]" value="{{$salary['penality_charges']}}" onchange="set('{{$emp['id']}}')"></td>

                      <td><input type="number" step="any" id="{{'tax_'.$emp['id']}}" style="border: none;max-width:100px;" name="tax[]" value="{{$salary['tax']}}" onchange="set('{{$emp['id']}}')"></td>
                      <td><input type="number" step="any" id="{{'net_'.$emp['id']}}" style="border: none;max-width:100px;" name="net[]" value="{{$salary['net_salary']}}" onchange="set('{{$emp['id']}}')"></td>
                      <td><input type="number" step="any" id="{{'loan_'.$emp['id']}}" style="border: none;max-width:100px;" name="loan[]" value="{{$salary['loan_deduction']}}" onchange="set('{{$emp['id']}}')"></td>
                      
                      <td><input type="number" step="any" id="{{'payable_'.$emp['id']}}" style="border: none;max-width:100px;" name="payables[]" value="{{$salary['payable_salary']}}" onchange="set('{{$emp['id']}}')"></td>
                    
                     </tr>
                     <?php $sr++; ?>
                               @endforeach

                               <tr>
                     <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                     @foreach($allowances as $all)
                          <th></th>
                        @endforeach
                     <th></th>

                        @foreach($deductions as $all)
                          <th></th>
                        @endforeach
                    <th></th>                    
                    <th></th>
                    <th></th>                    
                    <th></th>
                    <th></th>
                  
                  </tr>

                        @endforeach
                    @endif

                  

                  </tbody>

                   <tfoot>
                  <tr>
                  <th>#</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Current Salary</th>
                    <th>Attendance Days</th>
                    <th>Late Comming (Days)</th>
                    <th>Late Fine</th>
                    <th>Overtime(Hrs.)</th>
                    <th>Overtime Amount</th>
                    <th>Earned Salary</th>
                    
                    @foreach($allowances as $all)
                          <th>{{$all['text']}}</th>
                        @endforeach

                        <th>Gross Salary</th>

                        @foreach($deductions as $all)
                          <th>{{$all['text']}}</th>
                        @endforeach

                    
                    <th>Penality Charges</th>
                    <th>I Tax</th>
                    <th>Net Salary</th>
                    <th>Loan Deduction</th>
                    <th>Payable Salary</th>
                  </tr>
                  </tfoot>
                  

                 

                </table>
                 </div>

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   </form> 



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script type="text/javascript">

  function set(emp_id)
  {
    var month=$(`#salary_month`).val();
    var days='';

    var m_y=month.split("-");
    days=new Date(m_y[0], m_y[1], 0).getDate();

     var salary=$(`#basic_salary_${emp_id}`).val();
      var perDay=salary / days ;
       var att_days=$(`#att_days_${emp_id}`).val();
      var lates=$(`#lates_${emp_id}`).val();
      var fine=( lates  * (perDay /4) ) .toFixed(0);

      $(`#late_fine_${emp_id}`).val(fine);

       var overtime=$(`#overtime_${emp_id}`).val();
           var perHour=perDay / 8 ;
           var overtime_amount=( overtime  * perHour ) .toFixed(0);
      $(`#overtime_amount_${emp_id}`).val(overtime_amount);

      var earned= (perDay * att_days) - fine + parseFloat (overtime_amount) ;
     $(`#earned_salary_${emp_id}`).val(earned);

     var allowances=JSON.parse('<?php echo json_encode($allowances); ?>'); 
      
      var al_amount=0;
     for (var i =0; i < allowances.length ;  i++) {
         var alow=$(`#alow_${allowances[i]['id']}_${emp_id}`).val();
         if(alow=='')
           alow=0;

         al_amount=parseFloat( al_amount )+ parseFloat( alow );
      } 
      
     var gros=( parseFloat(earned) + parseFloat(al_amount) ) .toFixed(0);
       
     $(`#gross_${emp_id}`).val(gros);


      var deductions=JSON.parse('<?php echo json_encode($deductions); ?>');  

      var de_amount=0;
     for (var i =0; i < deductions.length ;  i++) {
         var de=$(`#ded_${deductions[i]['id']}_${emp_id}`).val();
         if(de=='')
           de=0;

         de_amount=parseFloat( de_amount )+ parseFloat( de );
      }


       $(`#payable_${emp_id}`).val(payable); 

       var penality=$(`#penality_amount_${emp_id}`).val(); 

      var tax=$(`#tax_${emp_id}`).val(); 

      var net=(gros - de_amount - penality - tax ) .toFixed(0);
        
        $(`#net_${emp_id}`).val(net); 

        var loan=$(`#loan_${emp_id}`).val(); 

      var payable=(net - loan ) .toFixed(0);

       $(`#payable_${emp_id}`).val(payable); 

  }
  
function setLateFine1(emp_id)
{
   var month=$(`#salary_month`).val();
   var days='';
   if(month=='' || month==null)
   {
    days=30;
   }
   else
   {
      var m_y=month.split("-");
       days=new Date(m_y[0], m_y[1], 0).getDate();
     }
     var salary=$(`#basic_salary_${emp_id}`).val();

     var perDay=salary / days ;

    var lates=$(`#lates_${emp_id}`).val();

     var fine=( (lates / 4) * perDay ) .toFixed(0);

     $(`#late_fine_${emp_id}`).val(fine);
}

</script>





@endsection  
  