
@extends('layout.master')
@section('title', 'Production Standard')
@section('header-css')


<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">

@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
    <form role="form" id="production_standard_form" method="POST" action="{{url('save/production-standard')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Production Standard</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('/finish-goods-production-standard')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/finish-goods-production-standard/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Standard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->


    
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
              <div class="col-md-8">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <div class="form-row">

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Standard No.</label>
                  <input type="text"  name="std_no" class="form-control col-sm-8" value="{{$std_no}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  <label class="col-sm-4">Standard Name</label>
                  <input type="text"  name="std_name" class="form-control col-sm-8"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Master Article</label>
                  <select name="master_article" id="master_article" class="form-control select2 col-sm-8" onchange="addStages()" required>
                    <option value="">Select Master Article</option>
                    @foreach($products as $pro)
                    <option value="{{$pro['id']}}">{{$pro['item_name']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="number" min="1"  name="batch_size" class="form-control col-sm-5"  required style="width: 100%;">
                  <input type="text"  name="batch_size_unit" id="batch_size_unit" class="form-control col-sm-3" readonly   style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea name="remarks" class="form-control col-sm-10"></textarea>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="activeness" value="active" id="activeness" class="" checked>&nbsp&nbspActive</label>
                  </div>
                </div>


               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

                

               
                
              </div>
              <!-- /.col -->
            

            </div>
            <!-- /.row -->

            

            


<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Material</a></li>
        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Packing Material</a></li> -->
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabStages">Stages</a></li>
        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC">By Product</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabD">Labour Allocation</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabE">Esitmated Production</a></li> -->
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
    <div class="tab-pane fade show active" id="tabA">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Article Detail</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">
                
                <div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" form="add_item" name="department_id" id="department_id" required="true" onchange="setDepartItems()" style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}" >{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Items</label>
                  <select class="form-control select2" form="add_item" name="item_id" id="item_id" onchange="setUom()" required="true">
                    <option>Select any value</option>
                  </select>
                </div>
              </div>
                   

                  <!-- <div class="col-md-3">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code">
      
           </div>
           </div> -->

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Stage</label>
                  <select class="form-control select2" form="add_item" name="item_stage" id="item_stage" required="true"  >
                    <option value="-1">Select Stage</option>
                    
                  </select>
                </div>
              </div>

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control" form="add_item" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
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
                  <input type="number" value="1" step="any" form="add_item" name="qty" id="qty" onchange="setTotalQty()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1"  form="add_item" name="p_s" id="p_s" value="1"  onchange="setTotalQty()" class="form-control" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1"  form="add_item" name="total_qty" id="total_qty" class="form-control" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Sort Order</label>
                  <input type="number" value="1" min="1" form="add_item" name="sort" id="sort" class="form-control "  style="width: 100%;">
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
             
             <th>Item</th>
          
             <th>Stage</th>
      
             
             
             <th>Unit</th>
             <th>UOM</th>
             <th>Qty</th>
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
        
    </div> <!-- End TabA  -->


    <!-- <div class="tab-pane fade" id="tabB">


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

              


</div> 



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


      
    </div> --> <!-- End TabB  -->

    <div class="tab-pane fade" id="tabStages">

     <input type="hidden" name="procedure_id" id="procedure_id" value="">

            <div id="stages_body" class="row">

              
              
            </div>

      
    </div> <!-- End Tab Stages -->

    

     <!-- <div class="tab-pane fade" id="tabC">

      
    </div> --> <!-- End TabC  -->

     <!-- <div class="tab-pane fade" id="tabD">

      
    </div> --> <!-- End TabD  -->

     <!-- <div class="tab-pane fade" id="tabE">

      
    </div> --> <!-- End TabE  -->
   
    
   

   
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_item">
              
            </form>

            <form role="form" id="#add_stage">
              
            </form>
   
@endsection

@section('jquery-code')

<script type="text/javascript">
  
  var row_num=1;

  

  $(document).ready(function() {

  $('.select2').select2(); 

  $('#production_standard_form').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();
             if(row_num==1)
             {
               $('#std_error').show();
               $('#std_error_txt').html('Select items!');
             }
             else
             {
                   //$('#std_error').hide();
               $('#std_error_txt').html('ok');
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

$(document).ready(function(){
  
   // var items=<?php //echo json_encode($raw_items); ?> ;
   //    setInventory(items,'item_code');

   //    var items=<?php //echo json_encode($packing_items); ?> ;
   //    setInventory(items,'p_item_code');

      $("#master_article").change(function(){

                   var id=$("#master_article").val();

                 var products=<?php echo json_encode($products); ?> ;
                 
                 let point = products.findIndex((item) => item.id == id);
              var unit=products[point]['unit'];
              if(unit!=null)
              $("#batch_size_unit").val(unit['name']);
        });
   
});

function setUom()
{
  var id=$(`#department_id`).val();
   var id1=$(`#item_id`).val();
  
   if(id=='' || id1=='')
    return ;
   
   var departs=JSON.parse(`<?php echo json_encode($departments); ?>`); 
   let point = departs.findIndex((item) => item.id == id);
  
      var items=departs[point]['items'];

      let point1 = items.findIndex((item) => item.id == id1);
       var unit=items[point1]['unit'];

       $(`#uom`).val(unit);
      
      // $('#item_id').empty().append('<option>Select any value</option>');

      //             for (var k =0 ;k < items.length ; k ++ )
      //              {                   

      //             $('<option value="'+items[k]['id']+'">'+items[k]['item_name']+'</option>').appendTo("#item_id");
      //               }


}



function setDepartItems()
{
  var id=$(`#department_id`).val();
   
   if(id=='')
    return ;

   var departs=JSON.parse(`<?php echo json_encode($departments); ?>`); 
   let point = departs.findIndex((item) => item.id == id);
  
      var items=departs[point]['items'];
      
      $('#item_id').empty().append('<option value="" >Select any value</option>');

                  for (var k =0 ;k < items.length ; k ++ )
                   {                   

                  $('<option value="'+items[k]['id']+'">'+items[k]['item_name']+'</option>').appendTo("#item_id");
                    }


}
 

       



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
  
   var net_total_qty=0, net_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#${id}total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#${id}total_qty_${i}`).text();
       var qty=$(`#${id}qty_${i}`).text();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;
      }
       

   }

    //net_qty= net_qty.toFixed(3);
     //net_total_qty= net_total_qty.toFixed(3);
     
   $(`#${id}net_total_qty`).text(net_total_qty);
   $(`#${id}net_qty`).text(net_qty);
     

}




function addItem(type='')
{
   var id='',type1=''; 
  if(type=='packing')
    {id='p_'; type1='packing';}
  else
    type1='raw';


    
    var item_uom=$(`#${id}uom`).val();
    var item_id=$(`#${id}item_id`).val();
    var item_name=$(`#${id}item_id option:selected`).text();


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
     
     if(item_id=='' || unit=='' || qty=='' )
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



           $(`#${id}item_add_error`).show();
           $(`#${id}item_add_error_txt`).html(err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=this.row_num;   


     var txt=`
     <tr ondblclick="(editItem(${row},'${type}'))" id="${row}">
      
     
     <input type="hidden" form="production_standard_form" id="${id}item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="production_standard_form" id="${id}type_${row}" name="types[]" value="${type1}"  >
     <input type="hidden" form="production_standard_form" id="${id}item_stage_id_${row}" name="item_stage_ids[]"  value="${stage_id}"  >
     <input type="hidden" form="production_standard_form" id="${id}units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="production_standard_form" id="${id}qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="production_standard_form" id="${id}p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="production_standard_form" id="${id}sorts_${row}" name="sort[]"  value="${sort}">

     <input type="hidden" form="production_standard_form" id="${id}mfs_${row}" name="mf[]"  value="${mf}">
     
     <td></td>
    
     <td id="${id}item_name_${row}">${item_name}</td>

    

     <td id="${id}item_stage_text_${row}">${stage_text}</td>
      
       
       
     <td id="${id}unit_${row}">${unit}</td>
     <td id="${id}item_uom_${row}">${item_uom}</td>
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
   


     $(`#${id}item_id`).val('');
      $(`#${id}item_id`).trigger('change');

  $(`#${id}item_stage`).val('-1');
  $(`#${id}uom`).val('');
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

  var item_uom=$(`#${id}uom`).val();
    var item_id=$(`#${id}item_id`).val();
    var item_name=$(`#${id}item_id option:selected`).text();

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
     
     if(item_id=='' ||  unit=='' || qty=='' )
     {
        var err_name='',err_location='',err_unit='',err_qty='';
           
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
           $("#item_add_error_txt").html(err_name+'  '+err_unit+' '+err_qty);

     }
     else
     {
     
       
       $(`#${id}item_id_${row}`).val(item_id);
        $(`#${id}item_stage_id_${row}`).val(stage_id);
        $(`#${id}units_${row}`).val(unit);
        $(`#${id}qtys_${row}`).val(qty);
        $(`#${id}p_ss_${row}`).val(p_s);
        $(`#${id}sorts_${row}`).val(sort);

      
      
      $(`#${id}item_name_${row}`).text(item_name);
      $(`#${id}item_stage_text_${row}`).text(stage_text);
      
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
  

  
  $(`#${id}item_id`).val('');
  $(`#${id}item_id`).trigger('change');
$(`#${id}item_stage`).val('-1');
  $(`#${id}uom`).val('');
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
   
   var item_id=$(`#${id}item_id_${row}`).val();
   
   var item_uom=$(`#${id}item_uom_${row}`).text();

   var departs=JSON.parse(`<?php echo json_encode($departments); ?>`); 
       var depart_id=-1; index=-1;
   for (var i =0; i < departs.length ; i++) {
         
      var items=departs[i]['items'];
      let point = items.findIndex((item) => item.id == item_id);
      if(point>0)
         {depart_id=departs[i]['id']; index=i; break;}
            
   }

       $(`#${id}department_id`).val(depart_id);
   
  
        //var items=departs[index]['items'];
         $(`#${id}department_id`).trigger('change');
   
   $(`#${id}item_id`).val(item_id);
   $(`#${id}item_id`).trigger('change');

   
   
  

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






function addStages()
{

   var product_id=$("#master_article").val();
   $('#item_stage').empty().append('<option selected="selected" value="-1">Select Stage</option>');

  if(product_id==''  )
     {
      $("#stages_body").html('');

        return ;

     }

     else
     {
         
       $.ajax({
               type:'get',
               url:'{{ url("get/product/procedure") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     product_id: product_id,
                  

               },
               success:function(data) {

                procedure=data;
                //alert(JSON.stringify(procedure));
                if(procedure.length==0 )
     {
      $("#stages_body").html('');
       $('#procedure_id').val('');
        return ;
     }
                 $('#procedure_id').val(procedure['id']);
                 var stages=procedure['processes'];
              
              var stage_text='<ul>';
                  for (var k =0 ;k < stages.length ; k ++ )
                   {                   
                  
       
                var index = k;
    
                  var proces='<li><h4>'+stages[index]['process_name']+'</h4></li>';
             
     $('<option value="'+stages[index]['id']+'">'+stages[index]['process_name']+'</option>').appendTo("#item_stage");
     $('<option value="'+stages[index]['id']+'">'+stages[index]['process_name']+'</option>').appendTo("#p_item_stage");

              for (var j =0 ;j < stages[index]['sub_stages'].length ; j ++ )
                   { 
                    $('<option value="'+stages[index]['sub_stages'][j]['id']+'">-'+stages[index]['sub_stages'][j]['process_name']+'</option>').appendTo("#item_stage");
                    $('<option value="'+stages[index]['sub_stages'][j]['id']+'">-'+stages[index]['sub_stages'][j]['process_name']+'</option>').appendTo("#p_item_stage");
                    }

                   stage_text+=proces;
                
                }//end for of stages

                stage_text+='</ul>';
                   $("#stages_body").html(stage_text);

               } //end fun success
             });//end ajax
     
     
 }//end else
}//end fun





      
    


</script>
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
@endsection  
