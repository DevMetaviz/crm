
@extends('layout.master')
@section('title', 'Capsule Filling')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('capsule-filling/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Capsule Filling</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <!-- <a class="btn" href="{{url('/transfer-note')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
            <a class="btn" href="{{url('/capsule-filling/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Capsule Filling</li>
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
                <h3 class="card-title">Capsule Filling</h3>
              
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
                  <input type="date" form="ticket_form" name="mfg" id="mfg" class="form-control  col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Exp Date</label>
                  <input type="date" form="ticket_form" name="exp" id="exp" class="form-control  col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Start Date & Time</label>
                  <input type="datetime-local"  form="ticket_form" name="grn_start" id="grn_start" class="form-control col-sm-8" value="" onchange="set_grn_total()"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Completed Date & Time</label>
                  <input type="datetime-local" form="ticket_form" name="grn_comp" id="grn_comp" class="form-control col-sm-8" value="" onchange="set_grn_total()" style="width: 100%;">
                  </div>
                 </div>
                 

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Total Time</label>
                  <input type="text" form="ticket_form" name="grn_total" id="grn_total" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Lead Time</label>
                  <input type="text" form="ticket_form" name="lead_time" id="lead_time" class="form-control  col-sm-8" value="" required   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Temprature(<sup>o</sup>C)</label>
                  <input type="text" form="ticket_form" name="temprature" id="temprature" class="form-control  col-sm-8" value="" required   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Humidity (%)</label>
                  <input type="text"  form="ticket_form" name="humidity" id="humidity" class="form-control  col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>

                 <div class="bg-info p-1 m-1 col-sm-12">
                        <h3>A: Weight Variation</h3>
                    </div>


                <table class="table table-bordered table-hover" style="width: 100%;"  id="" >
        <thead class="table-secondary">
           <tr>

             <th>Sr No</th>
             <th>Weight of Capsule</th> 
             <th>Sr No</th>
             <th>Weight of Capsule</th> 
             <th>Sr No</th>
             <th>Weight of Capsule</th> 
             <th>Sr No</th>
             <th>Weight of Capsule</th>             
             
           </tr>
        </thead>
        <tbody id="">

           @for($i=1;$i<=5;$i++)
           <tr>
             <td>{{$i}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  id="{{'weight_of_tablets_'.$i}}" class="form-control" value="" onchange="checkWeight()" style="width: 100%;"></td>
             <td>{{$i+5}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  class="form-control" id="{{'weight_of_tablets_'.$i+5}}" value="" onchange="checkWeight()" style="width: 100%;"></td>
             <td>{{$i+10}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  class="form-control" id="{{'weight_of_tablets_'.$i+10}}" value="" onchange="checkWeight()" style="width: 100%;"></td>
             <td>{{$i+15}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  class="form-control" id="{{'weight_of_tablets_'.$i+15}}" value="" onchange="checkWeight()" style="width: 100%;"></td>
           </tr>
          @endfor
           
          
        </tbody>
      </table>

               <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Recommended Weight:</label>
                  <input type="text" form="ticket_form" name="recommended_weight" id="recommended_weight" class="form-control  col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Lower Weight:</label>
                  <input type="text" form="ticket_form" name="lower_weight" id="lower_weight" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Upper Weight:</label>
                  <input type="text" form="ticket_form" name="upper_weight" id="upper_weight" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 


                  

                
                <!--  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea class="form-control col-sm-10" placeholder="Comment..." form="ticket_form" name="remarks"></textarea>
                  </div>
                 </div> -->


                

                 

                 
                 <!-- <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="activeness" value="1" id="activeness" class=""  checked>&nbsp&nbspActive</label>
                  </div>
                </div> -->
                 

                

               </div>
 

           <!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabE">Container Detail</a></li>
         <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabA">Yield Calculation</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">

     <div class="tab-pane fade show active" id="tabE">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Add</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Container No</label>
                  <input type="number"  form="add_item" name="no" id="no" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Gross Weight (kg)</label>
                  <input type="number" step="any" form="add_item" name="gross" id="gross" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Tare Weight (kg)</label>
                  <input type="number" step="any" form="add_item" name="tare" id="tare" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Net Weight (kg)</label>
                  <input type="number" step="any" form="add_item" name="net" id="net" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>


            <div class="col-md-2">
                    <div class="form-group">
                  <label>Performed By</label>
                  <input type="text"  form="add_item" name="performed_by" id="performed_by" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>


              

              
              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <input type="hidden" name="row_id" id="row_id" >
                  <button type="button" form="add_item" id="add_item_btn" class="btn" onclick="addItem()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> <!--end row-->



                 </fieldset>
              </div>
            </div>


     <div class="table-responsive">
      <table class="table table-bordered table-hover "  id="item_table" >
        <thead class="table-secondary">
           <tr>

             <th>Container #</th>
            
             <th>Gross Weight (kg)</th>
             <th>Tare Weight (kg)</th>
             <th>Net Weight (kg)</th>
             <th>Performed By</th>
             
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

         
        
           
          
        </tbody>
        <tfoot>
          <tr>
           
             <th></th>
             <th id="net_gross"></th>
             <th id="net_tare"></th>
             <th id="net_net"></th>
             <th></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

      
    </div> <!-- End TabE  -->
   
    <div class="tab-pane fade show active" id="tabA">
    </div><!-- End TabA  -->
   

   
</div>
<!-- End Tabs -->
      

                



              
                  
                  
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
var row_num=1;

function getRowNum()
 {
  return this.row_num;
}
function setRowNum()
 {
   this.row_num+=1;
}
  

  $(document).ready(function(){

$('.select2').select2(); 

$('#ticket_form').submit(function(e) {

     e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();

for (var i =1; i <= row_num ;  i++)
{
if ($(`#gross_${i}`). length > 0 )
     {
        $('#std_error_txt').html('');
               this.submit();
               return ;
      }
  }

             
               $('#std_error').show();
               $('#std_error_txt').html('Add weight detail!');



  });

});

  function checkWeight()
{    
  var low=0, up=0;

  for (var i = 1; i <= 20; i++) {

      var we=$(`#weight_of_tablets_${i}`).val();
      if(we=='')
         continue ;

      low=we; up=we; 
      break;
  }


  for (var i = 2; i <= 20; i++) {
      var we=$(`#weight_of_tablets_${i}`).val();
      if(we=='')
         continue ;
      if(parseFloat( we) < parseFloat(low))
        low=we;

      if(parseFloat(we) > parseFloat(up))
        up=we;
  }

      $(`#upper_weight`).val(up);
      $(`#lower_weight`).val(low);
}

  function set_grn_total()
{
   var t=$(`#grn_start`).val();
   var t1=$(`#grn_comp`).val();

   if(t=='' || t1=='')
        return ;
      //diff=t1 -  t;
        diff=get_timeDifference(t,t1);
        $(`#grn_total`).val(diff);
       //alert(diff);

}

function setSevTime()
{
   var t=$(`#sev_start`).val();
   var t1=$(`#sev_complete`).val();


   if(t=='' || t1=='')
        return ;
      //diff=t1 -  t;
        diff=get_timeDifference('2022-06-10T'+t,'2022-06-10T'+t1);
        $(`#sev_total`).val(diff);
       

}

function setMixTime()
{
   var t=$(`#mixing_start_time`).val();
   var t1=$(`#mixing_complete_time`).val();


   if(t=='' || t1=='')
        return ;
      //diff=t1 -  t;
        diff=get_timeDifference('2022-06-10T'+t,'2022-06-10T'+t1);
        $(`#mixing_total_time`).val(diff);
       

}


function setLoss()
{
   var qty=$(`#batch_qty`).val();
   var qty1=$(`#actual_qty`).val();
   var qty2=$(`#qa_sample`).val();
   var qty3=$(`#qc_sample`).val();

   if(qty=='' || qty==null)
        qty=0;

      if(qty1=='' || qty1==null)
        qty1=0;

      if(qty2=='' || qty2==null)
        qty2=0;

      if(qty3=='' || qty3==null)
        qty3=0;

      var t= parseFloat( qty3 )+parseFloat( qty2 ) + parseFloat( qty1 ); 
       var t1= ( parseFloat(t) / parseFloat( qty )) * 100 ; 
    
    $(`#yield`).val(t1); 
     var l= 100 - t1 ;
     $(`#loss`).val(l);
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
         $("#pro_pack_size").val(plan['pack_size']);

}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
   var  net_gross=0 , net_tare=0, net_net=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#gross_${i}`). length > 0 )
     { 
       
       var qty=$(`#gross_${i}`).val();
       var qty1=$(`#tare_${i}`).val();
       var qty2=$(`#net_${i}`).val();

      // if(qty=='' || qty==null)
      //   qty=0;
      
         net_gross +=  parseFloat (qty) ;
         net_tare +=  parseFloat (qty1) ;
         net_net +=  parseFloat (qty2) ;

        
      }
       

   }

    net_gross =  net_gross.toFixed(2) ;
    net_tare =  net_tare.toFixed(2) ;
    net_net =  net_net.toFixed(2) ;

   $(`#net_gross`).text(net_gross);
   $(`#net_tare`).text(net_tare);
   $(`#net_net`).text(net_net);

     
    setLoss();
}




function addItem()
{
  var no=$("#no").val();
  var gross=$("#gross").val();
  var tare=$("#tare").val();
  var net=$("#net").val();
  var performed_by=$("#performed_by").val();
   
  
       
     if(gross=='' || tare=='' || net=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(gross=='')
           {
                err_name='Gross Weight is required.';
           }

           if(tare=='')
           {
                err_dbl='Tare Weight is required.';
           }
           
           if(net=='')
           {
            err_qty='Net Weight is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     <input type="hidden" form="ticket_form" id="no_${row}" name="no[]" value="${no}" readonly >

     <input type="hidden" form="ticket_form" id="gross_${row}" name="gross[]" value="${gross}" readonly >
     
     <input type="hidden" form="ticket_form" id="tare_${row}" name="tare[]"  value="${tare}" >
     <input type="hidden" form="ticket_form" id="net_${row}" name="net[]"  value="${net}" >
     <input type="hidden" form="ticket_form" id="performed_by_${row}" name="performed_by[]"  value="${performed_by}" >
     
     
     <td id="no1_${row}">${no}</td>
   
  
       <td id="gross1_${row}">${gross}</td>
     <td id="tare1_${row}">${tare}</td>
     <td id="net1_${row}">${net}</td>
     <td id="performed_by1_${row}">${performed_by}</td>
    
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
    
     
   

    $("#selectedItems").append(txt);


  
  $("#no").val('');
  $("#gross").val('');
  $("#net").val('');
  $("#tare").val('');

 

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

  
          setNetQty();
           setRowNum();
   
   }
     
}//end add item

function updateItem(row)
{
  var no=$("#no").val();
  var gross=$("#gross").val();
  var tare=$("#tare").val();
  var net=$("#net").val();
  var performed_by=$("#performed_by").val();
   
  
       
     if(gross=='' || tare=='' || net=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(gross=='')
           {
                err_name='Gross Weight is required.';
           }

           if(tare=='')
           {
                err_dbl='Tare Weight is required.';
           }
           
           if(net=='')
           {
            err_qty='Net Weight is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_qty);

     }
          else
     {
     
    
       $(`#no_${row}`).val(no);
       $(`#gross_${row}`).val(gross);
        $(`#tare_${row}`).val(tare);
      $(`#net_${row}`).val(net);
      $(`#performed_by_${row}`).val(performed_by);

      $(`#no1_${row}`).text(no);
       $(`#gross1_${row}`).text(gross);
        $(`#tare1_${row}`).text(tare);
      $(`#net1_${row}`).text(net);
      $(`#performed_by1_${row}`).text(performed_by);


            
   $("#no").val('');
  $("#gross").val('');
  $("#net").val('');
  $("#tare").val('');
   $("#performed_by").val('');


   

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
  
   
   }
     
}  //end update item


function editItem(row)
{
   
  var no=$(`#no1_${row}`).text();
  $('#no').val(no);

  var unit=$(`#gross1_${row}`).text();
  $('#gross').val(unit);

  var qty=$(`#tare1_${row}`).text();
$('#tare').val(qty);

 var p_s=$(`#net1_${row}`).text();
$('#net').val(p_s);

 var total=$(`#performed_by1_${row}`).text();
$('#performed_by').val(total);



  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);
   
  
  

}

function removeItem(row)
{
  
    $(`#${row}`).remove();
    setNetQty();
  

}

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
  