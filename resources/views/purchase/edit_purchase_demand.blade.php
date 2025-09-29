
@extends('layout.master')
@section('title', 'Edit Purchase Demand')
@section('header-css')

<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')


       <div class="row default-header"  >
          <div class="col-sm-6">
            <h1>Purchase Demand</h1>
           </div>
          <div class="col-sm-6 text-right">

             <button form="purchase_demand" type="submit" class="btn btn-primary"><span class="fas fa-save"></span>Update</button>
             
           <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-del">
                  <span class="fas fa-trash"></span>Delete
                </button>
            <a class="btn btn-transparent" href="{{url('purchase/demand')}}" ><span class="fas fa-plus"></span>New</a>

            <a class="btn btn-transparent" href="{{url('purchase/demand/history')}}" ><span class="fas fa-history"></span>History</a>

           <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{url('/purchase/demand/report/'.$demand['doc_no'])}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>

            
          </div>
        </div>

           <ol class="breadcrumb default-breadcrumb"  >
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase</a></li>
              <li class="breadcrumb-item"><a href="#">Demand</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
  @endsection

@section('content')
    <!-- Main content -->


    <!-- /.delete modal -->
          <div class="modal fade" id="modal-del">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title ">Confirmation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Do you want to delete?&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
              <button form="delete_form" class="btn btn-outline-light">Yes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.delete modal -->


      <form role="form" id="delete_form" method="POST" action="{{url('purchase/demand/delete/'.$demand['id'])}}">
               
               @csrf    
    </form>

    <!-- Content Header (Page header) -->
    <form role="form" id="purchase_demand" method="POST" action="{{url('/purchase/demand/update')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$demand['id']}}" name="id"/>
    
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
                  
                   <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-file-alt mr-2"></i>Document</h4>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Doc No.</label>
                  <input type="text" form="purchase_demand" name="doc_no" class="form-control" value="{{$demand['doc_no']}}" readonly required style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>Demand Date</label>
                  <input type="date" form="purchase_demand" name="doc_date" class="form-control" value="{{$demand['doc_date']}}" required style="width: 100%;">
                  </div>

                   <div class="form-group">
                  <label>Required Date</label>
                  <input type="date" form="purchase_demand" name="required_date" class="form-control" value="{{$demand['required_date']}}" required style="width: 100%;">
                  </div>

                <div class="form-group">
                  <input type="checkbox" form="purchase_demand" name="posted" value="posted" id="posted" class="" >
                  <label>Posted</label>
                  </div>



              </div>

                                
              
               
                
              </div>
              <!-- /.col -->
              <div class="col-md-4">


                  <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-layer-group mr-2"></i>Other</h4>

               <!----
                  <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" onchange="setDepartmentItem()" form="purchase_demand" name="department_id" id="location" required style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($locations as $loc)
                    <option value="{{$loc['id']}}">{{$loc['name']}}</option>
                    @endforeach
                  </select>
                </div> ---->

                 



                    

                   <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" form="purchase_demand" class="form-control" >{{$demand['remarks']}}</textarea>
                </div>

                


                     
                        </div>

                      
             

              </div>
              <!-- /.col -->

              <div class="col-md-3">

                  <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-check-circle mr-2"></i>Approval</h4>

              
              <div class="form-row">

                         <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12"><input type="radio" form="purchase_demand" name="is_approved" value="1" id="approved" class=""  >&nbsp&nbspApproved</label>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-12"><input type="radio" form="purchase_demand" name="is_approved" value="0" id="rejected" class=""  >&nbsp&nbspRejected</label>
                  </div>
                </div>

              </div>

              </div>

              </div>

                            <!-- /.col -->

            </div>
            <!-- /.row -->

            

           <!------
                
                     <div class="form-section">
                   <h4 class="form-section-title"><i class="fas fa-plus-circle mr-2"></i>Add Item</h4>
              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                
              <div class="col-md-4">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code">
      
           </div>
           </div>


                 

                 <div class="col-md-2">
                    <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control" form="add_item" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
                  
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty" onchange="setTotalQty()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-1">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" min="1" form="add_item" name="p_s" id="p_s" value="1"  onchange="setTotalQty()" class="form-control" readonly required="true" style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" form="add_item" min="" value="1" value="1" name="total_qty" id="total_qty" class="form-control" required="true" readonly style="width: 100%;">
                </div>
              </div>

             
              <div class="col-md-1">
                    <div class="form-group">
                    <label style="visibility: hidden;">Qty</label>
                  <button type="button" form="add_item" id="add_item_btn" class="btn" onclick="addItem()">
    <span class="fa fa-plus-circle text-info"></span>
  </button>
                </div>
              </div>


</div> 



                 </div>
           ----->



<!-- Start Tabs -->
<div class="nav-tabs-wrapper mb-3">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA"><i class="fas fa-list mr-2"></i>Items</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="">
    
    <div class="tab-pane fade show active" id="tabA">

     <div class="table-responsive">
      <table class="table table-bordered table-hover" id="item_table">
        <thead class="table-primary">
           <tr>
            <th></th>
            <th>Department</th>
          
             <th>Item</th>
            
             <th>Variants</th>
        
          
             <th>Unit</th>
             <th>Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">
          
         
           <?php $row=1; ?>
          @foreach($demand['items'] as $item)

          <tr ondblclick="(editItem('{{$row}}'))" id="{{$row}}">
      
     <input type="hidden" form="purchase_demand" id="{{'location_id_'.$row}}"   name="location_ids[]" value="{{$item['location_id']}}"  >
     <input type="hidden" form="purchase_demand" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}"  >
     <input type="hidden" form="purchase_demand" id="{{'variant_id_'.$row}}" name="variant_ids[]" value="{{$item['variant_id']}}"  >
     
    
     
     
     
     <td></td>
     <td id="{{'location_text_'.$row}}">{{$item['location']}}</td>
   
     <td id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>
     
       <td id="{{'variant_'.$row}}">
         @if($item['variant_id'] > 0)
              {{ collect($item['variants'])->pluck('value')->implode(', ') }}
              @endif
       </td>

     
       <!----<td id="{{'item_uom_'.$row}}"></td>-->

     <td> <input type="text" form="purchase_demand" id="{{'unit_'.$row}}" name="units[]"  value="{{$item['unit']}}" readonly ></td>
     <td><input type="number" step="any" form="purchase_demand" id="{{'qty_'.$row}}" name="qtys[]"  value="{{$item['qty']}}" ></td>
     <td><input type="number" step="any" form="purchase_demand" id="{{'p_s_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}" readonly ></td>
     
     
     <td><input type="number" step="any" form="purchase_demand" id="{{'total_qty_'.$row}}"  value="{{$item['total_qty']}}" readonly></td>
     

         <td><button type="button" class="btn" onclick="removeItem('{{$row}}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
       
     <?php $row++; ?>
     @endforeach          
        </tbody>
        <tfoot class="table-secondary">
          <tr>

             <th></th>
             
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_qty">{{$demand['net_qty']}}</th>
             <th></th>
             <th id="net_total_qty">{{$demand['net_total_qty']}}</th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>
        
    </div>


     <div class="" >

    <div class="mb-2" >   
    <input type="hidden" name="items_check" id="items_check" value="1">
    </div>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemModal"><i class="fas fa-plus-circle"></i>Add Item</button>
     </div>


    <!----modal--->
 
     <div class="modal fade show" id="addItemModal"  aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Select Items</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body" >

              <div class="filter-items-search" >

                <select class="form-control" name="filter_department" >
                      <option value="">All Departments</option>
                    @foreach($locations as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                </select>

                <input class="form-control" name="filter_name" placeholder="Search by item name" >

              </div>

<div class="" style="max-height: 75vh;overflow-y: auto;"  >
          <table class="table table-bordered modal-table" >
          <thead class="table-light">
          <tr>
            <th>Department</th>
            <th>Item Name</th>
            <th>Variants</th>
            <th>Available Quantity</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Pack Size</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody id="productsTableBody">
            
            @foreach($items as $item)

            <tr data-id="{{$item['id']}}"  data-department="{{$item['department_id']}}" data-variant="{{$item['variant_id']}}"  >
              <td>{{$item['department_name']}}</td>
              <td>{{$item['item_name']}}</td>
              <td>
                @if($item['variant_id'] > 0)
              {{ collect($item['variant_items'])->pluck('value')->implode(', ') }}
              @endif
              </td>
              <td></td>
               <td>
              
                <select  name="unit" form="add_item"  class="form-control unit" >
                   <option value="loose">Loose</option>
                   <option value="pack">Pack</option>
                </select>
              </td>
              <td>
                <input type="number" step="any" form="add_item"  name="qty" class="form-control qty" >
                  <span class="error-msg text-danger small"></span>
              </td>
              <td>
                <select  name="p_s" form="add_item"  class="form-control pack_size" >
                   <option value="1">1</option>

                   @foreach($item['packs'] as $pk)
                   <option value="{{$pk}}" disabled >{{$pk}}</option>
                     @endforeach

                </select>
                <span class="error-msg text-danger small"></span>
              </td>
              <td><input type="number" step="any" form="add_item"  name="total_qty" class="form-control total_qty" readonly ></td>
              <td>
                <button type="button" class="btn btn-success" onclick="addItem(this)" >Add</button>
              </td>
            </tr>

            @endforeach

          </tbody>
        </table>
</div>



            
            </div>
            <div class="modal-footer justify-content-between-1">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <!---<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    <!-----modal----->

   
    
   

   
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->

    <form role="form" id="#add_item">
              
            </form>
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>

<script type="text/javascript">



$.validator.addMethod("atLeastOneItem", function(value, element) {
    return $("#selectedItems tr").length > 0;  // true if at least 1 row
}, "Please add at least one item.");


   $('#purchase_demand').validate({
  // Let the hidden items_check be validated (others can still be ignored)
  ignore: ":hidden:not(#items_check)",

  rules: {
    items_check: { atLeastOneItem: true }
  },
  messages: {},

  submitHandler: function (form) {
    form.submit();
  },

  errorElement: 'span',
  errorPlacement: function (error, element) {
    error.addClass('invalid-feedback');

    // Put the "no item selected" error under the items table
    if (element.attr('name') === 'items_check') {
      // If your table structure differs, tweak this line
      $('#selectedItems').closest('table').after(error);
    } else {
      // default placement for other fields
      const $group = element.closest('.form-group');
      if ($group.length) {
        $group.append(error);
      } else {
        element.after(error); // fallback
      }
    }
  },
  highlight: function (element) {
    $(element).addClass('is-invalid');
  },
  unhighlight: function (element) {
    $(element).removeClass('is-invalid');
  }
});

function afterItemsChanged() {
  $('#items_check').valid(); // triggers atLeastOneItem check
}

$(document).on("change keyup", ".qty, .pack_size, .unit", function () {
    let row = $(this).closest("tr");

    let unit = row.find(".unit").val();
    let qty = parseFloat(row.find(".qty").val()) || 0;
    let packSize = parseFloat(row.find(".pack_size").val()) || 1;

    // --- Enable/Disable pack size options ---
    if (unit === "loose") {
        // only "1" is enabled
        row.find(".pack_size option").prop("disabled", true);
        row.find(".pack_size option[value='1']").prop("disabled", false).prop("selected", true);
        packSize = 1; // force pack size to 1
    } else {
        // all options enabled
        row.find(".pack_size option").prop("disabled", false);
    }

    // --- Calculate total qty ---
    let total = qty * packSize;
    row.find(".total_qty").val(total);
});


  $(document).ready(function() {
    function filterRows() {
        let dept = $('[name="filter_department"]').val().trim().toLowerCase();
        let name = $('[name="filter_name"]').val().trim().toLowerCase();

        $("#productsTableBody tr").each(function() {
            let rowDept = $(this).data("department").toString().toLowerCase();
            let rowName = $(this).find("td:nth-child(2)").text().toLowerCase();

            // check both filters
            let deptMatch = (dept === "" || rowDept === dept);
            let nameMatch = (name === "" || rowName.includes(name));

            if (deptMatch && nameMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Run on change / input
    $('[name="filter_department"]').on("change", filterRows);
    $('[name="filter_name"]').on("keyup", filterRows);
});


var row_num=<?php echo json_encode( $row ) ; ?>; 
$(document).ready(function(){
  

   value1=<?php echo json_encode( $demand['department_id'] ) ; ?>; 

   $('#location').val(value1);

   value1=<?php echo json_encode( $demand['posted'] ) ; ?>; 
   
   
   if(value1=="posted")
   {
    
  $('#posted').prop("checked", true);
   
   }
    else{
      $('#posted').prop("checked", false);
  
    } 

 
var rslt = <?php echo json_encode($demand['is_approved']); ?>

    $(`input[name=is_approved][value=${rslt}]`).prop("checked",true);


});


$(document).ready(function(){



  $("#vendor_name").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#vendor_tabel_body tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

 /* $('#purchase_demand').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);

var rows=getRowNum();

for (var i =1; i <= rows ;  i++)
{
if ( $(`#total_qty_${i}`). length > 0 )
     {
        $('#std_error_txt').html('');
               this.submit();
               return ;
      }
  }
             
               $('#std_error').show();
               $('#std_error_txt').html('Select items!');
             
             
  });*/


   
});

function getRowNum()
 {
  return this.row_num;
  }

  function setRowNum() 
 {
   this.row_num++;
}

  function setInventory(items)
 {
  
  
  var new_items=[];
 
 for(var i = 0 ; i < items.length ; i++)
 {
  var item_color='',item_type='',item_unit='',item_size='',item_category='';
  if(items[i]['color']!=null)
    item_color=items[i]['color']['name'];
   if(items[i]['type']!=null)
    item_type=items[i]['type']['name'];
   if(items[i]['unit']!=null)
    item_unit=items[i]['unit']['name'];
   if(items[i]['size']!=null)
    item_size=items[i]['size']['name'];
   if(items[i]['category']!=null)
    item_category=items[i]['category']['name'];

    combine='code_'+items[i]['item_code']+'_name_'+items[i]['item_name']+'_uom_'+item_unit+'_size_'+item_size+'_color_'+item_color+'_id_'+items[i]['id'];

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit};
         //alert(let);
         new_items.push(let);
 }


$('#item_code').inputpicker({
    data:new_items,
    fields:[
        {name:'code',text:'Code'},
        {name:'item',text:'Item'},
        {name:'type',text:'Type'},
        {name:'category',text:'Category'},
        {name:'size',text:'Size'},
        {name:'color',text:'Color'},
        {name:'unit',text:'Unit'}
    ],
    headShow: true,
    fieldText : 'item',
    fieldValue: 'combine',
  filterOpen: true
    });

 }
$(document).ready(function(){
  
   

     //var items=[];
      //setInventory(items);
      setDepartmentItem();
   
});





 function setDepartmentItem()
{
  var department_id= jQuery('#location').val();
  if(department_id=='')
  {
    var items=[];//blank array
    setInventory(items);
    return;
  }
   $("#item_name").val('');
    $("#item_id").val('');
    $("#item_code").val('');
    $("#item_size").val('');
    $("#item_color").val('');
   $("#item_unit").val('');

    $.ajax({
               type:'get',
               url:'{{ url("/department/inventory") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     department_id: jQuery('#location').val(),
                  

               },
               success:function(data) {

                items=data;
                 
                 
                 setInventory(items);



               }
             });
    
}//end setDepartmentItem


       

 function select_vendor(name,id)
{
  //var name=this.name;
  //alert(name); alert(id);
    $("#vendor_name").val(name);
    $("#vendor_id").val(id);
}



function setPackSize()
{
  unit=$("#unit").val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  $("#p_s").val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('p_s').removeAttribute('readonly');
}

function setTotalQty()
{
  qty=$("#qty").val();
  p_s=$("#p_s").val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $("#total_qty").val(total_qty); 
}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
  
   var net_total_qty=0, net_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).val();
       var qty=$(`#qty_${i}`).val();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;
      
         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;
      }
       

   }
   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);
     

}

function checkItem(row='')
{
  var rows=getRowNum();
  for (var i =1; i <= rows ;  i++) {
   
     if ($(`#item_id_${i}`). length == 0 || $(`#item_id_${i}`). length < 0 )
     {
      continue;
     }
     if (row == i  )
     {
      continue;
     }
     var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
    var item_id='';
    if(item_combine!='')
    {     item_id=item_combine[11];
     }

     var tbl_item_id=$(`#item_id_${i}`).val(); 

     if(item_id == tbl_item_id)
      return true;
     
  
   }
  return false;   
   
}


function addItem(button) {
  

   let $row = $(button).closest("tr");

     $row.find(".error-msg").text("");

    // Data attributes
    let item_id   = $row.data("id");
    let location  = $row.data("department");
    let variant_id   = $row.data("variant");

    // Text values
    let location_text = $row.find("td:eq(0)").text().trim();
    let item_name     = $row.find("td:eq(1)").text().trim();
    let variants    = $row.find("td:eq(2)").text().trim();

    // Input/select values (using names)
    let unit   = $row.find('[name="unit"]').val();
    let qty = $row.find('[name="qty"]').val();
    let p_s = $row.find('[name="p_s"]').val();

   let valid = true;

    // Validation for qty
    if (!qty || qty <= 0) {
        $row.find('[name="qty"]').next(".error-msg").text("*Required");
        valid = false;
    }

    // Validation for pack size
    if (!p_s || p_s <= 0) {
        $row.find('[name="p_s"]').next(".error-msg").text("*Required");
        valid = false;
    }

     if (!valid) return;

    let total  = qty * p_s;

  var row=getRowNum();   


   var txt=`
   <tr ondblclick="(editItem(${row}))" id="${row}">
    
   <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}"  >
   <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}"  >
    <input type="hidden" form="purchase_demand" id="variant_id_${row}" name="variant_ids[]" value="${variant_id}"  >
   
   
   <td></td>
   <td id="location_text_${row}">${location_text}</td>
 
   <td id="item_name_${row}">${item_name}</td>
   
     <td id="variant_${row}">${variants}</td>
   
        
     <td><input type="text" form="purchase_demand" id="unit_${row}" name="units[]"  value="${unit}" readonly></td>
   <td><input type="number" step="any" form="purchase_demand" id="qty_${row}" name="qtys[]"  value="${qty}" ></td>
   <td><input type="number" form="purchase_demand" id="p_s_${row}" name="p_s[]"  value="${p_s}" readonly></td>
   
   
   <td><input type="number" step="any" form="purchase_demand" id="total_qty_${row}"  value="${total}" readonly></td>
   

       <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
   </tr>`;
   
   
   
   
 

  $("#selectedItems").append(txt);

   afterItemsChanged();

        setNetQty();
         setRowNum();


  }



function addItem1()
{
  var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
  
    if(item_combine!='')
    {
    var item_name=item_combine[3];
    var item_code=item_combine[1];
    var item_color=item_combine[9];
    var item_size=item_combine[7];
    var item_uom=item_combine[5];
    var item_id=item_combine[11];
  }
  else
  {
    var item_name='';
    var item_code='';
    var item_color='';
    var item_size='';
    var item_uom='';
    var item_id='';
  }

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
 
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();

  var dbl_item=false;
  if(item_name!='')
  {
     dbl_item=checkItem();
  }
     
     if(item_name=='' ||  unit=='' || qty=='' || dbl_item==true)
     {
        var err_name='',err_location='',err_unit='',err_qty='', err_dbl='';
           
           if(item_name=='')
           {
                err_name='Item is required.';
           }
           if(location=='')
           {
            //err_location='Location is required.';
           }
           if(unit=='')
           {
            err_unit='Unit  is required.';
           }
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }
           if(dbl_item==true)
           {
            err_dbl='Item already added.';
           }


           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_location+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     <input type="hidden" form="purchase_demand" id="location_id_${row}"   name="location_ids[]" value="${location}"  >
     <input type="hidden" form="purchase_demand" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     
     <input type="hidden" form="purchase_demand" id="units_${row}" name="units[]"  value="${unit}">
     <input type="hidden" form="purchase_demand" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     <input type="hidden" form="purchase_demand" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     
     <td></td>
     <td id="location_text_${row}">${location_text}</td>
     <td id="code_${row}">${item_code}</td>
     <td id="item_name_${row}">${item_name}</td>
     
       <td id="color_${row}">${item_color}</td>
       <td id="size_${row}">${item_size}</td>
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="unit_${row}">${unit}</td>
     <td id="qty_${row}">${qty}</td>
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='';
     
   

    $("#selectedItems").append(txt);

   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');

  $("#item_name").val('');
  $("#item_id").val('');

  //$("#location").val('');
  $("#unit").val('loose');
  $("#qty").val('1');
  $("#p_s").val('1');
  $("#total_qty").val('1');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

     
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  
          setNetQty();
           setRowNum();
   
   }
     
}//end add item

function updateItem(row)
{
  var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
  
    if(item_combine!='')
    {
    var item_name=item_combine[3];
    var item_code=item_combine[1];
    var item_color=item_combine[9];
    var item_size=item_combine[7];
    var item_uom=item_combine[5];
    var item_id=item_combine[11];
  }
  else
  {
    var item_name='';
    var item_code='';
    var item_color='';
    var item_size='';
    var item_uom='';
    var item_id='';
  }

  var location=$("#location").val();
  var location_text=$("#location option:selected").text();
  
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();

  var dbl_item=false;
  if(item_name!='')
  {
     dbl_item=checkItem(row);
  }
     
     if(item_name=='' || unit=='' || qty=='' || dbl_item==true)
     {
        var err_name='',err_location='',err_unit='',err_qty='', err_dbl='';
           
           if(item_name=='')
           {
                err_name='Item is required.';
           }
           if(location=='')
           {
            //err_location='Location is required.';
           }
           if(unit=='')
           {
            err_unit='Unit  is required.';
           }
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }
            if(dbl_item==true)
           {
            err_dbl='Item already added.';
           }


           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_location+' '+err_unit+' '+err_qty);

     }
     else
     {
     
       $(`#location_id_${row}`).val(location);
       $(`#item_id_${row}`).val(item_id);
        
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        $(`#p_ss_${row}`).val(p_s);

      $(`#location_text_${row}`).text(location_text);
     $(`#code_${row}`).text(item_code);
      
      $(`#item_name_${row}`).text(item_name);
      
      $(`#color_${row}`).text(item_color);
      $(`#size_${row}`).text(item_size);
      $(`#item_uom_${row}`).text(item_uom);
      $(`#unit_${row}`).text(unit);
        $(`#qty_${row}`).text(qty);
        $(`#p_s_${row}`).text(p_s);

       $(`#total_qty_${row}`).text(total_qty);
     
     
      if(p_s==null)
        p_s='';
     
   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');

  $("#item_name").val('');
  $("#item_id").val('');

  //$("#location").val('');
  $("#unit").val('loose');
  $("#qty").val('1');
  $("#p_s").val('1');
  $("#total_qty").val('1');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');


  document.getElementById('p_s').setAttribute('readonly', 'readonly');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
   
   }
     
}  //end update item


function editItem(row)
{
   
   var item_name=$(`#item_name_${row}`).text();
   var item_code=$(`#code_${row}`).text();
   var item_id=$(`#item_id_${row}`).val();
   var item_color=$(`#color_${row}`).text();
   var item_uom=$(`#item_uom_${row}`).text();
   var item_size=$(`#size_${row}`).text();
   
   combine='code_'+item_code+'_name_'+item_name+'_uom_'+item_uom+'_size_'+item_size+'_color_'+item_color+'_id_'+item_id;

   $('#item_code').val(combine);
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(item_name);


var location_id=$(`#location_id_${row}`).val();
$('#location').val(location_id);


var unit=$(`#unit_${row}`).text();
$('#unit').val(unit);



  var qty=$(`#qty_${row}`).text();
$('#qty').val(qty);


  var p_s=$(`#p_s_${row}`).text();
  $('#p_s').val(p_s);
  


  var total_qty=$(`#total_qty_${row}`).text();
  $('#total_qty').val(total_qty);

  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);

  if(unit=='' || unit=='loose')
  {
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  $("#p_s").val('1');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('p_s').removeAttribute('readonly');

}

function removeItem(row)
{
  
  $('#item_table tr').click(function(){
  
    $(`#${row}`).remove();
      setNetQty();
});

}


// Function to recalc one row
function recalcRow(row) {
    let qty       = parseFloat($("#qty_" + row).val())       || 0;
    let pack_size = parseFloat($("#p_s_" + row).val())       || 0;
    
    let unit      = $("#unit_" + row).val();

 

    // --- total qty ---
    let total_qty = qty * pack_size;
    $("#total_qty_" + row).val(total_qty);

    

      setNetQty();
}

// --- Trigger events ---
$(document).on("input change", "input[name='qtys[]'], input[name='p_s[]'], input[name='units[]']", function () {
    let row = $(this).closest("tr").attr("id");
    recalcRow(row);
});




</script>

@endsection  
  