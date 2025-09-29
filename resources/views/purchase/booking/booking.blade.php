
@extends('layout.master')
@section('title')
    {{ isset($order['id']) ? 'Edit the Booking' : 'Add New Booking' }}
@endsection
@section('header-css')


@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

          <!-- Page Header -->


      <div class="row default-header"  >
          <div class="col-sm-6">
            <h1>Purchase Booking</h1>
           </div>
          <div class="col-sm-6 text-right">

            <button form="purchase_demand" type="submit" class="btn btn-primary"><span class="fas fa-save"></span>{{ isset($order['id']) ? 'Update' : 'Save' }}</button>

             @if(isset($order['id']))
                        <button type="button"  class="btn btn-action" data-toggle="modal" data-target="#modal-del" >
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <a href="{{url('purchase-bookings/create')}}" class="btn btn-action">
                            <i class="fas fa-plus"></i> New
                        </a>
                        @endif
            
            <a class="btn btn-transparent" href="{{url('purchase-bookings')}}" ><span class="fas fa-history"></span>History</a>

            @if(isset($order['id']))
                         <div class="btn-group">
                    <button type="button"  class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('purchase-bookings/report/'.$order['id'])}}" class="dropdown-item">Report</a></li>
                      
                    </ul>
                  </div> 
                  @endif

            
          </div>
        </div>

           <ol class="breadcrumb default-breadcrumb"  >
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase</a></li>
              <li class="breadcrumb-item"><a href="#">Booking</a></li>
              <li class="breadcrumb-item active">{{ isset($order['id']) ? 'Edit' : 'Add' }}</li>
            </ol>



        <!---------->
     
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

@if(isset($order['id']))
    <form role="form" id="delete_form" method="POST" action="{{ route('purchase-bookings.destroy', $order['id']) }}">
                @csrf 
                @method('DELETE')        
    </form>
    @endif


<form role="form" id="purchase_demand" method="POST" action="{{ isset($order['id']) ? route('purchase-bookings.update',$order['id']) : route('purchase-bookings.store') }}">

    @csrf

     @if(isset($order['id']))
            @method('PUT')
        @endif

      <!--<input type="hidden" value="{{csrf_token()}}" name="_token"/>-->

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
                  <label>Purchase Booking</label>
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control" value="{{ old('doc_no', $order->doc_no) }}" readonly required >
                  </div>


                <div class="form-group col-md-4">
                  <label>Purchase Booking Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control " value="{{ old('doc_date', $order->doc_date ?? date('Y-m-d')) }}" required >
                  </div>

                   

                 

                <!---<div class="form-group col-md-4">
                  
                  <label>Order Status</label>
                  <select class="form-control" name="status"  required>
                   <option value="1" {{ old('status', $order->status ?? 1) == '1' ? 'selected' : '' }}>Post</option>
                  <option value="0" {{ old('status', $order->status ?? 1) == '0' ? 'selected' : '' }}>Unpost</option>
                  </select>
                  </div>
                  ------->



              
            


              
                <!--<h4 class="form-section-title"><i class="fas fa-user mr-2"></i>Vendor</h4>-->

                <div class="form-group col-md-4">
                  <label>Vendor</label>
                  <select class="form-control select2" name="vendor_id"  required>
                    
                     <option value="">Select any value</option>

                   @foreach($vendors as $comp)
                <option value="{{$comp['id']}}" {{ old('vendor_id', $order->vendor_id) == $comp->id ? 'selected' : '' }}>{{$comp['name']}}</option>
                    @endforeach
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

                     
                       <div class="form-group col-md-4">
                  <label>Remarks</label>
                  <input type="text" form="purchase_demand" name="remarks" class="form-control " value="{{ old('remarks', $order->remarks) }}"   >
                </div> 

                      
             


            </div>
            <!-- /.row -->

            

                           
                                
             



<!-- Start Tabs -->
<div class=" mb-4">

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
             <th style="width: 150px;" >Category</th>
           
            
             <th>Disc/Gain %</th>
            
             <th>Total Weight</th>
             <th>Remarks</th>
            

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

              <?php $total_weight=0; ?>

            @if(isset($order['categories']) && count($order['categories']) > 0)
        @foreach($order['categories']  as $item)

        <?php $total_weight+=$item['pivot']['weight']; 

                 
         ?>

        <tr class="item-row">
            <td class="row-num"></td>

            <td>  <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="{{$item['pivot']['id']}}"  >
                
                <select class="form-control select2" form="purchase_demand" name="category_id[]"  required>
                    <option value="">Select any value</option>
                    @foreach($categories as $depart)
                        <option value="{{ $depart['id'] }}" 
                            {{ $depart['id'] == $item->id ? 'selected' : '' }}>
                            {{ $depart['name'] }}
                        </option>
                    @endforeach
                </select>
            </td>

           
            <td>
                <input type="number" step="any" value="{{ $item->pivot->discount }}" form="purchase_demand" name="disc[]" class="form-control" required>
            </td>

          
            <td>
                <input type="number" step="any" value="{{ $item->pivot->weight }}" form="purchase_demand" name="weight[]" class="form-control" required>
            </td>

            <td><input type="text"  value="{{ $item->pivot->remarks }}" form="purchase_demand" name="item_remarks[]" class="form-control last-input" ></td>
           
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

            <td>  <input type="hidden" form="purchase_demand"  name="pivots_id[]" value="0"  >
                
                <select class="form-control select2" form="purchase_demand" name="category_id[]"  required>
                    <option value="">Select any value</option>
                    @foreach($categories as $depart)
                        <option value="{{ $depart['id'] }}" >
                            {{ $depart['name'] }}
                        </option>
                    @endforeach
                </select>
            </td>

           
            <td>
                <input type="number" step="any" value="0.0" form="purchase_demand" name="disc[]" class="form-control" required>
            </td>

          
            <td>
                <input type="number" step="any" value="0" form="purchase_demand" name="weight[]" class="form-control" required>
            </td>

            <td><input type="text"  value="" form="purchase_demand" name="item_remarks[]" class="form-control last-input" ></td>
           
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
             <th id="total_weight">0</th>
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
        <input type="number" step="any" value="0" form="purchase_demand" name="disc[]" class="form-control" >
      </td>
      
      <td>
        <input type="number" step="any" value="0" form="purchase_demand" name="weight[]" class="form-control" >
      </td>
      <td>
        <input type="text"  value="" form="purchase_demand" name="item_remarks[]" class="form-control last-input" >
      </td>
      
      <td>
        <button type="button" class="btn text-danger removeRow skip-enter">
          <i class="fa fa-times-circle"></i>
        </button>
      </td>
    </tr>
  </tbody>
</table>



<!---------->
                   



        
     

   
@endsection

@section('jquery-code')


<script type="text/javascript">

var row_num=1;

 let companies = @json($companies);

  let items = @json($items);
    let vendors = @json($vendors);



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

/*$('select[name="vendor_id"]').on('change', function () {
        let vendor_id = $(this).val();
        
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
     let item_id = $(this).val();
    
    let price = selected.data('price') || 0;
    let weight = selected.data('weight') || 0;
    let feet = selected.data('feet') || 0;
    let pricing_by= selected.data('pricingby');

    row.find('.std_price').text(price);
    row.find('input[name="unit_weight[]"]').val(weight);
    row.find('.feet').text(feet);
    row.find('input[name="rate[]"]').val(price);
    row.find('input[name="unit_feet[]"]').val(feet);
     row.find('input[name="pricing_by[]"]').val(pricing_by);

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

                       //if(rack!=''){
                         //txt = txt + '[' + rack + ']';
                       //}
                        row.find('.qty_av').text(txt);
                        row.find('input[name="av_qty[]"]').val(qty);
                       

                        
                    }
                },
                error: function(xhr) {
                    //alert('Error fetching customer information');
                    console.error(xhr.responseText);
                }
            });
        } 

    
});*/

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
        //newRow.find('select[name="item_id[]"]').addClass('select2');
        newRow.find('.select2').select2();

        updateRowNumbers();
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });


  // if you want one row by default
  if (!$('#selectedItems .item-row').length) {

    $('#addRow').trigger('click');
  }/***/

$('#selectedItems .item-row').each(function (index) {
            updateRowValues($(this));
        });

  $(document).on('input change', 'input[name="weight[]"]', function () {
    let row = $(this).closest('tr');

     updateRowValues(row);
});

  function updateRowValues(row){
      // values
    
    let disc = parseFormattedNumber(row.find('input[name="disc[]"]').val()) || 0;
    let weight = parseFormattedNumber(row.find('input[name="weight[]"]').val()) || 0;
    

    updateFooterTotals();
  }


  function updateFooterTotals() {
    let  totalWeight = 0;

    $("#selectedItems tr").each(function () {
        
        totalWeight += parseFormattedNumber($(this).find('input[name="weight[]"]').val()) || 0;
        
    });
    

   
    $("#total_weight").text(formatNumber(totalWeight,2));
    
    
}



// Call once on page load
updateRowNumbers();
updateFooterTotals();



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




 









</script>



@endsection  
  