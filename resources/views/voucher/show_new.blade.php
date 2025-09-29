
@extends('layout.master')
@section('title', 'Create New Voucher')
@section('header-css')



@endsection
@section('content-header')

    <!-- Content Header (Page header) -->
   
      <div class="row default-header"  >
        <div class="col-sm-6">
          <h1 class="text-capitalize" >{{$voucher['category']}} Voucher</h1>
         </div>
        <div class="col-sm-6 text-right">

           <button form="purchase_demand" type="submit" class="btn btn-primary"><span class="fas fa-save">&nbsp</span>{{ isset($voucher['id']) ? 'Update' : 'Save' }}</button>

            @if(isset($voucher['id']))
                        <button type="button"  class="btn btn-action" data-toggle="modal" data-target="#modal-del" >
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <a class="btn btn-transparent" href="{{url('voucher/'.$voucher['category'].'/create')}}" ><span class="fas fa-plus">&nbsp</span>New</a>

                        @endif
           
                   <a class="btn btn-transparent text-capitalize" href="{{url('voucher/'.$voucher['category'].'/list')}}" ><span class="fas fa-history">&nbsp</span>{{$voucher['category']}} List</a>

            @if(isset($voucher['id']))
                  

                  <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                       <li><a href="{{url('/voucher/report/'.$voucher['id'])}}" class="dropdown-item">Voucher</a></li>
                      <li><a href="{{url('/voucher/report1/'.$voucher['id'])}}" class="dropdown-item">Voucher1</a></li>
                      <li><a href="{{url('/voucher/report2/'.$voucher['id'])}}" class="dropdown-item">Voucher2</a></li>
                      
                    </ul>
                  </div>
                  @endif
         

          
        </div>
      </div>

         <ol class="breadcrumb default-breadcrumb"  >
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Voucher</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="#">{{$voucher['category']}}</a></li>
            <li class="breadcrumb-item active">View</li>
          </ol>
  @endsection

@section('content')
    <!-- Main content -->

     <!-- /.delete modal -->
          <div class="modal fade" id="modal-del">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title ">Confirmation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Do you want to delete?&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
              <button form="delete_form" class="btn btn-outline-light">Yes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.delete modal -->



     <form role="form" id="delete_form" method="POST" action="{{url('/delete_new/voucher/'.$voucher['id'])}}">
     @csrf    
    </form>


    <!-- /print modal -->
          <div class="modal fade" id="modal-print">
        <div class="modal-dialog">
          <div class="modal-content bg-gradient-info">
            <div class="modal-header">
              <h4 class="modal-title ">Confirmation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Do you want to Print?&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
              <!-- <button form="button" class="btn btn-outline-light">Yes</button> -->
              <a class="btn btn-outline-light" id="print_btn"  href="{{url('/voucher/report/'.session()->get('voucher_id') )}}" target="_blank" >Yes</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.print modal -->


     @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             
                        @if ($errors->has('error'))                       
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                                          </div>  
                        @endif


                @error('voucher_no')
                <!--<div class="alert alert-danger">
                {{ $message }}
               </div>-->
                @enderror


                        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif




        
 

      <div class="container-fluid" style="margin-top: 10px;">

           <h4 class="form-section-title text-capitalize mt-4"><i class="fas fa-file-alt mr-2"></i>{{$voucher['category']}} Voucher</h4>

          {{-- Voucher Details --}}


         <div class="row mb-4">

            <div class="col-sm-4">
                <b>Voucher No: </b>{{$voucher['voucher_no']}}<br>
                <b>Voucher Date: </b>{{$voucher['voucher_date']}}<br>
                <b>Pay Method: </b>{{$voucher->pay_method}}<br>
            </div>
            <div class="col-sm-4">

                <b>
                    @if($voucher['category']=='receipt')
                        Receive In: 
                        @else 
                        Pay From: 
                        @endif

                    </b> 

                    <?php   

                       $pay_to='';

                     if(isset($voucher['id'])){

                       if($voucher['category']=='receipt')
                      $pay_to=$voucher->accounts->where('pivot.debit','<>',0)->first();
                      else
                       $pay_to=$voucher->accounts->where('pivot.credit','<>',0)->first();

                        
                     }
                           
                     ?>

                     {{$pay_to['name']}}

                    <br>
                 <b>Company: </b>{{$voucher['company']['name']}}<br>
                 <b>Branch: </b>{{$voucher['branch']['name']}}<br>
            </div>

         </div>

       

        {{-- Currency Breakdown --}}
        @if($voucher['pay_method']=='cash')
        <h5>Currency Breakdown:</h5>
        <table class="table table-bordered" id="currency-table">
            <thead class="thead-light">
                <tr>
                    <th>Denomination</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php 

                       $all_denominations = [5000,1000,500,100,50,20,10,'coin'];

                             $denominations = explode(',', $voucher['denominations'] ?? '');
                             $quantities    = explode(',', $voucher['notes'] ?? '');

                             $total=0;

                 @endphp
                @foreach($all_denominations as $i=>$denomination)

                     @php
                $qty = $quantities[$i] ?? 0;

                $t=$qty*$denominations[$i];

                $total += $t;
               
            @endphp

                    <tr>
                        <td>
                            {{ is_numeric($denomination) ? number_format($denomination) : ucfirst($denomination) }}
                        </td>
                        <td>
                           {{number_format($qty,2)}}
                        </td>
                        <td class="row-total">{{number_format($t,2)}}</td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr class="font-weight-bold">
                    <td colspan="2" class="text-right">Grand Total</td>
                    <td id="currency-total">{{number_format($total,2)}}</td>
                </tr>
            </tfoot>
        </table>
        @endif
        

        {{-- Accounts Breakdown --}}
        <h5>Accounts Detail:</h5>
        <table class="table table-bordered add-lines-table" id="selectedItems">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th style="width: 500px;">Account</th>
                    <th>Remarks</th>

                     @if($voucher['pay_method']=='bank')  
                    <th>Cheque No</th>
                    <th>Cheque Date</th>
                    @endif

                    <th>Amount</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                     
                 @if(isset($voucher['accounts']) && count($voucher['accounts']) > 0)

                   <?php
                                

                                if($voucher['category']=='receipt')
                                $transections=$voucher->accounts->where('pivot.credit','<>',0);
                                else
                                $transections=$voucher->accounts->where('pivot.debit','<>',0);

                            $v_no=1;

                            $subTotal=0;
                   ?>

                     @foreach($transections  as $account)

                     <?php

                          if($voucher['category']=='receipt')
                                $amount=$account['pivot']['credit'];
                                else
                                $amount=$account['pivot']['debit'];

                            $subTotal += $amount;

                     ?>

                <tr class="item-row">
                    <td class="row-num">{{$v_no}}</td>
                    <td>
                        {{$account['code'].' '.$account['name']}}
                    </td>
                    <td>{{$account['pivot']['remarks']}}</td>
                    
                     @if($voucher['pay_method']=='bank')  
                     <td>
                         {{$account['pivot']['cheque_no']}}
                     </td>

                      <td>

                      {{$account['pivot']['cheque_date']}}
                        </td>
                        @endif 

                      <td>{{$amount}}</td>

                   

                </tr>
                <?php $v_no++; ?>
                 @endforeach
                
               
                @endif
            </tbody>
            <tfoot>
                <tr class="font-weight-bold">
                    <td></td>
                    <td></td>
                    <td></td>

                     @if($voucher['pay_method']=='bank')  
                    <td></td>
                    <td></td>
                    @endif

                    <td id="accounts-total">0</td>
                

                </tr>
            </tfoot>
        </table>
      

      

        


        {{-- Error if mismatch --}}
        <div id="total-error" class="alert alert-danger d-none"></div>

       



                   <div id="" class="row mt-2">
            
            @if(isset($voucher['files']))
            @foreach($voucher['files'] as $file )
            <div class="col-md-3 mb-2">  
                        <div class="card shadow-sm">
                            <img src="{{asset('public/'.$file['path'])}}" class="card-img-top" style="height:150px;object-fit:cover;">
                            <!--<div class="card-body p-2 text-center">
                                <small>${file.name}</small>
                            </div>-->
                        </div>
                    </div>
                    @endforeach
                    @endif

        </div>



        
      </div>

   
    <!-- /.content -->

  
   
@endsection

@section('jquery-code')


<script type="text/javascript">


   

</script>


@endsection  









  