
@extends('layout.master')
@section('title', 'Return Note')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('save/return/note')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Return Note</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('return-note-list')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Stock</a></li>
              <li class="breadcrumb-item active">Return Note</li>
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
                <h3 class="card-title">Return Note</h3>

                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <!-- <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="{{url('create/return-note')}}" class="dropdown-item">Return Note</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div> -->
                  
                </div>
                <!-- /. tools -->
                 
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
                <input type="hidden" form="ticket_form" value="{{$stock['id']}}" name="stock_id"/>
                
                <div class="row">

                  <div class="col-md-8">


                <div class="form-row">

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Return No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control select2 col-sm-8" value="{{$doc_no}}" required style="width: 100%;">
                  </div>
                 </div>
               
               <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Return Date</label>
                  <input type="date" form="ticket_form" name="doc_date" class="form-control select2 col-sm-8" value="{{date('Y-m-d')}}" required style="width: 100%;">
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
                  <label class="col-sm-4">Rec. Date</label>
                  <input type="date" form="ticket_form" name="rec_date" class="form-control select2 col-sm-8" value="{{$stock['grn']['doc_date']}}"   required style="width: 100%;">
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
                   if($stock['grn']['vendor']!='')
                    $vendor=$stock['grn']['vendor']['name'];
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
                  <input type="text" form="ticket_form" name="origin" class="form-control select2 col-sm-8" value="@if($stock['origin']!=''){{$stock['origin']['name']}}@endif" readonly required style="width: 100%;">
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
                  <label class="col-sm-4">Rec Qty</label>
                  <input type="number" form="ticket_form" name="rec_quantity" class="form-control select2 col-sm-8" value="{{$stock['rec_quantity']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <?php $total=$stock['rec_quantity'] * $stock['pack_size']; ?>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Total Qty</label>
                  <input type="number" form="ticket_form" name="total_quantity" class="form-control select2 col-sm-8"  value="{{$total}}" disabled style="width: 100%;">
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
                  <input type="text" form="ticket_form" name="pack_size" id="pack_size" class="form-control select2 col-sm-8" value="{{$stock['pack_size']}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                  <?php $rej=$stock['rec_quantity']-$stock['approved_qty']; ?>
                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Rejected Qty</label>
                  <input type="number" max="{{$rej}}" form="ticket_form" name="rejected_qty" class="form-control select2 col-sm-8" value="{{$rej}}" id="rejected_qty" onchange="" readonly style="width: 100%;">
                  </div>
                 </div>
                  <?php $gros=$rej * $stock['pack_size']; ?>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Gross Qty</label>
                  <input type="number" form="ticket_form" name="gross_quantity" class="form-control select2 col-sm-8" id="gross_quantity" value="{{$gros}}" readonly disabled style="width: 100%;">
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

                   <label class="col-sm-6 offset-sm-4"><input type="checkbox" form="ticket_form" name="returned" id="returned" class="" value="1"  onchange="">&nbsp&nbspReturned</label> 

                  <label class="col-sm-6 offset-sm-4"><input type="checkbox" form="ticket_form" name="active" id="active" class="" value="1" checked>&nbsp&nbspActive</label>

                  
                  </div>
                 </div>

               

               </div>
 
                   </div><!--outter row col-->
                     <div class="col-md-3">
                       <!-- <fieldset class="border p-4">
                          <legend class="w-auto">Result</legend>

                         <div class="form-row">

                         <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12"><input type="radio" form="ticket_form" name="qc_required" value="1" id="qc_required" onclick="setQC()" checked class="">&nbsp&nbspQC Request</label>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12"><input type="radio" form="ticket_form" name="qc_required" value="0" id="add_to_stock" onclick="setAddStock()"  class="" >&nbsp&nbspAdd to Stock</label>
                  </div>
                </div>

              </div>
            </fieldset> -->
                     </div>
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

    $(document).ready(function(){

    var active = <?php echo json_encode($stock['active']); ?>
    
    if(active==1)
    {
      //$('#active').prop("checked", true);
    }
    else
      //$('#active').prop("checked", false);

    

     var origin_id = <?php echo json_encode($stock['origin_id']); ?>
    
   
      $('#origin').val(origin_id);
    


  });

    


    
    
 

 
  </script>





@endsection  
  