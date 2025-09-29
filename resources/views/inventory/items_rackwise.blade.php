
@extends('layout.master')
@section('title', 'Items Stock')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Items Stock</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('#')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Items</a></li>
              <li class="breadcrumb-item active">Rackwise</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          <?php
                 $depart='';  $f=''; $t='';

                if(isset($department))
                  $depart=$department;

                if(isset($from))
                  $f=$from;

                if(isset($to))
                  $t=$to;
             ?>

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Items</h3>

                 <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('print/items-stock/?location='.$depart.'&from='.$f.'&to='.$t)}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <form role="form" id="item_history_form" method="get" action="{{url('/items-rackwise')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    <!---<div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" name="location" id="location" style="width: 100%;">
                    <option value="">Select any department</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>-->

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Categories</label>
                  <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;">
                    <option value="">Select any category</option>
                    @foreach($categories as $depart)
                    <option value="{{$depart['id']}}" {{ request('category_id') == $depart['id'] ? 'selected' : '' }} >{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                  

          <!--- <div class="col-md-2">
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
              </div>-->


                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="Search">
                     </div>


                    </div>

                 </fieldset>
                 </form>

               

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>No.</th>
                    <th>Category</th>
                  
                    <th>Item name</th>
                    <th>Rack</th>
                    <th>Rack Qty</th>
                  
                    <!----<th>Production Qty</th>
                    
                    <th>Issue Qty</th>-->
                    <th>Total Qty</th>

                    
                    <!---<th>Closing</th>
                    <th>Current Balance</th>-->
                   
                  </tr>

                  
                   <?php $i=1; ?>
                    @foreach($items as $item) 

                     <?php

                              $rackStock = $item->closingStockByRack();

                               $rack = implode(',', array_keys($rackStock));     
                                 $rack_qty = implode(',', array_values($rackStock));

                                $qty = $item->closingStock();
                     ?>
                      
                        <tr>
                   
                     <td>{{$i}}</td>
                    
                     <td>{{$item['category_name']}}</td>
                    <td>{{$item['item_name']}}</td>
                      <td>{{$rack}}</td>
                     <td>{{$rack_qty}}</td>
                     <!--- <td></td>
                     <td></td>-->
                     <td>{{$qty}}</td>
                     <!--<td></td>

                        
                     <td>
                      
                    </td>-->
                    
                     
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
  