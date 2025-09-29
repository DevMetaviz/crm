
@extends('layout.master')
@section('title', 'QA Sampling')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('save/qa/sampling')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">QA Sampling</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Stock</a></li>
              <li class="breadcrumb-item active">QA Sampling</li>
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
                <h3 class="card-title">QA Sampling</h3>
                 
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             @if ($errors->has('error'))                       
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                                          </div>  
                                @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                <input type="hidden" form="ticket_form" value="{{$stock['id']}}" name="stock_id"/>
                
                <div class="row">

                  <div class="col-md-10">


                <div class="form-row">

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sampling No.</label>
                  <input type="text" form="ticket_form" name="sampling_no" class="form-control select2 col-sm-8" value="{{$doc_no}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sampling Date</label>
                  <input type="date" form="ticket_form" name="sampling_date" class="form-control select2 col-sm-8" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sampling Time</label>
                  <input type="time" form="ticket_form" name="sampling_time" class="form-control select2 col-sm-8" value="{{date('H:i:s')}}" required style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Grn No.</label>
                  <input type="text" form="ticket_form" name="grn_no" class="form-control select2 col-sm-8" value="{{$stock['grn_no']}}" required style="width: 100%;">
                  </div>
                 </div>
                  
                  

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Item</label>
                  <input type="text" form="ticket_form" name="item_name" class="form-control select2 col-sm-8" value="{{$stock['item']['item_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <?php 


                     $vendor='';
                     if($stock['grn']!='')
                     {
                   if($stock['grn']['vendor']!='')
                    $vendor=$stock['grn']['vendor']['name'];
                     }


                    ?>
                   
                   
                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Vendor</label>
                  <input type="text" form="ticket_form" name="vendor" class="form-control select2 col-sm-8" value="{{$vendor}}" readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Origin</label>
                  <select name="origin" form="ticket_form" id="origin" class="form-control select2 col-sm-8" style="width: 100%;">
                    <option value=""  >------Select any value-----</option>
                    @foreach($origins as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                    
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" class="form-control select2 col-sm-8" value="{{$stock['batch_no']}}"   style="width: 100%;">
                  </div>
                 </div>


                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg. Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" class="form-control select2 col-sm-8" value="{{$stock['mfg_date']}}"   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Exp. Date</label>
                  <input type="date" form="ticket_form" name="exp_date" class="form-control select2 col-sm-8" value="{{$stock['exp_date']}}"    style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">No. of container</label>
                  <input type="number" form="ticket_form" name="no_of_container" class="form-control select2 col-sm-8" value="{{$stock['no_of_container']}}"   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Type of Container</label>
                  <input type="text" form="ticket_form" name="type_of_container" class="form-control select2 col-sm-8" value="{{$stock['type_of_container']}}"    style="width: 100%;">
                  </div>
                 </div>

                 <?php 
                   

                   if($stock['approved_qty']=='' || $stock['approved_qty']==null)
                    $total=$stock['rec_quantity'];
                  else
                 $total=$stock['stock_current_qty'];

                  ?>
                
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Total Qty</label>
                  <input type="number" form="ticket_form" name="total_qty" class="form-control select2 col-sm-8" value="{{$total}}"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sample Qty</label>
                  <input type="number" step="any" form="ticket_form" name="sample_qty" class="form-control select2 col-sm-8" value="" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Unit</label>
                  <input type="text" form="ticket_form" name="unit" class="form-control select2 col-sm-8" value="{{$stock['unit']}}"   required readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pack_size" class="form-control select2 col-sm-8" value="{{$stock['pack_size']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Type</label>
                  <select name="type" form="ticket_form" id="type" class="form-control select2 col-sm-8" style="width: 100%;" required>
                    <option value="">Select any value</option>
                    <option value="new_arrival"  >New Arrival</option>
                    <option value="retest"  >Retest</option>
                    
                    
                  </select>
                  </div>
                 </div>
<!-- 
                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Process Name</label>
                  <input type="text" form="ticket_form" name="process_name" class="form-control select2 col-sm-8" value="" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sample Qty</label>
                  <input type="number" form="ticket_form" name="sample_qty" class="form-control select2 col-sm-8" value="1" min="1" required   style="width: 100%;">
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
                 </div> -->

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea form="ticket_form" name="remarks" class="form-control select2 col-sm-10" style="width: 100%;"></textarea>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  
                  <label class="col-sm-6 offset-sm-4"><input type="checkbox" form="ticket_form" name="verified" id="verified" class="" value="1" checked >&nbsp&nbspVerified By QA</label>

                  
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

  <script type="text/javascript">
    
   
    var origin=<?php echo json_encode($stock['origin_id']) ?>;
    if(origin!='')
    {
      $('#origin').val(origin);
    }

   

  </script>





@endsection  
  