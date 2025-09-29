
@extends('layout.master')
@section('title', 'Gate Pass')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">

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
    <form role="form" id="purchase_demand" method="POST" action="{{url('/gate-pass/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Gate Pass</h1>
            <button form="purchase_demand" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
          
            <a class="btn" href="{{url('/gate-pass/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Gate Pass</li>
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

             
                        @if ($errors->has('error'))
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                                          </div>  
                                @endif
     
      <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>


            <div class="row">
              <div class="col-md-3">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Document</legend>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Gate Pass No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" id="doc_no" class="form-control" value="{{$doc_no}}" readonly required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Type</label>
                  <select form="purchase_demand" name="type" id="type" onchange="setDocNo()" class="form-control">
                    <option value="outward">Outward Gate Pass</option>
                     <option value="inward">Inward Gate Pass</option>
                  </select>
                  </div>



                <div class="form-group">
                  <label>Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <input type="radio" form="purchase_demand" name="returnable" value="1" id="returnable" class="" checked>
                  <label>Returnable</label>
                  <input type="radio" form="purchase_demand" name="returnable" value="0" id="non_returnable" class="">
                  <label>Non Returnable</label>

                  </div>

                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="active" value="1" id="active" class=""  checked>
                  <label>Active</label>
                  </div>



              </fieldset>

                                
                <!-- /.form-group -->
               
                
              </div>
              <!-- /.col -->
              <div class="col-md-5">

                 <fieldset class="border p-4">
                   <legend class="w-auto">Detail</legend>

                  

                    <div class="form-group">
                  <label>Name</label>
                  <input type="text" form="purchase_demand" name="name" class="form-control select2" value="" required style="width: 100%;">
                  </div>
                   
                  <div class="form-group">
                  <label>Vehicle #</label>
                  <input type="text" form="purchase_demand" name="vehicle" class="form-control" value="" style="width: 100%;">
                  </div>
                    
                    <div class="row">
                    <div class="form-group col-md-6">
                  <label>Time Out</label>
                  <input type="time" form="purchase_demand" name="time_out" class="form-control" value="" style="width: 100%;">
                  </div>

                  <div class="form-group col-md-6">
                  <label>Time In</label>
                  <input type="time" form="purchase_demand" name="time_in" class="form-control" value="" style="width: 100%;">
                  </div>
                   </div>

                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control" ></textarea>
                </div>

                


                     
                        </fieldset>

                      
             

              </div>
              <!-- /.col -->

                            <!-- /.col -->

            </div>
            <!-- /.row -->

            

            <div class="row">
              <div class="col-md-12">
                
                <fieldset class="border p-4">
                   <legend class="w-auto">Add Item</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                  
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Item</label>
                  <input type="text"   form="add_item" name="item" id="item"  class="form-control"  style="width: 100%;">
                </div>
              </div>

                 
              <div class="col-md-1">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty" class="form-control" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Unit</label>
                  <input type="text"   form="add_item" name="unit" id="unit"  class="form-control"  style="width: 100%;">
                </div>
              </div>


              <div class="col-md-4">
                    <div class="form-group">
                  <label>Remarks</label>
                  <input type="text"  form="add_item" name="rmrk" id="rmrk"  class="form-control select2"  style="width: 100%;">
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



<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Items</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">
    
    <div class="tab-pane fade show active" id="tabA">

      
      <div class="table-responsive p-0" style="height: 400px;">
      <table class="table table-bordered table-hover table-head-fixed text-nowrap"  id="item_table" >
        <thead class="table-secondary">
           <tr>
             <th>Sr No</th>
             <th>Item</th>
            
             <th>Qty</th>
             <th>Unit</th>
             <th>Remarks</th>

             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

          
          
        </tbody>
        <tfoot>
          <tr>

             <th></th>
             <th></th>
             <th></th>
             <th></th>
              <th></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

        
    </div>
   
    
   

   
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_item">
              
            </form>
   
@endsection

@section('jquery-code')


<script type="text/javascript">

var row_num=1;


$(document).ready(function(){


  $("#item_table").colResizable({
     resizeMode:'overflow'
   });

  


  $('#purchase_demand').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var rows=getRowNum();

for (var i =1; i <= rows ;  i++) {
if ($(`#item_${i}`). length > 0 )
     {
        $('#std_error_txt').html('');
               this.submit();

               return ;
      }
  }
             
             
               $('#std_error').show();
               $('#std_error_txt').html('Select items!');
             
  });

  



   
});

 function getRowNum() 
 {
  return this.row_num;
}

function setRowNum() 
 {
   this.row_num+=1;
}

  






 

function addItem()
{
    
 
  var item=$("#item").val();
  var qty=$("#qty").val();
  var rmrk=$("#rmrk").val();
  var unit=$("#unit").val();


     if(item=='' ||  qty=='' )
     {
        var err_name='',err_qty='';
           
           if(item=='')
           {
                err_name='Item is required.';
           }
           
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }

           


           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_qty);

     }
     else
     {
      
        
     var row=this.row_num;   


     var txt=`
     <tr id="${row}">
      <th ondblclick="editItem(${row})"></th>
     
    
     

     <td ondblclick="editItem(${row})"><input type="text" value="${item}" form="purchase_demand" name="items[]" id="item_${row}" required="true"></td>

     <td ondblclick="editItem(${row})"><input type="number" value="${qty}" min="1" form="purchase_demand" name="qtys[]" id="qty_${row}" required="true"></td>
      
      <td ondblclick="editItem(${row})"><input type="text" value="${unit}" form="purchase_demand" name="units[]" id="unit_${row}" ></td> 

     <td ondblclick="editItem(${row})"><input type="text" value="${rmrk}" form="purchase_demand" name="rmrks[]" id="rmrk_${row}" ></td>     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
     
     
   

    $("#selectedItems").append(txt);


  $("#item").val('');
  $("#qty").val('1');
  $("#unit").val('');
  $("#rmrk").val('');
  

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

       
   }
     
}//end add item

function updateItem(row)
{
  
  var item=$("#item").val();
  var qty=$("#qty").val();
  var rmrk=$("#rmrk").val();

var unit=$("#unit").val();
  
     
     if(item==''  || qty=='' )
     {
        var err_name='',err_qty='';
           
           if(item=='')
           {
                err_name='Item is required.';
           }
           
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }

            

           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_qty);

     }
     else
     {
     
      
       $(`#item_${row}`).val(item);
        $(`#qty_${row}`).val(qty);
        $(`#unit_${row}`).val(unit);
        $(`#rmrk_${row}`).val(rmrk);

  

  $("#item").val('');
  $("#qty").val('1');
  $("#rmrk").val('');
  $("#rmrk").val('');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');


  
  $('#add_item_btn').attr('onclick', `addItem()`);
   
   }
     
}  //end update item


function editItem(row)
{
   
  
   var item=$(`#item_${row}`).val();
   $('#item').val(item);


  var qty=$(`#qty_${row}`).val();
$('#qty').val(qty);

var unit=$(`#unit_${row}`).val();
$('#unit').val(unit);


  var rmrk=$(`#rmrk_${row}`).val();
  $('#rmrk').val(rmrk);
  

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);


}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
    $(`#${row}`).remove();
    
});

}

function setDocNo()
  {
    
   
    var type=$("#type option:selected").val();

    

    $.ajax({
               type:'get',
               url:'{{ url("/get/gatepass/docno") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     type: type ,
                                   },
               success:function(data) {

                var doc_no=data;

                 $('#doc_no').val(doc_no);
               

               }
             });

  }




</script>

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script src="{{asset('public/own/table-resize/colResizable-1.6.js')}}"></script>

@endsection  
  