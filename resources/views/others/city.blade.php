
@extends('layout.master')
@section('title', 'City Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">City Configuration</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
             
              <li class="breadcrumb-item active">City</li>
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
                   <legend class="w-auto">Add New City</legend>

                    <form role="form" method="post" action="{{url('/configuration/city/save')}}">

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
                <input type="text" name="city" class="" required="true" />

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
    link='{{ url("/get/country/detail") }}';



    $('#province').html('<option value="">------Select any province-----</option>');
    $('#region').html('<option value="">------Select any region-----</option>');
    $('#district').html('<option value="">------Select any district-----</option>');
    $('#city_body').html('');

    $.ajax({
               type:'get',
               url:  link ,
               data:{
                    
                    country: country,

               },
               success:function(data) {

                 provinces=data['provinces'];
                 regions=data['regions'];
                 districts=data['districts'];
                 cities=data['cities'];

                province_text='<option value="">------Select any province-----</option>';
                  for(i=0;i<provinces.length;i++)
                  {

                    province_text+=`<option value="${provinces[i]['id']}">${provinces[i]['name']}</option>`; 

                  }

                  regions_text='<option value="">------Select any region-----</option>';
                  for(i=0;i<regions.length;i++)
                  {

                    regions_text+=`<option value="${regions[i]['id']}">${regions[i]['name']}</option>`; 

                  }

                  districts_text='<option value="">------Select any district-----</option>';
                  for(i=0;i<districts.length;i++)
                  {

                    districts_text+=`<option value="${districts[i]['id']}">${districts[i]['name']}</option>`; 

                  }

                   city_body=''; 
                  for(i=0;i<cities.length;i++)
                  {

                    city_region=''; city_province=''; city_district=''; city_country='';
                if(cities[i]['region']!=null)
                  city_region=cities[i]['region']['name'];
                if(cities[i]['province']!=null)
                  city_province=cities[i]['province']['name'];
                 if(cities[i]['district']!=null)
                  city_district=cities[i]['district']['name'];
                if(cities[i]['country']!=null)
                  city_country=cities[i]['country']['name'];

                    city_body+=`<tr> 
          <td>${cities[i]['id']}</td> 
          <td>${cities[i]['name']}</td> 
          <td>${city_district}</td> 
          <td>${city_region}</td> 
          <td>${city_province}</td> 
          <td>${city_country}</td>
          <td>${cities[i]['description']}</td> 
          <td>${cities[i]['sort_order']}</td> 
          <td>${cities[i]['activeness']}</td>  
           </tr>`; 

                  }

                  
                  $('#province').html(province_text);
                   $('#region').html(regions_text);
                   $('#district').html(districts_text); 
                   $('#city_body').html(city_body);
                
               }
            });

  }// end set_country_detail

  function set_province_detail() {

   province= jQuery('#province').val();
    if(province=='')
    {
               set_country_detail();
    }

    else{
    
  
    $('#region').html('<option value="">------Select any region-----</option>');
    $('#district').html('<option value="">------Select any district-----</option>');
    $('#city_body').html('');

    $.ajax({
               type:'get',
               url:'{{ url("/get/state/detail") }}',
               data:{
                    
                   
                     province: jQuery('#province').val(),

               },
               success:function(data) {

                
                 regions=data['regions'];
                 districts=data['districts'];
                 cities=data['cities'];

              

                  regions_text='<option value="">------Select any region-----</option>';
                  for(i=0;i<regions.length;i++)
                  {

                    regions_text+=`<option value="${regions[i]['id']}">${regions[i]['name']}</option>`; 

                  }

                  districts_text='<option value="">------Select any district-----</option>';
                  for(i=0;i<districts.length;i++)
                  {

                    districts_text+=`<option value="${districts[i]['id']}">${districts[i]['name']}</option>`; 

                  }

                   city_body=''; 
                  for(i=0;i<cities.length;i++)
                  {

                    city_region=''; city_province=''; city_district=''; city_country='';
                if(cities[i]['region']!=null)
                  city_region=cities[i]['region']['name'];
                if(cities[i]['province']!=null)
                  city_province=cities[i]['province']['name'];
                 if(cities[i]['district']!=null)
                  city_district=cities[i]['district']['name'];
                if(cities[i]['country']!=null)
                  city_country=cities[i]['country']['name'];

                    city_body+=`<tr> 
          <td>${cities[i]['id']}</td> 
          <td>${cities[i]['name']}</td> 
          <td>${city_district}</td> 
          <td>${city_region}</td> 
          <td>${city_province}</td> 
          <td>${city_country}</td>
          <td>${cities[i]['description']}</td> 
          <td>${cities[i]['sort_order']}</td> 
          <td>${cities[i]['activeness']}</td>  
           </tr>`; 

                  }

                  
                   $('#region').html(regions_text);
                   $('#district').html(districts_text); 
                   $('#city_body').html(city_body);
                
               }
            });

  }//end else

  }// end set_province_detail

   function set_region_detail() {
    
    region= jQuery('#region').val();
    if(region=='')
    {
               set_province_detail();
    }

    else{
    
    $('#district').html('<option value="">------Select any district-----</option>');
    $('#city_body').html('');

    $.ajax({
               type:'get',
               url:'{{ url("/get/region/detail") }}',
               data:{
                    
                   
                     region: jQuery('#region').val(),

               },
               success:function(data) {

                 districts=data['districts'];
                 cities=data['cities'];

              

                  districts_text='<option value="">------Select any district-----</option>';
                  for(i=0;i<districts.length;i++)
                  {

                    districts_text+=`<option value="${districts[i]['id']}">${districts[i]['name']}</option>`; 

                  }

                   city_body=''; 
                  for(i=0;i<cities.length;i++)
                  {

                    city_region=''; city_province=''; city_district=''; city_country='';
                if(cities[i]['region']!=null)
                  city_region=cities[i]['region']['name'];
                if(cities[i]['district']!=null)
                  city_province=cities[i]['district']['name'];
                 if(cities[i]['province']!=null)
                  city_district=cities[i]['province']['name'];
                if(cities[i]['country']!=null)
                  city_country=cities[i]['country']['name'];

                    city_body+=`<tr> 
          <td>${cities[i]['id']}</td> 
          <td>${cities[i]['name']}</td> 
          <td>${city_district}</td> 
          <td>${city_region}</td> 
          <td>${city_province}</td> 
          <td>${city_country}</td>
          <td>${cities[i]['description']}</td> 
          <td>${cities[i]['sort_order']}</td> 
          <td>${cities[i]['activeness']}</td>  
           </tr>`; 

                  }

                  
                   $('#district').html(districts_text); 
                   $('#city_body').html(city_body);
                
               }
            });
  }//end else

  }// end set_region_detail

  function set_district_detail() {

    district= jQuery('#district').val();
    if(district=='')
    {
               set_region_detail();
    }

    else{


    
    $('#city_body').html('');

    $.ajax({
               type:'get',
               url:'{{ url("/get/district/detail") }}',
               data:{
                    
                
                    district: jQuery('#district').val(),

               },
               success:function(data) {

                 
                 cities=data['cities'];

                


                   city_body=''; 
                  for(i=0;i<cities.length;i++)
                  {

                    city_region=''; city_province=''; city_district=''; city_country='';
                if(cities[i]['region']!=null)
                  city_region=cities[i]['region']['name'];
                if(cities[i]['province']!=null)
                  city_province=cities[i]['province']['name'];
                 if(cities[i]['district']!=null)
                  city_district=cities[i]['district']['name'];
                if(cities[i]['country']!=null)
                  city_country=cities[i]['country']['name'];

                    city_body+=`<tr> 
          <td>${cities[i]['id']}</td> 
          <td>${cities[i]['name']}</td> 
          <td>${city_district}</td> 
          <td>${city_region}</td> 
          <td>${city_province}</td> 
          <td>${city_country}</td>
          <td>${cities[i]['description']}</td> 
          <td>${cities[i]['sort_order']}</td> 
          <td>${cities[i]['activeness']}</td>  
           </tr>`; 

                  }

              
                   $('#city_body').html(city_body);
                
               }
            });
  }//end else

  }// end set_district_detail
  


      

       
</script>
@endsection  
  