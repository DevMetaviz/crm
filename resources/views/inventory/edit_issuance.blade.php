
@extends('layout.master')
@section('title', 'Edit Issuance')
@section('header-css')
<style type="text/css">
  .alert-success {
     color: #155724; 
    background-color: #d4edda;
    /*border-color: #c3e6cb;*/
}

 
</style>
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')

<form role="form" id="delete_form" method="POST" action="{{url('/delete/issuance/'.$issuance['id'])}}">
               @csrf    
    </form>
    <!-- Content Header (Page header) -->
    <form role="form" id="ticket_form" method="POST" action="{{url('/issuance/update')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$issuance['id']}}" name="id"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit Store Issuance</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="button" data-toggle="modal" style="border: none;background-color: transparent;" data-target="#modal-del">
                  <span class="fas fa-trash text-danger">&nbsp</span>Delete
                </button>
            <a class="btn" href="{{url('store-issuance')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('issuance/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/issuance/print/'.$issuance['id'])}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>
          </div>

          <!-- /.delete modal -->
          <div class="modal fade" id="modal-del">
        <div class="modal-dialog">
          <div class="modal-content bg-gradient-danger">
            <div class="modal-header">
              <h4 class="modal-title ">Confirmation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Do you want to delete?&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
              <button form="delete_form" class="btn btn-outline-light">Yes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.delete modal -->

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Inventory</a></li>
              <li class="breadcrumb-item active">Store Issuance</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

<style type="text/css">
  .alert-inline{
              display: inline;
              color: #d32535;
              background-color:transparent ;
              border:none;padding: .7rem 4rem 0rem 0rem;
     }
</style>
    
      <div class="container-fluid" style="margin-top: 10px;">

            @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
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
              <div class="col-md-8">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Document</legend>

                <div class="row">
                  <div class="col-md-4">
                    
                  
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Issuance No.</label>
                  <input type="text" name="doc_no" id="doc_no"  class="form-control" value="{{$issuance['issuance_no']}}" required style="width: 100%;" readonly>
                  </div>

                  

                <div class="form-group">
                  <label>Issuance Date</label>
                  <input type="date" name="doc_date" class="form-control" value="{{$issuance['issuance_date']}}" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" name="department_id" id="department_id" onchange="setDepartmentItem()"  style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($locations as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                   
                  </select>
                </div>

                  
                  

                <div class="form-group">
                  <input type="checkbox" name="issued" value="1" id="issued" class=""  >
                  <label>Issued</label>
                  </div>

                  </div>

                
                  <div class="col-md-4">

                    

                       @if($issuance['plan_no']!='')

                  <div class="form-group">
                  <label>Plan No</label>
                  <input type="text" name="plan_no" id="plan_no"  class="form-control" value="{{$issuance['plan_no']}}" required style="width: 100%;" readonly>
                  <input type="hidden" name="plan_id" id="plan_id"  value="{{$issuance['plan_id']}}" >
                  </div>

                  <div class="form-group">
                  <label>Product</label>
                  <input type="text" name="product" id="product"  class="form-control" value="{{$issuance['product']}}" required style="width: 100%;" readonly>
                  </div>

                  <div class="form-group">
                  <label>Batch No.</label>
                  <input type="text" name="batch_no" id="batch_no"  class="form-control" value="{{$issuance['batch_no']}}" required style="width: 100%;" readonly>
                   </div>

                 
                  <div class="form-group">
                  <label>Batch Size</label>
                  <input type="text" name="batch_size" id="batch_size" class="form-control" value="{{$issuance['batch_size']}}" readonly style="width: 100%;">
                  </div>
                  
                  
                 @endif

                

                  
                  </div>
                
                  <div class="col-md-4">

                    @if(isset($issuance['request']))
                      <div class="form-group">
                  <label>Request No.</label>
                  <input type="text" name="request_no" id="request_no"  class="form-control" value="{{$issuance['request']['requisition_no']}}" required style="width: 100%;" readonly>
                  <input type="hidden" name="request_id" id="request_id"  value="{{$issuance['request']['id']}}" >
                  </div>

                  

                <div class="form-group">
                  <label>Request Date</label>
                  <input type="date" name="request_date" class="form-control" value="{{$issuance['request']['requisition_date']}}" readonly style="width: 100%;">
                  </div>
                  @endif

                    <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" id="remarks"  class="form-control">{{$issuance['remarks']}}</textarea>
                  </div>
                    
                    <!-- <fieldset class="border p-4">
                   <legend class="w-auto">Cost of Goods Account</legend>

                   <div class="form-group">
                   <select class="form-control" name="currency" id="currency" style="width: 100%;">
                    <option value="">Select any value</option>
                    <option value="">PKR </option>
                    <option value="">Pounds</option>
                  </select>
                  </div>

                    </fieldset> -->


                  </div>
                </div>



              </fieldset>

                                
                <!-- /.form-group -->
                

               

               
                  

               
                
              </div>
              <!-- /.col -->
              

              <div class="col-md-4">

                 
                        <fieldset class="border p-4">
                   <legend class="w-auto">Other</legend>

                   <div class="form-group row">
                  <label class="col-sm-4">Issued By:</label>
                   <select class="form-control select2 col-sm-8" name="issued_by" id="issued_by" onchange="setDesignation()" >
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">Designation</label>
                <input type="text" class="form-control col-sm-8" value="" name="designation_issued_by" id="designation_issued_by" readonly>
                </div> 

                  <div class="form-group row">
                  <label class="col-sm-4">Received By:</label>
                   <select class="form-control select2 col-sm-8" name="received_by" id="received_by" onchange="setDesignation1()"  >
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div> 

                  <div class="form-group row">
                  <label class="col-sm-4">Designation</label>
                <input type="text" class="form-control col-sm-8" value="" name="designation_received_by"  id="designation_received_by" readonly>
                </div> 

                <div class="form-group row">
                  <label class="col-sm-4">Department:</label>
                   <select class="form-control select2 col-sm-8" name="receiving_department" id="receiving_department" onchange="" >
                    <option value="">Select any value</option>
                    @foreach($departments as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div> 

                
                    </fieldset>

                        


            
              </div>
              <!-- /.col -->

            </div>
            <!-- /.row -->



<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Material</a></li>
       <!--  <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Expense</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC">Terms</a></li> -->
        
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="tabA">
      
     
    
     <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Item</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                   <!--  <div class="col-md-3">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" onchange="setDepartmentItem()" form="add_item" name="location" id="location" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($locations as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div> -->

                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Items</label>
                  <select class="form-control select2" form="add_item" name="item_id" id="item_id" onchange="setUom()" required="true">
                    <option>Select any value</option>
                  </select>
                </div>
              </div>

           <?php       $procs=[];
                  if(isset($issuance['ticket_procedure']['processes']))
                  {
                     //$pro=$request['ticket']->getProcedure();
                     //if(isset($pro['processes']))
                     $procs=$issuance['ticket_procedure']['processes'];
                  }
            ?>
           <div class="col-md-2">
                    <div class="form-group">
                  <label>Stage</label>
                  <select class="form-control" form="add_item" name="process_id" id="process_id"  style="width: 100%;">
                    <option value="-1">Select any Stage</option>

                    @foreach($procs as $pr)
                      <option value="{{$pr['id']}}">{{$pr['process_name']}}</option>
                       @foreach($pr['sub_stages'] as $sub)
                      <option value="{{$sub['id']}}">{{'--'.$sub['process_name']}}</option>
                        @endforeach
                    @endforeach
                    
                  </select>
                </div>
              </div> 


          

              <div class="col-md-2">
                    <div class="form-group">
                  <label>GRN No</label>
                  <select class="form-control" form="add_item" name="grn_no" id="grn_no"  onchange="setGrnAtt()" style="width: 100%;">
                    <option value="">Select any value</option>
                  </select>
                </div>
              </div> 


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Batch No</label>
                  <input type="text"  form="add_item" name="item_batch_no" id="item_batch_no" class="form-control" style="width: 100%;">
                </div>
              </div> 

              <div class="col-md-2">
                    <div class="form-group">
                  <label>QC No</label>
                  <input type="text"  form="add_item" name="qc_no" id="qc_no" class="form-control" style="width: 100%;">
                </div>
              </div>  

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number"  form="add_item" name="stock_in_qty" id="stock_in_qty" class="form-control" readonly style="width: 100%;">
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
                  <label>UOM</label>
                  <input type="text"  form="add_item" name="uom" id="uom" onchange="" class="form-control" required="true" readonly>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty" onchange="setTotalQty()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>Approved Qty</label>
                  <input type="number" value="0" min="0" form="add_item" name="app_qty" id="app_qty" onchange="setGrossTotalQty()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div> -->

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" value="1" min="1"  form="add_item" name="p_s" id="p_s"   onchange="setTotalQty()" class="form-control" readonly  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty" class="form-control" readonly style="width: 100%;">
                </div>
              </div>

              <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>Gross Total Qty</label>
                  <input type="number" value="0" min="0" form="add_item" name="gross_total_qty" id="gross_total_qty" class="form-control" readonly style="width: 100%;">
                </div>
              </div> -->

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
             
             <th>Item</th>
             <th>Stage</th>
              <th>GRN No</th> 
             <th>Batch No</th>
             <th>QC No</th>
          
             <th>UOM</th>
             <th>Unit</th>
             <th>Approved Qty</th>
             <th>Issued Qty</th>
             
             <th>Pack Size</th>
             <th>Total Qty</th>
             <!-- <th>Gross Total Qty</th> -->
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems"> 
       

       <?php $row=1; $total_qty=0; $total_net_qty=0; ?>
        
             @foreach($issuance['items'] as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>))" id="{{$row}}">
      
      <input type="hidden" form="ticket_form" id="{{'pivot_id_'.$row}}"   name="pivot_ids[]" value="{{$item['pivot_id']}}"  >

    
     <input type="hidden" form="ticket_form" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >
      
      <input type="hidden" form="ticket_form" id="{{'grn_nos_'.$row}}" name="grn_nos[]"  value="{{$item['grn_no']}}"  >
      <input type="hidden" form="ticket_form" id="{{'qcs_'.$row}}" name="qc[]"  value="{{$item['qc_no']}}">
      <input type="hidden" form="ticket_form" id="{{'batch_nos_'.$row}}" name="batch_nos[]"  value="{{$item['batch_no']}}"  >
     <input type="hidden" form="ticket_form" id="{{'units_'.$row}}" name="units[]"  value="{{$item['unit']}}">
     <input type="hidden" form="ticket_form" id="{{'stages_'.$row}}" name="stages[]"  value="{{$item['stage_id']}}">
     <input type="hidden" form="ticket_form" id="{{'request_item_ids_'.$row}}" name="request_item_ids[]"  value="{{$item['request_item_id']}}">
     
     <input type="hidden" form="ticket_form" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['qty']}}" >
     <!-- <input type="hidden" form="ticket_form" id="{{'app_qtys_'.$row}}" name="app_qtys[]"  value="" > -->
     <input type="hidden" form="ticket_form" id="{{'p_ss_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}">
     
     <td></td>
    
     <td id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>
    <td id="{{'stage_text_'.$row}}">{{$item['stage_text']}}</td>

      <td id="{{'grn_no_'.$row}}">{{$item['grn_no']}}</td> 
      <td id="{{'batch_no_'.$row}}">{{$item['batch_no']}}</td> 
      <td id="{{'qc_'.$row}}">{{$item['qc_no']}}</td>  
       
       <td id="{{'item_uom_'.$row}}">{{$item['uom']}}</td>
     <td id="{{'unit_'.$row}}">{{$item['unit']}}</td>
     <td id="{{'app_qty_'.$row}}">{{$item['app_qty']}}</td>
     <td id="{{'qty_'.$row}}">{{$item['qty']}}</td>
  
     <td id="{{'p_s_'.$row}}">{{$item['pack_size']}}</td>
     
     
     <td id="{{'total_qty_'.$row}}">{{$item['total_qty']}}</td>
     <!-- <td id="gross_total_qty_${row}"></td> -->
     

         <td><button type="button" class="btn" onclick="removeItem('{{$row}}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
     <?php $row+=1;  $total_qty+=$item['qty']; $total_net_qty+=$item['total_qty']; ?>
     @endforeach
           
          
        </tbody>
        <tfoot>
          <tr>

             
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_qty">{{$total_qty}}</th>
             <!-- <th></th> -->
             <th></th>
             <th id="net_total_qty">{{$total_net_qty}}</th>
             <!-- <th></th> -->
             <th></th>

           </tr>
        </tfoot>
      </table>
    </div>

                 
     
        
    </div>
    <!-- <div class="tab-pane fade" id="tabB">

      
      
    </div>

    <div class="tab-pane fade" id="tabC">

      
    </div> -->

    

    
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>

       <form role="form" id="#add_item">
              
            </form>

             <form role="form" id="#load_demand_items">
              
            </form>
    <!-- /.content -->

    
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">
  
  var row_num=<?php echo json_encode($row); ?>;

 
  $(document).ready(function() {

    
 $('.select2').select2(); 

 var issued="{{ $issuance['issued'] }}";
   if(issued==1)
   $('#issued').prop('checked','checked');

 $('#department_id').val('{{$issuance['department_id']}}');
  setDepartmentItem();
  $('#department_id').attr("disabled", true); 
  
  $('#ticket_form').submit(function(e) {

   e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();

for (var i =1; i <= row_num ;  i++)
{
if ($(`#qtys_${i}`). length > 0 )
     {
        $('#std_error_txt').html('');
         $('#department_id').removeAttr('disabled');
               this.submit();
               return ;
      }
  }

             
               $('#std_error').show();
               $('#std_error_txt').html('Select items!');
    

 
             
  });

});

  function getRowNum()
 {
  return this.row_num;
}
function setRowNum()
 {
   this.row_num++;
}





  

$(document).ready(function(){
  
     
     
       //setNetQty();

        var value="{{$issuance['issued_by'] }}";
     $('#issued_by').val(value);
     $('#issued_by').trigger('change');
      if(value!=null && value!='' && value!=0)
        setDesignation();
    var value="{{$issuance['received_by'] }}";
     $('#received_by').val(value);
     $('#received_by').trigger('change');
     if(value!=null && value!='' && value!=0)
        setDesignation1();

      var value="{{$issuance['receiving_department'] }}";
     $('#receiving_department').val(value);
     $('#receiving_department').trigger('change');
});



function setUom()
{
  var id=$(`#department_id`).val();
   var id1=$(`#item_id`).val();
  
   if(id=='' || id1=='')
    return ;
   
   var departs=JSON.parse(`<?php echo json_encode($locations); ?>`); 
   let point = departs.findIndex((item) => item.id == id);
  
      var items=departs[point]['items'];

      let point1 = items.findIndex((item) => item.id == id1);
       var unit=items[point1]['unit'];

       $(`#uom`).val(unit);
        
      
       $(`#stock_in_qty`).val(items[point1]['qty']);
      
         var grns=items[point1]['grns'];
            
         $('#grn_no').empty().append('<option value="" >Select any value</option>');

          for (var k =0 ;k < grns.length ; k ++ )
          {                   
              //alert(JSON.stringify(grns[0]));
          $('<option value="'+grns[k]['grn_no']+'">'+grns[k]['grn_no']+'</option>').appendTo("#grn_no");

            }
           
}


function setGrnAtt()
{
  var id=$(`#department_id`).val();
   var id1=$(`#item_id`).val();
   var grn_no=$(`#grn_no`).val();
  
   if(id=='' || id1=='' ||grn_no=='')
    return ;
   
   var departs=JSON.parse(`<?php echo json_encode($locations); ?>`); 
   let point = departs.findIndex((item) => item.id == id);
  
      var items=departs[point]['items'];

      let point1 = items.findIndex((item) => item.id == id1);
       
        var grns=items[point1]['grns'];

        let point2 = grns.findIndex((item) => item.grn_no == grn_no);
         
         var grn=items[point1]['grns'][point2];
           // alert(grn);
       $(`#stock_in_qty`).val(grn['qty']); 
       $(`#item_batch_no`).val(grn['batch_no']);    
         
           
}



function setDepartmentItem()
{
  var department_id= jQuery('#department_id').val();
  if(department_id=='')
  {
    return;
  }
     
   var departs=JSON.parse(`<?php echo json_encode($locations); ?>`); 
   let point = departs.findIndex((item) => item.id == department_id);
  
      var items=departs[point]['items'];
      
      $('#item_id').empty().append('<option value="" >Select any value</option>');

                  for (var k =0 ;k < items.length ; k ++ )
                   {                   

                  $('<option value="'+items[k]['id']+'">'+items[k]['item_name']+'</option>').appendTo("#item_id");
                    }

    $('#department_id').attr("disabled", true); 
    
}//end setDepartmentItem







function setPackSize()
{
  unit=$("#unit").val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  $("#p_s").val('');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('p_s').removeAttribute('readonly');
}



function setTotalQty() //in add item form
{
  qty=$("#qty").val();
  p_s=$("#p_s").val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   total_qty =  total_qty.toFixed(3) ;
   $("#total_qty").val(total_qty); 
   //setGrossTotalQty();
}

function setGrossTotalQty() //in add item form
{
  app_qty=$("#app_qty").val();
  p_s=$("#p_s").val();
  total_qty=app_qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   total_qty =  total_qty.toFixed(3) ;
   $("#gross_total_qty").val(total_qty); 
}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
   var net_total_qty=0, net_qty=0,total_app_qty=0, net_gross_total_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).text();
       var qty=$(`#qty_${i}`).text();
       //var t_g_qty=$(`#gross_total_qty_${i}`).text();
       //var app_qty=$(`#app_qty_${i}`).text();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;

      // if(t_g_qty=='' || t_g_qty==null)
      //   t_g_qty=0;

      // if(app_qty=='' || app_qty==null)
      //   app_qty=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;

        //total_app_qty +=  parseFloat (app_qty) ;

        //net_gross_total_qty +=  parseFloat (t_g_qty) ;
      }
       

   }

    net_total_qty =  net_total_qty.toFixed(3) ;
   net_qty =  net_qty.toFixed(3) ;
   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);

   //$(`#net_gross_total_qty`).text(net_total_qty);
   //$(`#total_app_qty`).text(net_qty);
     

}



function addItem()
{
   var item_uom=$(`#uom`).val();
    var item_id=$(`#item_id`).val();
    var item_name=$(`#item_id option:selected`).text();

  
 var grn_no=$("#grn_no").val();
  var batch_no=$("#item_batch_no").val();
  var unit=$("#unit").val();
  var qty=$("#qty").val();
   var qc_no=$("#qc_no").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();
  var stock=$("#stock_in_qty").val();

   var stage_id=$(`#process_id`).val();
  var stage_text=$(`#process_id option:selected`).text();
  if(stage_id==-1)
    stage_text='';
     
     if(item_name=='' ||  unit=='' || qty=='' || parseFloat(stock) < parseFloat(total) )
     {
        var err_name='',err_unit='',err_qty='',err_stock='';
           
           if(item_name=='')
           {
                err_name='Item is required.';
           }
        
           if(unit=='')
           {
            err_unit='Unit  is required.';
           }
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }
            if(parseFloat(stock) < parseFloat(total))
           {
            err_stock='Quantity should be less than stock qty.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_unit+' '+err_qty+' '+err_stock);

     }
     else
     {
      
        
     var row=this.row_num;   
    
    //<input type="hidden" form="ticket_form" id="app_qtys_${row}" name="app_qtys[]"  value="${app_qty}" ><td id="app_qty_${row}">${app_qty}</td><td id="gross_total_qty_${row}">${gross_total_qty}</td>

     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
    <input type="hidden" form="ticket_form" id="pivot_id_${row}"   name="pivot_ids[]" value="0"  >

    
     <input type="hidden" form="ticket_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
    

     <input type="hidden" form="ticket_form" id="grn_nos_${row}" name="grn_nos[]" value="${grn_no}" readonly >
     <input type="hidden" form="ticket_form" id="batch_nos_${row}" name="batch_nos[]" value="${batch_no}" readonly >
     <input type="hidden" form="ticket_form" id="qcs_${row}" name="qc[]"  value="${qc_no}">
     
     
     <input type="hidden" form="ticket_form" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     
     <input type="hidden" form="ticket_form" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="ticket_form" id="stages_${row}" name="stages[]"  value="${stage_id}">
     <input type="hidden" form="ticket_form" id="request_item_ids_${row}" name="request_item_ids[]"  value="0">
     
     <td></td>
     
     <td id="item_name_${row}">${item_name}</td>
     <td id="stage_text_${row}">${stage_text}</td>
      <td id="grn_no_${row}">${grn_no}</td>
     <td id="batch_no_${row}">${batch_no}</td>
     <td id="qc_${row}">${qc_no}</td>  
    
      
     
     <td id="unit_${row}">${unit}</td>
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="app_qty_${row}"></td>
     <td id="qty_${row}">${qty}</td>
     
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   $(`#item_id`).val('');
      $(`#item_id`).trigger('change');

  $("#uom").val('');


  $("#qc_no").val('');
  $("#grn_no").val('');
  
  $("#process_id").val('-1');
  $("#item_batch_no").val('');

  $("#unit").val('loose');
  $("#qty").val('1');
  $("#stock_in_qty").val('');
  $("#p_s").val('1');
  $("#total_qty").val('1');
  //$("#gross_total_qty").val('0');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

     
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  
          setNetQty();
           this.row_num ++;
   
   }
     
}//end add item

function updateItem(row)
{
  var item_uom=$(`#uom`).val();
    var item_id=$(`#item_id`).val();
    var item_name=$(`#item_id option:selected`).text();
  
   var qc_no=$("#qc_no").val();
 var grn_no=$("#grn_no").val();
   var batch_no=$("#item_batch_no").val();
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  //var app_qty=$("#app_qty").val();
  var p_s=$("#p_s").val();
  var total_qty=$("#total_qty").val();
  var stock=$("#stock_in_qty").val();

  var stage_id=$(`#process_id`).val();
  var stage_text=$(`#process_id option:selected`).text();

  if(stage_id==-1)
    stage_text='';
     
     if(item_name=='' ||  unit=='' || qty=='' || parseFloat(stock) < parseFloat(total_qty))
     {
        var err_name='',err_unit='',err_qty='',err_stock='';
           
           if(item_name=='')
           {
                err_name='Item is required.';
           }
           if(unit=='')
           {
            err_unit='Unit  is required.';
           }
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }
            if(parseFloat(stock) < parseFloat(total_qty))
           {
            err_stock='Quantity should be less than stock qty.';
           }


           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_unit+' '+err_qty+' '+err_stock);

     }
     else
     {
     
       
       $(`#item_id_${row}`).val(item_id);

       $(`#grn_nos_${row}`).val(grn_no);
       $(`#grn_no_${row}`).text(grn_no);

       $(`#qcs_${row}`).val(qc_no);
       $(`#qc_${row}`).text(qc_no);

       $(`#batch_nos_${row}`).val(batch_no);
       $(`#batch_no_${row}`).text(batch_no);
      
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        //$(`#app_qtys_${row}`).val(app_qty);
        $(`#p_ss_${row}`).val(p_s);
        $(`#stages_${row}`).val(stage_id);
       $(`#stage_text_${row}`).text(stage_text);

   
      
      $(`#item_name_${row}`).text(item_name);
    
      
      $(`#item_uom_${row}`).text(item_uom);
      $(`#unit_${row}`).text(unit);
        $(`#qty_${row}`).text(qty);
        //$(`#app_qty_${row}`).text(app_qty);
        $(`#p_s_${row}`).text(p_s);

       $(`#total_qty_${row}`).text(total_qty);
       //$(`#gross_total_qty_${row}`).text(gross_total_qty);
     
     
      if(p_s==null)
        p_s='';
     
   $("#uom").val('');
  $(`#item_id`).val('');
  $(`#item_id`).trigger('change');

 

  $("#grn_no").val('');
  
  $("#item_batch_no").val('');

  $("#unit").val('loose');
  
  $("#qty").val('1');
  $("#stock_in_qty").val('');
  $("#p_s").val('1');
  $("#total_qty").val('1');
  //$("#gross_total_qty").val('0');

  $("#qc_no").val('');
  
  $("#process_id").val('-1');


$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');


  document.getElementById('p_s').setAttribute('readonly', 'readonly');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
  
   
   }
     
}  //end update item

function addStock()
{
   total_qty=$('#total_qty').val();
   stock_in_qty=$('#stock_in_qty').val();
    now=parseFloat(total_qty) + parseFloat(stock_in_qty);
   $('#stock_in_qty').val(now);
}



function editItem(row)
{

var qc=$(`#qcs_${row}`).val();
$('#qc_no').val(qc);

 var batch_no=$(`#batch_nos_${row}`).val();
$('#item_batch_no').val(batch_no);
    

var unit=$(`#unit_${row}`).text();
$('#unit').val(unit);

var stage=$(`#stages_${row}`).val();
$('#process_id').val(stage);


  var qty=$(`#qty_${row}`).text();
$('#qty').val(qty);


  var p_s=$(`#p_s_${row}`).text();
   $('#p_s').val(p_s);

  var total_qty=$(`#total_qty_${row}`).text();
  $('#total_qty').val(total_qty);

  var item_name=$(`#item_name_${row}`).text();
   var item_id=$(`#item_id_${row}`).val();
   
   $(`#item_id`).val(item_id);
   $(`#item_id`).trigger('change');
  

    var grn_no=$(`#grn_nos_${row}`).val();
    $('#grn_no').val(grn_no);
     setGrnAtt();
addStock();

  


  //var gross_total_qty=$(`#gross_total_qty_${row}`).text();
  //$('#gross_total_qty').val(gross_total_qty);

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

  if(unit=='' || unit=='loose')
  {
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  $("#p_s").val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('p_s').removeAttribute('readonly');



}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
       // $(this).closest('tr').remove();
        $(`#${row}`).remove();
      setNetQty();
});

}






function setDesignation()
{
  var id=$('#issued_by').val();
  
  var emps=JSON.parse(`<?php echo json_encode($employees); ?>`);  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='' || emp==null || emp==0)
       $('#designation_issued_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_issued_by').val(emp);
     }
}

function setDesignation1()
{
  var id=$('#received_by').val();
  
  var emps=JSON.parse(`<?php echo json_encode($employees); ?>`);  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='' || emp==null || emp==0)
        $('#designation_received_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_received_by').val(emp);
     }

     setDepartment();
}

function setDepartment()
{
  var id=$('#received_by').val();
  
  var emps=JSON.parse(`<?php echo json_encode($employees); ?>`);  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['department_id'];
    
    if(emp=='' || emp==null || emp==0)
        $('#receiving_department').val('');
     else
     {
      var emp=emps[point]['department_id'];
      $('#receiving_department').val(emp);
     }
}   





function insert_item(item_name,stage_id,stage_text,item_uom,item_id,unit,qty,pack_size)
{  
  
    var item_name=item_name;
    var item_uom=item_uom;
    var item_id=item_id;
  
 
  var unit=unit;
  var qty=qty;
  var p_s=pack_size;
  var total=qty * pack_size;
     
     
      
        
     var row=getRowNum();   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
      <input type="hidden" form="ticket_form" id="pivot_id_${row}"   name="pivot_ids[]" value="0"  >

     
     <input type="hidden" form="ticket_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="ticket_form" id="grn_nos_${row}" name="grn_nos[]" value="" readonly >
     <input type="hidden" form="ticket_form" id="batch_nos_${row}" name="batch_nos[]" value="" readonly >
     <input type="hidden" form="ticket_form" id="qcs_${row}" name="qc[]"  value="">
     
     <input type="hidden" form="ticket_form" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="ticket_form" id="stages_${row}" name="stages[]"  value="${stage_id}">
     <input type="hidden" form="ticket_form" id="request_item_ids_${row}" name="request_item_ids[]"  value="0">
     
     <td></td>
     
     <td id="item_name_${row}">${item_name}</td>
    <td id="stage_text_${row}">${stage_text}</td>
     <td id="grn_no_${row}"></td>
     <td id="batch_no_${row}"></td>
     <td id="qc_${row}"></td>  
  
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="unit_${row}">${unit}</td>
     <td id="app_qty_${row}"></td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
 
     
   

    $("#selectedItems").append(txt);

  

$('#row_id').val('');



          setNetQty();
           setRowNum();
   
   
     
}//end add item



$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();

   

});




</script>

@endsection  
  