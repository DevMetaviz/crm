
@extends('layout.master')
@section('title', 'User List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">User</h1>
           
       
            <a class="btn" href="{{url('configuration/add-new-user')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">User</a></li>
              <li class="breadcrumb-item active">List</li>
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
                <h3 class="card-title">User List</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                

               
                
                <table class="table table-boardered">
                  <thead>
                      <tr><th>#</th>
                      <th>Name</th>
                      <th>Login Id</th>
                      <th>Role</th>
                      <th>Designation</th>
                      <th></th></tr>
                  </thead>
                  <tbody>
                   @foreach($users as $user) 
                    <tr>
                      <td>{{$user['id']}}</td>
                      <td>{{$user['name']}}</td>
                      <td>{{$user['login_name']}}</td>
                      <td>{{$user->role_text()}}</td>
                      <td>@if(isset($user['employee']['designation'])){{$user['employee']['designation']['name']}}@endif</td>
                      <td><a href="{{url('configuration/edit-user/'.$user['id'])}}"><span class="fa fa-edit"></span></a></td>
                      @endforeach
                    </tr>

                  </tbody>
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
  