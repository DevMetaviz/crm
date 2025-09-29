
@extends('layout.master')
@section('title', 'Edit Plan Ticket')
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
    <form role="form" id="ticket_form" method="POST" action="{{url('/plan-ticket/update')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token" id="_token" />
      <input type="hidden" value="{{$ticket['id']}}" name="ticket_id" id="ticket_id" />
        <input type="hidden" value="{{url('/')}}" name="base_url" id="base_url" /><!--for use in js-->
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Plan Ticket</h1>
            <button form="ticket_form" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('plan-ticket')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('plan/ticket/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>

             <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/ticket/master-formulation/report/'.$ticket['id'])}}" class="dropdown-item">Master Formulation</a></li>
                    </ul>
                  </div>


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
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$ticket['ticket_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Ticket Date</label>
                  <input type="date" form="ticket_form" name="ticket_date" class="form-control select2 col-sm-8" value="{{$ticket['ticket_date']}}"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" class="form-control select2 col-sm-8" value="{{$ticket['batch_no']}}" required style="width: 100%;">
                  </div>
                 </div>
              
              <?php $um='';
                      if(isset($ticket['product']['unit']['name']))
                          $um=$ticket['product']['unit']['name'];
                       ?>
                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="number" form="ticket_form" name="batch_size" class="form-control  col-sm-5" value="{{$ticket['batch_size']}}" id="batch_size" readonly  required style="width: 100%;">
                  <input type="text" form="ticket_form" name="batch_size_unit" class="form-control col-sm-3" value="{{$um}}" id="batch_size_unit" readonly  required style="width: 100%;">
                  </div>
                </div>

                

                <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="batch_close" value="1" id="batch_close" class=""  >&nbsp&nbspBatch Closed</label>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Total Production</label>
                  <input type="text" form="ticket_form" name="" class="form-control select2 col-sm-8" value="{{$ticket['total_production']}}" id="batch_size" readonly  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Current Stock</label>
                  <input type="text" form="ticket_form" name="" class="form-control select2 col-sm-8" value="{{$ticket['stock_current_qty']}}" id="batch_size" readonly  required style="width: 100%;">
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

                   <textarea form="ticket_form" name="remarks" class="form-control select2">{{$ticket['remarks']}}</textarea>
                 </fieldset>

                 <fieldset class="border p-4">
                   <legend class="w-auto">Production Plan</legend>
                     <select form="ticket_form" class="form-control select2" name="plan_id" id="plan_id" readonly onchange="" >
                       <option value="{{$ticket['plan']['id']}}">{{$ticket['plan']['text'].'~'.$ticket['plan']['plan_date']}}</option>
                     </select>
                     
                   </fieldset>


               </div>

               <div class="col-md-3">
                
                 

                  <a href="{{url('/production/list/'.$ticket['id'])}}" class="btn btn-success float-sm-right" >Production&nbsp&nbsp<span class="fa fa-plus-circle"></span></a>
                   
                  <a href="{{url('ticket/costing/'.$ticket['id'])}}" class="btn btn-success float-sm-right" >Costing&nbsp&nbsp<span class="fa fa-plus-circle"></span></a> 

                 


               </div>
            

            </div>
            <!-- /.row -->
            


<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Detail</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabStages">Stages</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabE">Raw Material</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabP">Packing Material</a></li>
        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabF">Request Material</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabG">Issued Material</a></li> -->
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabH">Other Detail</a></li>
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
                 <div class="form-group" >
        <label>Item</label>
         <select form="ticket_form" class="form-control" name="product_item_code" id="product_item_code" readonly onchange="" >
            <option value="{{$ticket['product']['id']}}">{{$ticket['product']['item_name']}}</option>
                     </select>
           </div>
           </div>
   <?php $avail=$ticket->getAvailQty(); ?>
           <div class="col-md-2">
                    <div class="form-group">
                  <label>Avail Qty</label>
                  <input type="number" min="0"  form="ticket_form" name="avail_qty" id="avail_qty" value="{{$avail}}" class="form-control select2" readonly required="true" style="width: 100%;">
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
                  <input type="number" value="{{$ticket['quantity']}}" min="0"  form="ticket_form" name="product_qty" id="product_qty" onchange="setProductTotalQty()" class="form-control select2" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1"  form="ticket_form" name="product_pack_size" id="product_pack_size" value="{{$ticket['pack_size']}}"  onchange="setProductTotalQty()" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>
 <?php $total=$ticket['quantity']*$ticket['pack_size']; ?>
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="{{$total}}" min="1" form="ticket_form" name="product_total_qty" id="product_total_qty" class="form-control select2" onchange="setEstimatedMaterial()" readonly style="width: 100%;">
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

    
          
             
             <div id="stages_body_new" class="row">
             <ul>
            @foreach($ticket['stages']->where('pivot.super_id','0') as $stage)
                          
                      
            <li>
              <h3><a href="{{url('plan-ticket/stage/'.$ticket['id'].'/'.$stage['pivot']['id'])}}">{{$stage['process_name']}}</a></h3>
            </li>
              
              @endforeach
            </ul>
            </div>

            <div id="stages_body" class="row">
                             
            </div>

      
    </div> <!-- End Tab Stages  -->

    

     <div class="tab-pane fade" id="tabE">

      <div class="row">
              <div class="col-md-12">
                
                <!-- <fieldset class="border p-4">
                   <legend class="w-auto">Article Detail</legend>

              
    
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
                    
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

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
                  <input type="hidden" name="row_id" id="row_id" >
                  <button type="button" form="add_item" id="add_item_btn" class="btn" onclick="addItem()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> 



                 </fieldset>-->
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
             <th>Issued Qty</th>
             <th>Sort Order</th>
             <th>M.F</th>
             <th></th>           </tr>
        </thead>
        <tbody id="selectedItems">
<?php $row=1; ?>
        
             @foreach($ticket->raw_material() as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>,''))" id="{{$row}}">

     <input type="hidden" form="ticket_form" id="{{'pivot_id_'.$row}}"   name="pivot_ids[]" value="{{$item['id']}}"  >
      
     <input type="hidden" form="ticket_form" id="{{'type_'.$row}}"   name="types[]" value="{{$item['type']}}"  >
     <input type="hidden" form="ticket_form" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >
     <input type="hidden" form="ticket_form" id="{{'item_stage_id_'.$row}}" name="item_stage_ids[]"  value="{{$item['stage_id']}}"  >
     <input type="hidden" form="ticket_form" id="{{'units_'.$row}}" name="units[]"  value="{{$item['unit']}}">

     <input type="hidden" form="ticket_form" id="{{'std_qtys_'.$row}}" name="std_qtys[]"  value="{{$item['std_qty']}}" >

     <input type="hidden" form="ticket_form" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['quantity']}}" >
     <input type="hidden" form="ticket_form" id="{{'p_ss_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}">
     <input type="hidden" form="ticket_form" id="{{'sorts_'.$row}}" name="sort[]"  value="{{$item['sort_order']}}">
     <input type="hidden" form="ticket_form" id="{{'mfs_'.$row}}" name="mf[]"  value="{{$item['is_mf']}}">
     
     <td></td>
     <td id="{{'item_code_'.$row}}">{{$item['item']['item_code']}}</td>
     <td id="{{'item_name_'.$row}}">{{$item['item']['item_name']}}</td>

    

           <?php 
             $name='';
           if(isset($item['process']['process_name']))
              $name=$item['process']['process_name'];
            ?>
     <td id="{{'item_stage_text_'.$row}}">{{$name}}</td>
       

    
       <td id="{{'item_uom_'.$row}}">@if($item['item']['unit']!=''){{$item['item']['unit']['name']}}@endif</td>
     <td id="{{'unit_'.$row}}">{{$item['unit']}}</td>
     <td id="{{'std_qty_'.$row}}">{{$item['std_qty']}}</td>
     <td id="{{'qty_'.$row}}">{{$item['quantity']}}</td>
     <td id="{{'p_s_'.$row}}">{{$item['pack_size']}}</td>
      <?php $t=$item['quantity']* $item['pack_size']; ?> 
     
     <td id="{{'total_qty_'.$row}}">{{$t}}</td>
     <?php $is=$ticket->item_issued_qty($item['item_id']); ?> 
     <td id="{{'total_issued_'.$row}}">{{$is}}</td>

     <td id="{{'sort_'.$row}}">{{$item['sort_order']}}</td>
     <?php
        $c='';
        if($item['is_mf']==1)
          $c='checked';
     ?>
     <td><input type="checkbox"  id="{{'mf_'.$row}}" {{$c}}  readonly  /></td>
     

         <td><!-- <button type="button" class="btn" onclick="removeItem(<?php //echo $row; ?>,'')"><span class="fa fa-minus-circle text-danger"></span></button> --></td>
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
             <th></th>
             <th id="net_std_qty">0</th>
             <th id="net_qty">0</th>
             <th></th>
             <th id="net_total_qty">0</th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

      
    </div> <!-- End TabE  -->

    <div class="tab-pane fade" id="tabP">


      <div class="row">
              <div class="col-md-12">
                
                 <!--<fieldset class="border p-4">
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
                  <input type="hidden" name="p_row_id" id="p_row_id" >
                  <button type="button" form="add_item" id="p_add_item_btn" class="btn" onclick="addItem('packing')">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> 



                 </fieldset>-->
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
             <th>Issued Qty</th>
             <th>Sort Order</th>
             <th>M.F</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="p_selectedItems">

          @foreach($ticket->packing_material() as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>,'packing'))" id="{{$row}}">

     <input type="hidden" form="ticket_form" id="{{'p_pivot_id_'.$row}}"   name="pivot_ids[]" value="{{$item['id']}}"  >
      
     <input type="hidden" form="ticket_form" id="{{'p_type_'.$row}}"   name="types[]" value="{{$item['type']}}"  >
     <input type="hidden" form="ticket_form" id="{{'p_item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >
     <input type="hidden" form="ticket_form" id="{{'p_item_stage_id_'.$row}}" name="item_stage_ids[]"  value="{{$item['stage_id']}}"  >
     <input type="hidden" form="ticket_form" id="{{'p_units_'.$row}}" name="units[]"  value="{{$item['unit']}}">

     <input type="hidden" form="ticket_form" id="{{'p_std_qtys_'.$row}}" name="std_qtys[]"  value="{{$item['std_qty']}}" >

     <input type="hidden" form="ticket_form" id="{{'p_qtys_'.$row}}" name="qtys[]"  value="{{$item['quantity']}}" >
     <input type="hidden" form="ticket_form" id="{{'p_p_ss_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}">
     <input type="hidden" form="ticket_form" id="{{'p_sorts_'.$row}}" name="sort[]"  value="{{$item['sort_order']}}">
      <input type="hidden" form="ticket_form" id="{{'mfs_'.$row}}" name="mf[]"  value="{{$item['is_mf']}}">
     
     <td></td>
     <td id="{{'p_item_code_'.$row}}">{{$item['item']['item_code']}}</td>
     <td id="{{'p_item_name_'.$row}}">{{$item['item']['item_name']}}</td>

     <?php 
             $name='';
           if(isset($item['process']['process_name']))
              $name=$item['process']['process_name'];
            ?>


     <td id="{{'p_item_stage_text_'.$row}}">@if($item['process']!=''){{$item['process']['process_name']}}@endif</td>
       
    
       <td id="{{'p_item_uom_'.$row}}">@if($item['item']['unit']!=''){{$item['item']['unit']['name']}}@endif</td>
     <td id="{{'p_unit_'.$row}}">{{$item['unit']}}</td>
     <td id="{{'p_std_qty_'.$row}}">{{$item['std_qty']}}</td>
     <td id="{{'p_qty_'.$row}}">{{$item['quantity']}}</td>
     <td id="{{'p_p_s_'.$row}}">{{$item['pack_size']}}</td>
      <?php $t=$item['quantity']* $item['pack_size']; ?> 
     
     <td id="{{'p_total_qty_'.$row}}">{{$t}}</td>
     <?php $is=$ticket->item_issued_qty($item['item_id']); ?> 
     <td id="{{'total_issued_'.$row}}">{{$is}}</td>
     <td id="{{'p_sort_'.$row}}">{{$item['sort_order']}}</td>
     <?php
        $c='';
        if($item['is_mf']==1)
          $c='checked';
     ?>
     <td><input type="checkbox"  id="{{'mf_'.$row}}" {{$c}}  readonly  /></td>
     

         <td><!-- <button type="button" class="btn" onclick="removeItem(<?php //echo $row; ?>,'packing')"><span class="fa fa-minus-circle text-danger"></span></button> --></td>
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
             <th></th>
             <th id="p_net_std_qty">0</th>
             <th id="p_net_qty">0</th>
             <th></th>
             <th id="p_net_total_qty">0</th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>


      
    </div> <!-- End TabP  -->


    <div class="tab-pane fade" id="tabF">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Request New Material</legend>

              
      
                   
                   <div class="row">

               

              

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
               Genrate Request For Material&nbsp&nbsp<span class="fa fa-arrow-right"></span>
              </button>

              <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Select</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
              
               <div class="form-row">
                 
                  <input type="hidden" form="request_material_form" name="ticket_id" value="{{$ticket['id']}}">

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Type</label>
                  <select form="request_material_form" class="form-control select2 col-sm-8" name="request_type" id="request_type"  >
                       <option value="raw">Raw Material</option>
                       <option value="packing">Packing Material</option>
                     </select>
                  </div>
                 </div>
                 

                 </div>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary float-sm-left" data-dismiss="modal">Close</button>
          <button type="submit" form="request_material_form" class="btn btn-success float-sm-right">Genrate</button>
        </div>
        
      </div>
    </div>
  </div>

  <!--End modal-->

              


</div> <!--end row-->



                 </fieldset>
              </div>

              <div class="col-md-12">
                 
                 @foreach($ticket['requisitions'] as $req)
                <p><a href="{{url('/requisition/request/edit/'.$req['id'])}}">{{$req['requisition_no']}}</a></p>
                @endforeach
                
              </div>
            </div>


     
      
    </div> <!-- End tabF  -->
   
    <div class="tab-pane fade" id="tabG">

      <div class="row">
          <div class="col-md-12">
                 
                 @foreach($ticket['issuances'] as $req)
                <p><a href="{{url('edit/issuance/'.$req['issuance_no'])}}">{{$req['issuance_no']}}</a></p>
                @endforeach
                
              </div>
      </div>
    </div>

    <div class="tab-pane fade" id="tabH">

      <div class="row">
          <div class="col-md-8">

            <div class="form-row">

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg. Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" class="form-control select2 col-sm-8" value="{{$ticket['mfg_date']}}"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Exp. Date</label>
                  <input type="date" form="ticket_form" name="exp_date" class="form-control select2 col-sm-8" value="{{$ticket['exp_date']}}"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">MRP</label>
                  <input type="number" step="any" form="ticket_form" name="mrp" class="form-control select2 col-sm-8" value="{{$ticket['mrp']}}"  style="width: 100%;">
                  </div>
                 </div>

                 <!-- <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Exp. Date</label>
                  <input type="date" form="ticket_form" name="exp_date" class="form-control select2 col-sm-8" value=""  style="width: 100%;">
                  </div>
                 </div> -->

            </div>
                 
                 
                
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

     <form role="form" id="request_material_form" method="get" action="{{url('request-material')}}">
              
    </form>

    
   
@endsection

@section('jquery-code')

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">
  
  var row_num=<?php echo $row; ?>;
  
 
  $(document).ready(function() {

     var batch_close='{{$ticket["batch_close"]}}';
     
       if(batch_close==1)
          $('#batch_close').prop('checked',true);
        if(batch_close==0)
          $('#batch_close').prop('checked',false);


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


function setEstimatedMaterial()
 {
    var plan_id= jQuery('#plan_id').val();
    var qty= jQuery('#product_total_qty').val();
    var item_combine=$('#product_item_code').val();
     //item_combine=item_combine.split('_');
   //var s=$("#product_item_dropdown").find(".inputpicker-input");
   //var item_name=s.val();
   var item_id=item_combine;

   //let point = this.products.findIndex((item) => item.item_name === item_name);
// value of index will be "1"
         //var std_id=this.products[point]['std_id'];
         <?php $std_id=''; ?>
   var std_id="{{$ticket->get_std_id()}}";

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

 
$(document).ready(function(){
  
      
      //alert(com); alert(s);
    

        var items=<?php echo json_encode($raw_items); ?> ;
      setInventory(items,'item_code');

      var items=<?php echo json_encode($packing_items); ?> ;
      setInventory(items,'p_item_code');
         
         setNetQty(); 
         setNetQty('packing');

        

               
});





 



      function setAvailQty() 
{
     var item_combine=$('#product_item_code').val();
     item_combine=item_combine.split('_');
   var s=$("#product_item_dropdown").find(".inputpicker-input");
   var item_name=s.val();
   document.getElementById("product_location").options.length = 0;
   $('<option value="'+item_combine[13]+'">'+item_combine[15]+'</option>').appendTo("#product_location");

   $("#product_location").val(item_combine[13]);

   $("#avail_qty").val(item_combine[17]);
    
    let point = this.products.findIndex((item) => item.item_name === item_name);
// value of index will be "1"
         var items=this.products[point]['materials'];
      
       
       //stages start
 
     var stages=this.products[point]['stages'];

      $('#stages').val(JSON.stringify( stages));

                 //start stages
                      // var stages=procedure['processes'];
               $('#item_stage').empty().append('<option selected="selected" value="-1">Select Stage</option>');
              var stage_text='';

                  for (var k =0 ;k < stages.length ; k ++ )
                   {                   
                  
       
                var index = k;
    
    
                  var getStagetxt=get_stage_text(stages[index]);
                stage_text+=getStagetxt;

     $('<option value="'+stages[index]['id']+'">'+stages[index]['process_name']+'</option>').appendTo("#item_stage");
                
                }//end for of stages
                   $("#stages_body").html(stage_text);
                 //end stages

                 //end stages

       
             

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
    //  net_total_qty= net_total_qty.toFixed(3);
    //  net_std_qty= net_std_qty.toFixed(3);
     
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

   var mf=item['mf'];
       var  checked='false';

    if( mf == 1 )
      { checked='true'; }

  var sort=item['sort'];
    var type=item['type'];


  var id='',type1=''; 
  if(type=='packing')
    {id='p_'; type1='packing';}
  else
    type1='raw';

     
        
     var row=this.row_num;   


     var txt=`
     <tr ondblclick="(editItem(${row},'${type}'))" id="${row}">
      
     <input type="hidden" form="ticket_form" id="${id}pivot_id_${row}" name="pivot_ids[]" value="0" readonly >

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
     <td></td>
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
      
      <input type="hidden" form="ticket_form" id="${id}pivot_id_${row}" name="pivot_ids[]" value="0" readonly >
     
     <input type="hidden" form="ticket_form" id="${id}item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="ticket_form" id="${id}type_${row}" name="types[]" value="${type1}"  >
     <input type="hidden" form="ticket_form" id="${id}item_stage_id_${row}" name="item_stage_ids[]"  value="${stage_id}"  >
     <input type="hidden" form="ticket_form" id="${id}units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="ticket_form" id="${id}std_qtys_${row}" name="std_qtys[]"  value="" >
     <input type="hidden" form="ticket_form" id="${id}qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="ticket_form" id="${id}p_ss_${row}" name="p_s[]"  value="${p_s}">
     <input type="hidden" form="ticket_form" id="${id}sorts_${row}" name="sort[]"  value="${sort}">
     
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
     <td></td>
     <td id="${id}sort_${row}">${sort}</td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row},'${type}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='1';
     
   

    $(`#${id}selectedItems`).append(txt);

    
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
