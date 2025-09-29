
@extends('layout.master')
@section('title', 'Item Stock Detail')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Item Stock Detail</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Item</a></li>
              <li class="breadcrumb-item active">Stock List</li>
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
                <h3 class="card-title">Stock List</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('item-stock-detail')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    <div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" onchange="setDepartmentItem()" name="location" id="location" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                  <div class="col-md-4">
                 <div class="dropdown" id="items_table_item_dropdown">
        <label>Item</label>
        <input class="form-control"  name="item_id" id="item_id" value="">
      
           </div>
           </div>

           <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control select2"  name="from" id="from" value="@if(isset($from)){{$from}}@endif">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control select2"  name="to" id="to"  value="@if(isset($to)){{$to}}@endif" >
                </div>
              </div> -->


                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>
                 @foreach($stocks as $st)
                  {{$st['batch_no']}}<br><br>
                  @endforeach
                  @if(isset($records))
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                    <tr>             
                    
                    <th colspan="7" class="text-right">{{'Opening Qty: '.$open}}</th>
                  </tr>
                  <tr>             
                    <th>#</th>
                    <th>Doc No</th>
                    <th>Date</th>
                    <th>Batch No.</th>
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
                    @elseif($record['type']=='production')
                    <a href="{{url('edit/production-entry/'.$record['production_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='challan')
                    <a href="{{url('edit/delivery-challan/'.$record['challan_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='adjustment')
                    <a href="{{url('edit/stock-adjustment/'.$record['adjustment_id'])}}">{{$record['doc_no']}}</a>
                    @elseif($record['type']=='purchase_return')
                    <a href="{{url('edit/purchase/return/'.$record['doc_id'])}}">{{$record['doc_no']}}</a>
                    @else
                    @endif
                   </td>
                   <?php $date=date_create($record['doc_date']);
                          $date=date_format($date,"d-M-Y");  ?>
                   <td>{{$date}}</td>
                   <td>{{$record['batch_no']}}</td>
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
                      <th colspan="7" class="text-right">{{'Closing Qty: '.$close}}</th>
                  </tr>
                  <tr>
                      <th colspan="7" class="text-right">{{'Current Balance: '.$current}}</th>
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

         var let={combine:combine , id:items[i]['id'] ,code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit};
         //alert(let);
         new_items.push(let);
 }


$('#item_id').inputpicker({
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
      fieldValue: 'id',
     filterOpen: false
    });

 }

$(document).ready(function(){
  
  @if(isset($inventories))
   var items=<?php echo json_encode($inventories); ?> ;
   setInventory(items);
   $('#location').val(<?php echo json_encode($department) ?>);
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(<?php echo json_encode($item['item_name']) ?>);
   $('#item_code').val(<?php echo json_encode($item_combine); ?>);
   @else
   var items=[];
   setInventory(items);
   @endif
     
      

   
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


$(document).ready(function(){




})



</script>
@endsection  
  