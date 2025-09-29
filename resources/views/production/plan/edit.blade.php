
@extends('layout.master')
@section('title', 'Production Plan')
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
<form role="form" id="delete_form" method="POST" action="{{url('/delete/production-plan/'.$plan['id'])}}">
               @csrf    
    </form>
    <!-- Content Header (Page header) -->
    <form role="form" id="production_plan" method="POST" action="{{url('/production/plan/update')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$plan['id']}}" name="id"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Production Plan</h1>
            <button form="production_plan" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            
            <a class="btn" href="{{url('production/plan/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
            <a class="btn" href="{{url('production-plan')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <button type="button" data-toggle="modal" style="border: none;background-color: transparent;" data-target="#modal-del">
                  <span class="fas fa-trash text-danger">&nbsp</span>Delete
                </button>
            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/print/plan/'.$plan['id'])}}" class="dropdown-item">Print</a></li>
                      <li><a href="{{url('/print/plan/bmr/'.$plan['id'])}}" class="dropdown-item">All</a></li>
                    </ul>
                  </div>
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

          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Plan</li>
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
<div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>

             
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

                                 @if ($errors->has('error'))                       
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                                          </div>  
                                @endif
     

            <div class="row">
              <div class="col-md-4">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <div class="form-row">
                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No.</label>
                  <input type="text" form="production_plan" name="plan_no" class="form-control col-sm-8" value="{{$plan['plan_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <!-- <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Alias Name</label>
                  <input type="text" form="production_plan" name="text" class="form-control col-sm-8" style="width: 100%;">
                  </div>
                 </div> -->

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Plan Date</label>
                  <input type="date" form="production_plan" name="plan_date" class="form-control col-sm-8" value="{{$plan['plan_date']}}"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Demand</label>
                  <select form="production_plan" name="demand_id" id="demand_id" class="form-control col-sm-8" onchange="setDemandAtt()" >
                    <option value="">Select any value</option>
                    @foreach($demands as $de)
                    <?php $s='';
                         if($plan['demand_id']==$de['id'])
                          $s='selected';
                     ?>
                    <option value="{{$de['id']}}" {{$s}}>{{$de['doc_no']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>


                <!-- <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Start Date</label>
                  <input type="date" form="production_plan" name="start_date" class="form-control col-sm-8" value="{{date('Y-m-d')}}" style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Completion Date</label>
                  <input type="Date" form="production_plan" name="complete_date" class="form-control col-sm-8"  style="width: 100%;">
                  </div>
                </div> -->

                <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="purchase_demand" name="is_closed" value="1" id="is_closed" class=""  >&nbsp&nbspClosed</label>
                  </div>
                </div>


               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

                

               
                
              </div>
              <!-- /.col -->


              <div class="col-md-4">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                   <!-- <div class="form-row"> -->
                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <select form="production_plan" name="product_id" id="product_id" class="form-control col-sm-8 select2" onchange="setStd()" >
                    <option value="">Select any value</option>
                    <?php $key = array_search('1', array_column($departments, 'id')); ?>
                    @foreach($departments[$key]['items'] as $de)
                      <?php $s='';
                      if( $de['id']== $plan['product_id'])
                       $s='selected';
                        ?>
                    <option value="{{$de['id']}}" {{$s}} >{{$de['item_name']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="number" step="any" form="production_plan" name="pack_size_qty" id="pack_size_qty" class="form-control col-sm-6" value="{{$plan['product']['pack_size_qty']}}" readonly="" style="width: 100%;">
                  <input type="text" form="production_plan" name="pack_size" id="pack_size" class="form-control col-sm-2" value="{{$plan['product']['pack_size']}}" readonly style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Qty</label>
                  <input type="number" step="any" form="production_plan" name="batch_qty" id="batch_qty"  class="form-control col-sm-6" value="{{$plan['batch_qty']}}" onchange="setBatchSize()" required style="width: 100%;">
                  <input type="text" form="production_plan" name="uom" id="uom" class="form-control col-sm-2" value="@if($plan['product']['unit']!=''){{$plan['product']['unit']['name']}}@endif" readonly style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="number" step="any" form="production_plan" name="batch_size" id="batch_size" class="form-control col-sm-6" value="{{$plan['batch_size']}}" onchange="setQty()" required style="width: 100%;">
                  <input type="text" form="production_plan" name="dosage_form" id="dosage_form" class="form-control col-sm-2" value="" readonly style="width: 100%;">
                  </div>
                 </div>


             

              </fieldset>
            </div>
         
         @if($plan['batch_no']!='')
            <div class="col-md-4">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                   <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="production_plan" name="batch_no" id="batch_no" class="form-control col-sm-8" value="{{$plan['batch_no']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg Date</label>
                <input type="date"  form="production_plan" name="mfg_date" id="mfg_date" class="form-control col-sm-8" value="{{$plan['mfg_date']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Exp Date</label>
                  <input type="date"  form="production_plan" name="exp_date" id="exp_date" class="form-control col-sm-8" value="{{$plan['exp_date']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">MRP</label>
                  <input type="number" step="any" form="production_plan" name="mrp" id="mrp" class="form-control col-sm-8" value="{{$plan['mrp']}}"  required style="width: 100%;">
                  </div>
                 </div>


                  </fieldset>

                 


               </div>
               @endif



               <div class="col-md-4">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Remarks</legend>

                   <textarea form="production_plan" name="remarks" class="form-control">{{$plan['remarks']}}</textarea>
                 </fieldset>

                 


               </div>
            

            </div>
            <!-- /.row -->
            


<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Material</a></li>
        
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
         

         <?php $row=1; ?>
        
             @foreach($plan_items as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>,''))" id="{{$row}}">
     
     <td>
      <input type="hidden" form="production_plan" id="{{'pivot_id_'.$row}}"   name="pivot_ids[]" value="{{$item['pivot_id']}}"  >
      

     <input type="hidden" form="production_plan" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >
     
     <input type="hidden" form="production_plan" id="{{'item_stage_id_'.$row}}" name="item_stage_ids[]"  value="{{$item['stage_id']}}"  >
     <input type="hidden" form="production_plan" id="{{'units_'.$row}}" name="units[]"  value="{{$item['unit']}}">
     <input type="hidden" form="production_plan" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['qty']}}" >
     <input type="hidden" form="production_plan" id="{{'p_ss_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}">
     <input type="hidden" form="production_plan" id="{{'sorts_'.$row}}" name="sort[]"  value="{{$item['sort']}}">

     <input type="hidden" form="production_plan" id="{{'mfs_'.$row}}" name="mf[]"  value="{{$item['mf']}}">

     
     </td>
  
     <td id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>

     <td id="{{'item_stage_text_'.$row}}">{{$item['stage_name']}}</td>
 
      
     <td id="{{'unit_'.$row}}">{{$item['unit']}}</td>
      <td id="{{'item_uom_'.$row}}">{{$item['item_uom']}}</td>
     <td id="{{'qty_'.$row}}">{{$item['qty']}}</td>
     <td id="{{'p_s_'.$row}}">{{$item['pack_size']}}</td>
      
     
     <td id="{{'total_qty_'.$row}}">{{$item['total']}}</td>
     <td id="{{'sort_'.$row}}">{{$item['sort']}}</td>
     <?php
        $c='';
        if($item['mf']==1)
          $c='checked';
     ?>
     <td><input type="checkbox"  id="{{'mf_'.$row}}" {{$c}}  readonly  /></td>
     

         <td><button type="button" class="btn" onclick="removeItem(<?php echo $row; ?>)"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
     <?php $row+=1; ?>
     @endforeach
          
          
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
  
  var row_num=<?php echo json_encode($row); ?>;
  var item_std=<?php echo json_encode($std); ?>;


  $(document).ready(function() {
     
     $('.select2').select2(); 

     setNetQty();

     var close="{{$plan['is_closed']}}";
     if(close==1)
     $('#is_closed').prop('checked',true);
   else if(close==0)
     $('#is_closed').prop('checked',false);

  
  $('#production_plan').submit(function(e) {

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
   this.row_num++;
}

function getItemStd()
 {
  return this.item_std;
}
function setItemStd(std)
 {
   this.item_std=std;
}

function setDemandAtt()
 {
      var demand_id=$('#demand_id').val();
      if(demand_id=='')
        return ;

      var demands=<?php echo json_encode($demands); ?> ;
                 
      let point = demands.findIndex((item) => item.id == demand_id);
              var demand=demands[point];

               $("#batch_qty").val(demand['qty']);
            $("#product_id").val(demand['product_id']);
            $("#product_id").trigger('change');
           
                 return ;
              // $("#product_id").val(demand['item_id']);
              // $("#product_name").val(demand['item_name']);
              // $("#pack_size").val(demand['pack_size']);
              // $("#pack_size_qty").val(demand['pack_size_qty']);
              // $("#batch_qty").val(demand['qty']);
              // $("#uom").val(demand['uom']);
              // $("#batch_size").val(demand['batch_size']);
              
              // $(`#selectedItems`).html('');

              //var items=demands[point]['std']['items'];
               //alert(JSON.stringify(items));
              // for (var i =0;i< items.length ;  i++) {
              //   var item=items[i];
              //   insertItem(item['item_id'],item['item_name'],item['stage_id'],item['stage_name'],item['item_uom'],item['unit'],item['qty'],item['pack_size'],item['total'],item['sort'],item['mf']);
              // }
              
         
  }

   function setBatchSize()
   {
         var p=$("#pack_size_qty").val();
             var q =$("#batch_qty").val();
              
              var t=p * q ;
             $("#batch_size").val(t);
              setItems();
   }

   function setQty()
   {
      var p=$("#pack_size_qty").val();
             var b =$("#batch_size").val();
              
              var t= b / p ;
              t=Math.round(t);
             $("#batch_qty").val(t);
          setItems();
   }

  
function setItems()
   {
      var product_id=$('#product_id').val();
      if(product_id=='')
        return ;

      var std=getItemStd();
                
            
             var batch_size=$('#batch_size').val();
              var std_size=std['batch_size'];
              var items=std['items'];
               //alert(JSON.stringify(items));
              for (var k =0;k< items.length ;  k++) {
                var item=items[k];
                // insertItem(item['item_id'],item['item_name'],item['stage_id'],item['stage_name'],item['item_uom'],item['unit'],item['qty'],item['pack_size'],item['total'],item['sort'],item['mf']);
                   //alert(item[]);
                var row_num=getRowNum();

                  for (var i =1; i <= row_num ;  i++) {
                  if ($(`#${i}`). length > 0 )
                  {
                      
                      var item_id=$(`#item_id_${i}`).val();
                      
                      if(item_id==item['item_id'])
                      {
                        var unit=item['unit'];
                        //var qty=(( item['qty'] / std_size ) * batch_size).toFixed(4);
                        var qty =   Math.round( ( item['qty'] / std_size ) * batch_size *100)/100;
                          var pack_size=item['pack_size'];
                         //var total = (qty * pack_size) .toFixed(4) ;Math.round(t);
                         var total =   Math.round(qty * pack_size*100)/100;
                             
                         $(`#units_${i}`).val(unit);
                         $(`#qtys_${i}`).val(qty);
                         $(`#p_ss_${i}`).val(pack_size);

                         $(`#unit_${i}`).text(unit);
                         $(`#qty_${i}`).text(qty);
                         $(`#p_s_${i}`).text(pack_size);
                         $(`#total_qty_${i}`).text(total);
                         
                      }
                
                  }
                  }
                  
                  
              }
   }






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
 

       



function setPackSize()
{
 

  unit=$(`#unit`).val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s`).setAttribute('readonly', 'readonly');
  $(`#p_s`).val('1');
       setTotalQty(type);
   }
   else if( unit=='pack')
   document.getElementById(`p_s`).removeAttribute('readonly');
}

function setTotalQty() //in add item form
{
  

  qty=$(`#qty`).val();
  p_s=$(`#p_s`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;

   //total_qty= total_qty.toFixed(3);
   
   $(`#total_qty`).val(total_qty); 
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

    //net_qty= net_qty.toFixed(3);
     //net_total_qty= net_total_qty.toFixed(3);
     
   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
     

}

function insertItem(item_id,item_name,stage_id,stage_text,item_uom,unit,qty,p_s,total,sort,mf)
{

 

  var row=this.row_num;   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     <input type="hidden" form="production_plan" id="pivot_id_${row}" name="pivot_ids[]" value="0" readonly >

     <input type="hidden" form="production_plan" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
    <input type="hidden" form="production_plan" id="item_stage_id_${row}" name="item_stage_ids[]"  value="${stage_id}"  >
     <input type="hidden" form="production_plan" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="production_plan" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="production_plan" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="production_plan" id="sorts_${row}" name="sort[]"  value="${sort}">

     <input type="hidden" form="production_plan" id="mfs_${row}" name="mf[]"  value="${mf}">
     
     <td></td>
    
     <td id="item_name_${row}">${item_name}</td>

    

     <td id="item_stage_text_${row}">${stage_text}</td>
      
       
       
     <td id="unit_${row}">${unit}</td>
     <td id="item_uom_${row}">${item_uom}</td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${p_s}</td>

     
     
     <td id="total_qty_${row}">${total}</td>
     <td id="sort_${row}">${sort}</td>
     <td><input type="checkbox"  id="mf_${row}" readonly  /></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

      $(`#selectedItems`).append(txt);

       if(mf==1)
      $(`#mf_${row}`).prop("checked", true );

      this.row_num ++;
}


function addItem()
{
   


    
    var item_uom=$(`#uom`).val();
    var item_id=$(`#item_id`).val();
    var item_name=$(`#item_id option:selected`).text();


  var stage_id=$(`#item_stage`).val();
  var stage_text=$(`#item_stage option:selected`).text();
  
  if(stage_id=='-1')
    { stage_text='';  }



  var unit=$(`#unit`).val();
  var qty=$(`#qty`).val();
  var p_s=$(`#p_s`).val();
  var total=$(`#total_qty`).val();

  var sort=$(`#sort`).val();
  var mf=0; checked='false';

    if( $(`#mf`).prop('checked') == true )
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



           $(`#item_add_error`).show();
           $(`#item_add_error_txt`).html(err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     
     insertItem(item_id,item_name,stage_id,stage_text,item_uom,unit,qty,p_s,total,sort,mf);

   
     
      if(p_s==null)
        p_s='1';
     
   

   
    
   $(`#sort`).val('1');
   


     $(`#item_id`).val('');
      $(`#item_id`).trigger('change');

  $(`#item_stage`).val('-1');
  $(`#uom`).val('');
  $(`#unit`).val('loose');
  $(`#qty`).val('1');
  $(`#p_s`).val('1');
  $(`#total_qty`).val('1');

  

$(`#row_id`).val('');

  $(`#item_add_error`).hide();
           $(`#item_add_error_txt`).html('');

     
  document.getElementById(`p_s`).setAttribute('readonly', 'readonly');
  
          setNetQty();
           
   
   }
     
}//end add item

function updateItem(row)
{


  var item_uom=$(`#uom`).val();
    var item_id=$(`#item_id`).val();
    var item_name=$(`#item_id option:selected`).text();

  var stage_id=$(`#item_stage`).val();
  var stage_text=$(`#item_stage option:selected`).text();
  
  if(stage_id=='-1')
    { stage_text='';  }

  var unit=$(`#unit`).val();
  var qty=$(`#qty`).val();
  var p_s=$(`#p_s`).val();
  var total=$(`#total_qty`).val();
  var sort=$(`#sort`).val();
  var mf=0; checked='false';

    if( $(`#mf`).prop('checked') == true )
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
     
       
       $(`#item_id_${row}`).val(item_id);
        $(`#item_stage_id_${row}`).val(stage_id);
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        $(`#p_ss_${row}`).val(p_s);
        $(`#sorts_${row}`).val(sort);

      
      
      $(`#item_name_${row}`).text(item_name);
      $(`#item_stage_text_${row}`).text(stage_text);
      
      $(`#item_uom_${row}`).text(item_uom);
      $(`#unit_${row}`).text(unit);
        $(`#qty_${row}`).text(qty);
        $(`#p_s_${row}`).text(p_s);

       $(`#total_qty_${row}`).text(total_qty);

          $(`#sort_${row}`).text(sort);

          $(`#mfs_${row}`).val(mf);

          if(checked=='true')
          $(`#mf_${row}`).prop('checked',true);
          else
          $(`#mf_${row}`).prop('checked',false);
     
     
      if(p_s==null)
        p_s='';
  

  
  $(`#item_id`).val('');
  $(`#item_id`).trigger('change');
$(`#item_stage`).val('-1');
  $(`#uom`).val('');
  $(`#unit`).val('loose');
  $(`#qty`).val('1');
  $(`#p_s`).val('1');
  $(`#total_qty`).val('1');
  $(`#sort`).val("1" );

$(`#row_id`).val('');

  $(`#item_add_error`).hide();
           $(`#item_add_error_txt`).html('');


  document.getElementById(`p_s`).setAttribute('readonly', 'readonly');
 
   setNetQty();
  $(`#add_item_btn`).attr('onclick', `addItem('')`);
   
   }
     
}  //end update item


function editItem(row)
{
   
 


   var item_name=$(`#item_name_${row}`).text();
   
   var item_id=$(`#item_id_${row}`).val();
   
   var item_uom=$(`#item_uom_${row}`).text();

   var departs=JSON.parse(`<?php echo json_encode($departments); ?>`); 
   alert(JSON.stringify( departs));
       var depart_id=-1; index=-1;
   for (var i =0; i < departs.length ; i++) {
         
      var items=departs[i]['items'];
      let point = items.findIndex((item) => item.id == item_id);
      if(point>0)
         {depart_id=departs[i]['id']; index=i; break;}
            
   }

       $(`#department_id`).val(depart_id);
   
  
        //var items=departs[index]['items'];
         $(`#department_id`).trigger('change');
   
   $(`#item_id`).val(item_id);
   $(`#item_id`).trigger('change');

   
   
  

var stage_id=$(`#item_stage_id_${row}`).val();
$(`#item_stage`).val(stage_id);

var unit=$(`#unit_${row}`).text();
$(`#unit`).val(unit);


  var qty=$(`#qty_${row}`).text();
$(`#qty`).val(qty);


  var p_s=$(`#p_s_${row}`).text();
  $(`#p_s`).val(p_s);
  


  var total_qty=$(`#total_qty_${row}`).text();
  $(`#total_qty`).val(total_qty);

  var sort=$(`#sort_${row}`).text(); 
  $(`#sort`).val(sort);

var mf=$(`#mfs_${row}`).val();
if(mf==1)
$(`#mf`).prop('checked',true)
else 
  $(`#mf`).prop('checked',false)

  $(`#row_id`).val(row);

  $(`#add_item_btn`).attr('onclick', `updateItem(${row})`);

  if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s`).setAttribute('readonly', 'readonly');
  $(`p_s`).val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById(`p_s`).removeAttribute('readonly');

}

function removeItem(row)
{
  
  
    $(`#${row}`).remove();
      setNetQty();


}

function setStd()
{
  var product_id=$(`#product_id`).val();

  if(product_id!='')
  {
    var departs=JSON.parse(`<?php echo json_encode($departments); ?>`);
    let index = departs.findIndex((item) => item.id == '1');


    var items=departs[index]['items']; //alert(items);
      let point = items.findIndex((item) => item.id == product_id);
     $("#pack_size").val(items[point]['pack_size']);
      $("#pack_size_qty").val(items[point]['pack_size_qty']);
      $("#uom").val(items[point]['unit']);
        
        $(`#selectedItems`).html('');

         var p=$("#pack_size_qty").val();
             var q =$("#batch_qty").val();
              
              var batch_size=p * q ;
             $("#batch_size").val(batch_size);

// get std
        $.ajax({
               type:'get',
               url:'{{ url("/get/production/std") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     product_id: product_id,
                  
               },
               success:function(data) {

                setItemStd(data);

                std_size=data['batch_size'];
          //alert(JSON.stringify(data));
                for (var i =0;i< data['items'].length ;  i++) {
                var item=data['items'][i];
                qty=Math.round( item['qty']/std_size*batch_size*100)/100;

                

                pack_size=item['pack_size'];
                total=Math.round(qty * pack_size*100)/100;
                insertItem(item['item_id'],item['item_name'],item['stage_id'],item['stage_name'],item['item_uom'],item['unit'],qty,pack_size,total,item['sort'],item['mf']);
              }

               }
             });
        //end get std

  

    
  }

}



</script>

@endsection  
