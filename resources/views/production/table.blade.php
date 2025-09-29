
@extends('layout.master')
@section('title', 'Create Table')
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
    <form role="form" id="production_process"  method="POST" action="{{url('save/configuration/table/')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 style="display: inline;">Process Table</h1>
            <button form="production_process" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('configuration/table/')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('configuration/table/list/')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Process</a></li>
              <li class="breadcrumb-item active">Table</li>
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
                  <label class="col-sm-4">Table Name</label>
                  <input type="text" form="production_process" name="name" class="form-control select2 col-sm-8"  style="width: 100%;">
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
                  <label class="col-sm-4">Process</label>
                  <select class="form-control select2 col-sm-8" form="production_process" name="process_id" id="process_id" required style="width: 100%;">
                    <option value="">------Select any process-----</option>
                    @foreach($processes as $pr)
                    <option value="{{$pr['id']}}">{{$pr['identity']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">No. of Rows</label>
                  <input type="number" form="production_process" name="no_of_rows" class="form-control select2 col-sm-8" min="1" value="1" required style="width: 100%;">
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
                  <label><input type="checkbox" form="production_process" name="activeness" value="1" id="activeness" class=""  checked>&nbsp&nbspActive</label>
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
                   <legend class="w-auto">Define Column/Header</legend>

              
    
    <div id="table_add_error" style="display: none;"><p class="text-danger" id="table_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    <div class="col-md-4">
                    <div class="form-group">
                  <label>Column Heading</label>
                  <input type="text"  form="add_stage" name="heading" id="heading" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-3">
                    <div class="form-group">
                  <label>Type</label>
                  <select class="form-control select2" form="add_stage" name="type" id="type" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                      
                    <option value="text">Text</option>
                    <option value="long_text">Long Text</option>
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                    <div class="form-group">
                  <label>Footer Type</label>
                  <select class="form-control select2" form="add_stage" name="footer_type" id="footer_type" style="width: 100%;">
                    <option value="text">Text</option>
                    <option value="sum">Sum</option>
                    <option value="blank" selected>blank</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                    <div class="form-group">
                  <label>Footer Text</label>
                  <input type="text"  form="add_stage" name="footer_text" id="footer_text" class="form-control select2" style="width: 100%;">
                </div>
              </div>

               

                

              <div class="col-md-3">
                    <div class="form-group">
                  <label>Sort Order</label>
                  <input type="number" value="1" min="1" form="add_stage" name="sort_order" id="sort_order" class="form-control select2" style="width: 100%;">
                </div>
              </div>

              
              <input type="hidden" name="row_id" id="row_id" >
              
                

              
              <div class="col-md-1">
                    <div class="form-group">
                  <br>
                  <button type="button" form="add_stage" id="add_stage_btn" class="btn" onclick="add_table()">
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
        
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Columns/Header</a></li>
        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Columns Footer</a></li> -->
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">

   <div class="tab-pane fade show active" id="tabA">

    


      <table class="table" id="columns_table">
        <thead>
           <tr>
             <th>No.</th>
             <th>Heading</th>
             <th>Type</th>
             <th>Footer Type</th>
             <th>Footer Text</th>
             <th>Sort Order</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="columns_body">
          
          
          
        </tbody>
      </table>
        
    </div> <!-- End TabA  -->
    
    <!--<div class="tab-pane fade" id="tabB">

           <fieldset class="border p-4">
                   <legend class="w-auto">Add Footer</legend>

              
    
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
                  <label>Column</label>
                  <select form="add_stage" name="colm" id="colm" class="form-control select2">
                    <option value="">Select any value</option>
                  
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



                 </fieldset> 
      


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
        
    </div>--> <!-- End TabA  -->

    
   
    
   

   
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

function add_table()
{
  var sort_order=$("#sort_order").val();
  var heading=$("#heading").val();
  var type=$("#type option:selected").val();
  var footer_text=$("#footer_text").val();
  var footer_type=$("#footer_type option:selected").val();
  
 
     
     if(heading=='' || type=='' || sort_order=='' )
     {
        var err_head='',err_sort='',err_type='';
           
           if(heading=='')
           {
                err_head='Heading is required.';
           }
           if(sort_order=='')
           {
            err_sort='Sort Order is required.';
           }

           if(type=='')
           {
            err_type='Type is required.';
           }
           


           $("#table_add_error").show();
           $("#table_add_error_txt").html(err_head+' '+err_sort+' '+err_type);

     }
     else
     {
      
      var rows = getRowNum();
       var err_exist='';
      if(rows>1)
      {
          for (var i =1; i < rows ;  i++) {
            if ($(`#heading_${i}`). length > 0 )
            {
            var id=$(`#heading_${i}`).val();

            if(id==heading)
            {  
              err_exist='Heading Already added!';
              $("#table_add_error").show();
           $("#table_add_error_txt").html(err_exist);
           break;
            }
          }
             
          }
      } 
      if(err_exist=='')
      {  //editTable(${rows})
     var txt=`<tr ondblclick="()" id="${rows}"><td></td><td><input type="text" form="production_process" id="heading_${rows}" name="headings[]" value="${heading}" readonly ></td><td><input type="text" form="production_process" id="type_${rows}" name="types[]" value="${type}" readonly ></td>
     <td><input type="text" form="production_process" id="footer_type_${rows}" name="footer_types[]" value="${footer_type}" readonly ></td><td><input type="text" form="production_process" id="footer_text_${rows}" name="footer_texts[]" value="${footer_text}" readonly ></td>
       <td><input type="text" form="production_process" name="sort_orders[]" id="sort_order_${rows}" value="${sort_order}" readonly></td>
       
       <td><button type="button" class="btn" onclick="removeTable(${rows})"><span class="fa fa-minus-circle text-danger"></span></button></td></tr>`;

    $("#columns_body").append(txt);
        
        
      
    $("#heading").val('');
  $("#type").val('');
  $("#sort_order").val('1');
   $("#footer_text").val('');
  $("#footer_type").val('blank');



  $("#table_add_error").hide();
           $("#table_add_error_txt").html('');

           setRowNum();

         }//inner else
   
   }//outer else
     
}// end function

function editTable(row)
{
   var sort=$(`#sort_order_${row}`).val();
   var type=$(`#type_${row}`).val();
   var heading=$(`#heading_${row}`).val();

   
$("#heading").val(heading);
   $('#sort_order').val(sort);
$("#type").val(type);



$('#row_id').val(row);

  $('#add_stage_btn').attr('onclick', `updateTable(${row})`)


}

function updateTable(row)
{
       var sort_order=$("#sort_order").val();
  var heading=$("#heading").val();
  var type=$("#type option:selected").val();



     if(heading=='' || type=='' || sort_order=='' )
     {
        var err_head='',err_sort='',err_type='';
           
           if(heading=='')
           {
                err_head='Heading is required.';
           }
           if(sort_order=='')
           {
            err_sort='Sort Order is required.';
           }

           if(type=='')
           {
            err_type='Type is required.';
           }
           


           $("#table_add_error").show();
           $("#table_add_error_txt").html(err_head+' '+err_sort+' '+err_type);

     }

  else
  {
      rows=getRowNum();
    var err_exist='';
          for (var i =1; i < rows ;  i++) {


            if(i==row)
              continue;

            for (var i =1; i < rows ;  i++) {
            if ($(`#heading_${i}`). length > 0 )
            {
            var id=$(`#heading_${i}`).val();

            if(id==heading)
            {  
              err_exist='Heading Already added!';
              $("#table_add_error").show();
           $("#table_add_error_txt").html(err_exist);
           break;
            }
          }
             
          }

            
                         
          }
       //end satge check
        if(err_exist=='')
      {
         $(`#heading_${row}`).val(heading);
         $(`#sort_order_${row}`).val(sort_order);
         $(`#type_${row}`).val(type);
          

     
           $("#heading").val('');
            $("#sort_order").val('1');
               $("#type").val('');
            $('#row_id').val('');
    
           $("#table_add_error").hide();
           $("#table_add_error_txt").html('');

           $('#add_stage_btn').attr('onclick', `add_table()`);

         }//end if err exist

  }//outer else


}//end update


function removeTable(row)
{
  $('#columns_body tr').click(function(){
     $(`#${row}`).remove();
});
}



</script>

@endsection  
