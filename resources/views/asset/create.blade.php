
@extends('layout.master')
@section('title', 'Add New Asset')
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
    <form role="form" method="POST" action="{{url('asset/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Asset</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('sale-point/list')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Asset List</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Asset</a></li>
              <li class="breadcrumb-item active">Add New Asset</li>
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
                  <label>Asset Name</label>
                  <input type="text" name="name" class="form-control" value="" required style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Asset Number</label>
                  <input type="text" name="number" class="form-control" value="{{$number}}" required style="width: 100%;">
                  </div>


                  <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category_id" id="category_id" required  style="width: 100%;">
                    <option>------Select any value-----</option>
                    <option value="1">Machinery</option>
                
                  </select>
                </div>

                <div class="form-group">
                  <label>Type</label>
                  <select class="form-control select2" name="type_id" id="type_id" required  style="width: 100%;">
                    <option>------Select any value-----</option>
                    <option value="1">Blister Machine</option>
                
                  </select>
                </div>

                <div class="form-group">
                  <label>Brand</label>
                  <input type="text" name="brand" class="form-control" value="{{old('brand')}}"  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Model</label>
                  <input type="text" name="model" class="form-control" value="{{old('model')}}"  style="width: 100%;">
                  </div>


                 <div class="form-group">
                  <label>Serial No</label>
                  <input type="text" name="serial_no" class="form-control" value="{{old('serial_no')}}"  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Condition</label>
                  <select class="form-control select2" name="condition_id" id="condition_id"   style="width: 100%;">
                    <option>------Select any value-----</option>
                    <option value="1">New</option>
                
                  </select>
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control " name="status_id" id="status_id"   style="width: 100%;">
                    <option>------Select any value-----</option>
                    <option value=""></option>
                
                  </select>
                </div>

                <div class="form-group">
                  <label>Location</label>
                  <select class="form-control " name="location_id" id="location_id"   style="width: 100%;">
                    <option>------Select any value-----</option>
                    <option value=""></option>
                
                  </select>
                </div>

                <div class="form-group">
                  <label>Manufacture</label>
                  <input type="text" name="manufacture" class="form-control" value="{{old('manufacture')}}"  style="width: 100%;">
                  </div>


                <div class="form-group">
                  <label>Vendor</label>
                  <select class="form-control select2" name="vendor_id" id="vendor_id" required  style="width: 100%;">
                    <option>------Select any value-----</option>
                    @foreach($vendors as $ven)
                    <option value="{{$ven['id']}}">{{$ven['name']}}</option>
                    @endforeach
                
                  </select>
                </div>


           

                  <div class="form-group">
                  <label>Purchase Date<span class="text-danger">*</span></label>
                  <input type="date" name="purchase_date" class="form-control" value="{{Date('Y-m-d')}}"  style="width: 100%;" required>
                </div>


                   <div class="form-group">
                  <label>Purchase Price<span class="text-danger">*</span></label>
                  <input type="number" step="any" name="purchase_price" id="purchase_price" class="form-control" value="{{old('purchase_price')}}" onchange="setTax()" required  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Current Value<span class="text-danger">*</span></label>
                  <input type="number" step="any" name="current_value" class="form-control" value=""  style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Warranty Expire<span class="text-danger">*</span></label>
                  <input type="date" name="warranty_expire" class="form-control" value="{{old('warranty_expire')}}"  style="width: 100%;">
                </div>

                  <div class="form-group">
                  <label>Description<span class="text-danger"></span></label>
                  <textarea name="description" class="form-control"></textarea>
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
                   <legend class="w-auto">W.H Tax</legend>

                   <div class="form-group">
                  <label>W.H Tax %<span class="text-danger"></span></label>
                  <input type="number" step="any" name="wh_tax" id="wh_tax"  class="form-control" value=""  style="width: 100%;" onchange="setTax()">
                  </div>

                  <div class="form-group">
                  <label>Amount<span class="text-danger"></span></label>
                  <input type="number" step="any" name="wh_amount" id="wh_amount" class="form-control" value="" readonly  style="width: 100%;">
                </div>

                   
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

function setTax()
{
   var price= jQuery('#purchase_price').val();
   var tax= jQuery('#wh_tax').val();
   if(price=='')
       price=0;
     if(tax=='')
       tax=0;

     amount=(tax / 100 ) * price;
     amount=amount.toFixed(2);

      jQuery('#wh_amount').val(amount); 
}


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
  