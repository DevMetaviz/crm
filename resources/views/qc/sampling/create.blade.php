
@extends('layout.master')
@section('title', 'QA Sampling')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('save/sampling')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">QA Sampling</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('sampling/list')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">QA</a></li>
              <li class="breadcrumb-item active">Sampling</li>
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
                
                
                <div class="row">

                  <div class="col-md-10">


                <div class="form-row">

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sampling No.</label>
                  <input type="text" form="ticket_form" name="sampling_no" class="form-control col-sm-8" value="{{$doc_no}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Intimation Date</label>
                  <input type="date" form="ticket_form" name="intimation_date" class="form-control col-sm-8" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Intimation Time</label>
                  <input type="time" form="ticket_form" name="intimation_time" class="form-control col-sm-8" value="{{date('H:i:s')}}" required style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Type</label>
                  <select name="type" form="ticket_form" id="type" class="form-control  col-sm-8" style="width: 100%;" onchange="setAtt()" required>
                    <option value="item_base"  >Item Base</option>
                    <!-- <option value="production_base"  >Production Base</option> -->
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Department</label>
                  <select name="department_id" form="ticket_form" id="department_id" class="form-control select2 col-sm-8" onchange="setDepartItems()" style="">
                    <option value=""  >Select any value</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}"  >{{$depart['name']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Item</label>
                  <select name="item_id" form="ticket_form" id="item_id" onchange="setItem()" class="form-control select2 col-sm-8" style="">
                    <option value=""  >Select any value</option>
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-6 plan">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No</label>
                  <select name="plan_batch_no" form="ticket_form" id="plan_batch_no" onchange="setPlan()" class="form-control col-sm-8" style="">
                    <option value=""  >Select any value</option>
                  </select>
                  </div>
                 </div>

                  <div class="col-sm-6 plan">
                <div class="form-group row">
                  <label class="col-sm-4">Process</label>
                  <select name="plan_process" form="ticket_form" id="plan_process"  class="form-control col-sm-8" style="">
                    <option value=""  >Select any value</option>
                  </select>
                  </div>
                 </div>


                 <div class="col-sm-6 grn">
                <div class="form-group row">
                  <label class="col-sm-4">Grn No.</label>
                  <select name="grn_no" form="ticket_form" id="grn_no" onchange="setGrn()" class="form-control col-sm-8" style="">
                    <option value=""  >Select any value</option>
                  </select>
                  </div>
                 </div>

<!-- 
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Grn No.</label>
                  <input type="text" form="ticket_form" name="grn_no" class="form-control  col-sm-8" value="" required style="width: 100%;">
                  </div>
                 </div> -->
                  
                  <div class="col-sm-6 grn">
                <div class="form-group row">
                  <label class="col-sm-4">Vendor</label>
                  <input type="text" form="ticket_form" name="vendor" id="vendor" class="form-control  col-sm-8" value="" readonly style="width: 100%;">
                  </div>
                 </div>


                  <div class="col-sm-6 grn">
                <div class="form-group row">
                  <label class="col-sm-4">Origin</label>
                  <input type="text" form="ticket_form" name="origin" id="origin" class="form-control  col-sm-8" value="" readonly style="width: 100%;">
                  </div>
                 </div>

                 
                   
                   
                 
                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" id="batch_no" class="form-control  col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 </div>


                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg. Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" id="mfg_date" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Exp. Date</label>
                  <input type="date" form="ticket_form" name="exp_date" id="exp_date" class="form-control  col-sm-8" value=""  readonly  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6 grn">
                <div class="form-group row">
                  <label class="col-sm-4">No. of container</label>
                  <input type="number" form="ticket_form" name="no_of_container" id="no_of_container" class="form-control  col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6 grn">
                <div class="form-group row">
                  <label class="col-sm-4">Type of Container</label>
                  <input type="text" form="ticket_form" name="type_of_container" id="type_of_container" class="form-control  col-sm-8" value=""  readonly  style="width: 100%;">
                  </div>
                 </div>

                 
                
                  <div class="col-sm-6 grn">
                <div class="form-group row">
                  <label class="col-sm-4">Total Qty</label>
                  <input type="number" form="ticket_form" name="total_qty" id="total_qty" class="form-control  col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Sample Qty</label>
                  <input type="number" step="any" form="ticket_form" name="sample_qty" class="form-control  col-sm-8" value="" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Unit</label>
                  <input type="text" form="ticket_form" name="uom" id="uom" class="form-control  col-sm-8" value="" readonly style="width: 100%;">
                  </div>
                 </div>

                 <!-- <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pack_size" class="form-control  col-sm-8" value="" readonly required style="width: 100%;">
                  </div>
                 </div> -->

                 <!-- <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Type</label>
                  <select name="type" form="ticket_form" id="type" class="form-control  col-sm-8" style="width: 100%;" required>
                    <option value="">Select any value</option>
                    <option value="new_arrival"  >New Arrival</option>
                    <option value="retest"  >Retest</option>
                    
                    
                  </select>
                  </div>
                 </div>
 -->
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
                  <textarea form="ticket_form" name="remarks" class="form-control  col-sm-10" style="width: 100%;"></textarea>
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
    
   $('.select2').select2(); 
   setAtt();

    function setDepartItems()
{ 
    
  var department_id= jQuery('#department_id').val();
  if(department_id=='')
  {
    return;
  }
     
   var departs=JSON.parse(  `<?php echo json_encode($departments); ?>`); 
   let point = departs.findIndex((item) => item.id == department_id);
  
      var items=departs[point]['items']; 
      
      $('#item_id').empty().append('<option value="" >Select any value</option>');

                  for (var k =0 ;k < items.length ; k ++ )
                   {                   

                  $('<option value="'+items[k]['id']+'">'+items[k]['item_name']+'</option>').appendTo("#item_id");
                    }

    
    
}

function setAtt()
{ 
    var type=$('#type').val();
    if(type=='item_base')
   {
    $('.plan').hide();
   $('.grn').show();
   }
   else if(type=='production_base')
   {
    $('.grn').hide();
   $('.plan').show();
   }

}

function setPlan()
{ 
    
  var department_id= jQuery('#department_id').val();
  var item_id= jQuery('#item_id').val();
  var plan_id= jQuery('#plan_batch_no').val();

  if(department_id=='' || item_id=='' || plan_id=='')
  {
    return;
  }
     
   var departs=JSON.parse( `<?php echo json_encode($departments); ?>`); 
   let point = departs.findIndex((item) => item.id == department_id);
      var items=departs[point]['items']; 
    let point1 = items.findIndex((item) => item.id == item_id);
        var plans=items[point1]['plans'];
    let point2 = plans.findIndex((item) => item.id == plan_id);
    var processes=plans[point2]['processes'];

      $('#plan_process').empty().append('<option value="" >Select any value</option>');

      for (var k =0 ;k < processes.length ; k ++ )
       {                   

      $('<option value="'+processes[k]+'">'+processes[k]+'</option>').appendTo("#plan_process");
        }
     
     jQuery('#batch_no').val(plans[point2]['batch_no']);
    jQuery('#mfg_date').val(plans[point2]['mfg_date']);
    jQuery('#exp_date').val(plans[point2]['exp_date']);
    
}

    function setItem()
{ 
   
   var item_id=$('#item_id').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/item/current/grn_no") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     item_id: item_id,
                  

               },
               success:function(data) {

                var grns = data;
                
                  $('#grn_no').empty().append('<option value="" >Select any value</option>');

      for (var k =0 ;k < grns.length ; k ++ )
       {                   

      $('<option value="'+grns[k]['grn_no']+'">'+grns[k]['grn_no']+'</option>').appendTo("#grn_no");
        }

               }
             });
    return ;


  var department_id= jQuery('#department_id').val();
  var item_id= jQuery('#item_id').val();

  if(department_id=='' || item_id=='')
  {
    return;
  }
     
   var departs=JSON.parse(`<?php echo json_encode($departments); ?>`); 
   let point = departs.findIndex((item) => item.id == department_id);
      var items=departs[point]['items']; 
    let point1 = items.findIndex((item) => item.id == item_id);
    var grns=items[point1]['grns'];

      $('#grn_no').empty().append('<option value="" >Select any value</option>');

      for (var k =0 ;k < grns.length ; k ++ )
       {                   

      $('<option value="'+grns[k]['grn_no']+'">'+grns[k]['grn_no']+'</option>').appendTo("#grn_no");
        }

        var plans=items[point1]['plans'];

      $('#plan_batch_no').empty().append('<option value="" >Select any value</option>');

      for (var k =0 ;k < plans.length ; k ++ )
       {                   

      $('<option value="'+plans[k]['id']+'">'+plans[k]['plan_no']+'</option>').appendTo("#plan_batch_no");
        }

       
    
    
}

function setGrn()
{ 

  var grn_no=$('#grn_no').val();

    $.ajax({
               type:'get',
               url:'{{ url("get/grn_no/") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     grn_no: grn_no,
                  

               },
               success:function(data) {

                var grn = data;
                //alert(JSON.stringify(grn));
                  
                  $('#total_qty').val(grn['closing_qty']);
       $('#batch_no').val(grn['batch_no']);
      $('#mfg_date').val(grn['mfg_date']);
      $('#exp_date').val(grn['exp_date']);
      $('#vendor').val(grn['vendor_name']);
      $('#origin').val(grn['origin']);
      $('#no_of_container').val(grn['no_of_container']);
      $('#type_of_container').val(grn['type_of_container']);
      $('#uom').val(grn['uom']);
      

               }
             });
    return ;
    
  var department_id= jQuery('#department_id').val();
  var item_id= jQuery('#item_id').val();
  var grn_no= jQuery('#grn_no').val();

  if(department_id=='' || item_id=='' || grn_no=='')
  {
    return;
  }
     
   var departs=JSON.parse(`<?php echo json_encode($departments); ?>`); 
   let point = departs.findIndex((item) => item.id == department_id);
      var items=departs[point]['items']; 
    let point1 = items.findIndex((item) => item.id == item_id);
    var grns=items[point1]['grns'];
    let point2 = grns.findIndex((item) => item.grn_no == grn_no);
      var grn=grns[point2];
          
       $('#total_qty').val(grn['qty']);
       $('#batch_no').val(grn['batch_no']);
      $('#mfg_date').val(grn['mfg_date']);
      $('#exp_date').val(grn['exp_date']);
      $('#vendor').val(grn['vendor']);
      $('#origin').val(grn['origin']);
      $('#no_of_container').val(grn['no_of_container']);
      $('#type_of_container').val(grn['type_of_container']);
      $('#uom').val(items[point1]['unit']);
    
    
}

  </script>





@endsection  
  