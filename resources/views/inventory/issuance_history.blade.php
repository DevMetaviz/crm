
@extends('layout.master')
@section('title', 'Issuance History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Issuance History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('store-issuance')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Issuance</a></li>
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
                <h3 class="card-title">Issuances</h3>
              
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
                    <th>Issuance No</th>
                    <th>Issuance Date</th>
                    <th>Requisition No</th>
                    <th>Requisition Date</th>
                    <th>Department</th>
                    <th>Plan No</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $issuances) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$issuances[$i]['id']}}</td>
                     <td>{{$issuances[$i]['issuance_no']}}</td>
                     <td>{{$issuances[$i]['issuance_date']}}</td>
                     <td>@if($issuances[$i]['requisition']!=''){{$issuances[$i]['requisition']['requisition_no']}}@endif</td>
                     <td>@if($issuances[$i]['requisition']!=''){{$issuances[$i]['requisition']['requisition_date']}}@endif</td>
                    
                      <td>@if($issuances[$i]['department']!=''){{$issuances[$i]['department']['name']}}@endif</td>
                      <td>@if($issuances[$i]['plan']!=''){{$issuances[$i]['plan']['plan_no']}}@endif</td>
                      <td>@if($issuances[$i]['plan']!=''){{$issuances[$i]['plan']['product']['item_name']}}@endif</td>
                      <td>{{$issuances[$i]['issued']}}</td>
                     <td>{{$issuances[$i]['remarks']}}</td>
                  
                                       
                    <td><a href="{{url('edit/issuance/'.$issuances[$i]['issuance_no'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  