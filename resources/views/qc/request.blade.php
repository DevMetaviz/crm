
@extends('layout.master')
@section('title', 'Lab Test Request')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('ticket/stage/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Lab Test Request</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Lab Test</a></li>
              <li class="breadcrumb-item active">Request</li>
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
                <h3 class="card-title">{{'Test Request ( '.$ticket_process['process_name'].' )'}}</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                <input type="hidden" form="ticket_form" value="{{$ticket_process['id']}}" name="ticket_process_id"/>
                
                <div class="row">

                  <div class="col-md-10">


                <div class="form-row">

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Req No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control select2 col-sm-8" value="{{$doc_no}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                  
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Date</label>
                  <input type="date" form="ticket_form" name="date" class="form-control select2 col-sm-8" value="{{date('Y-m-d')}}" readonly required style="width: 100%;">
                  </div>
                 </div>


                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No.</label>
                  <input type="text" form="ticket_form" name="plan_no" class="form-control select2 col-sm-8" value="{{$ticket_process['ticket']['plan']['plan_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Ticket No.</label>
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$ticket_process['ticket']['ticket_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Plan Product</label>
                  <input type="text" form="ticket_form" name="plan_no" class="form-control select2 col-sm-8" value="{{$ticket_process['ticket']['product']['item_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" class="form-control select2 col-sm-8" value="{{$ticket_process['ticket']['batch_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="text" form="ticket_form" name="batch_size" class="form-control select2 col-sm-8" value="{{$ticket_process['ticket']['batch_size']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Process Name</label>
                  <input type="text" form="ticket_form" name="process_name" class="form-control select2 col-sm-8" value="{{$ticket_process['process_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sample Qty</label>
                  <input type="number" form="ticket_form" name="sample_qty" class="form-control select2 col-sm-8" value="1" min="0" required   style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg. Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" class="form-control select2 col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Exp. Date</label>
                  <input type="date" form="ticket_form" name="exp_date" class="form-control select2 col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea form="ticket_form" name="remarks" class="form-control select2 col-sm-10" style="width: 100%;"></textarea>
                  </div>
                 </div>

               

               </div>
 
                   </div><!--outter row col-->
                </div><!--outter row-->
                 

                



              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  