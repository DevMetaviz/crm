
@extends('layout.master')
@section('title', 'Edit Purchase Order')
@section('header-css')
<style type="text/css">

#selectedItems td input{
  margin: 0px;
  border: none;
  display: table-cell;
  width: 100%;
  background-color: transparent;
  box-sizing:border-box;
}

#selectedItems td {
  /*padding: 0px;*/
}

 
</style>
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')


      <div class="row default-header"  >
          <div class="col-sm-6">
            <h1>Purchase Order</h1>
           </div>
          <div class="col-sm-6 text-right">

             <button form="purchase_order_form" type="submit" class="btn btn-primary"><span class="fas fa-save"></span>Update</button>
             
             <button type="button" data-toggle="modal" class="btn btn-danger"  data-target="#modal-del">
                  <span class="fas fa-trash"></span>Delete
                </button>


            <a class="btn btn-transparent" href="{{url('purchase/order')}}" ><span class="fas fa-plus"></span>New</a>
            <a class="btn btn-transparent" href="{{url('purchase/order/history')}}" ><span class="fas fa-history"></span>History</a>

             <div class="btn-group">
                    <button type="button"  class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('purchase/order/report/'.$order['id'])}}" class="dropdown-item">Report</a></li>
                      <li><a href="{{url('purchase/order/report1/'.$order['id'])}}" class="dropdown-item">Report1</a></li>
                    </ul>
                  </div> 

            
          </div>
        </div>

           <ol class="breadcrumb default-breadcrumb"  >
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase</a></li>
              <li class="breadcrumb-item"><a href="#">Order</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
  @endsection

@section('content')
    <!-- Main content -->

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

<form role="form" id="delete_form" method="POST" action="{{url('purchase/order/delete/'.$order['id'])}}">
               
               @csrf    
    </form>

    <!-- Content Header (Page header) -->
    <form role="form" id="purchase_order_form" method="POST" action="{{url('/purchase/order/update')}}">
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
              <div class="col-md-4">
                  
                  
                   <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-file-alt mr-2"></i>Document</h4>

                <!-- /.form-group -->
                <div class="form-group row">
                  <label class="col-sm-4">Doc No.</label>
                  <input type="text" name="doc_no" id="doc_no"  class="form-control  col-sm-8" value="{{$order['doc_no']}}" required style="width: 100%;" readonly>
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">PO Type</label>
                  <select class="form-control  col-sm-8" name="po_type" id="po_type" style="width: 100%;">
                    <option value="">Select any value</option>
                    <option value="Local PO">Local PO</option>
                    <option value="Import PO">Import PO</option>
                    <option value="Services Contract">Services Contract</option>
                  </select>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4">Doc Date</label>
                  <input type="date" name="doc_date" class="form-control  col-sm-8" value="{{$order['doc_date']}}" required style="width: 100%;">
                  </div>

                    <div class="form-group row">
                  <label class="col-sm-4">Due Date</label>
                  <input type="date" name="due_date" class="form-control  col-sm-8" value="{{$order['due_date']}}"  style="width: 100%;">
                  </div>


                  
                   <div class="form-group row">
                  <label class="col-sm-4">Shipped Via</label>
                  <select class="form-control  col-sm-8" name="shipped_via" id="shipped_via" style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($methods as $mt)
                    <option value="{{$mt['id']}}">{{$mt['name']}}</option>
                    @endforeach
                   
                  </select>
                  </div>


                  <div class="form-group row">
                  <label class="col-sm-4">FOB Point</label>
                  <textarea name="fob_point" class="form-control  col-sm-8">{{$order['fob_point']}}</textarea>
                  </div>


                  <div class="form-group row">
                  <label class="col-sm-4">Terms</label>
                  <select class="form-control  col-sm-8" name="payment_type" id="payment_type" style="width: 100%;">
                    <option value="">Select any value</option>
                    <option value="Advance">Advance</option>
                    <option value="Cash">Cash</option>
                    <option value="Online">Online</option>
                  </select>
                  </div>


                <div class="form-group">
                  <input type="checkbox" name="posted" value="post" id="posted" class="" >
                  <label>Posted</label>
                  </div>



              </div>

                                
                <!-- /.form-group -->
                

               

               
                  

               
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">

                 <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-user mr-2"></i>Vendor</h4>

                   <div class="form-group">
                  <label class="">Vendor</label>
                  <select class="form-control select2" name="vendor_id" id="vendor_id" required style="width: 100%;">
                    <option value="">Select any vendor</option>
                    @foreach($vendors as $vendor)
                    <option value="{{$vendor['id']}}">{{$vendor['name']}}</option>
                    @endforeach
                   
                  </select>
                  </div>


    

                   <div class="form-group">
                  <label>Vendor Address</label>
                  <textarea name="vendor_address" id="vendor_address" class="form-control " readonly>{{$order['vendor_address']}}</textarea>
                </div>

                <div class="form-group">
                  <label>Vendor Mobile</label>
                <input type="text" class="form-control " value="{{$order['vendor_phone']}}" name="vendor_phone" id="vendor_phone" readonly>
                </div>

                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" class="form-control " >{{$order['remarks']}}</textarea>
                </div>


                     
                        </div>

                      
             

              </div>
              <!-- /.col -->

              <div class="col-md-4">

                 <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-calculator mr-2"></i>Others</h4>

                   <div class="form-group row">
                  <label class="col-sm-4">GST (%)</label>
                  <input type="number" step="any" name="gst_tax" value="{{$order['gst_tax']}}" class="form-control  col-sm-8" style="width: 100%;">
                  </div>

                   <div class="form-group row">
                  <label class="col-sm-4">W.H Tax (%)</label>
                  <input type="number" step="any" name="with_holding_tax" value="{{$order['with_holding_tax']}}" class="form-control  col-sm-8" style="width: 100%;">
                  </div>

                  

                    </div>

                        <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-box-open mr-2"></i>Demand</h4>

                         {{-- <div class="form-group">
                  <label>Departments</label>
                   <select class="form-control select2" name="demand_department" id="demand_department" style="width: 100%;" onchange="setDemands()">
                    <option value="">Select any value</option>
                    @foreach($locations as $depart)
                    <?php $s='';
                        $id=$order['demand_department_id'];
                        if($id==$depart['id'])
                          $s='selected';
                     ?>
                    <option value="{{$depart['id']}}" {{$s}}><span>{{$depart['name']}}</span></option>
                    @endforeach
                  </select>
                  </div>--}}


                          <div class="form-group">
                  <label>Demand</label>
                   <select class="form-control select2" name="demand" id="demand" style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($demands as $demand)
                    <option value="{{$demand['id']}}">{{$demand['doc_no'].' '.$demand['doc_date']}}</option>
                    @endforeach
                  </select>
                  <center><button style="margin-top:5px;" form="load_demand_items" class="btn btn-secondary" onclick="loadDemand()">Load</button></center>
                  </div>
                         </div>

                        

                     


            
              </div>
              <!-- /.col -->

            </div>
            <!-- /.row -->



<!-- Start Tabs -->
<div class="form-section mb-4 p-3">
<div class="nav-tabs-wrapper mb-3">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA"><i class="fas fa-list mr-2"></i>Items</a></li>
         <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB"><i class="fas fa-dollar-sign mr-2"></i>Expense</a></li> 
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC"><i class="fas fa-clipboard-list mr-2"></i>Terms & Conditions</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabD"><i class="fas fa-cog mr-2"></i>Others</a></li>
        
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="">
    <div class="tab-pane fade show active" id="tabA">
      
     
<!-----
       <div class="form-section-in border p-3 mb-3" >
                   <h4 class="form-section-title">Add Item</h4>

              
   <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" onchange="setDepartmentItem()" form="add_item" name="location" id="location" style="width: 100%;">
                    <option value="">---Select any value---</option>
                    @foreach($locations as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                 <div class="col-md-3">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="" id="item_code">
      
    
 
  
</div>
</div>

                 <div class="col-md-1">
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="text" form="add_item" name="stock" id="stock" onchange="" class="form-control" readonly style="width: 100%;">
                </div>
              </div>


                 <div class="col-md-1">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control" form="add_item" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
                    
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" min="1" value="1" form="add_item" name="qty" id="qty" onchange="setTotalQty()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" form="add_item" name="p_s" id="p_s" value="1"  onchange="setTotalQty()" class="form-control" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" form="add_item" name="total_qty" id="total_qty" min="1" value="1"  class="form-control" required="true" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Current Rate</label>
                  <input type="number" form="add_item" name="current_rate" id="current_rate" onchange="setRate()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

               <div class="col-md-1">
                    <div class="form-group">
                  <label>Pack Rate</label>
                  <input type="number" form="add_item" name="pack_rate" id="pack_rate" onchange="set_rate()" class="form-control" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Disc %</label>
                  <input type="number" form="add_item" name="disc" id="disc" onchange="discChange()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Rate</label>
                  <input type="number" form="add_item" name="rate" id="rate" onchange="" class="form-control" readonly style="width: 100%;">
                </div>
              </div>

             

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total</label>
                  <input type="number" form="add_item" name="total" id="total" onchange="" class="form-control"  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Tax %</label>
                  <input type="number" form="add_item" name="tax" id="tax" onchange="setTotalAndNet()" class="form-control"  style="width: 100%;">
                </div>
              </div>

               <div class="col-md-2">
                    <div class="form-group">
                  <label>Net Total</label>
                  <input type="number" form="add_item" name="net_total" id="net_total" onchange="" class="form-control" readonly style="width: 100%;">
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


</div> 



                 </div>--->

       <div class="table-responsive">
        <table class="table table-bordered table-hover" id="item_table" style="">
        <thead class="table-primary">
           <tr>
             <th>No.</th>
             <th>Location</th>
        
             <th style="min-width:250px ;">Item</th>
            
             <th>Variants</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <th>Unit Rate</th>
             <th>Pack Rate</th>
             <th>Disc %</th>
             <!--<th>Rate</th>
             <th>Total(PKR)</th>-->
             <th>Tax %</th>
            
             <th>Net Total</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems" style="">
          
          <?php $rows=1; ?>
          @foreach($order['items'] as $item)

                 <?php $variants='';  

                      if($item['variant_id'] > 0)
                      $variants=collect($item['variants'])->pluck('value')->implode(', ');
               
                 ?>
              

        <tr ondblclick="(editItem('{{$rows}}'))" id="{{$rows}}">
          <td></td>
          <td><input type="text"  id="{{'location_'.$rows}}" name="locations[]" form="purchase_order_form" value="{{$item['location_name']}}" readonly ><input type="hidden"  id="{{'location_id_'.$rows}}" name="location_ids[]" form="purchase_order_form" value="{{$item['location_id']}}"  ></td>
         
          <td><input type="text" form="purchase_order_form"  id="{{'item_name_'.$rows}}" name="items_name[]" form="purchase_order_form" style="border: none;" value="{{$item['name']}}" readonly ><input type="hidden" form="purchase_order_form"  id="{{'item_id_'.$rows}}" name="items_id[]" value="{{$item['id']}}" readonly ></td>

          <td><input type="text" form="purchase_order_form"  id="{{'item_variant_'.$rows}}"  form="purchase_order_form" style="border: none;" value="{{$variants}}" readonly ><input type="hidden" form="purchase_order_form"  id="{{'item_variant_'.$rows}}" name="variant_ids[]" value="{{$item['variant_id']}}" readonly ></td>
          
          <!----<td><input type="text" form="purchase_order_form" id="{{'uom_'.$rows}}" name="" value="{{$item['uom']}}" readonly ></td>-->
          <td><input type="text" form="purchase_order_form"  id="{{'unit_'.$rows}}" name="units[]" value="{{$item['unit']}}" readonly ></td>
          <td><input type="number"  id="{{'qty_'.$rows}}" form="purchase_order_form" name="qtys[]" value="{{$item['quantity']}}"  ></td>
          <td><input type="number"  id="{{'p_s_'.$rows}}" form="purchase_order_form" name="p_s[]" value="{{$item['pack_size']}}" readonly ></td>
          <td><input type="number"  id="{{'total_qty_'.$rows}}" form="purchase_order_form" name="total_qty[]" value="{{$item['total_qty']}}" readonly ></td>
           <td><input type="number" form="purchase_order_form" id="{{'unit_rate_'.$rows}}" name="unit_rate[]" value="{{$item['unit_rate']}}"  ></td>
           <td><input type="number" form="purchase_order_form" id="{{'pack_rate_'.$rows}}" name="pack_rate[]" value="{{$item['pack_rate']}}"  ></td>
           <td><input type="number" form="purchase_order_form" id="{{'disc_'.$rows}}" name="disc[]" value="{{$item['discount']}}"  ></td>
           <!---<td><input type="text"  id="{{'rate_'.$rows}}" name="rate[]" form="purchase_order_form" value="{{$item['rate']}}" readonly ></td>-->
         <!--  <td><input type="text" form="purchase_order_form" id="{{'total_'.$rows}}" name="total[]" value="{{$item['total']}}" readonly ></td>-->
            <td><input type="number" form="purchase_order_form" id="{{'tax_'.$rows}}" name="tax[]" value="{{$item['tax']}}"  ></td>
            
            <td><input type="number"  id="{{'net_total_'.$rows}}" form="purchase_order_form" name="net_total[]" value="{{$item['net_total']}}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem('{{$rows}}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
     <?php $rows++; ?>
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
            <th></th>
            <th id="net_qty">{{$order['total_net_qty']}}</th>
            <th></th>
            <th></th>
            
           
            <th></th>
            <th></th>
          
            <th id="net_total_amount">{{$order['total_net_amount']}}</th>
            <th></th>
          </tr>
        </tfoot>
      </table>
      </div>
     
      <div class="" >

    <div class="mb-2" >   
    <input type="hidden" name="items_check" id="items_check" value="1">
    </div>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal"><i class="fas fa-plus-circle"></i>Add Item</button>
     </div>


    <!----modal--->
 
     <div class="modal fade show" id="addItemModal"  aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Select Items</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body" >

              <div class="filter-items-search" >

                <select class="form-control" name="filter_department" >
                      <option value="">All Departments</option>
                    @foreach($locations as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                </select>

                <input class="form-control" name="filter_name" placeholder="Search by item name" >

              </div>

<div class="" style="max-height: 75vh;overflow-y: auto;"  >
          <table class="table table-bordered modal-table" >
          <thead class="table-light">
          <tr>
            <th>Department</th>
            <th>Item Name</th>
            <th>Variants</th>
          
            <th>Unit</th>
            <th>Quantity</th>
            <th>Pack Size</th>
            <th>Total</th>
            <th>Unit Rate</th>
            <th>Pack Rate</th>
            <th>Disc %</th>
            <th>Tax %</th>
            <th>Net</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody id="productsTableBody">
            
            @foreach($items as $item)

            <tr data-id="{{$item['id']}}"  data-department="{{$item['department_id']}}" data-variant="{{$item['variant_id']}}"  >
              <td>{{$item['department_name']}}</td>
              <td>{{$item['item_name']}}</td>
              <td>
                @if($item['variant_id'] > 0)
              {{ collect($item['variant_items'])->pluck('value')->implode(', ') }}
              @endif
              </td>
           
               <td>
              
                <select  name="unit" form="add_item"  class="form-control unit" >
                   <option value="loose">Loose</option>
                   <option value="pack">Pack</option>
                </select>
              </td>
              <td>
                <input type="number" step="any" form="add_item"  name="qty" class="form-control qty" >
                  <span class="error-msg text-danger small"></span>
              </td>
              <td>
                <select  name="p_s" form="add_item"  class="form-control pack_size" >
                   <option value="1">1</option>

                   @foreach($item['packs'] as $pk)
                   <option value="{{$pk}}" disabled >{{$pk}}</option>
                     @endforeach

                </select>
                <span class="error-msg text-danger small"></span>
              </td>
              <td><input type="number" step="any" form="add_item"  name="total_qty" class="form-control total_qty" readonly ></td>

               <td>
                <input type="number" step="any" form="add_item"  name="unit_rate" class="form-control unit_rate"  >
                <span class="error-msg text-danger small"></span>
               </td>

               <td><input type="number" step="any" form="add_item"  name="pack_rate" class="form-control pack_rate"  ></td>
               <td><input type="number" step="any" form="add_item"  name="disc" class="form-control disc"  ></td>
               <td><input type="number" step="any" form="add_item"  name="tax" class="form-control tax"  ></td>
               <td><input type="number" step="any" form="add_item"  name="net_total" class="form-control net_total" readonly ></td>
              <td>
                <button type="button" class="btn btn-success" onclick="addItem(this)" >Add</button>
              </td>
            </tr>

            @endforeach

          </tbody>
        </table>
</div>



            
            </div>
            <div class="modal-footer justify-content-between-1">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <!---<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    <!-----modal----->
     
        
    </div>
    

    <div class="tab-pane fade" id="tabB">

     <div class="row">
              <div class="col-md-7">
               
                    <div class="form-section-in border p-3 mb-3" >
                   <h4 class="form-section-title">Add Expenses</h4>

              
    
   <div id="expense_add_error" style="display: none;"><p class="text-danger" id="expense_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-5">
                    <div class="form-group mb-0">
                  <label>Expenses</label>
                  <select class="form-control select2" form="add_expense" name="expense" id="expense" style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($expenses as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
               
               

              

              <div class="col-md-1 bt-col">
                    <div class="form-group mb-0">
                    <br>
                  <button type="button" form="add_expense" class="btn" id="add_expense_btn" style="width: 100%;" onclick="addExpense()">
                  <span class="fa fa-plus-circle text-info"></span>
                  </button>
                </div>
              </div>


</div> <!--end row-->



                 </div>
              
                  
                


                
                  
                 
                   
                  


                 

                   <table class="table table-hover" >

                  <thead class="table-primary">
                <tr class="">
                <th class="">Expenses</th>
                <th class="">Amount</th>
                <th></th>
                </tr>
                    </thead>   

                    <tbody id="expenses_body" >   

                     <?php $exp_row=1; ?>
                 @foreach($order['expenses'] as $exp)



                 <tr class="" id="{{'exp_'.$exp_row}}">
                
                  <td>{{$exp['name']}}</td>

                  <td>
                  <input type="hidden" name="expense_ids[]" form="purchase_order_form" id="{{'exp_id_'.$exp_row}}" value="{{$exp['id']}}" >
                  <input type="number" step="any" value="{{$exp['pivot']['amount']}}" name="exp_amount[]" class="form-control m-1" form="purchase_order_form" id="{{'exp_amount_'.$exp_row}}"   onchange="" style="width: 100%;">
                  </td>

                  <td>
                    <button type="button" class="btn" onclick="removeExpense('{{$exp_row}}')"><span class="fa fa-minus-circle text-danger"></span></button>
                  </td>

                 </tr>
                  
                  <?php $exp_row++; ?>
                 @endforeach


                    </tbody>


                  </table>


                
               
                
                
              </div>
              
        </div>
      
    </div> <!--tab expense-->

    <div class="tab-pane fade" id="tabC">
<div class="row">
              <div class="col-md-2">
        <label>Terms & Conditons</label>
      </div>
        <div class="col-md-3">
      <div class="form-group">
                  
                  <select class="form-control" name="terms_cond" id="terms_cond" onchange="select_terms_box()" style="width: 100%;">
                    <option value="terms">Terms & Conditons</option>
                    <option value="payment">Payment Terms</option>
                    <option value="delivery">Delivery Terms</option>
                   
                  </select>
                </div>
              </div>
            </div>
        
       <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                 
                  <textarea class="form-control" rows="5" name="terms" id="terms" placeholder="Terms & Conditions">{{$order['terms']}}</textarea>
                  <textarea class="form-control" rows="5" name="delivery_terms" id="delivery_terms" placeholder="Delivery Terms Here">{{$order['delivery_terms']}}</textarea>
                  <textarea class="form-control" rows="5" name="payment_terms" id="payment_terms" placeholder="Payment Terms Here">{{$order['payment_terms']}}</textarea>
                </div>
              </div>
        </div>
      
    </div>

    <div class="tab-pane fade" id="tabD">
      
      <div class="row">
           <div class="col-sm-4">
             
            <div class="form-group row">
                  <label class="col-sm-4">Order By:</label>
                   <select class="form-control select2 col-sm-8" name="order_by" id="order_by" onchange="setDesignation()" style="">
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">Designation</label>
                <input type="text" class="form-control col-sm-8" value="" name="designation_order_by" id="designation_order_by" readonly>
                </div> 

                  <div class="form-group row">
                  <label class="col-sm-4">Approved By:</label>
                   <select class="form-control select2 col-sm-8" name="approved_by" id="approved_by" onchange="setDesignation1()">
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
                 

                  </div>
                </div>

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



$.validator.addMethod("atLeastOneItem", function(value, element) {
    return $("#selectedItems tr").length > 0;  // true if at least 1 row
}, "Please add at least one item.");


   $('#purchase_order_form').validate({
  // Let the hidden items_check be validated (others can still be ignored)
  ignore: ":hidden:not(#items_check)",

  rules: {
    items_check: { atLeastOneItem: true }
  },
  messages: {},

  submitHandler: function (form) {
    form.submit();
  },

  errorElement: 'span',
  errorPlacement: function (error, element) {
    error.addClass('invalid-feedback');

    // Put the "no item selected" error under the items table
    if (element.attr('name') === 'items_check') {
      // If your table structure differs, tweak this line
      $('#selectedItems').closest('table').after(error);
    } else {
      // default placement for other fields
      const $group = element.closest('.form-group');
      if ($group.length) {
        $group.append(error);
      } else {
        element.after(error); // fallback
      }
    }
  },
  highlight: function (element) {
    $(element).addClass('is-invalid');
  },
  unhighlight: function (element) {
    $(element).removeClass('is-invalid');
  }
});

 
function afterItemsChanged() {
  $('#items_check').valid(); // triggers atLeastOneItem check
}


$(document).on("change keyup", ".qty, .pack_size, .unit, .unit_rate, .pack_rate, .disc, .tax", function () {
    let row = $(this).closest("tr");

    let unit = row.find(".unit").val();
    let qty = parseFloat(row.find(".qty").val()) || 0;
    let packSize = parseFloat(row.find(".pack_size").val()) || 1;

    let unitRate = parseFloat(row.find(".unit_rate").val()) || 0;
    let packRate = parseFloat(row.find(".pack_rate").val()) || 0;
    let disc = parseFloat(row.find(".disc").val()) || 0;
    let tax = parseFloat(row.find(".tax").val()) || 0;

    // --- Enable/Disable pack size options ---
    if (unit === "loose") {
        row.find(".pack_size option").prop("disabled", true);
        row.find(".pack_size option[value='1']").prop("disabled", false).prop("selected", true);
        packSize = 1;
    } else {
        row.find(".pack_size option").prop("disabled", false);
    }

    // --- Total Qty ---
    let totalQty = qty * packSize;
    row.find(".total_qty").val(totalQty);

    // --- Unit/Pack Rate Logic ---
    if (unit === "loose") {
        // user enters unit_rate -> pack_rate auto = unit_rate * packSize
        if ($(this).hasClass("unit_rate")) {
            packRate = unitRate * packSize;
            row.find(".pack_rate").val(packRate);
        } else if ($(this).hasClass("pack_rate")) {
            unitRate = packRate / packSize;
            row.find(".unit_rate").val(unitRate);
        }
    } else {
        // user enters pack_rate -> unit_rate auto = packRate / packSize
        if ($(this).hasClass("pack_rate")) {
            unitRate = packRate / packSize;
            row.find(".unit_rate").val(unitRate);
        } else if ($(this).hasClass("unit_rate")) {
            packRate = unitRate * packSize;
            row.find(".pack_rate").val(packRate);
        }
    }

    // --- Calculate Gross ---
    let gross = unitRate * totalQty;

    // --- Apply Discount (percentage) ---
    let discountAmount = (gross * disc) / 100;
    let afterDisc = gross - discountAmount;

    // --- Apply Tax (percentage) ---
    let taxAmount = (afterDisc * tax) / 100;
    let netTotal = afterDisc + taxAmount;

    // --- Set values ---
    row.find(".net_total").val(netTotal.toFixed(2));
});





  $(document).ready(function() {
    function filterRows() {
        let dept = $('[name="filter_department"]').val().trim().toLowerCase();
        let name = $('[name="filter_name"]').val().trim().toLowerCase();

        $("#productsTableBody tr").each(function() {
            let rowDept = $(this).data("department").toString().toLowerCase();
            let rowName = $(this).find("td:nth-child(2)").text().toLowerCase();

            // check both filters
            let deptMatch = (dept === "" || rowDept === dept);
            let nameMatch = (name === "" || rowName.includes(name));

            if (deptMatch && nameMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Run on change / input
    $('[name="filter_department"]').on("change", filterRows);
    $('[name="filter_name"]').on("keyup", filterRows);
});


var row_num=<?php echo json_encode( $rows ) ; ?>; 
var expense_row_num=<?php echo json_encode( $exp_row ) ; ?>; 
function getRowNum()
 {
  return this.row_num;
}

function setRowNum()
 {
   this.row_num++;
}

function getExpenseRowNum()
 {
  return this.expense_row_num;
}

function setExpenseRowNum()
 {
     this.expense_row_num++;
}


$(document).ready(function(){

  $('.select2').select2(); 

  

  var type= "{{ $order['payment_type']}}";

  $('#payment_type').val(type);

  var via= "{{ $order['shipped_via']}}";

  $('#shipped_via').val(via);

   var id= "{{ $order['vendor_id']}}";

   setDefault();

  $('#vendor_id').val(id);
  $('#vendor_id').trigger('change');

  /*$('#purchase_order_form').submit(function(e) {

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
             
             
  });*/


   
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

         var let={code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit};
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
    fieldValue: 'code',
  filterOpen: true
    });

 }

$(document).ready(function(){

  $('#disp_status').val('{{$order['dispatched_status']}}');
  $('#po_type').val('{{$order['po_type']}}');

  $('#demand').val('{{$order['purchasedemand_id']}}');
  $('#demand').trigger('change');
  
  value="{{$order['posted'] }}"
   
   
   if(value=="post")
   {
    
  $('#posted').prop("checked", true);
   
   }
    else{
      $('#posted').prop("checked", false);
  
    } 


  $("#vendor_name").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#vendor_tabel_body tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  var items=<?php echo json_encode($inventories); ?> ;

 setInventory(items);
  
  $("#payment_terms").hide();
  $("#delivery_terms").hide();

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

function setVendorDetail()
{
  var vendor_id=$('#vendor_id').val();
   
  $.ajax({
               type:'get',
               url:`{{ url("/get/vendor/") }}`,
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     vendor_id: vendor_id,
                  

               },
               success:function(data) {
                 

                 $('#vendor_phone').val(data['mobile']);
                 $('#vendor_address').val(data['address']);

               }
             });

}

function select_vendor(name,id)
{

    var vendor=$("#vendor_name").val();
   if(vendor==name)
      return;

    $("#vendor_name").val(name);
    $("#vendor_id").val(id);

    setVendorDetail();
//alert(name);
}




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

    discChange();
   setTotalAndNet();

}



function setNetQtyAndAmount()
{
  var rows=getRowNum();
   
   var net_qty=0.0 , net_amount=0.0;   
   for (var i =1; i <= rows ;  i++) { 
    
    if($(`#total_qty_${i}`). length == 0 || $(`#total_qty_${i}`). length < 0)
      continue;
    
       var qty=$(`#total_qty_${i}`).val();
      var amount=$(`#net_total_${i}`).val();
       
       
       

      if(qty=='' || qty==null)
        qty=0;
      if(amount=='' || amount==null)
        amount=0;

        net_qty +=  parseFloat (qty) ;

        net_amount +=  parseFloat (amount) ;

   }
   $(`#net_qty`).text(net_qty);
      $(`#net_total_amount`).text(net_amount);

}
function setTotalAndNet()
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
  
  var tax=$("#tax").val();
  if(tax=='')
    tax=0;
    tax_amount=total *(tax/100);
   var net_total= parseFloat(total) + parseFloat (tax_amount) ;
   net_total=net_total.toFixed(2);
   $("#net_total").val(net_total);  

   
}


function setRate()
{
  $("#pack_rate").val('');
   var current_rate=$("#current_rate").val();
   
     var disc=$("#disc").val();
   var rate=0;
   
   if(disc=='')
         disc=0;
       if(current_rate=='')
         current_rate=0;

        

       var d=current_rate * ( disc / 100 );
       rate=current_rate-d;
       rate=rate.toFixed(2);

       $("#rate").val(rate); 

     setTotalAndNet();

}

function set_rate()
{
  $("#current_rate").val('');
   var pack_rate=$("#pack_rate").val();
   var p_s=$("#p_s").val();
     var disc=$("#disc").val();
   var rate=0;
   
   if(disc=='')
         disc=0;
       if(pack_rate=='')
         pack_rate=0;

        var per=pack_rate / p_s ;

       var d=per * ( disc / 100 );
       rate=per - d;
       rate=rate.toFixed(2);

       $("#rate").val(rate); 

     setTotalAndNet();

}

function discChange()
{
   var current_rate=$("#current_rate").val();
    var pack_rate=$("#pack_rate").val();
     var disc=$("#disc").val();

   var rate=0;
   
   if(disc=='')
         disc=0;
       if(current_rate=='')
         current_rate=0;

       if(pack_rate=='')
         pack_rate=0;

       if(current_rate==0 && pack_rate==0)
        {
          $("#total").val('0');
          $("#net_total").val('0');
        }
        else if(current_rate!=0 && pack_rate==0)
        {
              setRate();
        }
        else if(current_rate==0 && pack_rate!=0)
        {
          set_rate();
        }
        else
        {
          set_rate();
        }

}


function checkItem(row='')
{
  var rows=getRowNum();
  for (var i =1; i <= rows ;  i++) {
   
     if ($(`#code_${i}`). length == 0 || $(`#code_${i}`). length < 0 )
     {
      continue;
     }
     if (row == i  )
     {
      continue;
     }
     var item_code=$("#item_code").val();

    

     var tbl_item_code=$(`#code_${i}`).val(); 

     if(item_code == tbl_item_code)
      return true;
     
  
   }
  return false;   
   
}

function updateItem(row)
{
  
 var item_code=$("#item_code").val();
  
  var location=$("#location").val();
   var location_text=$("#location option:selected").text();
   if(location=='')
    location_text='';

  var unit=$("#unit").val();
  var qty=$("#qty").val();

  var p_s=$("#p_s").val();
  var total_qty=$("#total_qty").val();
  var current_rate=$("#current_rate").val();
  var pack_rate=$("#pack_rate").val();

  var disc=$("#disc").val();
  var rate=$("#rate").val();
  var total=$("#total").val();
  var tax=$("#tax").val();
  var net_total=$("#net_total").val();

  var dbl_item=false;
  if(item_code!='')
  {
     dbl_item=checkItem(row);
  }
     
     if(item_code==''  || unit=='' || qty=='' || dbl_item==true)
     {
        var err_name='',err_unit='',err_qty='', err_dbl='';
           
           if(item_code=='')
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
           $("#item_add_error_txt").html(err_dbl+' '+err_name+'  '+err_unit+' '+err_qty);

     }
     else
     {

       $(`#code_${row}`).val(item_code);

 

                      $(`#location_id_${row}`).val(location);
                      $('#location').val(location_text);

                    $(`#unit_${row}`).val(unit);

                         $(`#qty_${row}`).val(qty);



                           $(`#p_s_${row}`).val(p_s);
 
                         $(`#total_qty_${row}`).val(total_qty);
  
                             $(`#current_rate_${row}`).val(current_rate);
  
                        $(`#pack_rate_${row}`).val(pack_rate);
 
                       $(`#disc_${row}`).val(disc);
                        $(`#rate_${row}`).val(rate);
  
                            $(`#total_${row}`).val(total);
  
                             $(`#tax_${row}`).val(tax);
  
                         $(`#net_total_${row}`).val(net_total);
  

     $.ajax({
               type:'get',
               url:'{{ url("/inventory/item/") }}',
               data:{
                    
                    
                    
                     item_code : jQuery('#item_code').val(),
                      

               },
               success:function(data) {
                name='#item_name_'+row;
              
                
                uom='#uom_'+row;
              
                id='#item_id_'+row;
                size_value='',uom_value='',color_value='';
                
                  
            
            
                if(data['unit']!=null)
                  uom_value=data['unit']['name'];
 //var name=$(id).val(); alert(name);
                   // alert(JSON.stringify(data));
                    $(name).val(data['item_name']);
                    
                    $(id).val(data['id']);
                    
                    $(uom).val(uom_value);
               }

             });

  
 $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');
  $("#item_name").val('');
  $("#item_id").val('');
  $("#location").val('');
  
  $("#item_unit").val('');
  $("#item_code").val('');
  $("#unit").val('loose');
  $("#qty").val('1');

  $("#p_s").val('1');
  $("#total_qty").val('1');
  $("#current_rate").val('');
  $("#pack_rate").val('');

  $("#disc").val('');
  $("#rate").val('');
  $("#total").val('');
  $("#tax").val('');
  $("#net_total").val('');

  $('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

            $('#add_item_btn').attr('onclick', `addItem()`);
       setNetQtyAndAmount();
   }

  }// update item


function addItem(button) {
  

   let $row = $(button).closest("tr");

     $row.find(".error-msg").text("");

    // Data attributes
    let item_id   = $row.data("id");
    let location  = $row.data("department");
    let variant_id   = $row.data("variant");

    // Text values
    let location_text = $row.find("td:eq(0)").text().trim();
    let item_name     = $row.find("td:eq(1)").text().trim();
    let variants    = $row.find("td:eq(2)").text().trim();

    // Input/select values (using names)
    let unit   = $row.find('[name="unit"]').val();
    let qty = $row.find('[name="qty"]').val();
    let p_s = $row.find('[name="p_s"]').val();

     var unit_rate=  $row.find('[name="unit_rate"]').val(); 
  var pack_rate= $row.find('[name="pack_rate"]').val(); 

  var disc=$row.find('[name="disc"]').val();  
  //var rate=$("#rate").val();
  //var total=$("#total").val();
  var tax=$row.find('[name="tax"]').val();  
  var net_total=$row.find('[name="net_total"]').val();  

   let valid = true;

    // Validation for qty
    if (!qty || qty <= 0) {
        $row.find('[name="qty"]').next(".error-msg").text("*Required");
        valid = false;
    }

    // Validation for pack size
    if (!p_s || p_s <= 0) {
        $row.find('[name="p_s"]').next(".error-msg").text("*Required");
        valid = false;
    }

     if (!valid) return;

    let total  = qty * p_s;

  var rows=getRowNum();   


  
   
   
    
     var txt=`<tr ondblclick="(editItem(${rows}))" id="${rows}">
     <td>

    
     </td>
     <td><input type="text"  id="location_${rows}" name="locations[]" form="purchase_order_form" value="${location_text}" readonly >
       <input type="hidden"  id="location_id_${rows}" name="location_ids[]" form="purchase_order_form" value="${location}"  >
       </td>
       <td><input type="text" form="purchase_order_form"  id="item_name_${rows}" name="items_name[]" form="purchase_order_form" value="${item_name}" readonly ><input type="hidden" form="purchase_order_form"  id="item_id_${rows}" name="items_id[]" value="${item_id}" readonly ></td>

 

      <td><input type="text" form="purchase_order_form"  id="item_variant_${rows}"  form="purchase_order_form" value="${variants}" readonly ><input type="hidden" form="purchase_order_form"  id="item_variant_id_${rows}" name="variant_ids[]" value="${variant_id}" readonly ></td>
     


           <td><input type="text" form="purchase_order_form"  id="unit_${rows}" name="units[]" value="${unit}" readonly ></td>

           <td><input type="number"  id="qty_${rows}" form="purchase_order_form" name="qtys[]" value="${qty}" readonly ></td>
     <td><input type="number"  id="p_s_${rows}" form="purchase_order_form" name="p_s[]" value="${p_s}" readonly ></td>
     <td><input type="number"  id="total_qty_${rows}" form="purchase_order_form" name="total_qty[]" value="${total}" readonly ></td>

       <td><input type="number" form="purchase_order_form" id="unit_rate_${rows}" name="unit_rate[]" value="${unit_rate}" readonly ></td>
       <td><input type="number" form="purchase_order_form" id="pack_rate_${rows}" name="pack_rate[]" value="${pack_rate}" readonly ></td>
       <td><input type="number" form="purchase_order_form" id="disc_${rows}" name="disc[]" value="${disc}" readonly ></td>

          
          <td><input type="number" form="purchase_order_form" id="tax_${rows}" name="tax[]" value="${tax}" readonly ></td>
          <td><input type="text"  id="net_total_${rows}" form="purchase_order_form" name="net_total[]" value="${net_total}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${rows})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

   

    $("#selectedItems").append(txt);

 

 

   afterItemsChanged();

    

          setNetQtyAndAmount();
            setRowNum(); 


  }

function addItem1()
{
  
  var item_code=$("#item_code").val();
  
  //var item_id=$("#item_id").val();
  var location=$("#location").val();
   var location_text=$("#location option:selected").text();
   if(location=='')
    location_text='';
  //var size=$("#item_size").val();
  //var color=$("#item_color").val();
  //var uom=$("#item_unit").val();
//var code=$("#item_code").val();
  var unit=$("#unit").val();
  var qty=$("#qty").val();

  var p_s=$("#p_s").val();
  var total_qty=$("#total_qty").val();
  var current_rate=$("#current_rate").val();
  var pack_rate=$("#pack_rate").val();

  var disc=$("#disc").val();
  var rate=$("#rate").val();
  var total=$("#total").val();
  var tax=$("#tax").val();
  var net_total=$("#net_total").val();

  var dbl_item=false;
  if(item_code!='')
  {
     dbl_item=checkItem();
  }
     
     if(item_code==''  || unit=='' || qty=='' || dbl_item==true)
     {
        var err_name='',err_unit='',err_qty='', err_dbl='';
           
           if(item_code=='')
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
           $("#item_add_error_txt").html(err_dbl+' '+err_name+'  '+err_unit+' '+err_qty);

     }
     else
     {


      var rows = getRowNum(); 
            
     var txt=`<tr ondblclick="(editItem(${rows}))" id="${rows}"><td></td><td><input type="text"  id="location_${rows}" name="locations[]" form="purchase_order_form" value="${location_text}" readonly ><input type="hidden"  id="location_id_${rows}" name="location_ids[]" form="purchase_order_form" value="${location}"  ></td><td><input type="text" form="purchase_order_form"  id="code_${rows}" name="codes[]" value="${item_code}" readonly ></td><td><input type="text" form="purchase_order_form"  id="item_name_${rows}" name="items_name[]" form="purchase_order_form" value="" readonly ><input type="hidden" form="purchase_order_form"  id="item_id_${rows}" name="items_id[]" value="" readonly ></td><td><input type="text" form="purchase_order_form" id="uom_${rows}" name="" value="" readonly ></td>
     <td><input type="text" form="purchase_order_form"  id="unit_${rows}" name="units[]" value="${unit}" readonly ></td><td><input type="text"  id="qty_${rows}" form="purchase_order_form" name="qtys[]" value="${qty}" readonly ></td>
     <td><input type="text"  id="p_s_${rows}" form="purchase_order_form" name="p_s[]" value="${p_s}" readonly ></td>
     <td><input type="text"  id="total_qty_${rows}" form="purchase_order_form" name="total_qty[]" value="${total_qty}" readonly ></td>
       <td><input type="text" form="purchase_order_form" id="current_rate_${rows}" name="current_rate[]" value="${current_rate}" readonly ></td><td><input type="text" form="purchase_order_form" id="pack_rate_${rows}" name="pack_rate[]" value="${pack_rate}" readonly ></td><td><input type="text" form="purchase_order_form" id="disc_${rows}" name="disc[]" value="${disc}" readonly ></td><td><input type="text"  id="rate_${rows}" name="rate[]" form="purchase_order_form" value="${rate}" readonly ></td>
          <td><input type="text" form="purchase_order_form" id="total_${rows}" name="total[]" value="${total}" readonly ></td>
          <td><input type="text" form="purchase_order_form" id="tax_${rows}" name="tax[]" value="${tax}" readonly ></td>
          <td><input type="text"  id="net_total_${rows}" form="purchase_order_form" name="net_total[]" value="${net_total}" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${rows})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

   

    $("#selectedItems").append(txt);

  
                  
     $.ajax({
               type:'get',
               url:'{{ url("/inventory/item/") }}',
               data:{
                    
                    
                    
                     item_code : jQuery('#item_code').val(),
                      

               },
               success:function(data) {
                name='#item_name_'+rows;
              
                
                uom='#uom_'+rows;
            
                id='#item_id_'+rows;
                size_value='',uom_value='',color_value='';
              
                
                if(data['unit']!=null)
                  uom_value=data['unit']['name'];
 //var name=$(id).val(); alert(name);
                   // alert(JSON.stringify(data));
                    $(name).val(data['item_name']);
                    
                    $(id).val(data['id']);
                    
                    $(uom).val(uom_value);
               }

             });

  
$("#item_code").val('');
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');

  $("#item_name").val('');
  $("#item_id").val('');
  $("#location").val('');
  
  
  
  $("#item_unit").val('');
  $("#item_code").val('');
  $("#unit").val('loose');
  $("#qty").val('1');

  $("#p_s").val('1');
  $("#total_qty").val('1');
  $("#current_rate").val('');
  $("#pack_rate").val('');

  $("#disc").val('');
  $("#rate").val('');
  $("#total").val('');
  $("#tax").val('');
  $("#net_total").val('');

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
   var item_code=$(`#code_${row}`).val();

   $('#item_code').val(item_code);
var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(item_name);


var location_id=$(`#location_id_${row}`).val();
$('#location').val(location_id);

var unit=$(`#unit_${row}`).val();
$('#unit').val(unit);

if(unit=='pack')
{
   document.getElementById('p_s').removeAttribute('readonly');
    document.getElementById('pack_rate').removeAttribute('readonly');
}

  var qty=$(`#qty_${row}`).val();
$('#qty').val(qty);


  var p_s=$(`#p_s_${row}`).val();
  $('#p_s').val(p_s);
  var total_qty=$(`#total_qty_${row}`).val();
  $('#total_qty').val(total_qty);
  var current_rate=$(`#current_rate_${row}`).val();
  $('#current_rate').val(current_rate);
  var pack_rate=$(`#pack_rate_${row}`).val();
  $('#pack_rate').val(pack_rate);
  var disc=$(`#disc_${row}`).val();
  $('#disc').val(disc);
  var rate=$(`#rate_${row}`).val();
  $('#rate').val(rate);
  var total=$(`#total_${row}`).val();
  $('#total').val(total);
  var tax=$(`#tax_${row}`).val();
  $('#tax').val(tax);
  var net_total=$(`#net_total_${row}`).val();
  $('#net_total').val(net_total);

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
    //$(this).remove();
    $(`#${row}`).remove();
    setNetQtyAndAmount();
      afterItemsChanged();
  
});

}

function select_terms_box()
{
  var term=$("#terms_cond").val();
  if(term=='terms')
  {
$("#payment_terms").hide();
  $("#delivery_terms").hide();
   $("#terms").show();
  }
  else if(term=='payment')
  {
$("#payment_terms").show();
  $("#delivery_terms").hide();
   $("#terms").hide();
  }
  else if(term=='delivery')
  {
    $("#payment_terms").hide();
  $("#delivery_terms").show();
   $("#terms").hide();
  }

}

function setDemands()
{
  var department_id=$('#demand_department').val();

  if(department_id=='')
     department_id=0;

  $.ajax({
               type:'get',
               url:'{{ url("/department/demands") }}' +'/' +department_id ,
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     //department_id: department_id,
                  

               },
               success:function(data) {

                var demands=data;

                

                opt_txt=`<option>Select any value</option>`;

                for (var i =0; i < demands.length ; i++) {
                  txt    = `<option value="${demands[i]['id']}">${demands[i]['doc_no']} ${demands[i]['doc_date']}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                }

                $('#demand').empty().append(opt_txt);

                  


               }
             });
}


function loadDemand()
{
  var demand = jQuery('#demand').val();

  if(demand!='')
  {

  $.ajax({
               type:'get',
               url:'{{ url("/get/demand/") }}',
               data:{
                    
                    
                    
                     demand : demand,
                      

               },
               success:function(data) {

                demand_id=data['id'];
                //vendor_id=data['vendor_id'];
                //vendor_name=data['vendor_name'];

              

                //$('#vendor_name').val(vendor_name);
                //$('#vendor_id').val(vendor_id);
                $('#demand').val(demand);
                var txt='';
                for (var i =0; i < data['items'].length  ; i++) {
                  var item = data['items'][i];
                    
                  var rows = getRowNum(); 
            
        let variants = '';

         if (item.variant_id > 0) {
         variants = item.variants.map(v => v.value).join(", ");
    
          }

       var txt1=`<tr ondblclick="(editItem(${rows}))" id="${rows}">
     <td>

    
     </td>
     <td><input type="text"  id="location_${rows}" name="locations[]" form="purchase_order_form" value="${item['location']}" readonly >
       <input type="hidden"  id="location_id_${rows}" name="location_ids[]" form="purchase_order_form" value="${item['location_id']}"  >
       </td>
       <td><input type="text" form="purchase_order_form"  id="item_name_${rows}" name="items_name[]" form="purchase_order_form" value="${item['item_name']}" readonly ><input type="hidden" form="purchase_order_form"  id="item_id_${rows}" name="items_id[]" value="${item['item_id']}" readonly ></td>

 

        <td><input type="text" form="purchase_order_form"  id="item_variant_${rows}"  form="purchase_order_form" value="${variants}" readonly ><input type="hidden" form="purchase_order_form"  id="item_variant_id_${rows}" name="variant_ids[]" value="${item['variant_id']}" readonly ></td>
     


           <td><input type="text" form="purchase_order_form"  id="unit_${rows}" name="units[]" value="${item['unit']}" readonly ></td>

           <td><input type="number"  id="qty_${rows}" form="purchase_order_form" name="qtys[]" value="${item['qty']}"  ></td>
     <td><input type="number"  id="p_s_${rows}" form="purchase_order_form" name="p_s[]" value="${item['pack_size']}" readonly ></td>
     <td><input type="number"  id="total_qty_${rows}" form="purchase_order_form" name="total_qty[]" value="${item['total_qty']}" readonly ></td>

       <td><input type="number" form="purchase_order_form" id="unit_rate_${rows}" name="unit_rate[]" value=""  ></td>
       <td><input type="number" form="purchase_order_form" id="pack_rate_${rows}" name="pack_rate[]" value=""  ></td>
       <td><input type="number" form="purchase_order_form" id="disc_${rows}" name="disc[]" value=""  ></td>

          
          <td><input type="number" form="purchase_order_form" id="tax_${rows}" name="tax[]" value=""  ></td>
          <td><input type="number"  id="net_total_${rows}" form="purchase_order_form" name="net_total[]" value="" readonly ></td>
     

         <td><button type="button" class="btn" onclick="removeItem(${rows})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;


   
         txt=txt+txt1;
    
              setRowNum();

                }

                  
                $("#selectedItems").html(txt);

                afterItemsChanged();

                  setNetQtyAndAmount();

                 

    

          

                
               }

             });//end ajax
  
}
     
}// end load item



function addExpense()
{
  
  
  var expense=$("#expense").val();
   var expense_text=$("#expense option:selected").text();
   if(expense=='')
      return ;


  var dbl_item=false;
  if(item_code!='')
  {
     dbl_item=checkExpense();
  }
     
     if( dbl_item==true)
     {
        var  err_dbl='';
           
           
           if(dbl_item==true)
           {
            err_dbl='Expense already added.';
           }



           $("#expense_add_error").show();
           $("#expense_add_error_txt").html(err_dbl);

     }
     else
     {


      var rows = getExpenseRowNum();


           



             var txt=`
             <tr class="" id="exp_${rows}">
               
                  <td class="">${expense_text}</td>

                   <td class="">
                  <input type="hidden" name="expense_ids[]" form="purchase_order_form" id="exp_id_${rows}" value="${expense}" >
                  <input type="number" step="any" value="0" name="exp_amount[]" class="form-control col-sm-3 m-1" form="purchase_order_form" id="exp_amount_${rows}"   onchange="" style="width: 100%;">
                  </td>

                   <td class="">
                    <button type="button" class="btn" onclick="removeExpense(${rows})"><span class="fa fa-minus-circle text-danger"></span></button>
                   </td>

                 </tr>
            `;
     

   

    $("#expenses_body").append(txt);

  

           $("#expense_add_error").hide();
           $("#expense_add_error_txt").html('');

           $("#expense").val('');
            setExpenseRowNum(); 
   
   }


     
}//add expense

function checkExpense(row='')
{
  var rows=getExpenseRowNum();
  for (var i =1; i <= rows ;  i++) {
   
     if ($(`#exp_${i}`). length == 0 || $(`#exp_${i}`). length < 0 )
     {
      continue;
     }
     if (row == i  )
     {
      continue;
     }
     var expense=$("#expense").val();
    

     var tbl_exp=$(`#exp_id_${i}`).val(); 
//alert(expense+' '+tbl_exp);
     if(expense == tbl_exp)
      return true;
     
  
   }
  return false;   
   
}


function removeExpense(row)
{
  
 
    $(`#exp_${row}`).remove();
    //setNetQtyAndAmount();
  

}


function setDefault()
{
  var or="{{$order['order_by']}}";
  var app="{{$order['approve_by']}}";


  if(or )
   {

  var id=or;
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);
//alert(emp);
   var emp=emps[point]['designation_id'];
    
    if(emp=='')
    $('#designation_order_by').val('');
     else
     {
      var emp=emps[point]['id'];
      $('#order_by').val(emp);
      $('#order_by').trigger('change');
        
        if(emps[point]['designation_id']!=null && emps[point]['designation_id']!='' && emps[point]['designation_id']!=0)
      {  var emp=emps[point]['designation']['name'];
         $('#designation_order_by').val(emp);
       }

     }

   }

   if(app   )
   {

  var id=app;
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);
//alert(emp);
   var emp=emps[point]['designation_id'];
    
    if(emp=='')
    $('#designation_approved_by').val('');
     else
     {
      var emp=emps[point]['id'];
      $('#approved_by').val(emp);
      $('#approved_by').trigger('change');
        
        if(emps[point]['designation_id']!=null && emps[point]['designation_id']!=''  && emps[point]['designation_id']!=0)
          {
            var emp=emps[point]['designation']['name'];
         $('#designation_approved_by').val(emp);
         }
     }

   }

}


function setDesignation()
{
  var id=$('#order_by').val();
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='')
    $('#designation_order_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_order_by').val(emp);
     }
}

function setDesignation1()
{
  var id=$('#approved_by').val();
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='')
    $('#designation_approved_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_approved_by').val(emp);
     }
}


// Function to recalc one row
function recalcRow(row, changedField = null) {
    let qty       = parseFloat($("#qty_" + row).val())       || 0;
    let pack_size = parseFloat($("#p_s_" + row).val())       || 0;
    let unit_rate = parseFloat($("#unit_rate_" + row).val()) || 0;
    let pack_rate = parseFloat($("#pack_rate_" + row).val()) || 0;
    let discount  = parseFloat($("#disc_" + row).val())      || 0;
    let tax       = parseFloat($("#tax_" + row).val())       || 0;
    let unit      = $("#unit_" + row).val();

    // --- Keep unit_rate and pack_rate in sync ---
    if (changedField === "unit_rate" && pack_size > 0) {
        // user changed unit rate → auto set pack rate
        pack_rate = unit_rate * pack_size;
        $("#pack_rate_" + row).val(pack_rate.toFixed(2));
    }
    else if (changedField === "pack_rate" && pack_size > 0) {
        // user changed pack rate → auto set unit rate
        unit_rate = pack_rate / pack_size;
        $("#unit_rate_" + row).val(unit_rate.toFixed(2));
    }

    // --- total qty ---
    let total_qty = qty * pack_size;
    $("#total_qty_" + row).val(total_qty);

    // --- rate logic ---
    let rate = unit_rate || (pack_rate && pack_size ? pack_rate / pack_size : 0);

    // discount
    let d_rate = rate - (discount / 100) * rate;

    // tax
    let t_rate = d_rate + (tax / 100) * d_rate;

    // net total
    let net_total = t_rate * total_qty;
    $("#net_total_" + row).val(net_total.toFixed(2));

     setNetQtyAndAmount();
}

// --- Trigger events ---
$(document).on("input", "input[name='unit_rate[]']", function () {
    let row = $(this).closest("tr").attr("id");
    recalcRow(row, "unit_rate");
});

$(document).on("input", "input[name='pack_rate[]']", function () {
    let row = $(this).closest("tr").attr("id");
    recalcRow(row, "pack_rate");
});

$(document).on("input change", "input[name='qtys[]'], input[name='p_s[]'], input[name='disc[]'], input[name='tax[]'], input[name='units[]']", function () {
    let row = $(this).closest("tr").attr("id");
    recalcRow(row);
});

</script>

@endsection  
  