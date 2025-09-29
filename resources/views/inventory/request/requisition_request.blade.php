
@extends('layout.master')
@section('title', 'Requisition Form')
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
    <form role="form" id="ticket_form" method="POST" action="{{url('/requisition/request/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Requisition</h1>
            <button form="ticket_form" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('requisition/request/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('requisition/requests')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Inventory</a></li>
              <li class="breadcrumb-item active">Requisition</li>
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
              <div class="col-md-4">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <div class="form-row">

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Requisition No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control col-sm-8" value="{{$doc_no}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Requisition Date</label>
                  <input type="date" form="ticket_form" name="doc_date" class="form-control col-sm-8" value="{{date('Y-m-d')}}"  required style="width: 100%;">
                  </div>
                </div>

               
 
                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Department</label>
                  <select form="ticket_form" name="department_id" id="department_id" onchange="setDepartmentItem()" class="form-control col-sm-8" required="true">
                    <option value="">Select any value</option>
                    @foreach($locations as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>

               

                 <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="active" value="1" id="active" class=""  checked>&nbsp&nbspActive</label>
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="is_approved" value="1" id="is_approved" class=""  >&nbsp&nbspApproved</label>
                  </div>
                </div> 


               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

                

               
                
              </div>
              <!-- /.col -->

               <div class="col-md-4">

                <fieldset class="border p-4">
                   <legend class="w-auto">Detail</legend>
                  
                  <div class="form-group row">
                  <label class="col-sm-4">Plan</label>
                  <select form="ticket_form" name="plan_id" id="plan_id" onchange="setPlanAtt()"  class="form-control col-sm-8" >  
                    <option>Select any value</option>
                    @foreach($plans as $prod)
                    
                    <option value="{{$prod['id']}}">{{$prod['plan_no']}}</option>
                    @endforeach
                  </select>
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <select form="ticket_form" name="product_id" id="product_id"  class="form-control col-sm-8" readonly >  
                    <option>Select any value</option>
                  </select>
                  </div>
                   
                   <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="text" form="ticket_form" name="batch_size" id="batch_size" class="form-control col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                      
                  <div class="form-group row">
                  <label class="col-sm-4">Batch No</label> 
                  <input type="text" form="ticket_form" name="batch_no" id="batch_no" class="form-control col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 
                  

                 <!--  <div class="form-group row">
                  <label class="col-sm-4">Process</label>
                  <select form="ticket_form" name="process_id" id="process_id"  class="form-control col-sm-8" >  
                    <option value="-1">Select any value</option>
                    
                  </select>
                  </div> -->

              

               </fieldset>
               </div>

     
     <div class="col-md-4">

                <fieldset class="border p-4">
                   <legend class="w-auto">Other</legend>

               <div class="form-group row">
                  <label class="col-sm-4">MRP</label>
                  <input type="number" step="any" form="ticket_form" name="mrp" id="mrp" class="form-control col-sm-8" value="" readonly  style="width: 100%;">
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">Mfg Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" id="mfg_date" class="form-control col-sm-8" value="" readonly style="width: 100%;">
                  </div>
                      
                  <div class="form-group row">
                  <label class="col-sm-4">Exp Date</label> 
                  <input type="date" form="ticket_form" name="exp_date" id="exp_date" class="form-control col-sm-8" value="" readonly style="width: 100%;">
                  </div>

                 <div class="form-group row">
                  <label class="col-sm-4">Batch Due Date</label> 
                  <input type="date" form="ticket_form" name="batch_due_date" id="batch_due_date" class="form-control col-sm-8" value="" readonly style="width: 100%;">
                  </div>  

                </fieldset>
              </div>

               <div class="col-md-4">

                <fieldset class="border p-4">
                   <legend class="w-auto">Other</legend>

                   <div class="form-group row">
                  <label class="col-sm-4">Requisition By:</label>
                   <select class="form-control select2 col-sm-8" name="request_by" id="request_by" onchange="setDesignation()" >
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">Designation</label>
                <input type="text" class="form-control col-sm-8" value="" name="designation_request_by" id="designation_request_by" readonly>
                </div> 

                  <div class="form-group row">
                  <label class="col-sm-4">Approved By:</label>
                   <select class="form-control select2 col-sm-8" name="approved_by" id="approved_by" onchange="setDesignation1()"  >
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div> 

                  <div class="form-group row">
                  <label class="col-sm-4">Designation</label>
                <input type="text" class="form-control col-sm-8" value="" name="designation_approved_by"  id="designation_approved_by" readonly>
                </div> 

                
                    </fieldset>
                  
               
                   


               </div>


               <div class="col-md-4">

                <fieldset class="border p-4">
                   <legend class="w-auto">Remarks</legend>
                   <textarea form="ticket_form" name="remarks" class="form-control"></textarea>
              </fieldset>
            </div>
            

            </div>
            <!-- /.row -->
            


<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabE">Material/Items</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
   

     <div class="tab-pane fade show active" id="tabE">

      <div class="row hidden-item">
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

                  <div class="col-md-2">
                    <div class="form-group">
                  <label>Items</label>
                  <select class="form-control select2" form="add_item" name="item_id" id="item_id" onchange="setUom()" required="true">
                    <option>Select any value</option>
                  </select>
                </div>
              </div>


           <div class="col-md-2">
                    <div class="form-group">
                  <label>Stage</label>
                  <select class="form-control" form="add_item" name="process_id" id="process_id"   style="width: 100%;">
                    <option value="-1">Select any value</option>
                    
                  </select>
                </div>
              </div>

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control" form="add_item" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
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
             <th>UOM</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <th class="hidden-item"></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

         <?php $row=1; ?>
          @if(isset($request_material))
          
        
             @foreach($request_material as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>))" id="{{$row}}">
      
      
    
     <input type="hidden" form="ticket_form" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >
     
     <input type="hidden" form="ticket_form" id="{{'units_'.$row}}" name="units[]"  value="{{$item['unit']}}">
     
     <input type="hidden" form="ticket_form" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['qty']}}" >
     
     <input type="hidden" form="ticket_form" id="{{'p_ss_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}">

     <input type="hidden" form="ticket_form" id="{{'stages_'.$row}}" name="stages[]"  value="{{$item['stage_id']}}">
     
     <td></td>
     
     <td id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>
     <td id="{{'stage_text_'.$row}}">{{$item['stage_text']}}</td>
    
    
       <td id="{{'item_uom_'.$row}}">{{$item['uom']}}</td>
     <td id="{{'unit_'.$row}}">{{$item['unit']}}</td>
    
     <td id="{{'qty_'.$row}}">{{$item['qty']}}</td>
    
     <td id="{{'p_s_'.$row}}">{{$item['pack_size']}}</td>
     
     
     <td id="{{'total_qty_'.$row}}">{{$item['total_qty']}}</td>
    
     

         <td class="hidden-item"><button type="button" class="btn" onclick="removeItem(<?php echo $row; ?>)"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
              <?php $row+=1;  ?>
     @endforeach

          @endif
        
           
          
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
             <th id="net_total_qty"></th>
             <th class="hidden-item"></th>
           </tr>
        </tfoot>
      </table>
    </div>

      
    </div> <!-- End TabE  -->
   
    
   

   
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
<script type="text/javascript">
  
  var row_num=<?php echo $row ?>;
 
  $(document).ready(function() {

     $('.select2').select2(); 
   
   setNetQty();
  
  $('#ticket_form').submit(function(e) {

     e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();

for (var i =1; i <= row_num ;  i++)
{
if ($(`#total_qty_${i}`). length > 0 )
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
}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
   var net_total_qty=0, net_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).text();
       var qty=$(`#qty_${i}`).text();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;
      }
       

   }

    net_qty =  net_qty.toFixed(3) ;

        net_total_qty =  net_total_qty.toFixed(3) ;


   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
     

}






function addItem()
{
   var item_uom=$(`#uom`).val();
    var item_id=$(`#item_id`).val();
    var item_name=$(`#item_id option:selected`).text();

  
 
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();

  var stage_id=$(`#process_id`).val();
  var stage_text=$(`#process_id option:selected`).text();
  
  if(stage_id=='-1')
    { stage_text='';  }
     
     if(item_id=='' ||  unit=='' || qty=='' )
     {
        var err_name='',err_unit='',err_qty='';
           
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



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     
     <input type="hidden" form="ticket_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     
     <input type="hidden" form="ticket_form" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="ticket_form" id="stages_${row}" name="stages[]"  value="${stage_id}">
     
     <td></td>
     
     <td id="item_name_${row}">${item_name}</td>
    <td id="stage_text_${row}">${stage_text}</td>
  
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="unit_${row}">${unit}</td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td class="hidden-item"><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   

  

    $(`#process_id`).val('-1');
    

  $(`#item_id`).val('');
      $(`#item_id`).trigger('change');

  $("#uom").val('');

  
  $("#unit").val('loose');
  $("#qty").val('1');
  $("#p_s").val('1');
  $("#total_qty").val('1');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

     
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  
          setNetQty();
           setRowNum();
   
   }
     
}//end add item

function updateItem(row)
{
  var item_uom=$(`#uom`).val();
    var item_id=$(`#item_id`).val();
    var item_name=$(`#item_id option:selected`).text();
  
  
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();

  var stage_id=$(`#process_id`).val();
  var stage_text='';
  if(stage_id!=-1)
   stage_text=$(`#process_id option:selected`).text();
     
     if(item_id=='' ||  unit=='' || qty=='' )
     {
        var err_name='',err_unit='',err_qty='';
           
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



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
     
    
       $(`#item_id_${row}`).val(item_id);
      
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        $(`#p_ss_${row}`).val(p_s);

    $(`#stages_${row}`).val(stage_id);
       $(`#stage_text_${row}`).text(stage_text);

    
      
      $(`#item_name_${row}`).text(item_name);
    
    
    
      $(`#item_uom_${row}`).text(item_uom);
      $(`#unit_${row}`).text(unit);
        $(`#qty_${row}`).text(qty);
        $(`#p_s_${row}`).text(p_s);

       $(`#total_qty_${row}`).text(total_qty);
     
     
      if(p_s==null)
        p_s='';
     
  
  $("#uom").val('');
  $(`#item_id`).val('');
  $(`#item_id`).trigger('change');

  $("#process_id").val('-1');

  
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

  var item_name=$(`#item_name_${row}`).text();
   
   var item_id=$(`#item_id_${row}`).val();
   
   //var item_uom=$(`#item_uom_${row}`).text();
   $(`#item_id`).val(item_id);
   $(`#item_id`).trigger('change');



var stage=$(`#stages_${row}`).val();
$('#process_id').val(stage);


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


function setDesignation()
{
  var id=$('#request_by').val();
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='' || emp==null || emp==0)
       $('#designation_request_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_request_by').val(emp);
     }
}

function setDesignation1()
{
  var id=$('#approved_by').val();
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='' || emp==null || emp==0)
        $('#designation_approved_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_approved_by').val(emp);
     }
}

function setPlanAtt()
{     
     plan_id=$('#plan_id').val();
     if(plan_id=='')
      return;
  
    var plans=JSON.parse(`<?php echo json_encode($plans); ?>`);  

   let point = plans.findIndex((item) => item.id == plan_id);

   var plan=plans[point];
    
   $('#product_id').empty().append(`<option selected="selected" value="${plan['product_id']}">${plan['product_name']}</option>`);
              var text='';
              
             

         $('#batch_size').val(plan['batch_size']) ;
              
          if(plan['batch_no']=='' || plan['batch_no']==null)
          {
            document.getElementById('batch_no').setAttribute('required', 'true');
            document.getElementById('mfg_date').setAttribute('required', 'true');
            document.getElementById('exp_date').setAttribute('required', 'true');
            document.getElementById('batch_due_date').setAttribute('required', 'true');
            document.getElementById('mrp').setAttribute('required', 'true');

            document.getElementById('batch_no').removeAttribute('readonly');
            document.getElementById('mfg_date').removeAttribute('readonly');
            document.getElementById('exp_date').removeAttribute('readonly');
            document.getElementById('batch_due_date').removeAttribute('readonly');
            document.getElementById('mrp').removeAttribute('readonly');
          }
          else
          {
            $('#batch_no').val(plan['batch_no']) ;
            $('#mfg_date').val(plan['mfg_date']) ;
            $('#exp_date').val(plan['exp_date']) ;
            $('#batch_due_date').val(plan['batch_due_date']) ;
            $('#mrp').val(plan['mrp']) ;

            document.getElementById('batch_no').setAttribute('readonly', 'readonly');
            document.getElementById('mfg_date').setAttribute('readonly', 'readonly');
            document.getElementById('exp_date').setAttribute('readonly', 'readonly');
            document.getElementById('batch_due_date').setAttribute('readonly', 'readonly');
            document.getElementById('mrp').setAttribute('readonly', 'readonly');
          }
         $('.hidden-item').hide() ;
       setPlanItems(); 

         

}



$('#department_id').on('change',function(e) {

    setPlanItems();

  });

function setPlanItems()
{ 
    var depart_id=$('#department_id').val();

    plan_id=$('#plan_id').val();
     if(plan_id=='' || depart_id =='')
      return;

    var plans=JSON.parse(`<?php echo json_encode($plans); ?>`);  

   let point = plans.findIndex((item) => item.id == plan_id);

   var plan=plans[point];

     var items=plan['items'];
                 $("#selectedItems").html(''); 

         for (var i =0; i < items.length ;  i++) {

          var departs=JSON.parse(`<?php echo json_encode($locations); ?>`); 
          let point = departs.findIndex((item) => item.id == depart_id);
            var d_items=departs[point]['items'];

          let point1 = d_items.findIndex((item) => item.id == items[i]['item_id']);
            if(point1<0)
              continue ;
          insert_item(items[i]['item_name'],'-1','',items[i]['item_uom'],items[i]['item_id'],items[i]['unit'],items[i]['qty'],items[i]['pack_size']);

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
      
     
     <input type="hidden" form="ticket_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     
     <input type="hidden" form="ticket_form" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="ticket_form" id="stages_${row}" name="stages[]"  value="${stage_id}">
     
     <td></td>
     <td id="item_name_${row}">${item_name}</td>
    <td id="stage_text_${row}">${stage_text}</td>
  
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="unit_${row}">${unit}</td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td class="hidden-item" style="display:none;"><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
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
