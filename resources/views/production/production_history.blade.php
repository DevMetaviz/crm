
@extends('layout.master')
@section('title', 'Production History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Production History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            @if(isset($ticket))
            <a class="btn" href="{{url('/production-entry/'.$ticket['id'])}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            @else
            <a class="btn" href="{{url('/production-entry')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            @endif
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
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
                <h3 class="card-title">Productions</h3>
              
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
                    <th>Doc No</th>
                    <th>Ticket No</th>
                   
                    <th>Department</th>
                    <th>Product</th>
                    <th>Production Date</th>
                    <th>Batch No</th>
                     <th>Mfg Date</th>
                      <th>Exp Date</th>
                       <th>Quantity</th>
                        <th>Unit</th>
                         <th>Pack Size</th>
                          <th>Total</th>
                    <th>Active</th>
                    
                    <th></th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $productions) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$productions[$i]['id']}}</td>
                     <td>{{$productions[$i]['code']}}</td>
                     <td>@if($productions[$i]['ticket_id']!='') {{$productions[$i]['ticket']['ticket_no']}} @endif</td>
                    
                     <td>{{$productions[$i]['item']['department']['name']}}</td>
                      <td>{{$productions[$i]['item']['item_name']}}</td>
                     <td>{{$productions[$i]['production_date']}}</td>
                     <td>{{$productions[$i]['batch_no']}}</td>
                      <td>{{$productions[$i]['mfg_date']}}</td>
                      <td>{{$productions[$i]['exp_date']}}</td>
                      <td>{{$productions[$i]['qty']}}</td>
                      <td>{{$productions[$i]['unit']}}</td>
                      <td>{{$productions[$i]['pack_size']}}</td>
                      <td>{{$productions[$i]['qty'] * $productions[$i]['pack_size']}}</td>
                      <td>{{$productions[$i]['activeness']}}</td>
                    
                   
                    <td><a href="{{url('edit/production-entry/'.$productions[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  