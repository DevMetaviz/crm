
@extends('layout.master')
@section('title', 'Costing')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Ticket/Batch Costing</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Batch</a></li>
              <li class="breadcrumb-item active">Costing</li>
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
                <h3 class="card-title">Costing</h3>
                 
                
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                
              <div class="row">
                  
                  <div class="col-md-5">
                  
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <div class="form-row">

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Ticket No.</label>
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$ticket['ticket_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Ticket Date</label>
                  <input type="date" form="ticket_form" name="ticket_date" class="form-control select2 col-sm-8" value="{{$ticket['ticket_date']}}"  required style="width: 100%;">
                  </div>
                </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" class="form-control select2 col-sm-8" value="{{$ticket['batch_no']}}" required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="number" form="ticket_form" name="batch_size" id="batch_size" class="form-control select2 col-sm-8" value="{{$ticket['batch_size']}}" required readonly style="width: 100%;">
                  </div>
                </div>

                <!-- <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="purchase_demand" name="default" value="default" id="default" class=""  checked>&nbsp&nbspDefault</label>
                  </div>
                </div> -->


               

              </div><!--end form row-->

              </fieldset>

                                
                <!-- /.form-group -->

               
                
              </div>
              <!-- /.col -->

                </div> <!--end row-->


                <!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#material">Material Cost</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Expense</a></li> 
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC">Terms</a></li>
        
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="material">
       
       <table class="table table-bordered table-hover "  id="" >
        <thead class="table-secondary">
           <tr>

             <th>#</th>
             <th>Location</th>
             <th>Code</th>
             <th>Item</th>
             <th>UOM</th>
             <th>Qty</th>
             <th>Rate</th>
             <th>Amount</th>
           </tr>
        </thead>
        <tbody id="">
          <?php $item_net_total=0; ?>
     @foreach($ticket['issued_items'] as $item)
  
     <br>
         <?php 
              $qty=$item['quantity']*$item['pack_size'];

              $rate=$item['rate'];

              $total=round($rate * $qty , 2);
                $item_net_total  = $item_net_total + $total;
           ?>
        <tr>
              <td></td>
              <td>{{$item['item']['department']['name']}}</td>
              <td>{{$item['item']['item_code']}}</td>
              <td>{{$item['item']['item_name']}}</td>
              <td>@if($item['item']['unit']!=''){{$item['item']['unit']['name']}}@endif</td>
              <td>{{$qty}}</td>
              <td>{{$rate}}</td>
              <td>{{$total}}</td>

        </tr>
     @endforeach

   </tbody>

      <tfoot>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th id="item_net_total">{{$item_net_total}}</th>
      </tfoot>
 </table>
        
    </div>
     <div class="tab-pane fade" id="tabB">

     
      
    </div> 

    <div class="tab-pane fade" id="tabC">

      
    </div>
     

    

    
</div>
<!-- End Tabs -->
                 

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')


<script type="text/javascript">

$(document).ready(function(){
  
 
     
      

  
   
});

 





</script>
@endsection  
  