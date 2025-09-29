
@extends('layout.master')
@section('title', 'Item History')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Item History</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Item</a></li>
              <li class="breadcrumb-item active">History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">History</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('search/item/history')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    {{---<!---<div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" onchange="setDepartmentItem()" name="location" id="location" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>-->--}}

               <div class="col-md-2">
                    <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category_id"  style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($categories as $depart)
                    <option value="{{$depart['id']}}"  {{ $depart['id'] == request('category_id')  ? 'selected' : '' }} >{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                    <div class="form-group">
                  <label>Item</label>
                  <select class="form-control select2" onchange="" name="item_id" id="item_id">
                    <option value="">Select any value</option>
                    
                    @foreach($items as $depart)
                    @if($depart['category_id']== request('category_id'))
                    <option value="{{$depart['id']}}" {{ $depart['id'] == request('item_id')  ? 'selected' : '' }} >{{$depart['item_name']}}</option>
                    @endif
                    @endforeach

                  </select>
                </div>
              </div>


                  <!-- <div class="col-md-4">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code" value="">
      
           </div>
           </div>
 -->
           <div class="col-md-2">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control "  name="from" id="from" value="@if(isset($from)){{$from}}@endif">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control "  name="to" id="to"  value="@if(isset($to)){{$to}}@endif" >
                </div>
              </div>


                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View History">
                     </div>


                    </div>

                 </fieldset>
                 </form>

                  @if(isset($records))
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                    <tr>             
                    
                    <th colspan="10" class="text-right">{{'Opening Qty: '.$open}}</th>
                  </tr>
                  <tr>             
                    <th>#</th>
                    <th>Doc No</th>
                    <th>Date</th>
                    <th>Customer / Vendor</th>
                    <!--<th>Batch No.</th>
                    <th>Item</th>
                    <th>GRN No</th>-->
                    <th>Rack</th>
                    <th>Rack Qty</th>

                    <th>In Qty</th>
                    <th>Out Qty</th>
                    <th>Balance</th>
                    <th></th>
                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; ?>
                  @foreach($records as $record)
                 
                  
                  <tr>
                  
                   <td>{{$i}}</td>
                   <td>
                    @if($record['type']=='grn')
                    <a href="{{url('edit/purchase/grn/'.$record['doc_no'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='issuance')
                    <a href="{{url('edit/issuance/'.$record['doc_no'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='issuance-return')
                    <a href="{{url('edit/issuance-return/'.$record['doc_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='production')
                    <a href="{{url('edit/transfer-note/'.$record['yield_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='challan')
                    <a href="{{url('edit/delivery-challan/'.$record['challan_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='adjustment')
                    <a href="{{url('stock-adjustment/edit/'.$record['adjustment_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='purchase_return')
                    <a href="{{url('edit/purchase/return/'.$record['doc_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='sale_return')
                    <a href="{{url('edit/sale/return/'.$record['doc_id'])}}">{{$record['doc_no']}}</a>
                    @else
                    @endif
                   </td>
                   <?php $date=date_create($record['doc_date']);
                          $date=date_format($date,"d-M-Y");  ?>
                   <td>{{$date}}</td>
                   <?php $name='';
                      if(isset($record['customer_name']))
                        $name=$record['customer_name'];
                    ?>
                   <td>{{$name}}</td>

                   <!---<td>{{$record['batch_no']}}</td>
                   <td>@if(isset($record['production_item'])){{$record['production_item']}}@endif</td>
                   <td>@if(isset($record['grn_no'])){{$record['grn_no']}}@endif</td>-->

                   <td>@if(isset($record['rack'])){{$record['rack']}}@endif</td>
                   <td>@if(isset($record['rack_qty'])){{$record['rack_qty']}}@endif</td>

                   <td>{{$record['in_qty']}}</td>
                   <td>{{$record['out_qty']}}</td>
                   <td>{{$record['balance']}}</td>
                   <td></td>
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  
                  
                  </tbody>
                  <tfoot>
                    
                  <tr>
                      <th colspan="10" class="text-right">{{'Closing Qty: '.$close}}</th>
                  </tr>
                  <tr>
                      <th colspan="10" class="text-right">{{'Current Balance: '.$current}}</th>
                  </tr>
                  </tfoot>
                </table>
                @endif

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">

  let items = @json($items);


 $(document).on('change', 'select[name="category_id"]', function () {
    let categoryId = $(this).val();
  
    let itemSelect = $('select[name="item_id"]');

    itemSelect.empty().append('<option value="">Select any value</option>');

    if (categoryId) {
        let filteredItems = items.filter(item => item.category_id == categoryId);

        filteredItems.forEach(item => {
            itemSelect.append(
                $('<option>', { value: item.id, text: item.item_name, 'data-weight': item.weight, 'data-feet': item.feet  })
            );
        });
    }
});

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
     filterOpen: false
    });

 }

$(document).ready(function(){

   $('.select2').select2(); 
  
  @if(isset($inventories))
   var items=<?php echo json_encode($inventories); ?> ;
   //setInventory(items);
   $('#item_id').empty().append('<option value="" >Select any value</option>');

    for (var k =0 ;k < items.length ; k ++ )
     {                   

    $('<option value="'+items[k]['id']+'">'+items[k]['item_name']+'</option>').appendTo("#item_id");
      }

   $('#location').val(<?php echo json_encode($department) ?>);
   // var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   // s.val(<?php //echo json_encode($item['item_name']) ?>);
   // $('#item_code').val(<?php //echo json_encode($item_combine); ?>);

   $('#item_id').val(<?php echo json_encode($item_id) ?>);
   $('#item_id').trigger('change');
   @else
   var items=[];
   //setInventory(items);
   @endif
     
      

      $('#item_history_form').submit(function(e) {

    e.preventDefault();
//alert(this.row_num);
var item_code=$('#item_id').val();
             if(item_code=='')
             {
               $('#item_error').show();
               $('#item_error_txt').html('Select items!');
             }
             else
             {
                   $('#item_error').hide();
               $('#item_error_txt').html('');
               this.submit();
             }
  });

   
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
                 
                 $('#item_id').empty().append('<option value="" >Select any value</option>');

                  for (var k =0 ;k < items.length ; k ++ )
                   {                   

                  $('<option value="'+items[k]['id']+'">'+items[k]['item_name']+'</option>').appendTo("#item_id");
                    }
                 
                 //setInventory(items);



               }
             });
    
}//end setDepartmentItem


$(document).ready(function(){

@if(isset($employees))
 var employees=<?php echo json_encode($employees); ?> ;



for (var i = 0 ; i < employees.length ; i++) {
    
    value1=employees[i]['status']
    id=employees[i]['employee_id']
   
   if(value1!="")
   {
    
 
    $('#'+id+'_status').find('option[value="'+value1+'"]').attr("selected", "selected");
   
   }

  }

  @endif  


})



</script>
@endsection  
  