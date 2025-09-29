
@extends('layout.master')
@section('title', 'Territory Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Territory Configuration</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
             
              <li class="breadcrumb-item active">Territory</li>
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
                <h3 class="card-title">Cities</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              <div class="row">
                  

                   <div class="col-md-6">
                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

           </div>
         </div>

                <div class="row">
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add New Territory</legend>

                    <form role="form" method="post" action="{{url('/configuration/territory/save')}}">

                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <label>Country</label>
                
                <select  name="country" id="country" onchange="set_country_detail()" required="true" style="">
                    <option value="">------Select any value-----</option>
                    @foreach($countries as $country)
                    <option value="{{$country['id']}}">{{$country['name']}}</option>
                    @endforeach
                  
                  </select>

                  <label>Province</label>
                
                <select  name="province" id="province" onchange="set_province_detail()" style="">
                    <option value="">------Select any province-----</option>
                    
                  
                  </select>

                  <label>Region</label>
                
                <select  name="region" id="region" onchange="set_region_detail()" style="">
                    <option value="">------Select any region-----</option>
                    
                  
                  </select>

                  <label>District</label>
                
                <select  name="district" id="district" onchange="set_district_detail()" style="">
                    <option value="">------Select any district-----</option>
                  </select>

                  <label>City</label>
                
                <select  name="city" id="city" onchange="" style="">
                    <option value="">------Select any city-----</option>
                  </select>

                <label>Territory</label>
                <input type="text" name="territory" class="" required="true" />

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

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                       <tr>
                    <th>Id</th>
                    <th>Territory</th>
                    <th>City</th>
                    <th>District</th>
                    <th>Region</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Description</th>
                     <th>Sort Order</th>
                    <th>Status</th>
                  </tr>


                  </thead>
                  <tbody id="city_body">
                  
                 

            
          
                  
                
                  
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
<script src="{{asset('public/own/js/others.js')}}"></script>
<script type="text/javascript">
  
  function set_country_detail() {

 country= jQuery('#country').val();

 if(country=='')
  return;

    var countries= `<?php echo json_encode($countries); ?>  `;
    countries=JSON.parse(countries);

    let point = countries.findIndex((item) => item.id == country);
         
         var states=countries[point]['provinces'];

           province_text='<option value="">------Select any province-----</option>';
                  for(i=0;i<states.length;i++)
                  {

                    province_text+=`<option value="${states[i]['id']}">${states[i]['name']}</option>`; 

                  }
                  $('#province').html(province_text);


  }// end set_country_detail

  function set_province_detail() {

    country= jQuery('#country').val();
    province= jQuery('#province').val();

    if(province=='')
      return;

    var countries= `<?php echo json_encode($countries); ?>  `;
    countries=JSON.parse(countries);

    let point = countries.findIndex((item) => item.id == country);
         
         var states=countries[point]['provinces'];

     point = states.findIndex((item) => item.id == province);

    var regions=states[point]['regions'];

           text='<option value="">------Select any value-----</option>';
                  for(i=0;i<regions.length;i++)
                  {

                    text+=`<option value="${regions[i]['id']}">${regions[i]['name']}</option>`; 

                  }
                  $('#region').html(text);

  }// end set_province_detail

   function set_region_detail() {

    country= jQuery('#country').val();
    province= jQuery('#province').val();
    region= jQuery('#region').val();

    if(region=='')
      return;

    var countries= `<?php echo json_encode($countries); ?>  `;
    countries=JSON.parse(countries);

    let point = countries.findIndex((item) => item.id == country);
         
         var states=countries[point]['provinces'];

     point = states.findIndex((item) => item.id == province);

    var regions=states[point]['regions'];

    point = regions.findIndex((item) => item.id == region);

    var districts=regions[point]['districts'];

           text='<option value="">------Select any value-----</option>';
                  for(i=0;i<districts.length;i++)
                  {

                    text+=`<option value="${districts[i]['id']}">${districts[i]['name']}</option>`; 

                  }
                  $('#district').html(text);

  }// end set_region_detail

  function set_district_detail() {

    country= jQuery('#country').val();
    province= jQuery('#province').val();
    region= jQuery('#region').val();
    district= jQuery('#district').val();

    if(district=='')
      return;

    var countries= `<?php echo json_encode($countries); ?>  `;
    countries=JSON.parse(countries);

    let point = countries.findIndex((item) => item.id == country);
         
         var states=countries[point]['provinces'];

     point = states.findIndex((item) => item.id == province);

    var regions=states[point]['regions'];

    point = regions.findIndex((item) => item.id == region);

    var districts=regions[point]['districts'];

     point = districts.findIndex((item) => item.id == district);

    var cities=districts[point]['cities'];

           text='<option value="">------Select any value-----</option>';
                  for(i=0;i<cities.length;i++)
                  {

                    text+=`<option value="${cities[i]['id']}">${cities[i]['name']}</option>`; 

                  }
                  $('#city').html(text);

  }// end set_district_detail
  


      

       
</script>
@endsection  
  