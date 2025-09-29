
@extends('layout.master')
@section('title', 'Select Stage')
@section('header-css')

  <link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('select/batch/stage')}}">
   <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Batch Stage</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Click</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/production-entry')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('/production/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Batch Stage</li>
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

               

                

                <div class="row col-md-10 form-row">
                  
                 
                 
                   

                 

                 <div class="col-sm-6">
                    <div class="form-group row">
                  <label class="col-sm-4">Batches</label>
                  <select class="form-control select2 col-sm-8" form="ticket_form"  name="ticket_id" id="ticket_id" onchange="setStages()" required style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($batches as $depart)
                    <option value="{{$depart['id']}}">{{$depart['batch_no']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

               <div class="col-sm-6">
                    <div class="form-group row">
                  <label class="col-sm-4">Stages</label>
                  <select class="form-control select2 col-sm-8" form="ticket_form"  name="stage_id" id="stage_id" required style="width: 100%;">
                    <option value="">Select any stage</option>
                    
                  </select>
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






  function setStages()
{
  var ticket_id= jQuery('#ticket_id').val();
  if(ticket_id=='')
  {
        return;
  }
   

    $.ajax({
               type:'get',
               url:'{{ url("get/ticket/stages") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     ticket_id: ticket_id,
                  

               },
               success:function(data) {

                stages=data;
                 
                 $('#stage_id').empty().append('<option selected="selected" value="">Select any stage</option>');

                 for (var k =0 ;k < stages.length ; k ++ )
                   {   
                     $('<option value="'+stages[k]['id']+'">'+stages[k]['process_name']+'</option>').appendTo("#stage_id");
                   }
                



               }
             });
    
}//end setDepartmentItem
  
 
</script>





@endsection  
  