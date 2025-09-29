
@extends('layout.master')
@section('title', 'GRN History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">GRN History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('purchase/goods-receiving-note')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase GRN</a></li>
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
                <h3 class="card-title">GRNs</h3>
              
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
                  
                  <thead class="table-primary" >
                  

                 <tr>
                    <th>#</th>
                    <th>GRN No</th>
                    <th>GRN Date</th>
                    <th>Vendor</th>
                    <th>PO No</th>
                    <th>PO Date</th>
                    
                    <th>Qty</th>
                    <th>Weight</th>
                 
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Action</th>
                  </tr>

                  </thead>
                  <tbody>
                  
                 

                     <?php $i=1; ?>      
            
                    @foreach($grns as $grn)

                   
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td>{{$grn['doc_no']}}</td>
                     <td>{{$grn['doc_date']}}</td>
                    <td>@if(isset($grn['vendor'])){{$grn['vendor']['name']}}@endif</td>
                     <td>@if(isset($grn['order'])){{$grn['order']['doc_no']}}@endif</td>
                      <td>@if(isset($grn['order'])){{$grn['order']['doc_date']}}@endif</td>
                     
                     <td>{{number_format($grn->total_quantity(),2)}}</td>
                     <td>{{number_format($grn->total_weight(),2)}}</td>
                     
                     <?php 
                         $s=$grn['status'];
                     
                      ?>
                     <td>
                      @if($s==0)
                      <span class="badge badge-warning">Unpost</span>
                      @elseif($s==1 && !isset($grn['purchase']))
                      <span class="badge badge-primary">Bill Pending</span>
                      @elseif($s==1 && isset($grn['purchase']))
                      <span class="badge badge-info">Post</span>
                      @endif
                    </td>

                    <td>@if(isset($grn['user'])){{ $grn['user']['name'] }}@endif</td>
                   
                    <td>

                      @if($s==1 && !isset($grn['purchase']))
                       <a class="btn btn-info btn-sm" href="{{url('purchase?grn='.$grn['id'])}}" >Invoice</a>
                      @endif

                      <a href="{{url('edit/purchase/grn/'.$grn['doc_no'])}}"><span class="fa fa-edit"></span></a>
                    </td>
                     
                    </tr>
                   <!--  <tr><td colspan="8"></td></tr> -->

                     <?php $i++; ?>
                    @endforeach
                
                  
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
  