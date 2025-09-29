
@extends('layout.master')
@section('title', 'New Production Process')
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
    <form role="form" id="production_process"  method="POST" action="{{url('save/configuration/production/process')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Production Process</h1>
            <button form="production_process" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('configuration/production/process')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('configuration/production/process/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Production Process</li>
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
                  <input type="text" form="production_process" name="process" class="form-control select2 col-sm-8"  style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Identity</label>
                  <input type="text" form="production_process" name="identity" class="form-control select2 col-sm-8" required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Sort Order</label>
                  <input type="number" form="production_process" name="sort_order" class="form-control select2 col-sm-8" min="1" value="1" required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <div class="col-sm-8 offset-sm-4">
                  <label ><input type="checkbox" form="production_process" name="qc_required" value="1" id="qc_required" class=""  >&nbsp&nbspQC Required</label>&nbsp
                  <label><input type="checkbox" form="production_process" name="activeness" value="active" id="activeness" class=""  checked>&nbsp&nbspActive</label>
                  </div>
                  </div>
                </div>
                



               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

                

               
                
              </div>
              <!-- /.col -->


               <div class="col-md-3">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Remarks</legend>

                   <textarea class="form-control select2" form="production_process" name="remarks"></textarea>
                 </fieldset>
               </div>
            

            </div>
            <!-- /.row -->

            
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
                    <option value="{{$pr['id']}}">{{$pr['process_name']}}</option>
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

    <!-- <fieldset class="border p-4">
                   <legend class="w-auto">Add/Edit Parameter</legend>

              
    
    <div id="parameter_add_error" style="display: none;"><p class="text-danger" id="parameter_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-3">
                    <div class="form-group">
                  <label>Parameter</label>
                  <input type="text" value="" form="add_stage" name="parameter_name" id="parameter_name" class="form-control select2" style="width: 100%;">
                   </div>
                  </div>

               <div class="col-md-3">
                    <div class="form-group">
                  <label>Identity</label>
                  <input type="text" value="" form="add_stage" name="parameter_id" id="parameter_id" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Type</label>
                  <select form="add_stage" name="parameter_type" id="parameter_type" class="form-control select2">
                    <option value="text">Text</option>
                    <option value="integer">Integer</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                  </select>
                </div>
              </div>

                

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Sort Order</label>
                  <input type="number" value="1" min="1" form="add_stage" name="parameter_sort_order" id="parameter_sort_order" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              
              <input type="hidden" name="parameter_row_id" id="parameter_row_id" >
              
                
               <div class="col-md-2">
                    <div class="form-group">
                <br>
                <label><input type="checkbox" form="add_stage" value="1" name="parameter_active" id="parameter_active" checked>&nbspActive</label>
                </div>
              </div>

              
              
              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <button type="button" form="add_stage" id="add_parameter_btn" class="btn" onclick="add_parameter()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>

              


</div> 



                 </fieldset> -->


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
          
          
          
        </tbody>
      </table>
        
    </div> <!-- End TabA  -->
    
    <div class="tab-pane fade" id="tabB">

      


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

          
          
        </tbody>
      </table>
        
    </div> <!-- End TabA  -->

    
   
    
   

   
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_stage">
              
            </form>
   
@endsection

@section('jquery-code')

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
      
      var rows = getRowNum();
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

           setRowNum();

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
      rows=getRowNum();
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
