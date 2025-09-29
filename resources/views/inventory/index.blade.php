
@extends('layout.master')
@section('title', 'Inventories')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Inventory Configuration</h1>
           <!--  <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('inventory/Add')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Inventories</li>
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
                <h3 class="card-title">Inventory Items</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               
              <form role="form" id="item_history_form" method="get" action="{{url('/inventory')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    

          
           <div class="col-md-2">
                    <div class="form-group">
                  <label>Category</label>
                  <select class="form-control select2"  name="category_id" id="category_id">
                    <option value="">Select any category</option>
                    @foreach($categories as $so)
                    <option value="{{$so['id']}}"  {{ request('category_id') == $so['id'] ? 'selected' : '' }}  >{{$so['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>


              <?php

               $sub_categories=[];

              if(isset($_GET['category_id']) && $_GET['category_id']>0)
                {
                  $category = $categories->firstWhere('id', $_GET['category_id']);
                  $sub_categories = $category->sub_categories;
                }
              ?>

               <div class="col-md-2">
                    <div class="form-group">
                  <label>Sub Category</label>
                  <select class="form-control select2"  name="sub_category_id" id="sub_category_id">
                    <option value="">Select any category</option>

                    @foreach($sub_categories as $so)
                    <option value="{{$so['id']}}"  {{ request('sub_category_id') == $so['id'] ? 'selected' : '' }}  >{{$so['name']}}</option>
                    @endforeach
                    
                  </select>
                </div>
              </div>


              <div class="col-md-2">
                    <div class="form-group">
                  <label>Gage</label>
                  <select class="form-control"  name="gage_id" id="gage_id">
                    <option value="">Select any gage</option>

                    @foreach($gages as $so)
                    <option value="{{$so['id']}}"  {{ request('gage_id') == $so['id'] ? 'selected' : '' }}  >{{$so['name']}}</option>
                    @endforeach
                    
                  </select>
                </div>
              </div>

           

                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="Search">
                     </div>


                    </div>

                 </fieldset>
                 </form>
                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                    <tr>
                    <th>#</th>
                    <!---<th>Id</th>-->
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Code</th>
                    <th>Item</th>
                    <th>Gage</th>
                    <th>Std Rate</th>
                    <th>L Qty</th>
                    <th>Reorder Level</th>
                    <th>Weight</th> 
                    <th>Feet</th>
                   
                    <th>Pricing By</th>
                    <th></th>
                  </tr>


                  </thead>
                  <tbody>
                  
                

                  
                   <?php $i=1; ?>
                    @foreach($items as $item)

                    <?php

                     $category='';
                  if(isset($item['category']['name'])) 
                  $category=$item['category']['name'];

                $sub_category='';
                  if(isset($item['sub_category']['name'])) 
                  $sub_category=$item['sub_category']['name'];

                  /*$department='';
                  if(isset($item['department']['name'])) 
                  $department=$item['department']['name'];

                
                 
                 $origin='';
                  if(isset($item['origin']['name'])) 
                  $origin=$item['origin']['name'];

                 $unit='';
                  if(isset($item['unit']['name'])) 
                  $unit=$item['unit']['name'];
                  
                   
                  
                   $size='';
                  if(isset($item['size']['name'])) 
                  $size=$item['size']['name'];
                   
                    $color='';
                  if(isset($item['color']['name'])) 
                  $color=$item['color']['name'];*/

                    /*$last_purchase_rate=$item->last_purchase_rate();
                        //$b= json_encode($item['grns']);
                        
                        $open=$item->item_opening();
                          $open_qty=0;
                          if(isset($open['approved_qty']))
                           $open_qty=$open['approved_qty'];*/
                 ?>

                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <!---<td>{{$item['id']}}</td>-->
                     <td>{{$category}}</td>
                     <td>{{$sub_category}}</td>
                     <td>{{$item['item_code']}}</td>
                    <td>{{$item['item_name']}}</td>
                     <td>@if(isset($item['gage']['name'])){{$item['gage']['name']}}@endif</td>
                     <td>{{$item['standard_rate']}}</td>
                     <td>{{$item['loading_qty']}}</td>
                     <td>{{$item['minimal']}}</td>
                      <td>{{$item['weight']}}</td>   
                     <td>{{$item['feet']}}</td>
                                  
                     <td>{{$item['pricing_by']}}</td>
                      
                      <td><a href="{{url('edit/inventory/'.$item['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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


<script>

 let categories = @json($categories);


 $('select[name="category_id"]').on('change', function () {
        let category_id = $(this).val();
        let sub_category_id = $('select[name="sub_category_id"]');

        sub_category_id.empty(); // clear old options

        if (category_id) {
            
            let category = categories.find(c => c.id == category_id);

            sub_category_id.append('<option value="">Select any value</option>');

            if (category && category.sub_categories.length > 0) {
                category.sub_categories.forEach(branch => {
                    sub_category_id.append(
                        $('<option>', {
                            value: branch.id,
                            text: branch.name
                        })
                    );
                });
            } else {
               // sub_category_id.append('<option value="">No sub category available</option>');
            }
        }
    });

</script>


@endsection  
  