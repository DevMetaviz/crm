
@extends('layout.master')
@section('title', 'Edit Voucher Type')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('voucher/type/update')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Voucher Types</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('voucher/types')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Voucher</a></li>
              <li class="breadcrumb-item active">Edit Voucher Types</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Process Parameters</h3>
              
              </div>
 -->              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

            

                                       
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add Voucher Type</legend>
                   <div class="row">
                    <div class="col-md-6">
                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                  <input type="hidden" value="{{$type['id']}}" name="id"/>

                 <div class="form-row">

              

                
                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Text:</label>
                  <input type="text"  name="name" class="form-control select2 col-sm-8" value="{{$type['name']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Code:</label>
                  <input type="text"  name="code" class="form-control select2 col-sm-8" value="{{$type['attributes']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 

                 <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="activeness" value="1" id="activeness" class="" checked>&nbsp&nbspActive</label>
                  </div>
                </div>

               </div>
                
                  </div>

                  <div class="col-md-4" >
                       
                       <div class="form-row">
                       <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks:</label>
                  <textarea name="remarks" class="form-control select2 col-sm-8">{{$type['description']}}</textarea>
                  </div>
                 </div>
               </div>

                  </div>


                  </div>
                       </fieldset>

                  </form>
                     
                  

          

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                    <tr>
                    <th>#</th>
                    
                    <th>Text</th>
                    <th>Code</th>
                   <th>Remarks</th>
                  
                    <th>Active</th>
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody>
                  
   
                        
                   
                    @foreach($types as $acc)
                    <tr>
                     <td></td>
                     <td>{{$acc['name']}}</td>
                     <td>{{$acc['attributes']}}</td>
                    <td>{{$acc['description']}}</td>
                  <?php
                     $active=$acc['activeness'];
                      if($active=='1')
                          $active='Active';
                        else
                          $active='Inactive';
                   ?>
                    <td>{{$active}}</td>
                      <td><a href="{{url('edit/voucher/type/'.$acc['id'])}}"><span class="fa fa-edit"></span></a></td>
                      </tr>
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


   
   value1="{{ $type['activeness'] }}";

   if(value1=="1")
   {
    
  $('#activeness').prop("checked", true);
   
   }
    else{
      $('#activeness').prop("checked", false);
  
    } 

  });

</script>




@endsection  
  