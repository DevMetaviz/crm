
@extends('layout.master')
@section('title', 'Add New Vendor')
@section('header-css')

@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
   

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Vendor</h1>
            <button type="submit" form="form" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('/configuration/vendors')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>List</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('/configuration/vendors')}}">Vendors</a></li>
              <li class="breadcrumb-item active">Add New Vendor</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

 <form role="form" method="POST" id="form" action="{{url('/configuration/vendor/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
    
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
                  <label>Vendor Name<span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control" value="{{old('name')}}" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Vendor Type</label>
                  <select class="form-control" name="type" id="type"   style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($vendor_types as $type)
                    <option value="{{$type['id']}}">{{$type['text']}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Creditor Account<span class="text-danger">*</span></label>
                  <select class="form-control" name="creditor_account_type" id="creditor_account_type" required  style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($accounts as $type)
                    <option value="{{$type['id']}}">{{$type['name']}}</option>
                    @endforeach
                  </select>
                </div>

                
                <div class="form-group">
                  <label>Mobile No<span class="text-danger">*</span></label>
                  <input type="text" name="mobile" class="form-control" value="{{old('mobile')}}" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Phone No</label>
                  <input type="text" name="phone" class="form-control " value="{{old('phone')}}"  style="width: 100%;">
                 
                </div>


                   <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control " value="{{old('email')}}"  style="width: 100%;">
                  </div>

                  
                  <div class="form-group">
                  <label>Bank 1</label>
                  <select class="form-control" name="bank1" id="bank1" >
                    <option value="">------Select any value-----</option>
                    <option value="Meezan Bank Ltd">Meezan Bank Ltd</option>
                    <option value="Habib Bank Ltd">Habib Bank Ltd</option>
                    <option value="United Bank Ltd">United Bank Ltd</option>
                    <option value="Faisal Bank Ltd">Faisal Bank Ltd</option>
                    <option value="Bank Alflah">Bank Alflah</option>
                    <option value="National Bank">National Bank</option>
                    <option value="Allied Bank">Allied Bank</option>
                    <option value="Bank of Punjab">Bank of Punjab</option>
                    <option value="Habib Metropolitan Bank">Habib Metropolitan Bank</option>
                    <option value="Bank AL Habib">Bank AL Habib</option>
                    <option value="Askari Bank">Askari Bank</option>
                    <option value="BankIslami">BankIslami</option>
                    <option value="MCB Islamic Bank Limited">MCB Islamic Bank Limited</option>
                    <option value="MCB Bank Limited">MCB Bank Limited</option>
                    <option value="JS Bank Limited">JS Bank Limited</option>
                    <option value="Standard Chartered Bank (Pakistan) Limited">Standard Chartered Bank (Pakistan) Limited</option>
                    <option value="Dubai Islamic Bank Pakistan Ltd">Dubai Islamic Bank Pakistan Ltd</option>
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Account Title 1<span class="text-danger"></span></label>
                  <input type="text" name="account_title1" class="form-control" value="{{old('account_title1')}}"  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Account No 1<span class="text-danger"></span></label>
                  <input type="text" name="account_no1" class="form-control" value="{{old('account_no1')}}"  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Bank 2</label>
                  <select class="form-control" name="bank2" id="bank2" >
                    <option value="">------Select any value-----</option>
                    <option value="Meezan Bank Ltd">Meezan Bank Ltd</option>
                    <option value="Habib Bank Ltd">Habib Bank Ltd</option>
                    <option value="United Bank Ltd">United Bank Ltd</option>
                    <option value="Faisal Bank Ltd">Faisal Bank Ltd</option>
                    <option value="Bank Alflah">Bank Alflah</option>
                    <option value="National Bank">National Bank</option>
                    <option value="Allied Bank">Allied Bank</option>
                    <option value="Bank of Punjab">Bank of Punjab</option>
                    <option value="Habib Metropolitan Bank">Habib Metropolitan Bank</option>
                    <option value="Bank AL Habib">Bank AL Habib</option>
                    <option value="Askari Bank">Askari Bank</option>
                    <option value="BankIslami">BankIslami</option>
                    <option value="MCB Islamic Bank Limited">MCB Islamic Bank Limited</option>
                    <option value="MCB Bank Limited">MCB Bank Limited</option>
                    <option value="JS Bank Limited">JS Bank Limited</option>
                    <option value="Standard Chartered Bank (Pakistan) Limited">Standard Chartered Bank (Pakistan) Limited</option>
                    <option value="Dubai Islamic Bank Pakistan Ltd">Dubai Islamic Bank Pakistan Ltd</option>
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Account Title 2<span class="text-danger"></span></label>
                  <input type="text" name="account_title2" class="form-control" value="{{old('account_title2')}}"  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Account No 2<span class="text-danger"></span></label>
                  <input type="text" name="account_no2" class="form-control" value="{{old('account_no2')}}"  style="width: 100%;">
                  </div>



                  <div class="form-group">
                  <label>Address<span class="text-danger">*</span></label>
                  <textarea name="address" class="form-control" required></textarea>
                  </div>
                
                <!-- /.form-group -->

                
                 
                 <div class="form-group">
                  <input type="checkbox" name="status" value="1" id="status" class=""  checked>
                  <label>Active</label>
                  </div>


                
                

                  </fieldset>

               
                
              </div>
              <!-- /.col -->
              <div class="col-md-5">

                

                  <fieldset class="border p-4">
                   <legend class="w-auto"></legend>

                <!-- /.form-group -->
                <!---<div class="form-group">
                  <label>Country</label>
                  <select class="form-control" name="country" onchange="set_country_detail()" id="country" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($countries as $con)
                    <option value="{{$con['id']}}">{{$con['name']}}</option>
                    @endforeach
                  </select>
                  </div>

                <div class="form-group">
                  <label>Province</label>
                  <select class="form-control" name="province" id="province" onchange="set_province_detail()" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    
                  </select>
                  </div>

                  <div class="form-group">
                  <label>Region</label>
                  <select class="form-control" name="region" id="region" onchange="set_region_detail()" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                   
                  </select>
                </div>-->

                <div class="row">
                   <div class="col-md-12">
                     
                     <!--<div class="form-group">
                  <label>District</label>
                  <select class="form-control" name="district" id="district" onchange="set_district_detail()" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                   
                  </select>
                </div>

                <div class="form-group">
                  <label>City</label>
                  <select class="form-control" name="city" id="city" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                  </select>
                </div>-->

                <div class="form-group">
                  <label>CNIC</label>
                  <input type="text" name="cnic" class="form-control" value="{{old('cnic')}}"  style="width: 100%;">
                 
                </div>


                 <div class="form-group">
                  <label>City</label>
                  <select class="form-control" name="city_id" id="city_id"  ><!--onchange="set_territory()"-->
                    <option value="">Select any value</option>
                    @foreach($cities as $city)
                    <option value="{{$city['id']}}" >{{$city['name']}}</option>
                    @endforeach
                  </select>
                </div>


                   </div>
                  
                </div>

                <div class="form-group">
                  <label>NTN Number</label>
                  <input type="text" name="ntn_number" class="form-control" value="{{old('ntn_number')}}"  style="width: 100%;">
                 
                </div>

                <div class="form-group">
                  <label>SalesTax No.</label>
                  <input type="text" name="salestax_num" class="form-control" value="{{old('salestax_num')}}"  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Comment</label>
                  <textarea name="comment" class="form-control"></textarea>
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


  $('#form').validate({
    rules: {
      
    },
    messages: {
      
    },
    submitHandler: function (form) {
        //alert("Form submitted successfully!");
        form.submit(); // uncomment for real submission
      },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
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
  