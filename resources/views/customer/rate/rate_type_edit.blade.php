
@extends('layout.master')
@section('title', 'Edit Rate Type')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

    <form role="form" id="type" method="POST" action="{{url('/configure/rate/type/update')}}" onkeydown="return event.key != 'Enter';" >
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$type['id']}}" name="id"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Rate Type Edit</h1>
            <button form="type" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('/configure/rate')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/configure/rates')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Customer</a></li>
              <li class="breadcrumb-item active">Edit Rate Type</li>
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
                <h3 class="card-title">Rate Type</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    

                  <div class="col-md-3">
        <label>Text</label>
        <input class="form-control"  name="text" id="text" value="{{$type['text']}}" placeholder="e.g. Trading, Promotion etc" required>
           </div>

                    
                    

                    </div>

                 </fieldset>
          

                  
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                    
                  <tr>             
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Item name</th>
                 <!--  <th>Bussiness Typ</th> -->
                    <th>Rate</th>
                 
                    
                  </tr>
                 </thead>
                  <tbody>

                  <?php $i=1; $its=$type['item_list'];  ?>
                  @foreach($products as $record)
                 
                  
                  <tr>
                  
              <td>{{$i}}<input type="hidden" name="items_id[]" form="type" value="{{$record['id']}}"></td>
                   <td>{{$record['item_code']}}</td>
                   <td>{{$record['item_name']}}</td>
                      <?php 
                      $rate='';
                      $t=$its->where('item_id',$record['id'])->first();
                      if($t!='')
                      $rate=$t->value;
                       
                       // if(isset($t->bt))
                       // $bt=$t->bt;
                       //  else
                       //    $bt='tp_percent';
                        
                       // $f=''; $p='';
                       // if($bt=='flat_rate')
                       //  $f='selected';
                       //  elseif($bt=='tp_percent')
                       //    $p='selected';
                       ?>

                       <!-- <td>
                         <select name="bts[]" form="type" >
                        <option value="tp_percent" >Percentage on Tp</option>
                       <option value="flat_rate" >Flat rate</option>
                     </select>
                       </td>
 -->                   <td><input type="number" form="type" step="any" name="values[]" value="{{$rate}}"></td>
               
                   
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  
                  
                  </tbody>
                  <tfoot>
                    
                  
                  </tfoot>
                </table>
                

              
                  
                  
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
  
  
    

  
   
});

 





</script>
@endsection  
  