
@extends('layout.master')
@section('title', 'Add New Receipt')
@section('header-css')


<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
   

       <div class="row default-header"  >
          <div class="col-sm-6">
            <h1>Receipt</h1>
           </div>
          <div class="col-sm-6 text-right">

             <button form="purchase_demand" type="submit" class="btn btn-primary"><span class="fas fa-save">&nbsp</span>Save</button>
           
            <a class="btn btn-transparent" href="{{url('receipt/create')}}" ><span class="fas fa-plus">&nbsp</span>New</a>
            <a class="btn btn-transparent" href="{{url('receipt/history')}}" ><span class="fas fa-history">&nbsp</span>Receipt List</a>

           

            
          </div>
        </div>

           <ol class="breadcrumb default-breadcrumb"  >
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Receipt</a></li>
              <li class="breadcrumb-item active">Add New Receipt</li>
            </ol>

  @endsection

@section('content')
    <!-- Main content -->



<!-- /print modal -->
          <div class="modal fade" id="modal-print">
        <div class="modal-dialog">
          <div class="modal-content bg-gradient-info">
            <div class="modal-header">
              <h4 class="modal-title ">Confirmation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Do you want to Print?&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
              <!-- <button form="button" class="btn btn-outline-light">Yes</button> -->
              <a class="btn btn-outline-light" id="print_btn"  href="{{url('/voucher/report2/'.session()->get('receipt_id') )}}" target="_blank" >Yes</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.print modal -->
    

     <form role="form" id="purchase_demand" method="POST" action="{{url('/receipt/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>


      <div class="container-fluid" style="margin-top: 10px;">

            @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             
                        @if ($errors->has('error'))                       
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                                          </div>  
                                @endif
     
      <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>


            <div class="row">
              <div class="col-md-9">
                  
                  <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-file-alt mr-2"></i>Receipt Voucher</h4>

                 <div class="row">

                <!-- /.form-group -->
                <div class="col-md-3 form-group ">
                  <label>Voucher No.</label>
                  <input type="text" form="purchase_demand" name="voucher_no" id="voucher_no" class="form-control " value="{{$doc_no}}" readonly required style="width: 100%;">
                  </div>


                <div class="col-md-3 form-group">
                  <label>Voucher Date</label>
                  <input type="date" form="purchase_demand" name="voucher_date" class="form-control " value="{{date('Y-m-d')}}" id="voucher_date" onchange="setDocNo()" required style="width: 100%;">
                  </div>

                  <div class="col-md-2 form-group">
                  <label>Pay Mehtod</label>
                  <select form="purchase_demand" name="pay_method" id="pay_method" class="form-control" onchange="setDocNo()" required>
                    <option value="cash" selected>Cash</option>
                    <option value="bank">Bank</option>
                  </select>
                  </div>

                  <div class="col-md-4 form-group">
                  <label>Receive In</label>
                  <select form="purchase_demand" name="pay_to" id="pay_to" class="form-control" required>
                    <option value="" selected>Select any value</option>
                    @foreach($cashes as $cash)
                    <option value="{{$cash['id']}}">{{$cash['name']}}</option>
                    @endforeach
                  </select>
                  </div>

                  <div class="col-md-4 form-group">
                  <label>Reference</label>
                  <input type="text" form="purchase_demand" name="reference" class="form-control " value=""  style="width: 100%;">
                  </div>

                  <div class="col-md-2 form-group">
                    
                  <!--<input type="checkbox" form="purchase_demand" name="activeness" value="1" id="activeness" class=""  checked>-->
                  <label>Status</label>
                  <select form="purchase_demand" name="status" class="form-control" required >
                        <option value="1" >Post</option>
                        <option value="0" >Unpost</option>
                    </select>

                  </div>


                </div>

                



              </div>

                                
                <!-- /.form-group -->
               
                
              </div>
              <!-- /.col -->
              <div class="col-md-9">

                 <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-plus-circle mr-2"></i>Receipt Detail</h4>

                  
                  <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>



      
                  


                    

                  


                <div class="row">

                     <div class="dropdown col-sm-9" id="accounts_table_account_dropdown">
                     <label>Receive From</label>
                     <input class="form-control" form="add_item"  name="account_id" id="account_id" required>
                      </div>


                  <div class="form-group col-sm-3" >
                  <label>Amount</label>
                  <input type="number" value="0" min="0" step="any" form="add_item" name="amount" id="amount" class="form-control select2" style="width: 100%;">
                  </div>

                   <div class="form-group col-sm-12">
                  <label>Remarks</label>
                  <textarea name="remarks" id="remarks" form="add_item" class="form-control select2" ></textarea>
                  </div>

                  <!-- <div class="form-group col-sm-4" >
                  <label>Cheque Book</label>
                  <input type="number" value="0" min="0" step="any" form="add_item"  name="credit" id="credit" class="form-control select2" style="width: 100%;">
                  </div> -->

                  <div class="form-group col-sm-4" >
                  <label>Cheque No</label>
                  <input type="text" form="add_item"  name="cheque_no" id="cheque_no" class="form-control select2" style="width: 100%;">
                  </div>

                  <div class="form-group col-sm-4" >
                  <label>Cheque Date</label>
                  <input type="date" form="add_item"  name="cheque_date" id="cheque_date" class="form-control select2" style="width: 100%;">
                  </div>

                  <div class="col-sm-2" >
                     <br>
                     <input type="hidden" name="row_id" id="row_id" >
                <button type="button" form="add_item" id="add_item_btn" class="btn" onclick="addItem()">
                    <span class="fa fa-plus-circle text-info"></span>
                  </button>


                   </div>

                   

                   
                 

               </div>

                


                     
                        </div>

                      
             

              </div>
              <!-- /.col -->

                            <!-- /.col -->

            </div>
            <!-- /.row -->

            

            



<!-- Start Tabs -->
<div class="nav-tabs-wrapper mb-3">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA"><i class="fas fa-list mr-2"></i>Detail</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="item_table" >
        <thead class="table-primary">
           <tr>
             <th>#</th>
          
             <th>Account</th>
             <th>Account Code</th>
             <th>Description</th>
             <th>Cheque No</th>
             <th>Cheque Date</th>
             <th>Amount</th>
            

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

          
          
        </tbody>
        <tfoot class="table-secondary">
          <tr>

             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
          
             
             <th id="net_amount">0</th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

        
    </div>
   
    
   

   
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_item">
              
            </form>
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>


<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

<script type="text/javascript">

var row_num=1;


$(document).ready(function(){


  $("#item_table").colResizable({
     resizeMode:'overflow'
   });

  


  $('#purchase_demand').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var rows=getRowNum();

for (var i =1; i <= rows ;  i++) {
if ($(`#account_id_${i}`). length > 0 )
     {

         
        $('#std_error_txt').html('');
               this.submit();
            
               return ;
             
             
      }
  }
             
             
               $('#std_error').show();
               $('#std_error_txt').html('Select items!');
             
  });

  



   
}); //end docment ready function

 function getRowNum() 
 {
  return this.row_num;
}

function setRowNum() 
 {
   this.row_num++;
}



  


 function setAccounts(accounts)
 {
  
  
  var new_accounts=[];
 
 for(var i = 0 ; i < accounts.length ; i++)
 {
  
     
         var let={ account:accounts[i]['name'],code:accounts[i]['code'],sub_sub_ac:accounts[i]['super_account']['name'],id:accounts[i]['id'],type:accounts[i]['super_account']['account_type']['name'],city:accounts[i]['id'] };
         //alert(let);
         new_accounts.push(let);
 }


$('#account_id').inputpicker({
    data:new_accounts,
    fields:[
        {name:'account',text:'Account'},
        {name:'code',text:'Code'},
        {name:'type',text:'Type'},
        {name:'sub_sub_ac',text:'Sub Sub Acc'},
        {name:'city',text:'City'}
        
    ],
    headShow: true,
    fieldText : 'account',
    fieldValue: 'id',
  filterOpen: true
    });

 }

$(document).ready(function(){
  

    @if(session()->has('receipt_id'))
       $("#modal-print").modal();
       //alert("{{ session()->get('receipt_id') }}");
       @endif

      var accounts=<?php echo json_encode($accounts) ?>;
      setAccounts(accounts);
   
});

// Hide the Modal
  $("#print_btn").click(function(){
    $("#modal-print").modal("hide");
  });



 function setDetailAccount()
{
  
  
   var pay_method=$('#pay_method').val();
   
   var sub_sub_acount_id= '';

   if(pay_method=='bank')
    {  
          sub_sub_acount_id=120;
    }
    else if(pay_method=='cash')
    {
         sub_sub_acount_id=119;
    }
   

    $.ajax({
               type:'get',
               url:'{{ url("/get/sub-sub/detail-accounts") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     sub_sub_acount_id: sub_sub_acount_id,
                  

               },
               success:function(data) {

                accounts=data;

                var txt= `<option value=''>Select any value</option>`;
                 
                 for (var i = 0; i < accounts.length ;  i++) {
                   
                   var txt1= `<option value='${accounts[i]['id']}'>${accounts[i]['name']}</option>`;

                   txt = txt + txt1 ;
                 }
                 
                 $('#pay_to').empty().append(txt);



               }
             });
    
}//end setDepartmentItem





       

 





function setNetAmount() //for end of tabel to show net
{
  var rows=getRowNum();
  
   var net_amount=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#amount_${i}`). length > 0 )
     { 
       var amount=$(`#amount_${i}`).val();

      if(amount=='' || amount==null)
        amount=0;
      
         net_amount +=  parseFloat (amount) ;      
      }
       

   }
   $(`#net_amount`).text(net_amount);
     

}

function checkItem(row='')
{
  var rows=getRowNum();
  for (var i =1; i <= rows ;  i++) {
   
     if ($(`#account_id_${i}`). length == 0 || $(`#account_id_${i}`). length < 0 )
     {
      continue;
     }
     if (row == i  )
     {
      continue;
     }
     var account_id=$("#account_id").val();
     var tbl_item_id=$(`#account_id_${i}`).val(); 

     if(account_id == tbl_item_id)
      return true;
     
  
      }
     return false;
}

function isItem(item_name)
{
  var bool=false;
  $.ajax({
               type:'get',
               url:'{{ url("/item/exist") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     item_name: item_name,
                  

               },
               success:function(data) {

                bool = data;


               }
             });

     return bool;
  }



function addItem()
{
    var account_id=$("#account_id").val();
    var s=$("#accounts_table_account_dropdown").find(".inputpicker-input");
    var account_name=s.val(); //alert(item_name);alert(item_id);
  
 var remarks=$("#remarks").val();
  var amount=$("#amount").val();
  
  var cheque_no=$("#cheque_no").val();
  var cheque_date=$("#cheque_date").val();


    
    var dbl_item=false;
  if(account_name!='')
  {
     //dbl_item=checkItem();
  }

  if( (amount<=0 )  )
  {
         $("#item_add_error").show();
        $("#item_add_error_txt").html('Amount should greater than 0!');

        return ;
  }
  
     if(account_name=='' || dbl_item==true)
     {
        var account_name='' , err_dbl='';
           
           if(account_name=='')
           {
                account_name='Account is required.';
           }
           

           if(dbl_item==true)
           {
            err_dbl='Item already added.';
           }

           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+account_name);

     }
     else
     {
         
      
        
     var row=getRowNum(); 

     var txt=`
     <tr id="${row}" ondblclick="editItem(${row})">
      <th></th>
     
     <input type="hidden" form="purchase_demand" id="account_id_${row}" name="accounts_id[]" value="${account_id}" readonly >

    
     <td id="account_name_${row}">${account_name}</td>
     <td id="account_code_${row}"></td>
       
  

     <td><input type="text" class="form-control" value="${remarks}" form="purchase_demand" name="remarks[]" id="remarks_${row}" readonly ></td>
     <td><input type="text" class="form-control" value="${cheque_no}" form="purchase_demand" name="cheque_no[]" id="cheque_no_${row}" readonly ></td>
<td><input type="text" class="form-control" value="${cheque_date}" form="purchase_demand" name="cheque_date[]" id="cheque_date_${row}" readonly ></td>

     <td><input type="text" class="form-control" value="${amount}" form="purchase_demand" name="amount[]" id="amount_${row}" readonly ></td>
      
      
         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      
     
   

    $("#selectedItems").append(txt);

    $.ajax({
               type:'get',
               url:'{{ url("/get/account/") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     account_id: account_id,
                  

               },
               success:function(data) {

                account = data;

                  $(`#account_code_${row}`).html(account['code']);

               }
             });

   $("#account_id").val('');

   var s=$("#accounts_table_account_dropdown").find(".inputpicker-input");
   s.val('');

   
  
  $("#remarks").val('');
  $("#amount").val('0');
  
  $("#cheque_no").val('');
  $("#cheque_date").val('');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

           setRowNum();
          setNetAmount();
           
   
   }
     
}//end add item

function updateItem(row)
{
  var account_id=$("#account_id").val();
    var s=$("#accounts_table_account_dropdown").find(".inputpicker-input");
    var account_name=s.val(); //alert(item_name);alert(item_id);
  


  
 var remarks=$("#remarks").val();
  var amount=$("#amount").val();
 
  var cheque_no=$("#cheque_no").val();
  var cheque_date=$("#cheque_date").val();


    
    var dbl_item=false;
  if(account_name!='')
  {
     //dbl_item=checkItem();
  }

  if( (amount<=0 )  )
  {
         $("#item_add_error").show();
        $("#item_add_error_txt").html('Amount should greater than 0!');

        return ;
  }


     if(account_name=='' || dbl_item==true)
     {
        var account_name='' , err_dbl='';
           
           if(account_name=='')
           {
                account_name='Account is required.';
           }
           

           if(dbl_item==true)
           {
            err_dbl='Item already added.';
           }

           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+account_name);

     }
     else
     {
     
       $(`#account_id_${row}`).val(account_id);
       
        
        $(`#remarks_${row}`).val(remarks);
        $(`#amount_${row}`).val(amount);
        
        $(`#cheque_no_${row}`).val(cheque_no);
        $(`#cheque_date_${row}`).val(cheque_date);


    
    
      
      $(`#account_name_${row}`).text(account_name);
      
      $.ajax({
               type:'get',
               url:'{{ url("/get/account/") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     account_id: account_id,
                  

               },
               success:function(data) {

                account = data;

                  $(`#account_code_${row}`).html(account['code']);

               }
             });
      

   $("#account_id").val('');

   var s=$("#accounts_table_account_dropdown").find(".inputpicker-input");
   s.val('');

   
  
  $("#remarks").val('');
  $("#amount").val('0');
  
  $("#cheque_no").val('');
  $("#cheque_date").val('');


$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

 
   setNetAmount();
  $('#add_item_btn').attr('onclick', `addItem()`);
   
   }
     
}  //end update item


function editItem(row)
{

   
   var account_name=$(`#account_name_${row}`).text();
   var account_id=$(`#account_id_${row}`).val();

   $('#account_id').val(account_id);
   var s=$("#accounts_table_account_dropdown").find(".inputpicker-input");
   s.val(account_name);
  

var remarks=$(`#remarks_${row}`).val();
$('#remarks').val(remarks);

  var amount=$(`#amount_${row}`).val();
$('#amount').val(amount);



  var cheque_no=$(`#cheque_no_${row}`).val();
  $('#cheque_no').val(cheque_no);

   var cheque_date=$(`#cheque_date_${row}`).val();
  $('#cheque_date').val(cheque_date);

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

  

}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
    $(`#${row}`).remove();
      setNetAmount();
});

}


function setDocNo()
{
   var pay_method=$('#pay_method').val();
   var voucher_date=$('#voucher_date').val();

   var voucher_type='';

   if(pay_method=='bank')
    {  
          voucher_type=30;
    }
    else if(pay_method=='cash')
    {
         voucher_type=28;
    }

   $.ajax({
               type:'get',
               url:'{{ url("/get/voucher/no/") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     voucher_type: voucher_type,
                      voucher_date: voucher_date,
                  

               },
               success:function(data) {

              
                var doc_no = data['doc_no'];

                
                  $(`#voucher_no`).val(doc_no);

               }
             });//end ajax

   setDetailAccount();
    
}






</script>


@endsection  
  