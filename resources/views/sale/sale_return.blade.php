
@extends('layout.master')
@section('title')
    {{ isset($order['id']) ? 'Edit the Sale Return' : 'Add New Sale Return' }}
@endsection
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">

@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

          <!-- Page Header -->

        <div class="container-fluid px-3 py-3">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1><i class="fas fa-file-invoice mr-2"></i>Sale Return</h1>
                </div>
                <div class="col-md-6">
                    <div class="action-buttons justify-content-md-end">
                        <button type="submit" form="purchase_demand" class="btn btn-success" >
                            <i class="fas fa-save"></i> {{ isset($order['id']) ? 'Update' : 'Save' }}
                        </button>

                        @if(isset($order['id']))
                        <button type="submit" form="delete_form"  class="btn btn-action">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <a href="{{url('sale/return')}}" class="btn btn-action">
                            <i class="fas fa-plus"></i> New
                        </a>
                        @endif
                        <a href="{{url('sale/return/history')}}" class="btn btn-action">
                            <i class="fas fa-history"></i> History
                        </a>


                       @if(isset($order['id']))
                         <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('/return/report/'.$order['id'].'/invoice1')}}" class="dropdown-item">Print</a></li>
                      <!--<li><a href="{{url('/return/report/'.$order['id'].'/invoice2')}}" class="dropdown-item">Print1</a></li>-->
                    </ul>
                  </div>
                  @endif


                    </div>
                </div>
            </div>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white-50">Sale</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ isset($order['id']) ? 'Edit the Sale Return' : 'Add New Sale Return' }}</li>
                </ol>
            </nav>
        </div>
      </div>
        <!---------->
     
  @endsection

@section('content')
    <!-- Main content -->

<form role="form" id="purchase_demand" method="POST" action="{{ isset($order['id']) ? url('/sale/return/update') : url('/sale/return/save') }}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

       @if(isset($order['id']))
       <input type="hidden" value="{{$order['id']}}" name="id"/>
        @endif

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
             
               
                   <h4 class="form-section-title col-md-12"><i class="fas fa-file-alt mr-2"></i>Document</h4>

                <!-- /.form-group -->
                <div class="form-group col-md-4">
                  <label>Return No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control" value="{{ old('doc_no', $order->doc_no) }}" readonly required >
                  </div>


                <div class="form-group col-md-4">
                  <label>Return Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control " value="{{ old('doc_date', $order->doc_date ?? date('Y-m-d')) }}" required >
                  </div>



                   

                  <div class="form-group col-md-4">
                  <label>Invoice No.</label>
                  <input type="text" form="purchase_demand" name="invoice_no" class="form-control" value="{{ $order->invoice_no ?? $order->sale->doc_no ?? '' }}"  readonly> 
                   <input type="hidden" form="purchase_demand" name="invoice_id" class="form-control" value="{{ old('invoice_id', $order->invoice_id) }}"  > 
                  </div>


                <div class="form-group col-md-4">
                  <label>Invoice Date</label>
                  <input type="date" form="purchase_demand" name="invoice_date" class="form-control" value="{{ old('invoice_date', $order->sale->doc_date ?? '') }}"  readonly>
                  </div>

                  

                <div class="form-group col-md-4">
                  <label>Status</label>
                  <select class="form-control" name="status"  required>
                    
                    

               <option value="1" {{ old('status', $order->status ?? 1) == '1' ? 'selected' : '' }}>Post</option>
                <option value="0" {{ old('status', $order->status ?? 1) == '0' ? 'selected' : '' }}>Unpost</option>

                  </select>
                  </div>


                  <div class="form-group col-md-4">
                  <label>Company</label>
                  <select class="form-control" name="company_id"  required>
                    
                    <option value="">Select any company</option>
                   @foreach($companies as $comp)
                <option value="{{$comp['id']}}" {{ old('company_id', $order->company_id ?? null) == $comp->id ? 'selected' : '' }}>{{$comp['name']}}</option>
                    @endforeach
                  </select>
                  </div>


                  <div class="form-group col-md-4">
                  <label>Branch</label>
                  <select class="form-control" name="branch_id"  required>
                    
                    <option value="">Select any value</option>

                    @foreach($branches as $branch)
            <option value="{{ $branch->id }}"
                {{ old('branch_id', $order->branch_id ?? null) == $branch->id ? 'selected' : '' }}>
                {{ $branch->name }}
            </option>
        @endforeach

                  </select>
                  </div>



             
            


             
                <h4 class="form-section-title col-md-12"><i class="fas fa-user mr-2"></i>Customer</h4>

                <div class="form-group col-md-4">
                  <label>Customer</label>
                  <select class="form-control select2" name="customer_id"  required>
                    
                     <option value="">Select any value</option>

                   @foreach($customers as $comp)
                <option value="{{$comp['id']}}" {{ old('customer_id', $order->customer_id) == $comp->id ? 'selected' : '' }}>{{$comp['name']}}</option>
                    @endforeach
                  </select>
                  </div>

                <!---<div class="form-group">
                  <label>Last Sales</label>
                  <input type="text" form="purchase_demand" name="balance_limit" class="form-control" value="" readonly >
                  </div>


              <div class="form-group">
                  <label>Current Month Sales</label>
                  <input type="text" form="purchase_demand" name="balance_limit" class="form-control" value="" readonly >
                  </div>


                <div class="form-group">
                  <label>Current Year Sales</label>
                  <input type="text" form="purchase_demand" name="balance_limit" class="form-control" value="" readonly >
                  </div>

                  <div class="form-group">
                  <label>Credit Days</label>
                  <input type="text" form="purchase_demand" name="credit_days" class="form-control" value="{{ old('credit_days', optional($order->customer)->credit_days) }}" readonly >
                  </div>


                <div class="form-group">
                  <label>Balance Due</label>
                  <input type="text" form="purchase_demand" name="balance_limit" class="form-control" value="" readonly >
                  </div>

                  <div class="form-group">
                  <label>Balance Limit</label>
                  <input type="text" form="purchase_demand" name="balance_limit" class="form-control" value="" readonly >
                  </div>-->


                    <div class="form-group col-md-4">
                  <label>Remarks</label>
                  <input type="text" form="purchase_demand" name="remarks" class="form-control " value="{{ old('remarks', $order->remarks) }}"   >
                </div>




                            <!-- /.col -->

                              

                  
                  


                   


                  


      
                  <!-- <div class="dropdown" id="customers_table_customer_dropdown">
        <label>Customer</label>
        <input class="form-control"  name="customer_id" id="customer_id" onchange="setQuotations()" required>
      
           </div>
            
            <div class="dropdown" id="customers_table_dispatch_dropdown">
        <label>Dispatch To</label>
        <input class="form-control"  name="dispatch_to_id" id="dispatch_to_id" >
      
           </div>
       
       <div class="dropdown" id="customers_table_invoice_dropdown">
        <label>Invoice To</label>
        <input class="form-control"  name="invoice_to_id" id="invoice_to_id" >
      
           </div>



                    <div class="form-group">
                  <label>Quotation</label>
                  <select form="purchase_demand" name="quotation_id" id="quotation_id" class="form-control select2" onchange="uploadQuotation()">
                     <option value="">Select any quotation</option>
                  </select>
                  </div>-->

                 

                

            </div>
            <!-- /.row -->

            

                           
                                
             



<!-- Start Tabs -->
<div class=" mb-4 p-2">

<div class="nav-tabs-wrapper mb-2">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA"><i class="fas fa-list mr-2"></i>Items</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive p-0" style="border-radius:8px ;">
      <table class="table table-hover table-head-fixed text-nowrap mb-0 add-lines-table"  id="item_table" >
        <thead class="table-primary">
           <tr>
             <th></th>
             <th style="min-width: 150px;" >Category</th>
             <th style="min-width: 250px;" >Item</th>
             
             <th>Qty</th>
             <th>Std Price</th>
             <th>Disc/Gain %</th>
             <th>Price</th>
             <th>Unit Weight</th>
             <th>Total Weight</th>
             <th>FT</th>
             <th>Total FT</th>
             <th>Amount</th>
              <th>Rack</th>
             <th>Rack Qty</th>

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

              <?php $total_weight=0; ?>
            @if(isset($order['items']) && count($order['items']) > 0)
        @foreach($order['items']  as $item)

        <?php $total_weight+=$item['pivot']['qty']*$item['pivot']['unit_weight'];  ?>

        <tr class="item-row">
            <td class="row-num"></td>

            <td>  <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="{{$item['pivot']['id']}}"  >
                <select class="form-control select2" form="purchase_demand" name="category_id[]" required>
                    <option value="">Select any value</option>
                    @foreach($categories as $depart)
                        <option value="{{ $depart['id'] }}" 
                            {{ $depart['id'] == $item->category_id ? 'selected' : '' }}>
                            {{ $depart['name'] }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <select class="form-control select2" form="purchase_demand" name="item_id[]" required>
                    <option value="">Select any value</option>
                    @foreach($items as $i)
                    @if($i['category_id']==$item['category_id'])
                        <option value="{{ $i->id }}" 
                            {{ $i->id == $item->id ? 'selected' : '' }}>
                            {{ $i->item_name }}
                        </option>
                        @endif
                    @endforeach
                </select>
            </td>

           

            <td>
                <input type="number" step="any" value="{{ $item->pivot->qty }}" min="1" form="purchase_demand" name="qty[]" class="form-control" required>
            </td>

            <td class="std_price">{{ $item->pivot->rate ?? '' }}</td>

            <td>
                <input type="number" step="any" value="{{ $item->pivot->discount }}" form="purchase_demand" name="disc[]" class="form-control" required>
            </td>

            <td class="rate"></td>

            <td>
                <input type="number" step="any" value="{{ $item->pivot->unit_weight }}" form="purchase_demand" name="unit_weight[]" class="form-control" required>
                <input type="hidden" value="{{ $item->pivot->rate }}" form="purchase_demand" name="rate[]">
                <input type="hidden" value="{{ $item->pivot->pricing_by }}" form="purchase_demand" name="pricing_by[]">
                <input type="hidden" value="{{ $item->pivot->unit_feet }}" form="purchase_demand" name="unit_feet[]">
            </td>

            <td class="total_weight"></td>
            <td class="feet">{{ $item->pivot->unit_feet ?? '' }}</td>
            <td class="total_feet"></td>
            <td class="amount"></td>

             <td class="rack">
                <input type="text" step="any" value="{{ $item->pivot->rack }}" form="purchase_demand" name="rack[]" class="form-control" >
            </td>

            <td class="rack_qty">
                <input type="text" step="any" value="{{ $item->pivot->rack_qty }}" form="purchase_demand" name="rack_qty[]" class="form-control last-input" >
            </td>

            <td>
                <button type="button" class="btn text-danger btn-sm removeRow skip-enter">
                    <i class="fa fa-times-circle"></i>
                </button>
            </td>
        </tr>
        @endforeach
    @else

         <tr class="item-row">
      <td class="row-num"></td>
      <td>
        <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="0"  >
        <select class="form-control select2" form="purchase_demand" name="category_id[]" required>
          <option value="">Select any value</option>
          @foreach($categories as $depart)
            <option value="{{$depart['id']}}">{{$depart['name']}}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select class="form-control select2" form="purchase_demand" name="item_id[]" required>
          <option value="">Select any value</option>
        </select>
      </td>
      
      <td>
        
        <input type="number" step="any" value="1" min="1" form="purchase_demand" name="qty[]" class="form-control" required>
      </td>
      <td class="std_price"></td>
      <td>
        <input type="number" step="any" value="" form="purchase_demand" name="disc[]" class="form-control" required>
      </td>
      <td class="rate"></td>
      <td>
        <input type="number" step="any" value="1" form="purchase_demand" name="unit_weight[]" class="form-control" required>
        <input type="hidden" value="" form="purchase_demand" name="unit_feet[]" >
        <input type="hidden" value="" form="purchase_demand" name="pricing_by[]" >
        <input type="hidden" value="" form="purchase_demand" name="rate[]">
      </td>
      <td class="total_weight"></td>
      <td class="feet"></td>
      <td class="total_feet"></td>
      <td class="amount">0</td>
       

            <td class="rack">
            <input type="text" step="any" value="" form="purchase_demand" name="rack[]" class="form-control" >
        </td>

            <td class="rack_qty">
                <input type="text" step="any" value="" form="purchase_demand" name="rack_qty[]" class="form-control last-input" >
            </td>

            
      <td>
        <button type="button" class="btn text-danger btn-sm removeRow skip-enter">
          <i class="fa fa-times-circle"></i>
        </button>
      </td>
    </tr>
    @endif

          
          
        </tbody>
        <tfoot class="table-secondary">
          <tr>

             <th></th>
             
             <th></th>
             <th></th>
             <th id="total_qty">0</th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="total_weight">0</th>
             <th></th>
             <th id="total_ft">0</th>
             
             <th id="total_amount">0</th>
             <th></th>
             <th></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

<div class="row mt-2">
    <div class="col-md-6">
    <button type="button" class="btn btn-sm btn-success" id="addRow">
        <i class="fa fa-plus"></i> Add Item
      </button>
  </div>
  <div class="col-md-6">

         <?php 
                 $per_freight=1.5; $per_loading=0.5; //echo $total_weight.' '.$order['freight_charges'];

                    

                    if(isset($order['freight_charges']) && $total_weight>0)
                    {
                     $per_freight= round($order['freight_charges']/$total_weight,2); 
                      $per_loading= round($order['loading_charges']/$total_weight,2); 
                   }



         ?>


           <!---<div class="form-group row">
            <label  class="col-sm-4 col-form-label1">
                <select class="form-control" name="freight_expense_id" >

                    @foreach($freight_expenses as $fr)
                    <option value="{{$fr['id']}}" {{ $fr->id == $order->freight_expense_id ? 'selected' : '' }} >{{$fr['name'].' '.$fr['code']}}</option>

                    @endforeach
                </select>
            </label>
            <div class="col-sm-4">
              <input type="number" step="any" name="freight_charges_per_unit" class="form-control"  value="{{$per_freight}}" >
            </div>
            <div class="col-sm-4">
              <input type="number" step="any" name="freight_charges" class="form-control"  value="{{ old('freight_charges', $order->freight_charges) }}" >
            </div>
          </div>

          <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Loading Charges</label>
            <div class="col-sm-4">
              <input type="number" step="any" name="loading_charges_per_unit" class="form-control"  value="{{$per_loading}}" >
            </div>
            <div class="col-sm-4">
              <input type="number" step="any" name="loading_charges" class="form-control"  value="{{ old('loading_charges', $order->loading_charges) }}" >
            </div>
          </div>-->


          <!----<div class="form-group row">
            <label  class="col-sm-4 col-form-label">Sales Tax Payable</label>
            <div class="col-sm-8">
              <input type="number" step="any" name="tax1" class="form-control"  value="{{ old('tax1', $order->tax1) }}" >
            </div>
          </div>

          <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Further Sales Tax on Sales</label>
            <div class="col-sm-8">
              <input type="number" step="any" name="tax2" class="form-control"  value="{{ old('tax2', $order->tax2) }}" >
            </div>
          </div>

          <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Advance Income Tax on Sales</label>
            <div class="col-sm-8">
              <input type="number" step="any" name="tax3" class="form-control"  value="{{ old('tax3', $order->tax3) }}" >
            </div>
          </div>---->


          <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Total Amount</label>
            <div class="col-sm-8">
              <input type="text" step="any" name="total_amount"  class="form-control"  value="" readonly>
            </div>
          </div>

          <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Previous Balance</label>
            <div class="col-sm-8">
              <input type="text" step="any" name="previous_balance" class="form-control"  value="{{ old('previous_balance', number_format($order->previous_balance,2)) }}" readonly >
            </div>
          </div>

           <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Total Balance</label>
            <div class="col-sm-8">
              <input type="text" step="any" name="total_balance" class="form-control"  value="" readonly >
            </div>
          </div>

          <!---<div class="form-group row">
            <label  class="col-sm-4 col-form-label">Previous Balance</label>
            <div class="col-sm-8">
              <input type="number" step="any"  class="form-control"  value="" readonly >
            </div>
          </div>

           <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Total Balance</label>
            <div class="col-sm-8">
              <input type="number" step="any" class="form-control"  value="" readonly >
            </div>
          </div>-->
  

  </div>
</div>
        
    </div>
   
    
   

   
</div>

</div>
<!-- End Tabs -->

 </div>

      </form>
    <!-- /.content -->



<!-- Hidden template row -->
<table style="display:none;">
  <tbody id="rowTemplate">
    <tr class="item-row">
      <td class="row-num"></td>
      <td>
        <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="0"  >
        <select class="form-control" form="purchase_demand" name="category_id[]" required>
          <option value="">Select any value</option>
          @foreach($categories as $depart)
            <option value="{{$depart['id']}}">{{$depart['name']}}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select class="form-control" form="purchase_demand" name="item_id[]" required>
          <option value="">Select any value</option>
        </select>
      </td>
      
      <td>
        
        <input type="number" step="any" value="1" min="1" form="purchase_demand" name="qty[]" class="form-control" required>
      </td>
      <td class="std_price"></td>
      <td>
        <input type="number" step="any" value="" form="purchase_demand" name="disc[]" class="form-control" required>
      </td>
      <td class="rate"></td>
      <td>
        <input type="number" step="any" value="1" form="purchase_demand" name="unit_weight[]" class="form-control" required>
        <input type="hidden" value="" form="purchase_demand" name="unit_feet[]" >
        <input type="hidden" value="" form="purchase_demand" name="pricing_by[]" >
        <input type="hidden" value="" form="purchase_demand" name="rate[]">
      </td>
      <td class="total_weight"></td>
      <td class="feet"></td>
      <td class="total_feet"></td>
      <td class="amount">0</td>

        <td class="rack">
            <input type="text" step="any" value="" form="purchase_demand" name="rack[]" class="form-control" >
        </td>

            <td class="rack_qty">
                <input type="text" step="any" value="" form="purchase_demand" name="rack_qty[]" class="form-control last-input" >
            </td>

      <td>
        <button type="button" class="btn text-danger btn-sm removeRow skip-enter">
          <i class="fa fa-times-circle"></i>
        </button>
      </td>
    </tr>
  </tbody>
</table>



<!---------->








<!---Transactions---->
@if(isset($order['id']))    

<?php $transactions = collect($order['transections'])->groupBy('account.id'); ?>

<h4 class="bold text-center">Voucher Transactions</h4>               

<table class="table table-bordered table-hover">

<thead>
<tr>
    <th>#</th>
    <th>Account</th>
    <th>Narration</th>
    <th>Debit</th>
    <th>Credit</th>
    

</tr>
</thead>

<tbody>
    <?php $t=0; $t1=0; $i=1; ?>

@foreach($transactions as $accountId => $accountTrans)
    <?php
        $accountName = $accountTrans[0]['account']['code'].' '.$accountTrans[0]['account']['name'];
        $debitSum = collect($accountTrans)->sum('debit');
        $creditSum = collect($accountTrans)->sum('credit');
        $t += $debitSum;
        $t1 += $creditSum;
    ?>
    <tr>
        <td>{{$i}}</td>
        <td>{{ $accountName }}</td>
        <td>
            {{-- show all narrations together, separated by commas --}}
            {{ collect($accountTrans)->pluck('remarks')->implode(', ') }}
        </td>
        <td>{{ $debitSum }}</td>
        <td>{{ $creditSum }}</td>
    </tr> <?php $i++; ?>
@endforeach
</tbody>

<tfoot>
<tr>
    <th></th>
    <th></th>
    <th></th>
    <th>{{$t}}</th>
    <th>{{$t1}}</th>
    

</tr>
</tfoot>

</table>

@endif
<!-----Transactions---->

        
     

    <form role="form" id="#add_item">
              
            </form>

           

            
          <form role="form" id="delete_form" method="POST" action="{{url('/sale/return/delete/'.$order['id'])}}">     
               @csrf    
           </form>
   
@endsection

@section('jquery-code')


<script type="text/javascript">

var row_num=1;

 let companies = @json($companies);

  let items = @json($items);
    
let customers = @json($customers);


$(document).ready(function(){


$('.select2').select2(); 

  /*$("#item_table").colResizable({
     resizeMode:'overflow'
   });*/

$('select[name="customer_id"]').on('change',function() {  
        var customerId = $(this).val();
        
        if (customerId) {
            
            // Fetch customer info via AJAX
            $.ajax({
                url: '{{ route('customers.info') }}',
                type: 'GET',
                data: {
                    customer_id: customerId
                },
                success: function(response) {
                    if (response.success) {

                       
                        //$('input[name="balance_due"]').val(formatNumber(response.data.due_balance,2));
                        $('input[name="previous_balance"]').val(formatNumber(response.data.balance,2)); 
                        //$('input[name="credit_limits"]').val(formatNumber(response.data.credit_limits,2));
                         //$('input[name="remaining_limit"]').val(formatNumber(response.data.remaining_limit,2));
                        //$('input[name="last_sales"]').val(formatNumber(response.data.last_sales,2));
                        //$('input[name="current_month_sales"]').val(formatNumber(response.data.current_month_sales,2));
                       //$('input[name="current_year_sales"]').val(formatNumber(response.data.current_year_sales));

                       updateFooterTotals();

                        
                    }
                },
                error: function(xhr) {
                    //alert('Error fetching customer information');
                    console.error(xhr.responseText);
                }
            });
        } 
    });


$('select[name="company_id"]').on('change', function () {
        let companyId = $(this).val();
        let branchSelect = $('select[name="branch_id"]');

        branchSelect.empty(); // clear old options

        if (companyId) {
            // Find company in companies array
            let company = companies.find(c => c.id == companyId);

            branchSelect.append('<option value="">Select any branch</option>');

            if (company && company.branches.length > 0) {
                company.branches.forEach(branch => {
                    branchSelect.append(
                        $('<option>', {
                            value: branch.id,
                            text: branch.name
                        })
                    );
                });
            } else {
               // branchSelect.append('<option value="">No branches available</option>');
            }
        }
    });

$('select[name="customer_id"]').on('change', function () {
        let customer_id = $(this).val();
        let credit_days = $('input[name="credit_days"]');
        let due_date = $('input[name="due_date"]');

       /* credit_days.val('0');
        due_date.val(); 

        if (customer_id) {
            // Find company in companies array
            let customer = customers.find(c => c.id == customer_id);

              let today = new Date();
    today.setDate(today.getDate() + customer.credit_days); // add days

    // Format as yyyy-mm-dd
    let year  = today.getFullYear();
    let month = String(today.getMonth() + 1).padStart(2, '0');
    let day   = String(today.getDate()).padStart(2, '0');
    
    let formatted = `${year}-${month}-${day}`;


            credit_days.val(customer.credit_days);

            due_date.val(formatted);

            
        }*/
    });

$(document).on('change', 'select[name="category_id[]"]', function () {
    let categoryId = $(this).val();
    let row = $(this).closest('tr');
    let itemSelect = row.find('select[name="item_id[]"]');

    itemSelect.empty().append('<option value="">Select any value</option>');

    if (categoryId) {
        let filteredItems = items.filter(item => item.category_id == categoryId);

        filteredItems.forEach(item => {
            itemSelect.append(
                $('<option>', { value: item.id, text: item.item_name, 'data-price': item.standard_rate, 'data-weight': item.weight, 'data-feet': item.feet, 'data-pricingby':item.pricing_by })
            );
        });
    }
});

$(document).on('change', 'select[name="item_id[]"]', function () {
    let row = $(this).closest('tr');
    let selected = $(this).find(':selected');

    
    let price = selected.data('price') || 0;
    let weight = selected.data('weight') || 0;
    let feet = selected.data('feet') || 0;
    let pricing_by= selected.data('pricingby');

    
     row.find('.std_price').text(formatNumber(price,2));
    row.find('input[name="unit_weight[]"]').val(weight);
    row.find('.feet').text(formatNumber(feet,2));
    row.find('input[name="rate[]"]').val(price);
    row.find('input[name="unit_feet[]"]').val(feet);
    row.find('input[name="pricing_by[]"]').val(pricing_by);

     updateRowValues(row);

    
});

function updateRowNumbers() {
        $('#selectedItems .item-row').each(function (index) {
            $(this).find('.row-num').text(index + 1);
        });
    }
  
$('#addRow').on('click', function () {
        let newRow = $('#rowTemplate .item-row').clone(); // fresh new row
        $('#selectedItems').append(newRow);

        // Initialize Select2
        newRow.find('select[name="category_id[]"]').addClass('select2');
        newRow.find('select[name="item_id[]"]').addClass('select2');
        newRow.find('.select2').select2();

        updateRowNumbers();
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });


  // if you want one row by default
  /*if (!$('#selectedItems .item-row').length) {

    $('#addRow').trigger('click');
  }*/

$('#selectedItems .item-row').each(function (index) {
            updateRowValues($(this));
        });

  $(document).on('input change', 'input[name="qty[]"], input[name="disc[]"], input[name="unit_weight[]"]', function () {
    let row = $(this).closest('tr');

     updateRowValues(row);
});

  function updateRowValues(row){
      // values
    let qty = parseFormattedNumber(row.find('input[name="qty[]"]').val()) || 0;
    let disc = parseFormattedNumber(row.find('input[name="disc[]"]').val()) || 0;
    let unitWeight = parseFormattedNumber(row.find('input[name="unit_weight[]"]').val()) || 0;
    let stdPrice = parseFormattedNumber(row.find('.std_price').text()) || 0;
    let unitFeet = parseFormattedNumber(row.find('.feet').text()) || 0;
    let pricingBy = row.find('input[name="pricing_by[]"]').val(); // "feet" or "weight"

    let discountAmt = (disc / 100) * stdPrice;

    // calculations
    let rate = stdPrice + discountAmt; // std_price + discount
    let totalWeight = unitWeight * qty;
    let totalFeet = unitFeet * qty;

    let amount = (pricingBy === "feet")
        ? totalFeet * rate
        : totalWeight * rate;

    // update row
     row.find('.rate').text(formatNumber(rate,2));
    row.find('.total_weight').text(formatNumber(totalWeight,2));
    row.find('.total_feet').text(formatNumber(totalFeet,2));
    row.find('.amount').text(formatNumber(amount, 2));

    updateFooterTotals();
  }


  function updateFooterTotals() {
    let totalQty = 0, totalWeight = 0, totalFeet = 0, totalAmount = 0;

    $("#selectedItems tr").each(function () {
        totalQty += parseFormattedNumber($(this).find("input[name='qty[]']").val()) || 0;
        totalWeight += parseFormattedNumber($(this).find(".total_weight").text()) || 0;
        totalFeet += parseFormattedNumber($(this).find(".total_feet").text()) || 0;
        totalAmount += parseFormattedNumber($(this).find(".amount").text()) || 0;  //alert(totalQty);
    });
    

    $("#total_qty").text(formatNumber(totalQty,2));
    $("#total_weight").text(formatNumber(totalWeight,2));
    $("#total_ft").text(formatNumber(totalFeet,2));
    $("#total_amount").text(formatNumber(totalAmount,2));

    updateChargesAndTaxes(totalWeight, totalAmount);
}



function updateChargesAndTaxes(totalWeight, baseAmount) {
    let $freightPerUnitInput = $("input[name='freight_charges_per_unit']");
    let $freightTotalInput = $("input[name='freight_charges']");
    let $loadingPerUnitInput = $("input[name='loading_charges_per_unit']");
    let $loadingTotalInput = $("input[name='loading_charges']");

    let $previousBalanceInput = $("input[name='previous_balance']");
    let $totalBalanceInput = $("input[name='total_balance']");

    let freightPerUnit = parseFormattedNumber($freightPerUnitInput.val()) || 0;
    let freightTotal = parseFormattedNumber($freightTotalInput.val()) || 0;

    let loadingPerUnit = parseFormattedNumber($loadingPerUnitInput.val()) || 0;
    let loadingTotal = parseFormattedNumber($loadingTotalInput.val()) || 0;

    let previousBalance = parseFormattedNumber($previousBalanceInput.val()) || 0;
    let totalBalance = parseFormattedNumber($totalBalanceInput.val()) || 0;

    // --- Freight Logic ---
    if ($freightPerUnitInput.is(":focus")) {
        // User is typing per unit → update total only
        freightTotal = freightPerUnit * totalWeight;
        $freightTotalInput.val(freightTotal ? freightTotal.toFixed(2) : "");
    } else if ($freightTotalInput.is(":focus")) {
        // User is typing total → update per unit only
        freightPerUnit = totalWeight > 0 ? (freightTotal / totalWeight) : 0;
        $freightPerUnitInput.val(freightPerUnit ? freightPerUnit.toFixed(2) : "");
    } else {
        // If not editing, keep both in sync
        freightTotal = freightPerUnit * totalWeight;
        $freightTotalInput.val(freightTotal ? freightTotal.toFixed(2) : "");
    }

    // --- Loading Logic ---
    if ($loadingPerUnitInput.is(":focus")) {
        loadingTotal = loadingPerUnit * totalWeight;
        $loadingTotalInput.val(loadingTotal ? loadingTotal.toFixed(2) : "");
    } else if ($loadingTotalInput.is(":focus")) {
        loadingPerUnit = totalWeight > 0 ? (loadingTotal / totalWeight) : 0;
        $loadingPerUnitInput.val(loadingPerUnit ? loadingPerUnit.toFixed(2) : "");
    } else {
        loadingTotal = loadingPerUnit * totalWeight;
        $loadingTotalInput.val(loadingTotal ? loadingTotal.toFixed(2) : "");
    }

    // --- Taxes ---
    /*let tax1 = parseFloat($("input[name='tax1']").val()) || 0;
    let tax2 = parseFloat($("input[name='tax2']").val()) || 0;
    let tax3 = parseFloat($("input[name='tax3']").val()) || 0;

    let tax1Amt = baseAmount * tax1 / 100;
    let tax2Amt = baseAmount * tax2 / 100;
    let tax3Amt = baseAmount * tax3 / 100;*/

    // --- Final Total ---

     let grandTotal = baseAmount + freightTotal + loadingTotal; //+ tax1Amt + tax2Amt + tax3Amt;
    $("input[name='total_amount']").val(formatNumber(grandTotal,2));

     let bal= previousBalance-grandTotal;

      
      $totalBalanceInput.val(formatNumber(bal,2));
}


$(document).on("input", "input[name='freight_charges_per_unit'], input[name='freight_charges'], input[name='loading_charges_per_unit'], input[name='loading_charges'], input[name='tax1'], input[name='tax2'], input[name='tax3']", function () {
    updateFooterTotals();
});

// Call once on page load
let id=$('input[name="id"]');
if (!(id && id.length > 0)) {
    $('select[name="customer_id"]').trigger("change");
}
updateFooterTotals();
updateRowNumbers();



$('#purchase_demand').validate({
  // Let the hidden items_check be validated (others can still be ignored)
  rules: {
    
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
      $('#selectedItemsError').after(error);
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


  /*$('#purchase_demand').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var rows=getRowNum();

for (var i =1; i <= rows ;  i++) {
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

 function getRowNum() 
 {
  return this.row_num;
}

function setRowNum() 
 {
   this.row_num++;
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

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit,id:
         items[i]['id']};
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


 function setCustomers(customers)
 {
  
  
  var new_customers=[];
 
 for(var i = 0 ; i < customers.length ; i++)
 {
  

         var let={ mobile:customers[i]['mobile'],customer:customers[i]['name'],id:customers[i]['id'],address:customers[i]['address'] };
         //alert(let);
         new_customers.push(let);
 }


$('#customer_id').inputpicker({
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

$('#dispatch_to_id').inputpicker({
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

$('#invoice_to_id').inputpicker({
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
      setCustomers(customers);
   
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





       

 



function setPackSize(row)
{
  unit=$(`#unit_${row}`).val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById(`p_s_${row}`).setAttribute('readonly', 'readonly');
  $(`#p_s_${row}`).val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById(`p_s_${row}`).removeAttribute('readonly');
}

function setTotalQty(row)
{
  qty=$(`#qty_${row}`).val();
  p_s=$(`#p_s_${row}`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $(`#total_qty_${row}`).val(total_qty); 
   
   if(row!=0)
   setNetQty();
}

function setNetQty() //for end of tabel to show net
{
  var rows=getRowNum();
  
   var net_total_qty=0, net_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).val();
       var qty=$(`#qty_${i}`).val();

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
     var item_id=$("#item_code").val();

    

     var tbl_item_id=$(`#item_id_${i}`).val(); 

     if(item_id == tbl_item_id)
      return true;
     
  
   }
  return false;   
   
}

function isItem(item_name)
{
  var bool=false;
  $.ajax({
               type:'get',
               url:'{{ url("/item/exist") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     item_name: item_name,
                  

               },
               success:function(data) {

                bool = data;


               }
             });

     return bool;
  }

function addItem()
{
  var item_id=$("#item_code").val();
var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   var item_name=s.val(); //alert(item_name);alert(item_id);
  //alert(item_combine);

  //   item_combine=item_combine.split('_');
  
  //   if(item_combine!='')
  //   {
  //   var item_name=item_combine[3];
  //   var item_code=item_combine[1];
  //   var item_color=item_combine[9];
  //   var item_size=item_combine[7];
  //   var item_uom=item_combine[5];
  //   var item_id=item_combine[11];
  // }
  // else
  // {
  //   var item_name='';
  //   var item_code='';
  //   var item_color='';
  //   var item_size='';
  //   var item_uom='';
  //   var item_id='';
  // }

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
 
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total=$("#total_qty_0").val();

var readonly='';
  if(unit=='loose')
     readonly='readonly';
    
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
     if(item_name=='' ||  unit=='' || qty=='' || dbl_item==true)
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
      
        
     var row=this.row_num;   


     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <input type="hidden" form="purchase_demand"  name="quotation_items_id[]" value=""  >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" class="form-control" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true"></td>

     <td><input type="number" class="form-control" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setTotalQty(${row})" required="true"></td>

     <td><input type="number" class="form-control" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setTotalQty(${row})" ${readonly} required="true"></td>
     

     
     <td><input type="number" class="form-control" value="${total}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>
     

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
  var item_id=$("#item_code").val();
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   var item_name=s.val();

  //   item_combine=item_combine.split('_');
  
  //   if(item_combine!='')
  //   {
  //   var item_name=item_combine[3];
  //   var item_code=item_combine[1];
  //   var item_color=item_combine[9];
  //   var item_size=item_combine[7];
  //   var item_uom=item_combine[5];
  //   var item_id=item_combine[11];
  // }
  // else
  // {
  //   var item_name='';
  //   var item_code='';
  //   var item_color='';
  //   var item_size='';
  //   var item_uom='';
  //   var item_id='';
  // }

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
  var unit=$("#unit_0").val();
  var qty=$("#qty_0").val();
  var p_s=$("#p_s_0").val();
  var total=$("#total_qty_0").val();

  var dbl_item=false;
  if(item_name!='')
  {
     //dbl_item=checkItem(row);
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
        
        $(`#unit_${row}`).val(unit);
        $(`#qty_${row}`).val(qty);
        $(`#p_s_${row}`).val(p_s);

      $(`#location_text_${row}`).text(location_text);
     //$(`#code_${row}`).text(item_code);
      
      $(`#item_name_${row}`).text(item_name);
      
      //$(`#color_${row}`).text(item_color);
      //$(`#size_${row}`).text(item_size);
      //$(`#item_uom_${row}`).text(item_uom);
      

       $(`#total_qty_${row}`).val(total_qty);
     
     
      if(p_s==null)
        p_s='';
     
   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');


  $("#location").val('');
  $("#unit_0").val('loose');
  $("#qty_0").val('1');
  $("#p_s_0").val('1');
  $("#total_qty_0").val('1');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');


  document.getElementById('p_s_0').setAttribute('readonly', 'readonly');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
   
   }
     
}  //end update item


function editItem(row)
{
   
   var item_name=$(`#item_name_${row}`).text();
   //var item_code=$(`#code_${row}`).text();
   var item_id=$(`#item_id_${row}`).val();
   //var item_color=$(`#color_${row}`).text();
   //var item_uom=$(`#item_uom_${row}`).text();
   //var item_size=$(`#size_${row}`).text();
   
   //combine='code_'+item_code+'_name_'+item_name+'_uom_'+item_uom+'_size_'+item_size+'_color_'+item_color+'_id_'+item_id;

   $('#item_code').val(item_id);
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(item_name);


var location_id=$(`#location_id_${row}`).val();
$('#location').val(location_id);


var unit=$(`#unit_${row}`).val();
$('#unit_0').val(unit);



  var qty=$(`#qty_${row}`).val();
$('#qty_0').val(qty);


  var p_s=$(`#p_s_${row}`).val();
  $('#p_s_0').val(p_s);
  


  var total_qty=$(`#total_qty_${row}`).val();
  $('#total_qty_0').val(total_qty);

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

  if(unit=='' || unit=='loose')
  {
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  $("#p_s_0").val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('p_s_0').removeAttribute('readonly');

}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
    $(`#${row}`).remove();
      setNetQty();
});

}



function setQuotations()
{
    var customer_id=$('#customer_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/customer/new/quotations") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     customer_id: customer_id,
                  

               },
               success:function(data) {

                var orders = data;
                  opt_txt=`<option value="">Select any quotation</option>`;

                      for (var i =0; i < orders.length ;  i++) {
                            txt    = `<option value="${orders[i]['id']}">${orders[i]['doc_no']}</option>` ;
                  
                  opt_txt= opt_txt + txt;
                      }

                      $('#quotation_id').empty().append(opt_txt);

               }
             });


}


function uploadQuotation()
{
  var quotation_id=$('#quotation_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/quotation") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     quotation_id: quotation_id,
                  

               },
               success:function(data) {
                  
                  var quotation=data;
                var items = quotation['item_list'];
            
                  //alert(JSON.stringify( quotation) );
                  $('#selectedItems').html('');

                      for (var i =0; i < items.length ;  i++) {

                        var row=getRowNum();

                      

                         var item_id=items[i]['item_id'];

                         var item_name=items[i]['item']['item_name'];
                           var unit=items[i]['unit'];
                              var qty=items[i]['qty'];
                              var p_s=items[i]['pack_size'];

                              var quotation_item_id=items[i]['id'];
      var location='';
     var location_text='';
  
                            
                           var total=qty * p_s;

                              var readonly='';
                             if(unit=='loose')
                              readonly='readonly';
                        

                            
      var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >

     <input type="hidden" form="purchase_demand"  name="quotation_items_id[]" value="${quotation_item_id}"  >

     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}" >
     
     
     <td ondblclick="editItem(${row})" id="location_text_${row}">${location_text}</td>

     <td ondblclick="editItem(${row})" id="code_${row}"></td>

     <td ondblclick="editItem(${row})" id="item_name_${row}">${item_name}</td>
       
       <td ondblclick="editItem(${row})" id="item_uom_${row}"></td>

     <td><input type="text" class="form-control" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" required="true"></td>

     <td><input type="number" class="form-control" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" onchange="setTotalQty(${row})" required="true"></td>

     <td><input type="number" class="form-control" value="${p_s}" min="1" form="purchase_demand" name="p_s[]" id="p_s_${row}" onchange="setTotalQty(${row})" ${readonly} required="true"></td>
     

     
     <td><input type="number" class="form-control" value="${total}" min="1" form="purchase_demand" id="total_qty_${row}" readonly ></td>
     

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

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

@endsection  
  