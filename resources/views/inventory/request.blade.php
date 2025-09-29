
@extends('layout.master')
@section('title', 'Requisition Requests')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Requisition Requests</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/requisition/request/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Requisition</a></li>
              <li class="breadcrumb-item active">Requests</li>
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
                <h3 class="card-title">Requests</h3>
              
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
                    <th>Requisition No</th>
                    <th>Date</th>
                    <th>Department</th>
                    <th>Plan No</th>
                    <th>Product</th>
                  
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $requests) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$requests[$i]['id']}}</td>
                     <td>{{$requests[$i]['requisition_no']}}</td>
                     <td>{{$requests[$i]['requisition_date']}}</td>
                    <td>@if(isset($requests[$i]['department'])){{$requests[$i]['department']['name']}}@endif</td>
                    <td>@if(isset($requests[$i]['plan'])){{$requests[$i]['plan']['plan_no']}}@endif</td>
                     <td>@if(isset($requests[$i]['plan']['product'])){{$requests[$i]['plan']['product']['item_name']}}@endif</td>
                      
                     <td>{{$requests[$i]['remarks']}}</td>
                  
                                       
                    <td><a href="{{url('/requisition/request/edit/'.$requests[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  