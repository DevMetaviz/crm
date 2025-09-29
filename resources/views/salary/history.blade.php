
@extends('layout.master')
@section('title', 'Salary History')
@section('header-css')

<style type="text/css">
  #salary_table th {
    position: -webkit-sticky; // this is for all Safari (Desktop & iOS), not for Chrome
    position: sticky;
    top: 0;
    z-index: 10; // any positive value, layer order is global
    background: #fff;
}
</style>
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

    
     

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Salary History</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <!-- <a class="btn" href="{{url('salary/history')}}"><span class="fas fa-edit">&nbsp</span>History</a> -->
            <a class="btn" href="{{url('make-salary')}}"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Salaries</a></li>
              <li class="breadcrumb-item active">History</li>
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
                <h3 class="card-title">List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               
                

                  


              <div class="table-responsive p-0" style="height: 400px;">
              <table id="salary_table" class="table table-bordered table-hover table-head-fixed text-nowrap" style="">
                  
                  
                
                  <thead>
                 <tr>
                    <th>#</th>
                    <th>Doc No</th>
                    <th>Salary Date</th>
                    <th>Month</th>
                    <th></th>
                 
                   
                    
                  </tr>

                  </thead>
                  <tbody>
                    <?php $sr=1; ?>
                
                        @foreach($list as $it)
                           
                        
                              
                                   <tr>
                   
                     <td>{{$sr}}</td>
                     <td>{{$it['doc_no']}}</td>
                     <td>{{$it['doc_date']}}</td>
                     <td>{{$it['month']}}</td>
                     <td><a href="{{url('edit/salary/'.$it['id'])}}"><span class="fa fa-edit"></span></a></td>

                   
                       
                    
                     </tr>
                     <?php $sr++; ?>
                  

                              

                        @endforeach
                  

                  

                  </tbody>

                   
                  

                 

                </table>
                 </div>

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                  



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script type="text/javascript">

 </script>





@endsection  
  