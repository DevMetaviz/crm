
@extends('layout.master')
@section('title', 'Allowances Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Allowances Configuration</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Allowances</li>
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
                <h3 class="card-title">Allownces</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                   
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add New Allownce</legend>

                    <form role="form" method="post" action="{{url('configuration/allowances/save')}}">
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                

                <label>Text</label>
                <input type="text" name="text" required="true" />

               <!--  <label>Type</label>
                
                <select  name="type" id="type" required="true" style="">
                    <option value="">------Select any value-----</option>
                    
                    <option value="additive">Additive</option>
                    <option value="deductive">Deductive</option>
                  
                  </select> -->


                  <label>Type</label>
                
                <select  name="type" id="type" required="true" style="">
                   
                    
                    <option value="allowance">Allownce</option>
                    <option value="deduction">Deduction</option>
                  
                  </select>

                   <label>Sort Order</label>
                <input type="number" value="1" name="sort_order" required="true" />

                  <label><input type="checkbox" name="activeness" value="1" checked>Active</label>


                

                <input type="submit" name="" value="Add">
                       </fieldset>

                  </form>
                     
                   </div>

                </div>

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Text</th>
                    <th>Type</th>
                    <!--  <th>Type1</th> -->
                     <th>Sort Order</th>
                     <th>Activeness</th>
                    <th>Created At</th>
                  </tr>

            
                    @foreach($allowances as $allowance)
                      
                        <tr>
                   
                     
                     <td>{{$allowance['id']}}</td>
                     <td>{{$allowance['text']}}</td>
                    <td>{{$allowance['type']}}</td>
                
                    <!--  <td>{{$allowance['type1']}}</td> -->
                     <td>{{$allowance['sort_order']}}</td>
                     <td>{{$allowance['activeness']}}</td>
                    <td>{{$allowance['created_at']}}</td>
                     
                   
                    
                 
                   
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







@endsection  
  