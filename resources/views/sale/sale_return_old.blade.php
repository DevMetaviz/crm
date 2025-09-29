
@extends('layout.master')
@section('title', 'Sale Return')
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
    <!-- Content Header (Page header) -->
    <form role="form" id="purchase_demand" method="POST" action="{{url('/sale/return/save')}}" onkeydown="return event.key != 'Enter';" >
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Sale Return</h1>
            <button form="purchase_demand" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('sale/return')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('sale/return/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Return</li>
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

             
                       @if ($errors->has('error'))
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                                          </div>  
                                @endif
     
      <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>


            <div class="row">
              <div class="col-md-3">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Document</legend>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Doc No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control select2" value="{{$doc_no}}" readonly required style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>Doc Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control select2" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>

                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="active" value="1" id="activeness" class=""  checked>
                  <label>Active</label>
                  </div>



              </fieldset>

                                
                <!-- /.form-group -->
               
                
              </div>
              <!-- /.col -->
              <div class="col-md-5">

                 <fieldset class="border p-4">
                   <legend class="w-auto">Customer</legend>

                  

                  <div class="dropdown" id="customers_table_customer_dropdown">
        <label>Customer</label>
        <input class="form-control"  name="customer_id" id="customer_id" onchange="uploadInvoices()" required>
      
           </div>

           <div class="form-group">
                  <label>Products</label>
                  <select form="purchase_demand" name="product_id" id="product_id" class="form-control select2" onchange="uploadInvoices()">
                     <option value="">Select any product</option>
                     @foreach($products as $pr)
                     <option value="{{$pr['id']}}">{{$pr['item_name']}}</option>
                     @endforeach
                  </select>
                  </div>

               <div class="form-group">
                  <label>Sale Invoice</label>
                  <select form="purchase_demand" name="invoice_id" id="invoice_id" class="form-control select2" onchange="uploadSale()">
                     <option value="">Select any value</option>
                     
                  </select>
                  </div>


                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control select2" ></textarea>
                </div>

                


                     
                        </fieldset>

                      
             

              </div>
              <!-- /.col -->

              <div class="col-md-3">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Net Total</legend>

                <!-- /.form-group -->
                <!-- <div class="form-group">
                  <label>Disc.</label>
                  <input type="number" step="any" min="0" form="purchase_demand" name="disc" id="disc" class="form-control select2" value="" onchange="setNetBill()" style="width: 100%;">
                  </div> -->

                  <!-- <div class="form-group">
                  <input type="radio" form="purchase_demand" name="net_disc" value="flat" id="flat" class="" onchange="setNetBill()"  checked>
                  <label for="flat">Flat</label>
                  <input type="radio" form="purchase_demand" name="net_disc" value="percentage" id="percentage" onchange="setNetBill()" class=""  >
                  <label for="percentage">Percentage</label>
                  </div>
 -->

                <div class="form-group">
                  <label>Net Total</label>
                  <input type="number" form="purchase_demand" name="net_bill" id="net_bill" class="form-control select2" value="" readonly  style="width: 100%;">
                  </div>

                


              </fieldset>

                                
                <!-- /.form-group -->
               
                
              </div>

                            <!-- /.col -->

            </div>
            <!-- /.row -->

            

            <div class="row">
              <div class="col-md-12">
                
                <fieldset class="border p-4">
                   <legend class="w-auto">Add Item</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" onchange="setDepartmentItem()" form="add_item" name="location" id="location" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                  <div class="col-md-4">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code">
      
           </div>
           </div>

           

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control select2" form="add_item" name="unit" id="unit_0" required="true" onchange="setPackSize(0)" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty_0" onchange="setItemNet(0)" class="form-control select2" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number"  form="add_item" name="stock" id="stock"  class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1" value="1" step="1"  form="add_item" name="p_s" id="p_s_0" value="1"  onchange="setItemNet(0)" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>


             <div class="col-md-2">
                    <div class="form-group">
                  <label>MRP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="mrp" id="mrp_0" onchange="setItemNet(0)" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>TP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="tp" id="tp_0" onchange="setItemNet(0)" readonly class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Business Type</label>
                  <select class="form-control select2" form="add_item" name="business_type" id="business_type_0" required="true" onchange="" style="width: 100%;">
                     <option value="">Select any value</option>
                    <option value="tp_percent" selected>Percentage on TP</option>
                    <option value="flat_rate">Flat Rate</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discount Type</label>
                  <select class="form-control select2" form="add_item" name="discount_type" id="discount_type_0" required="true" onchange="setItemNet(0)" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="percentage" selected>Percentage</option>
                    <option value="flat">Flat</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discount Factor</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="discount_factor" id="discount_factor_0" onchange="setItemNet(0)" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discounted Value</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="discounted_value" id="discounted_value_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Rate</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="rate" id="rate_0" onchange="rate_change(0)" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total</label>
                  <input type="number" value="" min="0" step="any" onchange="setTotalAmount(0)" form="add_item" name="total" id="total_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Tax %</label>
                  <input type="number" min="0" step="any" form="add_item" name="tax" id="tax_0" class="form-control select2" onchange="setItemNet(0)"  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Tax Amount</label>
                  <input type="number" min="0" step="any" form="add_item" name="tax_amount" id="tax_amount_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Net Amount</label>
                  <input type="number"  min="0" step="any" form="add_item" name="net_amount" id="net_amount_0" class="form-control select2" readonly style="width: 100%;">
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



<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Items</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="item_table" >
        <thead class="table-secondary">
           <tr>

             <th>#</th>
             <th>Invoice No</th>
             <th>Location</th>
             <th>Code</th>
             <th>Item</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Batch #</th>
             <th>Expiry date</th>
             <th>Total Qty</th>
              <th>MRP</th>
              <th>TP</th>
              <th>Business Type</th>
              <th>Discount Type</th>
             <th>Discount Factor</th>
             <th>Discounted Value</th>
             <th>Rate</th>
             <th>Total</th>
             <th>Tax %</th>
             <th>Tax Amount</th>
              <th>Net Amount</th>

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
             <th></th>
             <th id="net_total"></th>
             <th></th>
             <th></th>
             <th id="net_amount"></th>
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

         net_total +=  parseFloat (total) ;

        net_amount +=  parseFloat (net) ;
      }
       

   }
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

         //var netbill=net_amount - disc_amount ;

         var netbill=net_amount  ;

         netbill= netbill.toFixed(2);
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

       //   var netbill=net_amount - disc_amount ;

       var netbill=net_amount  ;

         netbill= netbill.toFixed(2);
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
  
   var item_id=$("#item_code").val();
var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   var item_name=s.val(); //alert(item_name);alert(item_id);
  

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
 
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

  var tp=$("#tp_0").val();
  var business_type=$("#business_type_0").val();
  var discount_type=$("#discount_type_0").val(); 
  var discount_factor=$("#discount_factor_0").val();
  var discounted_value=$("#discounted_value_0").val();
  var rate=$("#rate_0").val();
  var total=$("#total_0").val();
  var tax=$("#tax_0").val();
  var tax_amount=$("#tax_amount_0").val();
  var net_amount=$("#net_amount_0").val();

  var percentage='', flat='';
  if(discount_type=='percentage')
      percentage='selected';
     else if(discount_type=='flat')
      flat='selected';

    var tp_percent='', flat_rate='';
  if(business_type=='tp_percent')
      tp_percent='selected';
     else if(business_type=='flat_rate')
      flat_rate='selected';
    
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
        var err_name='',err_unit='',err_qty='', err_dbl='';
           
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
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
      <input type="hidden" form="purchase_demand" id="stock_id_${row}" name="stocks_id[]" value="" readonly >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     <td ondblclick="editItem(${row})" id="invoice_no_${row}"></td>
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

     <td><input type="number" value="${mrp}" step="any"  form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  required="true"></td>

     <td><input type="number" value="${tp}" step="any"  form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     <td><select form="purchase_demand" name="business_type[]" id="business_type_${row}" onchange="setItemNet(${row})">
     <option value="" >Select any value</option>
      <option value="tp_percent" ${tp_percent}>Percentage on TP</option>
      <option value="flat_rate" ${flat_rate}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="discount_type[]" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any"  form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${rate}" step="any"  form="purchase_demand" name="rate[]" id="rate_${row}" onchange="rate_change(${row})" ></td>

     <td><input type="number" value="${total}" step="any" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>

     <td><input type="number" value="${tax}" step="any"  form="purchase_demand" name="tax[]" id="tax_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${tax_amount}" step="any"  form="purchase_demand" name="tax_amount[]" id="tax_amount_${row}" readonly  ></td>

     <td><input type="number" value="${net_amount}" step="any" min="0" form="purchase_demand" name="net_amount[]" id="net_amount_${row}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');


  //$("#location").val('');
  $("#unit_0").val('loose');
  $("#qty_0").val('1');
  $("#p_s_0").val('1');
  $("#total_qty_0").val('1');

  $("#mrp_0").val('');
  $("#batch_no_0").val('');
  $("#expiry_date_0").val('');
  $("#tp_0").val('');
  $("#discount_factor_0").val('');
  $("#discounted_value_0").val('');
  $("#rate_0").val('');
  $("#total_0").val('');
  $("#tax_0").val('');
  $("#tax_amount_0").val('');
  $("#net_amount_0").val('');

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



function uploadInvoices()
{
  var product_id=$('#product_id').val();
   var customer_id=$('#customer_id').val();

   if(product_id=='' || customer_id=='')
     {  return; }


  $.ajax({
               type:'get',
               url:'{{ url("get/customer/product/invoices") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     product_id : product_id ,
                     customer_id : customer_id ,

               },
               success:function(data) {

                var items = data;
//alert(JSON.stringify(items));
                  opt_txt=`<option value="">invoice~item~qty~batch_no~rate</option>`;

                      for (var i =0; i < items.length ;  i++) {
                        
                        var invoice=items[i]['sale']['invoice_no'];
                        var item=items[i]['item']['item_name'];
                        var item_id=items[i]['id'];
                        var location=items[i]['item']['department']['name'];
                        var item_code=items[i]['item']['item_code'];
                        var mrp=items[i]['mrp'];
                        var tp=(0.85 * mrp).toFixed(2);
                        var batch=items[i]['batch_no']; 
                        var qty=items[i]['qty'] * items[i]['pack_size'];
                        var rate=items[i]['rate'];

                            txt   = `<option value="${items[i]['id']}">${invoice}~${item}~${qty}~${batch}~${rate}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                      }

                      $('#invoice_id').empty().append(opt_txt);

              }

            });




}

function uploadSale()
{
  var invoice_id=$('#invoice_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/invoice/item") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     sale_stock_id: invoice_id,
                  

               },
               success:function(data) {

                var items = data;


                    

                        var row=getRowNum();

                         var stock_id=items['id'];
                         var invoice_no=items['sale']['invoice_no'];
                        var item_id=items['item']['id'];
                        var location=items['item']['department_id'];
                        var location_text=items['item']['department']['name'];
                        var item_name=items['item']['item_name'];
                        var unit=items['unit'];
                        var qty=items['qty'];
                        var p_s=items['pack_size'];
                        var mrp=items['mrp'];
                        var tp=(0.85 * mrp).toFixed(2);
                         var batch_no=items['batch_no']; 
                         if(batch_no=='null')
                          batch_no='';
                         var expiry_date=items['expiry_date']; 
                         var total_qty=qty * p_s;
                         var business_type=items['business_type'];
                         var discount_type=items['discount_type'];
                         var discount_factor=items['discount_factor'];
                         var discounted_value=items['discounted_value'];

                         
                           if(discount_type=='flat')
                               discounted_value= discount_factor;
                            else if(discount_type=='percentage')
                              discounted_value= (discount_factor / 100) * tp;

                            var rate= (tp - discounted_value).toFixed(2);

                         var total=(rate * total_qty ).toFixed(2);
                         var tax=items['tax'];
                         var tax_amount=( (tax / 100) * rate ).toFixed(2);
                         var t_rate=parseFloat( rate ) + parseFloat( tax_amount ) ;  
                         var net_amount= t_rate * total_qty ;
                          net_amount= net_amount.toFixed(2);


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
     <input type="hidden" form="purchase_demand" id="stock_id_${row}" name="stocks_id[]" value="${stock_id}" readonly >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
      <td ondblclick="editItem(${row})" id="invoice_no_${row}">${invoice_no}</td>
     
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

     <td><input type="number" value="${mrp}" step="any"  form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  ></td>

     <td><input type="number" value="${tp}" step="any"  form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     <td><select form="purchase_demand" name="business_type[]" id="business_type_${row}" onchange="setItemNet(${row})">
     <option value="" >Select any value</option>
      <option value="tp_percent" ${tp_percent}>Percentage on TP</option>
      <option value="flat_rate" ${flat_rate}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="discount_type[]" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any"  form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any"  form="purchase_demand" name="discounted_value[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${rate}" step="any" min="0" form="purchase_demand" name="rate[]" id="rate_${row}" onchange="rate_change(${row})" ></td>

     <td><input type="number" value="${total}" step="any"  form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>

     <td><input type="number" value="${tax}" step="any"  form="purchase_demand" name="tax[]" id="tax_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${tax_amount}" step="any"  form="purchase_demand" name="tax_amount[]" id="tax_amount_${row}" readonly  ></td>

     <td><input type="number" value="${net_amount}" step="any" form="purchase_demand" name="net_amount[]" id="net_amount_${row}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

       $('#selectedItems').append(txt);
            setRowNum();      
                  
                      

                   setNetQty();   
               }
             });
}





</script>

@endsection  
  