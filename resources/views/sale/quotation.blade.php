
@extends('layout.master')
@section('title', 'Add Quotation')
@section('header-css')

<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">

@endsection


@section('content-header')
    <!-- Content Header (Page header) -->

        <div class="row default-header"   >
          <div class="col-sm-6">
            <h1 style="display: inline;">Quotation</h1>
                     </div>
          <div class="col-sm-6 text-right">

             <button form="purchase_demand" type="submit" class="btn btn-primary"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" class="btn btn-transparent" ><span class="fas fa-redo">&nbsp</span>Clear</button>
            <a class="btn btn-transparent" href="{{url('quotation/create')}}" ><span class="fas fa-plus">&nbsp</span>New</a>
            <a class="btn btn-transparent" href="{{url('quotation/history')}}" ><span class="fas fa-history">&nbsp</span>History</a>

            
          </div>
        </div>

           <ol class="breadcrumb default-breadcrumb"  >
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Quotation</li>
            </ol>


      
  @endsection

@section('content')
    <!-- Main content -->
<form role="form" id="purchase_demand" method="POST" action="{{url('/quotation/save')}}" onkeydown="return event.key != 'Enter';" >

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
              <div class="col-md-3">
                  
                  <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-file-alt mr-2"></i>Document</h4>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Doc No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" id="doc_no" class="form-control " value="{{$doc_no}}"  required style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>Doc Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>

                   <div class="form-group">
                  <label>Type</label>
                  <select form="purchase_demand" name="type" id="type" class="form-control" onchange="setDocNo()">
                     <option value="local" selected>Local</option>
                     <option value="export">Export</option>
                  </select>
                  </div>


                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="active" value="1" id="activeness" class=""  checked>
                  <label>Active</label>
                  </div>

                  <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="approved" value="1" id="approved" class=""  >
                  <label>Approved</label>
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
        <input class="form-control"  name="customer_id" id="customer_id"  required>
      
           </div>

           <!-- <div class="form-group">
                  <label>Sale Order</label>
                  <select form="purchase_demand" name="order_id" id="order_id" class="form-control select2" onchange="uploadSaleOrder()">
                     <option value="">Select sale order</option>
                  </select>
                  </div> -->


                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control " ></textarea>
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
                      {$s='selected'; $default_cur_id=$cur['id'];}
                     ?>
                    <option value="{{$cur['id']}}" {{$s}} >{{$cur['symbol'].'~'.$cur['text']}}</option>
                    @endforeach
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Rate</label>
                  <input type="number" step="any" form="purchase_demand" name="cur_rate" id="cur_rate" class="form-control" value="1" readonly required>
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
                  <input type="number" step="any" min="0" form="purchase_demand" name="disc" id="disc" class="form-control" value="" onchange="setNetTaxAndExpense()" style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <input type="radio" form="purchase_demand" name="net_disc" value="flat" id="flat" class="" onchange="setNetTaxAndExpense()"  checked>
                  <label for="flat">Flat</label>
                  <input type="radio" form="purchase_demand" name="net_disc" value="percentage" id="percentage" onchange="setNetTaxAndExpense()" class=""  >
                  <label for="percentage">Percentage</label>
                  </div>
                  
                  <div class="row">
                  
                  

                  <div class="col-sm-6">
                    <div class="form-group">
                  <label>GST %</label>
                  <input type="number" step="any" name="gst" id="gst" class="form-control" value="" onchange="setNetTaxAndExpense()" style="width: 100%;">
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
                  <select class="form-control select2" onchange="setRate(0)" form="add_item" name="item_id_0" id="item_id_0">
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
                  <input type="number"  form="add_item" name="stock" id="stock"  class="form-control " readonly style="width: 100%;">
                </div>
              </div> -->

             

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <select class="form-control" form="add_item" name="p_s" id="p_s_0" required="true" onchange="setItemNet(0)" readonly  style="width: 100%;">
                  
                    <option value="1" selected>1</option>
              
                  </select>
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
                  <label>Exp Date</label>
                  <input type="date"  form="add_item" name="exp_date" id="exp_date_0" class="form-control"   style="width: 100%;">
                </div>
              </div>


             <div class="col-md-2">
                    <div class="form-group">
                  <label>MRP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="mrp" id="mrp_0" class="form-control" style="width: 100%;">
                </div>
              </div>

              <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>TP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="tp" id="tp_0" onchange="setItemNet(0)" readonly class="form-control" style="width: 100%;">
                </div>
              </div>
 -->
               <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>Business Type</label>
                  <select class="form-control" form="add_item" name="business_type" id="business_type_0" required="true" onchange="" style="width: 100%;">
                     <option value="">Select any value</option>
                    <option value="tp_percent" selected>Percentage on TP</option>
                    <option value="flat_rate">Flat Rate</option>
                  </select>
                </div>
              </div> -->
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
                  <input type="number" value="" min="0" step="any" form="add_item" name="discounted_rate" id="discounted_rate_0" readonly class="form-control"  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total</label>
                  <input type="number" value="" min="0" step="any" onchange="setTotalAmount(0)" form="add_item" name="total" id="total_0" class="form-control" readonly style="width: 100%;">
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



                 </div>
                 
            



<!-- Start Tabs -->
<div class="form-section mb-4 p-3">

<div class="nav-tabs-wrapper mb-3">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA"><i class="fas fa-list mr-2"></i>Items</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB"><i class="fas fa-dollar-sign mr-2"></i>Expenses</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC"><i class="fas fa-cog mr-2"></i>Others</a></li>

    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive p-0" style="">
      <table class="table table-hover table-head-fixed text-nowrap"  id="item_table" >
        <thead class="table-primary">
           <tr>

             <th>#</th>
           
             <th style="min-width:250px;">Item</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <th>Exp Date</th>
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
             <th  id="net_qty">0</th>
             <th></th>
             <th id="net_total_qty">0</th>
             
             <th ></th>
             <th></th>
             <th></th>
             <th></th>
             
             <th></th>
             <th></th>
             <th></th>
             <th id="net_total">0</th>
             
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

        
    </div>
   
    <div class="tab-pane fade" id="tabB">

      <div class="row">
              <div class="col-md-7">
               
                   <div class="form-section-in border p-3 mb-3" >
                   <h4 class="form-section-title">Add Expenses</h4>

              
    
   <div id="expense_add_error" style="display: none;"><p class="text-danger" id="expense_add_error_txt"></p></div>
      
                   
                     <div class="row">

                      <div class="col-md-5">
                      <div class="form-group mb-0">
                    <label>Expenses</label>
                    <select class="form-control select2" form="add_expense" name="expense" id="expense" style="width: 100%;">
                      <option value="">Select any value</option>
                      @foreach($expenses as $depart)
                      <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                      @endforeach
                    </select>
                    </div>
                    </div>





                    <div class="col-md-1 bt-col">
                      <div class="form-group mb-0">
                      
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


                  </table>



                  <!----<div class="" id="expenses_body">

                  
                <div class="row p-1 m-0 bg-primary">
                <div class="col-sm-3">Expenses</div>
                <div class="col-sm-4">Amount</div>
                </div>
                                  
                  


                  </div>-->

                
               
                
                
              </div>
              
        </div>
      
    </div>
    <!-- End TabB -->

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
   
@endsection

@section('jquery-code')


<script type="text/javascript">

var row_num=1;
var products=[];
var expense_row_num=1;

function getExpenseRowNum()
 {
  return this.expense_row_num;
}

function setExpenseRowNum()
 {
     this.expense_row_num++;
}


$(document).ready(function(){

$('.select2').select2(); 


  /*$("#item_table").colResizable({
     resizeMode:'overflow'
   });*/

  

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

function getProducts()
 {
  return this.products;
}
function setProducts(products)
 {
    this.products=products;
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









function setTp(row) //not using
{  
  var mrp=$(`#mrp_${row}`).val();

  var tp= (mrp * 0.85 ).toFixed(2) ;

  $(`#tp_${row}`).val(tp);
}

function rate_change(row) //not using
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
  //var tp=$(`#tp_${row}`).val();
  //var bt=$(`#business_type_${row}`).val();
  var discount_type=$(`#discount_type_${row}`).val();
  var discount_factor=$(`#discount_factor_${row}`).val();
  var discounted_value='';
  var rate=$(`#rate_${row}`).val();

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

         d_rate= ( rate - discounted_value ).toFixed(2) ;

       $(`#discounted_rate_${row}`).val(d_rate);

     
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

  
  function setNetTaxAndExpense()
{
 
     var net_amount=$(`#net_total`).text();
      if(net_amount=='')
       net_amount=0;

     //disc

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

   // GST tax
   var gst=$('#gst').val();
   if(gst=='')
    gst=0;

   
     var gst_amount=(gst / 100) * net_amount;
       gst_amount=gst_amount.toFixed(2);

     $(`#gst_amount`).val(gst_amount);

     

   
      net=parseFloat(net_amount) + parseFloat(gst_amount) - parseFloat(disc_amount)  ;
     $(`#net_bill`).val(net); 

     //expense
        var row=getExpenseRowNum();
     
  for (var i = 1; i <= row; i++) {
      if($(`#exp_amount_${i}`). length == 0 || $(`#exp_amount_${i}`). length < 0)
      continue;
        var debit=$(`#exp_amount_${i}`).val();  
        net= parseFloat(net) + parseFloat(debit); 
  }

  
          net=net.toFixed(2);
  $(`#net_bill`).val(net);

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
       //setTp(row);
       setDiscountedAmount(row);
       setTotalAmount(row);
          

          setNetQty();
          
  }      

 $(`#item_id_0`).on('change',function(){
setPackSize(0);

 });



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

     id=$('#item_id_0').val();
      if(id=='')
        return ;

     var products=<?php echo json_encode($inventories); ?>  ; 
      let point = products.findIndex((item) => item.id == id);
              var packs=products[point]['packings'];

              var txt='<option value="1">1</option>';
       for (var i=0;  i < packs.length ;  i++) {
            
            txt +=`<option value="${packs[i]}">${packs[i]}</option>`;
       }
         
           $('#p_s_0').empty().append(txt);
           setTotalQty(row);
            
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
   
         var netbill=net_total  ;

           $(`#net_bill`).val( net_total ) ;

           setNetTaxAndExpense();

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

   var item_name=$("#item_id_0 option:selected").text(); //alert(item_name);alert(item_id);
  

  var exp=$("#exp_date_0").val();
  
  
 
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total_qty=$("#total_qty_0").val();

  var mrp=$("#mrp_0").val();
  
var readonly='';
  if(unit=='loose')
     readonly='readonly';

  //var tp=$("#tp_0").val();
  //var business_type=$("#business_type_0").val(); 
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

  //   var tp_percent='', flat_rate='';
  // if(business_type=='tp_percent')
  //     tp_percent='selected';
  //    else if(business_type=='flat_rate')
  //     flat_rate='selected';
    
    var dbl_item=false;
  if(item_name!='')
  {
    // dbl_item=checkItem();
  }

  // var is_item=false;

  // if(item_name!='')
  // {
  //    is_item=isItem(item_name);
  // }
     //alert(is_item);
     if(item_name==''  || unit=='' || qty=='' || dbl_item==true)
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
/*
     <td><input type="number" value="${tp}" step="any" min="0" form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     <td><select form="purchase_demand" name="business_type[]" id="business_type_${row}" onchange="setItemNet(${row})">
     <option value="" >Select any value</option>
      <option value="tp_percent" ${tp_percent}>Percentage on TP</option>
      <option value="flat_rate" ${flat_rate}>Flat Rate</option>
     </select></td>*/

     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <td ondblclick="editItem(${row})"><input type="text" class="form-control"  value="${item_name}" form="purchase_demand" id="item_name_${row}" readonly ></td>
       
       <td ondblclick="editItem(${row})" ><input type="text" class="form-control"  value=""  form="purchase_demand" id="item_uom_${row}" readonly ></td>

     <td><input type="text" class="form-control" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" class="form-control" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" class="form-control" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      
     
     <td><input type="number" class="form-control"  value="${total_qty}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="date" class="form-control"  name="exp_dates[]" value="${exp}"  form="purchase_demand" id="exp_date_${row}" readonly ></td>


     <td><input type="number" class="form-control"  value="${mrp}" step="any" min="0" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

       <td><input type="number" class="form-control"  value="${rate}" step="any" min="0" form="purchase_demand" name="rate[]" id="rate_${row}"  onchange="setItemNet(${row})" ></td>

     <td><select form="purchase_demand" class="form-control"  name="discount_type[]" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" class="form-control"  value="${discount_factor}" step="any"  form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" class="form-control"  value="${discounted_value}" step="any"  form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" class="form-control"  value="${discounted_rate}" step="any" min="0" form="purchase_demand" name="discounted_rate[]" id="discounted_rate_${row}"  readonly ></td>

     <td><input type="number" class="form-control"  value="${total}" step="any" min="0" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>


         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   $("#item_id_0").val('');
   $("#item_id_0").trigger('change');
   


  //$("#location").val('');
  $("#unit_0").val('loose');
  $("#qty_0").val('1');
  $("#p_s_0").val('1');
  $("#total_qty_0").val('1');
$("#exp_date_0").val('');
  $("#mrp_0").val('');
    $("#tp_0").val('');
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
                        var location=items[i]['location_id'];
                        var location_text=items[i]['location_text'];
                        var item_name=items[i]['item_name'];
                        var unit=items[i]['unit'];
                        var qty=items[i]['qty'];
                        var p_s=items[i]['pack_size'];
                        var mrp=items[i]['mrp'];
                        var tp=items[i]['tp'];
                        var business_type=items[i]['business_type'];
                         var batch_no=items[i]['batch_no'];
                         if(batch_no==null)
                             batch_no=''; 
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


                        var readonly='';
                        if(unit=='loose')
                          readonly='readonly';



                        var flat='',percentage='';
                        if(discount_type=='flat')
                          flat='selected';
                        else if(discount_type=='percentage')
                          percentage='selected';



                        var tp_percent='', flat_rate='';
                    if(business_type=='tp_percent')
                         tp_percent='selected';
                  else if(business_type=='flat_rate')
                        flat_rate='selected';


                            
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

     <td><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      <td><input type="text" value="${batch_no}" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  ></td>

      <td><input type="date" value="${expiry_date}" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  ></td>
     
     <td><input type="number" value="${total_qty}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any" min="0" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

     <td><input type="number" value="${tp}" step="any" min="0" form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     <td><select form="purchase_demand" name="business_type[]" id="business_type_${row}" onchange="setItemNet(${row})">
     <option value="" >Select any value</option>
      <option value="tp_percent" ${tp_percent}>Percentage on TP</option>
      <option value="flat_rate" ${flat_rate}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="discount_type[]" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any" min="0" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any" min="0" form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${rate}" step="any" min="0" form="purchase_demand" name="rate[]" id="rate_${row}" onchange="rate_change(${row})"  ></td>

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
             });
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
                 //$(`#business_type_0`).val(data['business_type']);
                //$('#discount_factor_0').val(data['discount_factor']);
                  $(`#rate_0`).val(data);
                    setItemNet(0);
                 //$('#discount_type_0').val(data['discount_type']);
               }
             });
     
     }//end if
    
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


           /* var txt=`
             <div class="col-sm-12" id="exp_${rows}">
                <div class="form-group row">
                  <label class="col-sm-3">${expense_text}</label>
                  <input type="hidden" name="expense_ids[]" form="purchase_demand" id="exp_id_${rows}" value="${expense}" >
                  <input type="number" step="any" value="0" name="exp_amount[]" class="form-control col-sm-3 m-1" form="purchase_demand" id="exp_amount_${rows}"   onchange="setNetTaxAndExpense()" style="width: 100%;">
                  
                    <button type="button" class="btn" onclick="removeExpense(${rows})"><span class="fa fa-minus-circle text-danger"></span></button>
                  </div>
                 </div>
            `;*/


            var txt=`
             <tr class="" id="exp_${rows}">
               
                  <td class="">${expense_text}</td>

                   <td class="">
                  <input type="hidden" name="expense_ids[]" form="purchase_demand" id="exp_id_${rows}" value="${expense}" >
                  <input type="number" step="any" value="0" name="exp_amount[]" class="form-control col-sm-3 m-1" form="purchase_demand" id="exp_amount_${rows}"   onchange="setNetTaxAndExpense()" style="width: 100%;">
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
    setNetQty();
    //setNetQtyAndAmount();
  

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

 $.ajax({
               type:'post',
               url:'{{ url("/get/quotation/code") }}',
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
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>


<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>
@endsection  
