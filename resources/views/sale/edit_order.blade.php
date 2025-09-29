
@extends('layout.master')
@section('title', 'Edit New Order')
@section('header-css')


<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">



@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
    

              <div class="container-fluid px-3 py-3">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1><i class="fas fa-file-invoice mr-2"></i>Order</h1>
                </div>
                <div class="col-md-6">
                    <div class="action-buttons justify-content-md-end">


                        <button type="submit" form="purchase_demand" class="btn btn-success" >
                            <i class="fas fa-save"></i> Update
                        </button>
                        <button type="submit" form="delete_form"  class="btn btn-action">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <a href="{{url('order/create')}}" class="btn btn-action">
                            <i class="fas fa-plus"></i> New
                        </a>
                        <a href="{{url('order/history')}}" class="btn btn-action">
                            <i class="fas fa-history"></i> History
                        </a>

                          <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('/order/report/'.$order['id'])}}" class="dropdown-item">Print</a></li>
                      <!---<li><a href="{{url('/order/report1/'.$order['id'])}}" class="dropdown-item">Print1</a></li>
                      <li><a href="{{url('/order/form/'.$order['id'])}}" class="dropdown-item">Form</a></li>-->

                    </ul>
                  </div>

                    </div>
                </div>
            </div>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Sale</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Edit the Order</li>
                </ol>
            </nav>
        </div>
      </div>
  @endsection

@section('content')
    <!-- Main content -->


<form role="form" id="purchase_demand" method="POST" action="{{url('/order/update')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <input type="hidden" value="{{$order['id']}}" name="id"/>
    
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
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control" value="{{$order['doc_no']}}"  required style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>Order Date</label>
                  <input type="date" form="purchase_demand" name="order_date" class="form-control" value="{{$order['order_date']}}" required style="width: 100%;">
                  </div>

                   <div class="form-group">
                  <label>PO No.</label>
                  <input type="text" form="purchase_demand" name="po_no" class="form-control " value="{{$order['po_no']}}"   style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>PO Date</label>
                  <input type="date" form="purchase_demand" name="po_date" class="form-control" value="{{$order['po_date']}}"  style="width: 100%;">
                  </div>

                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="active" value="1" id="active" class="" >
                  <label>Active</label>
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
        <input class="form-control"  name="customer_id" id="customer_id" onchange="setQuotations()" required>
      
           </div>


              <div class="dropdown" id="customers_table_dispatch_dropdown">
        <label>Dispatch To</label>
        <input class="form-control"  name="dispatch_to_id" id="dispatch_to_id" >
      
           </div>
       
       <div class="dropdown" id="customers_table_invoice_dropdown">
        <label>Invoice To</label>
        <input class="form-control"  name="invoice_to_id" id="invoice_to_id" >
      
           </div>

           <div class="form-group">
                  <label>Quotation</label>
                  <select form="purchase_demand" name="quotation_id" id="quotation_id" class="form-control select2" onchange="uploadQuotation()">
                     <option value="">Select any quotation</option>
                     @foreach($quotations as $qt)
                     <option value="{{$qt['id']}}">{{$qt['doc_no']}}</option>
                     @endforeach
                  </select>
                  </div>
                    

                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control select2" >{{$order['remarks']}}</textarea>
                </div>

                


                     
                        </div>

                      
             

              </div>
              <!-- /.col -->

                            <!-- /.col -->

            </div>
            <!-- /.row -->

            

                           
                 <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-plus-circle mr-2"></i>Add Item</h4>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" onchange="setDepartmentItem()" form="add_item" name="location" id="location" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($locations as $depart)
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
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty_0" onchange="setTotalQty(0)" class="form-control select2" required="true" style="width: 100%;">
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
                  <input type="number" min="1" value="1" step="1"  form="add_item" name="p_s" id="p_s_0" value="1"  onchange="setTotalQty(0)" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty_0" class="form-control select2" readonly style="width: 100%;">
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

      
      <div class="table-responsive p-0" style="border-radius:8px ;">
      <table class="table table-hover table-head-fixed text-nowrap mb-0"  id="item_table" >
        <thead class="table-primary">
           <tr>
             <th></th>
             <th>Location</th>
             <th>Code</th>
             <th>Item</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">
          
          <?php $row=1; ?>

          @foreach($order['items'] as $item)

          <tr id="{{$row}}">
      <th ondblclick="editItem('{{$row}}')"></th>
     
     <input type="hidden" form="purchase_demand" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['id']}}" readonly >

     <input type="hidden" form="purchase_demand"  name="quotation_items_id[]" value="{{$item['pivot']['quotation_item_id']}}"  >

     <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="{{$item['pivot']['id']}}"  >

     <input type="hidden" form="purchase_demand" id="{{'location_id_'.$row}}"   name="location_ids[]" value="{{$item['department_id']}}" >
     
     
     <td ondblclick="editItem('{{$row}}')" id="{{'location_text_'.$row}}">{{$item['department']['name']}}</td>

     <td ondblclick="editItem('{{$row}}')" id="{{'code_'.$row}}"></td>

     <td ondblclick="editItem('{{$row}}')" id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>
       
       <td ondblclick="editItem('{{$row}}')" id="{{'item_uom_'.$row}}"></td>

     <td><input type="text" class="form-control" value="{{$item['pivot']['unit']}}" form="purchase_demand" name="units[]" id="{{'unit_'.$row}}" required="true"></td>

     <td><input type="number" class="form-control" value="{{$item['pivot']['qty']}}" min="1" form="purchase_demand" name="qtys[]" id="{{'qty_'.$row}}" onchange="setTotalQty('{{$row}}')" required="true"></td>

     <?php $readonly='';
           if($item['pivot']['unit']=='pack')
            $readonly='readonly';
      ?>

     <td><input type="number" class="form-control" value="{{$item['pivot']['pack_size']}}" min="1" form="purchase_demand" name="p_s[]" id="{{'p_s_'.$row}}" {{$readonly}} onchange="setTotalQty('{{$row}}')"  required="true"></td>
     

     <?php $total=$item['pivot']['qty'] * $item['pivot']['pack_size']; ?>
     <td><input type="number" class="form-control" value="{{$total}}" min="1" form="purchase_demand" id="{{'total_qty_'.$row}}" readonly ></td>
     

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
             <th></th>
             <th id="net_qty">0</th>
             <th></th>
             
             <th id="net_total_qty">0</th>
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

          <form role="form" id="delete_form" method="POST" action="{{url('/order/delete/'.$order['id'])}}">
               
               @csrf

            
            </form>
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>


<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

<script type="text/javascript">

var row_num="{{$row}}";


$(document).ready(function(){


  /*$("#item_table").colResizable({
     resizeMode:'overflow'
   });*/

  var qut="{{$order['quotation_id']}}";
     $('#quotation_id').val(qut);

  var active="{{$order['activeness']}}";
     if(active==1)
     $('#active').prop('checked',true);
   else if(active==0)
     $('#active').prop('checked',false);

      var customer_id="{{$order['customer']['id']}}";
      var customer_name="{{$order['customer']['name']}}";

      $('#customer_id').val(customer_id);
var s=$("#customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(customer_name);

 var dispatch_to_id="{{$order['dispatch_to_id']}}";

  
 @if($order['dispatch_to_id']!='')
 
   var customer_id="{{$order['dispatch_to']['id']}}";
      var customer_name="{{$order['dispatch_to']['name']}}";

      $('#dispatch_to_id').val(customer_id);
 
var s=$("#customers_table_dispatch_dropdown").find(".inputpicker-input");
   s.val(customer_name);

 @endif

 var invoice_to_id="{{$order['invoice_to_id']}}";

 @if($order['invoice_to_id']!='')

   var customer_id="{{$order['invoice_to']['id']}}";
      var customer_name="{{$order['invoice_to']['name']}}";

      $('#invoice_to_id').val(customer_id);
 
var s=$("#customers_table_invoice_dropdown").find(".inputpicker-input");
   s.val(customer_name);

 @endif

   setNetQty();




  $('#purchase_demand').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var rows=getRowNum();

for (var i =1; i <= rows ;  i++) {
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
   this.row_num++;
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

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit,id:
         items[i]['id']};
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

$('#dispatch_to_id').inputpicker({
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


$('#invoice_to_id').inputpicker({
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





       

 



function setPackSize(row)
{
  unit=$(`#unit_${row}`).val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s_${row}`).setAttribute('readonly', 'readonly');
  $(`#p_s_${row}`).val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById(`p_s_${row}`).removeAttribute('readonly');
}

function setTotalQty(row)
{
  qty=$(`#qty_${row}`).val();
  p_s=$(`#p_s_${row}`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $(`#total_qty_${row}`).val(total_qty); 
   
   if(row!=0)
   setNetQty();
}

function setNetQty() //for end of tabel to show net
{
  var rows=getRowNum();
  
   var net_total_qty=0, net_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).val();
       var qty=$(`#qty_${i}`).val();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;
      }
       

   }
   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
     

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
     var item_id=$("#item_code").val();

    

     var tbl_item_id=$(`#item_id_${i}`).val(); 

     if(item_id == tbl_item_id)
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
  var item_id=$("#item_code").val();
var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   var item_name=s.val(); //alert(item_name);alert(item_id);
  //alert(item_combine);

  //   item_combine=item_combine.split('_');
  
  //   if(item_combine!='')
  //   {
  //   var item_name=item_combine[3];
  //   var item_code=item_combine[1];
  //   var item_color=item_combine[9];
  //   var item_size=item_combine[7];
  //   var item_uom=item_combine[5];
  //   var item_id=item_combine[11];
  // }
  // else
  // {
  //   var item_name='';
  //   var item_code='';
  //   var item_color='';
  //   var item_size='';
  //   var item_uom='';
  //   var item_id='';
  // }

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
 
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total=$("#total_qty_0").val();

var readonly='';
  if(unit=='loose')
     readonly='readonly';
    
    var dbl_item=false;
  if(item_name!='')
  {
     //dbl_item=checkItem();
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
      
        
     var row=getRowNum();   


     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="0"  >

     <input type="hidden" form="purchase_demand"  name="quotation_items_id[]" value=""  >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" class="form-control" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true"></td>

     <td><input type="number" class="form-control" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setTotalQty(${row})" required="true"></td>

     <td><input type="number" class="form-control" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setTotalQty(${row})" ${readonly} required="true"></td>
     

     
     <td><input type="number" class="form-control" value="${total}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');


  $("#location").val('');
  $("#unit_0").val('loose');
  $("#qty_0").val('1');
  $("#p_s_0").val('1');
  $("#total_qty_0").val('1');

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
  var item_id=$("#item_code").val();
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   var item_name=s.val();

  //   item_combine=item_combine.split('_');
  
  //   if(item_combine!='')
  //   {
  //   var item_name=item_combine[3];
  //   var item_code=item_combine[1];
  //   var item_color=item_combine[9];
  //   var item_size=item_combine[7];
  //   var item_uom=item_combine[5];
  //   var item_id=item_combine[11];
  // }
  // else
  // {
  //   var item_name='';
  //   var item_code='';
  //   var item_color='';
  //   var item_size='';
  //   var item_uom='';
  //   var item_id='';
  // }

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total=$("#total_qty_0").val();

  var dbl_item=false;
  if(item_name!='')
  {
     //dbl_item=checkItem(row);
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
        
        $(`#unit_${row}`).val(unit);
        $(`#qty_${row}`).val(qty);
        $(`#p_s_${row}`).val(p_s);

      $(`#location_text_${row}`).text(location_text);
     //$(`#code_${row}`).text(item_code);
      
      $(`#item_name_${row}`).text(item_name);
      
      //$(`#color_${row}`).text(item_color);
      //$(`#size_${row}`).text(item_size);
      //$(`#item_uom_${row}`).text(item_uom);
      

       $(`#total_qty_${row}`).val(total_qty);
     
     
      if(p_s==null)
        p_s='';
     
   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');


  $("#location").val('');
  $("#unit_0").val('loose');
  $("#qty_0").val('1');
  $("#p_s_0").val('1');
  $("#total_qty_0").val('1');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');


  document.getElementById('p_s_0').setAttribute('readonly', 'readonly');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
   
   }
     
}  //end update item


function editItem(row)
{
   
   var item_name=$(`#item_name_${row}`).text();
   //var item_code=$(`#code_${row}`).text();
   var item_id=$(`#item_id_${row}`).val();
   //var item_color=$(`#color_${row}`).text();
   //var item_uom=$(`#item_uom_${row}`).text();
   //var item_size=$(`#size_${row}`).text();
   
   //combine='code_'+item_code+'_name_'+item_name+'_uom_'+item_uom+'_size_'+item_size+'_color_'+item_color+'_id_'+item_id;

   $('#item_code').val(item_id);
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(item_name);


var location_id=$(`#location_id_${row}`).val();
$('#location').val(location_id);


var unit=$(`#unit_${row}`).val();
$('#unit_0').val(unit);



  var qty=$(`#qty_${row}`).val();
$('#qty_0').val(qty);


  var p_s=$(`#p_s_${row}`).val();
  $('#p_s_0').val(p_s);
  


  var total_qty=$(`#total_qty_${row}`).val();
  $('#total_qty_0').val(total_qty);

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

  if(unit=='' || unit=='loose')
  {
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  $("#p_s_0").val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('p_s_0').removeAttribute('readonly');

}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
    $(`#${row}`).remove();
      setNetQty();
});

}


function setQuotations()
{
    var customer_id=$('#customer_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/customer/new/quotations") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     customer_id: customer_id,
                  

               },
               success:function(data) {

                var orders = data;
                  opt_txt=`<option value="">Select any quotation</option>`;

                      for (var i =0; i < orders.length ;  i++) {
                            txt    = `<option value="${orders[i]['id']}">${orders[i]['doc_no']}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                      }

                      $('#quotation_id').empty().append(opt_txt);

               }
             });


}


function uploadQuotation()
{
  var quotation_id=$('#quotation_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/quotation") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     quotation_id: quotation_id,
                  

               },
               success:function(data) {
                  
                  var quotation=data;
                var items = quotation['item_list'];
            
                  //alert(JSON.stringify( quotation) );
                  $('#selectedItems').html('');

                      for (var i =0; i < items.length ;  i++) {

                        var row=getRowNum();

                      

                         var item_id=items[i]['item_id'];

                         var item_name=items[i]['item']['item_name'];
                           var unit=items[i]['unit'];
                              var qty=items[i]['qty'];
                              var p_s=items[i]['pack_size'];
                              var quotation_item_id=items[i]['id'];
      var location='';
     var location_text='';
  
                            
                           var total=qty * p_s;

                              var readonly='';
                             if(unit=='loose')
                              readonly='readonly';
                        

                            
      var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <input type="hidden" form="purchase_demand"  name="quotation_items_id[]" value="${quotation_item_id}"  >
     <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="0"  >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true"></td>

     <td><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setTotalQty(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setTotalQty(${row})" ${readonly} required="true"></td>
     

     
     <td><input type="number" value="${total}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

       $('#selectedItems').append(txt);
            setRowNum();      
                  
                      }

                   setNetQty();   
               }
             });
}





</script>

@endsection  
  