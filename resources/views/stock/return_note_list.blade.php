
@extends('layout.master')
@section('title', 'Return Note List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Return Note List</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
           <!--  <a class="btn" href="{{url('/purchase/order')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Return Note</a></li>
              <li class="breadcrumb-item active">List</li>
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
                <h3 class="card-title">List</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>#</th>
                    <th>Doc No</th>
                    <th>Doc Date</th>
                    <th>GRN No</th>
                    <th>Item</th>
                     <th>Vendor</th>
                    <th>Qty</th>
                    
                    
                    <th>Remarks</th>
                    <th>Active</th>
                    <th></th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $notes) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$i+1}}</td>
                     <td>{{$notes[$i]['doc_no']}}</td>
                     <td>{{$notes[$i]['doc_date']}}</td>
                     <td>{{$notes[$i]['stock']['grn_no']}}</td>
                     <td>{{$notes[$i]['stock']['item']['item_name']}}</td>
                    <td>@if($notes[$i]['stock']['grn']['vendor']!=''){{$notes[$i]['stock']['grn']['vendor']['name']}}@endif</td>
                     <td>{{$notes[$i]['qty']}}</td>
                      <td>{{$notes[$i]['remarks']}}</td>
                    
                     <td>{{$notes[$i]['activeness']}}</td>
                   
                    <td><a href="{{url('edit/return-note/'.$notes[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  