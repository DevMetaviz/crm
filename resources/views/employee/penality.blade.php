
@extends('layout.master')
@section('title', 'Penalities')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">HR Penalities</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employee</a></li>
              <li class="breadcrumb-item active">Penality</li>
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
                <h3 class="card-title">Penalities</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                   
                   

                   <div class="col-md-12">

                    <form role="form" method="post" action="{{url('save-penality')}}">
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <label>Text</label>
                <input type="text" name="text" required="true" />

                <label>Employee</label>
                <select  name="employee" id="employee" required="true" style="">
                    <option value="">------Select any value-----</option>
                    
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                    @endforeach
                  </select>

                  <label>Amount</label>
                <input type="number" step="any" name="amount" required="true" />

                  <label>Type</label>
                <select  name="type" id="type" required="true" style="">
                    <option value="">Select any type</option>
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                  </select>

                  <label>Weight(Applicale if type percent)</label>
                <select  name="weight" id="weight" style="">
                    <option value="">Select any type</option>
                    <option value="per day">Per Day</option>
                    <option value="per month">Per Month</option>
                  </select>

                

                <label>Month</label>
                <input type="month" name="month" required="true" />

                <label>Remarks</label>
                <textarea name="remarks" required="true"></textarea>

                

                <input type="submit" name="" value="Add">


                  </form>
                     
                   </div>

                </div>

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

              
                <table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Text</th>
                    <th>Employee</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Weight</th>
                    <th>Month</th>
                    <th>Remarks</th>
                    <th>Created At</th>
                  </tr>

                  @if(isset($penalities))
                    @foreach($penalities as $pan)
                      
                        <tr>
                   
                     
                     <td>{{$pan['id']}}</td>
                      <td>{{$pan['text']}}</td>
                     <td>{{$pan['employee']['name']}}</td>
                    <td>{{$pan['amount']}}</td>
                    <td>{{$pan['type']}}</td>
                    <td>{{$pan['weight']}}</td>
                    <td>{{$pan['month']}}</td>
                   <td>{{$pan['remarks']}}</td>
                    <td>{{$pan['created_at']}}</td>
                     
                   
                    
                 
                   
                  </tr>

                    @endforeach
                  @endif
                  
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
  