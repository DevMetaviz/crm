
@extends('layout.master')
@section('title', 'Add New Point')
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
    <form role="form" method="POST" action="{{url('point/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Point</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('point/list')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Points</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Point</a></li>
              <li class="breadcrumb-item active">Add New Point</li>
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
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>

                                          <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>
  
                                @endif
     

            <div class="row">
              <div class="col-md-5">
            
              <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <div class="form-group">
                  <label>Point Name</label>
                  <input type="text" name="name" class="form-control" value="{{old('name')}}" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Distributor</label>
                  <select class="form-control select2" name="distributor_id" id="distributor_id" required  style="width: 100%;">
                    <option>------Select any value-----</option>
                    @foreach($customers as $cus)
                    <option value="{{$cus['id']}}" >{{$cus['name']}}</option>
                    @endforeach
                
                  </select>
                </div>

                <div class="form-group">
                  <label>Salesman</label>
                  <select class="form-control select2" name="salesman_id" id="salesman_id"   style="width: 100%;">
                    <option>------Select any value-----</option>
                    @foreach($salesmen as $cus)
                    <option value="{{$cus['id']}}">{{$cus['name']}}</option>
                    @endforeach
                
                  </select>
                </div>

                <div class="form-group">
                  <label>Doctor</label>
                  <select class="form-control select2" name="doctor_id" id="doctor_id"   style="width: 100%;">
                    <option>------Select any value-----</option>
                    @foreach($doctors as $d)
                    <option value="{{$d['id']}}" >{{$d['name']}}</option>
                    @endforeach
                
                  </select>
                </div>

                <div class="form-row">

                  <div class="form-group col-sm-7">
                  <label>Contact No 1<span class="text-danger">*</span></label>
                  <input type="text" name="contact" class="form-control" value="{{old('contact')}}"   style="width: 100%;">
                  </div>

                  <div class="form-group col-sm-5">
                  <label>Mobile<span class="text-danger">*</span></label>
                  <input type="text" name="mobile" class="form-control" value="{{old('mobile')}}"   style="width: 100%;">
                  </div>

                  <div class="form-group col-sm-7">
                  <label>Contact No 2<span class="text-danger">*</span></label>
                  <input type="text" name="contact2" class="form-control" value="{{old('contact2')}}"   style="width: 100%;">
                  </div>

                  <div class="form-group col-sm-5">
                  <label>Mobile<span class="text-danger">*</span></label>
                  <input type="text" name="mobile2" class="form-control" value="{{old('mobile2')}}"   style="width: 100%;">
                  </div>
                   
                </div>
                

                  <div class="form-group">
                  <label>Phone No<span class="text-danger">*</span></label>
                  <input type="text" name="phone" class="form-control" value="{{old('phone')}}"  style="width: 100%;">
                 
                </div>


                   <div class="form-group">
                  <label>Email<span class="text-danger">*</span></label>
                  <input type="text" name="email" class="form-control" value="{{old('email')}}"  style="width: 100%;">
                  </div>

                  <!-- <div class="form-group">
                  <label>NTN No.<span class="text-danger">*</span></label>
                  <input type="text" name="ntn" class="form-control select2" value="{{old('payee_title')}}"  style="width: 100%;">
                  </div> -->

                  <div class="form-group">
                  <label>Address<span class="text-danger">*</span></label>
                  <textarea name="address" class="form-control"></textarea>
                  </div>
                
                <!-- /.form-group -->

                
                 
                 <div class="form-group">
                  <input type="checkbox" name="activeness" value="1" id="activeness" class=""  checked>
                  <label>Active</label>
                  </div>


                
                

                  </fieldset>

               
                
              </div>
              <!-- /.col -->
              <div class="col-md-5">

                
                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                   
                <!-- /.form-group -->
               <!--  <div class="form-group">
                  <label>Country</label>
                  <select class="form-control select2" name="country" onchange="set_country_detail()" id="country" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    
                  </select>
                  </div>

                <div class="form-group">
                  <label>Province</label>
                  <select class="form-control select2" name="province" id="province" onchange="set_province_detail()" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Region</label>
                  <select class="form-control select2" name="region" id="region" onchange="set_region_detail()" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                   
                  </select>
                </div>

                <div class="row">
                   <div class="col-md-12">
                     
                     <div class="form-group">
                  <label>District</label>
                  <select class="form-control select2" name="district" id="district" onchange="set_district_detail()" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                   
                  </select>
                </div>

                <div class="form-group">
                  <label>City</label>
                  <select class="form-control select2" name="city" id="city" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                  </select>
                </div> -->

                <!-- <div class="form-group">
                  <label>Credit Days<span class="text-danger">*</span></label>
                  <input type="text" name="credit_days" class="form-control select2" value="{{old('credit_days')}}"  style="width: 100%;">
                 
                </div>
 -->

                   </div>
                   <div class="col-md-1">
                     
                     <!-- <div class="form-group">
                  <label>Belt</label>
                  <select class="form-control select2" name="type" id="type" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    <option value="">1</option>
                    <option value="">2</option>
                  </select>
                </div> -->

                <!-- <div class="form-group">
                  <label>Territory</label>
                  <select class="form-control select2" name="type" id="type" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    <option value="">1</option>
                    <option value="">2</option>
                  </select>
                </div> -->

                <!-- <div class="form-group">
                  <label>Advance Limit<span class="text-danger">*</span></label>
                  <input type="text" name="item_code" class="form-control select2" value="{{old('item_code')}}" required style="width: 100%;">
                 
                </div> -->


                   </div>
                </div>

              

                 
                  </fieldset>    

               


             

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

                   



        
      </div>

      </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script type="text/javascript">

  $(document).ready(function(){

$('.select2').select2(); 


});

function set_country_detail() {

    country= jQuery('#country').val();
    //link='{{ url("/get/country/detail") }}';



    $('#province').html('<option value="">------Select any province-----</option>');
    $('#region').html('<option value="">------Select any region-----</option>');
    $('#district').html('<option value="">------Select any district-----</option>');
    $('#city_body').html('');

    $.ajax({
               type:'get',
               url:  '{{ url("/get/country/detail") }}' ,
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
  