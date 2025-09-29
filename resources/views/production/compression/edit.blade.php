
@extends('layout.master')
@section('title', 'Compression')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('compression/update')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Compression</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/compression')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/compression/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>

            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('print/compression/'.$compression['id'])}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>


          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Compression</li>
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
                <h3 class="card-title">Compression</h3>
              
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

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                <input type="hidden" form="ticket_form" value="{{$compression['id']}}" name="id"/>
                  

                
                

                <div class="row col-md-12 form-row">

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No</label>
                  <select class="form-control col-sm-8 select2" onchange="setPlanAtt()" form="ticket_form" name="plan_id" id="plan_id" required >
                    <option value="">------Select any value-----</option>
                    @foreach($plans as $plan)
                    <option value="{{$plan['id']}}">{{$plan['plan_no']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                  
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <input type="text" form="ticket_form" name="product_id" id="product_id" class="form-control col-sm-8" value="" readonly  style="width: 100%;">
                  </div>
                 </div>
                 
                
                   <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Batch No</label>
                  <input type="text" form="ticket_form" name="batch_no" id="batch_no" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Pack Size</label>
                  <input type="text" form="ticket_form" name="pro_pack_size" id="pro_pack_size" class="form-control  col-sm-8" value="" readonly  required style="width: 100%;">
                  </div>
                 </div>

                 

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Batch Size</label>
                  <input type="text" form="ticket_form" name="batch_size" id="batch_size" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Mfg Date</label>
                  <input type="date" form="ticket_form" name="mfg_date" id="mfg_date" class="form-control  col-sm-8" value=""   style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Exp Date</label>
                  <input type="date" form="ticket_form" name="exp_date" id="exp_date" class="form-control  col-sm-8" value="" style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Start Date & Time</label>
                  <input type="datetime-local" step="any" form="ticket_form" name="start_date" id="start_date" class="form-control  col-sm-8" value="{{ date('Y-m-d\TH:i', strtotime($compression['start_date'])) }}" onchange="setTotalTime()" required  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Completed Date & Time</label>
                  <input type="datetime-local" step="any" form="ticket_form" name="comp_date" id="comp_date" class="form-control  col-sm-8" value="{{ date('Y-m-d\TH:i', strtotime($compression['comp_date'])) }}" onchange="setTotalTime()" required style="width: 100%;">
                  </div>
                 </div>
                 

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Total Time</label>
                  <input type="text" form="ticket_form" name="total_time" id="total_time" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Lead Time</label>
                  <input type="text" form="ticket_form" name="lead_time" id="lead_time" class="form-control  col-sm-8" value="{{$compression['lead_time']}}" required  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Temprature (<sup>o</sup>C)</label>
                  <input type="number" step="any" form="ticket_form" name="temprature" id="temprature" class="form-control  col-sm-8" value="{{$compression['temprature']}}" required   style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Humidity (%)</label>
                  <input type="number" step="any" form="ticket_form" name="humidity" id="humidity" class="form-control  col-sm-8" value="{{$compression['humidity']}}" required  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Granuales Weight(kg)</label>
                  <input type="number" step="any" form="ticket_form" name="granules_weight" id="granules_weight" class="form-control  col-sm-8" value="{{$compression['granules_weight']}}" required  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Punch Size</label>
                  <input type="number" step="any" form="ticket_form" name="punch_size" id="punch_size" class="form-control  col-sm-8" value="{{$compression['punch_size']}}" required  style="width: 100%;">
                  </div>
                 </div>

                 <div class="bg-info p-1 m-1 col-sm-12">
                        <h3>Tablet Compression Start Up Analysis Sheet By QA</h3>
                    </div>

                    <table class="table table-bordered table-hover" style="width: 100%;"  id="" >
        <thead class="table-secondary">
           <tr>

             <th>Parameter</th>
             <th>Specifications</th> 
             <th>Observations</th>
             <th><button type="button" class="btn" onclick="AddPr()"><span class="fa fa-plus-circle text-success"></span></button></th>      
             
           </tr>
        </thead>
        <tbody id="parameters_body">
              
              <?php $pr_num=1; ?>
           @foreach($compression['start_up_analysis'] as $pr)
          <tr  id="{{'pr_'.$pr_num}}">
      
     <td><input type="text" form="ticket_form" id="{{'p_'.$pr_num}}" name="parameters[]" value="{{$pr['parameter']}}" class="form-control"  style="width: 100%;" ></td>

     <td><input type="text" form="ticket_form" id="{{'s_'.$pr_num}}" name="specifications[]" value="{{$pr['specifications']}}" class="form-control"  style="width: 100%;" ></td>

     <td><input type="text" form="ticket_form" id="{{'o_'.$pr_num}}" name="observations[]" value="{{$pr['observations']}}" class="form-control"  style="width: 100%;" ></td>
 

         <td><button type="button" class="btn" onclick="removePr(<?php echo $pr_num; ?>)"><span class="fa fa-minus-circle text-danger"></span></button><button type="button" class="btn" onclick="AddPr()"><span class="fa fa-plus-circle text-success"></span></button></td>

     </tr>
     <?php $pr_num++; ?>
    @endforeach

        
           <!-- <tr>
             
             <td><input type="text"  form="ticket_form" name="parameters[]"  id="" class="form-control" value=""  style="width: 100%;"></td>
             
            <td><input type="text"  form="ticket_form" name="observations[]"  id="" class="form-control" value=""  style="width: 100%;"></td>

            <td><input type="text"  form="ticket_form" name="specifications[]"  id="" class="form-control" value=""  style="width: 100%;"></td>
             
           </tr>
 -->    
           
          
        </tbody>
      </table>

                 <div class="bg-info p-1 m-1 col-sm-12">
                        <h3>A: Test of Friability</h3>
                    </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Initial Weight:</label>
                  <input type="number" step="any" form="ticket_form" name="initial_weight" id="initial_weight" class="form-control  col-sm-8" value="{{$compression['initial_weight']}}" required onchange="setFriability()" style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Final Weight:</label>
                  <input type="number" step="any" form="ticket_form" name="final_weight" id="final_weight" class="form-control  col-sm-8" value="{{$compression['final_weight']}}" required onchange="setFriability()" style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Result</label>
                  <input type="text" step="any" form="ticket_form" name="result" id="result" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                  
                   <div class="bg-info p-1 m-1 col-sm-12">
                        <h3>B: Weight Variation</h3>
                    </div>

          
                <table class="table table-bordered table-hover" style="width: 100%;"  id="" >
        <thead class="table-secondary">
           <tr>

             <th>Sr No</th>
             <th>Weight of Tablet</th> 
             <th>Sr No</th>
             <th>Weight of Tablet</th> 
             <th>Sr No</th>
             <th>Weight of Tablet</th> 
             <th>Sr No</th>
             <th>Weight of Tablet</th>             
             
           </tr>
        </thead>
        <tbody id="">
            <?php $ws=$compression->weights(); ?>
           @for($i=1;$i<=5;$i++)
           <tr>
             <td>{{$i}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  id="{{'weight_of_tablets_'.$i}}" class="form-control" value="{{$ws[$i-1]}}" onchange="checkWeight()" style="width: 100%;"></td>
             <td>{{$i+5}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  class="form-control" id="{{'weight_of_tablets_'.$i+5}}" value="{{$ws[$i+4]}}" onchange="checkWeight()" style="width: 100%;"></td>
             <td>{{$i+10}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  class="form-control" id="{{'weight_of_tablets_'.$i+10}}" value="{{$ws[$i+9]}}" onchange="checkWeight()" style="width: 100%;"></td>
             <td>{{$i+15}}</td>
             <td><input type="number" step="any" form="ticket_form" name="weight_of_tablets[]"  class="form-control" id="{{'weight_of_tablets_'.$i+15}}" value="{{$ws[$i+14]}}" onchange="checkWeight()" style="width: 100%;"></td>
           </tr>
          @endfor
           
          
        </tbody>
      </table>

               <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Recommended Weight:</label>
                  <input type="text" form="ticket_form" name="recommended_weight" id="recommended_weight" class="form-control  col-sm-8" value="{{$compression['recommended_weight']}}" required style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Lower Weight:</label>
                  <input type="text" form="ticket_form" name="lower_weight" id="lower_weight" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Upper Weight:</label>
                  <input type="text" form="ticket_form" name="upper_weight" id="upper_weight" class="form-control  col-sm-8" value=""  readonly style="width: 100%;">
                  </div>
                 </div>

                 <div class="bg-info p-1 m-1 col-sm-12">
                        <h3>C: Hardness</h3>
                    </div>


        <table class="table table-bordered table-hover" style="width: 100%;"  id="" >
        <thead class="table-secondary">
           <tr>

             <th>Sr No</th>
             <th>Hardness of Tablet (KP)</th> 
             <th>Sr No</th>
             <th>Hardness of Tablet (KP)</th>             
             
           </tr>
        </thead>
        <tbody id="">
            <?php $ws=$compression->hardness(); ?>
           @for($i=1;$i<=5;$i++)
           <tr>
             <td>{{$i}}</td>
             <td><input type="number" step="any" form="ticket_form" name="hardness_of_tablets[]"  id="{{'hardness_of_tablets_'.$i}}" class="form-control" value="{{$ws[$i-1]}}" onchange="checkHardnessAvg()" style="width: 100%;"></td>
             <td>{{$i+5}}</td>
             <td><input type="number" step="any" form="ticket_form" name="hardness_of_tablets[]"  class="form-control" id="{{'hardness_of_tablets_'.$i+5}}" value="{{$ws[$i+4]}}" onchange="checkHardnessAvg()" style="width: 100%;"></td>
           </tr>
          @endfor
           
          
        </tbody>
      </table>

               <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Average Hardness:</label>
                  <input type="text" form="ticket_form" name="average_hardness" id="average_hardness" class="form-control  col-sm-8" value="" readonly style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks:</label>
                  <input type="text" form="ticket_form" name="hardness_remarks" id="hardness_remarks" class="form-control  col-sm-8" value="{{$compression['hardness_remarks']}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="bg-info p-1 m-1 col-sm-12">
                        <h3>D: Thickness</h3>
                    </div>


        <table class="table table-bordered table-hover" style="width: 100%;"  id="" >
        <thead class="table-secondary">
           <tr>

             <th>Sr No</th>
             <th>Thickness (mm)</th> 
             <th>Sr No</th>
             <th>Thickness (mm)</th>             
             
           </tr>
        </thead>
        <tbody id="">
            <?php $ws=$compression->thickness(); ?>
           @for($i=1;$i<=5;$i++)
           <tr>
             <td>{{$i}}</td>
             <td><input type="number" step="any" form="ticket_form" name="thickness_of_tablets[]"  id="{{'thickness_of_tablets_'.$i}}" class="form-control" value="{{$ws[$i-1]}}" onchange="checkThicknessAvg()" style="width: 100%;"></td>
             <td>{{$i+5}}</td>
             <td><input type="number" step="any" form="ticket_form" name="thickness_of_tablets[]"  class="form-control" id="{{'thickness_of_tablets_'.$i+5}}" value="{{$ws[$i+4]}}" onchange="checkThicknessAvg()" style="width: 100%;"></td>
           </tr>
          @endfor
           
          
        </tbody>
      </table>

               <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Average Thickness:</label>
                  <input type="text" form="ticket_form" name="average_thickness" id="average_thickness" class="form-control  col-sm-8" value="" readonly style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks:</label>
                  <input type="text" form="ticket_form" name="thickness_remarks" id="thickness_remarks" class="form-control  col-sm-8" value="{{$compression['thickness_remarks']}}" required style="width: 100%;">
                  </div>
                 </div>

                 
                  
                
                <!--  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea class="form-control col-sm-10" placeholder="Comment..." form="ticket_form" name="remarks"></textarea>
                  </div>
                 </div> -->


                

                 

               
                 

                

               </div>
 

           <!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">In-Process Weigh Control Sheet</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabE">Container Detail</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabA">Yield Calculation</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;min-height:200px;">

  <div class="tab-pane fade show active" id="tabA">

      <div class="row">
       <div class="col-sm-4">
      <div class="form-group row">
        <label class="col-sm-4">Date:</label>
        <input type="date" form="ticket_form" name="weight_date" id="weight_date" class="form-control  col-sm-8" value="{{$compression['weight_date']}}" style="width: 100%;">
        </div>
       </div>

       <div class="col-sm-4">
      <div class="form-group row">
        <label class="col-sm-4">Start Time:</label>
        <input type="time" form="ticket_form" name="weight_start_time" id="weight_start_time" class="form-control  col-sm-8" value="{{$compression['weight_start_time']}}" style="width: 100%;">
        </div>
       </div>


<div class="col-sm-4">
      <div class="form-group row">
        <label class="col-sm-4">End Time:</label>
        <input type="time" form="ticket_form" name="weight_end_time" id="weight_end_time" class="form-control  col-sm-8" value="{{$compression['weight_end_time']}}" style="width: 100%;">
        </div>
       </div>
 

 <div class="col-sm-4">
      <div class="form-group row">
        <label class="col-sm-4">Size of Tablet:</label>
        <input type="text" form="ticket_form" name="weight_tab_size" id="weight_tab_size" class="form-control  col-sm-8" value="{{$compression['weight_tab_size']}}" style="width: 100%;">
        </div>
       </div>

       <div class="col-sm-4">
      <div class="form-group row">
        <label class="col-sm-4">Limit:</label>
        <input type="text" form="ticket_form" name="weight_limit" id="weight_limit" class="form-control  col-sm-8" value="{{$compression['weight_limit']}}" style="width: 100%;">
        </div>
       </div>
  
  </div>

     <div class="table-responsive p-0" style="height: 400px;">
    <table class="table table-bordered table-hover" style="width: 100%;"  id="" >
        <thead class="table-secondary">
           <tr>

             <th>Date</th>
             <th>Time</th> 
              @for($i=1;$i<=10;$i++)
              <th>{{$i}}</th>
              @endfor
             <th>Average</th>
             <th style="min-width: 120px;"><button type="button" class="btn" onclick="AddWeight()"><span class="fa fa-plus-circle text-success"></span></button></th>      
             
           </tr>
        </thead>
        <tbody id="control_sheet_body">
           
          <?php  $we_row=1;  ?>
        
           @foreach($compression['control_sheet'] as $con)
           <tr id="{{'control_'.$we_row}}">
             
             <td><input type="date"  form="ticket_form" name="control_dates[]"  id="" class="form-control" value="{{$con['date']}}"  style="width: 100%;"></td>
             
            <td><input type="time"  form="ticket_form" name="control_times[]"  id="" class="form-control" value="{{$con['time']}}"  style="width: 100%;"></td>
            <?php  $avg=0;  ?>
            @for($i=1;$i<=10;$i++)

              <td><input type="number" step="any"  form="ticket_form" name="{{'control_'.$i.'_weights'}}[]"  id="{{'control_'.$we_row.'_'.$i.'_weight'}}" class="form-control" value="{{$con['num'.$i]}}" onchange="set_avg('{{$we_row}}')" style="width: 100%;min-width: 80px;"></td>
              <?php  
                if($con['num'.$i] !='')
              $avg=$avg + $con['num'.$i];  ?>
              @endfor
              <?php  $avg=$avg / 10;  ?>

            <td><input type="text"  form="ticket_form" name="control_avgs[]"  id="{{'control_avg_'.$we_row}}" class="form-control" value="{{$avg}}" readonly  style="width: 100%;"></td>

            <td><button type="button" class="btn" onclick="RemoveWeight('{{$we_row}}')"><span class="fa fa-minus-circle text-danger"></span></button><button type="button" class="btn" onclick="AddWeight()"><span class="fa fa-plus-circle text-success"></span></button></td>  
             
           </tr>
           <?php  $we_row++; ?>
            @endforeach
           
          
        </tbody>
      </table>
      </div>



   </div><!--end TabA-->

     <div class="tab-pane fade" id="tabE">

      <div class="row">
              <div class="col-md-12">
                
                 <fieldset class="border p-4">
                   <legend class="w-auto">Add</legend>

              
    
    <div id="item_add_error" style="display: none;"><p class="text-danger" id="item_add_error_txt"></p></div>
      
                   
                   <div class="row">

                    


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Container No</label>
                  <input type="number"  form="add_item" name="no" id="no" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Gross Weight (kg)</label>
                  <input type="number" step="any" form="add_item" name="gross" id="gross" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Tare Weight (kg)</label>
                  <input type="number" step="any" form="add_item" name="tare" id="tare" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Net Weight (kg)</label>
                  <input type="number" step="any" form="add_item" name="net" id="net" class="form-control" value=""  style="width: 100%;">
                </div>
              </div>


            <div class="col-md-2">
                    <div class="form-group">
                  <label>Performed By</label>
                  <input type="text"  form="add_item" name="performed_by" id="performed_by" class="form-control" value=""  style="width: 100%;">
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

              


</div> <!--end row-->



                 </fieldset>
              </div>
            </div>


     <div class="table-responsive">
      <table class="table table-bordered table-hover "  id="item_table" >
        <thead class="table-secondary">
           <tr>

             <th>Container #</th>
            
             <th>Gross Weight (kg)</th>
             <th>Tare Weight (kg)</th>
             <th>Net Weight (kg)</th>
             <th>Performed By</th>
             
             <th></th>
           </tr>
        </thead>
        <tbody id="selectedItems">

           
        <?php $row=1; ?>
        
             @foreach($compression['containers'] as $item)
          <tr ondblclick="(editItem(<?php echo $row; ?>))" id="{{$row}}">
      
      
    <input type="hidden" form="ticket_form" id="{{'no_'.$row}}" name="no[]" value="{{$item['no']}}" readonly >
     <input type="hidden" form="ticket_form" id="{{'gross_'.$row}}" name="gross[]" value="{{$item['gross']}}" readonly >
     
     
     <input type="hidden" form="ticket_form" id="{{'tare_'.$row}}" name="tare[]"  value="{{$item['tare']}}" >
     <input type="hidden" form="ticket_form" id="{{'net_'.$row}}" name="net[]" value="{{$item['net']}}" readonly >
     
     
     <input type="hidden" form="ticket_form" id="{{'performed_by_'.$row}}" name="performed_by[]"  value="{{$item['performed_by']}}" >
     
    
    
     <td id="{{'no1_'.$row}}">{{$item['no']}}</td>
    
       <td id="{{'gross1_'.$row}}">{{$item['gross']}}</td>
     <td id="{{'tare1_'.$row}}">{{$item['tare']}}</td>
    <td id="{{'net1_'.$row}}">{{$item['net']}}</td>
     <td id="{{'performed_by1_'.$row}}">{{$item['performed_by']}}</td>

    
        
     

         <td><button type="button" class="btn" onclick="removeItem(<?php echo $row; ?>)"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>
              <?php $row+=1;  ?>
     @endforeach
        
           
          
        </tbody>
        <tfoot>
          <tr>
           
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th id="net_qty"></th>
             <th></th>
           </tr>
        </tfoot>
      </table>
    </div>

      
    </div> <!-- End TabE  -->
   
    <div class="tab-pane fade show active" id="tabA">
    </div><!-- End TabA  -->
   

   
</div>
<!-- End Tabs -->
      

                



              
                  
                  
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
var row_num=<?php echo $row ?>;
var pr_num=<?php echo $pr_num ?>;
var we_num="{{$we_row}}";

function getRowNum()
 {
  return this.row_num;
}
function setRowNum()
 {
   this.row_num+=1;
}

function getPrNum()
 {
  return this.pr_num;
}
function setPrNum()
 {
   this.pr_num+=1;
}

function getWeNum()
 {
  return this.we_num;
}

function setWeNum()
 {
   this.we_num+=1;
}
  

  $(document).ready(function(){

$('.select2').select2(); 

var plan_id="{{$compression['plan_id']}}";
$('#plan_id').val(plan_id);
$('#plan_id').trigger('change');

setTotalTime();
checkWeight();
setFriability();
checkThicknessAvg();
checkHardnessAvg();
setNetQty();

$('#ticket_form').submit(function(e) {

     e.preventDefault();
//alert(this.row_num);
var row_num=getRowNum();

for (var i =1; i <= row_num ;  i++)
{
if ($(`#gross_${i}`). length > 0 )
     {
        $('#std_error_txt').html('');
               this.submit();
               return ;
      }
  }

             
               $('#std_error').show();
               $('#std_error_txt').html('Add weight detail!');



  });

});

  function checkThicknessAvg()
{   
     
  var avg=0;

  for (var i = 1; i <= 10; i++) {

      var we=$(`#thickness_of_tablets_${i}`).val();
      if(we=='')
         continue ;

      avg= parseFloat(we) + parseFloat(avg);
  }


      avg= avg / 10 ;
          avg =avg.toFixed(3);
      $(`#average_thickness`).val(avg);
      
}

  function checkHardnessAvg()
{   
     
  var avg=0;

  for (var i = 1; i <= 10; i++) {

      var we=$(`#hardness_of_tablets_${i}`).val();
      if(we=='')
         continue ;

      avg= parseFloat(we) + parseFloat(avg);
  }


      avg= avg / 10 ;
          avg =avg.toFixed(3);
      $(`#average_hardness`).val(avg);
      
}

function checkWeight()
{    
  var low=0, up=0;

  for (var i = 1; i <= 20; i++) {

      var we=$(`#weight_of_tablets_${i}`).val();
      if(we=='')
         continue ;

      low=we; up=we; 
      break;
  }


  for (var i = 2; i <= 20; i++) {
      var we=$(`#weight_of_tablets_${i}`).val();
      if(we=='')
         continue ;
      if(parseFloat( we) < parseFloat(low))
        low=we;

      if(parseFloat(we) > parseFloat(up))
        up=we;
  }

      $(`#upper_weight`).val(up);
      $(`#lower_weight`).val(low);
}

function setFriability()
{
   var qty=$(`#initial_weight`).val();
   var qty1=$(`#final_weight`).val();
   

   if(qty=='' || qty==null)
        qty=0;

      if(qty1=='' || qty1==null)
        qty1=0;

     

      var t= parseFloat( qty )- parseFloat( qty1 ) ; 
       var t1= ( parseFloat(t) / parseFloat( qty )) * 100 ; 
         t1=t1.toFixed(3) + ' %';
    $(`#result`).val(t1); 
     
}

function setLoss()
{
   var qty=$(`#batch_qty`).val();
   var qty1=$(`#actual_qty`).val();
   var qty2=$(`#qa_sample`).val();
   var qty3=$(`#qc_sample`).val();

   if(qty=='' || qty==null)
        qty=0;

      if(qty1=='' || qty1==null)
        qty1=0;

      if(qty2=='' || qty2==null)
        qty2=0;

      if(qty3=='' || qty3==null)
        qty3=0;

      var t= parseFloat( qty3 )+parseFloat( qty2 ) + parseFloat( qty1 ); 
       var t1= ( parseFloat(t) / parseFloat( qty )) * 100 ; 
    
    $(`#yield`).val(t1); 
     var l= 100 - t1 ;
     $(`#loss`).val(l);
}

  



function setPlanAtt()
{
   var id=$("#plan_id").val();
     if(id=='')
      return ;

   var plans=<?php echo json_encode($plans); ?> ;
                 
                 let point = plans.findIndex((item) => item.id == id);
              var plan=plans[point];

         
         $("#product_id").val(plan['product_name']);
        $("#batch_size").val(plan['batch_size']);
        $("#batch_qty").val(plan['batch_qty']);
        $("#batch_no").val(plan['batch_no']);
        $("#mfg_date").val(plan['mfg_date']);
        $("#exp_date").val(plan['exp_date']);
         $("#pro_pack_size").val(plan['pack_size']);
          

          var prs=plan['parameters']; 
         
            var txt='';

    for (var i =0; i < prs.length ;  i++) { 
      var row=getPrNum();

     txt=txt + `
     <tr  id="pr_${row}">
      
     <td><input type="text" form="ticket_form" id="p_${row}" name="parameters[]" value="${prs[i]['name']}" class="form-control"  style="width: 100%;" ></td>

     <td><input type="text" form="ticket_form" id="s_${row}" name="specifications[]" value="${prs[i]['description']}" class="form-control"  style="width: 100%;" ></td>

     <td><input type="text" form="ticket_form" id="o_${row}" name="observations[]" value="" class="form-control"  style="width: 100%;" ></td>
 

         <td><button type="button" class="btn" onclick="removePr(${row})"><span class="fa fa-minus-circle text-danger"></span></button><button type="button" class="btn" onclick="AddPr()"><span class="fa fa-plus-circle text-success"></span></button></td>

     </tr>`;
        setPrNum();
    } 
   

    $("#parameters_body").append(txt);

         

}

function setNetQty() //for end of tabel to show net
{
  var rows=this.row_num;
   var  net_gross=0 , net_tare=0, net_net=0 ;   
   for (var i =1; i <= rows ;  i++) {
   
     if ($(`#gross_${i}`). length > 0 )
     { 
       
       var qty=$(`#gross_${i}`).val();
       var qty1=$(`#tare_${i}`).val();
       var qty2=$(`#net_${i}`).val();

      // if(qty=='' || qty==null)
      //   qty=0;
      
         net_gross +=  parseFloat (qty) ;
         net_tare +=  parseFloat (qty1) ;
         net_net +=  parseFloat (qty2) ;

        
      }
       

   }

    net_gross =  net_gross.toFixed(2) ;
    net_tare =  net_tare.toFixed(2) ;
    net_net =  net_net.toFixed(2) ;

   $(`#net_gross`).text(net_gross);
   $(`#net_tare`).text(net_tare);
   $(`#net_net`).text(net_net);

     
    setLoss();
}




function addItem()
{
  var no=$("#no").val();
  var gross=$("#gross").val();
  var tare=$("#tare").val();
  var net=$("#net").val();
  var performed_by=$("#performed_by").val();
   
  
       
     if(gross=='' || tare=='' || net=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(gross=='')
           {
                err_name='Gross Weight is required.';
           }

           if(tare=='')
           {
                err_dbl='Tare Weight is required.';
           }
           
           if(net=='')
           {
            err_qty='Net Weight is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_qty);

     }
     else
     {
      
        
     var row=getRowNum();   


     var txt=`
     <tr ondblclick="(editItem(${row}))" id="${row}">
      
     <input type="hidden" form="ticket_form" id="no_${row}" name="no[]" value="${no}" readonly >

     <input type="hidden" form="ticket_form" id="gross_${row}" name="gross[]" value="${gross}" readonly >
     
     <input type="hidden" form="ticket_form" id="tare_${row}" name="tare[]"  value="${tare}" >
     <input type="hidden" form="ticket_form" id="net_${row}" name="net[]"  value="${net}" >
     <input type="hidden" form="ticket_form" id="performed_by_${row}" name="performed_by[]"  value="${performed_by}" >
     
     
     <td id="no1_${row}">${no}</td>
   
  
       <td id="gross1_${row}">${gross}</td>
     <td id="tare1_${row}">${tare}</td>
     <td id="net1_${row}">${net}</td>
     <td id="performed_by1_${row}">${performed_by}</td>
    
     

         <td><button type="button" class="btn" onclick="removeItem(${row})"><span class="fa fa-minus-circle text-danger"></span></button></td>
     </tr>`;
    
     
   

    $("#selectedItems").append(txt);


  
  $("#no").val('');
  $("#gross").val('');
  $("#net").val('');
  $("#tare").val('');

 

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');

  
          setNetQty();
           setRowNum();
   
   }
     
}//end add item

function updateItem(row)
{
  var no=$("#no").val();
  var gross=$("#gross").val();
  var tare=$("#tare").val();
  var net=$("#net").val();
  var performed_by=$("#performed_by").val();
   
  
       
     if(gross=='' || tare=='' || net=='' )
     {
        var err_name='',err_qty='',err_dbl='';
           
           if(gross=='')
           {
                err_name='Gross Weight is required.';
           }

           if(tare=='')
           {
                err_dbl='Tare Weight is required.';
           }
           
           if(net=='')
           {
            err_qty='Net Weight is required.';
           }



           $("#item_add_error").show();
           $("#item_add_error_txt").html(err_dbl+' '+err_name+' '+err_qty);

     }
          else
     {
     
    
       $(`#no_${row}`).val(no);
       $(`#gross_${row}`).val(gross);
        $(`#tare_${row}`).val(tare);
      $(`#net_${row}`).val(net);
      $(`#performed_by_${row}`).val(performed_by);

      $(`#no1_${row}`).text(no);
       $(`#gross1_${row}`).text(gross);
        $(`#tare1_${row}`).text(tare);
      $(`#net1_${row}`).text(net);
      $(`#performed_by1_${row}`).text(performed_by);


            
   $("#no").val('');
  $("#gross").val('');
  $("#net").val('');
  $("#tare").val('');
   $("#performed_by").val('');


   

$('#row_id').val('');

  $("#item_add_error").hide();
           $("#item_add_error_txt").html('');
 
   setNetQty();
  $('#add_item_btn').attr('onclick', `addItem()`);
  
   
   }
     
}  //end update item


function editItem(row)
{
   
  var no=$(`#no1_${row}`).text();
  $('#no').val(no);

  var unit=$(`#gross1_${row}`).text();
  $('#gross').val(unit);

  var qty=$(`#tare1_${row}`).text();
$('#tare').val(qty);

 var p_s=$(`#net1_${row}`).text();
$('#net').val(p_s);

 var total=$(`#performed_by1_${row}`).text();
$('#performed_by').val(total);



  $('#row_id').val(row);

  $('#add_item_btn').attr('onclick', `updateItem(${row})`);
   
  
  

}

function removeItem(row)
{
  
    $(`#${row}`).remove();
    setNetQty();
  

}

function setTotalTime()
{
   var t=$(`#start_date`).val();
   var t1=$(`#comp_date`).val();


   if(t=='' || t1=='')
        return ;
      //diff=t1 -  t;
        diff=get_timeDifference(t,t1);
        
        $(`#total_time`).val(diff);
       

}

 function get_timeDifference(strtdatetime,enddatetime) {
    var datetime = new Date(strtdatetime).getTime();

    var now = new Date(enddatetime).getTime();
    //var now = new Date().getTime();

    if (isNaN(datetime)) {
        return "";
    }

    //console.log(datetime + " " + now);

    if (datetime < now) {
        var milisec_diff = now - datetime;
    } else {
        var milisec_diff = datetime - now;
    }

    var days = Math.floor(milisec_diff / 1000 / 60 / (60 * 24));

    var date_diff = new Date(milisec_diff);





    var msec = milisec_diff;
    var hh = Math.floor(msec / 1000 / 60 / 60);
    msec -= hh * 1000 * 60 * 60;
    var mm = Math.floor(msec / 1000 / 60);
    msec -= mm * 1000 * 60;
    var ss = Math.floor(msec / 1000);
    msec -= ss * 1000


    var daylabel = "";
    if (days > 0) {
        var grammar = " ";
        if (days > 1) grammar = "s " 
        var hrreset = days * 24;
        hh = hh - hrreset;
        daylabel = days + " Day" + grammar ;
    }


    //  Format Hours
    var hourtext = '00';
    hourtext = String(hh);
    if (hourtext.length == 1) { hourtext = '0' + hourtext };
     
     if(hourtext=='00')
      hourtext='';
    else
      hourtext=hourtext + " hours ";

    //  Format Minutes
    var mintext = '00';
    mintext = String(mm); 
    if (mintext.length == 1) { mintext = '0' + mintext };

    //  Format Seconds
    var sectext = '00';
    sectext = String(ss); 
    if (sectext.length == 1) { sectext = '0' + sectext };

    var msectext = '00';
    msectext = String(msec);
    msectext = msectext.substring(0, 1);
    if (msectext.length == 1) { msectext = '0' + msectext };

     return daylabel + hourtext  + mintext + " min " ;
    //return daylabel + hourtext + ":" + mintext + ":" + sectext + ":" + msectext;
}

function removePr(row)
{
    $(`#pr_${row}`).remove();
  

}

function AddPr()
{
    
      var row=getPrNum();

     var txt= `
     <tr  id="pr_${row}">
      
     <td><input type="text" form="ticket_form" id="p_${row}" name="parameters[]" value="" class="form-control"  style="width: 100%;" ></td>

     <td><input type="text" form="ticket_form" id="s_${row}" name="specifications[]" value="" class="form-control"  style="width: 100%;" ></td>

     <td><input type="text" form="ticket_form" id="o_${row}" name="observations[]" value="" class="form-control"  style="width: 100%;" ></td>
 

         <td><button type="button" class="btn" onclick="removePr(${row})"><span class="fa fa-minus-circle text-danger"></span></button><button type="button" class="btn" onclick="AddPr()"><span class="fa fa-plus-circle text-success"></span></button></td>

     </tr>`;
        setPrNum();
     
   

    $("#parameters_body").append(txt);


}

function set_avg(row)
{
   var avg=0;
    for (var i = 1; i <= 10; i++) {
       var v=$(`#control_${row}_${i}_weight`).val();
       if(v=='')
        continue;
      avg = parseFloat(avg) + parseFloat( v);
    }
  
    avg= avg /10;
    $(`#control_avg_${row}`).val(avg);
}

function RemoveWeight(row)
{
    $(`#control_${row}`).remove();
  

}

function AddWeight()
{
    
      var row=getWeNum();

      var t=` `;

              for (var i = 1; i <= 10; i++) {
                t=t + `
              <td><input type="number" step="any"  form="ticket_form" name="control_${i}_weights[]"  id="control_${row}_${i}_weight" class="form-control" value="" onchange="set_avg(${row})" style="width: 100%;min-width: 80px;"></td>
               `;

              }

     var txt= `
     <tr id="control_${row}">
             
             <td><input type="date"  form="ticket_form" name="control_dates[]"  id="" class="form-control" value=""  style="width: 100%;"></td>
             
            <td><input type="time"  form="ticket_form" name="control_times[]"  id="" class="form-control" value=""  style="width: 100%;"></td>

            ${t}

            <td><input type="text"  form="ticket_form" name="control_avgs[]"  id="control_avg_${row}" class="form-control" value="" readonly  style="width: 100%;"></td>

            <td><button type="button" class="btn" onclick="RemoveWeight(${row})"><span class="fa fa-minus-circle text-danger"></span></button><button type="button" class="btn" onclick="AddWeight()"><span class="fa fa-plus-circle text-success"></span></button></td> 
     `;
        setWeNum();
     
   

    $("#control_sheet_body").append(txt);


}
  
</script>





@endsection  
  