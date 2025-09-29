
@extends('layout.master')
@section('title', 'Config Edit Product Procedure')
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
    <form role="form" id="product_process"  method="POST" action="{{url('update/configuration/product/procedure')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$procedure['id']}}" name="id"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Edit Product Procedure</h1>
            <button form="product_process" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('#')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('configuration/product/procedure/list')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Product</a></li>
              <li class="breadcrumb-item active">Edit Production Procedure</li>
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
                  <label class="col-sm-4">Procedure Name</label>
                  <input type="text" form="product_process" name="name" class="form-control select2 col-sm-8" value="{{$procedure['name']}}" required style="width: 100%;">
                  </div>
                </div>

                

                

                
                

                <div class="col-sm-12">
                  <div class="form-group row">
                  <div class="col-sm-8 offset-sm-4">
                  <label><input type="checkbox" form="product_process"  name="activeness" value="1" id="activeness" class=""  >&nbsp&nbspActive</label>
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

                   <textarea class="form-control select2" form="product_process" name="remarks">{{$procedure['remarks']}}</textarea>
                 </fieldset>
               </div>
            

            </div>
            <!-- /.row -->

            
<div class="row">
              <div class="col-md-8">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Define Stages/Process</legend>

              
    
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

               

                

              <div class="col-md-4">
                    <div class="form-group">
                  <label>Sort Order</label>
                  <input type="number" value="1" min="1" form="add_stage" name="process_sort_order" id="process_sort_order" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              
              <input type="hidden" name="row_id" id="row_id" >
              
                <div class="col-md-2">
                    <div class="form-group">
                  <label style="visibility: hidden;">QC</label>
                  <label><input type="checkbox" form="add_stage" value="false" name="qc_required" id="qc_required">&nbspQC Required</label>
                </div>
              </div>
              
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
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Stages</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
    <div class="tab-pane fade show active" id="tabA">

      


      <table class="table" id="stages_table">
        <thead>
           <tr>
             <th>No.</th>
             <th>Stages</th>
             <th>Sort Order</th>
             <th>QC Required</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedStages">
           <?php $rows=1; ?>

           
         
         

            @foreach($procedure['processes'] as $process )
            <?php 
                  $qc_required=$process['pivot']['qc_required'];
                  $checked='';
                  if($qc_required==1)
                    $checked='checked';
             ?>
          <tr ondblclick="(editStage('{{$rows}}'))" id="{{$rows}}">
            <td></td>
            <td><input type="text" form="product_process" id="{{'stage_text_'.$rows}}" name="stages_text[]" value="{{$process['identity']}}" readonly >
              <input type="hidden" form="product_process" id="{{'stage_id_'.$rows}}" name="stages_id[]" value="{{$process['id']}}" readonly ></td>
            <td><input type="text" form="product_process" id="{{'stage_sort_order_'.$rows}}" name="stages_sort_order[]" value="{{$process['pivot']['sort_order']}}" readonly ></td>
       <td><input type="checkbox" form="product_process" name="qcs_required[]" id="{{'qc_required_'.$rows}}" {{$checked}} ><input type="hidden" form="product_process" name="qcs[]" id="{{'qc_'.$rows}}" value="{{$qc_required}}"  ></td>
       <td><button type="button" class="btn" onclick="removeStage()"><span class="fa fa-minus-circle text-danger"></span></button></td></tr>
         <?php $rows++; ?>
       @endforeach
          
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

var row_num="{{$rows}}";

function getRowNum()
 {
  return this.row_num;
}
function setRowNum()
 {
   this.row_num+=1;
}



$(document).ready(function(){

  var active="{{$procedure['activeness']}}";
  if(active==1)
     $('#activeness').prop('checked',true);
   else if(active==0)
     $('#activeness').prop('checked',false);

  });



function add_stage()
{
  var sort_order=$("#process_sort_order").val();
  var stage_id=$("#stage_id").val();
  var stage_text=$("#stage_id option:selected").text();
  var qc_required=$("#qc_required").prop("checked");
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
     var txt=`<tr ondblclick="(editStage(${rows}))" id="${rows}"><td></td><td><input type="text" form="product_process" id="stage_text_${rows}" name="stages_text[]" value="${stage_text}" readonly ><input type="hidden" form="product_process" id="stage_id_${rows}" name="stages_id[]" value="${stage_id}" readonly ></td><td><input type="text" form="product_process" id="stage_sort_order_${rows}" name="stages_sort_order[]" value="${sort_order}" readonly ></td>
       <td><input type="checkbox" form="product_process" name="qcs_required[]" id="qc_required_${rows}"><input type="hidden" form="product_process" name="qcs[]" id="qc_${rows}"></td>
       <td><button type="button" class="btn" onclick="removeStage()"><span class="fa fa-minus-circle text-danger"></span></button></td></tr>`;

    $("#selectedStages").append(txt);
        
        $(`#qc_required_${rows}`).prop("checked", qc_required );
         
         if(qc_required==false)
         $(`#qc_${rows}`).val("0" );
       else
        $(`#qc_${rows}`).val("1" );
      
    $("#process_sort_order").val('1');
  $("#stage_id").val('');
 $(`#qc_required`).prop("checked" , false );

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

   $('#stage_id').val(id);
$("#process_sort_order").val(sort);

$(`#qc_required`).prop("checked" , qc_required );

$('#row_id').val(row);

  $('#add_stage_btn').attr('onclick', `updateStage(${row})`)

}

function updateStage(row)
{
     var sort_order=$("#process_sort_order").val();
  var stage_id=$("#stage_id").val();
  var stage_text=$("#stage_id option:selected").text();
  var qc_required=$("#qc_required").prop("checked");

     
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

          if(qc_required==false)
         $(`#qc_${row}`).val("0" );
       else
        $(`#qc_${row}`).val("1" );
          

            $("#process_sort_order").val('1');
               $("#stage_id").val('');
             $(`#qc_required`).prop("checked" , false );

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
