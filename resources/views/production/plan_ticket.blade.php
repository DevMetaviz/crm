
@extends('layout.master')
@section('title', 'Plan Ticket')
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
    <form role="form" id="ticket_form" method="POST" action="{{url('/plan-ticket/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
  

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Plan Ticket</h1>
            <button form="ticket_form" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('plan-ticket')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('plan/ticket/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Plan Ticket</li>
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
                  <label class="col-sm-4">Ticket No.</label>
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$ticket_no}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Ticket Date</label>
                  <input type="date" form="ticket_form" name="ticket_date" class="form-control select2 col-sm-8" value="{{date('Y-m-d')}}"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" class="form-control select2 col-sm-8" value="" required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="number" form="ticket_form" name="batch_size" id="batch_size" class="form-control select2 col-sm-5"  required readonly style="width: 100%;">
                  <input type="text" form="ticket_form" name="batch_size_unit" id="batch_size_unit" class="form-control select2 col-sm-3"  readonly style="width: 100%;">
                  </div>
                </div>

                <!-- <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="purchase_demand" name="default" value="default" id="default" class=""  checked>&nbsp&nbspDefault</label>
                  </div>
                </div> -->


               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

                

               
                
              </div>
              <!-- /.col -->


               <div class="col-md-4">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Remarks</legend>

                   <textarea form="ticket_form" name="remarks" class="form-control select2"></textarea>
                 </fieldset>

                 <fieldset class="border p-4">
                   <legend class="w-auto">Production Plan</legend>
                     <select form="ticket_form" class="form-control select2" name="plan_id" id="plan_id" onchange="setPlanItems()" >
                       <option value="">Select any std.</option>
                       @foreach($plans as $std)
                       <option value="{{$std['id']}}">{{$std['plan_no'].'~'.$std['text'].'~'.$std['plan_date']}}</option>
                       @endforeach
                     </select>
                     
                   </fieldset>


               </div>
            

            </div>
            <!-- /.row -->
            


<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Detail</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabStages">Stages</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabE">Raw Material</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabF">Packing Material</a></li>

    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
    <div class="tab-pane fade show active" id="tabA">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Product Detail</legend>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2"  form="ticket_form" name="product_location" id="product_location" readonly style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    
                  </select>
                </div>
              </div>

                  <div class="col-md-3">
                 <div class="dropdown" id="product_item_dropdown">
        <label>Item</label>
        <input class="form-control" form="ticket_form" onchange="setAvailQty()"  name="product_item_code" id="product_item_code">
      
           </div>
           </div>

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Avail Qty</label>
                  <input type="number" min="0"  form="ticket_form" name="avail_qty" id="avail_qty" value="0" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control select2" form="ticket_form" name="product_unit" id="product_unit" required="true" onchange="setProductPackSize()" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="0" min="0"  form="ticket_form" name="product_qty" id="product_qty" onchange="setProductTotalQty()" class="form-control select2" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1"  form="ticket_form" name="product_pack_size" id="product_pack_size" value="1"  onchange="setProductTotalQty()" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="ticket_form" name="product_total_qty" id="product_total_qty" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <!-- <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <input type="hidden" name="row_id" id="row_id" >
                  <button type="button" form="ticket_form" id="add_item_btn" class="btn" onclick="addItem()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div> -->

              


</div> <!--end row-->



                 </fieldset>
              </div>
            </div>


     
        
    </div> <!-- End TabA  -->

    <div class="tab-pane fade" id="tabStages">

     <input type="hidden" form="ticket_form" name="stages" id="stages" value="">

            <div id="stages_body" class="row">

              
              
            </div>

      
    </div> <!-- End Tab Stages  -->

    

     <div class="tab-pane fade" id="tabE">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Raw Material</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                  <div class="col-md-3">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code">
      
           </div>
           </div>

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Stage</label>
                  <select class="form-control select2" form="add_item" name="item_stage" id="item_stage" required="true"  style="width: 100%;">
                    <option value="-1">Select Stage</option>
                    
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

              <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>Std. Qty</label>
                  <input type="number" value="0" min="0" form="add_item" name="std_qty" id="std_qty" onchange="" class="form-control select2" required="true" style="width: 100%;">
                </div>
              </div> -->

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Req. Qty</label>
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
                  <label>Sort Order</label>
                  <input type="number" value="1" min="1" form="add_item" name="sort" id="sort" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <label><input type="checkbox" form="add_item" name="mf" id="mf" value="1" checked>
                  MF
                  </label>
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
              <th>Code</th>
             <th>Item</th>
      
             <th>Stage</th>
  
             <th>UOM</th>
             <th>Unit</th>
              <th>Std Qty</th>
             <th>Req. Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <th>Sort Order</th>
             <th>M.F</th>
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
             <th id="net_std_qty">0</th>
             <th id="net_qty">0</th>
             <th></th>
             <th id="net_total_qty">0</th>
             <th></th>
             <th></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

      
    </div> <!-- End TabE  -->


     <div class="tab-pane fade" id="tabF">


      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Article Detail</legend>

              
    
    <div id="p_item_add_error" style="display: none;"><p class="text-danger" id="p_item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                   

                  <div class="col-md-3">
                 <div class="dropdown" id="p_items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="p_item_code" id="p_item_code">
      
           </div>
           </div>

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Stage</label>
                  <select class="form-control select2" form="add_item" name="p_item_stage" id="p_item_stage" required="true"  style="width: 100%;">
                    <option value="-1">Select Stage</option>
                    
                  </select>
                </div>
              </div>

           
                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control select2" form="add_item" name="p_unit" id="p_unit" required="true" onchange="setPackSize('packing')" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" step="any" form="add_item" name="p_qty" id="p_qty" onchange="setTotalQty('packing')" class="form-control select2" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1"  form="add_item" name="p_p_s" id="p_p_s" value="1"  onchange="setTotalQty('packing')" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1"  form="add_item" name="p_total_qty" id="p_total_qty" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Sort Order</label>
                  <input type="number" value="1" min="1" form="add_item" name="p_sort" id="p_sort" class="form-control select2"  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <label><input type="checkbox" form="add_item" name="p_mf" id="p_mf" value="1" >
                  MF
                  </label>
                </div>
              </div>



              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <input type="hidden" name="p_row_id" id="p_row_id" >
                  <button type="button" form="add_item" id="p_add_item_btn" class="btn" onclick="addItem('packing')">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> <!--end row-->



                 </fieldset>
              </div>
            </div>


     <div class="table-responsive">
      <table class="table table-bordered table-hover "  id="p_item_table" >
        <thead class="table-secondary">
           <tr>

             <th>#</th>
             <th>Code</th>
             <th>Item</th>
             <th>Stage</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Std Qty</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <th>Sort Order</th>
             <th>M.F</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="p_selectedItems">

          

          
          
        </tbody>
        <tfoot>
          <tr>
           
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="p_net_std_qty">0</th>
             <th id="p_net_qty">0</th>
             <th></th>
             <th id="p_net_total_qty">0</th>
             <th></th>
             <th></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>


      
    </div> <!-- End TabF  -->
   
    
   

   
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
  
  var row_num=1;
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
   this.row_num+=1;
}

function setProducts(products) //initiate all products of plan 
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
                  $("#p_selectedItems").html('');
                //start material items
             for ( var l =0; l< materials.length ; l++ ) {
               addItemTabel(materials[l]);
             }
               
             //end material items

               }
             });

    
}

function setInventory(items,element_id)
 {
  
  
  var new_items=[];
 
 for(var i = 0 ; i < items.length ; i++)
 {
    var item_type='',item_unit='',item_category='';

  
   if(items[i]['type']!=null)
    item_type=items[i]['type']['name'];
   if(items[i]['unit']!=null)
    item_unit=items[i]['unit']['name'];
 
   if(items[i]['category']!=null)
    item_category=items[i]['category']['name'];

    combine='code_'+items[i]['item_code']+'_name_'+items[i]['item_name']+'_uom_'+item_unit+'_id_'+items[i]['id'];

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,unit:item_unit};
         //alert(let);
         new_items.push(let);
 }


$(`#${element_id}`).inputpicker({
    data:new_items,
    fields:[
        {name:'code',text:'Code'},
        {name:'item',text:'Item'},
        {name:'type',text:'Type'},
        {name:'category',text:'Category'},
      
    
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
       

       var items=<?php echo json_encode($raw_items); ?> ;
      setInventory(items,'item_code');

      var items=<?php echo json_encode($packing_items); ?> ;
      setInventory(items,'p_item_code');

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

                items=data; //alert(JSON.stringify(items));
                 setProducts(items);
                 setPlanProducts(items);



               }
             });
    
}//end setDepartmentItem



      function setAvailQty() 
{
     var item_combine=$('#product_item_code').val();
     item_combine=item_combine.split('_');
   var s=$("#product_item_dropdown").find(".inputpicker-input");
   var item_name=s.val();
   
    $('#product_location').empty().append('<option value="'+item_combine[13]+'">'+item_combine[15]+'</option>');

  
   $("#avail_qty").val(item_combine[17]);
    
    let point = this.products.findIndex((item) => item.item_name === item_name);

        

      var stages=this.products[point]['stages'];
     
      $('#stages').val(JSON.stringify( stages));
    

               $('#item_stage').empty().append('<option selected="selected" value="-1">Select Stage</option>');
              var stage_text='<ul>';

                  for (var k =0 ;k < stages.length ; k ++ )
                   {                   
                  
       
                    var index = k;
                   

                  var proces='<li><h4>'+stages[index]['process_name']+'</h4></li>';
                  var sub_proces=stages[index]['sub_processes'];

                  $('<option value="'+stages[index]['id']+'">'+stages[index]['process_name']+'</option>').appendTo("#item_stage");

                      for(var j =0 ;j < sub_proces.length ; j ++ )
                      {
                        $('<option value="'+sub_proces[j]['id']+'">~'+sub_proces[j]['process_name']+'</option>').appendTo("#item_stage");
                      }
                
                   stage_text+=proces;

     
                
                }//end for of stages
                stage_text+='</ul>';
                   $("#stages_body").html(stage_text);
                 //end stages
             

}

function get_stage_text(stage)
{   
     var sub_processes=stage['sub_processes'];
//alert(JSON.stringify(stage));
    var stage_text=get_stage_text_inner(stage,'stages_id');
    var sub_stage_txt=get_sub_stage_text(sub_processes);
   txt=`<div class="col-md-4" id="">

                <fieldset class="border p-4">
                ${stage_text}

                ${sub_stage_txt}


                </fieldset>
              </div> `;
            
    return txt;

}

function get_sub_stage_text(sub_processes)
{
     var sub_txt='';
     if(sub_processes.length >0)
     {
                  for (var sub =0 ;sub < sub_processes.length ; sub ++ )
                   { 

                    var stages_array_name='sub_'+sub_processes[sub]['id']+'_ids';
                     var sub_p_txt=get_stage_text_inner(sub_processes[sub],stages_array_name);
                     var sub_sub_txt = '';
                        
                        if(sub_processes[sub]['sub_processes'].length!=0)
                        {
                           sub_sub_txt=get_sub_stage_text(sub_processes[sub]['sub_processes']);
                        }

                        sub_txt+=`
                    <div class="col-md-12" id="">

                <fieldset class="border p-4">
                
                ${sub_p_txt}

                ${sub_sub_txt}

                      </fieldset>
                
              </div>
   `;

                   }
                 }

                   return sub_txt;
}

function get_stage_text_inner(stage,stages_array_name)
{   
    var process_id=stage['id'];
    var process_name=stage['process_name'];
    var parameters=stage['parameters'];
    var sort=stage['sort_order'];
    var qc_required=stage['qc_required'];
    var sub_processes=stage['sub_processes'];

    var check='';
    if(qc_required==1)
      check='checked';
      parameter_array_name='';
     var prmtr_txt=get_parameter_text(parameters);

    qc_txt=''
    if(qc_required==1)
    {
      qc_txt+=`<label class="col-sm-8 offset-sm-4 text-danger">
                  *QC Required</label>`;
    }

    txt=` <legend class="w-auto">${process_name}&nbsp<a href="#" data-toggle="tooltip" data-placement="bottom" title="The parameters which are filled when relevant process is carried out!"><span class="fa fa-info-circle"></span></a></legend>
                    <input type="hidden" form="production_standard_form" name="${stages_array_name}[]" value="${process_id}" >
                    <div class="form-group row">
                  <label class="col-sm-4">Sort order</label>
                  <input type="number" form="production_standard_form"  name="stages_sort[]" class="form-control select2 col-sm-8" min="1" value="${sort}" style="width: 100%;">
                  </div>
                   ${prmtr_txt}
                    
                    <div class="form-group row">
                  ${qc_txt}
                  </div>`;
                  
                  

               

    return txt;

}


function get_parameter_text(parameters,parameter_array_name)
{
    var prmtr_txt='';
    for (var i =0; i < parameters.length ; i ++) {
                   prmtr_txt+=`<div class="form-group row">
                  <label class="col-sm-4">${parameters[i]['name']}</label>
                  <input type="hidden" form="production_standard_form" name="${parameter_array_name}[]" value="${parameters[i]['id']}" >
                  <input type="text" form="production_standard_form"  name="stage_parameters[]" class="form-control select2 col-sm-8"  style="width: 100%;">
                  </div>`;
    }

    return prmtr_txt;
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
   
   $("#batch_size").val(total_qty);

    

   setEstimatedMaterial();
}

// $("#product_item_code").change(function(){

//                    var id=$("#product_item_code").val();

//                  var products=this.products;
                 
//                  let point = products.findIndex((item) => item.id == id);
//               var unit=products[point]['unit'];
//               if(unit!=null)
//               $("#batch_size_unit").val(unit['name']);
//         });




function setPackSize(type='')
{
  var id='';
  if(type=='packing')
    id='p_';

  unit=$(`#${id}unit`).val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById(`${id}p_s`).setAttribute('readonly', 'readonly');
  $(`#${id}p_s`).val('1');
       setTotalQty(type);
   }
   else if( unit=='pack')
   document.getElementById(`${id}p_s`).removeAttribute('readonly');
}



function setTotalQty(type='') //in add item form
{
  var id='';
  if(type=='packing')
    id='p_';

  qty=$(`#${id}qty`).val();
  p_s=$(`#${id}p_s`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;

   //total_qty= total_qty.toFixed(3);
   
   $(`#${id}total_qty`).val(total_qty); 
}

function setNetQty(type='') //for end of tabel to show net
{
  var rows=this.row_num;

  var id='';
  if(type=='packing')
    id='p_';
  
   var net_total_qty=0, net_qty=0, net_std_qty=0 ; 
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#${id}total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#${id}total_qty_${i}`).text();
       var qty=$(`#${id}qty_${i}`).text();
       var std_qty=$(`#${id}std_qty_${i}`).text();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;

      if(std_qty=='' || std_qty==null || std_qty=='-')
        std_qty=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;
         net_std_qty +=  parseFloat (std_qty) ;
      }
       

   }

   // net_qty= net_qty.toFixed(3);
     //net_total_qty= net_total_qty.toFixed(3);
     //net_std_qty= net_std_qty.toFixed(3);
     
   $(`#${id}net_total_qty`).text(net_total_qty);
   $(`#${id}net_qty`).text(net_qty);
   $(`#${id}net_std_qty`).text(net_std_qty);

     

}



function addItemTabel(item)
{
   
    var item_name=item['item_name'];
   var item_code=item['item_code'];
  
    var item_uom=item['item_uom'];
    var item_id=item['item_id'];
  

  var stage_id=item['stage_id'];
  var stage_text=item['stage_name'];
  
  if(stage_id=='-1')
    { stage_text='';  }
  var unit=item['unit'];
  var qty=item['qty'];
  var p_s=item['pack_size'];
  var total=item['total'];

  var sort=item['sort'];
    var type=item['type'];

      var mf=item['mf'];
       var  checked='false';

    if( mf == 1 )
      { checked='true'; }

  var id='',type1=''; 
  if(type=='packing')
    {id='p_'; type1='packing';}
  else
    type1='raw';

     
        
     var row=this.row_num;   


     var txt=`
     <tr ondblclick="(editItem(${row},'${type}'))" id="${row}">
      
     
     <input type="hidden" form="ticket_form" id="${id}item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="ticket_form" id="${id}type_${row}" name="types[]" value="${type1}"  >
     <input type="hidden" form="ticket_form" id="${id}item_stage_id_${row}" name="item_stage_ids[]"  value="${stage_id}"  >
     <input type="hidden" form="ticket_form" id="${id}units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="${id}std_qtys_${row}" name="std_qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="${id}qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="${id}p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="ticket_form" id="${id}sorts_${row}" name="sort[]"  value="${sort}">
     <input type="hidden" form="ticket_form" id="${id}mfs_${row}" name="mf[]"  value="${mf}">

     
     <td></td>
     <td id="${id}code_${row}">${item_code}</td>
     <td id="${id}item_name_${row}">${item_name}</td>
     
     <td id="${id}item_stage_text_${row}">${stage_text}</td>
      
       <td id="${id}item_uom_${row}">${item_uom}</td>
     <td id="${id}unit_${row}">${unit}</td>
     <td id="${id}std_qty_${row}">${qty}</td>
     <td id="${id}qty_${row}">${qty}</td>
     <td id="${id}p_s_${row}">${p_s}</td>
     
     
     <td id="${id}total_qty_${row}">${total}</td>
     <td id="${id}sort_${row}">${sort}</td>
     <td><input type="checkbox"  id="${id}mf_${row}" readonly  /></td>

         <td><button type="button" class="btn" onclick="removeItem(${row},'${type}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;     
   $(`#${id}selectedItems`).append(txt);

   if(checked=='true')
      $(`#${id}mf_${row}`).prop("checked", checked );
  
          setNetQty(type);
           this.row_num ++;
   
     
}//end add item


function addItem(type='')
{
   var id='',type1=''; 
  if(type=='packing')
    {id='p_'; type1='packing';}
  else
    type1='raw';

  var item_combine=$(`#${id}item_code`).val();

    item_combine=item_combine.split('_');
  
    if(item_combine!='')
    {
    var item_name=item_combine[3];
    var item_code=item_combine[1];
    var item_uom=item_combine[5];
    var item_id=item_combine[7];
  }
  else
  {
    var item_name='';
    var item_code='';
    var item_uom='';
    var item_id='';
  }


  var stage_id=$(`#${id}item_stage`).val();
  var stage_text=$(`#${id}item_stage option:selected`).text();
  
  if(stage_id=='-1')
    { stage_text='';  }



  var unit=$(`#${id}unit`).val();
  var qty=$(`#${id}qty`).val();
  var p_s=$(`#${id}p_s`).val();
  var total=$(`#${id}total_qty`).val();

  var sort=$(`#${id}sort`).val();

  var mf=0; checked='false';

    if( $(`#${id}mf`).prop('checked') == true )
      {mf=1; checked='true'; }
     
     if(item_name=='' || unit=='' || qty=='' )
     {
        var err_name='',err_unit='',err_qty='';
           
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



           $(`#${id}item_add_error`).show();
           $(`#${id}item_add_error_txt`).html(err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=this.row_num;   


     var txt=`
     <tr ondblclick="(editItem(${row},'${type}'))" id="${row}">
      
      <input type="hidden" form="ticket_form" id="${id}pivot_id_${row}" name="pivot_ids[]" value="" readonly >
     
     <input type="hidden" form="ticket_form" id="${id}item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="ticket_form" id="${id}type_${row}" name="types[]" value="${type1}"  >
     <input type="hidden" form="ticket_form" id="${id}item_stage_id_${row}" name="item_stage_ids[]"  value="${stage_id}"  >
     <input type="hidden" form="ticket_form" id="${id}units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="${id}std_qtys_${row}" name="std_qtys[]"  value="" >
     <input type="hidden" form="ticket_form" id="${id}qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="${id}p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="ticket_form" id="${id}sorts_${row}" name="sort[]"  value="${sort}">
     <input type="hidden" form="ticket_form" id="${id}mfs_${row}" name="mf[]"  value="${mf}">
     
     <td></td>
    <td id="${id}code_${row}">${item_code}</td>
     <td id="${id}item_name_${row}">${item_name}</td>

    

     <td id="${id}item_stage_text_${row}">${stage_text}</td>
      
       
       <td id="${id}item_uom_${row}">${item_uom}</td>
     <td id="${id}unit_${row}">${unit}</td>
     <td id="${id}std_qty_${row}">-</td>
     <td id="${id}qty_${row}">${qty}</td>
     <td id="${id}p_s_${row}">${p_s}</td>

     
     
     <td id="${id}total_qty_${row}">${total}</td>
     <td id="${id}sort_${row}">${sort}</td>
     <td><input type="checkbox"  id="${id}mf_${row}" readonly  /></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row},'${type}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='1';
     
   

    $(`#${id}selectedItems`).append(txt);

     if(checked=='true')
      $(`#${id}mf_${row}`).prop("checked", checked );

   $(`#${id}sort`).val('1');
   $(`#${id}item_code`).val('');

   var s=$(`#${id}items_table_item_dropdown`).find(".inputpicker-input");
   s.val('');


  $(`#${id}item_stage`).val('-1');
  
  $(`#${id}unit`).val('loose');
  $(`#${id}qty`).val('1');
  $(`#${id}p_s`).val('1');
  $(`#${id}total_qty`).val('1');

  

$(`#${id}row_id`).val('');

  $(`#${id}item_add_error`).hide();
           $(`#${id}item_add_error_txt`).html('');

     
  document.getElementById(`${id}p_s`).setAttribute('readonly', 'readonly');
  
          setNetQty(type);
           this.row_num ++;
   
   }
     
}//end add item



function updateItem(row,type='')
{

  var id=''; 
  if(type=='packing')
    {id='p_';}

  var item_combine=$(`#${id}item_code`).val();

    item_combine=item_combine.split('_');
  
    if(item_combine!='')
    {
    var item_name=item_combine[3];
    var item_code=item_combine[1];
    //var item_color=item_combine[9];
    //var item_size=item_combine[7];
    var item_uom=item_combine[5];
    var item_id=item_combine[7];
  }
  else
  {
    var item_name='';
    var item_code='';
    //var item_color='';
    //var item_size='';
    var item_uom='';
    var item_id='';
  }

  // var location=$(`#${id}location`).val();
  // var location_text=$(`#${id}location option:selected`).text();
  var stage_id=$(`#${id}item_stage`).val();
  var stage_text=$(`#${id}item_stage option:selected`).text();
  
  if(stage_id=='-1')
    { stage_text='';  }
  var unit=$(`#${id}unit`).val();
  var qty=$(`#${id}qty`).val();
  var p_s=$(`#${id}p_s`).val();
  var total=$(`#${id}total_qty`).val();
  var sort=$(`#${id}sort`).val();
  var mf=0; checked='false';

    if( $(`#${id}mf`).prop('checked') == true )
      { mf=1; checked='true'; }
     
     if(item_name=='' ||  unit=='' || qty=='' )
     {
        var err_name='',err_location='',err_unit='',err_qty='';
           
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



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+'  '+err_unit+' '+err_qty);

     }
     else
     {
     
       //$(`#${id}location_id_${row}`).val(location);
       $(`#${id}item_id_${row}`).val(item_id);
        $(`#${id}item_stage_id_${row}`).val(stage_id);
        $(`#${id}units_${row}`).val(unit);
        $(`#${id}qtys_${row}`).val(qty);
        $(`#${id}p_ss_${row}`).val(p_s);
        $(`#${id}sorts_${row}`).val(sort);

      //$(`#${id}location_text_${row}`).text(location_text);
     $(`#${id}code_${row}`).text(item_code);
      
      $(`#${id}item_name_${row}`).text(item_name);
      $(`#${id}item_stage_text_${row}`).text(stage_text);
      //$(`#color_${row}`).text(item_color);
      //$(`#size_${row}`).text(item_size);
      $(`#${id}item_uom_${row}`).text(item_uom);
      $(`#${id}unit_${row}`).text(unit);
        $(`#${id}qty_${row}`).text(qty);
        $(`#${id}p_s_${row}`).text(p_s);

       $(`#${id}total_qty_${row}`).text(total_qty);

          $(`#${id}sort_${row}`).text(sort);
       
          $(`#${id}mfs_${row}`).val(mf);

          if(checked=='true')
          $(`#${id}mf_${row}`).prop('checked',true);
          else
          $(`#${id}mf_${row}`).prop('checked',false);
     
      if(p_s==null)
        p_s='';
     
   $(`#${id}item_code`).val('');

   var s=$(`#${id}items_table_item_dropdown`).find(".inputpicker-input");
   s.val('');

  $(`#${id}item_name`).val('');
  $(`#${id}item_id`).val('');
$(`#${id}item_stage`).val('-1');
  //$(`#${id}location`).val('');
  $(`#${id}unit`).val('loose');
  $(`#${id}qty`).val('1');
  $(`#${id}p_s`).val('1');
  $(`#${id}total_qty`).val('1');
  $(`#${id}sort`).val("1" );

$(`#${id}row_id`).val('');

  $(`#${id}item_add_error`).hide();
           $(`#${id}item_add_error_txt`).html('');


  document.getElementById(`${id}p_s`).setAttribute('readonly', 'readonly');
 
   setNetQty(type);
  $(`#${id}add_item_btn`).attr('onclick', `addItem('${type}')`);
   
   }
     
}  //end update item


function editItem(row,type='')
{
   
    var id=''; 
  if(type=='packing')
    {id='p_';}


   var item_name=$(`#${id}item_name_${row}`).text();
   var item_code=$(`#${id}code_${row}`).text();
   var item_id=$(`#${id}item_id_${row}`).val();
   
   var item_uom=$(`#${id}item_uom_${row}`).text();
   
   combine='code_'+item_code+'_name_'+item_name+'_uom_'+item_uom+'_id_'+item_id;

   $(`#${id}item_code`).val(combine);
   var s=$(`#${id}items_table_item_dropdown`).find(".inputpicker-input");
   s.val(item_name);
  

var stage_id=$(`#${id}item_stage_id_${row}`).val();
$(`#${id}item_stage`).val(stage_id);

var unit=$(`#${id}unit_${row}`).text();
$(`#${id}unit`).val(unit);


  var qty=$(`#${id}qty_${row}`).text();
$(`#${id}qty`).val(qty);


  var p_s=$(`#${id}p_s_${row}`).text();
  $(`#${id}p_s`).val(p_s);
  


  var total_qty=$(`#${id}total_qty_${row}`).text();
  $(`#${id}total_qty`).val(total_qty);

  var sort=$(`#${id}sort_${row}`).text(); 
  $(`#${id}sort`).val(sort);

  var mf=$(`#${id}mfs_${row}`).val();
if(mf==1)
$(`#${id}mf`).prop('checked',true)
else 
  $(`#${id}mf`).prop('checked',false)


  $(`#${id}row_id`).val(row);

  $(`#${id}add_item_btn`).attr('onclick', `updateItem(${row},'${type}')`);

  if(unit=='' || unit=='loose')
  {
  document.getElementById(`${id}p_s`).setAttribute('readonly', 'readonly');
  $(`${id}p_s`).val('1');
  setTotalQty(type);
   }
   else if( unit=='pack')
   document.getElementById(`${id}p_s`).removeAttribute('readonly');

}

function removeItem(row,type='')
{
  
  
    $(`#${row}`).remove();
      setNetQty(type);


}



$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});




</script>

@endsection  
