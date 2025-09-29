
@extends('layout.master')
@section('title', 'Plan Ticket History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Plan Ticket History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/plan-ticket')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Plan Ticket</a></li>
              <li class="breadcrumb-item active">History</li>
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
                <h3 class="card-title">Tickets</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

               <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Ticket No</th>
                    <th>Date</th>
                   
                    <th>Batch No</th>
                    <th>Batch Size</th>
                    <th>Plan</th>
                   
                    <th>Product</th>
                     <th>Exp Date</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Pack Size</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>

                  
                       
                    @for($i=0;$i< count( $tickets) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$i+1}}</td>
                     <td>{{$tickets[$i]['ticket_no']}}</td>
                     <td>{{$tickets[$i]['ticket_date']}}</td>
                    
                     <td>{{$tickets[$i]['batch_no']}}</td>
                      <td>{{$tickets[$i]['batch_size']}}</td>
                     <td>{{$tickets[$i]['plan']['plan_no']}}</td>
                      
                      <td>{{$tickets[$i]['product']['item_name']}}</td>
                      <td>{{$tickets[$i]['exp_date']}}</td>
                     <td>{{$tickets[$i]['quantity']}}</td>
                      <td>{{$tickets[$i]['unit']}}</td>
                     <td>{{$tickets[$i]['pack_size']}}</td>
                     <?php $total=$tickets[$i]['quantity']*$tickets[$i]['pack_size'] ?>
                     <td>{{$total}}</td>
                   
                    <td><a href="{{url('edit/plan/ticket/'.$tickets[$i]['ticket_no'])}}"><span class="fa fa-edit"></span></a></td>
                     
                    </tr>
                   <!--  <tr><td colspan="8"></td></tr> -->

                    @endfor
                
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
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
  