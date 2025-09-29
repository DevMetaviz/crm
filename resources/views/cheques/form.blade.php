@extends('layout.master')
@section('title', 'Cheques')
@section('header-css')


  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Cheques</h1>
           
           

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Cheque</a></li>
              <li class="breadcrumb-item active">List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h3>{{ isset($cheque) ? 'Edit Cheque' : 'Add New Cheque' }}</h3>

    <form action="{{ isset($cheque) ? route('cheques.update', $cheque->id) : route('cheques.store') }}" method="POST">
        @csrf
        @if(isset($cheque))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Customer</label>
            <select name="customer_id" class="form-control select2" required>
                <option value="">Select any value</option>
                @foreach($customers as $cust)
                    <option value="{{ $cust->id }}"
                        {{ isset($cheque) && $cheque->customer_id == $cust->id ? 'selected' : '' }}>
                        {{ $cust->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label>Account</label>
            <select name="account_id" class="form-control" required>
               
                    <option value="{{ $account->id }}"
                        {{ isset($cheque) && $cheque->account_id == $account->id ? 'selected' : '' }}>
                        {{ $account->code.' '.$account->name }}
                    </option>
                
            </select>
        </div>

       

        <div class="mb-3">
            <label>Cheque Number</label>
            <input type="text" name="cheque_number" class="form-control"
                value="{{ $cheque->cheque_number ?? old('cheque_number') }}" required>
                @error('cheque_no')
                <small class="text-danger">{{ $message }}</small>
               @enderror
        </div>

        <div class="mb-3">
            <label>Cheque Date</label>
            <input type="date" name="cheque_date" class="form-control"
                value="{{ $cheque->cheque_date ?? old('cheque_date') }}" required>
        </div>

        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control"
                value="{{ $cheque->amount ?? old('amount') }}" required>
        </div>

       

        <!--<div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending"  {{ (isset($cheque) && $cheque->status=='pending') ? 'selected' : '' }}>Pending</option>
                <option value="cleared"  {{ (isset($cheque) && $cheque->status=='cleared') ? 'selected' : '' }}>Cleared</option>
                <option value="bounced"  {{ (isset($cheque) && $cheque->status=='bounced') ? 'selected' : '' }}>Bounced</option>
            </select>
        </div>-->

        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control">{{ $cheque->remarks ?? old('remarks') }}</textarea>
        </div>

        <button type="submit" class="btn btn-{{ isset($cheque) ? 'primary' : 'success' }}">
            {{ isset($cheque) ? 'Update Cheque' : 'Save Cheque' }}
        </button>
    </form>
</div>
@endsection
@section('jquery-code')

<script>

$(document).ready(function(){


$('.select2').select2(); 

});

</script>


@endsection  


