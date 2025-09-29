
@extends('layout.master')
@section('title', 'Sale Demand')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('sale-demand/update')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Sale Demand</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/sale-demand')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/sale-demand/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/print/sale-demand/'.$demand['id'])}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Demand</li>
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
                <h3 class="card-title">Demand</h3>
              
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
                <input type="hidden" form="ticket_form" value="{{$demand['id']}}" name="id"/>

                
                

                <div class="row col-md-10 form-row">
                  
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Demand No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control col-sm-8" value="{{$demand['doc_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                 
                
                   

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Demand Date</label>
                  <input type="date" form="ticket_form" name="doc_date" class="form-control  col-sm-8" value="{{$demand['doc_date']}}" readonly  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">From</label>
                  <input type="date" form="ticket_form" name="from" class="form-control  col-sm-8" value="{{$demand['from']}}"  required style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">To</label>
                  <input type="date" form="ticket_form" name="to" class="form-control  col-sm-8" value="{{$demand['to']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 

                <!--  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Month</label>
                  <input type="date" form="ticket_form" name="production_date" class="form-control select2 col-sm-8" value=""  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Manufacturing Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" class="form-control select2 col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div> -->


                 
                 

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea class="form-control col-sm-10" placeholder="Comment..." form="ticket_form" name="remarks">{{$demand['remarks']}}</textarea>
                  </div>
                 </div>


                

                 

                 
                 <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="activeness" value="1" id="activeness" class="" >&nbsp&nbspActive</label>
                  </div>
                </div>
                 

                

               </div>
 

                 
<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabE">Material/Items</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">

     <div class="tab-pane fade show active" id="tabE">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Item</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Product</label>
                  <select class="form-control select2" onchange="setAttrinutes()" form="add_item" name="item_id" id="item_id" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($products as $product)
                    <option value="{{$product['id']}}">{{$product['item_name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div> 


              <div class="col-md-2">
                    <div class="form-group">
                  <label>UOM</label>
                  <input type="text"  form="add_item" name="uom" id="uom" class="form-control" readonly  style="width: 100%;">
                </div>
              </div>


                  
             <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="text"   form="add_item" name="pack_size" id="pack_size" class="form-control" readonly  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>MRP</label>
                  <input type="number" value=""  form="add_item" name="mrp" id="mrp"  class="form-control" readonly  style="width: 100%;">
                </div>
              </div>

                 

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty"  class="form-control" required="true" style="width: 100%;">
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
             <th>Item</th>
             <th>UOM</th>
             <th>Pack Size</th>
             <th>MRP</th>
             <th>Qty</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

         
        <?php $row=1; ?>
        
             @foreach($demand['items'] as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>))" id="{{$row}}">
      
      
    
     <input type="hidden" form="ticket_form" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['id']}}" readonly >
     
     
     <input type="hidden" form="ticket_form" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['pivot']['qty']}}" >
     
    
     
     <td></td>
     <td id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>
     
    
    
       <td id="{{'uom_'.$row}}">@if($item['unit']!=''){{$item['unit']['name']}}@endif</td>
     <td id="{{'pack_size_'.$row}}">{{$item['pack_size']}}</td>
    <td id="{{'mrp_'.$row}}">{{$item['mrp']}}</td>
     <td id="{{'qty_'.$row}}">{{$item['pivot']['qty']}}</td>
        
     

         <td><button type="button" class="btn" onclick="removeItem(<?php echo $row; ?>)"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
              <?php $row+=1;  ?>
     @endforeach
           
          
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

  
var row_num=<?php echo $row ?>;

function getRowNum()
 {
  return this.row_num;
}
function setRowNum()
 {
   this.row_num+=1;
}
  

  $(document).ready(function(){

    var active="{{$demand['activeness']}}";
     if(active==1)
     $('#activeness').prop('checked',true);
   else if(active==0)
     $('#activeness').prop('checked',false);

$('.select2').select2(); 

 setNetQty();

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

  

function setAttrinutes()
{
   var id=$("#item_id").val();
     if(id=='')
      return ;

   var products=<?php echo json_encode($products); ?> ;
                 
                 let point = products.findIndex((item) => item.id == id);
              var item=products[point];

    var uom="";

        $("#mrp").val(item['mrp']);
         $("#pack_size").val(item['pack_size']);
          
          if(item['unit']!='')
            uom=item['unit']['name'];
         $("#uom").val(uom);

}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
   var  net_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#qty_${i}`). length > 0 )
     { 
       
       var qty=$(`#qty_${i}`).text();

      if(qty=='' || qty==null)
        qty=0;
      
         net_qty +=  parseFloat (qty) ;

        
      }
       

   }

    net_qty =  net_qty.toFixed(2) ;

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
     var item_id=$("#item_id").val();

    

     var tbl_item_id=$(`#item_id_${i}`).val(); 

     if(item_id == tbl_item_id)
      return true;
     
  
   }
  return false;   
   
}

function addItem()
{
  var item_id=$("#item_id").val();
  var item_name=$(`#item_id option:selected`).text();

  var mrp=$("#mrp").val();
  var qty=$("#qty").val();
  var uom=$("#uom").val();
  var pack_size=$("#pack_size").val();

      var dbl=checkItem();
       
     if(item_id=='' || dbl==true || qty=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(item_id=='')
           {
                err_name='Item is required.';
           }

           if(dbl==true)
           {
                err_dbl='Item is already added.';
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
      
     
     <input type="hidden" form="ticket_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     
     
     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     
     
     <td></td>
     <td id="item_name_${row}">${item_name}</td>
   
  
       <td id="uom_${row}">${uom}</td>
     <td id="pack_size_${row}">${pack_size}</td>
     <td id="mrp_${row}">${mrp}</td>
     <td id="qty_${row}">${qty}</td>
    
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
    
     
   

    $("#selectedItems").append(txt);

   $("#item_id").val('');
    $('#item_id').trigger('change');

  
  $("#uom").val('');
  $("#qty").val('1');
  $("#pack_size").val('');
  $("#mrp").val('');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

  
          setNetQty();
           setRowNum();
   
   }
     
}//end add item

function updateItem(row)
{
  var item_id=$("#item_id").val();
  var item_name=$(`#item_id option:selected`).text();

  var mrp=$("#mrp").val();
  var qty=$("#qty").val();
  var uom=$("#uom").val();
  var pack_size=$("#pack_size").val();

     
     var dbl=checkItem(row);
       
     if(item_id=='' || dbl==true || qty=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(item_id=='')
           {
                err_name='Item is required.';
           }

           if(dbl==true)
           {
                err_dbl='Item is already added.';
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
     
    
       $(`#item_id_${row}`).val(item_id);
      
        $(`#qtys_${row}`).val(qty);
      
      
      $(`#item_name_${row}`).text(item_name);
    
    
    
      $(`#uom_${row}`).text(uom);
      $(`#mrp_${row}`).text(mrp);
        $(`#qty_${row}`).text(qty);
        $(`#pack_size_${row}`).text(pack_size);

            
   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');


  $("#item_id").val('');
  $('#item_id').trigger('change');
 
  
  $("#uom").val('');
  $("#qty").val('1');
  $("#pack_size").val('');
  $("#mrp").val('');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
  
   
   }
     
}  //end update item


function editItem(row)
{
   

  var item_id=$(`#item_id_${row}`).val();
  $('#item_id').val(item_id);
   $('#item_id').trigger('change');
 

  var qty=$(`#qty_${row}`).text();
$('#qty').val(qty);



  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

  

}

function removeItem(row)
{
  

  $('#item_table tr').click(function(){
    $(`#${row}`).remove();
    setNetQty();
  
    });


}



 
  
</script>





@endsection  
  