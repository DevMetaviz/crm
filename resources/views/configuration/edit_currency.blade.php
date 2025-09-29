
@extends('layout.master')
@section('title', 'Edit Currency')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('configuration/currency/update')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Currency</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('configuration/currency')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Currency</li>
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

             @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
    </div>
             @endif

            

                                       
                        <fieldset class="border p-4">
                   <legend class="w-auto">Edit Currency</legend>
                   <div class="row">
                    <div class="col-md-6">
                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                   <input type="hidden" value="{{$currency['id']}}" name="id"/>

                 <div class="form-row">

              

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Currency:</label>
                  <input type="text"  name="text" class="form-control col-sm-8" value="{{$currency['text']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Symbol:</label>
                  <input type="text"  name="symbol" class="form-control col-sm-8" value="{{$currency['symbol']}}"  required style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-12">
                  <div class="form-group row">
                  <?php
                      $s='';
                      if($currency['activeness']==1)
                        $s='checked';
                   ?>
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="activeness" value="1" id="activeness" class="" {{$s}}>&nbsp&nbspActive</label>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group row">
                  <?php
                      $d='';
                      if($currency['is_default']==1)
                        $d='checked';
                   ?>
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="is_default" value="1" id="is_default" class="" {{$d}} >&nbsp&nbspDefault</label>
                  </div>
                </div>

               </div>
                
                  </div>

                  <div class="col-md-4" >
                       
                       <div class="form-row">
                       <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks:</label>
                  <textarea name="remarks" class="form-control  col-sm-8">{{$currency['remarks']}}</textarea>
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
                    
                    <th>Currency</th>
                    <th>Symbol</th>
                
                   <th>Remarks</th>
                  
                    <th>Active</th>
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody>
                  
   
                        
                    <?php $i=1; ?>
                    @foreach($methods as $acc)
                    <tr>
                     <td>{{$i}}</td>
                     
                     <td>{{$acc['text']}}
                     @if($acc['is_default']==1)
                      <span class="badge badge-success">Default</span>
                     @endif
                   </td>
                    <td>{{$acc['symbol']}}</td>
                
                    <td>{{$acc['remarks']}}</td>
                  <?php
                     $active=$acc['activeness'];
                      if($active=='1')
                          $active='Active';
                        else
                          $active='Inactive';
                   ?>
                    <td>{{$active}}</td>
                      <td><a href="{{url('configuration/currency/edit/'.$acc['id'])}}"><span class="fa fa-edit"></span></a></td>
                      </tr>
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







@endsection  
  