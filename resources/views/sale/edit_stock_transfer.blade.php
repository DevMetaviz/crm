
@extends('layout.master')
@section('title', 'Edit Stock Transfer')
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
    <form role="form" id="purchase_demand" method="POST" action="{{url('/stock/transfer/update')}}" onkeydown="return event.key != 'Enter';" >
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$transfer['id']}}" name="id"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit Stock Transfer</h1>
            <button form="purchase_demand" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="submit" form="delete_form" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Delete</button>
            <a class="btn" href="{{url('/stock/transfer')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('stock/transfer/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Stock</a></li>
              <li class="breadcrumb-item active">Edit Transfer</li>
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
              <div class="col-md-3">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Document</legend>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Doc No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control select2" value="{{$transfer['doc_no']}}" readonly required style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>Doc Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control select2" value="{{$transfer['doc_date']}}" required style="width: 100%;">
                  </div>

                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="active" value="1" id="activeness" class=""  >
                  <label>Active</label>
                  </div>



              </fieldset>

                                
                <!-- /.form-group -->
               
                
              </div>
              <!-- /.col -->
              <div class="col-md-5">

                 <fieldset class="border p-4">
                   <legend class="w-auto">Customer</legend>

                  

           <div class="dropdown" id="from_customers_table_customer_dropdown">
        <label>From</label>
        <input class="form-control"  name="from_customer_id" id="from_customer_id" onchange="uploadInvoices()" required>
           </div>


           <div class="dropdown" id="to_customers_table_customer_dropdown">
        <label>To</label>
        <input class="form-control"  name="to_customer_id" id="to_customer_id" onchange="" required>
           </div>


           <div class="form-group">
                  <label>Products</label>
                  <select form="purchase_demand" name="product_id" id="product_id" class="form-control select2" onchange="uploadInvoices()">
                     <option value="">Select any product</option>
                     @foreach($products as $pr)
                     <option value="{{$pr['id']}}">{{$pr['item_name']}}</option>
                     @endforeach
                  </select>
                  </div>

               <div class="form-group">
                  <label>Delivery Challan</label>
                  <select form="purchase_demand" name="invoice_id" id="invoice_id" class="form-control select2" onchange="uploadSale()">
                     <option value="">Select any challan</option>
                     
                  </select>
                  </div>


                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control select2" >{{$transfer['remarks']}}</textarea>
                </div>

                


                     
                        </fieldset>

                      
             

              </div>
              <!-- /.col -->

              <div class="col-md-3">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Net Total</legend>

                <!-- /.form-group -->
                <!-- <div class="form-group">
                  <label>Disc.</label>
                  <input type="number" step="any" min="0" form="purchase_demand" name="disc" id="disc" class="form-control select2" value="" onchange="setNetBill()" style="width: 100%;">
                  </div> -->

                  <!-- <div class="form-group">
                  <input type="radio" form="purchase_demand" name="net_disc" value="flat" id="flat" class="" onchange="setNetBill()"  checked>
                  <label for="flat">Flat</label>
                  <input type="radio" form="purchase_demand" name="net_disc" value="percentage" id="percentage" onchange="setNetBill()" class=""  >
                  <label for="percentage">Percentage</label>
                  </div>
 -->

                <div class="form-group">
                  <label>Net Total(From)</label>
                  <input type="number" form="purchase_demand" name="from_net_bill" id="from_net_bill" class="form-control select2" value="" readonly  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Net Total(To)</label>
                  <input type="number" form="purchase_demand" name="to_net_bill" id="to_net_bill" class="form-control select2" value="" readonly  style="width: 100%;">
                  </div>

                


              </fieldset>

                                
                <!-- /.form-group -->
               
                
              </div>

                            <!-- /.col -->

            </div>
            <!-- /.row -->

            

            <div class="row">
              <div class="col-md-12">
                
                <fieldset class="border p-4">
                   <legend class="w-auto">Add Item</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" onchange="setDepartmentItem()" form="add_item" name="location" id="location" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($departments as $depart)
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
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty_0" onchange="setItemNet(0)" class="form-control select2" required="true" style="width: 100%;">
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
                  <input type="number" min="1" value="1" step="1"  form="add_item" name="p_s" id="p_s_0" value="1"  onchange="setItemNet(0)" class="form-control select2" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>


             <div class="col-md-2">
                    <div class="form-group">
                  <label>MRP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="mrp" id="mrp_0" onchange="setItemNet(0)" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>TP</label>
                  <input type="number" value="" step="any" min="0" form="add_item" name="tp" id="tp_0" onchange="setItemNet(0)" readonly class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Business Type</label>
                  <select class="form-control select2" form="add_item" name="business_type" id="business_type_0" required="true" onchange="" style="width: 100%;">
                     <option value="">Select any value</option>
                    <option value="tp_percent" selected>Percentage on TP</option>
                    <option value="flat_rate">Flat Rate</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discount Type</label>
                  <select class="form-control select2" form="add_item" name="discount_type" id="discount_type_0" required="true" onchange="setItemNet(0)" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="percentage" selected>Percentage</option>
                    <option value="flat">Flat</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discount Factor</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="discount_factor" id="discount_factor_0" onchange="setItemNet(0)" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Discounted Value</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="discounted_value" id="discounted_value_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Rate</label>
                  <input type="number" value="" min="0" step="any" form="add_item" name="rate" id="rate_0" onchange="rate_change(0)" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total</label>
                  <input type="number" value="" min="0" step="any" onchange="setTotalAmount(0)" form="add_item" name="total" id="total_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Tax %</label>
                  <input type="number" min="0" step="any" form="add_item" name="tax" id="tax_0" class="form-control select2" onchange="setItemNet(0)"  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Tax Amount</label>
                  <input type="number" min="0" step="any" form="add_item" name="tax_amount" id="tax_amount_0" class="form-control select2" readonly style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Net Amount</label>
                  <input type="number"  min="0" step="any" form="add_item" name="net_amount" id="net_amount_0" class="form-control select2" readonly style="width: 100%;">
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



<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Items</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="item_table" >
        <thead class="table-secondary">

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
                  <th></th>
                  <th></th>

                 <th colspan="9"><center>From</center></th>  
                 <th colspan="9"><center>To</center></th>
                 <th></th>
          </tr>

           <tr>

             <th>#</th>
             <th>Challan No</th>
             <th>Location</th>
             <th>Code</th>
             <th>Item</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Batch #</th>
             <th>Expiry date</th>
             <th>Total Qty</th>
              <th>MRP</th>
              <th>TP</th>
              <th>Business Type</th>
              <th>Discount Type</th>
             <th>Discount Factor</th>
             <th>Discounted Value</th>
             <th>Rate</th>
             <th>Total</th>
             <th>Tax %</th>
             <th>Tax Amount</th>
              <th>Net Amount</th>

               <th>Business Type</th>
              <th>Discount Type</th>
             <th>Discount Factor</th>
             <th>Discounted Value</th>
             <th>Rate</th>
             <th>Total</th>
             <th>Tax %</th>
             <th>Tax Amount</th>
              <th>Net Amount</th>

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">
          <?php $row=1; ?>
          @foreach($transfer['stock_transfer_items'] as $item)

          <?php  
                $bt=$item['from_business_type'];
                $dt=$item['from_discount_type'];
                  $tp_percent=''; $flat_rate='';
                if($bt=='tp_percent')
                    $tp_percent='selected';
                  elseif ($bt=='flat_rate')
                      $flat_rate='selected';


                       $percent=''; $flat='';
                if($dt=='percentage')
                    $percent='selected';
                  elseif ($dt=='flat')
                      $flat='selected'; 

                    $bt1=$item['to_business_type'];
                $dt1=$item['to_discount_type'];
                  $tp_percent1=''; $flat_rate1='';
                if($bt1=='tp_percent')
                    $tp_percent1='selected';
                  elseif ($bt1=='flat_rate')
                      $flat_rate1='selected';


                       $percent1=''; $flat1='';
                if($dt1=='percentage')
                    $percent1='selected';
                  elseif ($dt1=='flat')
                      $flat1='selected'; 
                  

          ?>

          <tr id="{{$row}}">
      <th ondblclick="editItem('{{$row}}')">
        
        <input type="hidden" form="purchase_demand" id="{{'pivot_id_'.$row}}" name="pivots_id[]" value="{{$item['id']}}"  >

      </th>
     
     <input type="hidden" form="purchase_demand" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >
     <input type="hidden" form="purchase_demand" id="{{'challan_id_'.$row}}" name="challans_id[]" value="{{$item['challan_id']}}" readonly >

     <input type="hidden" form="purchase_demand" id="{{'location_id_'.$row}}"   name="location_ids[]" value="{{$item['item']['department_id']}}" >
     
      <td ondblclick="editItem('{{$row}}')" id="{{'challan_no_'.$row}}">{{$item['challan']['doc_no']}}</td>
     
     <td ondblclick="editItem('{{$row}}')" id="{{'location_text_'.$row}}">{{$item['item']['department']['name']}}</td>

     <td ondblclick="editItem('{{$row}}')" id="{{'code_'.$row}}"></td>

     <td ondblclick="editItem('{{$row}}')" id="{{'item_name_'.$row}}">{{$item['item']['item_name']}}</td>
       
       <td ondblclick="editItem('{{$row}}')" id="{{'item_uom_'.$row}}"></td>

     <td><input type="text" value="{{$item['unit']}}" form="purchase_demand" name="units[]" id="{{'unit_'.$row}}" required="true" readonly onchange="setPackSize('{{$row}}')"></td>

     <td><input type="number" value="{{$item['qty']}}" min="1" form="purchase_demand" name="qtys[]" id="{{'qty_'.$row}}" onchange="setItemNet('{{$row}}')" required="true"></td>

     <td><input type="number" value="{{$item['pack_size']}}" min="1" form="purchase_demand" name="p_s[]" id="{{'p_s_'.$row}}" onchange="setItemNet('{{$row}}')" readonly required="true"></td>
     
      

      <td><input type="text" value="{{$item['batch_no']}}" form="purchase_demand" name="batch_no[]" id="{{'batch_no_'.$row}}"  required="true"></td>

      <td><input type="date" value="{{$item['expiry_date']}}" form="purchase_demand" name="expiry_date[]" id="{{'expiry_date_'.$row}}"  required="true"></td>
     
     <td><input type="number" value="{{$item['total_qty']}}" min="1" form="purchase_demand" id="{{'total_qty_'.$row}}" readonly ></td>

     <td><input type="number" value="{{$item['mrp']}}" step="any" min="0" form="purchase_demand" name="mrp[]" id="{{'mrp_'.$row}}" onchange="setItemNet('{{$row}}')"  required="true"></td>

     <td><input type="number" value="{{$item['tp']}}" step="any" min="0" form="purchase_demand" name="tp[]" id="{{'tp_'.$row}}" onchange="setItemNet('{{$row}}')"  readonly></td>


     <td><select form="purchase_demand" name="from_business_type[]" id="{{'from_business_type_'.$row}}" onchange="setItemNet('{{$row}}')">
     <option value="" >Select any value</option>
      <option value="tp_percent" {{$tp_percent}}>Percentage on TP</option>
      <option value="flat_rate" {{$flat_rate}}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="from_discount_type[]" id="{{'from_discount_type_'.$row}}" onchange="setItemNet('{{$row}}')">
      <option value="percentage" {{$percent}}>Percentage</option>
      <option value="flat" {{$flat}}>Flat</option>
     </select></td>

     <td><input type="number" value="{{$item['from_discount_factor']}}" step="any" min="0" form="purchase_demand" name="from_discount_factor[]" id="{{'from_discount_factor_'.$row}}" onchange="setItemNet('{{$row}}')" ></td>

     <td><input type="number" value="{{$item['from_discount']}}" step="any" min="0" form="purchase_demand" name="from_discounted_value[]" id="{{'from_discounted_value_'.$row}}" readonly ></td>

     <td><input type="number" value="{{$item['from_discounted_rate']}}" step="any" min="0" form="purchase_demand" name="from_rate[]" id="{{'from_rate_'.$row}}" onchange="rate_change('{{$row}}')" ></td>

     <td><input type="number" value="{{$item['from_total']}}" step="any" min="0" form="purchase_demand" name="from_total[]" id="{{'from_total_'.$row}}" readonly onchange="setTotalAmount('{{$row}}')"></td>

     <td><input type="number" value="{{$item['from_tax']}}" step="any" min="0" form="purchase_demand" name="from_tax[]" id="{{'from_tax_'.$row}}" onchange="setItemNet('{{$row}}')" ></td>

     <td><input type="number" value="{{$item['from_tax_amount']}}" step="any" min="0" form="purchase_demand" name="from_tax_amount[]" id="{{'from_tax_amount_'.$row}}" readonly  ></td>

     <td><input type="number" value="{{$item['from_net_amount']}}" step="any" min="0" form="purchase_demand" name="from_net_amount[]" id="{{'from_net_amount_'.$row}}" readonly ></td>


     <td><select form="purchase_demand" name="to_business_type[]" id="{{'to_business_type_'.$row}}" onchange="setItemNet('{{$row}}')">
     <option value="" >Select any value</option>
      <option value="tp_percent" {{$tp_percent1}}>Percentage on TP</option>
      <option value="flat_rate" {{$flat_rate1}}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="to_discount_type[]" id="{{'to_discount_type_'.$row}}" onchange="setItemNet('{{$row}}')">
      <option value="percentage" {{$percent1}}>Percentage</option>
      <option value="flat" {{$flat1}}>Flat</option>
     </select></td>

     <td><input type="number" value="{{$item['to_discount_factor']}}" step="any" min="0" form="purchase_demand" name="to_discount_factor[]" id="{{'to_discount_factor_'.$row}}" onchange="setItemNet('{{$row}}')" ></td>

     <td><input type="number" value="{{$item['to_discount']}}" step="any" min="0" form="purchase_demand" name="to_discounted_value[]" id="{{'to_discounted_value_'.$row}}" readonly ></td>

     <td><input type="number" value="{{$item['to_discounted_rate']}}" step="any" min="0" form="purchase_demand" name="to_rate[]" id="{{'to_rate_'.$row}}" onchange="rate_change('{{$row}}')" ></td>

     <td><input type="number" value="{{$item['to_total']}}" step="any" min="0" form="purchase_demand" name="to_total[]" id="{{'to_total_'.$row}}" readonly onchange="setTotalAmount('{{$row}}')"></td>

     <td><input type="number" value="{{$item['to_tax']}}" step="any" min="0" form="purchase_demand" name="to_tax[]" id="{{'to_tax_'.$row}}" onchange="setItemNet('{{$row}}')" ></td>

     <td><input type="number" value="{{$item['to_tax_amount']}}" step="any" min="0" form="purchase_demand" name="to_tax_amount[]" id="{{'to_tax_amount_'.$row}}" readonly  ></td>

     <td><input type="number" value="{{$item['to_net_amount']}}" step="any" min="0" form="purchase_demand" name="to_net_amount[]" id="{{'to_net_amount_'.$row}}" readonly ></td>


     

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
             <th  id="net_qty">0</th>
             
             <th></th>
             <th></th>
             <th></th>
             <th id="net_total_qty">0</th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="from_net_total">0</th>
             <th></th>
             <th></th>
             <th id="from_net_amount">0</th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="to_net_total">0</th>
             <th></th>
             <th></th>
             <th id="to_net_amount">0</th>
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
    <!-- /.content -->

    <form role="form" id="#add_item">
              
            </form>

             <form role="form" id="delete_form" method="POST" action="{{url('stock/transfer/delete/'.$transfer['id'])}}">
               
               @csrf    
    </form>
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>


<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

<script type="text/javascript">

var row_num="{{$row}}";


$(document).ready(function(){

  var active="{{$transfer['activeness']}}";
     if(active==1)
     $('#activeness').prop('checked',true);
   else if(active==0)
     $('#activeness').prop('checked',false);

   var from_id="{{$transfer['from_id']}}";
      var from_name="{{$transfer['from_customer']['name']}}";

      $('#from_customer_id').val(from_id);
var s=$("#from_customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(from_name);

var to_id="{{$transfer['to_id']}}";
      var to_name="{{$transfer['to_customer']['name']}}";

      $('#to_customer_id').val(to_id);
var s=$("#to_customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(to_name);

   
   setNetQty();


  $("#item_table").colResizable({
     resizeMode:'overflow'
   });

  

  $('#purchase_demand').submit(function(e) {

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
  this.row_num ++;
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

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit,id:items[i]['id']};
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



function setCustomers(customers,id)
 {
  
  
  var new_customers=[];
 
 for(var i = 0 ; i < customers.length ; i++)
 {
  

         var let={ mobile:customers[i]['mobile'],customer:customers[i]['name'],id:customers[i]['id'],address:customers[i]['address'] };
         //alert(let);
         new_customers.push(let);
 }


$(`#${id}`).inputpicker({
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
      setCustomers(customers,'from_customer_id');
      setCustomers(customers,'to_customer_id');
   
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


function setTp(row)
{  
  var mrp=$(`#mrp_${row}`).val();

  var tp= (mrp * 0.85 ).toFixed(2) ;

  $(`#tp_${row}`).val(tp);
}

function rate_change(row)
{
       //from
        $(`#from_discount_type_${row}`).val('flat');
        var rate=$(`#from_rate_${row}`).val();

        var tp=$(`#tp_${row}`).val();

           var discounted_value=(tp - rate).toFixed(2);
           $(`#from_discount_factor_${row}`).val(discounted_value);

           $(`#from_discounted_value_${row}`).val(discounted_value);
           //to
        $(`#to_discount_type_${row}`).val('flat');
        var rate=$(`#to_rate_${row}`).val();

        var tp=$(`#tp_${row}`).val();

           var discounted_value=(tp - rate).toFixed(2);
           $(`#to_discount_factor_${row}`).val(discounted_value);

           $(`#to_discounted_value_${row}`).val(discounted_value);
     setItemNet(row);

  }

  function setDiscountedAmount(row)
{   //from
  var tp=$(`#tp_${row}`).val();
  var bt=$(`#from_business_type_${row}`).val();
  var discount_type=$(`#from_discount_type_${row}`).val();
  var discount_factor=$(`#from_discount_factor_${row}`).val();
  var discounted_value='';
  var rate='';

  if(tp=='')
    tp=0;

  if(bt=='flat_rate')
  {
        $(`#from_discount_type_${row}`).val('flat');
        var rate=$(`#from_rate_${row}`).val();

           var discounted_value=(tp - rate).toFixed(2);
           $(`#from_discount_factor_${row}`).val(discounted_value);

           $(`#from_discounted_value_${row}`).val(discounted_value);
  }
  
  else
  {

 

  if(discount_factor=='')
    discount_factor=0;

       if(discount_type=='flat')
       {
          discounted_value=( parseFloat(discount_factor)).toFixed(2);
       }
       else if(discount_type=='percentage')
       {
           discounted_value=( (discount_factor / 100 ) * tp ).toFixed(2);
       }
              
       $(`#from_discounted_value_${row}`).val(discounted_value);

         rate= ( tp - discounted_value ).toFixed(2) ;

       $(`#from_rate_${row}`).val(rate);

     }

     //to

     var tp=$(`#tp_${row}`).val();
  var bt=$(`#to_business_type_${row}`).val();
  var discount_type=$(`#to_discount_type_${row}`).val();
  var discount_factor=$(`#to_discount_factor_${row}`).val();
  var discounted_value='';
  var rate='';

  if(tp=='')
    tp=0;

  if(bt=='flat_rate')
  {
        $(`#to_discount_type_${row}`).val('flat');
        var rate=$(`#to_rate_${row}`).val();

           var discounted_value=(tp - rate).toFixed(2);
           $(`#to_discount_factor_${row}`).val(discounted_value);

           $(`#to_discounted_value_${row}`).val(discounted_value);
  }
  
  else
  {

 

  if(discount_factor=='')
    discount_factor=0;

       if(discount_type=='flat')
       {
          discounted_value=( parseFloat(discount_factor)).toFixed(2);
       }
       else if(discount_type=='percentage')
       {
           discounted_value=( (discount_factor / 100 ) * tp ).toFixed(2);
       }
              
       $(`#to_discounted_value_${row}`).val(discounted_value);

         rate= ( tp - discounted_value ).toFixed(2) ;

       $(`#to_rate_${row}`).val(rate);

     }

}//end fun

  function setTotalAmount(row)
  {  //from
    var total_qty=$(`#total_qty_${row}`).val();
    var rate=$(`#from_rate_${row}`).val();
      var total_amount='';

      if(rate=='')
        rate=0;

      total_amount = (rate * total_qty).toFixed(2) ;

      $(`#from_total_${row}`).val(total_amount);

      //to
    var total_qty=$(`#total_qty_${row}`).val();
    var rate=$(`#to_rate_${row}`).val();
      var total_amount='';

      if(rate=='')
        rate=0;

      total_amount = (rate * total_qty).toFixed(2) ;

      $(`#to_total_${row}`).val(total_amount);
  }

  function setTaxAmount(row)
  {  //from
    var tax=$(`#from_tax_${row}`).val();
  
    var total_amount=$(`#from_total_${row}`).val();
      var tax_amount='';
      
      if(tax=='')
        tax=0;

      if(total_amount=='')
         total_amount=0;

      tax_amount = ( (tax / 100 ) * total_amount).toFixed(2) ;

      $(`#from_tax_amount_${row}`).val(tax_amount);
      //to
      var tax=$(`#to_tax_${row}`).val();
  
    var total_amount=$(`#to_total_${row}`).val();
      var tax_amount='';
      
      if(tax=='')
        tax=0;

      if(total_amount=='')
         total_amount=0;

      tax_amount = ( (tax / 100 ) * total_amount).toFixed(2) ;

      $(`#to_tax_amount_${row}`).val(tax_amount);
  }

  function setNetAmount(row)
  {
    //from
    var total_amount=$(`#from_total_${row}`).val();

      var tax_amount=$(`#from_tax_amount_${row}`).val();
      var net_amount=0;

      if(total_amount=='')
           total_amount=0;

         if(tax_amount=='')
           tax_amount=0;
      
      net_amount = parseFloat(total_amount)    + parseFloat(tax_amount)  ;

      net_amount = parseFloat(net_amount).toFixed(2) ;

      $(`#from_net_amount_${row}`).val(net_amount);
      //to
    var total_amount=$(`#to_total_${row}`).val();

      var tax_amount=$(`#to_tax_amount_${row}`).val();
      var net_amount=0;

      if(total_amount=='')
           total_amount=0;

         if(tax_amount=='')
           tax_amount=0;
      
      net_amount = parseFloat(total_amount)    + parseFloat(tax_amount)  ;

      net_amount = parseFloat(net_amount).toFixed(2) ;

      $(`#to_net_amount_${row}`).val(net_amount);
  }

  function setItemNet(row)
  {
       setTotalQty(row);
       setTp(row);
       setDiscountedAmount(row);
       setTotalAmount(row);
       setTaxAmount(row);
       setNetAmount(row);

          setNetQty();
  }      

 



function setPackSize(row)
{
  var unit=$(`#unit_${row}`).val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s_${row}`).setAttribute('readonly', 'readonly');
  $(`#p_s_${row}`).val('1');
  setTotalQty(row);
   }
   else if( unit=='pack')
   document.getElementById(`p_s_${row}`).removeAttribute('readonly');
}

function setTotalQty(row)
{
  var qty=$(`#qty_${row}`).val();
  var p_s=$(`#p_s_${row}`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $(`#total_qty_${row}`).val(total_qty); 
}

function setNetQty() //for end of tabel to show net
{
  var rows=getRowNum();
  
   var net_total_qty=0, net_qty=0 , from_net_total=0, from_net_amount=0, to_net_total=0, to_net_amount=0;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).val();
       var qty=$(`#qty_${i}`).val();
       var from_total=$(`#from_total_${i}`).val();
       var from_net=$(`#from_net_amount_${i}`).val();
       var to_total=$(`#to_total_${i}`).val();
       var to_net=$(`#to_net_amount_${i}`).val();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;

      if(from_total=='' || from_total==null)
        from_total=0;

      if(from_net=='' || from_net==null)
        from_net=0;
      if(to_total=='' || to_total==null)
        to_total=0;

      if(to_net=='' || to_net==null)
        to_net=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;

         from_net_total +=  parseFloat (from_total) ;

        from_net_amount +=  parseFloat (from_net) ;

         to_net_total +=  parseFloat (to_total) ;

        to_net_amount +=  parseFloat (to_net) ;
      }
       

   }

   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
   $(`#from_net_total`).text(from_net_total);
   $(`#from_net_amount`).text(from_net_amount);


   $(`#to_net_total`).text(to_net_total);
   $(`#to_net_amount`).text(to_net_amount);

   
       // var disc=$(`#disc`).val();
       // var disc_type=$('input[name="net_disc"]:checked').val();
       // var disc_amount=0;

       // if(disc_type=='flat')
       // {
       //       disc_amount=disc;
       // }
       // else if(disc_type=='percentage')
       // {
       //     disc_amount= (disc / 100) * net_amount;
       // }

         //var netbill=net_amount - disc_amount ;

         var from_netbill=from_net_amount  ;
        var to_netbill=to_net_amount  ;

         //netbill= netbill.toFixed(2);
         //netbill= netbill.toFixed(2);
           $(`#from_net_bill`).val( from_netbill ) ;
           $(`#to_net_bill`).val( to_netbill ) ;

}

function setNetBill()
{
      var net_amount= $(`#net_amount`).text() ;
       // var disc=$(`#disc`).val();
       // var disc_type=$('input[name="net_disc"]:checked').val();
       // var disc_amount=0;

       // if(disc_type=='flat')
       // {
       //       disc_amount=disc;
       // }
       // else if(disc_type=='percentage')
       // {
       //     disc_amount= (disc / 100) * net_amount;
       // }

       //   var netbill=net_amount - disc_amount ;

       var netbill=net_amount  ;

         netbill= netbill.toFixed(2);
           $(`#net_bill`).val( netbill ) ;
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
     var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
    var item_id='';
    if(item_combine!='')
    {     item_id=item_combine[11];
     }

     var tbl_item_id=$(`#item_id_${i}`).val(); 

     if(item_id == tbl_item_id)
      return true;
     
  
   }
  return false;   
   
}

function addItem()
{
  
   var item_id=$("#item_code").val();
var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   var item_name=s.val(); //alert(item_name);alert(item_id);
  

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
 
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total_qty=$("#total_qty_0").val();

  var mrp=$("#mrp_0").val();
  var batch_no='';
  var expiry_date='';

var readonly='';
  if(unit=='loose')
     readonly='readonly';

  var tp=$("#tp_0").val();
  var business_type=$("#business_type_0").val();
  var discount_type=$("#discount_type_0").val(); 
  var discount_factor=$("#discount_factor_0").val();
  var discounted_value=$("#discounted_value_0").val();
  var rate=$("#rate_0").val();
  var total=$("#total_0").val();
  var tax=$("#tax_0").val();
  var tax_amount=$("#tax_amount_0").val();
  var net_amount=$("#net_amount_0").val();

  var percentage='', flat='';
  if(discount_type=='percentage')
      percentage='selected';
     else if(discount_type=='flat')
      flat='selected';

    var tp_percent='', flat_rate='';
  if(business_type=='tp_percent')
      tp_percent='selected';
     else if(business_type=='flat_rate')
      flat_rate='selected';
    
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
      
        
     var row=getRowNum();   


     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"><input type="hidden" form="purchase_demand" id="pivot_id_${row}" name="pivots_id[]" value="0"  ></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
      <input type="hidden" form="purchase_demand" id="challan_id_${row}" name="challans_id[]" value="" readonly >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     <td ondblclick="editItem(${row})" id="challan_no_${row}"></td>
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      <td><input type="text" value="${batch_no}" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  required="true"></td>

      <td><input type="date" value="${expiry_date}" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  required="true"></td>
     
     <td><input type="number" value="${total_qty}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any" min="0" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  required="true"></td>

     <td><input type="number" value="${tp}" step="any" min="0" form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     <td><select form="purchase_demand" name="business_type[]" id="business_type_${row}" onchange="setItemNet(${row})">
     <option value="" >Select any value</option>
      <option value="tp_percent" ${tp_percent}>Percentage on TP</option>
      <option value="flat_rate" ${flat_rate}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="discount_type[]" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any" min="0" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any" min="0" form="purchase_demand" name="mrp[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${rate}" step="any" min="0" form="purchase_demand" name="rate[]" id="rate_${row}" onchange="rate_change(${row})" ></td>

     <td><input type="number" value="${total}" step="any" min="0" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>

     <td><input type="number" value="${tax}" step="any" min="0" form="purchase_demand" name="tax[]" id="tax_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${tax_amount}" step="any" min="0" form="purchase_demand" name="tax_amount[]" id="tax_amount_${row}" readonly  ></td>

     <td><input type="number" value="${net_amount}" step="any" min="0" form="purchase_demand" name="net_amount[]" id="net_amount_${row}" readonly ></td>
     

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

  $("#mrp_0").val('');
  $("#batch_no_0").val('');
  $("#expiry_date_0").val('');
  $("#tp_0").val('');
  $("#discount_factor_0").val('');
  $("#discounted_value_0").val('');
  $("#rate_0").val('');
  $("#total_0").val('');
  $("#tax_0").val('');
  $("#tax_amount_0").val('');
  $("#net_amount_0").val('');

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
  
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();

  var dbl_item=false;
  if(item_name!='')
  {
     dbl_item=checkItem(row);
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
        
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        $(`#p_ss_${row}`).val(p_s);

      $(`#location_text_${row}`).text(location_text);
     $(`#code_${row}`).text(item_code);
      
      $(`#item_name_${row}`).text(item_name);
      
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
  $('#add_item_btn').attr('onclick', `addItem()`);
   
   }
     
}  //end update item

function editItem(row)
{
}

function editItem1(row)
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


function setDeliveryChallan()
{
    var customer_id=$('#customer_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/customer/new/challans") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     customer_id: customer_id,
                  

               },
               success:function(data) {

                var orders = data;
                  opt_txt=`<option value="">Select Delivery Challan</option>`;

                      for (var i =0; i < orders.length ;  i++) {
                            txt    = `<option value="${orders[i]['id']}">${orders[i]['doc_no']}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                      }

                      $('#challan_id').empty().append(opt_txt);

               }
             });


}
function uploadInvoices()
{
  var product_id=$('#product_id').val();
   var customer_id=$('#from_customer_id').val();

   if(product_id=='' || customer_id=='')
     {  return; }


  $.ajax({
               type:'get',
               url:'{{ url("get/customer/product/invoices") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     product_id : product_id ,
                     customer_id : customer_id ,

               },
               success:function(data) {

                var items = data;
//alert(JSON.stringify(items));
                  opt_txt=`<option value="">challan~item~qty~batch_no~rate</option>`;

                      for (var i =0; i < items.length ;  i++) {
                        
                        var invoice=items[i]['challan']['doc_no'];
                        var item=items[i]['item']['item_name'];
                        var item_id=items[i]['id'];
                        var location=items[i]['item']['department']['name'];
                        var item_code=items[i]['item']['item_code'];
                        var mrp=items[i]['mrp'];
                        var tp=(0.85 * mrp).toFixed(2);
                        var batch=items[i]['batch_no'];
                        var qty=items[i]['qty'] * items[i]['pack_size'];
                        var rate=items[i]['rate'];

                            txt   = `<option value="${items[i]['id']}">${invoice}~${item}~${qty}~${batch}~${rate}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                      }

                      $('#invoice_id').empty().append(opt_txt);

              }

            });




}

function uploadSale()
{
  var invoice_id=$('#invoice_id').val();
  var from_id=$('#from_customer_id').val();
  var to_id=$('#to_customer_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/transfer/item/") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     sale_stock_id : invoice_id,
                     from_id : from_id,
                     to_id : to_id,

               },
               success:function(data) {

                var items = data;


                    

                        var row=getRowNum();

                         var challan_id=items['challan_id'];
                         var challan_no=items['challan_no'];
                        var item_id=items['item_id'];
                        var location=items['location_id'];
                        var location_text=items['location_text'];
                        var item_name=items['item_name'];
                        var unit=items['unit'];
                        var qty=items['qty'];
                        var p_s=items['pack_size'];
                        var mrp=items['mrp'];
                        var tp=items['tp'];
                         var batch_no=items['batch_no']; 
                         var expiry_date=items['expiry_date']; 
                         var total_qty=items['total_qty'];
                      //from
                         var from_business_type=items['from_business_type'];
                         var from_discount_type=items['from_discount_type'];
                         var from_discount_factor=items['from_discount_factor'];
                         var from_discounted_value=items['from_discounted_value'];
                         var from_rate=items['from_rate'];
                         var from_total=items['from_total'];
                         var from_tax=items['from_tax'];
                         var from_tax_amount=items['from_tax_amount'];
                         var from_net_total=items['from_net_amount'];

                         //to
                         var to_business_type=items['to_business_type'];
                         var to_discount_type=items['to_discount_type'];
                         var to_discount_factor=items['to_discount_factor'];
                         var to_discounted_value=items['to_discounted_value'];
                         var to_rate=items['to_rate'];
                         var to_total=items['to_total'];
                         var to_tax=items['to_tax'];
                         var to_tax_amount=items['to_tax_amount'];
                         var to_net_total=items['to_net_amount'];

                         
                            


                        var readonly='';
                        if(unit=='loose')
                          readonly='readonly';

                        var from_flat='',from_percentage='';
                        if(from_discount_type=='flat')
                          from_flat='selected';
                        else if(from_discount_type=='percentage')
                          from_percentage='selected';

                          var from_tp_percent='', from_flat_rate='';
                    if(from_business_type=='tp_percent')
                         from_tp_percent='selected';
                  else if(from_business_type=='flat_rate')
                        from_flat_rate='selected';

                      var to_flat='',to_percentage='';
                        if(to_discount_type=='flat')
                          to_flat='selected';
                        else if(to_discount_type=='percentage')
                          to_percentage='selected';

                          var to_tp_percent='', to_flat_rate='';
                    if(to_business_type=='tp_percent')
                         to_tp_percent='selected';
                  else if(to_business_type=='flat_rate')
                        to_flat_rate='selected';

                            
      var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"><input type="hidden" form="purchase_demand" id="pivot_id_${row}" name="pivots_id[]" value="0"  ></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="purchase_demand" id="challan_id_${row}" name="challans_id[]" value="${challan_id}" readonly >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
      <td ondblclick="editItem(${row})" id="challan_no_${row}">${challan_no}</td>
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      <td><input type="text" value="${batch_no}" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  required="true"></td>

      <td><input type="date" value="${expiry_date}" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  required="true"></td>
     
     <td><input type="number" value="${total_qty}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any" min="0" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  required="true"></td>

     <td><input type="number" value="${tp}" step="any" min="0" form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>


     <td><select form="purchase_demand" name="from_business_type[]" id="from_business_type_${row}" onchange="setItemNet(${row})">
     <option value="" >Select any value</option>
      <option value="tp_percent" ${from_tp_percent}>Percentage on TP</option>
      <option value="flat_rate" ${from_flat_rate}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="from_discount_type[]" id="from_discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${from_percentage}>Percentage</option>
      <option value="flat" ${from_flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${from_discount_factor}" step="any" min="0" form="purchase_demand" name="from_discount_factor[]" id="from_discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${from_discounted_value}" step="any" min="0" form="purchase_demand" name="from_discounted_value[]" id="from_discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${from_rate}" step="any" min="0" form="purchase_demand" name="from_rate[]" id="from_rate_${row}" onchange="rate_change(${row})" ></td>

     <td><input type="number" value="${from_total}" step="any" min="0" form="purchase_demand" name="from_total[]" id="from_total_${row}" readonly onchange="setTotalAmount($row)"></td>

     <td><input type="number" value="${from_tax}" step="any" min="0" form="purchase_demand" name="from_tax[]" id="from_tax_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${from_tax_amount}" step="any" min="0" form="purchase_demand" name="from_tax_amount[]" id="from_tax_amount_${row}" readonly  ></td>

     <td><input type="number" value="${from_net_total}" step="any" min="0" form="purchase_demand" name="from_net_amount[]" id="from_net_amount_${row}" readonly ></td>


     <td><select form="purchase_demand" name="to_business_type[]" id="to_business_type_${row}" onchange="setItemNet(${row})">
     <option value="" >Select any value</option>
      <option value="tp_percent" ${to_tp_percent}>Percentage on TP</option>
      <option value="flat_rate" ${to_flat_rate}>Flat Rate</option>
     </select></td>

     <td><select form="purchase_demand" name="to_discount_type[]" id="to_discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${to_percentage}>Percentage</option>
      <option value="flat" ${to_flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${to_discount_factor}" step="any" min="0" form="purchase_demand" name="to_discount_factor[]" id="to_discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${to_discounted_value}" step="any" min="0" form="purchase_demand" name="to_discounted_value[]" id="to_discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${to_rate}" step="any" min="0" form="purchase_demand" name="to_rate[]" id="to_rate_${row}" onchange="rate_change(${row})" ></td>

     <td><input type="number" value="${to_total}" step="any" min="0" form="purchase_demand" name="to_total[]" id="to_total_${row}" readonly onchange="setTotalAmount($row)"></td>

     <td><input type="number" value="${to_tax}" step="any" min="0" form="purchase_demand" name="to_tax[]" id="to_tax_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${to_tax_amount}" step="any" min="0" form="purchase_demand" name="to_tax_amount[]" id="to_tax_amount_${row}" readonly  ></td>

     <td><input type="number" value="${to_net_total}" step="any" min="0" form="purchase_demand" name="to_net_amount[]" id="to_net_amount_${row}" readonly ></td>


     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;

       $('#selectedItems').append(txt);
            setRowNum();      
                  
                      

                   setNetQty();   
               }
             });
}

function uploadSale1()
{
  var invoice_id=$('#invoice_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/sale/invoice") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     invoice_id: invoice_id,
                  

               },
               success:function(data) {

                var items = data['items'];


     

      $('#customer_id').val(data['customer_id']);
var s=$("#customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(data['customer']['name']);
            
                  
                  $('#selectedItems').html('');

                      for (var i =0; i < items.length ;  i++) {

                        var row=getRowNum();

                        var item_id=items[i]['id'];
                        var location=items[i]['department_id'];
                        var location_text=items[i]['department']['name'];
                        var item_name=items[i]['item_name'];
                        var unit=items[i]['pivot']['unit'];
                        var qty=items[i]['pivot']['qty'];
                        var p_s=items[i]['pivot']['pack_size'];
                        var mrp=items[i]['pivot']['mrp'];
                        var tp=(0.85 * mrp).toFixed(2);
                         var batch_no=items[i]['pivot']['batch_no']; 
                         var expiry_date=items[i]['pivot']['expiry_date']; 
                         var total_qty=qty * p_s;
                         var discount_type=items[i]['pivot']['discount_type'];
                         var discount_factor=items[i]['pivot']['discount_factor'];
                         var discounted_value=items[i]['pivot']['discounted_value'];

                         
                           if(discount_type=='flat')
                               discounted_value= discount_factor;
                            else if(discount_type=='percentage')
                              discounted_value= (discount_factor / 100) * tp;

                            var rate= (tp - discounted_value).toFixed(2);

                         var total=(rate * total_qty ).toFixed(2);
                         var tax=items[i]['pivot']['tax'];
                         var tax_amount=( (tax / 100) * rate ).toFixed(2);
                         var t_rate=parseFloat( rate ) + parseFloat( tax_amount ) ;  
                         var net_amount= t_rate * total_qty ;
                          net_amount= net_amount.toFixed(2);


                        var readonly='';
                        if(unit=='loose')
                          readonly='readonly';

                        var flat='',percentage='';
                        if(discount_type=='flat')
                          flat='selected';
                        else if(discount_type=='percentage')
                          percentage='selected';
                            
      var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"><input type="hidden" form="purchase_demand" id="pivot_id_${row}" name="pivots_id[]" value="0"  ></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true" readonly onchange="setPackSize(${row})"></td>

     <td><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setItemNet(${row})" required="true"></td>

     <td><input type="number" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setItemNet(${row})" readonly required="true"></td>
     
      

      <td><input type="text" value="${batch_no}" form="purchase_demand" name="batch_no[]" id="batch_no_${row}"  required="true"></td>

      <td><input type="date" value="${expiry_date}" form="purchase_demand" name="expiry_date[]" id="expiry_date_${row}"  required="true"></td>
     
     <td><input type="number" value="${total_qty}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>

     <td><input type="number" value="${mrp}" step="any" min="0" form="purchase_demand" name="mrp[]" id="mrp_${row}" onchange="setItemNet(${row})"  required="true"></td>

     <td><input type="number" value="${tp}" step="any" min="0" form="purchase_demand" name="tp[]" id="tp_${row}" onchange="setItemNet(${row})"  readonly></td>

     <td><select form="purchase_demand" name="discount_type[]" id="discount_type_${row}" onchange="setItemNet(${row})">
      <option value="percentage" ${percentage}>Percentage</option>
      <option value="flat" ${flat}>Flat</option>
     </select></td>

     <td><input type="number" value="${discount_factor}" step="any" min="0" form="purchase_demand" name="discount_factor[]" id="discount_factor_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${discounted_value}" step="any" min="0" form="purchase_demand" name="mrp[]" id="discounted_value_${row}" readonly ></td>

     <td><input type="number" value="${rate}" step="any" min="0" form="purchase_demand" name="rate[]" id="rate_${row}" onchange="rate_change(${row})" ></td>

     <td><input type="number" value="${total}" step="any" min="0" form="purchase_demand" name="total[]" id="total_${row}" readonly onchange="setTotalAmount($row)"></td>

     <td><input type="number" value="${tax}" step="any" min="0" form="purchase_demand" name="tax[]" id="tax_${row}" onchange="setItemNet(${row})" ></td>

     <td><input type="number" value="${tax_amount}" step="any" min="0" form="purchase_demand" name="tax_amount[]" id="tax_amount_${row}" readonly  ></td>

     <td><input type="number" value="${net_amount}" step="any" min="0" form="purchase_demand" name="net_amount[]" id="net_amount_${row}" readonly ></td>
     

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
  