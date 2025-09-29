
@extends('layout.master')
@section('title', 'Company Config')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('/company/config/update')}}" enctype="multipart/form-data"  >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Company Info</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
           
           <!--  <a class="btn" href="{{url('inventory/Add')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Company Config</li>
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
                <h3 class="card-title">Edit Info</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
    </div>
             @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                
                
                <div class="col-md-6 form-row">

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Company Name:</label>
                  <input type="text" form="ticket_form" name="comp_name" class="form-control select2 col-sm-8" value="{{$name}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Short Name:</label>
                  <input type="text" form="ticket_form" name="short_name" class="form-control select2 col-sm-8" value="{{$short_name}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Name Abbreviation:</label>
                  <input type="text" form="ticket_form" name="abbreviation" class="form-control select2 col-sm-8" value="{{$abbreviation}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Tag Line:</label>
                  <input type="text" form="ticket_form" name="tag_line" class="form-control select2 col-sm-8" value="{{$tag_line}}" required style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Phone:</label>
                  <input type="text" form="ticket_form" name="phone" class="form-control select2 col-sm-8" value="{{$phone}}" style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Mobile:</label>
                  <input type="text" form="ticket_form" name="mobile" class="form-control select2 col-sm-8" value="{{$mobile}}"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Whats App:</label>
                  <input type="text" form="ticket_form" name="whats_app" class="form-control select2 col-sm-8" value="{{$whats_app}}"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Email:</label>
                  <input type="text" form="ticket_form" name="email" class="form-control select2 col-sm-8" value="{{$email}}"  style="width: 100%;">
                  </div>
                 </div>

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Fax:</label>
                  <input type="text" form="ticket_form" name="fax" class="form-control select2 col-sm-8" value="{{$fax}}"  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Head Office:</label>
                  <textarea form="ticket_form" name="head_office" class="form-control select2 col-sm-8" style="width: 100%;"  >{{$head_office}}</textarea>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Factory Address:</label>
                  <textarea form="ticket_form" name="factory_address" class="form-control select2 col-sm-8" style="width: 100%;"  >{{$factory_address}}</textarea>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Logo:</label>
                  <div class="col-sm-8">
                    <img src="{{url($logo)}}" alt="logo's Image">
                  <input type="file" form="ticket_form" name="logo" class="form-control select2"  style="width: 100%;">
                    </div>
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







@endsection  
  