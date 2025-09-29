
@extends('layout.master')
@section('title', 'Edit Config Commission')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" id="com_form" action="{{url('update/config/commission/area-wise/')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Area Wise Commission</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <a class="btn" href="{{url('config/commission/history/')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
            <a class="btn" href="{{url('config/commission/area-wise/')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Salesman</a></li>
              <li class="breadcrumb-item active">Config Commission</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Process Parameters</h3>
              
              </div>
 -->              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

            

                                       
                        <fieldset class="border p-4">
                   <legend class="w-auto">General</legend>
                   <div class="row">
                    <div class="col-md-6">
                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                  <input type="hidden" value="{{$commission['id']}}" name="id"/>

                 <div class="form-row">

              

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Saleman:</label>
                  <select name="salesman_id" id="salesman_id" class="form-control select2 col-sm-8" onchange="getCustomers()" required onchange="">
                    <option value="">Select any value</option>
                    @foreach($men as $mn)
                    <option value="{{$mn['id']}}">{{$mn['name']}}</option>
                    @endforeach
                   </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Customer:</label>
                  <select name="customer_id" id="customer_id" class="form-control select2 col-sm-8"  onchange="">
                    <option value="">Select any value</option>
                    @foreach($commission['salesman']['customers'] as $mn)
                    <option value="{{$mn['id']}}">{{$mn['name']}}</option>
                    @endforeach
                    
                  </select>
                  </div>
                 </div>


                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Calculation Method:</label>
                  <select name="type" id="type" class="form-control col-sm-8"  onchange="">
                    <option value="">Select any type</option>
                    
                    <option value="flat">Flat</option>
                    <option value="percentage">Percentage</option>
                
                    
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Value:</label>
                  <input type="number" step="any"  name="value" class="form-control col-sm-8" value="{{$commission['value']}}"   style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="activeness" value="1" id="activeness" class="" checked>&nbsp&nbspActive</label>
                  </div>
                </div>

               </div>
                
                  </div>

                  <div class="col-md-6" >

                    <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Country:</label>
                  <select name="country_id" id="country" class="form-control select2 col-sm-8" onchange="set_states()">
                    <option value="">Select any value</option>
                    @foreach($countries as $mn)
                    <option value="{{$mn['id']}}">{{$mn['name']}}</option>
                    @endforeach
                   </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">State:</label>
                  <select name="state_id" id="state" class="form-control select2 col-sm-8"   onchange="set_regions()">
                    <option value="">Select any value</option>
                   </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Region:</label>
                  <select name="region_id" id="region" class="form-control select2 col-sm-8"  onchange="set_districts()">
                    <option value="">Select any value</option>
                   </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">District:</label>
                  <select name="district_id" id="district" class="form-control select2 col-sm-8"  onchange="set_cities()">
                    <option value="">Select any value</option>
                   </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">City:</label>
                  <select name="city_id" id="city" class="form-control select2 col-sm-8"  onchange="set_territory()">
                    <option value="">Select any value</option>
                   </select>
                  </div>
                 </div>

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Territory:</label>
                  <select name="territory_id" id="territory" class="form-control select2 col-sm-8" onchange="">
                    <option value="">Select any value</option>
                   </select>
                  </div>
                 </div>
                       
                       <div class="form-row">
                       <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks:</label>
                  <textarea name="remarks" class="form-control select2 col-sm-8">{{$commission['remarks']}}</textarea>
                  </div>
                 </div>
               </div>

                  </div>


                  </div>
                       </fieldset>

                  </form>
                     
                  

          

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                    <tr>
                    <th>#</th>
                    
                    <th>Item</th>
                    <th>Type</th>
                   <th>Value</th>
                 
                  </tr>


                  </thead>
                  <tbody>
                  
   
                        
                   <?php $i=1; ?>
                    @foreach($items as $item)
                      <?php  $type=''; $value=''; $flat=''; $percent='';
                             $it=$commission->items->where('id',$item['id'])->first();
                             if($it!='')
                             {
                              $type=$it['pivot']['type']; 
                               $value=$it['pivot']['value'];
                                   if($type=='flat')
                                   $flat='selected';
                                    elseif($type=='percentage')
                                    $percent='selected';
                                }
                       ?>
                    <tr>
                     <td>{{$i}}<input type="hidden" name="items[]" form="com_form" value="{{$item['id']}}"></td>
                     <td>{{$item['item_name']}}</td>
                     <td>
                       <select name="types[]"  class="form-control" form="com_form"  onchange="">
                    <option value="">Select any type</option>
                    
                    <option value="flat" {{$flat}}>Flat</option>
                    <option value="percentage" {{$percent}}>Percentage</option>
                
                    
                  </select>
                     </td>
                    <td><input type="number" step="any" name="values[]" value="{{$value}}" form="com_form" class="form-control"></td>
                  
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


<script type="text/javascript">

  $(document).ready(function(){ 

value1="{{$commission['activeness'] }}"
   
   
   if(value1=="1")
   {
    
  $('#activeness').prop("checked", true);
   
   }
    else{
      $('#activeness').prop("checked", false);
  
    } 

    salesman_id="{{$commission['salesman_id'] }}";
    $('#salesman_id').val(salesman_id);
   
   type="{{$commission['type'] }}";
    $('#type').val(type);

     customer_id="{{$commission['customer_id'] }}";
    $('#customer_id').val(customer_id);

    setArea();

  });

function setArea() {

  country="{{$commission['country_id'] }}";
    if(country=='' || country==null)
        return ;
      $('#country').val(country);
      set_states();

    state="{{$commission['state_id'] }}";
    if(state=='' || state==null)
        return ;
    $('#state').val(state);
      set_regions();

    region="{{$commission['region_id'] }}";
    if(region=='' || region==null)
        return ;
    $('#region').val(region);
    set_districts();

    district="{{$commission['district_id'] }}";
    if(district=='' || district==null)
        return ;
    $('#district').val(district);
    set_cities();

    city="{{$commission['city_id'] }}";
    if(city=='' || city==null)
        return ;
    $('#city').val(city);
    set_territory();

    territory="{{$commission['territory_id'] }}";
    if(territory=='' || territory==null)
        return ;
    $('#territory').val(territory);

}

  function getCustomers() {
    //add country states
            $.ajax({
               type:'get',
               url:'{{ url("/get/so/customers/") }}',
               data:{
                    
                    so_id: jQuery('#salesman_id').val(),

               },
               success:function(data) {
               
               var customers=data;
            
               <?php
                  // $custs=$men[0]->customers
                ?>
                       // var c=`<?php //echo json_encode($custs); ?>`;
                       // c= JSON.parse( c );
                       
                text='<option value="">------Select any value-----</option>';
                  for(i=0;i<customers.length;i++)
                  {

                    text+=`
                    
          <option value="${customers[i]['id']}">${customers[i]['name']}</option>
           `; 

                  }

                  $('#customer_id').html(text); 
            
              
                
               }
            });

             }



function set_states() {

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
                  $('#state').html(province_text);


  }// end set_states

  function set_regions() {

    country= jQuery('#country').val();
    province= jQuery('#state').val();

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

  }// end set_regions

   function set_districts() {

    country= jQuery('#country').val();
    province= jQuery('#state').val();
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

  }// end set_districts

  function set_cities() {

    country= jQuery('#country').val();
    province= jQuery('#state').val();
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

  }// end set_cities

  function set_territory() {

    country= jQuery('#country').val();
    province= jQuery('#state').val();
    region= jQuery('#region').val();
    district= jQuery('#district').val();
    city= jQuery('#city').val();

    if(city=='')
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

     point = cities.findIndex((item) => item.id == city);

     var ter=cities[point]['territories'];

           text='<option value="">------Select any value-----</option>';
                  for(i=0;i<ter.length;i++)
                  {

                    text+=`<option value="${ter[i]['id']}">${ter[i]['name']}</option>`; 

                  }
                  $('#territory').html(text);

  }// end set_territory
  
</script>




@endsection  
  