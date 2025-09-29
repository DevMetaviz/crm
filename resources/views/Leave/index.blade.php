
@extends('layout.master')
@section('title', 'Leaves')
@section('header-css')
<style type="text/css">
  .alert-success {
     color: #155724; 
    background-color: #d4edda;
    /*border-color: #c3e6cb;*/
}
</style>
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
   

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Leaves</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('/leaves')}}">Leaves</a></li>
              <li class="breadcrumb-item active">Leave</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

<style type="text/css">
  .alert-inline{
              display: inline;
              color: #d32535;
              background-color:transparent ;
              border:none;padding: .7rem 4rem 0rem 0rem;
     }
</style>
    
      <div class="container-fluid" style="margin-top: 10px;">

            @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             
                       @if ($errors->has('msg'))
                                    
                      <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>

                                         
  
                                @endif
     
           


           
<table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>

                   <tr>
                     <th>Application No</th>
                     <th>Employee</th>
                     <th>Apllication Date</th>
                     <th>Leave Type</th>
                     <th>Type</th>
                     <th>From</th>
                     <th>To</th>
                     <th>Status</th>
                     <th>Action</th>
                   </tr>

                  </thead>
                  <tbody>
                  @foreach($leaves as $leave)
                      <?php  
                           $from=$leave->leave_dates->first(); $from_date='';
                           if($from!=null) 
                              $from_date=$from['leave_date'];

                            $to=$leave->leave_dates->last(); $to_date='';
                           if($to!=null) 
                              $to_date=$to['leave_date'];
                      ?>
                   
                 <tr>
                     <td>{{$leave['application_no']}}</td>
                     <td>{{$leave['employee']['name']}}</td>
                     <td>{{$leave['application_date']}}</td>
                     <td>{{$leave['leave_type']['value']}}</td>
                     <td>{{$leave['type']}}</td>
                     <td>{{$from_date}}</td>
                     <td>{{$to_date}}</td>
                     <td>{{$leave['status']}}</td>
                     <td><a href="{{url('/edit/leave/'.$leave['id'])}}"><span class="fa fa-edit"></span></a></td>
                   </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
                </table>

            


           
                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">



</script>

@endsection  
  