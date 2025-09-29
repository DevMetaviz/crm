
@extends('layout.master')
@section('title', 'Edit Sub Sub Accounts')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('sub/sub/account/update')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit Sub Sub Accounts</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="submit" form="delete_form" style="border: none;background-color: transparent;"><span class="fas fa-trash">&nbsp</span>Delete</button>
            <a class="btn" href="{{url('sub/sub/accounts')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Chart Of Accounts</a></li>
              <li class="breadcrumb-item active">Edit Sub Sub Account</li>
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



             @if($errors->has('error'))
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                          <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                        </div>  
                                @endif

            

                                       
                        <fieldset class="border p-4">
                   <legend class="w-auto">Edit Sub Sub Account</legend>
                   <div class="row">
                    <div class="col-md-6">
                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                  <input type="hidden" value="{{$account['id']}}" name="id"/>

                 <div class="form-row">

              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Sub A/C:</label>
                  <select name="sub_acc" id="sub_acc" class="form-control select2 col-sm-8" onchange="setSubCode()">
                    <option value="">Select any sub account</option>
                    @foreach($sub_accounts as $ac)
                    <option value="{{$ac['id']}}">{{$ac['code'].'~'.$ac['name']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Sub Sub A/C Code:</label>
                  <input type="text"  name="sub_code" id="sub_code" class="form-control col-sm-2" value=""  readonly style="width: 100%;"> 
                  <label class="col-sm-1">-</label>
                  <input type="number"  name="sub_sub_code" id="sub_sub_code" class="form-control select2 col-sm-5" value=""  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Sub Sub A/C Name:</label>
                  <input type="text"  name="name" class="form-control col-sm-8" value="{{$account['name']}}"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">A/C Type:</label>
                  <select name="acc_type" id="acc_type" class="form-control select2 col-sm-8" required onchange="">
                    <option value="">Select any type</option>
                    @foreach($types as $type)
                    <option value="{{$type['id']}}">{{$type['name']}}</option>
                    @endforeach
                    
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="status" value="1" id="status" class="" >&nbsp&nbspActive</label>
                  </div>
                </div>

               </div>
                
                  </div>

                  <div class="col-md-4" >
                       
                       <div class="form-row">
                       <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks:</label>
                  <textarea name="remarks" class="form-control select2 col-sm-8">{{$account['remarks']}}</textarea>
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
                    <th>Sub A/C</th>
                    <th>A/C Code</th>
                    <th>A/C Name</th>
                    <th>A/C Type</th>
                   <th>Remarks</th>
                  
                    <th>Status</th>
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody id="account_body">
                  
   
                        
                    <?php $i=1; ?>
                    @foreach($sub_sub_accounts as $acc)
                    <tr>
                     <td>{{$i}}</td>
                     <td>{{$acc['sub_account']['name']}}</td>
                     <td>{{$acc['code']}}</td>
                    <td>{{$acc['name']}}</td>
                    <td>{{$acc['account_type']['name']}}</td>
                    <td>{{$acc['remarks']}}</td>
                  <?php
                     $status=$acc['status'];
                      if($status=='1')
                          $status='Active';
                        else
                          $status='Inactive';
                   ?>
                    <td>{{$status}}</td>
                      <td><a href="{{url('edit/sub/sub/account/'.$acc['id'])}}"><span class="fa fa-edit"></span></a></td>
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

    <form role="form" id="delete_form" method="POST" action="{{url('/delete/sub/sub/account/'.$account['id'])}}">
               @csrf    
    </form>
   
@endsection

@section('jquery-code')


<script type="text/javascript">

  $(document).ready(function(){
  

   value1="{{ $account['super_id'] }}";
   
   if(value1!="")
   {
    
  $('#sub_acc').find('option[value="{{$account['super_id']}}"]').attr("selected", "selected");
   
   }

   value1="{{ $account['acc_type'] }}";
   
   if(value1!="")
   {
    
  $('#acc_type').find('option[value="{{$account['acc_type']}}"]').attr("selected", "selected");
   
   }

   value1="{{ $account['status'] }}";

   if(value1=="1")
   {
    
  $('#status').prop("checked", true);
   
   }
    else{
      $('#status').prop("checked", false);
  
    } 

    var code="{{ $account['code'] }}";
    var code=code.split('-');

     
     $('#sub_code').val(code[0]+'-'+code[1]);
     $('#sub_sub_code').val(code[2]);

 });

function setSubCode()
  {
    
    var txt=$("#sub_acc option:selected").text();
    var txt1=$("#sub_acc option:selected").val();

    if(txt1=='')
    {
       $('#sub_sub_code').val('');
       $('#sub_code').val('');
       $('#account_body').html('');

       return ;
    }
    var txt=txt.split('~');

    $('#sub_code').val(txt[0]);

     var account=$('#sub_acc').val();
    

    $.ajax({
               type:'get',
               url:'{{ url("/get/account/code") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     account: account ,
                                   },
               success:function(data) {

                var code=data['code'];
                var accounts=data['sub_accounts'];


                var super_id="{{ $account['super_id'] }}";
    if(txt1==super_id)
    {
      var code="{{ $account['code'] }}";
      var code=code.split('-');
        $('#sub_sub_code').val(code[2]);
    }
    else{
                 $('#sub_sub_code').val(code);
               }

                 
                 

                    all = ``;

                    for (var i =0;i < accounts.length ; i ++) {
                      
                      var active='Inactive';
                      if(accounts[i]['status']==1)
                      {
                        active='Active';
                      }

                      var remarks='';
                      if(accounts[i]['remarks']!=null)
                      {
                        remarks=accounts[i]['remarks'];
                      }

                      var link='{{ url("/edit/sub/sub/account") }}' +'/'+ accounts[i]['id'] ;
                      
                      txt  = `
                         <tr>
                           <td></td>
                           <td>${accounts[i]['super_account']['name']}</td>
                           <td>${accounts[i]['code']}</td>
                           <td>${accounts[i]['name']}</td>
                           <td>${accounts[i]['account_type']['name']}</td>
                           <td>${remarks}</td>
                           <td>${active}</td>
                           <td><a  href="${link}"><span class="fa fa-edit"></span></a></td>
                         </tr>
                      `;

                      all=all.concat(txt);
                    }
                   
                   //alert(sub_accounts);
                 $('#account_body').html(all);
                 



               }
             });

  }
  
</script>




@endsection  
  