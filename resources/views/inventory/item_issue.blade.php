
@extends('layout.master')
@section('title', 'Issuance Material')
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
    <form role="form" id="ticket_form" method="POST" action="{{url('/issuance/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Material Issuance</h1>
            <button form="ticket_form" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('plan-ticket')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('issuance/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Inventory</a></li>
              <li class="breadcrumb-item active">Material Issuance</li>
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
              <div class="col-md-5">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <div class="form-row">

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Issuance No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control select2 col-sm-8" value="{{$doc_no}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Issuance Date</label>
                  <input type="date" form="ticket_form" name="doc_date" class="form-control select2 col-sm-8" value="{{date('Y-m-d')}}"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Requisition No.</label>
                  <input type="text" form="ticket_form" name="requisition_no" class="form-control select2 col-sm-8" value="{{$request['requisition_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Requisition Date</label>
                  <input type="date" form="ticket_form" name="requisition_date" class="form-control select2 col-sm-8" value="{{$request['requisition_date']}}"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No</label>
                  <input type="text" form="ticket_form" name="plan_no" class="form-control select2 col-sm-8" value="{{$request['plan_no']}}" required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Ticket No</label>
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$request['ticket_no']}}"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="issued" value="issued" id="issued" class=""  checked>&nbsp&nbspIssued</label>
                  </div>
                </div>


               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

                

               
                
              </div>
              <!-- /.col -->


               <div class="col-md-4">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Remarks</legend>

                   <textarea form="ticket_form" name="remarks" class="form-control select2">
                     {{$request['remarks']}}
                   </textarea>
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

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Item</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" readonly form="add_item" name="location" id="location" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                  <div class="col-md-3">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code" readonly>
      
           </div>
           </div>

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Stage</label>
                  <select class="form-control select2" form="add_item" name="item_stage" id="item_stage" readonly  style="width: 100%;">
                    <option value="-1">Select Stage</option>
                    @foreach($stages as $stage)
                    <option value="{{$stage['id']}}">{{$stage['process_name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control select2" form="add_item" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Req Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="req_qty" id="req_qty" onchange="" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Issued Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty" onchange="setTotalQty()" class="form-control select2" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" value="1" min="1"  form="add_item" name="p_s" id="p_s"   onchange="setTotalQty()" class="form-control select2" readonly  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <input type="hidden" name="row_id" id="row_id" >
                  <button type="button" form="add_item" id="add_item_btn" class="btn" onclick="">
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

             <th>Location</th>
             <th>Code</th>
             <th>Item</th>
             <th>Stage</th>
             <th>Color</th>
             <th>Size</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Req Qty</th>
             <th>Issue Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

          <?php $row=1; $total_req_qty=0; $total_qty=0; $total_net_qty=0; ?>
        
             @foreach($request_material as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>))" id="{{$row}}">
      
      
     <input type="hidden" form="ticket_form" id="{{'location_id_'.$row}}"   name="location_ids[]" value="{{$item['location_id']}}"  >
     <input type="hidden" form="ticket_form" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >
     <input type="hidden" form="ticket_form" id="{{'item_stage_id_'.$row}}" name="item_stage_ids[]"  value="{{$item['stage_id']}}"  >
     <input type="hidden" form="ticket_form" id="{{'units_'.$row}}" name="units[]"  value="{{$item['unit']}}">
     <input type="hidden" form="ticket_form" id="{{'req_qtys_'.$row}}" name="req_qtys[]"  value="{{$item['req_qty']}}" >
     <input type="hidden" form="ticket_form" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['qty']}}" >
     <input type="hidden" form="ticket_form" id="{{'p_ss_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}">
     
     <td id="{{'location_text_'.$row}}">{{$item['location_text']}}</td>
     <td id="{{'code_'.$row}}">{{$item['item_code']}}</td>
     <td id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>
     <td id="{{'item_stage_text_'.$row}}">{{$item['stage_text']}}</td>
       <td id="{{'color_'.$row}}">{{$item['color']}}</td>
       <td id="{{'size_'.$row}}">{{$item['size']}}</td>
       <td id="{{'item_uom_'.$row}}">{{$item['uom']}}</td>
     <td id="{{'unit_'.$row}}">{{$item['unit']}}</td>
     <td id="{{'req_qty_'.$row}}">{{$item['req_qty']}}</td>
     <td id="{{'qty_'.$row}}">{{$item['qty']}}</td>
     <td id="{{'p_s_'.$row}}">{{$item['pack_size']}}</td>
     
     
     <td id="{{'total_qty_'.$row}}">{{$item['total_qty']}}</td>
     

         <td><button type="button" class="btn" onclick="removeItem()"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
     <?php $row+=1; $total_req_qty+=$item['req_qty']; $total_qty+=$item['qty']; $total_net_qty+=($item['qty']*$item['pack_size']); ?>
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
             <th id="net_req_qty">{{$total_req_qty}}</th>
             <th id="net_qty">{{$total_qty}}</th>
             <th></th>
             <th id="net_total_qty">{{$total_net_qty}}</th>
             <th></th>
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
  var products=[];
  var esitmated_material=[];

  $(document).ready(function() {

  
  $('#ticket_form').submit(function(e) {

    e.preventDefault();
     var item=$('#product_item_code').val();
    if(item=='')
    {
      $('#std_error').show();
      $('#std_error_txt').html('Select product!');
      return;
    }

 var avail=$('#avail_qty').val();
 var qty=$('#product_qty').val();
    if(parseInt(qty)==0)
    {
      $('#std_error').show();
      $('#std_error_txt').html('Qty should be greater than 0!');
      return;
    }
             if( parseInt(qty) > parseInt(avail))
             {
               $('#std_error').show();
               $('#std_error_txt').html('Qty should be less than avail qty!');
             }
             else
             {
                   $('#std_error').hide();
                  $('#std_error_txt').html('');
                  this.submit();
             }
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

function setProducts(products)
 {
   this.products=products;
}

function setEstimatedMaterial()
 {
    var plan_id= jQuery('#plan_id').val();
    var qty= jQuery('#product_total_qty').val();
    var item_combine=$('#product_item_code').val();
     item_combine=item_combine.split('_');
   var s=$("#product_item_dropdown").find(".inputpicker-input");
   var item_name=s.val();
   var item_id=item_combine[11];

   let point = this.products.findIndex((item) => item.item_name === item_name);
// value of index will be "1"
         var std_id=this.products[point]['std_id'];

              //alert(item_combine);
  if(qty==0)
  {
    
  }
   

    $.ajax({
               type:'get',
               url:'{{ url("/get/ticket/esitmated-material") }}',
               data:{
                    
                     std_id : std_id,
                     qty : qty,
                  
               },
               success:function(data) {

                materials=data;
                  $("#selectedItems").html('');
                //start material items
             for ( var l =0; l< materials.length ; l++ ) {
               addItemTabel(materials[l]);
             }
               
             //end material items

               }
             });
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

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit};
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
    fieldValue: 'combine',
  filterOpen: true
    });

 }

  function setPlanProducts(items)
 {
  
  
  var new_items=[];
 
 for(var i = 0 ; i < items.length ; i++)
 {
  var item_color='',item_type='',item_unit='',item_size='',item_category='';
  if(items[i]['color']!=null)
    item_color=items[i]['color'];
   if(items[i]['type']!=null)
    item_type=items[i]['type'];
   if(items[i]['uom']!=null)
    item_unit=items[i]['uom'];
   if(items[i]['size']!=null)
    item_size=items[i]['size'];
   if(items[i]['category']!=null)
    item_category=items[i]['category'];

    combine='code_'+items[i]['item_code']+'_name_'+items[i]['item_name']+'_uom_'+item_unit+'_size_'+item_size+'_color_'+item_color+'_id_'+items[i]['item_id']+'_locId_'+items[i]['location_id']+'_locText_'+items[i]['location_text']+'_availQty_'+items[i]['total_available_qty'];

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit};
         //alert(let);
         new_items.push(let);
 }


$('#product_item_code').inputpicker({
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
    fieldValue: 'combine',
  filterOpen: true
    });

 }

$(document).ready(function(){
  
     var items=[];
      setPlanProducts(items);
       setInventory(items);
       //setNetQty();
});





 function setPlanItems()
{
  var plan_id= jQuery('#plan_id').val();

  if(plan_id=='')
  {
    var items=[];//blank array
    setPlanProducts(items);
     $("#selectedItems").html('');
      $("#stages_body").html('');

      $('#product_item_code').val('');
       var s=$("#product_item_dropdown").find(".inputpicker-input");
      s.val('');
    return;
  }
   

    $.ajax({
               type:'get',
               url:'{{ url("/get/plan/items") }}',
               data:{
                    
                     plan_id: plan_id,
                  
               },
               success:function(data) {

                items=data;
                 setProducts(items);
                 setPlanProducts(items);



               }
             });
    
}//end setDepartmentItem

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

      function setAvailQty() 
{
     var item_combine=$('#product_item_code').val();
     item_combine=item_combine.split('_');
   var s=$("#product_item_dropdown").find(".inputpicker-input");
   var item_name=s.val();
   
   $('<option value="'+item_combine[13]+'">'+item_combine[15]+'</option>').appendTo("#product_location");

   $("#product_location").val(item_combine[13]);

   $("#avail_qty").val(item_combine[17]);
    
    let point = this.products.findIndex((item) => item.item_name === item_name);
// value of index will be "1"
         var items=this.products[point]['materials'];
      var stages=this.products[point]['stages'];
       var txt='', stage_select_txt='';

       for (var k =0 ;k < stages.length ; k ++ )
                   {                   
                  
       
       var index = k;
    
    var prmtr_txt='';
    var process_id=stages[index]['id'];
     
    var box_id='stage_box_'+process_id;
   
    var process_name=stages[index]['process_name'];
    var parameters=stages[index]['parameters'];
    var sort=stages[index]['sort_order'];
    var qc_required=stages[index]['qc_required'];

    var check='';
    if(qc_required==1)
      check='checked';
   
     
    for (var i =0; i < parameters.length ; i ++) {
                   prmtr_txt+=`<div class="form-group row">
                  <label class="col-sm-4">${parameters[i]['name']}</label>
                  <input type="text" form="production_standard_form"  name="stage_${process_id}_parameters[]" class="form-control select2 col-sm-8"  style="width: 100%;">
                  </div>`;
    }
    qc_txt=''
    if(qc_required==1)
    {
      qc_txt+=`<label class="col-sm-8 offset-sm-4 text-danger">
                  *QC Required</label>`;
    }
      //<input type="checkbox" form="production_standard_form"  name="stages_sort[]" class=" " readonly value="${qc_required}" ${check} >&nbsp
  txt+=`
  <div class="col-md-4" id="${box_id}">

                <fieldset class="border p-4">
                  <legend class="w-auto">${process_name}&nbsp<a href="#" data-toggle="tooltip" data-placement="bottom" title="The parameters which are filled when relevant process is carried out!"><span class="fa fa-info-circle"></span></a></legend>
                    <input type="hidden" form="production_standard_form" name="stages_id[]" value="${process_id}" >
                    <div class="form-group row">
                  <label class="col-sm-4">Sort order</label>
                  <input type="number" form="production_standard_form"  name="stages_sort[]" class="form-control select2 col-sm-8" min="1" value="${sort}" style="width: 100%;">
                  </div>
                   ${prmtr_txt}
                    
                    <div class="form-group row">
                  ${qc_txt}
                  </div>

                </fieldset>
                
              </div>
   `;

     
            stage_select_txt+='<option value="'+process_id+'">'+process_name+'</option>';
     
                
                }//end for of stages
                $("#stages_body").html(txt);
                 $(stage_select_txt).appendTo("#item_stage");
             

} 

function setProductPackSize()
{
  unit=$("#product_unit").val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById('product_pack_size').setAttribute('readonly', 'readonly');
  $("#product_pack_size").val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('product_pack_size').removeAttribute('readonly');
}

function setProductTotalQty() //in add item form
{
  qty=$("#product_qty").val();
  p_s=$("#product_pack_size").val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $("#product_total_qty").val(total_qty); 

   setEstimatedMaterial();
}



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
   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
     

}

function addItemTabel(item)
{
  var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
  
   
    var item_name=item['item_name'];
    var item_code=item['item_code'];
    var item_color=item['item_color'];
    var item_size=item['item_size'];
    var item_uom=item['item_uom'];
    var item_id=item['item_id'];
  

  var location=item['location_id'];
  var location_text=item['location_text'];
  var stage_id=item['stage_id'];
  var stage_text=item['stage_name'];
  
  if(stage_id=='-1')
    { stage_text='';  }
  var unit=item['unit'];
  var qty=item['qty'];
  var p_s=item['pack_size'];
  var total=item['total'];
     
        
     var row=this.row_num;   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     <input type="hidden" form="ticket_form" id="location_id_${row}"   name="location_ids[]" value="${location}"  >
     <input type="hidden" form="ticket_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="ticket_form" id="item_stage_id_${row}" name="item_stage_ids[]"  value="${stage_id}"  >
     <input type="hidden" form="ticket_form" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     
     <td id="location_text_${row}">${location_text}</td>
     <td id="code_${row}">${item_code}</td>
     <td id="item_name_${row}">${item_name}</td>
     <td id="item_stage_text_${row}">${stage_text}</td>
       <td id="color_${row}">${item_color}</td>
       <td id="size_${row}">${item_size}</td>
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="unit_${row}">${unit}</td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td><button type="button" class="btn" onclick="removeItem()"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;     
   $("#selectedItems").append(txt);
  
          setNetQty();
           this.row_num ++;
   
   
     
}//end add item




function addItem()
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
  var stage_id=$("#item_stage").val();
  var stage_text=$("#item_stage option:selected").text();
  
  if(stage_id=='-1')
    { stage_text='';  }
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();
     
     if(item_name=='' || location=='' || unit=='' || qty=='' )
     {
        var err_name='',err_location='',err_unit='',err_qty='';
           
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



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_location+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=this.row_num;   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     <input type="hidden" form="production_standard_form" id="location_id_${row}"   name="location_ids[]" value="${location}"  >
     <input type="hidden" form="production_standard_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="production_standard_form" id="item_stage_id_${row}" name="item_stage_ids[]"  value="${stage_id}"  >
     <input type="hidden" form="production_standard_form" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="production_standard_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="production_standard_form" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     
     <td id="location_text_${row}">${location_text}</td>
     <td id="code_${row}">${item_code}</td>
     <td id="item_name_${row}">${item_name}</td>
     <td id="item_stage_text_${row}">${stage_text}</td>
       <td id="color_${row}">${item_color}</td>
       <td id="size_${row}">${item_size}</td>
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="unit_${row}">${unit}</td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td><button type="button" class="btn" onclick="removeItem()"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');

  $("#item_name").val('');
  $("#item_id").val('');
$("#item_stage").val('-1');
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
           this.row_num ++;
   
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
  var stage_id=$("#item_stage").val();
  var stage_text=$("#item_stage option:selected").text();
  
  if(stage_id=='-1')
    { stage_text='';  }
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();
     
     if(item_name=='' || location=='' || unit=='' || qty=='' )
     {
        var err_name='',err_location='',err_unit='',err_qty='';
           
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



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_location+' '+err_unit+' '+err_qty);

     }
     else
     {
     
       $(`#location_id_${row}`).val(location);
       $(`#item_id_${row}`).val(item_id);
        $(`#item_stage_id_${row}`).val(stage_id);
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        $(`#p_ss_${row}`).val(p_s);

      $(`#location_text_${row}`).text(location_text);
     $(`#code_${row}`).text(item_code);
      
      $(`#item_name_${row}`).text(item_name);
      $(`#item_stage_text_${row}`).text(stage_text);
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
$("#item_stage").val('-1');
  $("#location").val('');
  $("#unit").val('loose');
  $("#req_qty").val('1');
  $("#qty").val('1');
  $("#p_s").val('1');
  $("#total_qty").val('1');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');


  document.getElementById('p_s').setAttribute('readonly', 'readonly');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', ``);
   
   }
     
}  //end update item


function editItem(row)
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

var stage_id=$(`#item_stage_id_${row}`).val();
$('#item_stage').val(stage_id);



var unit=$(`#unit_${row}`).text();
$('#unit').val(unit);

  var req_qty=$(`#req_qty_${row}`).text();
$('#req_qty').val(req_qty);

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

function removeItem()
{
  
  $('#item_table tr').click(function(){
    $(this).remove();
      setNetQty();
});

}



$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});




</script>

@endsection  
