
@extends('layout.master')
@section('title', 'Transfer History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Transfer Note History</h1>
            
          <a class="btn" href="{{url('/transfer-note')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Transfer Note</li>
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
                <h3 class="card-title">Transer Note List</h3>
              
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
              
                    <th>Plan No</th>
                    <th>Product</th>
                    <th>Batch No</th>
                     <th>Theoretical Qty</th>
                    <th>Actual Qty</th>
                    <th>QC Sample</th>
                     <th>QA Sample</th>
                    <th>% Yield</th>
                    <th>Cost Price</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $yields) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$yields[$i]['id']}}</td>
                     <td>{{$yields[$i]['plan']['plan_no']}}</td>
                     <td>{{$yields[$i]['plan']['product']['item_name']}}</td>
                     <td>{{$yields[$i]['plan']['batch_no']}}</td>
                     <td>{{$yields[$i]['plan']['batch_qty']}}</td>
                     <td>{{$yields[$i]->actual_qty()}}</td>
                    <td>{{$yields[$i]['qc_sample']}}</td>
                     <td>{{$yields[$i]['qa_sample']}}</td>
                     <td>{{$yields[$i]->percent_yield()}}</td>
                     <td>{{$yields[$i]['cost_price']}}</td>
                    <td><a href="{{url('edit/transfer-note/'.$yields[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  