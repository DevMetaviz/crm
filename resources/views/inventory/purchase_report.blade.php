
@extends('layout.master')
@section('title', 'Item Purchase Report')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Item Purchase Report</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Item</a></li>
              <li class="breadcrumb-item active">Purchase Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Purchase Report</h3>
                 
                
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('item-purchase-report')}}">
                 

                      

                        <div class="row mb-2">


                          <div class="col-md-6">
                    <div class="form-group">
                  <label>Company</label>
                  <select class="form-control" name="company_id"  >
                    <option value="">Select any value</option>
                    @foreach($companies as $depart)
                    <option value="{{$depart['id']}}"  {{ $depart['id'] == request('company_id')  ? 'selected' : '' }} >{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>



              <div class="col-md-6">
                    <div class="form-group">
                  <label>Branches</label>
                  <select class="form-control" name="branch_id"  >
                    <option value="">Select any value</option>
                    @foreach($branches as $depart)
                    <option value="{{$depart['id']}}"  {{ $depart['id'] == request('branch_id')  ? 'selected' : '' }} >{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                   <div class="col-md-6">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control "  name="from" id="from" value="@if(isset($from)){{$from}}@endif">
                </div>
              </div>

              <div class="col-md-6">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control "  name="to" id="to"  value="@if(isset($to)){{$to}}@endif" >
                </div>
              </div>

               <div class="col-md-6">
                    <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category_id"  >
                    <option value="">Select any value</option>
                    @foreach($categories as $depart)
                    <option value="{{$depart['id']}}"  {{ $depart['id'] == request('category_id')  ? 'selected' : '' }} >{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

               

              <div class="col-md-6">
                    <div class="form-group">
                  <label>Item</label>
                  <select class="form-control select2" onchange="" name="item_id" id="item_id">
                    <option value="">Select any value</option>
                    
                    @foreach($items as $depart)
                    @if(($depart['category_id'] == request('category_id')) || request('category_id') === null)
                    
                    <option value="{{$depart['id']}}" {{ $depart['id'] == request('item_id')  ? 'selected' : '' }} >{{$depart['item_name']}}</option>

                    @endif
                    @endforeach

                  </select>
                </div>
              </div>


              <div class="col-md-6">
                    <div class="form-group">
                  <label>Vendor</label>
                  <select class="form-control select2" onchange="" name="vendor_id" id="vendor_id">
                    <option value="">Select any value</option>
                    
                    @foreach($vendors as $depart)
                    
                    <option value="{{$depart['id']}}" {{ $depart['id'] == request('vendor_id')  ? 'selected' : '' }} >{{$depart['name']}}</option>
                
                    @endforeach

                  </select>
                </div>
              </div>


              <div class="col-md-6">
                    <div class="form-group">
                  <label>City</label>
                  <select class="form-control select2" onchange="" name="city_id" id="city_id">
                    <option value="">Select any value</option>
                    
                    @foreach($cities as $depart)
                  
                    <option value="{{$depart['id']}}" {{ $depart['id'] == request('city_id')  ? 'selected' : '' }} >{{$depart['name']}}</option>
                    
                    @endforeach

                  </select>
                </div>
              </div>


                  
           


                    <div class="col-md-12 text-right">
                    <input type="submit" class="btn btn-info" name="" value="Search">
                     </div>


                    </div>

               
                 </form>

                   <div class="table-responsive" >
                  @if(isset($stocks))
                <table id="example1" class="table table-bordered table-striped table-hover " style="">
                  
                  <thead class="table-primary" >
                    
                  <tr>             
                    <th>#</th>
                    <th>Doc No</th>
                    <th>Date</th>
                    <th>Vendor</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Std Price</th>
                    <th>%</th>

                    <th>Price</th>
                    <th>Unit Weight</th>
                    <th>Total Weight</th>
                    <th>Unit Feet</th>
                    <th>Total Feet</th>
                    <th>Amount</th>
                    
                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; $total_qty=0; $total_weight=0; $total_feet=0; $total_amount=0; ?>
                  @foreach($stocks as $record)
                 
                  <?php $weight=$record['qty']*$record['unit_weight'];

                        $feet=$record['qty']*$record['unit_feet'];

                        $total_qty+=$record['qty']; $total_weight+=$weight; $total_feet+=$feet; $total_amount+=$record['total_amount'];

                   ?>
                  <tr>
                  
                   <td>{{$i}}</td>
                   <td>
                  
                    <a href="{{url('edit/purchase/'.$record['purchase_id'])}}">{{$record['purchase']['doc_no']}}</a>
                   
                   </td>
                   <?php $date=date_create($record['purchase']['doc_date']);
                          $date=date_format($date,"d-M-Y");  ?>
                   <td>{{$date}}</td>
                   <?php $name='';
                      if(isset($record['purchase']['vendor']['name']))
                        $name=$record['purchase']['vendor']['name'];
                    ?>
                   <td>{{$name}}</td>

                    <td>@if(isset($record['item']['category'])){{$record['item']['category']['name']}}@endif</td>

                   <td>{{$record['item']['item_code']}}</td>
                   <td>{{$record['item']['item_name']}}</td>
                   
                    <td>{{$record['qty']}}</td>
                    <td>{{$record['rate']}}</td>
                    <td>{{$record['discount']}}</td>
                    <td>{{$record->rate()}}</td>
                   <td>{{$record['unit_weight']}}</td>
                    <td>{{$weight}}</td>
                   <td>{{$record['unit_feet']}}</td>
                    <td>{{$feet}}</td>

                   
                   <td>{{$record->total_amount}}</td>
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  
                  
                  </tbody>
                  <tfoot>
                    
                  <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>{{$total_qty}}</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>{{$total_weight}}</th>
                      <th></th>
                      <th>{{$total_feet}}</th>
                      <th>{{$total_amount}}</th>
                  </tr>
                  
                  </tfoot>
                </table>
                @endif
             </div>
              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">

  let items = @json($items);

   let companies = @json($companies);


 $(document).on('change', 'select[name="category_id"]', function () {
    let categoryId = $(this).val();
  
    let itemSelect = $('select[name="item_id"]');

    itemSelect.empty().append('<option value="">Select any value</option>');

    if (categoryId) {
        let filteredItems = items.filter(item => item.category_id == categoryId);

        filteredItems.forEach(item => {
            itemSelect.append(
                $('<option>', { value: item.id, text: item.item_name, 'data-weight': item.weight, 'data-feet': item.feet  })
            );
        });
    }
});


 $('select[name="company_id"]').on('change', function () {
        let companyId = $(this).val();
        let branchSelect = $('select[name="branch_id"]');

        branchSelect.empty(); // clear old options

        if (companyId) {
            // Find company in companies array
            let company = companies.find(c => c.id == companyId);

            branchSelect.append('<option value="">Select any branch</option>');

            if (company && company.branches.length > 0) {
                company.branches.forEach(branch => {
                    branchSelect.append(
                        $('<option>', {
                            value: branch.id,
                            text: branch.name
                        })
                    );
                });
            } else {
               // branchSelect.append('<option value="">No branches available</option>');
            }
        }
    });



$(document).ready(function(){

   $('.select2').select2(); 
   
});

 






</script>
@endsection  
  