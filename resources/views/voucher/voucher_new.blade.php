
@extends('layout.master')
@section('title', 'Create New Voucher')
@section('header-css')

<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content-header')

<!-- Content Header (Page header) -->

  <div class="row default-header"  >
    <div class="col-sm-6">
      <h1 class="text-capitalize" >{{$category}} Voucher</h1>
     </div>
    <div class="col-sm-6 text-right">

       <button form="purchase_demand" type="submit" class="btn btn-primary"><span class="fas fa-save">&nbsp</span>{{ isset($voucher['id']) ? 'Update' : 'Save' }}</button>

        @if(isset($voucher['id']))
                    <button type="button"  class="btn btn-action" data-toggle="modal" data-target="#modal-del" >
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <a class="btn btn-transparent" href="{{url('voucher/'.$category.'/create')}}" ><span class="fas fa-plus">&nbsp</span>New</a>

                    @endif
       
               <a class="btn btn-transparent text-capitalize" href="{{url('voucher/'.$category.'/list')}}" ><span class="fas fa-history">&nbsp</span>{{$category}} List</a>

        @if(isset($voucher['id']))
              

              <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                  <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                   <li><a href="{{url('/voucher/report/'.$voucher['id'])}}" class="dropdown-item">Voucher</a></li>
                  <li><a href="{{url('/voucher/report1/'.$voucher['id'])}}" class="dropdown-item">Voucher1</a></li>
                  <li><a href="{{url('/voucher/report2/'.$voucher['id'])}}" class="dropdown-item">Voucher2</a></li>
                  
                </ul>
              </div>
              @endif
     

      
    </div>
  </div>

     <ol class="breadcrumb default-breadcrumb"  >
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Voucher</a></li>
        <li class="breadcrumb-item text-capitalize"><a href="#">{{$category}}</a></li>
        <li class="breadcrumb-item active">{{ isset($voucher['id']) ? 'Edit' : 'Add' }}</li>
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



 <form role="form" id="delete_form" method="POST" action="{{url('/delete_new/voucher/'.$voucher['id'])}}">
 @csrf    
</form>


<!-- /print modal -->
      <div class="modal fade" id="modal-print">
    <div class="modal-dialog">
      <div class="modal-content bg-gradient-info">
        <div class="modal-header">
          <h4 class="modal-title ">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Do you want to Print?&hellip;</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
          <!-- <button form="button" class="btn btn-outline-light">Yes</button> -->
          <a class="btn btn-outline-light" id="print_btn"  href="{{url('/voucher/report/'.session()->get('voucher_id') )}}" target="_blank" >Yes</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.print modal -->


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


            @error('voucher_no')
            <!--<div class="alert alert-danger">
            {{ $message }}
           </div>-->
            @enderror


                    @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif




    
<form role="form" id="purchase_demand" method="POST" action="{{ isset($voucher['id']) ? url('/voucher_new/update/'.$voucher['id']) : url('/voucher_new/save') }}" enctype="multipart/form-data" class="multiImgFrm">

<input type="hidden" value="{{$category}}" name="category"/>

  <div class="container-fluid" style="margin-top: 10px;">

       <h4 class="form-section-title text-capitalize"><i class="fas fa-file-alt mr-2"></i>{{$category}} Voucher</h4>

      {{-- Voucher Details --}}
    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Voucher No</label>
            <input type="text" name="doc_no" class="form-control" value="{{$voucher['doc_no']}}" readonly required>
        </div>
        <div class="form-group col-md-3">
            <label>Voucher Date</label>
            <input type="date" name="doc_date" class="form-control" value="{{ old('doc_date', $voucher->doc_date ?? date('Y-m-d')) }}" onchange="setDocNo('date')" required>
        </div>

            <div class="col-md-3 form-group">
              <label>Pay Mehtod</label>
              <select name="pay_method" id="pay_method" class="form-control" onchange="setDocNo('method')" required>
                <option value="cash" {{ old('pay_method', $voucher->pay_method) == 'cash' ? 'selected' : '' }} >Cash</option>
                <option value="bank" {{ old('pay_method', $voucher->pay_method) == 'bank' ? 'selected' : '' }}  >Bank</option>
              </select>
              </div>

        <div class="form-group col-md-3">
            <?php   

                   $pay_to='';

                 if(isset($voucher['id'])){

                   if($category=='receipt')
                  $pay_to=$voucher->accounts->where('pivot.debit','<>',0)->first()->id;
                  else
                   $pay_to=$voucher->accounts->where('pivot.credit','<>',0)->first()->id;

                    
                 }
                       
                 ?>

            <label> 
                    @if($category=='receipt')
                    Receive In
                    @else 
                    Pay From
                    @endif
         </label>
            <select name="pay_to" class="form-control" required>

                 

                @if($voucher['pay_method']=='bank')
                 @foreach($banks as $cash)
                <option value="{{$cash['id']}}" {{ old('pay_to', $pay_to) == $cash['id'] ? 'selected' : '' }} >{{$cash['name']}}</option>
                @endforeach
                 @else
                @foreach($cashes as $cash)
                <option value="{{$cash['id']}}" {{ old('pay_to', $pay_to) == $cash['id'] ? 'selected' : '' }} >{{$cash['name']}}</option>
                @endforeach
                @endif
            </select>
        </div>

          <div class="form-group col-md-3">
              <label>Company</label>
              <select class="form-control" name="company_id"  required>
                
                <option value="">Select any company</option>
               @foreach($companies as $comp)
            <option value="{{$comp['id']}}" {{ old('company_id', $voucher->company_id ?? null) == $comp->id ? 'selected' : '' }}>{{$comp['name']}}</option>
                @endforeach
              </select>
              </div>


              <div class="form-group col-md-3">
              <label>Branch</label>
              <select class="form-control" name="branch_id"  required>
                
                <option value="">Select any value</option>

                @foreach($branches as $branch)
        <option value="{{ $branch->id }}"
            {{ old('branch_id', $voucher->branch_id ?? null) == $branch->id ? 'selected' : '' }}>
            {{ $branch->name }}
        </option>
    @endforeach

              </select>
              </div>

         <!---<div class="col-md-3 form-group">
              <label>Status</label>
              <select form="purchase_demand" name="status" class="form-control" required >
                   

            <option value="1" {{ old('status', $voucher->status ?? 1) == '1' ? 'selected' : '' }}>Post</option>
            <option value="0" {{ old('status', $voucher->status ?? 1) == '0' ? 'selected' : '' }}>Unpost</option>

                </select>

        </div>-->

         <div class="col-md-3 form-group">
              <label>Remarks</label>
              <input type="text" form="purchase_demand" name="remarks" class="form-control " value="{{ old('remarks', $voucher->remarks) }}"  >
              </div>


    </div>

    {{-- Currency Breakdown --}}
    <h5>Currency Breakdown</h5>
    <table class="table table-bordered" id="currency-table">
        <thead class="thead-light">
            <tr>
                <th>Denomination</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php 

                   $all_denominations = [5000,1000,500,100,50,20,10,'coin'];

                         $denominations = explode(',', $voucher['denominations'] ?? '');
                         $quantities    = explode(',', $voucher['notes'] ?? '');

             @endphp
            @foreach($all_denominations as $i=>$denomination)

                 @php
            $qty = $quantities[$i] ?? 0;
           
        @endphp

                <tr>
                    <td>
                        <input type="hidden" 
                               name="notes[{{ $denomination }}][denomination]" 
                               value="{{ is_numeric($denomination) ? $denomination : 1 }}">
                        {{ is_numeric($denomination) ? number_format($denomination) : ucfirst($denomination) }}
                    </td>
                    <td>
                        <input type="number" min="0" class="form-control qty-input"
                               name="notes[{{ $denomination }}][quantity]" value="{{$qty}}" @if($voucher['pay_method']=='bank') readonly @endif >
                    </td>
                    <td class="row-total">0</td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr class="font-weight-bold">
                <td colspan="2" class="text-right">Grand Total</td>
                <td id="currency-total">0</td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="currency_total" id="currency-total-input">

    {{-- Accounts Breakdown --}}
    <h5>Accounts Detail</h5>
    <table class="table table-bordered add-lines-table" id="selectedItems">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th style="width: 500px;">Account</th>
                <th>Remarks</th>
                <th>Cheque No</th>
                <th>Cheque Date</th>
                <th>Amount</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
                  @php
                          $v_no=0;
                  @endphp
             @if(isset($voucher['accounts']) && count($voucher['accounts']) > 0)

               <?php
                            

                            if($category=='receipt')
                            $transections=$voucher->accounts->where('pivot.credit','<>',0);
                            else
                            $transections=$voucher->accounts->where('pivot.debit','<>',0);
               ?>

                 @foreach($transections  as $account)

                 <?php

                      if($category=='receipt')
                            $amount=$account['pivot']['credit'];
                            else
                            $amount=$account['pivot']['debit'];

                 ?>

            <tr class="item-row">
                <td class="row-num"></td>
                <td>
                    <select name="accounts[{{$v_no}}][account_id]" class="form-control select2" required>
                        <option value="">Select any value</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}" {{ $acc['id'] == $account->id ? 'selected' : '' }} >{{ $acc->code.' '.$acc->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="accounts[{{$v_no}}][remarks]" value="{{$account['pivot']['remarks']}}" class="form-control"></td>
                

                 <td><input type="text" name="accounts[{{$v_no}}][cheque_no]" class="form-control" value="{{$account['pivot']['cheque_no']}}" @if($voucher['pay_method']=='cash') readonly @endif ></td>
                  <td><input type="date" name="accounts[{{$v_no}}][cheque_date]" class="form-control" value="{{$account['pivot']['cheque_date']}}" @if($voucher['pay_method']=='cash') readonly @endif ></td>
                  <td><input type="number" step="any" name="accounts[{{$v_no}}][amount]" class="form-control account-amount last-input" value="{{$amount}}" required></td>

                <td>
                    <button type="button" class="btn text-danger removeRow skip-enter">
                    <i class="fa fa-times-circle"></i>
                    </button>
                </td>

            </tr>
            <?php $v_no++; ?>
             @endforeach
             @else
            <tr class="item-row">
                <td class="row-num"></td>
                <td>
                    <select name="accounts[][account_id]" class="form-control select2" required>
                        <option value="">Select any value</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->code.' '.$acc->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="accounts[0][remarks]" class="form-control"></td>
                

                 <td><input type="text" name="accounts[0][cheque_no]" class="form-control" readonly ></td>
                  <td><input type="date" name="accounts[0][cheque_date]" class="form-control" readonly></td>
                  <td><input type="number" step="any" name="accounts[0][amount]" class="form-control account-amount last-input" required></td>

                <td>
                    <button type="button" class="btn text-danger removeRow skip-enter">
                    <i class="fa fa-times-circle"></i>
                    </button>
                </td>

            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr class="font-weight-bold">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td id="accounts-total">0</td>
                <td></td>

            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="accounts_total" id="accounts-total-input">

    {{-- Add Row Button --}}
    <button type="button" id="addRow" class="btn btn-secondary btn-sm mb-3">+ Add Account</button>

    {{-- File Upload --}}
    <div class="form-group">
        <label for="proofs">Upload Proofs</label>
        <input type="file" name="proofs[]" id="proofs" class="form-control" multiple accept="image/*">
    </div>

    <div id="preview-container" class="row mt-2"></div>


    {{-- Error if mismatch --}}
    <div id="total-error" class="alert alert-danger d-none"></div>

    {{-- Submit --}}
    <button type="submit" id="submit-btn" class="btn btn-primary">{{ isset($voucher['id']) ? 'Update' : 'Save' }} Voucher</button>



    
  </div>

  </form>

  



    <div id="" class="row mt-2">
        @if(isset($voucher['files']))
        @foreach($voucher['files'] as $file)
            <div class="col-md-3 mb-2" id="file-{{ $file['id'] }}">  
                <div class="card shadow-sm position-relative">
                    <img src="{{ asset('public/'.$file['path']) }}" class="card-img-top" style="height:150px;object-fit:cover;">

                    <!-- Delete Button -->
                    <button class="btn btn-danger btn-sm position-absolute" 
                            style="top:5px; right:5px;" 
                            onclick="deleteFile({{ $file['id'] }})">
                        &times;
                    </button>
                </div>
            </div>
        @endforeach
        @endif
    </div>
<!-- /.content -->



@endsection

@section('jquery-code')


<script type="text/javascript">


    // Include CSRF token for Laravel
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let cashes = @json($cashes);
    let banks  = @json($banks);

    let companies = @json($companies);


    let selectedFiles = [];

    // On file input change
    $('#proofs').on('change', function (e) {
    const files = Array.from(e.target.files);

    files.forEach(file => {
        // Avoid duplicates
        if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
            selectedFiles.push(file);
        }
    });

    renderPreview();
    this.value = ''; // Reset input so user can add more files
    });

    // Initialize validation first, outside the submit event
    $('.multiImgFrm').validate({
    // Validation rules for required fields only
    rules: {
        //'proofs[]': { required: true }, // Uncomment if you want to enforce at least one image
        'title': { required: true },
        'description': { required: true },
        // Add other required fields here
    },
    messages: {
        'title': { required: 'Title is required' },
        'description': { required: 'Description is required' },
        //'proofs[]': { required: 'Please select at least one image' }
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        const $group = element.closest('.form-group');
        if ($group.length) {
            $group.append(error);
        } else {
            element.after(error);
        }
    },
    highlight: function(element) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element) {
        $(element).removeClass('is-invalid');
    },
    submitHandler: function(form) {
        // Optional check for images if needed
        if (selectedFiles.length === 0) {
            //alert('Please select at least one image.');
            //return;
        }

        // Create FormData and append all form fields
        const formData = new FormData(form); // Automatically grabs all input, textarea, select

        // Append selected files manually
        selectedFiles.forEach(file => {
            formData.append('proofs[]', file.file ? file.file : file);
        });

        // AJAX request
        /*$.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                alert('Form submitted successfully!');
                selectedFiles = [];
                renderPreview(); // reset image previews
                form.reset(); // reset other form fields
            },
            error: function(err) {
                console.error(err.responseText || err);
                alert('Error submitting the form.');
            }
        });*/

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                alert('Form submitted successfully!');

                // Clear previous selected files & previews
                selectedFiles = [];
                renderPreview(); 
                form.reset(); 

                //updateRowNumbers();
                //validateTotals(true); 

                window.location.reload();

                // Add new uploaded files to the existing div
                if(res.files && res.files.length > 0){
                    res.files.forEach(function(file){
                        let html = `
                        <div class="col-md-3 mb-2" id="file-${file.id}">  
                            <div class="card shadow-sm position-relative">
                                <img src="{{ asset('public') }}/${file.path}" class="card-img-top" style="height:150px;object-fit:cover;">
                                <button class="btn btn-danger btn-sm position-absolute" 
                                        style="top:5px; right:5px;" 
                                        onclick="deleteFile(${file.id})">
                                    &times;
                                </button>
                            </div>
                        </div>
                        `;
                        $('.row.mt-2').append(html); // Append to existing container
                    });
                }
            },
            error: function(err) {
                console.error(err.responseText || err);
                alert('Error submitting the form.');
            }
        });


    }
});


    function deleteFile(fileId) {
    if(!confirm('Are you sure you want to delete this file?')) return;

    $.ajax({
        url: '{{ url('voucher/file/delete') }}/' + fileId, // we'll create this route
        type: 'DELETE',
        data: {
           // _token: '{{ csrf_token() }}' // CSRF token
        },
        success: function(response) {
            if(response.success) {
                $('#file-' + fileId).remove(); // remove from DOM
                alert('File deleted successfully.');
            } else {
                alert('Failed to delete file.');
            }
        },
        error: function() {
            alert('Error deleting file.');
        }
    });
    }




    // Render previews
    function renderPreview() {
    $('#preview-container').empty();

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            const html = `
                <div class="col-md-3 text-center mb-3">
                    <img src="${e.target.result}" class="img-thumbnail" style="width:100%; height:150px; object-fit:cover;">
                    <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeFile(${index})">Remove</button>
                </div>
            `;
            $('#preview-container').append(html);
        }

        reader.readAsDataURL(file);
    });
    }

    // Remove a file
    function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
    }

    function setDocNo(change_in)
{

    let  default_date='{{$voucher['doc_date']}}';
    let  doc_no='{{$voucher['doc_no']}}';
    let  default_pay_method='{{$voucher['pay_method']}}';

   var pay_method=$('select[name="pay_method"]').val();
   var doc_date=$('input[name="doc_date"]').val();

   let category   = '{{$category}}';

   if(change_in=='method'){
   $('select[name="pay_to"]').empty(); 
   }

   var voucher_type='';

   if(pay_method=='bank')
    {  
          voucher_type= category =='receipt' ? 30 : 29;

          if(change_in=='method'){
          $.each(banks, function (i, item) {
                $('select[name="pay_to"]').append('<option value="'+item.id+'">'+item.name+'</option>');
            });
         }
    }
    else if(pay_method=='cash')
    {
         voucher_type= category =='receipt' ? 28 : 27;

          if(change_in=='method'){
         $.each(cashes, function (i, item) {
                $('select[name="pay_to"]').append('<option value="'+item.id+'">'+item.name+'</option>');
            });
        }
    }


        // Convert both to Date objects
        let d1 = new Date(default_date);
        let d2 = new Date(doc_date);

        // Compare year + month
        if (d1.getFullYear() === d2.getFullYear() && d1.getMonth() === d2.getMonth() && default_pay_method==pay_method ) {
            
            $(`input[name="doc_no"]`).val(doc_no); 
            return ;
        } else {
            
        }

           
         

   $.ajax({
               type:'get',
               url:'{{ url("/get/voucher/no/") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     voucher_type: voucher_type,
                      doc_date: doc_date,
                  

               },
               success:function(data) {

              
                var doc_no = data['doc_no'];

                
                  $(`input[name="doc_no"]`).val(doc_no);

               }
             });//end ajax
    
}




   

    $('.select2').select2(); 


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




    // --- Currency Breakdown ---
    function calculateCurrencyBreakdown() {
    let total = 0;
    $('#currency-table tbody tr').each(function () {
        let denom = parseFloat($(this).find('input[type="hidden"]').val()) || 0;
        let qty   = parseInt($(this).find('.qty-input').val()) || 0;
        let rowTotal = denom * qty;
        $(this).find('.row-total').text(formatNumber(rowTotal));
        total += rowTotal;
    });

    $('input[name="currency_total"]').val(total); 
    $('#currency-total').text(formatNumber(total));
    return total;
    }

    // --- Accounts Breakdown ---
    function calculateAccountsTotal() {
        let accountsTotal = 0;
        $('#selectedItems tbody tr').each(function () {
            let amount = parseFloat($(this).find('.account-amount').val()) || 0;
            accountsTotal += amount;
        });
        $('#accounts-total').text(formatNumber(accountsTotal));
        $('#accounts-total-input').val(accountsTotal);
        return accountsTotal;
    }

    // --- Validate Totals ---
    function validateTotals(currencyChange) {

      let currencyTotal ;

        if(currencyChange==true){  

        currencyTotal = calculateCurrencyBreakdown();

        // --- Distribute equally to accounts ---
        let accountRows = $('#selectedItems tbody tr');
        let accountCount = accountRows.length;

        if (accountCount > 0 && currencyTotal > 0) {
            let equalAmount = (currencyTotal / accountCount).toFixed(2);

            accountRows.each(function () {
                $(this).find('.account-amount').val(equalAmount);
            });
        }

        }
        else{
        currencyTotal =  $('input[name="currency_total"]').val();
        }



    let accountsTotal = calculateAccountsTotal();  
    let pay_method=$('select[name="pay_method"]').val();

    // --- Validation ---
    if (currencyTotal != accountsTotal && pay_method=='cash' ) {
        $('#total-error').removeClass('d-none').text(
            'Currency total (' + currencyTotal.toLocaleString() +
            ') does not match Accounts total (' + accountsTotal.toLocaleString() + ')'
        );
        $('#submit-btn').prop('disabled', true);
    } else {
        $('#total-error').addClass('d-none').text('');
        $('#submit-btn').prop('disabled', false);
    }
    }


    // --- Add Account Row ---
    let accountIndex = {{$v_no}};
    $('#addRow').click(function (){

        let reatonly_txt='';
        let pay_method=$('select[name="pay_method"]').val();

        if(pay_method=='cash'){
            reatonly_txt='readonly';
        }


        let row = `
        <tr class="item-row">
            <td class="row-num"></td>
            <td>
                <select name="accounts[${accountIndex}][account_id]" form="purchase_demand" class="form-control select2" required>
                    <option value="">Select any value</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->code.' '.$acc->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" name="accounts[${accountIndex}][remarks]" form="purchase_demand" class="form-control"></td>
             <td><input type="text" name="accounts[${accountIndex}][cheque_no]" form="purchase_demand" class="form-control" ${reatonly_txt} ></td>
             <td><input type="date" name="accounts[${accountIndex}][cheque_date]" form="purchase_demand" class="form-control" ${reatonly_txt} ></td>
            <td><input type="number"  step="any" name="accounts[${accountIndex}][amount]" form="purchase_demand" class="form-control account-amount last-input" required></td>
            <td>
            <button type="button" class="btn text-danger removeRow skip-enter">
          <i class="fa fa-times-circle"></i>
        </button>
            </td>
        </tr>`;

        $('#selectedItems tbody').append(row);

        $('#selectedItems tbody tr:last .select2').select2();


        updateRowNumbers();
        accountIndex++;
    });

     // Remove row
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });

    // --- File Previews ---
    $('#proofs1').on('change', function () {
        $('#preview-container').html('');
        let files = this.files;
        $.each(files, function (i, file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-container').append(`
                    <div class="col-md-3 mb-2">
                        <div class="card shadow-sm">
                            <img src="${e.target.result}" class="card-img-top" style="height:150px;object-fit:cover;">
                            <div class="card-body p-2 text-center">
                                <small>${file.name}</small>
                            </div>
                        </div>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });

    // --- Events ---
    $(document).on('input', '.qty-input, .account-amount', function () {

       let currencyChange=false;
         if ($(this).hasClass('qty-input')) {
               currencyChange=true;
        
    } else if ($(this).hasClass('account-amount')) {
        
    }

        validateTotals(currencyChange);
    });


    function updateRowNumbers() {
        $('#selectedItems .item-row').each(function (index) {
            $(this).find('.row-num').text(index + 1);
        });
    }


    updateRowNumbers();
    validateTotals(true); // initial run

     $(document).on('change', 'select[name="pay_method"]', function () {

       
         let pay_method=$(this).val();

         if(pay_method=='cash'){
           
             $('input[name^="notes"][name$="[quantity]"]').prop('readonly', false);
            $('input[name^="accounts"][name$="[cheque_no]"]').prop('readonly', true);
            $('input[name^="accounts"][name$="[cheque_date]"]').prop('readonly', true);
         }
         else if(pay_method=='bank'){
            
            $('input[name^="notes"][name$="[quantity]"]').val('0');

            validateTotals(true);

            $('input[name^="notes"][name$="[quantity]"]').prop('readonly', true);
            $('input[name^="accounts"][name$="[cheque_no]"]').prop('readonly', false);
            $('input[name^="accounts"][name$="[cheque_date]"]').prop('readonly', false);
         }
               

       
    });


    

</script>


@endsection  









