
@extends('layout.master')
@section('title', 'Transfer Note')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('transfer-note/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Transfer Note</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <!-- <a class="btn" href="{{url('/transfer-note')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
            <a class="btn" href="{{url('/transfer-note/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Transfer Note</li>
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
                <h3 class="card-title">Transfer Note</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                 <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                  

                
                

                <div class="row col-md-10 form-row">

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No</label>
                  <select class="form-control col-sm-8 select2" onchange="setPlanAtt()" form="ticket_form" name="plan_id" id="plan_id" required >
                    <option value="">------Select any value-----</option>
                    @foreach($plans as $plan)
                    <option value="{{$plan['id']}}">{{$plan['plan_no']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                  
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <input type="text" form="ticket_form" name="product_id" id="product_id" class="form-control col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 </div>
                 
                
                   <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" id="batch_no" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pro_pack_size" id="pro_pack_size" class="form-control  col-sm-8" value="" readonly  required style="width: 100%;">
                  </div>
                 </div>

                 

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="text" form="ticket_form" name="batch_size" id="batch_size" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 
                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" id="mfg_date" class="form-control  col-sm-8" value="" readonly   style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Exp Date</label>
                  <input type="date" form="ticket_form" name="exp_date" id="exp_date" class="form-control  col-sm-8" value="" readonly style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Mrp</label>
                  <input type="number" step="any" form="ticket_form" name="mrp" id="mrp" class="form-control  col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Theoretical Qty</label>
                  <input type="number" step="any" form="ticket_form" name="batch_qty" id="batch_qty" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>
                 

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Actual Qty</label>
                  <input type="number" step="any" form="ticket_form" name="actual_qty" id="actual_qty" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Qty (QA Samples)</label>
                  <input type="number" step="any" form="ticket_form" name="qa_sample" id="qa_sample" class="form-control  col-sm-8" value="" required onchange="setLoss()"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Qty (QC Samples)</label>
                  <input type="number" step="any" form="ticket_form" name="qc_sample" id="qc_sample" class="form-control  col-sm-8" value="" required onchange="setLoss()"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">% Yield</label>
                  <input type="number" step="any" form="ticket_form" name="yield" id="yield" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">% Loss</label>
                  <input type="number" step="any" form="ticket_form" name="loss" id="loss" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Cost Price</label>
                  <input type="number" step="any" form="ticket_form" name="cost_price" id="cost_price" class="form-control  col-sm-8" value=""  required style="width: 100%;">
                  </div>
                 </div>




                
                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea class="form-control col-sm-10" placeholder="Comment..." form="ticket_form" name="remarks"></textarea>
                  </div>
                 </div>


                

                 

                 
                 <!-- <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="activeness" value="1" id="activeness" class=""  checked>&nbsp&nbspActive</label>
                  </div>
                </div> -->
                 

                

               </div>
 

           <!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabE">Detail</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">

     <div class="tab-pane fade show active" id="tabE">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Add</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Date</label>
                  <input type="date"  form="add_item" name="tran_date" id="tran_date" class="form-control" value="{{date('Y-m-d')}}"  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control" form="add_item" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>
                  
             <div class="col-md-2">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" step="any" form="add_item" name="qty" id="qty" onchange="setTotalQty()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input list="p_s_list"   autocomplete="off"   form="add_item" name="p_s" id="p_s" value="1"  onchange="setTotalQty()" class="form-control" readonly required="true" style="width: 100%;">
                  <datalist form="add_item"  id="p_s_list">
                  <option value="1">
                  </datalist>

                </div>
              </div>

              


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1"  form="add_item" name="total_qty" id="total_qty" class="form-control" readonly style="width: 100%;">
                </div>
              </div>

              

              
              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <input type="hidden" name="row_id" id="row_id" >
                  <button type="button" form="add_item" id="add_item_btn" class="btn" onclick="addItem()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> <!--end row-->



                 </fieldset>
              </div>
            </div>


     <div class="table-responsive">
      <table class="table table-bordered table-hover "  id="item_table" >
        <thead class="table-secondary">
           <tr>

             <th>#</th>
             <th>Date</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total</th>
             
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

         
        
           
          
        </tbody>
        <tfoot>
          <tr>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_qty"></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

      
    </div> <!-- End TabE  -->
   
    
   

   
</div>
<!-- End Tabs -->
      

                



              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>

<script type="text/javascript">
var row_num=1;

function getRowNum()
 {
  return this.row_num;
}
function setRowNum()
 {
   this.row_num+=1;
}
  

  $(document).ready(function(){

$('.select2').select2(); 

$('#ticket_form').submit(function(e) {

     e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();

for (var i =1; i <= row_num ;  i++)
{
if ($(`#qty_${i}`). length > 0 )
     {
        $('#std_error_txt').html('');
               this.submit();
               return ;
      }
  }

             
               $('#std_error').show();
               $('#std_error_txt').html('Select items!');



  });

});

function setLoss()
{
   var qty=$(`#batch_qty`).val();
   var qty1=$(`#actual_qty`).val();
   var qty2=$(`#qa_sample`).val();
   var qty3=$(`#qc_sample`).val();

   if(qty=='' || qty==null)
        qty=0;

      if(qty1=='' || qty1==null)
        qty1=0;

      if(qty2=='' || qty2==null)
        qty2=0;

      if(qty3=='' || qty3==null)
        qty3=0;

      var t= parseFloat( qty3 )+parseFloat( qty2 ) + parseFloat( qty1 ); 
       var t1= ( parseFloat(t) / parseFloat( qty )) * 100 ; 
    
    $(`#yield`).val(t1); 
     var l= 100 - t1 ;
     $(`#loss`).val(l);
}

  function setPackSize()
{
  

  unit=$(`#unit`).val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s`).setAttribute('readonly', 'readonly');
  $(`#p_s`).val('1');
       setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById(`p_s`).removeAttribute('readonly');
}

function setTotalQty() //in add item form
{
 

  qty=$(`#qty`).val();
  p_s=$(`#p_s`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;

   //total_qty= total_qty.toFixed(3);
   
   $(`#total_qty`).val(total_qty); 
}



function setPlanAtt()
{
   var id=$("#plan_id").val();
     if(id=='')
      return ;

   var plans=<?php echo json_encode($plans); ?> ;
                 
                 let point = plans.findIndex((item) => item.id == id);
              var plan=plans[point];

         
         $("#product_id").val(plan['product_name']);
        $("#batch_size").val(plan['batch_size']);
        $("#batch_qty").val(plan['batch_qty']);
         $("#pro_pack_size").val(plan['pack_size']);

         $("#batch_no").val(plan['batch_no']);
        $("#mfg_date").val(plan['mfg_date']);
         $("#exp_date").val(plan['exp_date']);
         $("#mrp").val(plan['mrp']);

         var packings=plan['packing'];
          
      var txt='<option value="1" />';
       for (var i=0;  i < packings.length ;  i++) {
            txt += '<option value="'+packings[i]+'" />'; 
       }
         var my_list=document.getElementById("p_s_list");
       my_list.innerHTML = txt;

}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
   var  net_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_${i}`). length > 0 )
     { 
       
       var qty=$(`#total_${i}`).text();

      if(qty=='' || qty==null)
        qty=0;
      
         net_qty +=  parseFloat (qty) ;

        
      }
       

   }

    net_qty =  net_qty.toFixed(2) ;

   $(`#net_qty`).text(net_qty);

   $(`#actual_qty`).val(net_qty);
     
    setLoss();
}




function addItem()
{
  var tran_date=$("#tran_date").val();
 

  var unit=$("#unit").val();
  var qty=$("#qty").val();
  
  var pack_size=$("#p_s").val();
   var total=$("#total_qty").val();
  
       
     if(tran_date=='' || pack_size=='' || qty=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(tran_date=='')
           {
                err_name='Date is required.';
           }

           if(pack_size=='')
           {
                err_dbl='Pack Size is required.';
           }
           
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     
     <input type="hidden" form="ticket_form" id="tran_dates_${row}" name="tran_date[]" value="${tran_date}" readonly >
     
     <input type="hidden" form="ticket_form" id="units_${row}" name="unit[]"  value="${unit}" >
     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qty[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="p_ss_${row}" name="pack_size[]"  value="${pack_size}" >
     
     
     <td></td>
     <td id="tran_date_${row}">${tran_date}</td>
   
  
       <td id="unit_${row}">${unit}</td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${pack_size}</td>
     <td id="total_${row}">${total}</td>
    
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
    
     
   

    $("#selectedItems").append(txt);


  
  $("#unit").val('loose');
  $("#qty").val('1');
  $("#p_s").val('1');
  $("#total_qty").val('1');

   document.getElementById(`p_s`).setAttribute('readonly', 'readonly');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

  
          setNetQty();
           setRowNum();
   
   }
     
}//end add item

function updateItem(row)
{
  var tran_date=$("#tran_date").val();
 

  var unit=$("#unit").val();
  var qty=$("#qty").val();
  
  var pack_size=$("#p_s").val();
   var total=$("#total_qty").val();
  
       
     if(tran_date=='' || pack_size=='' || qty=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(tran_date=='')
           {
                err_name='Date is required.';
           }

           if(pack_size=='')
           {
                err_dbl='Pack Size is required.';
           }
           
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_qty);

     }
     else
     {
     
    
       $(`#tran_dates_${row}`).val(tran_date);
       $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
      $(`#p_ss_${row}`).val(pack_size);


      $(`#tran_date_${row}`).text(tran_date);
      $(`#unit_${row}`).text(unit);
      $(`#qty_${row}`).text(qty);
        $(`#p_s_${row}`).text(pack_size);
        $(`#total_${row}`).text(total);

            
   $("#unit").val('loose');
  $("#qty").val('1');
  $("#p_s").val('1');
  $("#total_qty").val('1');


   document.getElementById(`p_s`).setAttribute('readonly', 'readonly');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
  
   
   }
     
}  //end update item


function editItem(row)
{
   
  var trans=$(`#tran_date_${row}`).text();
  $('#tran_date').val(trans);

  var unit=$(`#unit_${row}`).text();
  $('#unit').val(unit);

  var qty=$(`#qty_${row}`).text();
$('#qty').val(qty);

 var p_s=$(`#p_s_${row}`).text();
$('#p_s').val(p_s);

 var total=$(`#total_${row}`).text();
$('#total_qty').val(total);



  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);
   
   if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s`).setAttribute('readonly', 'readonly');
   }
   else if( unit=='pack')
   document.getElementById(`p_s`).removeAttribute('readonly');
  

}

function removeItem(row)
{
  
    $(`#${row}`).remove();
    setNetQty();
  

}

 
  
</script>





@endsection  
  