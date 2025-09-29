
@extends('layout.master')
@section('title', 'Production Demand')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')

<form role="form" id="delete_form" method="POST" action="{{url('/delete/production-demand/'.$demand['id'])}}">
               @csrf    
    </form>

    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('production-demand/update')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Production Demand</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/production-demand')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/production-demand/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
            <button type="button" data-toggle="modal" style="border: none;background-color: transparent;" data-target="#modal-del">
                  <span class="fas fa-trash text-danger">&nbsp</span>Delete
                </button>
            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/print/production-demand/'.$demand['id'])}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>
          </div>

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
                <input type="hidden" form="ticket_form" value="{{$demand['id']}}" name="id"/>

                
                

                <div class="row col-md-10 form-row">
                  
                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Demand No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control col-sm-8" value="{{$demand['doc_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>
                 
                
                   

                  <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Demand Date</label>
                  <input type="date" form="ticket_form" name="doc_date" class="form-control  col-sm-8" value="{{$demand['doc_date']}}" readonly  required style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-6">
                    <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <select class="form-control select2 col-sm-8" form="ticket_form" name="product_id" id="product_id" required onchange="setAttrinutes()" >
                    <option value="">------Select any value-----</option>
                    @foreach($products as $depart)
                    <?php
                         $s='';
                         if($demand['product_id']==$depart['id'])
                          $s='selected';
                     ?>
                    <option value="{{$depart['id']}}" {{$s}}>{{$depart['item_name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div> 


                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">UOM</label>
                  <input type="text" form="ticket_form" name="uom" id="uom" class="form-control col-sm-8" value="@if($demand['product']['unit']!=''){{$demand['product']['unit']['name']}}@endif" id="uom" readonly style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pack_size" id="pack_size" class="form-control col-sm-8" value="{{$demand['product']['pack_size']}}" readonly  style="width: 100%;">
                  </div>
                 </div> 


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Quantity</label>
                  <input type="number" form="ticket_form" min="1" value="{{$demand['qty']}}" name="qty" id="qty" class="form-control col-sm-8"  required style="width: 100%;">
                  </div>
                 </div>

                
                 

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea class="form-control col-sm-10" placeholder="Comment..." form="ticket_form" name="remarks">{{$demand['remarks']}}</textarea>
                  </div>
                 </div>


                

                 

                 
                 <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="activeness" value="1" id="activeness" class="" >&nbsp&nbspActive</label>
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

    var active="{{$demand['activeness']}}";
     if(active==1)
     $('#activeness').prop('checked',true);
   else if(active==0)
     $('#activeness').prop('checked',false);

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
  