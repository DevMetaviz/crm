
@extends('layout.master')
@section('title', 'Stock History')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Stock History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('/purchase/order')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Stock</a></li>
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
                <h3 class="card-title">Stocks</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

              <div class="table-responsive p-0" style="height: 400px;">
                <table id="example1" class="table table-bordered table-hover table-head-fixed text-nowrap" style="">
                  
                  <thead>
                  

                    <tr>
                    <th>No.</th>
                    <th>GRN No</th>
                    <th>Vendor</th>
                    <th>Location</th>
                    <th>Item Code</th>
                    <th>Item name</th>

                    <th>Origin</th>
                  
                    <th>Batch #</th>
                    
                    <th>Mfg. Date</th>
                    <th>Exp. Date</th>
                    
                    <th>Rec. Qty</th>
                    <th>App. Qty</th>
                    <th>Unit</th>
                    <th>Pack Size</th>
                    <th>Total Qty</th>
                    <th>Current Qty</th>
                    <th>Rec Date</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

                  </thead>
                  <tbody>
                  
                 

                  
            
                    @for($i=0;$i< count( $stocks) ; $i++)

          
                      
                        <tr>
                   
                     <td>{{$i+1}}</td>
                     <td>{{$stocks[$i]['grn_no']}}</td>
                     <td>{{$stocks[$i]['vendor_name']}}</td>
                     <td>{{$stocks[$i]['location']}}</td>
                     <td>{{$stocks[$i]['item_code']}}</td>
                    <td>{{$stocks[$i]['item_name']}}</td>
                     <td>{{$stocks[$i]['origin']}}</td>
                      <td>{{$stocks[$i]['batch_no']}}</td>
                     <td>{{$stocks[$i]['mfg_date']}}</td>
                     <td>{{$stocks[$i]['exp_date']}}</td>
                     
                     <td>{{$stocks[$i]['rec_qty']}}</td>
                     <td>{{$stocks[$i]['qty']}}</td>
                     <td>{{$stocks[$i]['unit']}}</td>
                     <td>{{$stocks[$i]['pack_size']}}</td>
                     <td>{{$stocks[$i]['total_qty']}}</td>
                     <td>{{$stocks[$i]['stock_current_qty']}}</td>
                     <td>{{$stocks[$i]['date']}}</td>
                     
                     <td>
                      @if($stocks[$i]['is_under_qc']==1)
                      <span class="badge badge-info">Under QC</span>
                      @elseif($stocks[$i]['is_sampled']==1)
                      <span class="badge badge-warning">Advance Sampled</span>
                      @else
                      @if($stocks[$i]['stock_current_qty']>0)
                      <span class="badge badge-success">Available</span>
                      @elseif($stocks[$i]['stock_current_qty']<0)
                      <span class="badge badge-warning">Somthing Wrong</span>
                      @elseif($stocks[$i]['stock_current_qty']==0)
                      <span class="badge badge-danger">Closed</span>
                      @endif
                      @endif
                     </td>
                     <th>
                      
                      <a href="{{url('stock/edit/'.$stocks[$i]['stock_id'])}}"><span class="fa fa-edit"></span></a>
            
                     </th>
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


<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>




@endsection  
  