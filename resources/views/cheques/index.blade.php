
@extends('layout.master')
@section('title', 'Cheques')
@section('header-css')


  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Cheques List</h1>
           
           

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
   


    <div class="container">


        
    <div class="col-md-6 g-2 mb-3">

     <!-- <form method="GET" action="{{ route('cheques.index') }}" class="">-->

        <div class="mb-3">
             <label>Account</label>
           <select name="account_id" class="form-control" required>
           
              
                    <option value="{{ $account->id }}">{{ $account->code.' '.$account->name }}
                    </option>
              
            </select>
        </div>

         <div class="mb-3">
             <label>Balance</label>
            <input type="text" class="form-control" value="{{ $closing_balance }}" readonly >
        </div>

<?php  $dif=$closing_balance-$totalAmount; ?>
         <div class="mb-3">
             <label>Difference</label>
            <input type="text"  class="form-control"
                value="{{$dif}}" readonly >
        </div>
        
        <!--<div class="mb-3">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
        </form>-->

    </div>



     


    <!--<h3>Cheques List</h3>-->

    <div class="text-right" >
    <a href="{{ route('cheques.create') }}" class="btn btn-primary mb-3">Add Cheque</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
               
               <th>Date</th> 
                <th>Customer</th>
                <th>Cheque Date</th>
                <th>Cheque No</th>
                
                <th>Amount</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cheques as $chq)
                <tr>
                    
                    <td>{{ date("Y-m-d" , strtotime($chq['created_at']) ) }}</td>
                    <td>{{ $chq->customer->name ?? '-' }}</td>
               
                   
                   <td>{{ $chq->cheque_date }}</td>
                    <td>{{ $chq->cheque_number }}</td>
                    
                     <td>{{ number_format($chq->amount, 2) }}</td>

                      <td>{{ $chq->remarks }}</td>

                    <td>
                        <a href="{{ route('cheques.edit', $chq) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('cheques.destroy', $chq) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete cheque?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>{{ number_format($totalAmount, 2) }}</th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>

    </table>
  </div>

   <!-- /.content -->

    {{ $cheques->links() }}
   
@endsection

@section('jquery-code')

<script>

$(document).ready(function(){


$('.select2').select2(); 

});

</script>


@endsection  
  