
@extends('layout.master')
@section('title', 'Edit Delivery Challan')
@section('header-css')
<style type="text/css">


.fx{
   max-width: 100px;
 }

 
</style>

<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">

@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
    

      



       <!-- Page Header -->

        <div class="container-fluid px-3 py-3">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1><i class="fas fa-file-invoice mr-2"></i>Delivery Challan</h1>
                </div>
                <div class="col-md-6">
                    <div class="action-buttons justify-content-md-end">
                        <button type="submit" form="purchase_demand" class="btn btn-success" >
                            <i class="fas fa-save"></i> Update
                        </button>

                         <button type="submit" form="delete_form" class="btn btn-action"><i class="fas fa-trash">&nbsp</i>Delete</button>

                        <button type="reset" class="btn btn-action">
                            <i class="fas fa-redo"></i> Clear
                        </button>
                       
                       <a href="{{url('delivery-challan/create')}}" class="btn btn-action">
                            <i class="fas fa-plus"></i> New
                        </a>

                        <a href="{{url('delivery-challan/history')}}" class="btn btn-action">
                            <i class="fas fa-history"></i> History
                        </a>

                         <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle"  data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('/delivery-challan/report/'.$challan['id'].'/local')}}" class="dropdown-item">Delivery Challan</a></li>
                      <li><a href="{{url('/delivery-challan/report/'.$challan['id'].'/tendor')}}" class="dropdown-item">Delivery Challan(Tendor)</a></li>
                      <li><a href="{{url('/delivery-challan/report1/'.$challan['id'])}}" class="dropdown-item">Delivery Challan1</a></li>
                      <li><a href="{{url('/delivery-challan/form/'.$challan['id'])}}" class="dropdown-item">Form</a></li>
                      <li><a href="{{url('warranty-invoice/fahmir/'.$challan['id'])}}" class="dropdown-item">Warrenty (Fahmir)</a></li>
                      <li><a href="{{url('warranty-invoice/alsehat/'.$challan['id'])}}" class="dropdown-item">Warrenty (Al-Sehat)</a></li>
                    </ul>
                  </div>


                    </div>
                </div>
            </div>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Sale</a></li>
                     <li class="breadcrumb-item"><a href="#" class="text-white-50">Delivery Challan</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
      </div>
        <!---------->

  @endsection

@section('content')
    <!-- Main content -->

<form role="form" id="purchase_demand" method="POST" action="{{url('/delivery-challan/update')}}" onkeydown="return event.key != 'Enter';" >
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$challan['id']}}" name="id"/>
    
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
              <div class="col-md-4">
                  
                 
                    <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-file-alt mr-2"></i>Document</h4>

                <!-- /.form-group -->
                <div class="form-group row">
                  <label class="col-sm-4">Doc No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control  col-sm-8" value="{{$challan['doc_no']}}"  required style="width: 100%;">
                  </div>


                <div class="form-group row">
                  <label class="col-sm-4">Doc Date</label>
                  <input type="date" form="purchase_demand" name="challan_date" class="form-control  col-sm-8" value="{{$challan['challan_date']}}" required style="width: 100%;">
                  </div>

                   <div class="form-group row">
                  <label class="col-sm-4">Deliver Through</label>
                  <select class="form-control  col-sm-8" name="deliver_via" id="deliver_via" style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($methods as $mt)
                    <option value="{{$mt['id']}}">{{$mt['name']}}</option>
                    @endforeach
                  </select>
                  </div>




                  <div class="form-group row">
                  <label class="col-sm-4">Bilty No</label>
                  <input type="text" form="purchase_demand" name="bilty_no" class="form-control  col-sm-8" value="{{$challan['bilty_no']}}"  style="width: 100%;">
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">Type</label>
                  <select class="form-control  col-sm-8" name="bilty_type" id="bilty_type" style="width: 100%;">
                    <option value="">Select any value</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                    
                  </select>
                  </div>

                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="active" value="1" id="activeness" class=""  >
                  <label>Active</label>
                  </div>

                  <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="delivered" value="1" id="delivered" class=""  >
                  <label>Delivered</label>
                  </div>




              </div>

                                
                <!-- /.form-group -->
               
                
              </div>
              <!-- /.col -->
              <div class="col-md-5">

                 <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-user mr-2"></i>Customer</h4>

                  

                  <div class="dropdown" id="customers_table_customer_dropdown">
        <label>Customer</label>
        <input class="form-control"  name="customer_id" id="customer_id" onchange="setSaleOrder()" required>
      
           </div>

           <div class="form-group">
                  <label>Sale Order</label>
                  <select form="purchase_demand" name="order_id" id="order_id" class="form-control " onchange="uploadSaleOrder()">
                     <option value="">Select sale order</option>
                     @if($challan['order']!='')
                     <option value="{{$challan['order_id']}}" selected>@if(isset($challan['order'])){{$challan['order']['doc_no']}}@endif</option>
                     @endif
                  </select>
                  </div>


                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control" >{{$challan['remarks']}}</textarea>
                </div>

                


                     
                        </div>

                      
             

              </div>
              <!-- /.col -->

              <!-- <div class="col-md-3">
 -->                  
                  <!-- <fieldset class="border p-4">
                   <legend class="w-auto">Net Total</legend> -->

                <!-- /.form-group -->
               <!--  <div class="form-group">
                  <label>Disc.</label>
                  <input type="number" step="any" min="0" form="purchase_demand" name="disc" id="disc" class="form-control " value="" onchange="setNetBill()" style="width: 100%;">
                  </div> -->

                  <!-- <div class="form-group">
                  <input type="radio" form="purchase_demand" name="net_disc" value="flat" id="flat" class="" onchange="setNetBill()"  checked>
                  <label for="flat">Flat</label>
                  <input type="radio" form="purchase_demand" name="net_disc" value="percentage" id="percentage" onchange="setNetBill()" class=""  >
                  <label for="percentage">Percentage</label>
                  </div> -->


                <!-- <div class="form-group">
                  <label>Net Total</label>
                  <input type="number" form="purchase_demand" name="net_bill" id="net_bill" class="form-control " value="" readonly  style="width: 100%;">
                  </div>

                


              </fieldset>
 -->
                                
                <!-- /.form-group -->
               
                
             <!--  </div> -->

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
                  <select class="form-control select2" onchange="setBatches(0)" form="add_item" name="item_id_0" id="item_id_0">
                    <option value="">Select any value</option>
                    @foreach($inventories as $depart)
                    <option value="{{$depart['id']}}">{{$depart['item_name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Batch No</label>
                  <select class="form-control" form="add_item" name="batch_no" id="batch_no_0" required="true" onchange="setBatchInfo(0)" style="width: 100%;">
                    <option value="">Select any value</option>
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
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty_0" onchange="setItemNet(0)" class="form-control " required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1" value="1" step="1"  form="add_item" name="p_s" id="p_s_0" value="1"  onchange="setItemNet(0)" class="form-control " readonly required="true" style="width: 100%;">
                </div>
              </div>


              
              
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty_0" class="form-control " readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number" step="any"  form="add_item" name="stock_0" id="stock_0"  class="form-control" readonly style="width: 100%;">
                </div>
              </div>

              
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Exp Date</label>
                  <input type="date"  form="add_item" name="expiry_date" id="expiry_date_0"  class="form-control " style="width: 100%;">
                </div>
              </div>


             <div class="col-md-2">
                    <div class="form-group">
                  <label>MRP</label>
                  <input type="number" value="" step="any" form="add_item" name="mrp" id="mrp_0" onchange="setItemNet(0)" class="form-control " style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>TP</label>
                  <input type="number" value="" step="any"  form="add_item" name="tp" id="tp_0" onchange="setItemNet(0)" readonly class="form-control" style="width: 100%;">
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
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive p-0" style="">
      <table class="table table-bordered table-hover table-head-fixed text-nowrap"  id="item_table" >
        <thead class="table-primary">
           <tr>

              <th>#</th>
             <th>Item</th>
             <th class="fx">UOM</th>
              <th class="fx">Batch #</th>
             <th class="fx">Order Qty</th>
             <th class="fx">Unit</th>
             <th class="fx">Deliver Qty</th>
             <th class="fx">Pack Size</th>
             
             <th class="fx">Total Qty</th>
             <th class="fx">Stock</th>
             <th>Expiry date</th>
              <th>MRP</th>
              <th>TP</th>
             <!--  <th>Business Type</th>
              <th>Discount Type</th>
             <th>Discount Factor</th>
             <th>Discounted Value</th>
             <th>Rate</th>
             <th>Total</th>
             <th>Tax %</th>
             <th>Tax Amount</th>
              <th>Net Amount</th> -->

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

          <?php $row=1; ?>

          @foreach($challan['outgoing_stock_list'] as $item)

          <?php 
           $unit=$item['unit'];
          
          $readonly='';
                        if($unit=='loose')
                          $readonly='readonly';




               $total_qty=$item['qty'] *$item['pack_size'];

               $tp=round((0.85 * $item['mrp']),2);
                
                $order_qty='';
                if(isset($item['order_item']))
              $order_qty=$item['order_item']['qty'] * $item['order_item']['pack_size'];



           ?>
              
              <tr id="{{$row}}">
      <th ondblclick="editItem('{{$row}}')">

        <input type="hidden" form="purchase_demand" id="{{'pivot_id_'.$row}}" name="pivot_ids[]" value="{{$item['id']}}" >
        
      </th>
     
     <input type="hidden" form="purchase_demand" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item']['id']}}" readonly >

        

     <td ondblclick="editItem('{{$row}}')" id="{{'item_name_'.$row}}">{{$item['item']['item_name']}}</td>
       
       <td ondblclick="editItem('{{$row}}')" id="{{'item_uom_'.$row}}">@if($item['item']['unit']!=''){{$item['item']['unit']['name']}}@endif</td>

       <td>
        <select form="purchase_demand" class="form-control fx" name="batch_no[]" id="{{'batch_no_'.$row}}" onchange="setBatchInfo('{{$row}}')">
          <option value="">Select any value</option>
            <?php


                  $key=array_search($item['item_id'], array_column($inventories, 'id'));

                    $batches=[];
                  //$batches=$inventories[$key]['batches'];
                  
                      //if(isset($item['item']))
                      //$stock=$total_qty+$item['item']['current_stock'];
                    $stock=0;
             ?>

          @foreach($batches as $bt)
          <?php $s='';
             if($bt['batch_no']==$item['batch_no'])
              {$s='selected'; $stock=$total_qty+$bt['qty']; }
           ?>
            <option value="{{$bt['batch_no']}}" {{$s}}>{{$bt['batch_no']}}</option>
          @endforeach
        </select>

              
      </td>

      <td ><input type="hidden" form="purchase_demand" id="{{'order_item_id_'.$row}}" class="fx" name="order_items_id[]" value="{{$item['item_order_id']}}"  >{{$order_qty}}</td>

     <td><input type="text" value="{{$item['unit']}}" class="form-control fx" form="purchase_demand" name="units[]" id="{{'unit_'.$row}}" required="true" readonly onchange="setPackSize('{{$row}}')"></td>
   
     <td><input type="number" value="{{$item['qty']}}" min="1" class="form-control fx" form="purchase_demand" name="qtys[]" id="{{'qty_'.$row}}" onchange="qty_chk('{{$row}}'); setItemNet('{{$row}}');" required="true"></td>

     <td><input type="number" value="{{$item['pack_size']}}" min="1" class="form-control fx" form="purchase_demand" name="p_s[]" id="{{'p_s_'.$row}}" onchange="qty_chk('{{$row}}'); setItemNet('{{$row}}');" {{$readonly}} required="true"></td>
     
     
     <td><input type="number" value="{{$total_qty}}" min="1" class="form-control fx" form="purchase_demand" id="{{'total_qty_'.$row}}" readonly ></td>

     <td><input type="number" step="any" class="form-control fx" form="purchase_demand" name="" id="{{'stock_'.$row}}" value="{{$stock}}"  readonly></td>

      <td><input type="date" value="{{$item['expiry_date']}}" class="form-control" form="purchase_demand" name="expiry_date[]" id="{{'expiry_date_'.$row}}"  ></td>

     <td><input type="number" value="{{$item['mrp']}}" step="any" class="form-control fx"  form="purchase_demand" name="mrp[]" id="{{'mrp_'.$row}}" onchange="setItemNet('{{$row}}')"  ></td>

     <td><input type="number" value="{{$tp}}" step="any" class="form-control fx"  form="purchase_demand" name="tp[]" id="{{'tp_'.$row}}" onchange="setItemNet('{{$row}}')"  readonly></td>

     
    


     

         <td><button type="button" class="btn" onclick="removeItem('{{$row}}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>

           <?php $row++; ?>
          @endforeach

          
          
        </tbody>
        <tfoot class="table-secondary">
          <tr>

            <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             
             <th  id="net_qty"></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_total_qty"></th>
             <th></th>
             <th></th>
             
             <!-- <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_total"></th>
             <th></th>
             <th></th>
             <th id="net_amount"></th> -->
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

        
    </div>
   
    
   

   
</div>
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_item">
              
            </form>

              

    <form role="form" id="delete_form" method="POST" action="{{url('/challan/delete/'.$challan['id'])}}">
               
               @csrf    
    </form>
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>


<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

<script type="text/javascript">

var row_num="{{$row}}";  var items=[];


$(document).ready(function(){

  $('.select2').select2(); 

  var active="{{$challan['activeness']}}";
     if(active==1)
     $('#activeness').prop('checked',true);
   else if(active==0)
     $('#activeness').prop('checked',false);

   var deliver_via="{{$challan['deliver_via']}}";
     $('#deliver_via').val(deliver_via);

     var bilty_type="{{$challan['bilty_type']}}";
     $('#bilty_type').val(bilty_type);


var delivered="{{$challan['delivered']}}";
     if(delivered==1)
     $('#delivered').prop('checked',true);
   else if(delivered==0)
     $('#delivered').prop('checked',false);   


      var customer_id="{{$challan['customer']['id']}}";
      var customer_name="{{$challan['customer']['name']}}";

      $('#customer_id').val(customer_id);
var s=$("#customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(customer_name);

    //setItems1();
   setNetQty();


  $("#item_table").colResizable({
     resizeMode:'overflow'
   });

  

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

function getItems()
 {   
  return this.items;
}

function setItems(items)
{
  this.items =items; 
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


$('#item_id_0').inputpicker({
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
    $("#item_id_0").val('');
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
                  setItems(items); 

               }
             });
    
}//end setDepartmentItem


function setTp(row)
{  
  var mrp=$(`#mrp_${row}`).val();

  var tp= (mrp * 0.85 ).toFixed(2) ;

  $(`#tp_${row}`).val(tp);
}

function rate_change(row)
{
        $(`#discount_type_${row}`).val('flat');
        var rate=$(`#rate_${row}`).val();

        var tp=$(`#tp_${row}`).val();

           var discounted_value=(tp - rate).toFixed(2);
           $(`#discount_factor_${row}`).val(discounted_value);

           $(`#discounted_value_${row}`).val(discounted_value);

          setItemNet(row);

  }

function setDiscountedAmount(row)
{
  var tp=$(`#tp_${row}`).val();
  var bt=$(`#business_type_${row}`).val();
  var discount_type=$(`#discount_type_${row}`).val();
  var discount_factor=$(`#discount_factor_${row}`).val();
  var discounted_value='';
  var rate='';

  if(tp=='')
    tp=0;

  if(bt=='flat_rate')
  {
        $(`#discount_type_${row}`).val('flat');
        var rate=$(`#rate_${row}`).val();

           var discounted_value=(tp - rate).toFixed(2);
           $(`#discount_factor_${row}`).val(discounted_value);

           $(`#discounted_value_${row}`).val(discounted_value);
  }
  
  else
  {

 

  if(discount_factor=='')
    discount_factor=0;

       if(discount_type=='flat')
       {
          discounted_value=( parseFloat(discount_factor)).toFixed(2);
       }
       else if(discount_type=='percentage')
       {
           discounted_value=( (discount_factor / 100 ) * tp ).toFixed(2);
       }
              
       $(`#discounted_value_${row}`).val(discounted_value);

         rate= ( tp - discounted_value ).toFixed(2) ;

       $(`#rate_${row}`).val(rate);

     }
}

  function setTotalAmount(row)
  {
    var total_qty=$(`#total_qty_${row}`).val();
    var rate=$(`#rate_${row}`).val();
      var total_amount='';

      if(rate=='')
        rate=0;

      total_amount = (rate * total_qty).toFixed(2) ;

      $(`#total_${row}`).val(total_amount);
  }

  function setTaxAmount(row)
  {
    var tax=$(`#tax_${row}`).val();
  
    var total_amount=$(`#total_${row}`).val();
      var tax_amount='';
      
      if(tax=='')
        tax=0;

      if(total_amount=='')
         total_amount=0;

      tax_amount = ( (tax / 100 ) * total_amount).toFixed(2) ;

      $(`#tax_amount_${row}`).val(tax_amount);
  }

  function setNetAmount(row)
  {
    
    var total_amount=$(`#total_${row}`).val();

      var tax_amount=$(`#tax_amount_${row}`).val();
      var net_amount=0;

      if(total_amount=='')
           total_amount=0;

         if(tax_amount=='')
           tax_amount=0;
      
      net_amount = parseFloat(total_amount)    + parseFloat(tax_amount)  ;

      net_amount = parseFloat(net_amount).toFixed(2) ;

      $(`#net_amount_${row}`).val(net_amount);
  }

  function setItemNet(row)
  {
       setTotalQty(row);
       setTp(row);
       setDiscountedAmount(row);
       setTotalAmount(row);
       setTaxAmount(row);
       setNetAmount(row);

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
  
   var net_total_qty=0, net_qty=0 , net_total=0, net_amount=0;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).val();
       var qty=$(`#qty_${i}`).val();
       var total=$(`#total_${i}`).val();
       var net=$(`#net_amount_${i}`).val();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;

      if(total=='' || total==null)
        total=0;

      if(net=='' || net==null)
        net=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;

         net_total +=  parseFloat (total);//alert(net_total);

        net_amount +=  parseFloat (net) ;
      }
         

   }  // alert(net_total);

   net_total =parseFloat (net_total).toFixed(2);
          net_amount =parseFloat (net_amount).toFixed(2);

   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
   $(`#net_total`).text(net_total);
   $(`#net_amount`).text(net_amount);

   
       // var disc=$(`#disc`).val();
       // var disc_type=$('input[name="net_disc"]:checked').val();
       // var disc_amount=0;

       // if(disc_type=='flat')
       // {
       //       disc_amount=disc;
       // }
       // else if(disc_type=='percentage')
       // {
       //     disc_amount= (disc / 100) * net_amount;
       // }

       //   var netbill=net_amount - disc_amount ;
       var netbill=net_amount  ;

         //netbill= netbill.toFixed(2);
           $(`#net_bill`).val( netbill ) ;

}

function setNetBill()
{
      var net_amount= $(`#net_amount`).text() ;
       // var disc=$(`#disc`).val();
       // var disc_type=$('input[name="net_disc"]:checked').val();
       // var disc_amount=0;

       // if(disc_type=='flat')
       // {
       //       disc_amount=disc;
       // }
       // else if(disc_type=='percentage')
       // {
       //     disc_amount= (disc / 100) * net_amount;
       // }

         //var netbill=net_amount - disc_amount ;
         var netbill=net_amount ;

         //netbill= netbill.toFixed(2);
           $(`#net_bill`).val( netbill ) ;
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
     var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
    var item_id='';
    if(item_combine!='')
    {     item_id=item_combine[11];
     }

     var tbl_item_id=$(`#item_id_${i}`).val(); 

     if(item_id == tbl_item_id)
      return true;
     
  
   }
  return false;   
   
}

function addItem()
{
  
   var item_id=$("#item_id_0").val();

   var item_name=$("#item_id_0 option:selected").text();//alert(item_name);alert(item_id);
   var batch_no=$("#batch_no_0").val();

    var items=<?php echo json_encode($inventories); ?> ;
      let point = items.findIndex((item) => item.id == item_id);
         var batches=items[point]['batches'];
          
       var bt_txt='<option value="">Select any value</option>';
       for (var i=0;  i < batches.length ;  i++) {
            s='';
            if(batch_no==batches[i]['batch_no'])
              s='selected';

      bt_txt += '<option value="'+batches[i]['batch_no']+'" '+s+' >'+batches[i]['batch_no']+'</option>';
       }
  
 
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total_qty=$("#total_qty_0").val();

  var mrp=$("#mrp_0").val();
  
  var expiry_date=$("#expiry_date_0").val();

var readonly='';
  if(unit=='loose')
     readonly='readonly';

  var tp=$("#tp_0").val();
  // var business_type=$("#business_type_0").val(); 
  // var discount_type=$("#discount_type_0").val(); 
  // var discount_factor=$("#discount_factor_0").val();
  // var discounted_value=$("#discounted_value_0").val();
  // var rate=$("#rate_0").val();
  // var total=$("#total_0").val();
  // var tax=$("#tax_0").val();
  // var tax_amount=$("#tax_amount_0").val();
  // var net_amount=$("#net_amount_0").val();

  // var percentage='', flat='';
  // if(discount_type=='percentage')
  //     percentage='selected';
  //    else if(discount_type=='flat')
  //     flat='selected';

  //   var tp_percent='', flat_rate='';
  // if(business_type=='tp_percent')
  //     tp_percent='selected';
  //    else if(business_type=='flat_rate')
  //     flat_rate='selected';
    
  //   var dbl_item=false;
  // if(item_name!='')
  // {
  //    //dbl_item=checkItem();
  // }

  // var is_item=false;

  // if(item_name!='')
  // {
  //    is_item=isItem(item_name);
  // }
     //alert(is_item);
     var stock=$("#stock_0").val();

     if(item_id=='' ||  unit=='' || qty=='' || parseFloat( total_qty)>parseFloat(stock))
     {
        var err_name='',err_location='',err_unit='',err_qty='', err_dbl='';
           
           if(item_id=='')
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

           if(parseFloat( total_qty)>parseFloat(stock))
           {
            err_dbl='Qty should be less than stock.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_dbl+' '+err_location+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"><input type="hidden" form="purchase_demand" id="{{'pivot_id_'.$row}}" name="pivot_ids[]" value="0"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}"  >

          
     

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" class="fx" id="item_uom_${row}"></td>

       <td>
      <select  form="purchase_demand" class="form-control fx" name="batch_no[]" id="batch_no_${row}" onchange="setBatchInfo(${row})"  >
      ${bt_txt}
         </select>
      </td>

       <td ondblclick="editItem(${row})" id="order_item_${row}"><input type="hidden" form="purchase_demand" id="order_item_id_${row}" class="fx" name="order_items_id[]" value="0"  ></td>

     <td><input type="text" value="${unit}" form="purchase_demand" class="form-control fx" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1"  form="purchase_demand" class="form-control fx" name="qtys[]" id="qty_${row}" onchange="qty_chk(${row}); setItemNet(${row});" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" class="form-control fx" name="p_s[]" id="p_s_${row}" onchange="qty_chk(${row}); setItemNet(${row});" readonly required="true"></td>
           
     <td><input type="number" step="any" name="total_qty[]" class="form-control fx" value="${total_qty}" max="${stock}"  form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" step="any" value="${stock}" class="form-control fx" form="purchase_demand" name="" id="stock_${row}"  readonly></td>

     <td><input type="date" value="${expiry_date}" class="form-control" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  ></td>


     <td><input type="number" value="${mrp}" step="any" class="form-control fx"  form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

     <td><input type="number" value="${tp}" step="any" class="form-control fx"  form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   $("#item_id_0").val('');
   $("#item_id_0").trigger('change');

  

  $("#unit_0").val('loose');
  $("#qty_0").val('1');
  $("#p_s_0").val('1');
  $("#total_qty_0").val('1');

  $("#mrp_0").val('');
  $("#batch_no_0").val('');
  $("#expiry_date_0").val('');
  $("#tp_0").val('');
  
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

function setSaleOrder()
{
    var customer_id=$('#customer_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/customer/new/orders") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     customer_id: customer_id,
                  

               },
               success:function(data) {

                var orders = data;
                  opt_txt=`<option value="">Select Sale Order</option>`;

                      for (var i =0; i < orders.length ;  i++) {
                            txt    = `<option value="${orders[i]['id']}">${orders[i]['doc_no']}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                      }

                      $('#order_id').empty().append(opt_txt);

               }
             });


}


function uploadSaleOrder()
{
  var order_id=$('#order_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/sale/order") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     order_id: order_id,
                  

               },
               success:function(data) {

                var items = data;
            
                  
                  $('#selectedItems').html('');

                      for (var i =0; i < items.length ;  i++) {

                        var row=getRowNum();

                        var item_id=items[i]['item_id'];
                        // var location=items[i]['location_id'];
                        // var location_text=items[i]['location_text'];
                        var item_name=items[i]['item_name'];
                        var order_item_id=items[i]['order_item_id'];
                        var order_qty=items[i]['order_qty'];
                        var stock_qty=items[i]['stock_qty'];
                        var unit=items[i]['unit'];
                        var qty=items[i]['qty'];
                        var p_s=items[i]['pack_size'];
                        var mrp=items[i]['mrp'];
                        var tp=items[i]['tp'];
                        // var business_type=items[i]['business_type'];
                         var batches=items[i]['batches'];
                         var batch_no=items[i]['batch_no'];
                         if(batch_no==null)
                             batch_no=''; 
                         var expiry_date=items[i]['exp_date']; 
                         var total_qty=items[i]['total_qty'];
                         // var discount_type=items[i]['discount_type'];
                         // var discount_factor=items[i]['discount_factor'];
                         // var discounted_value=items[i]['discounted_value'];
                         // var rate=items[i]['rate'];
                         // var total=items[i]['total'];
                         // var tax=items[i]['tax'];
                         // var tax_amount=items[i]['tax_amount'];
                         // var net_amount=items[i]['net_amount'];

                         var bt_txt='<option value="">Select any value</option>';
                         //alert(JSON.stringify( batches));
       for (var k=0;  k < batches.length ;  k++) {
            s='';
            if(batch_no==batches[k]['batch_no'])
              s='selected';

      bt_txt += '<option value="'+batches[k]['batch_no']+'" '+s+' >'+batches[k]['batch_no']+'</option>';
       }


                        var readonly='';
                        if(unit=='loose')
                          readonly='readonly';



                  //       var flat='',percentage='';
                  //       if(discount_type=='flat')
                  //         flat='selected';
                  //       else if(discount_type=='percentage')
                  //         percentage='selected';



                  //       var tp_percent='', flat_rate='';
                  //   if(business_type=='tp_percent')
                  //        tp_percent='selected';
                  // else if(business_type=='flat_rate')
                  //       flat_rate='selected';


                            
      var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" class="fx" id="item_uom_${row}"></td>

       

      <td>
      <select  form="purchase_demand" name="batch_no[]" id="batch_no_${row}" class="form-control fx" onchange="setBatchInfo(${row})"  >
      ${bt_txt}
         </select>
      </td>

      <td ondblclick="editItem(${row})" id="order_item_${row}"><input type="hidden" form="purchase_demand" id="order_item_id_${row}" class="fx" name="order_items_id[]" value="${order_item_id}"  >${order_qty}</td>

     <td><input type="text" value="${unit}" form="purchase_demand" class="form-control fx" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" class="form-control fx" onchange="qty_chk(${row}); setItemNet(${row});" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" class="form-control fx" onchange="qty_chk(${row}); setItemNet(${row});" readonly required="true"></td>
      
     
     <td><input type="number" value="${total_qty}" class="form-control fx" max="${stock_qty}"  form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" step="any" class="form-control fx" value="${stock_qty}" form="purchase_demand" name="" id="stock_${row}"  readonly></td>

     <td><input type="date" value="${expiry_date}" class="form-control" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  ></td>

     <td><input type="number" value="${mrp}" step="any" class="form-control fx"  form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

     <td><input type="number" value="${tp}" step="any" class="form-control fx"  form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

    
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

       $('#selectedItems').append(txt);
            setRowNum();      
                  
                      }

                   setNetQty();   
               }
             });
}





function setItems1()
{
  <?php

        
   ?>
     var items= `<?php echo json_encode($challan['items']); ?>`; 

       //var items= '<?php //echo str_replace( '\'','\'', json_encode($challan['items']) ); ?>'; 

       items= JSON.parse( items );

        //alert(items[0]['item_name']);

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
                        var tp=items[i]['tp'];
                         var batch_no=items[i]['batch_no']; 
                         var expiry_date=items[i]['expiry_date']; 
                         var total_qty=items[i]['total_qty'];
                         var discount_type=items[i]['discount_type'];
                         var discount_factor=items[i]['discount_factor'];
                         var discounted_value=items[i]['discounted_value'];
                         var rate=items[i]['rate'];
                         var total=items[i]['total'];
                         var tax=items[i]['tax'];
                         var tax_amount=items[i]['tax_amount'];
                         var net_amount=items[i]['net_amount'];

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
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="qty_chk(${row}); setItemNet(${row});" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="qty_chk(${row}); setItemNet(${row});" readonly required="true"></td>
     
      


      <td>
      <input list="batch_no_${row}_${row}" value="${batch_no}" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  onchange="setBatchInfo(${row})"  >
          <datalist id="batch_no_${row}_${row}">
    <option value="">
  </datalist>
      </td>

      <td><input type="date" value="${expiry_date}" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  ></td>
     
     <td><input type="number" value="${total_qty}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any" min="0" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

     <td><input type="number" value="${tp}" step="any" min="0" form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     <td><select form="purchase_demand" name="discount_type[]" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any" min="0" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any" min="0" form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${rate}" step="any" min="0" form="purchase_demand" name="rate[]" id="rate_${row}" onchange="rate_change(${row})" ></td>

     <td><input type="number" value="${total}" step="any" min="0" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>

     <td><input type="number" value="${tax}" step="any" min="0" form="purchase_demand" name="tax[]" id="tax_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${tax_amount}" step="any" min="0" form="purchase_demand" name="tax_amount[]" id="tax_amount_${row}" readonly  ></td>

     <td><input type="number" value="${net_amount}" step="any" min="0" form="purchase_demand" name="net_amount[]" id="net_amount_${row}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

       $('#selectedItems').append(txt);
            setRowNum();      
                  
                      }
setNetQty(); 
}

function setBatchInfo(row)
{
      var item_id=$(`#item_id_${row}`).val();

   var batch_no=$(`#batch_no_${row}`).val();

     var items=<?php echo json_encode($inventories); ?> ;

      let point = items.findIndex((item) => item.id == item_id);
         var batches=items[point]['batches']; 
              
              if(batches.length>0)
              {
        let point1 = batches.findIndex((item) => item.batch_no == batch_no);
         var batch=batches[point1];  
         
         if(batch['mrp']=='' || batch['mrp']==null) 
         $(`#mrp_${row}`).val(items[point]['mrp']);
         else    
          $(`#mrp_${row}`).val(batch['mrp']);
           $(`#expiry_date_${row}`).val(batch['exp_date']);
           $(`#stock_${row}`).val(batch['qty']);
            $(`#total_qty_${row}`).prop('max', batch['qty']);
         }
   
         setTp(row);
}


function setBatches(row)
{   

   $(`#mrp_${row}`).val('');
      $(`#expiry_date_${row}`).val('');
       $(`#batch_no_${row}`).val('');
      
      var item_id=$(`#item_id_${row}`).val();
      if(item_id=='')
        return ;
      
          var items=<?php echo json_encode($inventories); ?> ;
      let point = items.findIndex((item) => item.id == item_id);
         var batches=items[point]['batches'];
          //alert(items[point]['batches']);
            //alert(item_id);
            $(`#stock_${row}`).val(items[point]['qty']);
            $('#batch_no_0').empty().append('<option value="">Select any value</option>');
       //var txt='';
       for (var i=0;  i < batches.length ;  i++) {
           // txt += '<option value="'+batches[i]['batch_no']+'" />'; 
            $('<option value="'+batches[i]['batch_no']+'">'+batches[i]['batch_no']+'</option>').appendTo("#batch_no_0");
       }
       //   var my_list=document.getElementById("batch_no_0_0");
       // my_list.innerHTML = txt;

}

function setRate()
{
   var item_id=$(`#item_id_0`).val();
   var customer_id=$('#customer_id').val();

   if(item_id!='' && customer_id!='')
    {

       $.ajax({
               type:'get',
               url:'{{ url("get/rate/") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     item_id: item_id,
                     customer_id: customer_id,
                  

               },
               success:function(data) {


                 $(`#business_type_0`).val(data['business_type']);
                $('#discount_factor_0').val(data['discount_factor']);
                  $(`#rate_0`).val(data['rate']);
                 $('#discount_type_0').val(data['discount_type']);

               }
             });


     }//end if
    setBatches(0);
}

function qty_chk(row)
{
    var q=$(`#qty_${row}`).val();
    var p=$(`#p_s_${row}`).val();
    var s=$(`#stock_${row}`).val();
    var u=$(`#unit_${row}`).val();

    var t= parseFloat( p) * parseFloat( q);

    if(s < t)
    {
      if(u=='loose')
      {$(`#qty_${row}`).val(s); $(`#total_qty_${row}`).val(s); }
      else{
         r = ( parseFloat( s) / parseFloat( p) ).toFixed(0);
         $(`#qty_${row}`).val(r);

           var t= parseFloat(r) * parseFloat(p);     
         $(`#total_qty_${row}`).val(t);
      }
    }
}

</script>

@endsection  
