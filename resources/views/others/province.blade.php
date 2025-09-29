
@extends('layout.master')
@section('title', 'States Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Province/State Configuration</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
             
              <li class="breadcrumb-item active">State</li>
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
                <h3 class="card-title">Provinces</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                   
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add New Province/State</legend>

                    <form role="form" method="post" action="{{url('/configuration/state/save')}}">

                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <label>Country</label>
                
                <select  name="country" id="country" onchange="getStates()" required="true" style="">
                    <option value="">------Select any value-----</option>
                    @foreach($countries as $country)
                    <option value="{{$country['id']}}">{{$country['name']}}</option>
                    @endforeach
                  
                  </select>

                <label>Province</label>
                <input type="text" name="name" class="" required="true" />

                <label>Description</label>
                <textarea name="description" class=""></textarea>
               
               <label>Sort Order</label>
                <input type="number" name="sort_order" class="" min="1" value="1" required="true" />

                  <input type="checkbox" name="activeness" value="1" id="activeness" class=""  checked>
                  <label>Active</label>

                

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
                  
                       <tr>
                    <th>Id</th>
                    <th>Country</th>
                    <th>Province/State</th>
                    <th>Description</th>
                     <th>Sort Order</th>
                    <th>Status</th>
                  </tr>


                  </thead>
                  <tbody id="province">
                  
                 
                  @foreach($provinces as $pr)
                      
                        <tr>
                   
                     
                     <td>{{$pr['id']}}</td>
                     <td>{{$pr['country']['name']}}</td>
                     <td>{{$pr['name']}}</td>
                    <td>{{$pr['description']}}</td>
                
                    <td>{{$pr['sort_order']}}</td>
                    <td>{{$pr['activeness']}}</td>
                     
                   
                    
                 
                   
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
  
  function getStates() {

    
            $.ajax({
               type:'get',
               url:'{{ url("/get/states") }}',
               data:{
                    
                    country: jQuery('#country').val(),

               },
               success:function(data) {
                     
                text='';
                  for(i=0;i<data.length;i++)
                  {

                    text+=`<tr> 
          <td>${data[i]['id']}</td> 
          <td>${data[i]['country']['name']}</td> 
          <td>${data[i]['name']}</td> 
          <td>${data[i]['description']}</td> 
          <td>${data[i]['sort_order']}</td> 
          <td>${data[i]['activeness']}</td> 
           </tr>`; 

                  }

                  $('#province').html(text); 
                
               }
            });
         }

</script>
@endsection  
  