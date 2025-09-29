
@extends('layout.master')
@section('title', 'Purchase Demad History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Purchase Demad History</h1>
           <!--  <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/purchase/demand')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase Demand</a></li>
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
                <h3 class="card-title">Purchase Demands</h3>
              
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
                    <th>Id</th>
                    <th>Doc No</th>
                    <th>Doc Date</th>
                    <th>Required Date</th>
                   <!---- <th>Department</th>-->
                    <th>Qty</th>
                    <th>Remarks</th>
                    <th>Post</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $demands) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$demands[$i]['id']}}</td>
                     <td>{{$demands[$i]['doc_no']}}</td>
                     <td>{{$demands[$i]['doc_date']}}</td>
                      <td>{{$demands[$i]['required_date']}}</td>
                    <!---- <td>{{$demands[$i]['department']}}</td>-->
                     <td>{{$demands[$i]['quantity']}}</td>
                     <td>{{$demands[$i]['remarks']}}</td>
                     <td>{{$demands[$i]['posted']}}</td>
                   
                    <td><a href="{{url('edit/purchase/demand/'.$demands[$i]['doc_no'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  