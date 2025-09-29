
@extends('layout.master')
@section('title')
    {{ isset($order['id']) ? 'Edit the Delivery Challan' : 'Add New Delivery Challan' }}
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
                    <h1><i class="fas fa-file-invoice mr-2"></i>Delivery Challan</h1>
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
                        <a href="{{url('delivery-challan/create')}}" class="btn btn-action">
                            <i class="fas fa-plus"></i> New
                        </a>
                        @endif
                        <a href="{{url('delivery-challan/history')}}" class="btn btn-action">
                            <i class="fas fa-history"></i> History
                        </a>


                       @if(isset($order['id']))
                         <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle"  data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('/delivery-challan/report/'.$order['id'].'/local')}}" class="dropdown-item">Delivery Challan</a></li>
                     <!-- <li><a href="{{url('/delivery-challan/report/'.$order['id'].'/tendor')}}" class="dropdown-item">Delivery Challan(Tendor)</a></li>
                      <li><a href="{{url('/delivery-challan/report1/'.$order['id'])}}" class="dropdown-item">Delivery Challan1</a></li>
                      <li><a href="{{url('/delivery-challan/form/'.$order['id'])}}" class="dropdown-item">Form</a></li>
                      <li><a href="{{url('warranty-invoice/fahmir/'.$order['id'])}}" class="dropdown-item">Warrenty (Fahmir)</a></li>
                      <li><a href="{{url('warranty-invoice/alsehat/'.$order['id'])}}" class="dropdown-item">Warrenty (Al-Sehat)</a></li>-->
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
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ isset($order['id']) ? 'Edit the Delivery Challan' : 'Add New Delivery Challan' }}</li>
                </ol>
            </nav>
        </div>
      </div>
        <!---------->
     
  @endsection

@section('content')
    <!-- Main content -->

<form role="form" id="purchase_demand" method="POST" action="{{ isset($order['id']) ? url('/delivery-challan/update') : url('/delivery-challan/save') }}">
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
                  <label>Delivery No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control" value="{{ old('doc_no', $order->doc_no) }}" readonly required >
                  </div>


                <div class="form-group col-md-4">
                  <label>Delivery Date</label>
                  <input type="date" form="purchase_demand" name="challan_date" class="form-control " value="{{ old('challan_date', $order->challan_date ?? date('Y-m-d')) }}" required >
                  </div>

                   <!----<div class="form-group">
                  <label>Financial Year</label>

                   <input type="text" form="purchase_demand" name="financial_year" class="form-control " value="{{ old('financial_year', $order->financial_year) }}" readonly required >

                  
                  </div>-->

                  <div class="form-group col-md-4">
                  <label>Sale Order No.</label>
                  <input type="text" form="purchase_demand" name="order_no" class="form-control" value="{{ $order->order->doc_no ?? '' }}" readonly >
                  <input type="hidden" form="purchase_demand" name="order_id" class="form-control" value="{{ $order->order_id }}" readonly >
                  </div>


                <div class="form-group col-md-4">
                  <label>Sale Order Date</label>
                  <input type="date" form="purchase_demand" name="order_date" class="form-control" value="{{  $order->order->order_date ?? '' }}" readonly >
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

                <div class="form-group col-md-4">
                  <!--<input type="checkbox" form="purchase_demand" name="active" value="1" id="active" class=""  checked>
                  <label>Active</label>-->
                  <label>Status</label>
                  <select class="form-control" name="status"  required>
                    
                    

               <option value="1" {{ old('status', $order->status ?? 1) == '1' ? 'selected' : '' }}>Post</option>
                <option value="0" {{ old('status', $order->status ?? 1) == '0' ? 'selected' : '' }}>Unpost</option>

                  </select>
                  </div>



            

                                
                <!-- /.form-group -->
               
            
            


              
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

                 <div class="form-group col-md-4">
                  <label>Remarks</label>
                   <input type="text" form="purchase_demand" name="remarks" class="form-control " value="{{ old('remarks', $order->remarks) }}"   >
                </div>




                    

                

            

                           
                                
             



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
             <th>Qty AV</th>
             <th>Qty</th>
             <th>Unit Weight</th>
             <th>Total Weight</th>
             <th>FT</th>
             <th>Total FT</th>
             <th>Rack</th>
             <th>Rack Qty</th>
             <th>Loading SQ</th>

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

              <?php $total_weight=0; ?>
            @if(isset($order['items']) && count($order['items']) > 0)
        @foreach($order['items']  as $item)

        <?php 


              $total_weight+=$item['pivot']['qty']*$item['pivot']['unit_weight']; 
                   
                   /**/

                    $av_qty_txt='';  $av_qty='';  $av_rack_qty='';
                        
                        if($item['pivot']['id']>0){

                            if($item['pivot']['av_qty'])
                        { $av_qty_txt .= $item['pivot']['av_qty'];    $av_qty=$item['pivot']['av_qty']; }

                    if($item['pivot']['av_rack_qty'])
                        { $av_qty_txt .= $item['pivot']['av_rack_qty'];    $av_rack_qty=$item['pivot']['av_rack_qty']; }


                        }
                        else{
                    $info = $item->getQtyWithRack();

                   $av_qty_txt=$info['total_qty'];   $av_qty=$info['total_qty'];

                   if($info['rack_qty']!='')
                    {$av_qty_txt .=' ['.$info['rack_qty'].']';     $av_rack_qty=' ['.$info['rack_qty'].']'; }
                }

         ?>

        <tr class="item-row">
            <td class="row-num"></td>

            <td><input type="hidden" form="purchase_demand"  name="pivots_id[]" value="{{$item['pivot']['id']}}"  >
                 <input type="hidden" form="purchase_demand"  name="av_qty[]" value="{{$av_qty}}"  >
                 <input type="hidden" form="purchase_demand"  name="av_rack_qty[]" value="{{$av_rack_qty}}"  >
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
                            {{ $i->full_name }}
                        </option>
                        @endif
                    @endforeach
                </select>
            </td>

            <td class="qty_av">{{$av_qty_txt}}</td>

            <td>
                <input type="number" step="any" value="{{ $item->pivot->qty }}" min="1" form="purchase_demand" name="qty[]" class="form-control" required>
            </td>

           

            

            <td>
                <input type="number" step="any" value="{{ $item->pivot->unit_weight }}" form="purchase_demand" name="unit_weight[]" class="form-control" required>
                <input type="hidden" value="{{ $item->pivot->unit_feet }}" form="purchase_demand" name="unit_feet[]" >
            </td>

            <td class="total_weight"></td>
            <td class="feet">{{ $item->pivot->unit_feet ?? '' }}</td>
            <td class="total_feet"></td>

            <td class="rack">
                <input type="text" step="any" value="{{ $item->pivot->rack }}" form="purchase_demand" name="rack[]" class="form-control" >
            </td>

            <td class="rack_qty">
                <input type="text" step="any" value="{{ $item->pivot->rack_qty }}" form="purchase_demand" name="rack_qty[]" class="form-control" >
            </td>

            <td class="loading_sq">
                <input type="text" step="any" value="{{ $item->pivot->loading_sq }}" form="purchase_demand" name="loading_sq[]" class="form-control last-input" >
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
        <input type="hidden" form="purchase_demand"  name="av_qty[]" value="0"  >
         <input type="hidden" form="purchase_demand"  name="av_rack_qty[]" value="0"  >
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
      
         <td class="qty_av"></td>

         <td>
                <input type="number" step="any" value="" min="1" form="purchase_demand" name="qty[]" class="form-control" required>
            </td>

      <td>
        <input type="number" step="any" value="1" form="purchase_demand" name="unit_weight[]" class="form-control" required>
        <input type="hidden" value="" form="purchase_demand" name="unit_feet[]" >
      </td>
      <td class="total_weight"></td>
      <td class="feet"></td>
      <td class="total_feet"></td>

       <td class="rack">
            <input type="text" step="any" value="" form="purchase_demand" name="rack[]" class="form-control" >
        </td>

            <td class="rack_qty">
                <input type="text" step="any" value="" form="purchase_demand" name="rack_qty[]" class="form-control" >
            </td>

            <td class="loading_sq">
                <input type="text" step="any" value="" form="purchase_demand" name="loading_sq[]" class="form-control last-input" >
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
             <th></th>
             <th id="total_qty">0</th>
             <th></th>
             <th id="total_weight">0</th>
             <th></th>
             <th id="total_ft">0</th>
             <th></th>
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


           <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Freight Charges</label>
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
          </div>


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
          </div>


          <div class="form-group row">
            <label  class="col-sm-4 col-form-label">Total Amount</label>
            <div class="col-sm-8">
              <input type="number" step="any" name="total_amount"  class="form-control"  value="" readonly>
            </div>
          </div>

          <div class="form-group row">
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
        <input type="hidden" form="purchase_demand"  name="av_qty[]" value="0"  >
         <input type="hidden" form="purchase_demand"  name="av_rack_qty[]" value="0"  >
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
      
         <td class="qty_av"></td>

         <td>
                <input type="number" step="any" value="" min="1" form="purchase_demand" name="qty[]" class="form-control" required>
            </td>

      <td>
        <input type="number" step="any" value="1" form="purchase_demand" name="unit_weight[]" class="form-control" required>
        <input type="hidden" value="" form="purchase_demand" name="unit_feet[]" >
      </td>
      <td class="total_weight"></td>
      <td class="feet"></td>
      <td class="total_feet"></td>

       <td class="rack">
            <input type="text" step="any" value="" form="purchase_demand" name="rack[]" class="form-control" >
        </td>

            <td class="rack_qty">
                <input type="text" step="any" value="" form="purchase_demand" name="rack_qty[]" class="form-control" >
            </td>

            <td class="loading_sq">
                <input type="text" step="any" value="" form="purchase_demand" name="loading_sq[]" class="form-control last-input" >
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
                   



        
     

    <form role="form" id="#add_item">
              
            </form>

            

             <form role="form" id="delete_form" method="POST" action="{{url('/challan/delete/'.$order['id'])}}">
               
               @csrf    
             </form>
   
@endsection

@section('jquery-code')


<script type="text/javascript">

var row_num=1;

 let companies = @json($companies);

  let items = @json($items);
    



$(document).ready(function(){


$('.select2').select2(); 

  /*$("#item_table").colResizable({
     resizeMode:'overflow'
   });*/


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

$(document).on('change', 'select[name="category_id[]"]', function () {
    let categoryId = $(this).val();
    let row = $(this).closest('tr');
    let itemSelect = row.find('select[name="item_id[]"]');

    itemSelect.empty().append('<option value="">Select any value</option>');

    if (categoryId) {
        let filteredItems = items.filter(item => item.category_id == categoryId);

        filteredItems.forEach(item => {
            itemSelect.append(
                $('<option>', { value: item.id, text: item.full_name, 'data-weight': item.weight, 'data-feet': item.feet  })
            );
        });
    }
});

$(document).on('change', 'select[name="item_id[]"]', function () {
    let row = $(this).closest('tr');
    let selected = $(this).find(':selected');

    let item_id = $(this).val();

    
    //let price = selected.data('price') || 0;
    let weight = selected.data('weight') || 0;
    let feet = selected.data('feet') || 0;
    //let pricing_by= selected.data('pricingby');

   

    //row.find('.std_price').text(formatNumber(price,2));
    row.find('input[name="unit_weight[]"]').val(weight);
    row.find('.feet').text(formatNumber(feet,2));
    //row.find('input[name="rate[]"]').val(price);
    row.find('input[name="unit_feet[]"]').val(feet);
     //row.find('input[name="pricing_by[]"]').val(pricing_by);

     updateRowValues(row);

     if (item_id) {
            
            // Fetch customer info via AJAX
            $.ajax({
                url: '{{ url('get-item-qty-rackwise') }}',
                type: 'GET',
                data: {
                    item_id: item_id
                },
                success: function(response) {
                    if (response.success) {

                       
                       let qty=response.data.total_qty;
                       let rack=response.data.rack_qty;  
                       let txt= qty;

                       let txt1='';

                       if(rack!=''){
                         txt1 =  '[' + rack + ']';
                       }
                        row.find('.qty_av').text(txt+' '+txt1);

                         row.find('input[name="av_qty[]"]').val(qty);
                          row.find('input[name="av_rack_qty[]"]').val(txt1);
                       

                        
                    }
                },
                error: function(xhr) {
                    //alert('Error fetching customer information');
                    console.error(xhr.responseText);
                }
            });
        } 

    
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

  $(document).on('input change', 'input[name="qty[]"], input[name="unit_weight[]"]', function () {
    let row = $(this).closest('tr');

     updateRowValues(row);
});

  function updateRowValues(row){
      // values
    let qty = parseFormattedNumber(row.find('input[name="qty[]"]').val()) || 0;
   // let disc = parseFormattedNumber(row.find('input[name="disc[]"]').val()) || 0;
    let unitWeight = parseFormattedNumber(row.find('input[name="unit_weight[]"]').val()) || 0;
    //let stdPrice = parseFormattedNumber(row.find('.std_price').text()) || 0;
    let unitFeet = parseFormattedNumber(row.find('.feet').text()) || 0;
    //let pricingBy = row.find('input[name="pricing_by[]"]').val(); // "feet" or "weight"

    //let discountAmt = (disc / 100) * stdPrice;

    // calculations
    //let rate = stdPrice + discountAmt; // std_price + discount
    let totalWeight = unitWeight * qty;
    let totalFeet = unitFeet * qty;

    //let amount = (pricingBy === "feet")
      //  ? totalFeet * rate
        //: totalWeight * rate;

    // update row
    //row.find('.rate').text(formatNumber(rate,2));
    row.find('.total_weight').text(formatNumber(totalWeight,2));
    row.find('.total_feet').text(formatNumber(totalFeet,2));
    //row.find('.amount').text(formatNumber(amount, 2));

    updateFooterTotals();
  }


  function updateFooterTotals() {
    let totalQty = 0, totalWeight = 0, totalFeet = 0, totalAmount = 0;

    $("#selectedItems tr").each(function () {
        totalQty += parseFormattedNumber($(this).find("input[name='qty[]']").val()) || 0;
        totalWeight += parseFormattedNumber($(this).find(".total_weight").text()) || 0;
        totalFeet += parseFormattedNumber($(this).find(".total_feet").text()) || 0;
        //totalAmount += parseFormattedNumber($(this).find(".amount").text()) || 0;  //alert(totalQty);
    });
    

    $("#total_qty").text(formatNumber(totalQty,2));
    $("#total_weight").text(formatNumber(totalWeight,2));
    $("#total_ft").text(formatNumber(totalFeet,2));
    //$("#total_amount").text(formatNumber(totalAmount,2));

    updateChargesAndTaxes(totalWeight, totalAmount);
}



function updateChargesAndTaxes(totalWeight, baseAmount) {
    let $freightPerUnitInput = $("input[name='freight_charges_per_unit']");
    let $freightTotalInput = $("input[name='freight_charges']");
    let $loadingPerUnitInput = $("input[name='loading_charges_per_unit']");
    let $loadingTotalInput = $("input[name='loading_charges']");

    let freightPerUnit = parseFormattedNumber($freightPerUnitInput.val()) || 0;
    let freightTotal = parseFormattedNumber($freightTotalInput.val()) || 0;

    let loadingPerUnit = parseFormattedNumber($loadingPerUnitInput.val()) || 0;
    let loadingTotal = parseFormattedNumber($loadingTotalInput.val()) || 0;

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

    /*// --- Taxes ---
    let tax1 = parseFloat($("input[name='tax1']").val()) || 0;
    let tax2 = parseFloat($("input[name='tax2']").val()) || 0;
    let tax3 = parseFloat($("input[name='tax3']").val()) || 0;

    let tax1Amt = baseAmount * tax1 / 100;
    let tax2Amt = baseAmount * tax2 / 100;
    let tax3Amt = baseAmount * tax3 / 100;

    // --- Final Total ---
    let grandTotal = baseAmount + freightTotal + loadingTotal + tax1Amt + tax2Amt + tax3Amt;
    $("input[name='total_amount']").val(grandTotal.toFixed(2));*/
}


$(document).on("input", "input[name='freight_charges_per_unit'], input[name='freight_charges'], input[name='loading_charges_per_unit'], input[name='loading_charges']", function () { //, input[name='tax1'], input[name='tax2'], input[name='tax3']
    updateFooterTotals();
});

// Call once on page load
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


});


</script>

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

@endsection  
  