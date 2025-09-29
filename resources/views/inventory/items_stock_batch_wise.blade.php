
@extends('layout.master')
@section('title', 'Items Stock')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Items Stock  Batch Wise</h1>
           <!--  <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('#')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Items</a></li>
              <li class="breadcrumb-item active">Stock</li>
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
                <h3 class="card-title">Stock List</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <form role="form" id="item_history_form" method="get" action="{{url('/items-stock-batch-wise')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    <div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" name="location" id="location" style="width: 100%;">
                    <option value="">Select any department</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                  

           <div class="col-md-2">
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
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Select</label>
                  <select class="form-control select2" name="expired" id="expired" style="width: 100%;">
                    <option value="">Select</option>
                    <option value="expired">Expired</option>
                    <option value="near_expiry">Near Expiry</option>
                    
                  </select>
                </div>
              </div>


                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="Search">
                     </div>


                    </div>

                 </fieldset>
                 </form>

        
                @if(isset($department))
                @if($department==1)
                  <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>No.</th>
                    
                  
                    <th>Item Discription</th>
                    <th>Batch No</th>
                    <th>Expiry Date</th>
                    <th>Opening</th>
                    <!-- <th>Total</th> -->
                    <th>Production</th>
                    <th>Sale Qty</th>
                  
                    <th>Sale Return</th>
                    
                    
                

                    
                    <th>Closing</th>
                    <!-- <th>Total</th> -->
                  
                   
                  </tr>

                  
                   <?php $i=1; ?>
                    @foreach($items as $item) 

                      <tr>
                         <?php $no=count($item['stocks']); 

                         if($no==0)
                             continue; 
                          ?>

                     
                     

                     @if($no==0)

                     <td>{{$i}}</td>
                    
                    
                    <td>{{$item['item_name']}}</td>

                        <td> - </td>
                        <td></td>
                      <td>0</td>
                      <td></td>
                     <td></td>
                      <td></td>
                                         
                     <td>0</td>

                     @else

                     <td rowspan="{{$no}}">{{$i}}</td>
                    
                    
                    <td rowspan="{{$no}}">{{$item['item_name']}}</td>

                     <?php $k=1; ?>
                     @foreach($item['stocks'] as $stk) 
                      
                      @if($k!=1)
                      <tr>
                        @endif
                        
                    <td>@if(isset($stk['batch_no'])){{$stk['batch_no']}}@endif</td>
                    <td>@if(isset($stk['exp_date'])){{$stk['exp_date']}}@endif</td>
                      <td>{{$stk['opening_qty']}}</td>
                      <td>
                      @if(isset($stk['production']))
                      {{$stk['production']}}
                      @elseif(isset($stk['purchase_qty']))
                      {{$stk['purchase_qty']}}
                      @endif
                    </td>
                     <td>
                      @if(isset($stk['dc_qty']))
                      {{$stk['dc_qty']}}
                      @endif
                     </td>
                      <td>
                      @if(isset($stk['sale_return_qty']))
                      {{$stk['sale_return_qty']}}
                      @endif
                    </td>
                                         
                     <td>{{$stk['closing_qty']}}</td>

                     @if($k!=1)
                      </tr>
                        @endif
                     
                     <?php $k++; ?>
                    @endforeach

                     @endif

                    </tr>
                   
                       <?php $i++; ?>
                    @endforeach
                
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
                </table>

                @else   


                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>No.</th>
                    <th>Item Discription</th>
                    <th>Grn No</th>
                    <th>Expiry Date</th>
                    <th>Opening</th>
                    <th>Purchase Qty</th>
                    <th>Issue Qty</th>
                    <th>Purchase Return</th>
                    <th>Closing</th>
                  </tr>

                  
                   <?php $i=1; ?>
                    @foreach($items as $item) 

                      <tr>
                         <?php $no=count($item['stocks']); ?>

                     
                     

                     @if($no==0)

                     <td>{{$i}}</td>
                    
                    
                    <td>{{$item['item_name']}}</td>

                        <td> - </td>
                        <td></td>
                      <td>0</td>
                      <td></td>
                     <td></td>
                      <td></td>                
                     <td>0</td>

                     @else

                     <td rowspan="{{$no}}">{{$i}}</td>
                    
                    
                    <td rowspan="{{$no}}">{{$item['item_name']}}</td>

                     <?php $k=1; ?>
                     @foreach($item['stocks'] as $stk) 
                      
                      @if($k!=1)
                      <tr>
                        @endif
                        
                    <td>{{$stk['grn_no']}}</td>
                    <td>{{$stk['exp_date']}}</td>
                      <td>{{$stk['opening_qty']}}</td>
                       <td>{{$stk['purchase_qty']}}</td>
                      <td>{{$stk['issue_qty']}}</td>
                     <td>{{$stk['purchase_return_qty']}}</td>
                                                              
                     <td>{{$stk['closing_qty']}}</td>

                     @if($k!=1)
                      </tr>
                        @endif
                     
                     <?php $k++; ?>
                    @endforeach

                     @endif

                    </tr>
                   
                       <?php $i++; ?>
                    @endforeach
                
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
                </table>


               @endif

                
            @else
              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>No.</th>
                    <th>Location</th>
                  
                    <th>Item Discription</th>
                    <th>Stocks</th>
                    <th>Opening</th>
                    <th>Purchase Qty</th>
                  
                    <th>Production Qty</th>
                    
                    <th>Issue Qty</th>
                    <th>Sale Qty</th>

                    
                    <th>Closing</th>
                    <th>Current Balance</th>
                   
                  </tr>

                  
                   <?php $i=1; ?>
                    @foreach($items as $item) 

          
                      
                        <tr>
                   
                     <td>{{$i}}</td>
                    
                     <td>{{$item['location']}}</td>
                    <td>{{$item['item_name']}}</td>
                    <td>
                      @foreach($item['stocks'] as $st)
                      {{json_encode($st)}}
                      @endforeach
                    </td>
                      <td>{{$item['opening']}}</td>
                     <td>{{$item['detail']['grn_qty']}}</td>
                      <td>{{$item['detail']['production_qty']}}</td>
                     <td>{{$item['detail']['issue_qty']}}</td>
                     <td>{{$item['detail']['dc_qty']}}</td>
                     <td>{{$item['closing']}}</td>

                        <?php 
                           $status=$item['status'];
                           


                         ?>
                     <td>
                      @if($status=='minimal')
                      <span class="bg-danger p-1">{{$item['current_balance']}}</span>
                      @elseif($status=='maximal')
                      <span class="bg-success p-1">{{$item['current_balance']}}</span>
                      @elseif($status=='optimal')
                      <span class="bg-info p-1">{{$item['current_balance']}}</span>
                      @else
                      <span class="p-1">{{$item['current_balance']}}</span>
                      @endif
                    </td>
                    
                     
                    </tr>
                   <!--  <tr><td colspan="8"></td></tr> -->
                       <?php $i++; ?>
                    @endforeach
                
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
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

<script type="text/javascript">

$(document).ready(function(){

@if($department!='')
$('#location').val(<?php echo json_encode($department) ?>);
@endif

});

</script>

@endsection  
  