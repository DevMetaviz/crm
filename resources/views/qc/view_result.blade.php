
@extends('layout.master')
@section('title', 'QC Result')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('update/qc/report')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">QC Result</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('lab-test-results')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/qc/result/report/'.$result['id'])}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Incoming Stock</a></li>
              <li class="breadcrumb-item active">QC Request</li>
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
                <h3 class="card-title">Certificate Of Analysis</h3>

                 
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
                
                 <input type="hidden" form="ticket_form" value="{{$result['id']}}" name="result_id"/>
                 <input type="hidden" form="ticket_form" value="{{$result['request']['sampling_id']}}" name="sampling_id"/>
                 
                
                <div class="row">

                  <div class="col-md-9">


                <div class="form-row">

                  

                  

                 
                  
                  

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Item</label>
                  <input type="text" form="ticket_form" name="item_name" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['item_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                   
                   
                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Vendor</label>
                  <input type="text" form="ticket_form" name="vendor" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['vendor_name']}}" readonly style="width: 100%;">
                  </div>
                 </div>

                 

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['batch_no']}}" readonly  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Testing Specs</label>
                  <input type="text" form="ticket_form" name="testing_specs" class="form-control select2 col-sm-8" value="{{$result['testing_specs']}}"   style="width: 100%;">
                  </div>
                 </div>


                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg. Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['mfg_date']}}" readonly  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Exp. Date</label>
                  <input type="date" form="ticket_form" name="exp_date" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['exp_date']}}" readonly   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Grn No.</label>
                  <input type="text" form="ticket_form" name="grn_no" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['grn_no']}}" readonly style="width: 100%;">
                  </div>
                 </div>

                 

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Total Qty</label>
                  <input type="number" form="ticket_form" name="rec_quantity" class="form-control select2 col-sm-8" value="{{$result['request']['total_qty']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sample Qty</label>
                  <input type="number" form="ticket_form" name="sample_qty" class="form-control select2 col-sm-8" value="{{$result['request']['sample_qty']}}" readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Approved Qty</label>
                  <input type="number" form="ticket_form" name="approved_qty" class="form-control select2 col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Unit</label>
                  <input type="text" form="ticket_form" name="unit" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['unit']}}"    readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pack_size" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['pack_size']}}" readonly  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">QC No.</label>
                  <input type="text" form="ticket_form" name="qc_no" class="form-control select2 col-sm-8" value="{{$result['qc_number']}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Date Tested</label>
                  <input type="date" form="ticket_form" name="test_date" class="form-control select2 col-sm-8" value="{{$result['tested_date']}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Stock Received</label>
                  <input type="date" form="ticket_form" name="" class="form-control select2 col-sm-8" value="{{$result['request']['stock']['rec_date']}}" readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Released Date</label>
                  <input type="date" form="ticket_form" name="released_date" class="form-control select2 col-sm-8" value="{{$result['released_date']}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Released Time</label>
                  <input type="time" form="ticket_form" name="released_time" class="form-control select2 col-sm-8" value="{{$result['released_time']}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Retest Date</label>
                  <input type="date" form="ticket_form" name="retest_date" class="form-control select2 col-sm-8" value="{{$result['retest_date']}}"  style="width: 100%;">
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
                  <textarea form="ticket_form" name="remarks" class="form-control select2 col-sm-10" style="width: 100%;">{{$result['remarks']}}</textarea>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  
                  <label class="col-sm-6 offset-sm-4"><input type="checkbox" form="ticket_form" name="active" id="active" class="" value="1"  >&nbsp&nbspActive</label>

                  
                  </div>
                 </div>

               

               </div>

               <div class="bg-info">
               <h3>Parameters</h3>
                </div>

                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                 <tr>
                    <th>PARAMETERS</th>
                    <th>SPECIFICATIONS</th>
                    <th>OBESRVATIONS</th>
                  </tr>


                  </thead>
                  <tbody>
                    @foreach($result['parameters'] as $prtm)

                    <tr>
                    <th>
                         <input type="text" form="ticket_form" name="parameters[]" value="{{$prtm['name']}}">
                         <input type="hidden" form="ticket_form" name="parameter_ids[]" value="{{$prtm['id']}}">
                    </th>
                    <td><textarea form="ticket_form" name="specifications[]" class="form-group form-control select2 col-sm-12" style="width: 100%;">{{$prtm['specification']}}</textarea></td>
                    <td><textarea form="ticket_form" name="observations[]" class="form-group form-control select2 col-sm-12" style="width: 100%;" required>{{$prtm['value']}}</textarea>
                     </td>
                  </tr>
                
                
                @endforeach
                  </tbody>

                </table>

                
                

                  
                    
 
                   </div><!--outter row col-->

                   <div class="col-md-3">
                        <fieldset class="border p-4">
                          <legend class="w-auto">Result</legend>

                         <div class="form-row">

                         <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12"><input type="radio" form="ticket_form" name="released" value="1" class="" id="released" >&nbsp&nbspReleased</label>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12"><input type="radio" form="ticket_form" name="released" value="0" id="default" class="" id="rejected" >&nbsp&nbspRejected</label>
                  </div>
                </div>

              </div>


                        </fieldset>
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

    var active = <?php echo json_encode($result['is_active']); ?>
    
    if(active==1)
    {
      $('#active').prop("checked", true);
    }

    var rslt = <?php echo json_encode($result['released']); ?>

    $(`input[name=released][value=${rslt}]`).prop("checked",true);

    
    
    
  });


   

  </script>





@endsection  
  