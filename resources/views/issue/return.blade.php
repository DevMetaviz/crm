
@extends('layout.master')
@section('title', 'Return Issuance')
@section('header-css')
<style type="text/css">
  .alert-success {
     color: #155724; 
    background-color: #d4edda;
    /*border-color: #c3e6cb;*/
}

 
</style>
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
    <form role="form" id="ticket_form" method="POST" action="{{url('/issuance-return/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">New Issuance Return</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
           
           
            <a class="btn" href="{{url('issuance-return/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Inventory</a></li>
              <li class="breadcrumb-item active">Issuance Return</li>
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

             @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
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
              <div class="col-md-8">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto">Document</legend>

                <div class="row">
                  <div class="col-md-4">
                    
                  
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Return No.</label>
                  <input type="text" name="doc_no" id="doc_no"  class="form-control" value="{{$doc_no}}" required style="width: 100%;" readonly>
                  </div>

                  

                <div class="form-group">
                  <label>Return Date</label>
                  <input type="date" name="doc_date" class="form-control" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Department</label>
                  <select class="form-control" name="department_id" id="department_id" onchange="setDepartmentItem()"  style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($locations as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                   
                  </select>
                </div>

                  
                  

                <div class="form-group">
                  <input type="checkbox" name="returned" value="1" id="returned" class=""  checked>
                  <label>Reurned</label>
                  </div>

                  </div>

                 
                  <div class="col-md-4">
                    
                     @if(isset($issue))
                      <div class="form-group">
                  <label>Issuance No.</label>
                  <input type="text" name="request_no" id="request_no"  class="form-control" value="{{$issue['issuance_no']}}" required style="width: 100%;" readonly>
                  <input type="hidden" name="issuance_id" id="issuance_id"  value="{{$issue['id']}}" >
                  </div>

                  

                <div class="form-group">
                  <label>Issuance Date</label>
                  <input type="date" name="issuance_date" class="form-control" value="{{$issue['issuance_date']}}" readonly style="width: 100%;">
                  </div>
                 @endif


                  <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" id="remarks"  class="form-control"></textarea>
                  </div>

                 
                  
                 


                  </div>

                   
                  <div class="col-md-4">

                    
                    
                    @if(isset($issue['plan_id']))

                    <div class="form-group">
                  <label>Plan No</label>
                  <input type="text" name="plan_no" id="plan_no"  class="form-control" value="{{$issue['plan']['plan_no']}}" required style="width: 100%;" readonly>
                  <input type="hidden" name="plan_id" id="plan_id"  value="{{$issue['plan_id']}}" >
                  </div>

                  <div class="form-group">
                  <label>Product</label>
                  <input type="text" name="product" id="product"  class="form-control" value="{{$issue['plan']['product']['item_name']}}" required style="width: 100%;" readonly>
                  </div>

                  <div class="form-group">
                  <label>Batch No.</label>
                  <input type="text" name="batch_no" id="batch_no"  class="form-control" value="{{$issue['plan']['batch_no']}}" required style="width: 100%;" readonly>
                   </div>

                 
                  <div class="form-group">
                  <label>Batch Size</label>
                  <input type="text" name="batch_size" id="batch_size" class="form-control" value="{{$issue['plan']['batch_size']}}" readonly style="width: 100%;">
                  </div>

                    @endif


                  </div>

                </div>



              </fieldset>

                                
                <!-- /.form-group -->
                

               

               
                  

               
                
              </div>
              <!-- /.col -->
              

              <div class="col-md-4">

                  <fieldset class="border p-4">
                   <legend class="w-auto">Other</legend>

                   <div class="form-group row">
                  <label class="col-sm-4">Return By:</label>
                   <select class="form-control select2 col-sm-8" name="return_by" id="return_by" onchange="setDesignation()" >
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div>

                  <div class="form-group row">
                  <label class="col-sm-4">Designation</label>
                <input type="text" class="form-control col-sm-8" value="" name="designation_return_by" id="designation_return_by" readonly>
                </div> 

                  <div class="form-group row">
                  <label class="col-sm-4">Received By:</label>
                   <select class="form-control select2 col-sm-8" name="received_by" id="received_by" onchange="setDesignation1()"  >
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div> 

                  <div class="form-group row">
                  <label class="col-sm-4">Designation</label>
                <input type="text" class="form-control col-sm-8" value="" name="designation_received_by"  id="designation_received_by" readonly>
                </div> 

                <div class="form-group row">
                  <label class="col-sm-4">Department:</label>
                   <select class="form-control select2 col-sm-8" name="receiving_department" id="receiving_department" onchange=""  >
                    <option value="">Select any value</option>
                    @foreach($departments as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                     @endforeach
                  </select>
                  </div> 

                
                    </fieldset>
                       

                        


            
              </div>
              <!-- /.col -->

            </div>
            <!-- /.row -->



<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Material</a></li>
        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Expense</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC">Terms</a></li> -->
        
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="tabA">
      
     
    
     <div class="row">
              <div class="col-md-12">
                
                 <!-- <fieldset class="border p-4">
                   <legend class="w-auto">Item</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                  

                  <div class="col-md-3">
                 <div class="dropdown" id="items_table_item_dropdown" onchange="setLots()">
        <label>Item</label>
        <input class="form-control"  name="item_code" id="item_code" >
      
           </div>
           </div>

            

              <div class="col-md-2">
                    <div class="form-group">
                  <label>GRN No</label>
                   <input list="grn_no_list" value=""  form="add_item" name="grn_no" id="grn_no" class="form-control" style="width: 100%;" autocomplete="off">
                   <datalist form="add_item"  id="grn_no_list">
                  <option value="">
                  </datalist>
                </div>
              </div> 

              
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Batch No</label>
                  <input type="text"  form="add_item" name="item_batch_no" id="item_batch_no" class="form-control" value="" style="width: 100%;">
                </div>
              </div>  

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Stock</label>
                  <input type="number" min="0" form="add_item" name="stock_in_qty" id="stock_in_qty" class="form-control" style="width: 100%;">
                </div>
              </div>

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Stage</label>
                  <select class="form-control" form="add_item" name="item_stage" id="item_stage" readonly  style="width: 100%;">
                    <option value="-1">Select Stage</option>
                    
                  </select>
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
                  <label>Return Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="qty" id="qty" onchange="setTotalQty()" class="form-control" required="true" style="width: 100%;">
                </div>
              </div>

              
              <div class="col-md-2">
                    <div class="form-group">
                  <label>Pack Size</label>
                  <input type="number" value="1" min="1"  form="add_item" name="p_s" id="p_s"   onchange="setTotalQty()" class="form-control" readonly  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Total Qty</label>
                  <input type="number" value="1" min="1" form="add_item" name="total_qty" id="total_qty" class="form-control" readonly style="width: 100%;">
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

              


</div> 



                 </fieldset> -->
              </div>
            </div>


     <div class="table-responsive">
      <table class="table table-bordered table-hover "  id="item_table" >
        <thead class="table-secondary">
           <tr>

             <th>#</th>
            
             <th>Item</th>
             <th>Stage</th>
             <th>GRN No</th> 
             <th>Batch No</th>
             <th>UOM</th>
             <th>Unit</th>
             <th>Issued Qty</th>
            <th>Returned Qty</th>
             <th>Pack Size</th>
             <th>Total Qty</th>
             <!-- <th>Gross Total Qty</th>
 -->             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems"> 


          <?php $row=1;  ?>
              
               @if(isset($issued_items))
             @foreach($issued_items as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>))" id="{{$row}}">
      

     
     <input type="hidden" form="ticket_form" id="{{'item_id_'.$row}}" name="items_id[]" value="{{$item['item_id']}}" readonly >

     <input type="hidden" form="ticket_form" id="{{'stages_'.$row}}" name="stages[]"  value="{{$item['stage_id']}}">

      <input type="hidden" form="ticket_form" id="{{'grn_nos_'.$row}}" name="grn_nos[]"  value="{{$item['grn_no']}}"  >
      <input type="hidden" form="ticket_form" id="{{'batch_nos_'.$row}}" name="batch_nos[]"  value="{{$item['batch_no']}}"  > 
     <input type="hidden" form="ticket_form" id="{{'units_'.$row}}" name="units[]"  value="{{$item['unit']}}">
     
     <!-- <input type="hidden" form="ticket_form" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['return_qty']}}" > -->
      <input type="hidden" form="ticket_form" id="{{'issue_id_'.$row}}" name="issue_ids[]"  value="{{$item['issued_id']}}" > 
     <input type="hidden" form="ticket_form" id="{{'p_ss_'.$row}}" name="p_s[]"  value="{{$item['pack_size']}}">

     
     
     <td></td>
    
     <td id="{{'item_name_'.$row}}">{{$item['item_name']}}</td>
     <td id="{{'stage_text_'.$row}}">{{$item['stage_text']}}</td>
      <td id="{{'grn_no_'.$row}}">{{$item['grn_no']}}</td> 
      <td id="{{'batch_no_'.$row}}">{{$item['batch_no']}}</td> 
  
       <td id="{{'item_uom_'.$row}}">{{$item['uom']}}</td>
     <td id="{{'unit_'.$row}}">{{$item['unit']}}</td>
      <td id="{{'iss_qty_'.$row}}">{{$item['issue_qty']}}</td>
     <!-- <td id="{{'qty_'.$row}}">{{$item['return_qty']}}</td> -->
     
     <td id="{{'qty_'.$row}}"> <input type="number" step="any" form="ticket_form" id="{{'qtys_'.$row}}" name="qtys[]"  value="{{$item['return_qty']}}" onchange="setTotalQty('{{$row}}')" > </td>

     <td id="{{'p_s_'.$row}}">{{$item['pack_size']}}</td>
     
     <?php $total=$item['pack_size'] * $item['return_qty']; ?>
     <td id="{{'total_qty_'.$row}}">{{$total}}</td>
     <!-- <td id="gross_total_qty_${row}"></td> -->
     

         <td><button type="button" class="btn" onclick="removeItem('{{$row}}')"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
     <?php $row+=1;   ?>
     @endforeach
      @endif
           
          
        </tbody>
        <tfoot>
          <tr>

             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_qty">0</th>
             <th></th> 
             <th></th>
             <th id="net_total_qty">0</th>
             <!-- <th></th> -->
             <th></th>

           </tr>
        </tfoot>
      </table>
    </div>

                 
     
        
    </div>
    <!-- <div class="tab-pane fade" id="tabB">

      
      
    </div>

    <div class="tab-pane fade" id="tabC">

      
    </div>
 -->
    

    
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>

       <form role="form" id="#add_item">
              
            </form>

             <form role="form" id="#load_demand_items">
              
            </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">
  
  var row_num=<?php echo json_encode($row); ?>;
  var items=[];
  var stocks=[];

 
  $(document).ready(function() {
     
      $('.select2').select2(); 
  
  $('#ticket_form').submit(function(e) {

    
    e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();

for (var i =1; i <= row_num ;  i++)
{
if ($(`#qty_${i}`). length > 0 )
     {
        $('#std_error_txt').html('');
         $('#department_id').removeAttr('disabled');
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
   this.row_num++;
}

function getItems()
 {
  return this.items;
}

function setItems(items)
{
  this.items =items;
}

function getStocks()
 {
  return this.stocks;
}
function setStocks(stocks)
 {
   this.stocks=stocks;
}



function setInventory(items)
 {
  
  
  var new_items=[];
 
 for(var i = 0 ; i < items.length ; i++)
 {
  var item_type='',item_unit='',item_category='';
  
   if(items[i]['type']!=null)
    item_type=items[i]['type']['name'];
   if(items[i]['unit']!=null)
    item_unit=items[i]['unit']['name'];
   
   if(items[i]['category']!=null)
    item_category=items[i]['category']['name'];

    combine='code_'+items[i]['item_code']+'_name_'+items[i]['item_name']+'_uom_'+item_unit+'_id_'+items[i]['id'];

         var let={combine:combine , code:items[i]['item_code'],item:items[i]['item_name'],type:item_type,category:item_category,unit:item_unit};
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
        {name:'unit',text:'Unit'}
    ],
    headShow: true,
    fieldText : 'item',
    fieldValue: 'combine',
  filterOpen: true
    });

 }

  

$(document).ready(function(){
  
    //alert(''); 
     @if(isset($department_id))

  var department_id='<?php echo $department_id ?>'; 
  jQuery('#department_id').val(department_id);
  $('#department_id').attr("disabled", true); 
@endif

      
      @if(isset($inventories))
  var items=<?php echo $inventories ?>;
  @else
     var items=[];
   @endif 
       setInventory(items);
        setItems(items);
       setNetQty();
});







function setDepartmentItem()
{
  var department_id= jQuery('#department_id').val();
  if(department_id=='')
  {
    var items=[];//blank array
    setInventory(items);
    return;
  }
   $("#item_name").val('');
    $("#item_id").val('');
    $("#item_code").val('');
    
   $("#item_unit").val('');

    $.ajax({
               type:'get',
               url:'{{ url("/department/inventory") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     department_id: jQuery('#department_id').val(),
                  

               },
               success:function(data) {

                items=data;
                 
                 setInventory(items);
                  setItems(items);



               }
             });
    $('#department_id').attr("disabled", true); 
}//end setDepartmentItem

    





function setPackSize()
{
  unit=$("#unit").val();
  if(unit=='' || unit=='loose')
  {
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  $("#p_s").val('');
  setTotalQty();
   }
   else if( unit=='pack')
   document.getElementById('p_s').removeAttribute('readonly');
}



function setTotalQty(row) //in add item form
{
  qty=$( `#qtys_${row}`).val();
  p_s=$(`#p_ss_${row}`).val();
  total_qty=qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   total_qty = Math.round( total_qty * 10000 ) /10000;

   $(`#total_qty_${row}`).text(total_qty); 

   //setGrossTotalQty();
}

function setGrossTotalQty() //in add item form
{
  app_qty=$("#app_qty").val();
  p_s=$("#p_s").val();
  total_qty=app_qty;

  if(p_s!='' )
     total_qty=total_qty*p_s;
   
   total_qty =  total_qty.toFixed(3) ;
   $("#gross_total_qty").val(total_qty); 
}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
   var net_total_qty=0, net_qty=0; //total_app_qty=0, net_gross_total_qty=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#total_qty_${i}`). length > 0 )
     { 
       var t_qty=$(`#total_qty_${i}`).text();
       var qty=$(`#qty_${i}`).text();
       //var t_g_qty=$(`#gross_total_qty_${i}`).text();
       //var app_qty=$(`#app_qty_${i}`).text();

      if(t_qty=='' || t_qty==null)
        t_qty=0;

      if(qty=='' || qty==null)
        qty=0;

      // if(t_g_qty=='' || t_g_qty==null)
      //   t_g_qty=0;

      // if(app_qty=='' || app_qty==null)
      //   app_qty=0;
      

         net_qty +=  parseFloat (qty) ;

        net_total_qty +=  parseFloat (t_qty) ;

        //total_app_qty +=  parseFloat (app_qty) ;

        //net_gross_total_qty +=  parseFloat (t_g_qty) ;
      }
       

   }

   net_total_qty =  net_total_qty.toFixed(3) ;
   net_qty =  net_qty.toFixed(3) ;

   $(`#net_total_qty`).text(net_total_qty);
   $(`#net_qty`).text(net_qty);

  // $(`#net_gross_total_qty`).text(net_total_qty);
   //$(`#total_app_qty`).text(net_qty);
     

}






function addItem()
{
  var item_combine=$("#item_code").val();

    item_combine=item_combine.split('_');
  
    if(item_combine!='')
    {
    var item_name=item_combine[3];
    var item_code=item_combine[1];
  
    var item_uom=item_combine[5];
    var item_id=item_combine[7];
  }
  else
  {
    var item_name='';
    var item_code='';

    var item_uom='';
    var item_id='';
  }


  
  
  var grn_no=$("#grn_no").val();
  var batch_no=$("#item_batch_no").val(); 
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  //var app_qty=$("#app_qty").val();
  var p_s=$("#p_s").val();
  var total=$("#total_qty").val();
  //var gross_total_qty=$("#gross_total_qty").val();
     
     if(item_name=='' ||  unit=='' || qty=='' )
     {
        var err_name='',err_unit='',err_qty='';
           
           if(item_name=='')
           {
                err_name='Item is required.';
           }
           if(unit=='')
           {
            err_unit='Unit  is required.';
           }
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
      
        
     var row=this.row_num;   
//<input type="hidden" form="ticket_form" id="app_qtys_${row}" name="app_qtys[]"  value="${app_qty}" ><td id="app_qty_${row}">${app_qty}</td><td id="gross_total_qty_${row}">${gross_total_qty}</td>

     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     
     <input type="hidden" form="ticket_form" id="item_id_${row}" name="items_id[]" value="${item_id}" readonly >
     <input type="hidden" form="ticket_form" id="grn_nos_${row}" name="grn_nos[]" value="${grn_no}" readonly >
     <input type="hidden" form="ticket_form" id="batch_nos_${row}" name="batch_nos[]" value="${batch_no}" readonly >
     
     
     <input type="hidden" form="ticket_form" id="units_${row}" name="units[]"  value="${unit}">

     <input type="hidden" form="ticket_form" id="{{'issue_id_'.$row}}" name="issue_ids[]"  value="0" > 

     <input type="hidden" form="ticket_form" id="qtys_${row}" name="qtys[]"  value="${qty}" >
     
     <input type="hidden" form="ticket_form" id="p_ss_${row}" name="p_s[]"  value="${p_s}">
     
     <td></td>
     <td id="code_${row}">${item_code}</td>
     <td id="item_name_${row}">${item_name}</td>
     <td id="grn_no_${row}">${grn_no}</td>
     <td id="batch_no_${row}">${batch_no}</td>
    
  
       <td id="item_uom_${row}">${item_uom}</td>
     <td id="unit_${row}">${unit}</td>

     <td id="iss_qty_${row}"></td>
     <td id="qty_${row}">${qty}</td>
     
     <td id="p_s_${row}">${p_s}</td>
     
     
     <td id="total_qty_${row}">${total}</td>
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
     
     
      if(p_s==null)
        p_s='1';
     
   

    $("#selectedItems").append(txt);

   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');

  $("#item_name").val('');
  $("#item_id").val('');

  $("#grn_no").val('');
  $("#item_batch_no").val('');
  
  $("#unit").val('loose');
  $("#qty").val('1');
  //$("#app_qty").val('0');
  $("#p_s").val('1');
  $("#total_qty").val('1');
  //$("#gross_total_qty").val('0');

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

     
  document.getElementById('p_s').setAttribute('readonly', 'readonly');
  
          setNetQty();
           this.row_num ++;
   
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
  
    var item_uom=item_combine[5];
    var item_id=item_combine[7];
  }
  else
  {
    var item_name='';
    var item_code='';
    
  
    var item_uom='';
    var item_id='';
  }

   
  
   var grn_no=$("#grn_no").val();
   var batch_no=$("#item_batch_no").val();
  var unit=$("#unit").val();
  var qty=$("#qty").val();
  //var app_qty=$("#app_qty").val();
  var p_s=$("#p_s").val();
  var total_qty=$("#total_qty").val();

  //var gross_total_qty=$("#gross_total_qty").val();
     
     if(item_name=='' ||  unit=='' || qty=='' )
     {
        var err_name='',err_unit='',err_qty='';
           
           if(item_name=='')
           {
                err_name='Item is required.';
           }
          
           if(unit=='')
           {
            err_unit='Unit  is required.';
           }
           if(qty=='')
           {
            err_qty='Quantity is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_name+' '+err_unit+' '+err_qty);

     }
     else
     {
     
    
       $(`#item_id_${row}`).val(item_id);

       $(`#grn_nos_${row}`).val(grn_no);
       $(`#grn_no_${row}`).text(grn_no);

       $(`#batch_nos_${row}`).val(batch_no);
       $(`#batch_no_${row}`).text(batch_no);
      
        $(`#units_${row}`).val(unit);
        $(`#qtys_${row}`).val(qty);
        //$(`#app_qtys_${row}`).val(app_qty);
        $(`#p_ss_${row}`).val(p_s);

  
     $(`#code_${row}`).text(item_code);
      
      $(`#item_name_${row}`).text(item_name);
    
    
    
      $(`#item_uom_${row}`).text(item_uom);
      $(`#unit_${row}`).text(unit);
        $(`#qty_${row}`).text(qty);
        //$(`#app_qty_${row}`).text(app_qty);
        $(`#p_s_${row}`).text(p_s);

       $(`#total_qty_${row}`).text(total_qty);
       //$(`#gross_total_qty_${row}`).text(gross_total_qty);
     
     
      if(p_s==null)
        p_s='';
     
   $("#item_code").val('');

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val('');

  $("#item_name").val('');
  $("#item_id").val('');

  
  $("#unit").val('loose');

   $("#grn_no").val('');
  $("#item_batch_no").val('');
  
  $("#qty").val('1');
  //$("#app_qty").val('0');
  $("#p_s").val('1');
  $("#total_qty").val('1');
  //$("#gross_total_qty").val('0');

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
   
   var item_uom=$(`#item_uom_${row}`).text();
   

   
   
   combine='code_'+item_code+'_name_'+item_name+'_uom_'+item_uom+'_id_'+item_id;

   $('#item_code').val(combine);
   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
   s.val(item_name);

   


 var grn_no=$(`#grn_nos_${row}`).val();
$('#grn_no').val(grn_no);

 var batch_no=$(`#batch_nos_${row}`).val(); 
$('#item_batch_no').val(batch_no);
 
var unit=$(`#unit_${row}`).text();
$('#unit').val(unit);



  var qty=$(`#qty_${row}`).text();
$('#qty').val(qty);

//var app_qty=$(`#app_qty_${row}`).text();
//$('#app_qty').val(app_qty);


  var p_s=$(`#p_s_${row}`).text();
   $('#p_s').val(p_s);
  


  var total_qty=$(`#total_qty_${row}`).text();
  $('#total_qty').val(total_qty);

  //var gross_total_qty=$(`#gross_total_qty_${row}`).text();
  //$('#gross_total_qty').val(gross_total_qty);

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



$('#location').on('change', function() {
   //$('#lot_no').empty().append('<option>---Select any value---</option>');
});

function setLots(lot_no='')
{

    var s1=$("#item_code").val();

   var s=$("#items_table_item_dropdown").find(".inputpicker-input");
      s=s.val();
      var item_id=s1.split('_')[7];

      if(item_id!='')
      {
          
          var items=this.getItems();
      let point = items.findIndex((item) => item.id == item_id);
         var grns=items[point]['grns'];
          //alert(items[point]['batches']);
            //alert(item_id);
       var txt='';
       for (var i=0;  i < grns.length ;  i++) {
            txt += '<option value="'+grns[i]['grn_no']+'" />'; 
       }
         var my_list=document.getElementById("grn_no_list");
          my_list.innerHTML = txt;
      }

      
      
}

 function setStockQty()
{
   var stock_id=$('#lot_no').val();
   if(stock_id!='')
   {
   let point = this.stocks.findIndex((item) => item.stock_id == stock_id);

   //alert(point);
   //alert(JSON.stringify(this.stocks));

   var stock_qty=this.stocks[point]['rem_stock_qty'];
   $('#stock_in_qty').val(stock_qty);
    } 

}


function removeItem(row)
{
  
  $('#item_table tr').click(function(){
       // $(this).closest('tr').remove();
        $(`#${row}`).remove();
      setNetQty();
    });

}

function setDesignation()
{
  var id=$('#return_by').val();
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='' || emp==null || emp==0)
       $('#designation_return_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_return_by').val(emp);
     }
}

function setDesignation1()
{
  var id=$('#received_by').val();
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['designation_id'];
    
    if(emp=='' || emp==null || emp==0)
        $('#designation_received_by').val('');
     else
     {
      var emp=emps[point]['designation']['name'];
      $('#designation_received_by').val(emp);
     }

     setDepartment();
}

function setDepartment()
{
  var id=$('#received_by').val();
  
  var emps=JSON.parse('<?php echo json_encode($employees); ?>');  

   let point = emps.findIndex((item) => item.id == id);

   var emp=emps[point]['department_id'];
    
    if(emp=='' || emp==null || emp==0)
        $('#receiving_department').val('');
     else
     {
      var emp=emps[point]['department_id'];
      $('#receiving_department').val(emp);
     }
}


$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});




</script>

@endsection  
  