
@extends('layout.master')
@section('title', 'QA Samplings')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">QA Samplings</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>-->
            <a class="btn" href="{{url('/sampling/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">QC</a></li>
              <li class="breadcrumb-item active">QA Samplings</li>
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

               

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                 <tr>
                    <th>Id</th>
                    <th>Req No.</th>
                    <th>Req Date</th>
                    <th>Item</th>
                    <th>Vendor</th>
                    <th>GRN No</th>
                    <th>Origin</th>
                    <th>Batch No.</th>
                    <th>Mfg. Date</th>
                    <th>Exp. Date</th>
                    <th>Total Qty</th>
                    <th>Sample Qty</th>
                    <th></th>
                  </tr>


                  </thead>
                  <tbody>
                  
                 @foreach($requests as $req)
                      <tr>
                      <td>{{$req['id']}}</td>
                     <td>{{$req['sampling_no']}}</td>
                     <td>{{$req['sampling_date']}}</td>
                     <td>@if($req['item']!=''){{$req['item']['item_name']}}@endif</td>
                     <td>@if(isset($req['stock']['grn']['vendor']['name'])){{$req['stock']['grn']['vendor']['name']}}@endif</td>
                     <td>@if($req['stock']!=''){{$req['stock']['grn_no']}}@endif</td>
                     <td>@if(isset($req['stock']['origin']['name'])){{$req['stock']['origin']['name']}}@endif</td>
                     <td>@if($req['stock']!=''){{$req['stock']['batch_no']}}@endif</td>
                     <td>@if($req['stock']!=''){{$req['stock']['mfg_date']}}@endif</td>
                     <td>@if($req['stock']!=''){{$req['stock']['exp_date']}}@endif</td>
                    <td>{{$req['total_qty']}}</td>
                     <td>{{$req['sample_qty']}}</td>
                     
                     <td>
                    <a href="{{url('/sampling/'.$req['id'])}}"><span class="fa fa-edit"></span></a>
                      @if($req['result']=='')
                    <!-- <a href="{{url('qa/sampling/'.$req['sampling_id'])}}"><span class="fa fa-edit"></span></a> -->
                    @else
                    <!-- <a href="{{url('edit/qc/result/'.$req['result']['id'])}}"><span class="fa fa-edit"></span></a>
 -->                    @endif
                     </td>
                   
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
  