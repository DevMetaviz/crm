
@extends('layout.master')
@section('title', 'Production Entry')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('production-entry/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Production Entry</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/production-entry')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/production/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Production Entry</li>
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
                <h3 class="card-title">Production</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>

                @if(isset($ticket))
                <input type="hidden" form="ticket_form" value="{{$ticket['id']}}" name="ticket_id"/>
                
                @endif

                

                <div class="row col-md-10 form-row">
                  
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Doc No.</label>
                  <input type="text" form="ticket_form" name="code" class="form-control select2 col-sm-8" value="{{$code}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                 
                   @if(isset($ticket))
                   

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No.</label>
                  <input type="text" form="ticket_form" name="plan_no" class="form-control select2 col-sm-8" value="{{$ticket['plan']['plan_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Ticket No.</label>
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$ticket['ticket_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                 @endif

                 

                 <div class="col-sm-6">
                    <div class="form-group row">
                  <label class="col-sm-4">Department</label>
                  <select class="form-control select2 col-sm-8" form="ticket_form" onchange="setDepartmentItem()" name="department" id="location" required style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                 


                 <div class="col-sm-6">
                 <div class="dropdown form-group row" id="items_table_item_dropdown">
               <label class="col-sm-4">Finished Product</label>
              <div class="col-sm-8" style="padding: 0px;">
             <input class="form-control" form="ticket_form"  name="item" id="item_code" onchange="setUom()">
             </div>
              </div>
               </div>

                 <?php 
                     if(isset($ticket))
                     {
                      $unit=$ticket['product']['unit'];
                      if($unit!='')
                        $unit=$ticket['product']['unit']['name'];
                       }
                  ?>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">UOM</label>
                  <input type="text" form="ticket_form" name="uom" class="form-control select2 col-sm-8" value="@if(isset($unit)){{$unit}}@endif" id="uom" readonly required style="width: 100%;">
                  </div>
                 </div>

                 

                


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Batch NO</label>
                  <input type="text" form="ticket_form" name="batch_no" class="form-control select2 col-sm-8" value="@if(isset($ticket)){{$ticket['batch_no']}}@endif"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Production Date</label>
                  <input type="date" form="ticket_form" name="production_date" class="form-control select2 col-sm-8" value=""  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Manufacturing Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" class="form-control select2 col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Expiry Date</label>
                  <input type="date" form="ticket_form" name="exp_date" class="form-control select2 col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">MRP</label>
                  <input type="number" form="ticket_form" name="mrp" step="any" class="form-control select2 col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>



                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Unit</label>
                  <select class="form-control select2 col-sm-8" form="ticket_form" name="unit" id="unit" required="true" onchange="setPackSize()" style="width: 100%;">
                    <!-- <option value="">Select Unit</option> -->
                    <option value="loose" selected>Loose</option>
                    <option value="pack">Pack</option>
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Quantity</label>
                  <input type="number" form="ticket_form" min="1" value="1" name="qty" id="qty" class="form-control select2 col-sm-8" onchange="setTotalQty()"   required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="number" form="ticket_form" name="p_s" id="p_s"   onchange="setTotalQty()" class="form-control select2 col-sm-8" value="1" min="1" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <?php 
                   

                  ?>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Total Quantity</label>
                  <input type="text" form="ticket_form" name="total_qty" id="total_qty" min="1" class="form-control col-sm-8" value="1" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Cost Price</label>
                  <input type="number" step="any" form="ticket_form" name="cost_price" id="cost_price" min="0" class="form-control col-sm-8" value="0" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="activeness" value="1" id="activeness" class=""  checked>&nbsp&nbspActive</label>
                  </div>
                </div>
                 

                

               </div>
 

                 

                



              
                  
                  
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

  $(document).ready(function() {  
      
       
       var items=[];
      setInventory(items);

      var department_id="<?php if(isset($ticket['inventory_id'])) echo $ticket['product']['department_id'] ; else echo '' ; ?>";
      
      var item_id="<?php if(isset($ticket['inventory_id'])) echo $ticket['inventory_id'] ; else echo '' ; ?>";
      var item="<?php if(isset($ticket['inventory_id'])) echo $ticket['product']['item_name'] ; else echo '' ; ?>";

      if(department_id!='')
      {
        $('#location').val(department_id);
        setDepartmentItem();
        $("#item_code").val(item_id);

       //var s=$("#items_table_item_dropdown").find(".inputpicker-input");
        //s.val(item);


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

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,size:item_size,color:item_color,unit:item_unit,id:items[i]['id']};
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
    fieldValue: 'id',
  filterOpen: true
    });

 }

function setUom()
{

    var uom="";
        $("#uom").val(uom);

}


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

function setTotalQty() //in add item form
{
  qty=$("#qty").val();
  p_s=$("#p_s").val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   $("#total_qty").val(total_qty); 
}
</script>





@endsection  
  