
@extends('layout.master')
@section('title', 'Edit Sale')
@section('header-css')
<style type="text/css">

</style>

<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
 


       <div class="container-fluid px-3 py-3">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1><i class="fas fa-file-invoice mr-2"></i>Sale Invoice</h1>
                </div>
                <div class="col-md-6">
                    <div class="action-buttons justify-content-md-end">
                        <button type="submit" form="purchase_demand" class="btn btn-success" >
                            <i class="fas fa-save"></i> Update
                        </button>
                         <button type="submit" form="delete_form" class="btn btn-action"><span class="fas fa-trash">&nbsp</span>Delete</button>
                        <button type="reset" class="btn btn-action">
                            <i class="fas fa-redo"></i> Clear
                        </button>
                        <a href="{{url('sale/create')}}" class="btn btn-action">
                            <i class="fas fa-plus"></i> New
                        </a>
                        <a href="{{url('sale/history')}}" class="btn btn-action">
                            <i class="fas fa-history"></i> History
                        </a>

                         <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('/estimated-invoice/report/'.$sale['id'].'/invoice')}}" class="dropdown-item">Invoice</a></li>
                      <li><a href="{{url('/export-invoice/report/'.$sale['id'])}}" class="dropdown-item">Invoice (Export)</a></li>
                      <li><a href="{{url('/estimated-invoice/report/'.$sale['id'].'/tp-invoice')}}" class="dropdown-item">TP Invoice</a></li>
                      <li><a href="{{url('/estimated-invoice/report/'.$sale['id'].'/mrp-invoice')}}" class="dropdown-item">MRP Invoice</a></li>
                    </ul>
                  </div>

                    </div>
                </div>
            </div>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Sale</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Invoice</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
      </div>
  @endsection

@section('content')
    <!-- Main content -->


   <form role="form" id="purchase_demand" method="POST" action="{{url('/sale/update')}}" onkeydown="return event.key != 'Enter';" >
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$sale['id']}}" name="id"/>
    
      <div class="container-fluid" style="margin-top: 10px;">

            @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             
                       @if ($errors->has('msg'))
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>

                                          <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>
  
                                @endif
     
      <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>


            <div class="row">
              <div class="col-md-3">
                  
                   <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-file-alt mr-2"></i>Document</h4>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Doc No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" id="doc_no" class="form-control" value="{{$sale['invoice_no']}}"  required style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>Doc Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control" value="{{$sale['invoice_date']}}" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Type</label>
                  <select form="purchase_demand" name="type" id="type" class="form-control" onchange="setDocNo()">
                     <option value="local">Local</option>
                     <option value="export">Export</option>
                  </select>
                  </div>

                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="active" value="1" id="active" class="" >
                  <label>Active</label>
                  </div>



              </div>

                                
                <!-- /.form-group -->
               
                
              </div>
              <!-- /.col -->
              <div class="col-md-4">

                 <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-user mr-2"></i>Customer</h4>

                  

                  <div class="dropdown" id="customers_table_customer_dropdown">
        <label>Customer</label>
        <input class="form-control"  name="customer_id" id="customer_id" onchange="" required>
      
           </div>

                <div class="form-group">
                  <label>Delivery Challan</label>
                  <select form="purchase_demand" name="challan_id" id="challan_id" class="form-control" onchange="uploadChallan()">
                    @if(isset($sale['challan']))
                     <option value="{{$sale['challan']['id']}}">{{$sale['challan']['doc_no']}}</option>
                     @else
                     <option value="">Select any challan</option>
                     @endif
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Sales Person</label>
                  <select form="purchase_demand" name="salesman_id" id="salesman_id" class="form-control">
                     <option value="">Select any saleman</option>
                     @foreach($salesmen as $men)
                     <option value="{{$men['id']}}">{{$men['name']}}</option>
                     @endforeach
                  </select>
                  </div>


                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control" >{{$sale['remarks']}}</textarea>
                </div>

                


                     
                        </div>

                      
             

              </div>
              <!-- /.col -->

              <div class="col-md-2">
                  
                  <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-money-bill mr-2"></i>Currency</h4>

                   <div class="form-group">
                  <label>Currency</label>
                  <select form="purchase_demand" name="currency_id" id="currency_id" class="form-control" onchange="setCurrency()" required>
                    <?php $default_cur_id=0; ?>
                    @foreach($currencies as $cur)
                    <?php
                     $s=''; 
                     if($cur['is_default']==1)
                      { $default_cur_id=$cur['id'];}

                    if($sale['currency_id']==$cur['id'])
                      {$s='selected'; }
                     ?>
                    <option value="{{$cur['id']}}" {{$s}} >{{$cur['symbol'].'~'.$cur['text']}}</option>
                    @endforeach
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Rate</label>
                  <?php  $r='';
                         if($default_cur_id==$sale['currency_id'])
                          $r='readonly';
                     ?>
                  <input type="number" step="any" form="purchase_demand" name="cur_rate" id="cur_rate" class="form-control" value="{{$sale['cur_rate']}}" {{$r}} required>
                  </div>

                 </div>
               </div>

               <!-- /.col -->


              <div class="col-md-3">
                  
                 <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-calculator mr-2"></i>Net Total</h4>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Disc.</label>
                  <input type="number" step="any" min="0" form="purchase_demand" name="disc" id="disc" class="form-control" value="{{$sale['net_discount']}}" onchange="setNetBill()"  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <input type="radio" form="purchase_demand" name="net_disc" value="flat" id="flat" class="" onchange="setNetBill()"  >
                  <label for="flat">Flat</label>
                  <input type="radio" form="purchase_demand" name="net_disc" value="percentage" id="percentage" onchange="setNetBill()" class=""  >
                  <label for="percentage">Percentage</label>
                  </div>

                  <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                  <label>GST %</label>
                  <input type="number" form="purchase_demand" step="any" name="gst" id="gst" class="form-control" value="{{$sale['gst']}}"  onchange="setNetBill()" style="width: 100%;">
                  </div>
                  </div>


                  <div class="col-sm-6">
                <div class="form-group">
                  <label>GST Amount</label>
                  <input type="number" step="any" name="gst_amount" id="gst_amount" class="form-control" value="" readonly style="width: 100%;">
                  </div>
                </div> 
                 </div>


                <div class="form-group">
                  <label>Net Total</label>
                  <input type="number" form="purchase_demand" name="net_bill" id="net_bill" class="form-control" value="" readonly  style="width: 100%;">
                  </div>

                


              </div>

                                
                <!-- /.form-group -->
               
                
              </div>

                            <!-- /.col -->

            </div>
            <!-- /.row -->

            

                           
                <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-plus-circle mr-2"></i>Add Item</h4>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Item</label>
                  <select class="form-control select2" onchange="" form="add_item" name="item_id_0" id="item_id_0">
                    <option value="">Select any value</option>
                    @foreach($inventories as $depart)
                    <option value="{{$depart['id']}}">{{$depart['item_name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                  
           

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control" form="add_item" name="unit" id="unit_0" required="true" onchange="setPackSize(0)" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty_0" onchange="setItemNet(0)" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              <!-- <div class="col-md-1">
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number"  form="add_item" name="stock" id="stock"  class="form-control" readonly style="width: 100%;">
                </div>
              </div>
 -->
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1" value="1" step="1"  form="add_item" name="p_s" id="p_s_0" value="1"  onchange="setItemNet(0)" class="form-control" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty_0" class="form-control" readonly style="width: 100%;">
                </div>
              </div>


             <div class="col-md-2">
                    <div class="form-group">
                  <label>MRP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="mrp" id="mrp_0" onchange="setItemNet(0)" class="form-control" style="width: 100%;">
                </div>
              </div>

              <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>TP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="tp" id="tp_0" onchange="setItemNet(0)" readonly class="form-control" style="width: 100%;">
                </div>
              </div>
 -->
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Rate</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="rate" id="rate_0" onchange="setItemNet(0)" class="form-control"  style="width: 100%;">
                </div>
              </div>


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discount Type</label>
                  <select class="form-control" form="add_item" name="discount_type" id="discount_type_0" required="true" onchange="setItemNet(0)" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="percentage" selected>Percentage</option>
                    <option value="flat">Flat</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discount Factor</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="discount_factor" id="discount_factor_0" onchange="setItemNet(0)" class="form-control" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discounted Value</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="discounted_value" id="discounted_value_0" class="form-control" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discounted Rate</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="discounted_rate" id="discounted_rate_0"  class="form-control" readonly  style="width: 100%;">
                </div>
              </div>


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total</label>
                  <input type="number" value="" min="0" step="any" onchange="setTotalAmount(0)" form="add_item" name="total" id="total_0" class="form-control" readonly style="width: 100%;">
                </div>
              </div>


              

              


              <div class="col-md-1 bt-col">
                    <div class="form-group">
                  <input type="hidden" name="row_id" id="row_id" >
                  <button type="button" form="add_item" id="add_item_btn" class="btn" onclick="addItem()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> <!--end row-->



                 </div>
                 
         


<!-- Start Tabs -->
<div class="form-section mb-4 p-2">

<div class="nav-tabs-wrapper mb-2">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA"><i class="fas fa-list mr-2"></i>Items</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB"><i class="fas fa-dollar-sign mr-2"></i>Expense</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC"><i class="fas fa-cog mr-2"></i>Others</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive p-0" style="">
      <table class="table table-bordered table-hover  table-head-fixed text-nowrap"  id="item_table" >
        <thead class="table-primary">
           <tr>

             <th>#</th>
            
             <th>Item</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Batch #</th>
             <th>Expiry date</th>
             <th>Total Qty</th>
              <th>MRP</th>
              <th>Rate</th>
              <th>Discount Type</th>
             <th>Discount Factor</th>
             <th>Discounted Value</th>
             <th>Discounted Rate</th>
             <th>Total</th>
            
            

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
             <th  id="net_qty"></th>
             
             <th></th>
             <th></th>
             <th></th>
             <th id="net_total_qty"></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_total"></th>
            
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

        
    </div>
   
    


   <div class="tab-pane fade" id="tabB">

      <div class="row">
              <div class="col-md-7">
               
                   <div class="border p-3 mb-3" style="border-radius: 8px;" >
                   <h4 class="form-section-title">Add Expenses</h4>

              
    
   <div id="expense_add_error" style="display: none;"><p class="text-danger" id="expense_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-5">
                    <div class="form-group">
                  <label>Expenses</label>
                  <select class="form-control" form="add_expense" name="expense" id="expense" style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($expenses as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
               
               

              

              <div class="col-md-1">
                    <div class="form-group">
                    <br>
                  <button type="button" form="add_expense" class="btn" id="add_expense_btn" style="width: 100%;" onclick="addExpense()">
                  <span class="fa fa-plus-circle text-info"></span>
                  </button>
                </div>
              </div>


</div> <!--end row-->



                 </div>
              
                  
                  <table class="table table-hover" >

                  <thead class="table-primary">
                <tr class="">
                <th class="">Expenses</th>
                <th class="">Amount</th>
                <th></th>
                </tr>
                    </thead>   

                    <tbody id="expenses_body" >           
                    </tbody>


                  
                  <?php $exp_row=1; ?>
                 @foreach($sale['expenses'] as $exp)



                 <tr class="col-sm-12" id="{{'exp_'.$exp_row}}">
                 <td>{{$exp['name']}}</td>

                 <td>
                  
                  <input type="hidden" name="expense_ids[]" form="purchase_demand" id="{{'exp_id_'.$exp_row}}" value="{{$exp['id']}}" >
                  <input type="number" step="any" value="{{$exp['pivot']['amount']}}" name="exp_amount[]" class="form-control col-sm-3 m-1" form="purchase_demand" id="{{'exp_amount_'.$exp_row}}"   onchange="setNetBill()" style="width: 100%;">
                  </td>

                  <td>
                    <button type="button" class="btn" onclick="removeExpense('{{$exp_row}}')"><span class="fa fa-minus-circle text-danger"></span></button>
                  </td>
                 </tr>
                  
                  <?php $exp_row++; ?>
                 @endforeach
                   
                  
                   </table>

                  

                
               
                
                
              </div>
              
        </div>
      
    </div>

<div class="tab-pane fade" id="tabC">

                <div class="form-row">

                  <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-2">Port of Shipment</label>
                  <select form="purchase_demand" name="shipment_port_id" id="shipment_port_id" class="form-control col-sm-4" >
                    <option value="">Select any value</option>
                    @foreach($ports as $de)
                    <option value="{{$de['id']}}">{{$de['text']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>

                  
                  <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-2">Port of Discharge</label>
                  <select form="purchase_demand" name="discharge_port_id" id="discharge_port_id" class="form-control col-sm-4" >
                    <option value="">Select any value</option>
                    @foreach($ports as $de)
                    <option value="{{$de['id']}}">{{$de['text']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>


                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-2">Packing Type</label>
                  <select form="purchase_demand" name="packing_type_id" id="packing_type_id" class="form-control col-sm-4" >
                    <option value="">Select any value</option>
                    @foreach($packing_types as $de)
                    <option value="{{$de['id']}}">{{$de['text']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-2">Freight Type</label>
                  <select form="purchase_demand" name="freight_type_id" id="freight_type_id" class="form-control col-sm-4" >
                    <option value="">Select any value</option>
                    @foreach($freight_types as $de)
                    <option value="{{$de['id']}}">{{$de['text']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>


                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-2">Transportations</label>
                  <select form="purchase_demand" name="transportation_id" id="transportation_id" class="form-control col-sm-4" >
                    <option value="">Select any value</option>
                    @foreach($transportations as $de)
                    <option value="{{$de['id']}}">{{$de['text']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>



                </div>

    </div>

   <!-- End TabC -->

   

   
</div>
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_item">
              
            </form>

             <form role="form" id="delete_form" method="POST" action="{{url('/sale/delete/'.$sale['id'])}}">
               
               @csrf    
           </form>

   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>


<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

<script type="text/javascript">

var row_num=1;

var expense_row_num="{{$exp_row}}";

function getExpenseRowNum()
 {
  return this.expense_row_num;
}

function setExpenseRowNum()
 {
     this.expense_row_num++;
}

$("#customer_id").change(function(){
      
      // var id=$('#customer_id').val();
      // var customers=`<?php //echo json_encode($customers) ; ?>`;
      //   customers=JSON.parse(customers);

      //   let point = customers.findIndex((item) => item.id == id);
         
      //    var so_id=customers[point]['so_id'];
      //    $('#salesman_id').val(so_id);

});


$(document).ready(function(){

$('.select2').select2(); 

  $("#item_table").colResizable({
     resizeMode:'overflow'
   });

  var id="{{$sale['salesman_id']}}";
  $('#salesman_id').val(id);

  var t="{{$sale['type']}}";
  $('#type').val(t);

  var active="{{$sale['activeness']}}";
     if(active==1)
     $('#active').prop('checked',true);
   else if(active==0)
     $('#active').prop('checked',false);

  //$('input[name="name_of_your_radiobutton"]:checked').val();
  var type="{{$sale['net_discount_type']}}";

  if(type=='flat')
     $('#flat').prop('checked',true);
   else if(type=='percentage')
     $('#percentage').prop('checked',true);


      var customer_id="{{$sale['customer']['id']}}";
      var customer_name="{{$sale['customer']['name']}}";

      $('#customer_id').val(customer_id);
var s=$("#customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(customer_name);

   $('#shipment_port_id').val("{{$sale['shipment_port_id']}}");
   $('#discharge_port_id').val("{{$sale['discharge_port_id']}}");
   $('#packing_type_id').val("{{$sale['packing_type_id']}}");
   $('#freight_type_id').val("{{$sale['freight_type_id']}}");
   $('#transportation_id').val("{{$sale['transportation_id']}}");

setSaleItems();
   setNetQty();

  

  $('#purchase_demand').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();

for (var i =1; i <= row_num ;  i++) {
if ($(`#total_qty_${i}`). length > 0 )
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

 function getRowNum()
 {
  return this.row_num;
}

function setRowNum()
{
  this.row_num ++;
}
  function setInventory(items)
 {
  
  
  var new_items=[];
 
 for(var i = 0 ; i < items.length ; i++)
 {
  var item_color='',item_type='',item_unit='',item_size='',item_category='';
  if(items[i]['color']!=null)
    item_color=items[i]['color']['name'];
   if(items[i]['type']!=null)
    item_type=items[i]['type']['name'];
   if(items[i]['unit']!=null)
    item_unit=items[i]['unit']['name'];
   if(items[i]['size']!=null)
    item_size=items[i]['size']['name'];
   if(items[i]['category']!=null)
    item_category=items[i]['category']['name'];

    combine='code_'+items[i]['item_code']+'_name_'+items[i]['item_name']+'_uom_'+item_unit+'_size_'+item_size+'_color_'+item_color+'_id_'+items[i]['id'];

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit,id:items[i]['id']};
         //alert(let);
         new_items.push(let);
 }


$('#item_code').inputpicker({
    data:new_items,
    fields:[
        {name:'code',text:'Code'},
        {name:'item',text:'Item'},
        {name:'type',text:'Type'},
        {name:'category',text:'Category'},
        {name:'size',text:'Size'},
        {name:'color',text:'Color'},
        {name:'unit',text:'Unit'}
    ],
    headShow: true,
    fieldText : 'item',
    fieldValue: 'id',
  filterOpen: true
    });

 }



function setCustomers(customers)
 {
  
  
  var new_customers=[];
 
 for(var i = 0 ; i < customers.length ; i++)
 {
  

         var let={ mobile:customers[i]['mobile'],customer:customers[i]['name'],id:customers[i]['id'],address:customers[i]['address'] };
         //alert(let);
         new_customers.push(let);
 }


$('#customer_id').inputpicker({
    data:new_customers,
    fields:[
        {name:'customer',text:'Customer'},
        {name:'mobile',text:'Mobile'},
        {name:'address',text:'Address'}
        
    ],
    headShow: true,
    fieldText : 'customer',
    fieldValue: 'id',
  filterOpen: true
    });

 }

$(document).ready(function(){
  

     var items=[];
      setInventory(items);

      var customers=<?php echo json_encode($customers) ?>;
      setCustomers(customers);
   
});






 function setDepartmentItem()
{
  var department_id= jQuery('#location').val();
  if(department_id=='')
  {
    var items=[];//blank array
    setInventory(items);
    return;
  }
   $("#item_name").val('');
    $("#item_id").val('');
    $("#item_code").val('');
    $("#item_size").val('');
    $("#item_color").val('');
   $("#item_unit").val('');

    $.ajax({
               type:'get',
               url:'{{ url("/department/inventory") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     department_id: jQuery('#location').val(),
                  

               },
               success:function(data) {

                items=data;
                 
                 
                 setInventory(items);



               }
             });
    
}//end setDepartmentItem


function setTp(row)//not using
{  
  var mrp=$(`#mrp_${row}`).val();

  var tp= (mrp * 0.85 ).toFixed(2) ;

  $(`#tp_${row}`).val(tp);
}

function rate_change(row)//not using
{
        $(`#discount_type_${row}`).val('flat');
        var rate=$(`#rate_${row}`).val();

        var tp=$(`#tp_${row}`).val();

           var discounted_value=(tp - rate).toFixed(2);;
           $(`#discount_factor_${row}`).val(discounted_value);

           $(`#discounted_value_${row}`).val(discounted_value);
setItemNet(row);

  }


function setDiscountedAmount(row)
{
  
  var rate=$(`#rate_${row}`).val();
  var discount_type=$(`#discount_type_${row}`).val();
  var discount_factor=$(`#discount_factor_${row}`).val();
  var discounted_value='';
  

   if(rate=='')
    rate=0;

  if(discount_factor=='')
    discount_factor=0;

       if(discount_type=='flat')
       {
          discounted_value=( parseFloat(discount_factor)).toFixed(2);
       }
       else if(discount_type=='percentage')
       {
           discounted_value=( (discount_factor / 100 ) * rate ).toFixed(2);
       }
              
       $(`#discounted_value_${row}`).val(discounted_value);

         d= ( rate - discounted_value ).toFixed(2) ;

       $(`#discounted_rate_${row}`).val(d);
}

  function setTotalAmount(row)
  {
    var total_qty=$(`#total_qty_${row}`).val();
    var rate=$(`#discounted_rate_${row}`).val();
      var total_amount='';

      if(rate=='')
        rate=0;

      total_amount = (rate * total_qty).toFixed(2) ;

      $(`#total_${row}`).val(total_amount);
  }

  
  

  function setItemNet(row)
  {
       setTotalQty(row);
       //setTp(row);
       setDiscountedAmount(row);
       setTotalAmount(row);
       
      

          setNetQty();
  }      

 



function setPackSize(row)
{
  var unit=$(`#unit_${row}`).val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s_${row}`).setAttribute('readonly', 'readonly');
  $(`#p_s_${row}`).val('1');
  setTotalQty(row);
   }
   else if( unit=='pack')
   document.getElementById(`p_s_${row}`).removeAttribute('readonly');
}

function setTotalQty(row)
{
  var qty=$(`#qty_${row}`).val();
  var p_s=$(`#p_s_${row}`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $(`#total_qty_${row}`).val(total_qty); 
}

function setNetQty() //for end of tabel to show net
{
  var rows=getRowNum();
  
   var net_total_qty=0, net_qty=0 , net_total=0;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).val();
       var qty=$(`#qty_${i}`).val();
       var total=$(`#total_${i}`).val();
      

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;

      if(total=='' || total==null)
        total=0;

            
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;

         net_total +=  parseFloat (total);//alert(net_total);

        
      }
         

   }  // alert(net_total);

   net_total =parseFloat (net_total).toFixed(2);
        

   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
   $(`#net_total`).text(net_total);
  

   
       setNetBill();

}


function setNetBill()
{
      var net_amount= $(`#net_total`).text() ;
      if(net_amount=='')
        net_amount=0;

       var disc=$(`#disc`).val();
       var disc_type=$('input[name="net_disc"]:checked').val();
       var disc_amount=0;

       if(disc=='')
            disc=0;

       if(disc_type=='flat')
       {
             disc_amount=disc;
       }
       else if(disc_type=='percentage')
       {
           disc_amount= (disc / 100) * net_amount;
       }

         // net_amount=net_amount - disc_amount ;

       


          var gst=$(`#gst`).val(); 
          if(gst=='')
            gst=0;
          var gst_amount=0;
           gst_amount=( gst / 100) *  net_amount;   
            gst_amount= Math.round(gst_amount *100)/100; 
            //alert(gst_amount);
             net_amount=parseFloat(net_amount) + parseFloat(gst_amount) - parseFloat(disc_amount) ;
              $(`#gst_amount`).val(gst_amount);

              net_amount= Math.round(net_amount *100)/100; 
           $(`#net_bill`).val( net_amount ) ;

           //expense
        var row=getExpenseRowNum();
     
  for (var i = 1; i <= row; i++) {
      if($(`#exp_amount_${i}`). length == 0 || $(`#exp_amount_${i}`). length < 0)
      continue;
        var debit=$(`#exp_amount_${i}`).val();  
        net_amount= parseFloat(net_amount) + parseFloat(debit); 
  }

  
        net_amount= Math.round(net_amount *100)/100; 
  $(`#net_bill`).val(net_amount);
  }

function checkItem(row='')
{
  var rows=getRowNum();
  for (var i =1; i <= rows ;  i++) {
   
     if ($(`#item_id_${i}`). length == 0 || $(`#item_id_${i}`). length < 0 )
     {
      continue;
     }
     if (row == i  )
     {
      continue;
     }
     var item_id=$("#item_id_0").val();

    // item_combine=item_combine.split('_');
    // var item_id='';
    // if(item_combine!='')
    // {     item_id=item_combine[11];
    //  }

     var tbl_item_id=$(`#item_id_${i}`).val(); 

     if(item_id == tbl_item_id)
      return true;
     
  
   }
  return false;   
   
}

function addItem()
{


   var item_id=$("#item_id_0").val();
   var item_name=$("#item_id_0 option:selected").text(); 
    
 
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total_qty=$("#total_qty_0").val();

  var mrp=$("#mrp_0").val();
  var batch_no='';
  var expiry_date='';

var readonly='';
  if(unit=='loose')
     readonly='readonly';

  
  var discount_type=$("#discount_type_0").val(); 
  var discount_factor=$("#discount_factor_0").val();
  var discounted_value=$("#discounted_value_0").val();
  var rate=$("#rate_0").val();
  var discounted_rate=$("#discounted_rate_0").val();
  var total=$("#total_0").val();
  
  var percentage='', flat='';
  if(discount_type=='percentage')
      percentage='selected';
     else if(discount_type=='flat')
      flat='selected';
    
    var dbl_item=false;
  if(item_name!='')
  {
     dbl_item=checkItem();
  }

  // var is_item=false;

  // if(item_name!='')
  // {
  //    is_item=isItem(item_name);
  // }
     //alert(is_item);
     if(item_name=='' ||  unit=='' || qty=='' || dbl_item==true)
     {
        var err_name='',err_location='',err_unit='',err_qty='', err_dbl='';
           
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

           if(dbl_item==true)
           {
            err_dbl='Item already added.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_location+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})">
       <input type="hidden" form="purchase_demand" id="pivot_id_${row}" name="pivots_id[]" value="0" readonly >
      </th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

   
     
     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" class="form-control" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" class="form-control" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" class="form-control" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      <td><input type="text" value="${batch_no}" class="form-control" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  ></td>

      <td><input type="date" value="${expiry_date}" class="form-control" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  ></td>
     
     <td><input type="number" value="${total_qty}" min="1" class="form-control" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any"  class="form-control" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

     <td><input type="number" value="${rate}" step="any" class="form-control" form="purchase_demand" name="rate[]" id="rate_${row}"  onchange="setItemNet(${row})" ></td>

     <td><select form="purchase_demand" name="discount_type[]" class="form-control" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any"  class="form-control" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any"  class="form-control" form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

    
     <td><input type="number" value="${discounted_rate}" step="any"  class="form-control" form="purchase_demand" name="discounted_rate[]" id="discounted_rate_${row}"  readonly ></td>


     <td><input type="number" value="${total}" step="any"  class="form-control" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

  

  $("#unit_0").val('loose');
  $("#qty_0").val('1');
  $("#p_s_0").val('1');
  $("#total_qty_0").val('1');

  $("#mrp_0").val('');
  $("#batch_no_0").val('');
  $("#expiry_date_0").val('');
  //$("#tp_0").val('');
  $("#discount_factor_0").val('');
  $("#discounted_value_0").val('');
  $("#rate_0").val('');
  $("#discounted_rate_0").val('');
  $("#total_0").val('');
 

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

     
  document.getElementById('p_s_0').setAttribute('readonly', 'readonly');
  
          setNetQty();
           setRowNum();
   
   }
   
     
}//end add item

function updateItem(row)
{
  var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
  
    if(item_combine!='')
    {
    var item_name=item_combine[3];
    var item_code=item_combine[1];
    var item_color=item_combine[9];
    var item_size=item_combine[7];
    var item_uom=item_combine[5];
    var item_id=item_combine[11];
  }
  else
  {
    var item_name='';
    var item_code='';
    var item_color='';
    var item_size='';
    var item_uom='';
    var item_id='';
  }

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();

  var dbl_item=false;
  if(item_name!='')
  {
     dbl_item=checkItem(row);
  }
     
     if(item_name=='' || location=='' || unit=='' || qty=='' || dbl_item==true)
     {
        var err_name='',err_location='',err_unit='',err_qty='', err_dbl='';
           
           if(item_name=='')
           {
                err_name='Item is required.';
           }
           if(location=='')
           {
            err_location='Location is required.';
           }
           if(unit=='')
           {
            err_unit='Unit  is required.';
           }
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }

            if(dbl_item==true)
           {
            err_dbl='Item already added.';
           }

           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_location+' '+err_unit+' '+err_qty);

     }
     else
     {
     
       $(`#location_id_${row}`).val(location);
       $(`#item_id_${row}`).val(item_id);
        
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        $(`#p_ss_${row}`).val(p_s);

      $(`#location_text_${row}`).text(location_text);
     $(`#code_${row}`).text(item_code);
      
      $(`#item_name_${row}`).text(item_name);
      
      $(`#color_${row}`).text(item_color);
      $(`#size_${row}`).text(item_size);
      $(`#item_uom_${row}`).text(item_uom);
      $(`#unit_${row}`).text(unit);
        $(`#qty_${row}`).text(qty);
        $(`#p_s_${row}`).text(p_s);

       $(`#total_qty_${row}`).text(total_qty);
     
     
      if(p_s==null)
        p_s='';
     
   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');

  $("#item_name").val('');
  $("#item_id").val('');

  $("#location").val('');
  $("#unit").val('loose');
  $("#qty").val('1');
  $("#p_s").val('1');
  $("#total_qty").val('1');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');


  document.getElementById('p_s').setAttribute('readonly', 'readonly');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
   
   }
     
}  //end update item

function editItem(row)
{
}
function editItem1(row)
{
   
   var item_name=$(`#item_name_${row}`).text();
   var item_code=$(`#code_${row}`).text();
   var item_id=$(`#item_id_${row}`).val();
   var item_color=$(`#color_${row}`).text();
   var item_uom=$(`#item_uom_${row}`).text();
   var item_size=$(`#size_${row}`).text();
   
   combine='code_'+item_code+'_name_'+item_name+'_uom_'+item_uom+'_size_'+item_size+'_color_'+item_color+'_id_'+item_id;

   $('#item_code').val(combine);
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(item_name);


var location_id=$(`#location_id_${row}`).val();
$('#location').val(location_id);


var unit=$(`#unit_${row}`).text();
$('#unit').val(unit);



  var qty=$(`#qty_${row}`).text();
$('#qty').val(qty);


  var p_s=$(`#p_s_${row}`).text();
  $('#p_s').val(p_s);
  


  var total_qty=$(`#total_qty_${row}`).text();
  $('#total_qty').val(total_qty);

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
    $(`#${row}`).remove();
      setNetQty();
      });

}


function setDeliveryChallan()
{
    var customer_id=$('#customer_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/customer/new/challans") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     customer_id: customer_id,
                  

               },
               success:function(data) {

                var orders = data;
                  opt_txt=`<option value="">Select Delivery Challan</option>`;

                      for (var i =0; i < orders.length ;  i++) {
                            txt    = `<option value="${orders[i]['id']}">${orders[i]['doc_no']}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                      }

                      $('#challan_id').empty().append(opt_txt);

               }
             });


}

function uploadChallan()
{
  var challan_id=$('#challan_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/delivery/challan") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     challan_id: challan_id,
                  

               },
               success:function(data) {

                var items = data;
            
                  
                  $('#selectedItems').html('');

                      for (var i =0; i < items.length ;  i++) {

                        var row=getRowNum();

                        var item_id=items[i]['item_id'];
                        var location=items[i]['location_id'];
                        var location_text=items[i]['location_text'];
                        var item_name=items[i]['item_name'];
                        var unit=items[i]['unit'];
                        var qty=items[i]['qty'];
                        var p_s=items[i]['pack_size'];
                        var mrp=items[i]['mrp'];
                        
                         var batch_no=items[i]['batch_no']; 
                         var expiry_date=items[i]['expiry_date']; 
                         var total_qty=items[i]['total_qty'];
                         var discount_type=items[i]['discount_type'];
                         var discount_factor=items[i]['discount_factor'];
                         var discounted_value=items[i]['discounted_value'];
                         var rate=items[i]['rate'];
                         var discounted_rate=items[i]['discounted_rate'];
                         var total=items[i]['total'];
                         


                        var readonly='';
                        if(unit=='loose')
                          readonly='readonly';

                        var flat='',percentage='';
                        if(discount_type=='flat')
                          flat='selected';
                        else if(discount_type=='percentage')
                          percentage='selected';
                            
      var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})">
        <input type="hidden" form="purchase_demand" id="pivot_id_${row}" name="pivots_id[]" value="0" readonly >
      </th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" class="form-control" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" class="form-control" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" class="form-control" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      <td><input type="text" value="${batch_no}" class="form-control" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  ></td>

      <td><input type="date" value="${expiry_date}" class="form-control" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  ></td>
     
     <td><input type="number" value="${total_qty}" min="1" class="form-control" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any" class="form-control" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

     <td><input type="number" value="${rate}" step="any" class="form-control" form="purchase_demand" name="rate[]" id="rate_${row}" onchange="setItemNet(${row})"  ></td>

     <td><select form="purchase_demand" name="discount_type[]" class="form-control" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any" class="form-control" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any" class="form-control" form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${discounted_rate}" step="any" class="form-control" form="purchase_demand" name="discounted_rate[]" id="discounted_rate_${row}" readonly ></td>

     <td><input type="number" value="${total}" step="any" class="form-control" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>

     
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

       $('#selectedItems').append(txt);
            setRowNum();      
                  
                      }

                   setNetQty();   
               }
             });
}



function setSaleItems()
{

       var items= `<?php echo json_encode($items); ?>`; 

       items= JSON.parse( items );

        //alert(items[0]['item_name']);

for (var i =0; i < items.length ;  i++) {

                        var row=getRowNum();

                        var item_id=items[i]['item_id'];
                        var pivot_id=items[i]['pivot_id'];
                        
                      
                        var item_name=items[i]['item_name'];
                        var unit=items[i]['unit'];
                        var qty=items[i]['qty'];
                        var p_s=items[i]['pack_size'];
                        var mrp=items[i]['mrp'];
                        
                         var batch_no=items[i]['batch_no']; 
                         var expiry_date=items[i]['expiry_date']; 
                         var total_qty=items[i]['total_qty'];
                         var discount_type=items[i]['discount_type'];
                         var discount_factor=items[i]['discount_factor'];
                         var discounted_value=items[i]['discounted_value'];
                         var rate=items[i]['rate'];
                         var discounted_rate=items[i]['discounted_rate'];
                         var total=items[i]['total'];
                      
                         
                        

                         var flat='', percentage='';
                         if(discount_type=='flat')
                          flat='selected';
                         else if(discount_type=='percentage')
                          percentage='selected';


                        var readonly='';
                        if(unit=='loose')
                          readonly='readonly';
                            
      var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})" >
      <input type="hidden" form="purchase_demand" id="pivot_id_${row}" name="pivots_id[]" value="${pivot_id}" readonly >
      </th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" class="form-control" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" class="form-control" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" class="form-control" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      <td><input type="text" value="${batch_no}" class="form-control" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  ></td>

      <td><input type="date" value="${expiry_date}" class="form-control" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  ></td>
     
     <td><input type="number" value="${total_qty}" min="1" class="form-control" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any" class="form-control" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

      <td><input type="number" value="${rate}" step="any" class="form-control" form="purchase_demand" name="rate[]" id="rate_${row}" onchange="setItemNet(${row})" ></td>

     <td><select form="purchase_demand" name="discount_type[]" class="form-control" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any" class="form-control" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any" class="form-control" form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${discounted_rate}" step="any" class="form-control" form="purchase_demand" name="discounted_rate[]" id="discounted_rate_${row}" readonly ></td>

     <td><input type="number" value="${total}" step="any" class="form-control" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

       $('#selectedItems').append(txt);
            setRowNum();      
                  
                      }

}


function addExpense()
{
  
  
  var expense=$("#expense").val();
   var expense_text=$("#expense option:selected").text();
   if(expense=='')
      return ;


  var dbl_item=false;
  
  
     dbl_item=checkExpense();
  
     
     if( dbl_item==true)
     {
        var  err_dbl='';
           
           
           if(dbl_item==true)
           {
            err_dbl='Expense already added.';
           }



           $("#expense_add_error").show();
           $("#expense_add_error_txt").html(err_dbl);

     }
     else
     {


      var rows = getExpenseRowNum();


          


             var txt=`
             <tr class="" id="exp_${rows}">
               
                  <td class="">${expense_text}</td>

                   <td class="">
                  <input type="hidden" name="expense_ids[]" form="purchase_demand" id="exp_id_${rows}" value="${expense}" >
                  <input type="number" step="any" value="0" name="exp_amount[]" class="form-control col-sm-3 m-1" form="purchase_demand" id="exp_amount_${rows}"   onchange="setNetBill()" style="width: 100%;">
                  </td>

                   <td class="">
                    <button type="button" class="btn" onclick="removeExpense(${rows})"><span class="fa fa-minus-circle text-danger"></span></button>
                   </td>

                 </tr>
            `;

     

   

    $("#expenses_body").append(txt);

  

           $("#expense_add_error").hide();
           $("#expense_add_error_txt").html('');

           $("#expense").val('');
            setExpenseRowNum(); 
   
   }


     
}//add expense

function checkExpense(row='')
{
  var rows=getExpenseRowNum();
  for (var i =1; i <= rows ;  i++) {
   
     if ($(`#exp_${i}`). length == 0 || $(`#exp_${i}`). length < 0 )
     {
      continue;
     }
     if (row == i  )
     {
      continue;
     }
     var expense=$("#expense").val();
    

     var tbl_exp=$(`#exp_id_${i}`).val(); 
//alert(expense+' '+tbl_exp);
     if(expense == tbl_exp)
      return true;
     
  
   }
  return false;   
   
}


function removeExpense(row)
{
  
 
    $(`#exp_${row}`).remove();
    setNetBill();
  

}

function setCurrency()
  {   

      var cur_id=$(`#currency_id`).val();
      var d="{{$default_cur_id}}";

    if(cur_id==d )
    {
      $("#cur_rate").attr("readonly", true);
      $(`#cur_rate`).val('1');
     }
     else
     {
       $("#cur_rate").attr("readonly", false);
      //$(`#cur_rate`).val('1');
     } 
  }

function setDocNo()
{
   var type=$('#type').val();
    
    var let_type="{{$sale['type']}}";
   if(type==let_type)
   {
       $('#doc_no').val("{{$sale['doc_no']}}");
        return ;
   }

 $.ajax({
               type:'post',
               url:'{{ url("/get/sale/code") }}',
               data:{
                    
                     "_token": "{{ csrf_token() }}",
                    
                     type: type ,
                     
               },
               success:function(data) {

                code=data;
                 
                 $('#doc_no').val(code);
                 



               }
             });
  

}

</script>

@endsection  
  