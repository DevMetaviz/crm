
@extends('layout.master')
@section('title', 'Investment')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('save/investment')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Investment</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('investment/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Doctor</a></li>
              <li class="breadcrumb-item active">Investment</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <!-- <div class="card"> -->
              <!-- <div class="card-header"> -->
                <!-- <h3 class="card-title">Return Note</h3> -->

                <!-- tools card -->
                <!-- <div class="card-tools"> -->
                  <!-- button with a dropdown -->
                  <!-- <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="{{url('create/return-note')}}" class="dropdown-item">Return Note</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div> -->
                  
                <!-- </div> -->
                <!-- /. tools -->
                 
              <!-- </div> -->

              
              <!-- /.card-header -->
              <!-- <div class="card-body"> -->

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             <div id="std_error" style="display: none;"><p class="text-danger" id="std_error_txt"></p></div>

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                
                
                <div class="row">

                  <div class="col-md-5">


                <div class="form-row">

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Doc No.</label>
                  <input type="text" form="ticket_form" name="doc_no" class="form-control col-sm-8" value="{{$doc_no}}" required style="width: 100%;">
                  </div>
                 </div>
               
               <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Investment Date</label>
                  <input type="date" form="ticket_form" name="investment_date" class="form-control col-sm-8" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Invested Through</label>
                  <select form="ticket_form" name="invested_through" id="invested_through" class="form-control select2 col-sm-8">
                    <option value="">Select any value</option>
                    @foreach($employees as $emp)
                    <?php 
                       $d='';
                    if($emp['designation']!='')
                      $d=$emp['designation']['name'];
                     ?>
                    <option value="{{$emp['id']}}">{{$emp['name'].'~'.$d}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks</label>
                  <textarea form="ticket_form" name="remarks" class="form-control col-sm-8" style="width: 100%;"></textarea>
                  </div>
                 </div>

                 
                 <div class="col-sm-12">
                <div class="form-group row">

                   
                  <label class="col-sm-3 offset-sm-4"><input type="checkbox" form="ticket_form" name="active" id="active" class="" value="1" checked>&nbsp&nbspActive</label>

                  <label class="col-sm-3"><input type="checkbox" form="ticket_form" name="invested" id="invested" class="" value="1" >&nbsp&nbspInvested</label> 


                  
                  </div>
                 </div>

               

               </div>
 
                   </div><!--outter row col-->
                     <div class="col-md-5">
                        <fieldset class="border p-4">
                          <legend class="w-auto">Detail</legend>

                         <div class="form-row">

                          <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Doctor</label>
                  <select form="ticket_form" name="doctor_id" id="doctor_id" class="form-control select2 col-sm-8" required >
                    <option value="">Select any doctor</option>
                    @foreach($doctors as $emp)
                      <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>


                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Investment Type</label>
                  <select form="ticket_form" name="type" id="type" onchange="" class="form-control col-sm-8" required>
                    <option value="Cash">Cash</option>
                    <option value="Other">Other</option>
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Investment Amount</label>
                  <input type="number" step="any" min="1" form="ticket_form" name="amount" id="amount" class="form-control col-sm-8" value=""    required style="width: 100%;">
                  </div>
                 </div>
                  
                  
                 

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Comment</label>
                  <textarea form="ticket_form" name="comment" class="form-control col-sm-8" style="width: 100%;"></textarea>
                  </div>
                 </div>


                          
                  
                  

                  

              </div>
            </fieldset> 
                     </div>
                </div><!--outter row-->


             
  



              
                  
                  
              <!-- </div> -->
              <!-- /.card-body -->
            <!-- </div>
 -->            <!-- /.card -->

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

  <script type="text/javascript">

    
    $(document).ready(function(){

$('.select2').select2(); 

$(function () {
  $('[data-tooltip="tooltip"]').tooltip({
    trigger : 'hover'
     });
});



  });//end ready







 
  </script>





@endsection  
  