
@extends('layout.master')
@section('title', 'Items Stock1')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Expired Stock</h1>
           <!--  <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>-->
            <a class="btn" href="{{url('print/expired')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Print</a> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Items</a></li>
              <li class="breadcrumb-item active">Stock</li>
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
                <h3 class="card-title">Stock List</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

             

        
                @if(isset($items))
                
                  <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                    <tr>
                    <th>No.</th>
                    <th>Item Discription</th>
                          
                        
                         <th>{{'Batch No'}}</th>
                      

                                               
                    
                    <th>Expiry Date</th>
                    <!-- <th>Opening</th>
                    <th>Purchase Qty</th>
                    <th>Production</th>
                     <th>Issue Qty</th>
                    <th>Sale Qty</th>
                    <th>Purchase Return</th>
                    <th>Sale Return</th> -->
                    <th>Closing</th>
                  
                  
                  </tr>


                  </thead>
                  <tbody>
                    
                  
                   <?php $i=1; ?>
                    @foreach($items as $item) 

                         <?php 
                          $list=[];
                            $list= $item['batches'] ;
                           
                           $no=count($list); 
                           
                           ?>

                      

                      <tr>
                  
                        @if($no==0)

                     <td>{{$i}}</td>
                    
                    
                    <td>{{$item['item_name']}}</td>

                        <td></td>
                        <td></td>
                      <td></td>
                      <!-- <td></td>
                     <td></td>
                      <td></td>                
                     <td></td>
                     <td></td>
                      <td></td>                
                     <td></td> -->

                     @else
                         
                     <td rowspan="{{$no}}">{{$i}}</td>
                    
                    
                    <td  rowspan="{{$no}}">{{$item['item']['item_name']}}</td>
                        
                        <?php $k=1; ?>

                     @foreach($list as $stk) 

                     <?php    

                             
                         ?>
                      
                      @if($k!=1)
                      <tr>
                        @endif
                        

                      
                        <td>{{$stk['batch_no']}}</td>

                        
                      <td>{{$stk['exp_date']}}</td>
                      <td>{{$stk['current']}}</td>
                     <!-- <td></td>
                      <td></td>
                       <td></td>
                     <td></td>
                     <td></td>
                      <td></td>               
                     <td></td> -->

                     @if($k!=1)
                      </tr>
                        @endif
                     
                     <?php $k++; ?>
                    @endforeach


                     @endif
                     </tr>
                     
                     
                     <?php $i++; ?>
                     @endforeach
                
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
                </table>

                

                
            
              

               @endif
              
                  
                  
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



});

</script>

@endsection  
  