
@extends('layout.master')
@section('title', 'Production Demand')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('production-demand/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Production Demand</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/production-demand')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/production-demand/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Demand</li>
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
                <h3 class="card-title">Demand</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                 <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
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

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                  

                
                

                <div class="row col-md-10 form-row">
                  
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Demand No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control col-sm-8" value="{{$code}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                 
                
                   

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Demand Date</label>
                  <input type="date" form="ticket_form" name="doc_date" class="form-control  col-sm-8" value="{{date('Y-m-d')}}" readonly  required style="width: 100%;">
                  </div>
                 </div>

                



                 <div class="col-sm-6">
                    <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <select class="form-control select2 col-sm-8" form="ticket_form" name="product_id" id="product_id" required onchange="setAttrinutes()" >
                    <option value="">------Select any value-----</option>
                    @foreach($products as $depart)
                    <option value="{{$depart['id']}}">{{$depart['item_name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div> 


                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">UOM</label>
                  <input type="text" form="ticket_form" name="uom" id="uom" class="form-control col-sm-8" value="" id="uom" readonly style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pack_size" id="pack_size" class="form-control col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 </div> 

                


                 
                <!-- <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">MRP</label>
                  <input type="number" form="ticket_form" name="mrp" id="mrp" step="any" class="form-control col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>  -->




                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Quantity</label>
                  <input type="number" form="ticket_form" min="1" value="1" name="qty" id="qty" class="form-control col-sm-8"  required style="width: 100%;">
                  </div>
                 </div>
 

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea class="form-control col-sm-10" placeholder="Comment..." form="ticket_form" name="remarks"></textarea>
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
  

  $(document).ready(function(){

$('.select2').select2(); 


});

  

function setAttrinutes()
{
   var id=$("#product_id").val();
     if(id=='')
      return ;

   var products=<?php echo json_encode($products); ?> ;
                 
   let point = products.findIndex((item) => item.id == id);
        var item=products[point];

    var uom="";

      
         $("#pack_size").val(item['pack_size']);
          
          if(item['unit']!='')
            uom=item['unit']['name'];
         $("#uom").val(uom);

}



 
  
</script>





@endsection  
  