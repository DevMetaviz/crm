
@extends('layout.master')
@section('title', 'Issuance Returns')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Issuance Return</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('issuance-return')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Return</a></li>
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
                <h3 class="card-title">Returns</h3>
              
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
                    <th>Return No</th>
                    <th>Return Date</th>
                    <th>Issuance No</th>
                    <th>Issuance Date</th>
                    <th>Department</th>
                    <th>Plan No</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $returns) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$returns[$i]['id']}}</td>
                     <td>{{$returns[$i]['doc_no']}}</td>
                     <td>{{$returns[$i]['doc_date']}}</td>

                    <td>@if($returns[$i]['issuance']!=''){{$returns[$i]['issuance']['issuance_no']}}@endif</td>

                     <td>@if($returns[$i]['issuance']!=''){{$returns[$i]['issuance']['issuance_date']}}@endif</td>
                                         
                      <td>@if($returns[$i]['department']!=''){{$returns[$i]['department']['name']}}@endif</td>
                      <td>@if($returns[$i]['plan']!=''){{$returns[$i]['plan']['plan_no']}}@endif</td>
                      <td>@if($returns[$i]['plan']!=''){{$returns[$i]['plan']['product']['item_name']}}@endif</td>
                      <td>{{$returns[$i]['returned']}}</td>
                     <td>{{$returns[$i]['remarks']}}</td>
                  
                                       
                    <td><a href="{{url('edit/issuance-return/'.$returns[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  