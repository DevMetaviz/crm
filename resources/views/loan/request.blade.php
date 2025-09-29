
@extends('layout.master')
@section('title', 'Loan Request')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('save/loan/request')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Loan Request</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('loan/request/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employee</a></li>
              <li class="breadcrumb-item active">Loan Request</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <!-- <div class="card"> -->
              <!-- <div class="card-header"> -->
                <!-- <h3 class="card-title">Return Note</h3> -->

                <!-- tools card -->
                <!-- <div class="card-tools"> -->
                  <!-- button with a dropdown -->
                  <!-- <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="{{url('create/return-note')}}" class="dropdown-item">Return Note</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div> -->
                  
                <!-- </div> -->
                <!-- /. tools -->
                 
              <!-- </div> -->

              
              <!-- /.card-header -->
              <!-- <div class="card-body"> -->

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                
                
                <div class="row">

                  <div class="col-md-5">


                <div class="form-row">

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Request No.</label>
                  <input type="text" form="ticket_form" name="request_no" class="form-control col-sm-8" value="{{$doc_no}}" required style="width: 100%;">
                  </div>
                 </div>
               
               <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Request Date</label>
                  <input type="date" form="ticket_form" name="request_date" class="form-control col-sm-8" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>
                 </div>


                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Loan Type</label>
                  <select form="ticket_form" name="loan_type" id="loan_type" onchange="changeType()" class="form-control col-sm-8" required>
                    <option value="Short Term">Short Term</option>
                    <option value="Long Term">Long Term</option>
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Loan Amount</label>
                  <input type="number" step="any" min="1" form="ticket_form" name="loan_amount" id="loan_amount" class="form-control col-sm-8" value=""    required style="width: 100%;">
                  </div>
                 </div>
                  
                  

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Employee</label>
                  <select form="ticket_form" name="employee_id" class="form-control select2 col-sm-8" required >
                    <option value="">Select any employee</option>
                    @foreach($employees as $emp)
                    <?php 
                       $d='';
                    if($emp['designation']!='')
                      $d=$emp['designation']['name'];
                     ?>
                    <option value="{{$emp['id']}}">{{$emp['name'].'~'.$d}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>
                   
                   
                 

                 

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Employee Remarks</label>
                  <textarea form="ticket_form" name="emp_remarks" class="form-control col-sm-8" style="width: 100%;"></textarea>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">

                   
                  <label class="col-sm-3 offset-sm-4"><input type="checkbox" form="ticket_form" name="active" id="active" class="" value="1" checked>&nbsp&nbspActive</label>

                  <label class="col-sm-3"><input type="checkbox" form="ticket_form" name="paid" id="paid" class="" value="1" >&nbsp&nbspPaid</label> 


                  
                  </div>
                 </div>

               

               </div>
 
                   </div><!--outter row col-->
                     <div class="col-md-5">
                        <fieldset class="border p-4">
                          <legend class="w-auto">Approval</legend>

                         <div class="form-row">

                          <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Approved Amount</label>
                  <input type="number" step="any" form="ticket_form" min="0" name="approved_amount" id="approved_amount" class="form-control col-sm-8" value=""     style="width: 100%;">
                  </div>
                 </div>
                  
                  

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Authorized By</label>
                  <select form="ticket_form" name="authorized_by" class="form-control select2 col-sm-8">
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <?php 
                       $d='';
                    if($emp['designation']!='')
                      $d=$emp['designation']['name'];
                     ?>
                    <option value="{{$emp['id']}}">{{$emp['name'].'~'.$d}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks</label>
                  <textarea form="ticket_form" name="remarks" class="form-control col-sm-8" style="width: 100%;"></textarea>
                  </div>
                 </div>

                         <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12 text-success"><input type="radio" form="ticket_form" name="status" value="1" id="is_approved" onclick="" class="">&nbsp&nbspApproved</label>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12 text-danger"><input type="radio" form="ticket_form" name="status" value="2" id="is_rejected" onclick="" >&nbsp&nbspRejected</label>
                  </div>
                </div>

              </div>
            </fieldset> 
                     </div>
                </div><!--outter row-->


                <!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Installments</a></li>
        <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Installments</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC">Unit Detail</a></li>
         <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabD">Other Info</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabE">Tab E</a></li> -->
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="tabA">


      


    
      <fieldset class="border p-4" id="add_installment" style="display: none;">
        <legend class="w-auto">Add Installment</legend>

        <div id="add_error" style="display: none;"><p class="text-danger" id="add_error_txt"></p></div>
      

      <div class="form-row">

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Amount</label>
                  <input type="number" step="any" form="ticket_form" name="installment_amount" id="installment_amount" class="form-control col-sm-8" value=""  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Month</label>
                  <input type="month" form="ticket_form" name="installment_month" id="installment_month" class="form-control col-sm-8" value=""  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-2">
                   <button class="btn" form="addInstallment" onclick="addInstallment()"><span class="fa fa-plus-circle text-info"></span></button>
                   <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default" data-tooltip="tooltip" data-placement="bottom" title="Click to make installments auto!">
                  <span class="fa fa-cog"></span>
                </button>

                <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Make Installments</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="err" style="display: none;"><p class="text-danger" id="err_txt"></p></div>
                     <div class="form-row">

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-5">Monthly Deduction</label>
                  <input type="number" step="any"  name="per_month_deduction" id="per_month_deduction" class="form-control col-sm-7" value=""  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-5">Start From</label>
                  <input type="month" f name="start_deduction_month" id="start_deduction_month" class="form-control col-sm-7" value=""  style="width: 100%;">
                  </div>
                 </div>

                 
                 
        </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" form="makeInstallments" onclick="makeInstallments()" class="btn btn-primary"><span class="fa fa-cog"></span> LOAD</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

                 </div> <!--end button div-->
                 
        </div>

        </fieldset>

      
        <div id="installments">

          <table class="table table-bordered table-hover">
              <thead>
                <th>Sr No</th>
                <th>Amount</th>
                <th>Month</th>
                <th></th>
              </thead>
              <tbody id="installments_body">
                
               <?php $rows=1; ?>

               <tr id="{{'instal_'.$rows}}">
              <td>{{$rows}}</td>
              <td><input type="number" step="any" form="ticket_form" name="amounts[]" id="{{'amount_'.$rows}}" class="form-control col-sm-8"  onchange="setNet()" style="width: 100%;" readonly></td>
              <td><input type="month" form="ticket_form" name="months[]" id="{{'month_'.$rows}}" class="form-control col-sm-8" value=""   style="width: 100%;"></td>
              <td></td>
             </tr>

                <?php $rows++; ?>

              </tbody>

              <tfoot>
                <th></th>
                <th id="net_total">0</th>
                <th></th>
                <th></th>
              </tfoot>

          </table>

        </div>

   
      
        
    </div>

  </div><!--end tabs-->
                 

                



              
                  
                  
              <!-- </div> -->
              <!-- /.card-body -->
            <!-- </div>
 -->            <!-- /.card -->

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

  <script type="text/javascript">

    
    $(document).ready(function(){

$('.select2').select2(); 

$(function () {
  $('[data-tooltip="tooltip"]').tooltip({
    trigger : 'hover'
     });
});

$('#ticket_form').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var rows=getRowNum();
var exist=false, blank=false;

for (var i =1; i <= rows ;  i++) {
if ($(`#month_${i}`). length > 0 )
     {

         exist=true;
        
          var month=$(`#month_${i}`).val();
           var amount=$(`#amount_${i}`).val();
            
            if(month=='' || amount=='')
              blank=true;
              
             
             
      }
  }

  if(exist==true)
  {
     if(blank==true)
          {
             $('#std_error').show();
            $('#std_error_txt').html("Installment's month or amount can not be empty!");
            return ;
          } 
  }

  var paid=$('#paid').is(':checked');

  if(paid==true)
  {   

          if(exist==false)
          {
             $('#std_error').show();
               $('#std_error_txt').html('If paid check is on, then make installments!');
               return;
          }

           var net=parseFloat( $(`#net_total`).text() );
           var app=$(`#approved_amount`).val();
          
           if( app== '' )
           {
              $('#std_error').show();
               $('#std_error_txt').html('Approved amount can not be null, if paid check is on!');
               return;
           }

           if(net != app )
           {
              $('#std_error').show();
               $('#std_error_txt').html('Installment amount and approved amount should be equal!');
               return;
           }
  } //end paid if

  $('#std_error_txt').html('');
 this.submit();


            
             
                            
  });//end submit

  });//end ready


var row="{{$rows}}"; 

function getRowNum()
 {
  return this.row;
}

function setRowNum()
 {
     this.row++;
}   
    
 
 function makeInstallments()
 {
    var amount=parseFloat( $('#approved_amount').val() );
     var per=parseFloat ( $('#per_month_deduction').val() );
     var start=$('#start_deduction_month').val();

     if(amount=='' || per=='' || start=='')
     {
          $('#err').show();
          $('#err_txt').html('Approved amount, Per month deduction or Deduction start month may be empty!');
          return ;
     }

     $('#err').show();
          $('#err_txt').html('');
     
      var rem= amount;
      var instals=[];
      
     do {
        
        if(rem == 0 )
          {
            
            break;
          }
          else if( rem < per )
          {
            instals.push(rem);
            break;
          }
          
          instals.push(per);
         rem=rem - per ;


  
        }
          while (true);

          var txt='';
           start = start.split("-");
          var d = new Date(start[0], parseInt( start[1] ) - 1, 1);
             this.row=1;
          for (var i =0;i < instals.length ;  i++) {

            m=zeroPad( d.getMonth() + parseInt( 1) ,2 );
            y= d.getFullYear() ;
          //alert(y+' '+m);
                
                var rows = getRowNum();

         txt=txt + `<tr id="instal_${rows}">
              <td>${rows}</td>
              <td><input type="number" step="any" form="ticket_form" name="amounts[]" id="amount_${rows}" class="form-control col-sm-8" value="${instals[i]}" onchange="setNet()" style="width: 100%;" required></td>
              <td><input type="month" form="ticket_form" name="months[]" id="month_${rows}" class="form-control col-sm-8" value="${y}-${m}" required  style="width: 100%;"></td>
              <td><button class="btn" form="makeInstallments" onclick="dellInstallment(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
             </tr>
            `;
            setRowNum();

        d=new Date(d.setMonth(d.getMonth() + 1));

        }

    $('#installments_body').html(txt);

    $("#add_error").hide();
           $("#add_error_txt").html('');

           $("#installment_month").val('');
           $("#installment_amount").val('');
          
            setNet();

      $('#modal-default').modal('hide');
     
 }

 function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}

function check_month(month)
{
  var rows=getRowNum();
   
    
   for (var i =1; i <= rows ;  i++) {

    if($(`#month_${i}`). length == 0 )
      continue;
    
      var let=$(`#month_${i}`).val();

      if(let == month)
        return true;
     
   }
  
     return false;
      

}

function addInstallment()
{
  var amount=$("#installment_amount").val();
  var month=$("#installment_month").val();
   
  


  var dbl_month=false;
  if(month!='')
  {
     dbl_month=check_month(month);
  }
     
     if( dbl_month==true || month=='' || amount=='' )
     {
        var  err_dbl='',  err_month='' ,  err_amount='' ;
           
           
           if(dbl_month==true)
           {
            err_dbl='Month already added.';
           }

           if(month=='')
           {
            err_dbl='Month required.';
           }

           if(amount=='')
           {
            err_dbl='Amount required.';
           }



           $("#add_error").show();
           $("#add_error_txt").html(err_dbl+' '+err_amount+' '+err_month);

     }
     else
     {


      var rows = getRowNum();


            var txt=`<tr id="instal_${rows}">
              <td>${rows}</td>
              <td><input type="number" step="any" form="ticket_form" name="amounts[]" id="amount_${rows}" class="form-control col-sm-8" value="${amount}" onchange="setNet()" style="width: 100%;" required></td>
              <td><input type="month" form="ticket_form" name="months[]" id="month_${rows}" class="form-control col-sm-8" value="${month}" required  style="width: 100%;"></td>
              <td><button class="btn" form="makeInstallments" onclick="dellInstallment(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
             </tr>
            `;
     

   

    $("#installments_body").append(txt);

  

           $("#add_error").hide();
           $("#add_error_txt").html('');

           $("#installment_month").val('');
           $("#installment_amount").val('');
            setRowNum(); 
            setNet();
   
   }
}

function setNet()
{
  var rows=getRowNum();
   
   var net=0 ;   
   for (var i =1; i <= rows ;  i++) {

    if($(`#amount_${i}`). length == 0 )
      continue;
    
       var amount=$(`#amount_${i}`).val();
     

      

      if(amount=='' || amount==null)
        amount=0;

      

        net +=  Number (amount);
     
   }
   $(`#net_total`).text(net);
     
      

}

function dellInstallment(row)
{
    $(`#instal_${row}`).remove();
    setNet();
}

function changeType()
{   
  var type=$('#loan_type').val();

  if(type=='Long Term')
    {
      $('#add_installment').show();
      dellInstallment(1);
       this.row=1;
    }
    else if(type=='Short Term')
    {
      $('#add_installment').hide();
       
       var rows=getRowNum();
       for (var i =1; i <= rows ;  i++) {

    if($(`#instal_${i}`). length == 0 )
      continue;
    
         dellInstallment(i);
        
       }
         makeShortInstall();
          setDeductionAmount();
         this.row = 2;
         

    }

}

 function makeShortInstall()
 {
    var txt=`<tr id="instal_1">
              <td>1</td>
              <td><input type="number" step="any" form="ticket_form" name="amounts[]" id="amount_1" class="form-control col-sm-8" value="" onchange="setNet()" style="width: 100%;" readonly></td>
              <td><input type="month" form="ticket_form" name="months[]" id="month_1" class="form-control col-sm-8" value=""   style="width: 100%;"></td>
              <td></td>
             </tr>
            `;
     

   

    $("#installments_body").html(txt);
 }

  function setDeductionAmount()
{   
     var type=$('#loan_type').val();

     if(type=='Short Term')
     {
     var am=$('#approved_amount').val();
      $('#amount_1').val(am);
      
       setNet();     
    }
}

  $("#loan_amount").change(function(){
      var am=$('#loan_amount').val();

      $('#approved_amount').val(am);
         
         setDeductionAmount();
});

  $("#approved_amount").change(function(){
      setDeductionAmount(); 
});

 
  </script>





@endsection  
  