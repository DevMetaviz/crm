
@extends('layout.master')
@section('title', 'Dispensing')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('dispensing/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Dispensing</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <!-- <a class="btn" href="{{url('/transfer-note')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
            <a class="btn" href="{{url('/dispensing/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Dispensing</li>
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
                <h3 class="card-title">Dispensing</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                 <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                  

                
                

                <div class="row col-md-12 form-row">

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No</label>
                  <select class="form-control col-sm-8 select2" onchange="setPlanAtt()" form="ticket_form" name="plan_id" id="plan_id" required >
                    <option value="">------Select any value-----</option>
                    @foreach($plans as $plan)
                    <option value="{{$plan['id']}}">{{$plan['plan_no']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                  
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <input type="text" form="ticket_form" name="product_id" id="product_id" class="form-control col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 </div>
                 
                
                   <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" id="batch_no" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pro_pack_size" id="pro_pack_size" class="form-control  col-sm-8" value="" readonly  required style="width: 100%;">
                  </div>
                 </div>

                 

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="text" form="ticket_form" name="batch_size" id="batch_size" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" id="mfg_date" class="form-control  col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Exp Date</label>
                  <input type="date" form="ticket_form" name="exp_date" id="exp_date" class="form-control  col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Start Date & Time</label>
                  <input type="datetime-local"  form="ticket_form" name="dispense_start" id="dispense_start" class="form-control col-sm-8" required value="" onchange="set_total_time()"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Completed Date & Time</label>
                  <input type="datetime-local" form="ticket_form" name="dispense_comp" id="dispense_comp" class="form-control col-sm-8" value="" onchange="set_total_time()" required style="width: 100%;">
                  </div>
                 </div>
                 

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Total Time</label>
                  <input type="text" form="ticket_form" name="dispense_total" id="dispense_total" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Temprature(<sup>o</sup>C)</label>
                  <input type="number" step="any" form="ticket_form" name="temprature" id="temprature" class="form-control  col-sm-8" value=""  required   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Humidity (%)</label>
                  <input type="number" step="any"  form="ticket_form" name="humidity" id="humidity" class="form-control  col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>

                 

                <table class="table table-bordered table-hover mt-4" style="">
                  <thead>
                 <tr>
                    <th>Sr #</th>
                    <th>Material Name</th>
                    <th>Assay Adjustment (If Any)</th>
                    <th>Quantity (kg/L)</th>
                    <th>Actual Qty (kg/L)</th>
                    <th>GRN #</th>
                    <th>QC #</th>
                  </tr>
                  </thead>
                  <tbody id="items_body">


                  </tbody>
                </table>
                 
                 

                

               </div>
 

          

                



              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>

<script type="text/javascript">


  $(document).ready(function(){

$('.select2').select2(); 



});

  function set_total_time()
{
   var t=$(`#dispense_start`).val();
   var t1=$(`#dispense_comp`).val();

   if(t=='' || t1=='')
        return ;
      //diff=t1 -  t;
        diff=get_timeDifference(t,t1);
        $(`#dispense_total`).val(diff);
       //alert(diff);

}




function setPlanAtt()
{
   var id=$("#plan_id").val();
     if(id=='')
      return ;

   var plans=<?php echo json_encode($plans); ?> ;
                 
                 let point = plans.findIndex((item) => item.id == id);
              var plan=plans[point];

         
         $("#product_id").val(plan['product_name']);
        $("#batch_size").val(plan['batch_size']);
        $("#batch_qty").val(plan['batch_qty']);
         $("#batch_no").val(plan['batch_no']);
          $("#mfg_date").val(plan['mfg_date']);
           $("#exp_date").val(plan['exp_date']);
         $("#pro_pack_size").val(plan['pack_size']);

    var items=plan['items'];  

    $("#items_body").html('');

for (var i =0; i < items.length ; i ++) {


      txt=`
     <tr>
     
     <td>${i+1}</td>
       <td>${items[i]['item_name']}</td>
        <td></td>
     <td>${items[i]['req_qty']}</td>
     <td>${items[i]['iss_qty']}</td>
     <td>${items[i]['grn']}</td>
    <td>${items[i]['qc']}</td>
     

     </tr>`;
    
    $("#items_body").append(txt);  
         
   }       
         //addItem(items);

}


function addItem(items)
{
     
        
  $("#items_body").html('');

for (var i =0; i < items.length ; i ++) {


     var txt=`
     <tr>
     
     <td>${i+1}</td>
       <td>${items[i]['item_name']}</td>
        <td></td>
     <td>${items[i]['req_qty']}</td>
     <td>${items[i]['iss_qty']}</td>
     <td>${items[i]['grn']}</td>
    <td>${items[i]['qc']}</td>
     

     </tr>`;
    
    $("#items_body").append(txt);  
         
   }
          
   
   

     
}//end add item







 function get_timeDifference(strtdatetime,enddatetime) {
    var datetime = new Date(strtdatetime).getTime();

    var now = new Date(enddatetime).getTime();
    //var now = new Date().getTime();

    if (isNaN(datetime)) {
        return "";
    }

    //console.log(datetime + " " + now);

    if (datetime < now) {
        var milisec_diff = now - datetime;
    } else {
        var milisec_diff = datetime - now;
    }

    var days = Math.floor(milisec_diff / 1000 / 60 / (60 * 24));

    var date_diff = new Date(milisec_diff);





    var msec = milisec_diff;
    var hh = Math.floor(msec / 1000 / 60 / 60);
    msec -= hh * 1000 * 60 * 60;
    var mm = Math.floor(msec / 1000 / 60);
    msec -= mm * 1000 * 60;
    var ss = Math.floor(msec / 1000);
    msec -= ss * 1000


    var daylabel = "";
    if (days > 0) {
        var grammar = " ";
        if (days > 1) grammar = "s " 
        var hrreset = days * 24;
        hh = hh - hrreset;
        daylabel = days + " Day" + grammar ;
    }


    //  Format Hours
    var hourtext = '00';
    hourtext = String(hh);
    if (hourtext.length == 1) { hourtext = '0' + hourtext };
     
     if(hourtext=='00')
      hourtext='';
    else
      hourtext=hourtext + " hours ";

    //  Format Minutes
    var mintext = '00';
    mintext = String(mm); 
    if (mintext.length == 1) { mintext = '0' + mintext };

    //  Format Seconds
    var sectext = '00';
    sectext = String(ss); 
    if (sectext.length == 1) { sectext = '0' + sectext };

    var msectext = '00';
    msectext = String(msec);
    msectext = msectext.substring(0, 1);
    if (msectext.length == 1) { msectext = '0' + msectext };

     return daylabel + hourtext  + mintext + " min " ;
    //return daylabel + hourtext + ":" + mintext + ":" + sectext + ":" + msectext;
}
  
</script>





@endsection  
  