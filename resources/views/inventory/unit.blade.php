
@extends('layout.master')
@section('title', 'Unit Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('configuration/unit/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Unit Configuration</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
          
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Unit</li>
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
                <h3 class="card-title">Unit</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <div class="row">
                   
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add New Unit</legend>

                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <div class="row">
                    <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Unit :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="text" name="name" class="form-control" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div>

            


             <!-------- <div class="col-md-3">
                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Type :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <select name="type" class="form-control"  style="width: 100%;">
                    <option>Larger</option>
                    <option selected>Standard</option>
                    <option>Smaller</option>
                  </select>
                  </div>
                </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Convertion Rate :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="number" step="any" name="rate" class="form-control" value="1" style="width: 100%;">
                  </div>
                </div>
                </div>
              </div>--------->

              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Sort Order :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="number" min="1" value="1" name="sort_order" class="form-control" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Remarks :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                    <textarea name="description" class="form-control"></textarea>
                     
                 <!------ <label><input type="checkbox" name="decimal" value="1" id="decimal" class=""  checked>Decimal</label>---->

                  <label><input type="checkbox" name="status" value="1" id="status" class=""  checked>Active</label>
                  </div>
                </div>
                </div>

              </div>

            </div>

                

                
                
                       </fieldset>

                  </form>
                     
                   </div>

                </div>

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Unit</th>
                   <th>Sort Order</th>
                    <th>Description</th>
                   <!---- <th>Is Decimal</th>--->
                    <th>Status</th>
                  </tr>

            
                    @foreach($units as $unit)
                      
                        <tr>
                   
                     
                     <td>{{$unit['id']}}</td>
                     <td>{{$unit['name']}}</td>
                  
                    <td>{{$unit['sort_order']}}</td>
                    <td>{{$unit['description']}}</td>
                     <?php $c='';
                       /*if($unit['is_decimal']==1)
                          $c='checked';*/
                      ?>
                     <!----<td><input type="checkbox" name="" {{$c}}></td>--->

                    <td>
                      @if($unit['status']==1)
                        Active
                      @else
                        Inactive
                      @endif
                    

                  </td>
                     
                   
                    
                 
                   
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
  