
@extends('layout.master')
@section('title', 'Edit Stock Adjustment')
@section('header-css')
<style type="text/css">
  .alert-success {
     color: #155724; 
    background-color: #d4edda;
    /*border-color: #c3e6cb;*/
}
#selectedItems td input{
  border: none;
}

td > input[type='text']
{
    /*width: auto;
    height: auto;
    max-width: 40px;
    border: none;
    margin: 0px;
    padding: 0px;
    resize: both;
  overflow: auto;*/ /*this will set the width of the textbox equal to its container td*/
}

td 
{
   
    /*padding: 0px;*/ /*this will set the width of the textbox equal to its container td*/
}

 
</style>
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')

<form role="form" id="delete_form" method="POST" action="{{url('stock-adjustment/delete/'.$adjustment['id'])}}">
               
               @csrf    
    </form>

    <!-- Content Header (Page header) -->
    <form role="form" id="purchase_order_form" method="POST" action="{{url('/stock-adjustment/update')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$adjustment['id']}}" name="id"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit Stock Adjustment</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="button" data-toggle="modal" style="border: none;background-color: transparent;" data-target="#modal-del">
                  <span class="fas fa-trash text-danger">&nbsp</span>Delete
                </button>
            <a class="btn" href="{{url('stock-adjustment')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('stock-adjustment/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <!-- /.delete modal -->
          <div class="modal fade" id="modal-del">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
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
              <li class="breadcrumb-item"><a href="#">Stock</a></li>
              <li class="breadcrumb-item active">Edit Adjustment</li>
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
              <div class="col-md-6">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Document</legend>
                  

              <div class="row">
              <div class="col-md-5">
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Adjustment No.</label>
                  <input type="text" name="doc_no" id="doc_no"  class="form-control select2" value="{{$adjustment['doc_no']}}" required style="width: 100%;" readonly>
                  </div>

                  

                <div class="form-group">
                  <label>Adjustment Date</label>
                  <input type="date" name="doc_date" class="form-control select2" value="{{$adjustment['doc_date']}}" required style="width: 100%;">
                  </div>

                  

                <div class="form-group">
                  <input type="checkbox" name="activeness" value="1" id="activeness" class=""  >
                  <label>Active</label>
                  </div>

               </div>

             <div class="col-md-7">
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" class="form-control select2">{{$adjustment['remarks']}}</textarea>
                  </div>

              </div>


             </div>

              </fieldset>

                                
                <!-- /.form-group -->
                

               

               
                  

               
                
              </div>
              <!-- /.col -->
              
             

            </div>
            <!-- /.row -->



<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Detail</a></li>
        
        
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="tabA">
      
     

      <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

              
   <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" onchange="setDepartmentItem()" form="add_item" name="location" id="location" style="width: 100%;">
                    <option value="">---Select any value---</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                 <div class="col-md-3">
                 <div class="dropdown" id="items_table_item_dropdown" onchange="">
        <label>Item</label>
        <input class="form-control"  name="" id="item_code">
      
    
 
  
</div>
</div>

          
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Type</label>
                  <select class="form-control select2" form="add_item" name="type" id="type" required="true" onchange="" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="add stock" selected>Add Stock</option>
                    <option value="less stock">Less Stock</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>GRN No</label>
                   <input type="text"  form="add_item" name="grn_no" id="grn_no" class="form-control" style="width: 100%;">
                </div>
              </div> 

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Batch No</label>
                  <input type="text"  form="add_item" name="batch_no" id="batch_no" class="form-control" style="width: 100%;">
                </div>
              </div> 

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number" min="0" form="add_item" name="stock_in_qty" id="stock_in_qty" class="form-control select2" style="width: 100%;">
                </div>
              </div>


                 <div class="col-md-1">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control select2" form="add_item" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" min="0" value="1" form="add_item" name="qty" id="qty" step="any" onchange="setTotalQty()" class="form-control select2" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" form="add_item" name="p_s" id="p_s" value="1"  onchange="setTotalQty()" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" form="add_item" name="total_qty" id="total_qty" min="1" value="1"  class="form-control select2" required="true" readonly style="width: 100%;">
                </div>
              </div>
               

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Rate</label>
                  <input type="number" form="add_item" name="rate" step="any" id="rate" onchange="setTotal()" class="form-control select2"  style="width: 100%;">
                </div>
              </div>

             

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total</label>
                  <input type="number" form="add_item" name="total" id="total" onchange="" class="form-control select2"  style="width: 100%;">
                </div>
              </div>

              
              
             

              <div class="col-md-1">
                    <div class="form-group">
                      <label style="visibility: hidden;">Net</label>
                  <input type="hidden" name="row_id" id="row_id" >
                    
                  <button type="button" form="add_item" class="btn" id="add_item_btn" style="width: 100%;" onclick="addItem()">
                  <span class="fa fa-plus-circle text-info"></span>
                  </button>
                </div>
              </div>


</div> <!--end row-->



                 </fieldset>
        <div class="table-responsive">
        <table class="table table-bordered" id="item_table" style="">
        <thead>
           <tr>
             <th>No.</th>
             <th>Location</th>
             <th>Code</th>
             <th>Item</th>
             <th>GRN No</th>
             <th>Batch No</th>
             <th>Size</th>
             <th>UOM</th>
             <th>Type</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
           
             <th>Rate</th>
             <th>Total</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems" style="">
             
             <?php $row=1; $net_total=0; $net_amount=0; ?>

          @foreach($adjustment['adjusted_items'] as $item)

          <?php

           $total_qty=$item['qty'] * $item['pack_size'];
            $total=$item['rate']  * $total_qty;

            $net_total +=$total_qty; $net_amount +=$total;

           

            $uom='';
            if($item['item']['unit']!='')
            $uom=$item['item']['unit']['name'];

           $size='';
            if($item['item']['size']!='')
            $size=$item['item']['size']['name'];
          

           ?>

          <tr ondblclick="(editItem('{{$row}}'))" id="{{$row}}">
            <td></td>
            <td><input type="text"  id="{{'location_'.$row}}" name="locations[]" form="purchase_order_form" value="{{$item['item']['department']['name']}}" readonly ><input type="hidden"  id="{{'location_id_'.$row}}" name="location_ids[]" form="purchase_order_form" value="{{$item['item']['department']['id']}}"  ></td>

            <td><input type="text" form="purchase_order_form"  id="{{'code_'.$row}}" name="codes[]" value="{{$item['item']['item_code']}}" readonly ></td>

            <td><input type="text" form="purchase_order_form"  id="{{'item_name_'.$row}}" name="items_name[]" form="purchase_order_form" value="{{$item['item']['item_name']}}" readonly ><input type="hidden" form="purchase_order_form"  id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item']['id']}}" readonly ></td>

            <td><input type="text" form="purchase_order_form" name="grn_nos[]"  id="{{'grn_no_'.$row}}"  form="purchase_order_form" value="{{$item['grn_no']}}" readonly ></td>

            <td><input type="text" name="batch_nos[]"  id="{{'batch_no_'.$row}}" form="purchase_order_form"  value="{{$item['batch_no']}}" readonly ></td>

            <td><input type="text" form="purchase_order_form" id="{{'size_'.$row}}" name="" value="{{$size}}" readonly ></td>

            <td><input type="text" form="purchase_order_form" id="{{'uom_'.$row}}" name="" value="{{$uom}}" readonly ></td>
     <td><input type="text" form="purchase_order_form"  id="{{'type_'.$row}}" name="types[]" value="{{$item['type']}}" readonly >

     </td>
     <td><input type="text" form="purchase_order_form"  id="{{'unit_'.$row}}" name="units[]" value="{{$item['unit']}}" readonly ></td>

     <td><input type="text"  id="{{'qty_'.$row}}" form="purchase_order_form" name="qtys[]" value="{{$item['qty']}}" readonly ></td>
     <td><input type="text"  id="{{'p_s_'.$row}}" form="purchase_order_form" name="p_s[]" value="{{$item['pack_size']}}" readonly ></td>
     <td><input type="text"  id="{{'total_qty_'.$row}}" form="purchase_order_form" name="total_qty[]" value="{{$total_qty}}" readonly ></td>
       <td><input type="text"  id="{{'rate_'.$row}}" name="rate[]" form="purchase_order_form" value="{{$item['rate']}}" readonly ></td>
          <td><input type="text" form="purchase_order_form" id="{{'total_'.$row}}" name="total[]" value="{{$total}}" readonly ></td>    

         <td><button type="button" class="btn" onclick="removeItem('{{$row}}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>

          <?php $row++; ?>
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
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th id="net_qty">{{$net_total}}</th>
            <th></th>
        
            <th id="net_total">{{$net_amount}}</th>
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

       <form role="form" id="#add_item">
              
            </form>

             <form role="form" id="#load_demand_items">
              
            </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">
var row_num="{{$row}}";
function getRowNum()
 {
  return this.row_num;
}

function setRowNum()
 {
   this.row_num+=1;
}

$(document).ready(function(){

var active="{{$adjustment['activeness']}}";

    if(active==1)
    {
      $('#activeness').prop("checked", true);
    }
    else
      $('#activeness').prop("checked", false);


  $('#purchase_order_form').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var rows=getRowNum();
for (var i =1; i <= rows ;  i++)
{
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

         var let={code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit,item_id:items[i]['id']};
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
    fieldValue: 'item_id',
  filterOpen: true
    });

 }

$(document).ready(function(){

  

  var items=[] ;

 setInventory(items);
  
  

});

 
 function setDepartmentItem()
{
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
                 //var let={item_code:'sd',item_name:'sd'};
                  //items.push(let);
     //$('#item_name').inputpicker('_init');

     //$("#inputpicker_table tr").remove(); 
                 
                 setInventory(items);



               }
             });
    
}//end setDepartmentItem








function setPackSize()
{
  unit=$("#unit").val();
  if(unit=='' || unit=='loose')
  {
     document.getElementById('p_s').setAttribute('readonly', 'readonly');
     $("#p_s").val('1');
      

       document.getElementById('pack_rate').setAttribute('readonly', 'readonly');
       $("#pack_rate").val('');

        setTotalQty();


   }
   else if( unit=='pack')
   {
    document.getElementById('p_s').removeAttribute('readonly');
    document.getElementById('pack_rate').removeAttribute('readonly');
    }
}

function setTotalQty()
{
  qty=$("#qty").val();
  p_s=$("#p_s").val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $("#total_qty").val(total_qty); 


   
   setTotal();

}

function setTotal()
{
   var total_qty=$("#total_qty").val();
   var rate=$("#rate").val();
     if(total_qty=='')
    total_qty=0;
  if(rate=='')
  {
    rate=0;
  }

   var total=parseFloat(rate) * parseFloat(total_qty) ;
   total=total.toFixed(2); 

   $("#total").val(total);

   
}


function setNetQtyAndAmount() //for end of tabel to show net
{
  var rows=getRowNum();
  
   var net_qty=0.0 , net_amount=0.0;   
   for (var i =1; i <= rows ;  i++) {

    if($(`#total_qty_${i}`). length == 0 || $(`#total_qty_${i}`). length < 0)
      continue;
    
       var qty=$(`#total_qty_${i}`).val();
      var amount=$(`#total_${i}`).val();

      

      if(qty=='' || qty==null)
        qty=0;
      if(amount=='' || amount==null)
        amount=0;

        net_qty +=  parseFloat (qty) ;

        net_amount +=  parseFloat (amount) ;

   }
   $(`#net_qty`).text(net_qty);
      $(`#net_total`).text(net_amount);

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
     var item_code=$("#item_code").val();

    

     var tbl_item_code=$(`#item_id_${i}`).val(); 

     if(item_code == tbl_item_code)
      return true;
     
  
   }
  return false;   
   
}


function updateItem(row)
{
  
 var item_id=$("#item_code").val();
  
  var location=$("#location").val();
   var location_text=$("#location option:selected").text();
   if(location=='')
    location_text='';

    var grn_no=$("#grn_no").val();
  var batch_no=$("#batch_no").val();

  var type=$("#type").val();
  var unit=$("#unit").val();
  var qty=$("#qty").val();

  var p_s=$("#p_s").val();
  var total_qty=$("#total_qty").val();
  


  var rate=$("#rate").val();
  var total=$("#total").val();


  
     
     if(item_id==''  || unit=='' || qty=='' || rate=='')
     {
        var err_name='',err_unit='',err_qty='', err_rate='';
           
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
           
           if(rate=='')
           {
            err_rate='Rate is required.';
           }


           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_rate+' '+err_name+'  '+err_unit+' '+err_qty);

     }
     else
     {

       $(`#item_id_${row}`).val(item_id);

            $(`#grn_no_${row}`).val(grn_no);
       $(`#batch_no_${row}`).val(batch_no);

                      $(`#location_id_${row}`).val(location);
                      $('#location').val(location_text);
                    
                    $(`#type_${row}`).val(type);
                    $(`#unit_${row}`).val(unit);

                         $(`#qty_${row}`).val(qty);



                           $(`#p_s_${row}`).val(p_s);
 
                         $(`#total_qty_${row}`).val(total_qty);
  
                        
                        $(`#rate_${row}`).val(rate);
  
                            $(`#total_${row}`).val(total);
  
                          
  

     $.ajax({
               type:'get',
               url:'{{ url("/inventory/item/") }}',
               data:{
                    
                    
                    
                     item_id : jQuery('#item_code').val(),
                      

               },
               success:function(data) {
                name='#item_name_'+row;
              
                size='#size_'+row;
                uom='#uom_'+row;
              
                code='#code_'+row;
                size_value='',uom_value='',color_value='';
              
                if(data['size']!=null)
                  size_value=data['size']['name'];
                if(data['unit']!=null)
                  uom_value=data['unit']['name'];
 //var name=$(id).val(); alert(name);
                   // alert(JSON.stringify(data));
                    $(name).val(data['item_name']);
                    
                    $(code).val(data['item_code']);
                    $(size).val(size_value);
                    $(uom).val(uom_value);
               }

             });

  
 $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');
  $("#item_name").val('');
  $("#item_id").val('');
  $("#location").val('');
  
  $("#item_size").val('');
  $("#grn_no").val('');
  $("#batch_no").val('');
  $("#item_unit").val('');
  $("#item_code").val('');
  $("#unit").val('loose');
  $("#qty").val('1');

  $("#p_s").val('1');
  $("#total_qty").val('1');
  
  $("#pack_rate").val('');

  
  $("#rate").val('');
  $("#total").val('');
 

  $('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

            $('#add_item_btn').attr('onclick', `addItem()`);
       setNetQtyAndAmount();
   }

  }// update item

function addItem()
{
  
  var item_id=$("#item_code").val();
   //alert(item_id);
  //var item_id=$("#item_id").val();
  var location=$("#location").val();
   var location_text=$("#location option:selected").text();
   if(location=='')
    location_text='';
  //var size=$("#item_size").val();
  //var color=$("#item_color").val();
  var grn_no=$("#grn_no").val();
var batch_no=$("#batch_no").val();  
  var unit=$("#unit").val();
  var type=$("#type").val();
  var qty=$("#qty").val();

  var p_s=$("#p_s").val();
  var total_qty=$("#total_qty").val();
  
  var pack_rate=$("#pack_rate").val();

  var rate=$("#rate").val();
  var total=$("#total").val();
 

 
     
     if(item_id==''  || unit=='' || qty=='' || rate=='')
     {
        var err_name='',err_unit='',err_qty='', err_rate='';
           
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
           if(rate=='')
           {
            err_rate='Rate is required.';
           }


           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_rate+' '+err_name+'  '+err_unit+' '+err_qty);

     }
     else
     {


      var rows = getRowNum(); 
            
     var txt=`<tr ondblclick="(editItem(${rows}))" id="${rows}"><td></td><td><input type="text"  id="location_${rows}" name="locations[]" form="purchase_order_form" value="${location_text}" readonly ><input type="hidden"  id="location_id_${rows}" name="location_ids[]" form="purchase_order_form" value="${location}"  ></td><td><input type="text" form="purchase_order_form"  id="code_${rows}" name="codes[]" value="" readonly ></td><td><input type="text" form="purchase_order_form"  id="item_name_${rows}" name="items_name[]" form="purchase_order_form" value="" readonly ><input type="hidden" form="purchase_order_form"  id="item_id_${rows}" name="items_id[]" value="${item_id}" readonly ></td>

     <td><input type="text" form="purchase_order_form" name="grn_nos[]"  id="grn_no_${rows}"  form="purchase_order_form" value="${grn_no}" readonly ></td>

     <td><input type="text"  id="batch_no_${rows}" form="purchase_order_form" name="batch_nos[]" value="${batch_no}" readonly ></td><td><input type="text" form="purchase_order_form" id="size_${rows}" name="" value="" readonly ></td><td><input type="text" form="purchase_order_form" id="uom_${rows}" name="" value="" readonly ></td>
     <td><input type="text" form="purchase_order_form"  id="type_${rows}" name="types[]" value="${type}" readonly ></td>
     <td><input type="text" form="purchase_order_form"  id="unit_${rows}" name="units[]" value="${unit}" readonly ></td><td><input type="text"  id="qty_${rows}" form="purchase_order_form" name="qtys[]" value="${qty}" readonly ></td>
     <td><input type="text"  id="p_s_${rows}" form="purchase_order_form" name="p_s[]" value="${p_s}" readonly ></td>
     <td><input type="text"  id="total_qty_${rows}" form="purchase_order_form" name="total_qty[]" value="${total_qty}" readonly ></td>
       <td><input type="text"  id="rate_${rows}" name="rate[]" form="purchase_order_form" value="${rate}" readonly ></td>
          <td><input type="text" form="purchase_order_form" id="total_${rows}" name="total[]" value="${total}" readonly ></td>    

         <td><button type="button" class="btn" onclick="removeItem(${rows})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

   

    $("#selectedItems").append(txt);

                  
     $.ajax({
               type:'get',
               url:'{{ url("/inventory/item/") }}',
               data:{
                    
                    
                    
                     item_id : jQuery('#item_code').val(),
                      

               },
               success:function(data) {
                name='#item_name_'+rows;
              
                size='#size_'+rows;
                uom='#uom_'+rows;
              
                code='#code_'+rows;
                size_value='',uom_value='',color_value='';
        
                  
                if(data['size']!=null)
                  size_value=data['size']['name'];
                if(data['unit']!=null)
                  uom_value=data['unit']['name'];
 //var name=$(id).val(); alert(name);
                   // alert(JSON.stringify(data));
                    $(name).val(data['item_name']);
              
                    $(code).val(data['item_code']);
                    $(size).val(size_value);
                    $(uom).val(uom_value);
               }

             });

   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');


  $("#item_name").val('');
  $("#item_id").val('');
  $("#location").val('');

  $("#item_size").val('');

   $("#grn_no").val('');
    $("#batch_no").val('');

  $("#item_unit").val('');
  $("#item_code").val('');
  $("#unit").val('loose');
  $("#qty").val('1');

  $("#p_s").val('1');
  $("#total_qty").val('1');
  
  $("#pack_rate").val('');


  $("#rate").val('');
  $("#total").val('');
  


  $('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

            setNetQtyAndAmount();
            setRowNum(); 
   
   }


     
}//add item

function editItem(row)
{
   var item_name=$(`#item_name_${row}`).val();
   var item_id=$(`#item_id_${row}`).val();

   $('#item_code').val(item_id);

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(item_name);

var location_id=$(`#location_id_${row}`).val();
$('#location').val(location_id);

var grn_no=$(`#grn_no_${row}`).val();
$('#grn_no').val(grn_no);

var batch_no=$(`#batch_no_${row}`).val();
$('#batch_no').val(batch_no);



var unit=$(`#unit_${row}`).val();
$('#unit').val(unit);

if(unit=='pack')
{
   document.getElementById('p_s').removeAttribute('readonly');
    document.getElementById('pack_rate').removeAttribute('readonly');
}

var type=$(`#type_${row}`).val();
$('#type').val(type);


  var qty=$(`#qty_${row}`).val();
$('#qty').val(qty);


  var p_s=$(`#p_s_${row}`).val();
  $('#p_s').val(p_s);
  var total_qty=$(`#total_qty_${row}`).val();
  $('#total_qty').val(total_qty);
  
  var pack_rate=$(`#pack_rate_${row}`).val();
  $('#pack_rate').val(pack_rate);
  
  var rate=$(`#rate_${row}`).val();
  $('#rate').val(rate);
  var total=$(`#total_${row}`).val();
  $('#total').val(total);
  
 

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
    //$(this).remove();
    $(`#${row}`).remove();
    setNetQtyAndAmount();
  
});

}


function setLots(lot_no='')
{

    var s1=$("#item_code").val();

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
      s=s.val();
      var item_id=s1;

      if(item_id=='')
      {
        $('#lot_no').empty().append('<option>---Select any value---</option>');
      }

      $.ajax({
               type:'get',
               url:'{{ url("get/item/current/stocks") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     item_id: item_id,
                  

               },
               success:function(data) {

                stocks=data;
                //setStocks(stocks);

                $('#lot_no').empty();

                

                 var txt='<option value="">---Select any value---</option><option value="">id~GRN No~Batch No</option>';
                 $(txt).appendTo("#lot_no");


                 for (var i =0; i < stocks.length ; i ++) {
                  var selected='';
                  if(lot_no==stocks[i]['stock_id'])
                    selected='selected';
                   txt=`<option value="${stocks[i]['stock_id']}" ${selected}>${stocks[i]['stock_id']}~${stocks[i]['grn_no']}~${stocks[i]['batch_no']}</option>`;
                   $(txt).appendTo("#lot_no");
                 }


               }
             });

      
}

function setStockQty()
{
   var stock_id=$('#lot_no').val();
   if(stock_id!='')
   {
   let point = this.stocks.findIndex((item) => item.stock_id == stock_id);

   //alert(point);
   //alert(JSON.stringify(this.stocks));

   var stock_qty=this.stocks[point]['rem_stock_qty'];
   $('#stock_in_qty').val(stock_qty);

    var rate=this.stocks[point]['rate'];
   $('#rate').val(rate);
    setTotal();

    
    } 

}




</script>

@endsection  
  