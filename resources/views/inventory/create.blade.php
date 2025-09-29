
@extends('layout.master')
@section('title', 'Add New Item')
@section('header-css')

@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
  

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Item Definition</h1>
            <button type="submit" form="inventory_form"  style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('inventory')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>List</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Inventory</a></li>
              <li class="breadcrumb-item active">Add New Item</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

  <form role="form" method="POST" action="{{url('save-inventory')}}" id="inventory_form" >
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
    
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
     

            <div class="row">
              <div class="col-md-3">

                <!-- /.form-group -->
               {{--- <!---<div class="form-group">
                  <label>Department<span class="text-danger">*</span></label>
                  <select class="form-control" onchange="setItemCode()" name="department" id="department" required style="width: 100%;">
                    <option value="">------Select any department-----</option>
                    @foreach($config['departments'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                  </select>
                  </div>-->--}}


                  <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category" id="category" onchange="setItemCode()" style="width: 100%;" required>
                    <option value="">------Select any value-----</option>
                    @foreach($config['categories'] as $raw)
                    <option value="{{$raw['id']}}" data-name="{{$raw['name']}}" >{{$raw['code'].' - '.$raw['name']}}</option>
                    @endforeach
                  </select>
                </div>
 

                  <div class="form-group">
                  <label>Sub Category</label>
                  <select class="form-control" name="type" id="type" onchange="setItemCode()" style="width: 100%;" required>
                    <option value="">------Select any type-----</option>
                    @foreach($config['types'] as $raw)
                    <option value="{{$raw['id']}}" data-name="{{$raw['name']}}" >{{$raw['code'].' - '.$raw['name']}}</option>
                    @endforeach
                  </select>
                </div>


             <div class="form-group">
                  <label>Gage</label>
                  <select name="gage_id" id="gage_id" class="form-control" >
                    
                    <option value=""  >------Select any value-----</option>
                    @foreach($config['gages'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                    
                  </select>
                </div>


                {{----<!--<div class="form-group">
                  <label>Shape</label>
                  <select name="shape_id" id="shape_id" class="form-control" >
                    
                    <option value=""  >------Select any value-----</option>
                    @foreach($config['shapes'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                    
                  </select>
                </div>


                <div class="form-group">
                  <label>Size</label>
                  <select name="size_id" id="size_id" class="form-control" >
                    
                    <option value=""  >------Select any value-----</option>
                    @foreach($config['sizes'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                    
                  </select>
                </div>--> ---}}

                

                <div class="form-group">
                  <label>Item Code<span class="text-danger">*</span></label>
                  <input type="text" name="item_code" id="item_code" class="form-control" value="{{old('item_code')}}" readonly required style="width: 100%;">
                 
                </div>

                <div class="form-group">
                  <label>Item Name<span class="text-danger">*</span></label>
                  <input type="text" name="item_name" id="item_name" class="form-control" value="{{old('item_name')}}" required style="width: 100%;" readonly>
                  </div>

            {{----      <!---<div class="form-group row">
                  <label class="col-md-12">Pack Size<span class="text-danger">*</span></label>
                  <input type="number" step="any" name="pack_size_qty" class="form-control" value="{{old('pack_size_qty')}}" placeholder="14"  style="width: 40%">
                  <input type="text" name="pack_size" class="form-control" value="{{old('pack_size')}}" placeholder="e.g 2x7's"  style="width: 55%;margin-left: 2%;">
                  </div>--->


                   <!-----<div class="form-group">
                  <label>Item Bar Code</label>
                  <input type="text" name="item_bar_code" class="form-control" value="{{old('item_bar_code')}}"  style="width: 100%;">
                  </div>--->


                 <!---- <div class="form-group">
                  <label>Generic</label>
                  <input type="text" name="generic" class="form-control" value="{{old('generic')}}"  style="width: 100%;">
                  </div>
                
               
                <div class="form-group">
                  <label>Origin</label>
                  <select name="origin" id="origin" class="form-control" >
                    
                    <option value=""  >------Select any value-----</option>
                    @foreach($config['origins'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                    
                  </select>
                </div>--->
                ------}}

                

            {{----       <!---<div class="form-group">
                  <label>Unit</label>
                   <select class="form-control" name="unit" id="unit" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($config['units'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                  </select>
                  </div>

               
                 <div class="form-group">
                  <label>GTIN No</label>
                   <select class="form-control" name="gtin_id" id="gtin_id" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($config['gtins'] as $gtin)
                    <option value="{{$gtin['id']}}">{{$gtin['gtin_no']}}</option>
                    @endforeach
                  </select>
                  </div>-------->
---}}

               <div class="form-group">
                  <label>Pricing By</label>
                  <select class="form-control" name="pricing_by"  required>
                    
                    <option value="feet">Feet</option>
                    <option value="weight">Weight</option>
                  </select>
                </div>
                
              </div>
              <!-- /.col -->
              <div class="col-md-5">

                <!---- <fieldset class="border p-4">
                   <legend class="w-auto">Stock level</legend>

                   <div class="row">
                   <div class="col-md-4">
                     <label>Minimal</label>
                   </div>
                   <div class="col-md-4">
                     <label>Optimal</label>
                   </div>
                   <div class="col-md-4">
                     <label>Maximal</label>
                   </div>
                   </div>

                    <div class="row">
                   <div class="col-md-4">
                     <input type="number" class="form-control" step="any"  name="minimal" value="{{old('minimal')}}">
                   </div>
                   <div class="col-md-4">
                     <input type="number" class="form-control" step="any" name="optimal" value="{{old('optimal')}}">
                   </div>
                   <div class="col-md-4">
                     <input type="number" class="form-control" step="any" name="maximal" value="{{old('maximal')}}">
                   </div>
                   </div>

                     
                        </fieldset>--->

                  <div class="form-group">
                     <label>Reorder Level</label>
                     <input type="number" step="any" class="form-control" name="minimal" required>
                   </div>
      
                    
                   <div class="form-group">
                     <label>Standard Rate</label>
                     <input type="number" step="any" class="form-control" name="standard_rate" required>
                   </div>

                   <div class="form-group">
                     <label>L QTY</label>
                     <input type="number" step="any" class="form-control" name="loading_qty" >
                   </div>

                   <div class="form-group">
                     <label>Weight</label>
                     <input type="number" step="any" class="form-control" name="weight" required>
                   </div>

                   <div class="form-group">
                     <label>Feet</label>
                     <input type="number" step="any" class="form-control" name="feet" required>
                   </div>
                  
                   
                 

                {{-- <!------<fieldset class="border p-4 mt-5">
                    <div class="row">
                   <div class="col-md-6">
                     <label>Small Unit</label>
                  
                
                   <select class="form-control" name="small_unit_id" id="small_unit_id" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($config['units'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                  </select>
            
                   </div>
                   <div class="col-md-6">
                     <label>Conversion Rate</label>
                     <input type="number" step="any" class="form-control" name="unit_rate">
                   </div>
                  
                   </div>
                 </fieldset>

                 <div class="form-group">
                  <input type="checkbox" name="status" value="1" id="status" class=""  checked>
                  <label>Active</label>
                  </div>

                  <div class="form-group">
                  <input type="checkbox" name="manufactured" value="1" id="manufactured" onchange="" class="" >
                  <label>Manufactured</label>
                  </div>

                  <div class="form-group">
                  <label>Manufactured By</label>
                   <select class="form-control" name="manufactured_by" id="manufactured_by"  style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    <option value="fahmir">Fahmir Pharma</option>
                    <option value="alsehat">Al-Sehat Lab</option>
                    
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Bill of Material</label>
                   <select class="form-control " name="procedure" id="procedure"  style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($config['procedures'] as $raw)
                    <option value="{{$raw['id']}}">{{$raw['name']}}</option>
                    @endforeach
                  </select>
                  </div>


                <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" class="form-control" >{{old('remarks')}}</textarea>
                </div>--->
              --}}
             

              </div>
              <!-- /.col -->

             {{---<!--- <div class="col-md-4">

                 <fieldset class="border p-4">
                   <legend class="w-auto">Opening Stock</legend>

                   <div class="row">
                   <div class="col-md-4">
                     <label>Quantity</label>
                   </div>
                   <div class="col-md-4">
                     <label>Rate</label>
                   </div>
                   <div class="col-md-4">
                     <label>Total</label>
                   </div>
                   </div>

                    <div class="row">
                   <div class="col-md-4">
                     <input type="number" class="form-control " step="any" onchange="setTotal()" id="qty"  name="qty" value="">
                   </div>
                   <div class="col-md-4">
                     <input type="number" class="form-control" step="any" onchange="setTotal()" id="rate" name="rate" value="">
                   </div>
                   <div class="col-md-4">
                     <input type="number" class="form-control" id="total" step="any" name="total" value="">
                   </div>
                   </div>

                   <div class="row">
                   <div class="col-md-6">
                     <label>GRN No.</label>
                   </div>
                   <div class="col-md-6">
                     <label>Batch No.</label>
                   </div>
                   </div>

                    <div class="row">
                   <div class="col-md-6">
                     <input type="text" class="form-control "  name="grn_no" value="">
                   </div>
                   <div class="col-md-6">
                     <input type="text" class="form-control" name="batch_no" value="">
                   </div>
                   </div>

                     
                        </fieldset>
                      </div>---> --}}
            </div>
            <!-- /.row -->





        
      </div>

      </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">

  
//$("#inventory_form").validate();

 function updateItemName() {
     //   let category = $("#category option:selected").text();
       // let subCategory = $("#type option:selected").text();

         let category = $("#category option:selected").data("name") || "";
        let subCategory = $("#type option:selected").data("name") || "";
 

        let gage = $("#gage_id option:selected").text();

        // Only include if selected (skip default "-- Select --")
        let parts = [];
        //if ($("#category").val()) parts.push(category);
        if ($("#type").val()) parts.push(subCategory);
        if ($("#gage_id").val()) parts.push(gage);

        $("#item_name").val(parts.join(" "));
    }

    // Run whenever dropdowns change
    $("#category, #type, #gage_id").on("change", updateItemName);


  
  $('#inventory_form').validate({
    rules: {
      
    },
    messages: {
      
    },
    submitHandler: function (form) {
        //alert("Form submitted successfully!");
        form.submit(); // uncomment for real submission
      },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });



  var packing_row=1;
  var color_row=1;

$(document).ready(function(){
  value1="{{old('gender') }}"
   
   if(value1!="")
   {
    
  $('#gender').find('option[value="{{old('gender')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('marital_status') }}"
   
   if(value1!="")
   {
    
  $('#marital_status').find('option[value="{{old('marital_status')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('type') }}"
   
   if(value1!="")
   {
    
  $('#type').find('option[value="{{old('type')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('designation') }}"
   
   if(value1!="")
   {
    
  $('#designation').find('option[value="{{old('designation')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('department') }}"
   
   if(value1!="")
   {
    
  $('#department').find('option[value="{{old('department')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('shift') }}"
   
   if(value1!="")
   {
    
  $('#shift').find('option[value="{{old('shift')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('refference') }}"
   
   if(value1!="")
   {
    
  $('#refference').find('option[value="{{old('refference')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('state') }}"
   
   if(value1!="")
   {
    
  $('#state').find('option[value="{{old('state')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('city') }}"
   
   if(value1!="")
   {
    
  $('#city').find('option[value="{{old('city')}}"]').attr("selected", "selected");
   
   }

  //  value1="{{old('status') }}"
   
   
  //  if(value1=="1")
  //  {
    
  // $('#status').prop("checked", true);
   
  //  }
  //   else{
  //     $('#status').prop("checked", false);
  
  //   } 

 



})



    
function setItemCode()
{
    var department=$('#department').val();
    var type=$('#type').val();
    var category=$('#category').val();

    $.ajax({
               type:'get',
               url:'{{ url("/get/item/code") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     department: department ,
                     type: type,
                     category: category,
               },
               success:function(data) {

                item_code=data;
                 
                 $('#item_code').val(item_code);
                 



               }
             });

}

function setTotal()
{
   var rate=$('#rate').val();
   var qty=$('#qty').val();

   var total=rate * qty;

   total=total.toFixed(2);

   $('#total').val(total);
}

function AddPacking()
{
      
           var packing_row=this.packing_row;
      
     var txt=`<tr id="packing_${packing_row}"><td></td><td><input type="number" step="any" form="inventory_form"   name="packing[]" value="1" ></td>
       
       <td><button type="button" class="btn" onclick="removePacking(${packing_row})"><span class="fa fa-minus-circle text-danger"></span></button></td></tr>`;

    $("#packing_body").append(txt);
        
       this.packing_row=this.packing_row+1;
   
   
     
}// end function

function removePacking(row)
{
  
  
    $(`#packing_${row}`).remove();
  


}
function AddColor(){
   var color_row=this.color_row;

   let color_id=$('#color').val();
   let color=$('#color option:selected').text();
   
   if(color_id==''){
     return;
   }

   if ($("input[name='color[]'][value='" + color_id + "']").length > 0) {
        $("#color-error").show();
        return;
    }
    else{
      $("#color-error").hide();
    }
      
     var txt=`<tr id="color_${color_row}"><td></td><td><input type="hidden" form="inventory_form"   name="color[]" value="${color_id}" >${color}</td>
       
       <td><button type="button" class="btn" onclick="removeColor(${color_row})"><span class="fa fa-minus-circle text-danger"></span></button></td></tr>`;

    $("#color_body").append(txt);

    $("#colorsModal").modal('hide');
        
       this.color_row=this.color_row+1;
}
function removeColor(row)
{
  
  
    $(`#color_${row}`).remove();
  


}
</script>

@endsection  
  