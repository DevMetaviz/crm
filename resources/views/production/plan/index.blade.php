
@extends('layout.master')
@section('title', 'Production Planing History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Production Planing History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/production-plan')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production Standard</a></li>
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
                <h3 class="card-title">Production Planing</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               <form role="form" id="plan_check_form" method="get" action="{{url('production/plan/history')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    
              <!-- <div class="col-md-4">
                    <div class="form-group">
                  <label>Item</label>
                  <select class="form-control select2" onchange="" name="item_id" id="item_id">
                    <option value="">------Select any value-----</option>
                    
                  </select>
                </div>
              </div> -->


                  <!-- <div class="col-md-4">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code" value="">
      
           </div>
           </div>
 -->
           <div class="col-md-2">
                    <div class="form-group">
                  <label>Mfg From</label>
                  <input type="date" class="form-control "  name="mfg_from" id="mfg_from" value="@if(isset($mfg_from)){{$mfg_from}}@endif">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Mfg To</label>
                  <input type="date" class="form-control "  name="mfg_to" id="mfg_to"  value="@if(isset($mfg_to)){{$mfg_to}}@endif" >
                </div>
              </div>


                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>

                

               <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                 <tr>
                    <th>Id</th>
                    <th>Plan No</th>
                    <th>Plan Date</th>
                    <th>Demand No</th>
                   
                    
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Batch Size</th>
                    <th>Batch No</th>
                    <th>Mfg Date</th>
                    <th>Exp Date</th>
                    <th>MRP</th>
                    <th>Remarks</th>
                    
                    <th></th>
                  </tr>



                  </thead>
                  <tbody>
                  
                 
                  
            
                    @for($i=0;$i< count( $plans) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$i+1}}</td>
                     <td>{{$plans[$i]['plan_no']}}</td>
                     <td>{{$plans[$i]['plan_date']}}</td>
                    
                     <td>@if($plans[$i]['demand']!=''){{$plans[$i]['demand']['doc_no']}}@endif</td>
                      <td>@if($plans[$i]['product']!=''){{$plans[$i]['product']['item_name']}}@endif</td>
                     <td>{{$plans[$i]['batch_qty']}}</td>
                     <td>{{$plans[$i]['batch_size']}}</td>
                     <td>{{$plans[$i]['batch_no']}}</td>
                     <td>{{$plans[$i]['mfg_date']}}</td>
                     <td>{{$plans[$i]['exp_date']}}</td>
                     <td>{{$plans[$i]['mrp']}}</td>
                      <td>{{$plans[$i]['remarks']}}</td>
                    
                   
                    <td><a href="{{url('production-plan/edit/'.$plans[$i]['plan_no'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  