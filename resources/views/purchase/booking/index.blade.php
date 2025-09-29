
@extends('layout.master')
@section('title', 'Booking List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Booking List</h1>
            <a class="btn" href="{{url('purchase-bookings/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase</a></li>
              <li class="breadcrumb-item active">Bookings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bookings</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

              <div class="table-responsive p-0" style="">
                <table id="example1" class="table table-bordered table-hover mt-4 table-head-fixed" style="">
                  
                  <thead class="table-primary">
                  
                  <tr>
                    <th>#</th>
                    <th>Booking No</th>
                    <th>Booking Date</th>
                    <th>Vendor</th>
                     <th>Category</th>
                    <th>Disc/Gain %</th>
                    <th>Weight</th>
                    <th>Received</th>
                    <th>Pending</th>
                     <th>Created By</th>
                    
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody>
                  
                 
                  
            <?php $i=1; $total_weight=0; $total_received=0; $total_pending=0; $categoryStats = []; ?>
                    @foreach($orders as $order)
                    
                      <?php
                             $weight=$order['weight'];

                            // $avg=$order->avg_discount();

                             $received=$order->received_weight();

                              $pending=$weight-$received;
                           

                              $total_weight+=$weight; $total_received+=$received; $total_pending+=$pending;

                           //$count=count($order['categories']);
                      ?>
                      <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td><a href="{{url('purchase-bookings/'.$order['booking_id'].'/edit')}}">{{$order['booking']['doc_no']}}</a></td>
                     <td>{{$order['booking']['doc_date']}}</td>
                    <td>{{$order['booking']['vendor']['name']}}</td>


             
                     <td>{{$order['category']['name']}}</td>
                     <td>{{number_format($order['discount'],2)}}</td>

                      <?php
                              //discount per category
                              if (!isset($categoryStats[$order['category_id']])) {
                              $categoryStats[$order['category_id']] = [
                              'name' => $order['category']['name'],
                              'sum' => 0,
                              'count' => 0
                               ];
                              }

                              $categoryStats[$order['category_id']]['sum'] += $order['discount'];
                              $categoryStats[$order['category_id']]['count']++;

                              ?>

                    

                      
                      <td>{{number_format($weight,2)}}</td>
                      <td>{{number_format($received,2)}}</td>

                     
                     <td>@if($pending>0) <span class="badge badge-warning">{{number_format($pending,2)}}</span> @endif</td>

                       <td>@if($order['user']){{$order['user']['name']}}@endif</td>
                     
                    
                     <td>
                      
                      <a href="{{ route('purchase-bookings.edit', $order['booking_id']) }}"><span class="fa fa-edit"></span></a>
                    </td>
                   
                    
                 
                   
                  </tr>
                <?php $i++; ?>
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
                      <th>{{number_format($total_weight,2)}}</th>
                      <th>{{number_format($total_received,2)}}</th>
                      <th>{{number_format($total_pending,2)}}</th>
                      <th></th>
                      <th></th>
                  </tr>

                              

                  </tfoot>
                </table>


              <table class="table table-bordered table-hover mt-4 table-head-fixed">
    <thead class="table-primary">
      <tr>
        <th colspan="4" class="text-center" >Avg Disc/Gain % of each category</th>
      </tr>
        <tr>
            <th>Category</th>
            <th>Disc/Gain %</th>
            <th>Category</th>
            <th>Disc/Gain %</th>
        </tr>
    </thead>
    <tbody>
        @php
            $categories = array_values($categoryStats); // reset keys for indexing
        @endphp

        @for ($i = 0; $i < count($categories); $i += 2)
            <tr>
                {{-- First column --}}
                <th>{{ $categories[$i]['name'] }}</th>
                <td>{{ number_format($categories[$i]['sum'] / $categories[$i]['count'], 2) }}</td>

                {{-- Second column (if exists) --}}
                @if (isset($categories[$i+1]))
                    <th>{{ $categories[$i+1]['name'] }}</th>
                    <td>{{ number_format($categories[$i+1]['sum'] / $categories[$i+1]['count'], 2) }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
            </tr>
        @endfor
    </tbody>
</table>



               </div>

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  