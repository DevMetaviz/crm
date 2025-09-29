
@extends('layout.master')
@section('title', 'QC Results')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Stock QC Results</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('#')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Lab Test</a></li>
              <li class="breadcrumb-item active">Result</li>
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
                <h3 class="card-title">Result List</h3>
              
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
                  
                 <tr>
                    <th>Id</th>
                    <th>QC No.</th>
                    <th>Req No.</th>
                    <th>Req Date</th>
                    <th>Item</th>
                    <th>Vendor</th>
                    <th>GRN No</th>
                    <th>Origin</th>
                    <th>Testing Specs</th>
                    <th>Batch No.</th>
                    <th>Mfg. Date</th>
                    <th>Exp. Date</th>
                    <th>Total Qty</th>
                    <th>Sample Qty</th>
                    <th></th>
                  </tr>


                  </thead>
                  <tbody>
                  
                 @foreach($results as $req)
                      <tr>
                      <td>{{$req['id']}}</td>
                      <td>{{$req['qc_number']}}</td>
                     <td>{{$req['request']['sampling_no']}}</td>
                     <td>{{$req['request']['sampling_date']}}</td>
                    <td>{{$req['request']['stock']['item_name']}}</td>
                     <td>{{$req['request']['stock']['vendor_name']}}</td>
                     <td>{{$req['request']['stock']['grn_no']}}</td>
                     <td>{{$req['request']['stock']['origin']}}</td>
                     <td>{{$req['testing_specs']}}</td>
                     <td>{{$req['request']['stock']['batch_no']}}</td>
                     <td>{{$req['request']['stock']['mfg_date']}}</td>
                     <td>{{$req['request']['stock']['exp_date']}}</td>
                    <td>{{$req['request']['total_qty']}}</td>
                     <td>{{$req['request']['sample_qty']}}</td>
                     
                     <td>
                      <a href="{{url('qa/sampling/'.$req['request']['sampling_id'])}}">Sampling</a>
                      <a href="{{url('edit/qc/result/'.$req['id'])}}">Result</a>
                      <a href="{{url('stock/qc/result/'.$req['request']['stock']['stock_id'].'/'.$req['request']['sampling_id'])}}"><span class="fa fa-plus-circle"></span></a></td>
                   
                  </tr>
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
  