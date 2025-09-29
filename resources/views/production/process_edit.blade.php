
@extends('layout.master')
@section('title', 'Edit Production Process')
@section('header-css')
<style type="text/css">
  .alert-success {
     color: #155724; 
    background-color: #d4edda;
    /*border-color: #c3e6cb;*/
}

 
</style>


@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
    <form role="form" id="production_process" method="POST" action="{{url('update/configuration/production/process')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$process['id']}}" name="id"/>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Edit Production Process</h1>
            <button form="production_process" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('configuration/production/process')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('configuration/production/process/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Edit Process</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

<style type="text/css">
  .alert-inline{
              display: inline;
              color: #d32535;
              background-color:transparent ;
              border:none;padding: .7rem 4rem 0rem 0rem;
     }
</style>
    
      <div class="container-fluid" style="margin-top: 10px;">

            @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             
                       @if ($errors->has('msg'))
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>

                                          <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>
  
                                @endif
     

            <div class="row">
              <div class="col-md-5">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <div class="form-row">

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Process</label>
                  <input type="text" form="production_process" name="process" class="form-control select2 col-sm-8" value="{{$process['process_name']}}"   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Identity</label>
                  <input type="text" form="production_process" name="identity" class="form-control select2 col-sm-8" value="{{$process['identity']}}" required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Sort Order</label>
                  <input type="number" form="production_process" name="sort_order" class="form-control select2 col-sm-8" min="1" value="{{$process['sort_order']}}" required style="width: 100%;">
                  </div>
                </div>

                
                

                <div class="col-sm-12">
                  <div class="form-group row">
                  <div class="col-sm-8 offset-sm-4">
                  <label ><input type="checkbox" form="production_process" name="qc_required" value="1" id="qc_required" class=""  checked>&nbsp&nbspQC Required</label>&nbsp
                  <label><input type="checkbox" form="production_process" name="activeness" value="active" id="activeness" class=""  checked>&nbsp&nbspActive</label>
                  </div>
                  </div>
                </div>

                

                <!-- <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="purchase_demand" name="default" value="default" id="default" class=""  checked>&nbsp&nbspDefault</label>
                  </div>
                </div> -->


               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

                

               
                
              </div>
              <!-- /.col -->


               <div class="col-md-3">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Remarks</legend>

                   <textarea class="form-control select2" name="remarks">
                     {{$process['remarks']}}
                   </textarea>
                 </fieldset>
               </div>
            

            </div>
            <!-- /.row -->

           

            
            


<!-- Start Tabs -->
<div class="nav-tabs-wrapper">

    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Parameters</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Sub-Process</a></li>
    </ul>
    
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
    <div class="tab-pane fade show active" id="tabA">


      <table class="table" id="parameter_table">
        <thead>
           <tr>
             <th>No.</th>
             <th>Parameter</th>
             <th>Sort Order</th>
             <th>Active</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedParameters">
          
          <?php $rows=1; ?>
          @foreach($process['parameters'] as $pr)
          <tr ondblclick="(editParameter('{{$rows}}'))" id="{{$rows}}">
            <td></td>
          <td><input type="text" form="production_process" id="{{'parameter_text_'.$rows}}" name="parameters_text[]" value="{{$pr['name']}}" readonly ><input type="hidden" form="production_process" id="{{'parameter_id_'.$rows}}" name="parameters_id[]" value="{{$pr['id']}}" readonly ></td>
          <td><input type="text" form="production_process" id="{{'parameter_sort_order_'.$rows}}" name="parameter_sort_order[]" value="{{$pr['sort_order']}}" readonly ></td>
          <?php
                  $pr_active=''; 
                   if($pr['activeness']=='active')
                    $pr_active='checked';
                 ?>
          <td><input type="checkbox" name="" id="" {{$pr_active}}></td>
          <td><button type="button" class="btn" onclick="removeParameter()"><span class="fa fa-minus-circle text-danger"></span></button></td>
          </tr>
          <?php $rows++; ?>
          @endforeach
          
        </tbody>
      </table>
        
    </div> <!-- End TabA  -->

    <div class="tab-pane fade" id="tabB">

       <!-- define stage-->
              <div class="row">
              <div class="col-md-8">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Define Sub-Process</legend>

              
    
    <div id="stage_add_error" style="display: none;"><p class="text-danger" id="stage_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-4">
                    <div class="form-group">
                  <label>Process</label>
                  <select class="form-control select2" form="add_stage" name="stage_id" id="stage_id" style="width: 100%;">
                    <option value="">------Select any process-----</option>
                    @foreach($processes as $pr)
                    <option value="{{$pr['id']}}">{{$pr['identity']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

               

                

              <div class="col-md-3">
                    <div class="form-group">
                  <label>Sort Order</label>
                  <input type="number" value="1" min="1" form="add_stage" name="process_sort_order" id="process_sort_order" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              
              <input type="hidden" name="row_id" id="row_id" >
              
                <div class="col-md-2">
                    <div class="form-group">
                  <label style="visibility: hidden;">QC</label>
                  <label><input type="checkbox" form="add_stage" value="false" name="stage_qc_required" id="stage_qc_required">&nbspQC Required</label>
                </div>
              </div>

               <div class="col-md-2">
                    <div class="form-group">
                <label style="visibility: hidden;">Active</label><br>
                <label><input type="checkbox" form="add_stage" value="false" name="stage_active" id="stage_active" checked>&nbspActive</label>
                </div>
              </div>

              <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label style="visibility: hidden;">Active</label>
                  <label><input type="checkbox" form="add_stage" value="false" name="stage_active" id="stage_active">&nbspActive</label>
                </div>
              </div> -->
              
              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <button type="button" form="add_stage" id="add_stage_btn" class="btn" onclick="add_stage()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> <!--end row-->



                 </fieldset>
              </div>
            </div>
            <!--end stage-->

         <table class="table" id="stages_table">
        <thead>
           <tr>
             <th>No.</th>
             <th>Stages</th>
             <th>Sort Order</th>
             <th>QC Required</th>
             <th>Active</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedStages">
             <?php $stage_row_num=1; ?>
          @foreach($sub_processes as $stage)
                 <?php $rows=$stage_row_num; ?>
              <tr ondblclick="(editStage(<?php echo $rows ?>))" id="{{$rows}}">
                <td></td>
                <td><input type="text" form="production_process" id="{{'stage_text_'.$rows}}" name="stages_text[]" value="{{$stage['process_name']}}" readonly ><input type="hidden" form="production_process" id="{{'stage_id_'.$rows}}" name="stages_id[]" value="{{$stage['id']}}" readonly ></td>
                <td><input type="text" form="production_process" id="{{'stage_sort_order_'.$rows}}" name="stages_sort_order[]" value="{{$stage['pivot']['sort_order']}}" readonly ></td>
                <?php
                  $qc_required_check=''; 
                   if($stage['pivot']['qc_required']==1)
                    $qc_required_check='checked';
                 ?>
       <td><input type="checkbox" form="production_process" name="qcs_required[]" id="{{'qc_required_'.$rows}}" {{$qc_required_check}}><input type="hidden" form="production_process" name="satges_qc[]" value="{{$stage['pivot']['qc_required']}}" id="{{'qc_'.$rows}}"></td>
               <?php
                  $active_check=''; 
                   if($stage['pivot']['active']==1)
                    $active_check='checked';
                  
                 ?>
       <td><input type="checkbox" form="production_process" name="actives[]" id="{{'actives_'.$rows}}" {{$active_check}}><input type="hidden" form="production_process" name="stages_actives[]" id="{{'stages_actives_'.$rows}}" value="{{$stage['pivot']['active']}}"></td>
       <td><button type="button" class="btn" onclick="removeStage()"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
              <?php $stage_row_num+=1; ?>
          @endforeach
          
        </tbody>
      </table>

     </div> <!-- End TabB stages  -->
    
   

   
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_parameter">
              
            </form>
   
@endsection

@section('jquery-code')

<script type="text/javascript">

  $(document).ready(function(){

  var stage_row_num=<?php echo json_encode( $stage_row_num); ?>;
  
  active="{{$process['activeness'] }}";
  qc="{{$process['qc_required'] }}";
   
   
   if(active=="active")
   {
    
  $('#activeness').prop("checked", true);
   
   }
    else{
      $('#activeness').prop("checked", false);
  
    }

    if(qc=="1")
   {
    
  $('#qc_required').prop("checked", true);
   
   }
    else{
      $('#qc_required').prop("checked", false);
  
    } 

  });


function add_parameter()
{
  var sort_order=$("#parameter_sort_order").val();
  var parameter_id=$("#parameter").val();
  var parameter_text=$("#parameter option:selected").text();
  
     
     if(parameter_id=='' || sort_order=='' )
     {
        var err_parameter_id='',err_sort='';
           
           if(parameter_id=='')
           {
                err_parameter_id='Parameter is required.';
           }
           if(sort_order=='')
           {
            err_sort='Sort Order is required.';
           }
           


           $("#parameter_add_error").show();
           $("#parameter_add_error_txt").html(err_parameter_id+' '+err_sort);

     }
     else
     {
      
      var rows = $("#parameter_table tr").length;
       var err_exist='';
      if(rows>1)
      {
          for (var i =1; i < rows ;  i++) {
            var id=$(`#parameter_id_${i}`).val();

            if(id==parameter_id)
            {  
              err_exist='Parameter Already added!';
              $("#parameter_add_error").show();
           $("#parameter_add_error_txt").html(err_exist);
           break;
            }
             
          }
      } 
      if(err_exist=='')
      {
     var txt=`<tr ondblclick="(editParameter(${rows}))" id="${rows}"><td></td><td><input type="text" form="production_process" id="parameter_text_${rows}" name="parameters_text[]" value="${parameter_text}" readonly ><input type="hidden" form="production_process" id="parameter_id_${rows}" name="parameters_id[]" value="${parameter_id}" readonly ></td><td><input type="text" form="production_process" id="parameter_sort_order_${rows}" name="parameter_sort_order[]" value="${sort_order}" readonly ></td><td><button type="button" class="btn" onclick="removeParameter()"><span class="fa fa-minus-circle text-danger"></span></button></td></tr>`;

    $("#selectedParameters").append(txt);

      
    $("#parameter_sort_order").val('1');
  $("#parameter").val('');
 

  $("#parameter_add_error").hide();
           $("#parameter_add_error_txt").html('');

         }//inner else
   
   }//outer else
     
}// end function

function editParameter(row)
{
   var sort=$(`#parameter_sort_order_${row}`).val();
   var id=$(`#parameter_id_${row}`).val();

   $('#parameter').val(id);
$("#parameter_sort_order").val(sort);

$('#row_id').val(row);

  $('#add_parameter_btn').attr('onclick', `updateParameter(${row})`)

}

function updateParameter(row)
{
     var sort_order=$("#parameter_sort_order").val();
  var parameter_id=$("#parameter").val();
  var parameter_text=$("#parameter option:selected").text();

  if(false)
  {

  }
  else
  {
         $(`#parameter_text_${row}`).val(parameter_text);
         $(`#parameter_id_${row}`).val(parameter_id);
         $(`#parameter_sort_order_${row}`).val(sort_order);

          $("#parameter_sort_order").val('1');
           $("#parameter").val('');
 

           $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

           $('#add_parameter_btn').attr('onclick', `add_parameter()`);
  }


}//end update


function removeParameter()
{
  
  $('#parameter_table tr').click(function(){
    $(this).remove();
  
});

}



function getStageRowNum()
 {
  return this.stage_row_num;
}
function setStageRowNum()
 {
   this.stage_row_num+=1;
}

function add_stage()
{
  var sort_order=$("#process_sort_order").val();
  var stage_id=$("#stage_id").val();
  var stage_text=$("#stage_id option:selected").text();
  var qc_required=$("#stage_qc_required").prop("checked");
  var active=$("#stage_active").prop("checked");
  //alert(qc_required);
     
     if(stage_id=='' || sort_order=='' )
     {
        var err_stage_id='',err_sort='';
           
           if(stage_id=='')
           {
                err_stage_id='Stage is required.';
           }
           if(sort_order=='')
           {
            err_sort='Sort Order is required.';
           }
           


           $("#stage_add_error").show();
           $("#stage_add_error_txt").html(err_stage_id+' '+err_sort);

     }
     else
     {
      
      var rows = getStageRowNum();
       var err_exist='';
      if(rows>1)
      {
          for (var i =1; i < rows ;  i++) {
            if ($(`#stage_id_${i}`). length > 0 )
            {
            var id=$(`#stage_id_${i}`).val();

            if(id==stage_id)
            {  
              err_exist='Stage Already added!';
              $("#stage_add_error").show();
           $("#stage_add_error_txt").html(err_exist);
           break;
            }
          }
             
          }
      } 
      if(err_exist=='')
      {
     var txt=`<tr ondblclick="(editStage(${rows}))" id="${rows}"><td></td><td><input type="text" form="production_process" id="stage_text_${rows}" name="stages_text[]" value="${stage_text}" readonly ><input type="hidden" form="production_process" id="stage_id_${rows}" name="stages_id[]" value="${stage_id}" readonly ></td><td><input type="text" form="production_process" id="stage_sort_order_${rows}" name="stages_sort_order[]" value="${sort_order}" readonly ></td>
       <td><input type="checkbox" form="production_process" name="qcs_required[]" id="qc_required_${rows}"><input type="hidden" form="production_process" name="satges_qc[]" id="qc_${rows}"></td>
       <td><input type="checkbox" form="production_process" name="actives[]" id="actives_${rows}"><input type="hidden" form="production_process" name="stages_actives[]" id="stages_actives_${rows}"></td>
       <td><button type="button" class="btn" onclick="removeStage()"><span class="fa fa-minus-circle text-danger"></span></button></td></tr>`;

    $("#selectedStages").append(txt);
        
        $(`#qc_required_${rows}`).prop("checked", qc_required );
        $(`#actives_${rows}`).prop("checked", active );
         
         if(qc_required==false)
         $(`#qc_${rows}`).val("0" );
       else
        $(`#qc_${rows}`).val("1" );

      if(active==false)
         $(`#stages_actives_${rows}`).val("0" );
       else
        $(`#stages_actives_${rows}`).val("1" );
      
    $("#process_sort_order").val('1');
  $("#stage_id").val('');

 $(`#stage_qc_required`).prop("checked" , false );
 $(`#stage_active`).prop("checked" , false );

  $("#stage_add_error").hide();
           $("#stage_add_error_txt").html('');

           setStageRowNum();

         }//inner else
   
   }//outer else
     
}// end function

function editStage(row)
{
   var sort=$(`#stage_sort_order_${row}`).val();
   var id=$(`#stage_id_${row}`).val();

   var qc_required=$(`#qc_required_${row}`).prop("checked"  );
   var active=$(`#actives_${row}`).prop("checked"  );

   $('#stage_id').val(id);
$("#process_sort_order").val(sort);

$(`#stage_qc_required`).prop("checked" , qc_required );
$(`#stage_active`).prop("checked" , active );

$('#row_id').val(row);

  $('#add_stage_btn').attr('onclick', `updateStage(${row})`)

}

function updateStage(row)
{
     var sort_order=$("#process_sort_order").val();
  var stage_id=$("#stage_id").val();
  var stage_text=$("#stage_id option:selected").text();

   var qc_required=$("#stage_qc_required").prop("checked");
  var active=$("#stage_active").prop("checked");
     
     if(stage_id=='' || sort_order=='' )
     {
        var err_stage_id='',err_sort='';
           
           if(stage_id=='')
           {
                err_stage_id='Stage is required.';
           }
           if(sort_order=='')
           {
            err_sort='Sort Order is required.';
           }
           


           $("#stage_add_error").show();
           $("#stage_add_error_txt").html(err_stage_id+' '+err_sort);

     }
  else
  {
      rows=getStageRowNum();
    var err_exist='';
          for (var i =1; i < rows ;  i++) {
            if(i==row)
              continue;
            if ($(`#stage_id_${i}`). length > 0 )
            {
            var id=$(`#stage_id_${i}`).val();

            if(id==stage_id)
            {  
              err_exist='Stage Already added!';
              $("#stage_add_error").show();
           $("#stage_add_error_txt").html(err_exist);
           break;
            }
          }
             
          }
       //end satge check
        if(err_exist=='')
      {
         $(`#stage_text_${row}`).val(stage_text);
         $(`#stage_id_${row}`).val(stage_id);
         $(`#stage_sort_order_${row}`).val(sort_order);
          $(`#qc_required_${row}`).prop("checked", qc_required );
          $(`#actives_${row}`).prop("checked", active );

          if(qc_required==false)
         $(`#qc_${row}`).val("0" );
       else
        $(`#qc_${row}`).val("1" );

       if(active==false)
         $(`#stages_actives_${row}`).val("0" );
       else
        $(`#stages_actives_${row}`).val("1" );
          

            $("#process_sort_order").val('1');
               $("#stage_id").val('');
            
             $(`#stage_qc_required`).prop("checked" , false );
              $(`#stage_active`).prop("checked" , false );

           $("#stage_add_error").hide();
           $("#stage_add_error_txt").html('');

           $('#add_stage_btn').attr('onclick', `add_stage()`);

         }//end if err exist

  }//outer else


}//end update


function removeStage()
{
  
  $('#stages_table tr').click(function(){
    $(this).remove();
  
});

}



</script>

@endsection  
