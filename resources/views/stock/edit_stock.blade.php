
@extends('layout.master')
@section('title', 'View Stock')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('update/stock/')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Stock</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('stock-list')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Stock List</a></li>
              <li class="breadcrumb-item active">Stock</li>
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
                <h3 class="card-title">Stock</h3>

                <!-- tools card -->

                <div class="card-tools">
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>-->
                  <label>
                    @if($stock['is_opening_stock'])
                      <span class="badge badge-info">Opening Stock</span>
                      @endif
                      @if($stock['is_sampled']==1)
                      <span class="badge badge-warning">Advance Sampled</span>
                      @endif
                    @if($stock->is_under_qc()==1)
                      <span class="badge badge-info">Under QC</span>
                      @else
                     @if($stock['stock_current_qty']>0)
                      <span class="badge badge-success">Available</span>
                      @elseif($stock['stock_current_qty']<0)
                      <span class="badge badge-warning">Somthing Wrong</span>
                      @elseif($stock['stock_current_qty']==0)
                      <span class="badge badge-danger">Closed</span>
                      @endif
                      @endif
                </label>
                     <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">

                        @if($stock['return_note']=='')
                      <a href="{{url('create/return-note/'.$stock['id'])}}" class="dropdown-item">Return Note</a>
                      @else
                      <a href="{{url('edit/return-note/'.$stock['return_note']['id'])}}" class="dropdown-item">Return Note</a>
                      @endif
                      @foreach($stock['qa_samplings'] as $key)
                      <a href="{{url('qa/sampling/'.$key['id'])}}" class="dropdown-item">{{$key['sampling_no']}}</a>
                      @endforeach

                      @foreach($stock['qa_samplings'] as $key)
                      @if($key['qc_report']!='')
                      <a href="{{url('edit/qc/result/'.$key['qc_report']['id'])}}" class="dropdown-item">{{$key['qc_report']['qc_number']}}</a>
                      @endif
                      @endforeach

                    
                      <div class="dropdown-divider"></div>

                      <!-- <a href="{{url('sampling-for-qc/'.$stock['id'])}}" class="dropdown-item">Sampling For QC</a> -->
                      <!-- <a href="{{url('qa-sampling/'.$stock['id'])}}" class="dropdown-item">Sampling For QC</a> -->
                    </div>
                  </div>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button> -->
                </div>

                
                <!-- /. tools -->
                 
              </div>

              
              <!-- /.card-header -->
              <div class="card-body">

                 @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
    </div>
             @endif

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             @if(session()->has('info'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('info') }}
    </div>
             @endif



                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                <input type="hidden" form="ticket_form" value="{{$stock['id']}}" name="stock_id"/>
                
                <div class="row">
                  
                  <div class="col-md-8">


                <div class="form-row">

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Grn No.</label>
                  <input type="text" form="ticket_form" name="grn_no" class="form-control select2 col-sm-8" value="{{$stock['grn_no']}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Rec. No</label>
                  <input type="text" form="ticket_form" name="rec_date" class="form-control select2 col-sm-8" value="@if($stock['grn']!=''){{$stock['grn']['grn_no']}}@endif"   readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Rec. Date</label>
                  <input type="date" form="ticket_form" name="rec_date" class="form-control select2 col-sm-8" value="@if($stock['grn']!=''){{$stock['grn']['doc_date']}}@endif"   readonly style="width: 100%;">
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

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Approved Qty</label>
                  <input type="number" step="any" form="ticket_form" name="approved_quantity" class="form-control select2 col-sm-8" id="approved_qty" onchange="setGross()" value="{{$stock['approved_qty']}}"  style="width: 100%;">
                  </div>
                 </div>
                  <?php $gros=$stock['approved_qty'] * $stock['pack_size']; ?>

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
                  <textarea form="ticket_form" name="remarks" class="form-control select2 col-sm-10" style="width: 100%;">{{$stock['remarks']}}</textarea>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">


                  <label class="col-sm-6 offset-sm-4"><input type="checkbox" form="ticket_form" name="active" id="active" class="" value="1" >&nbsp&nbspActive</label>

                  
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

    var active = <?php echo json_encode($stock['is_active']); ?>
    
    if(active==1)
    {
      $('#active').prop("checked", true);
    }
    else
      $('#active').prop("checked", false);

    // var qc_required = <?php echo json_encode($stock['qc_required']); ?>
    
    // if(qc_required==1)
    // {
    //   $('#qc_required').prop("checked", true);
    // }
    // else
    //    $('#qc_required').prop("checked", false);

     var origin_id = <?php echo json_encode($stock['origin_id']); ?>
    
   
      $('#origin').val(origin_id);
    


  });

    


    function setQC()
 {
  var qc_required=$('#qc_required').val();
  var qc_required=$('#qc_required').is(':checked');
//alert(qc_required);
  if(qc_required==1)
  {
     $('#approved_qty').val('');
  $('#approved_qty').attr('disabled', 'disabled');
  $('#gross_quantity').val('');
  $('#gross_quantity').attr('disabled', 'disabled');
  }
  else
  {
     $('#approved_qty').removeAttr('disabled');
        var qty = <?php echo json_encode($stock['rec_quantity']) ?>;
      $('#approved_qty').val(qty);

     $('#gross_quantity').removeAttr('disabled');
     var p_s=$('#pack_size').val();
     var gros = qty * p_s;
      $('#gross_quantity').val(gros);
  }
  
 }
    
 

 function setGross()
 {
  var qty = $('#approved_qty').val();
 

  
  var p_s=$('#pack_size').val();
  var gros = qty * p_s;
  $('#gross_quantity').val(gros);
  //alert('add');
 }

  </script>





@endsection  
  