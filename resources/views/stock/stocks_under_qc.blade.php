
@extends('layout.master')
@section('title', 'Stock Under QC')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Stock Under QC</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Stock</a></li>
              <li class="breadcrumb-item active">Under QC</li>
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
                <h3 class="card-title">Stocks</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>No.</th>
                    <th>GRN No</th>
                    <th>Vendor</th>
                    <th>Location</th>
                    <th>Item Code</th>
                    <th>Item name</th>

                    <th>Origin</th>
                  
                    <th>Batch #</th>
                    
                    <th>Mfg. Date</th>
                    <th>Exp. Date</th>
                    
                    <th>Rec Qty</th>
                    <th>Unit</th>
                    <th>Pack Size</th>
                    <th>Total Qty</th>
                    <th>Rec Date</th>
                    <th></th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $stocks) ; $i++)

          
                      
                        <tr>
                   
                     <td>{{$i+1}}</td>
                     <td>{{$stocks[$i]['grn_no']}}</td>
                     <td>{{$stocks[$i]['vendor_name']}}</td>
                     <td>{{$stocks[$i]['location']}}</td>
                     <td>{{$stocks[$i]['item_code']}}</td>
                    <td>{{$stocks[$i]['item_name']}}</td>
                     <td>{{$stocks[$i]['origin']}}</td>
                      <td>{{$stocks[$i]['batch_no']}}</td>
                     <td>{{$stocks[$i]['mfg_date']}}</td>
                     <td>{{$stocks[$i]['exp_date']}}</td>
                     
                     <td>{{$stocks[$i]['rec_qty']}}</td>
                     <td>{{$stocks[$i]['unit']}}</td>
                     <td>{{$stocks[$i]['pack_size']}}</td>
                     
                     <?php $total=$stocks[$i]['pack_size'] * $stocks[$i]['rec_qty'] ; ?>
                     <td>{{$total}}</td>
                     <td>{{$stocks[$i]['rec_date']}}</td>
                     <th><a href="#"><span class="fa fa-edit"></span></a></th>
                    </tr>
                   <!--  <tr><td colspan="8"></td></tr> -->

                    @endfor
                
                  
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







@endsection  
  