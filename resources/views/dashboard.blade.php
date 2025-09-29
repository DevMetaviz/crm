
@extends('layout.master')
@section('title', 'Dashboard')
@section('content-header')


    <!-- Content Header (Page header) -->
    
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->

      <style>
        .hd-tbl{
            width: 100%;
        }
        .hd-tbl td:last-child{
            text-align: right;
        }
        .card-tools a.nav-link {
          padding: 3px 10px ;
        }
        .card-tools a.nav-link:hover {
          color:#000 !important  ;
        }
        .card-tools a.nav-link.active {
          background-color: #fff;
        }
        .card-tools .form-control{
           padding: 0;
           height: auto;
        }
    </style>
  @endsection

@section('content')


        <!-- Main content -->
    
      <div class="container-fluid">

                <!-- <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Title</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                Start creating your amazing application!
              </div>
              <div class="card-footer">
                Footer
              </div>
            </div>
        
          </div>
        </div> -->


        

         <div class="row" style="margin-top: 20px;">


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">

                 <p class="mb-0">Sales</p>
                <h3>{{$sale_detail['today']}} <span class="h5" >Today</span></h3>

               

              <table class="hd-tbl" >

              <tr><td></td> <td>Weight(Kg)</td> <td  >Value(Rs)</td></tr>
               <tr><td>Today:</td> <td>{{$sale_detail['today_weight']}}</td> <td>{{$sale_detail['today']}}</td> </tr>
              <tr><td>Yesterday:</td> <td>{{$sale_detail['yesterday_weight']}}</td> <td>{{$sale_detail['yesterday']}}</td> </tr>
              <tr><td>This Month:</td> <td>{{$sale_detail['month_weight']}}</td> <td>{{$sale_detail['month']}}</td> </tr>
              <tr><td>This Year:</td> <td>{{$sale_detail['year_weight']}}</td> <td>{{$sale_detail['year']}}</td> </tr>

             
             
             </table>


              </div>
              <div class="icon">
                <i class="fa fa-shopping-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">

                 <p class="mb-0">Cash Sales</p>
                <h3>{{$cash_sale_detail['today']}} <span class="h5" >Today</span></h3>

               

              <table class="hd-tbl" >

              <tr><td></td> <td>Weight(Kg)</td> <td  >Value(Rs)</td></tr>
               <tr><td>Today:</td> <td>{{$cash_sale_detail['today_weight']}}</td> <td>{{$cash_sale_detail['today']}}</td> </tr>
              <tr><td>Yesterday:</td> <td>{{$cash_sale_detail['yesterday_weight']}}</td> <td>{{$cash_sale_detail['yesterday']}}</td> </tr>
              <tr><td>This Month:</td> <td>{{$cash_sale_detail['month_weight']}}</td> <td>{{$cash_sale_detail['month']}}</td> </tr>
              <tr><td>This Year:</td> <td>{{$cash_sale_detail['year_weight']}}</td> <td>{{$cash_sale_detail['year']}}</td> </tr>

             
             
             </table>


              </div>
              <div class="icon">
                <i class="fa fa-shopping-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">

                 <p class="mb-0">Pending Orders</p>
                <h3>{{$order_detail['pending']}} <span class="h5" >Today</span></h3>

               

              <table class="hd-tbl" >

              <tr><td></td> <td  >Qty(No)</td> <td>Weight(Kg)</td> </tr>
               <tr><td>Pending Orders:</td> <td>{{$order_detail['pending']}}</td> <td>{{$order_detail['pending_weight']}}</td> </tr>
              <tr><td>Booked Today:</td> <td>{{$order_detail['today']}}</td> <td>{{$order_detail['today_weight']}}</td> </tr>
              <tr><td>This Month:</td> <td>{{$order_detail['month']}}</td> <td>{{$order_detail['month_weight']}}</td> </tr>
              <tr><td>This Year:</td> <td>{{$order_detail['year']}}</td> <td>{{$order_detail['year_weight']}}</td> </tr>

             
             
             </table>


              </div>
              <div class="icon">
                <i class="fa fa-shopping-bag"></i>
              </div>
              <a href="{{url('orders/pending')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">

                <?php
                    $liquid=$balances['bank']+$balances['cash']+$balances['cheques_in_hand'];
                ?>

                 <p class="mb-0">Liquid Assets</p>
                <h3>{{ number_format($liquid,2) }}</h3>

               

              <table class="hd-tbl" >

              <tr><td></td>  <td>Rs</td> </tr>
               <tr><td>Bank:</td> <td>{{number_format($balances['bank'],2)}}</td> </tr>
              <tr><td>Cash in Hand:</td>  <td>{{number_format($balances['cash'],2)}}</td> </tr>
              <tr><td>Cheques in Hand:</td> <td>{{number_format($balances['cheques_in_hand'],2)}}</td> </tr>
              <tr style="opacity:0"><td>Total</td> <td></td> </tr>

             
             
             </table>

            


              </div>
              <div class="icon">
                <i class="fa fa-shopping-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

         



        </div>

         
        
        <!-- Charts Row -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>
                            Sales Trend
                        </h5>

                        <div class="card-tools">

                            <select id="sale_chart" class="form-control" >
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                 <option value="yearly">Yearly</option>
                            </select>
                 
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height:300px">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-pie me-2"></i>
                            Order Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height:300px" >
                            <canvas id="orderChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>




            <!--Top Item-->
<div class="col-lg-6 mb-4">
  <div class="card card-primary">
    <div class="card-header border-0 d-flex justify-content-between align-items-center">
      <h3 class="card-title">Top Products</h3>
      <div class="card-tools ml-auto">
        <!-- Bootstrap Tabs -->
        <ul class="nav nav-pills" id="topItemsTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="year-tab" data-toggle="tab" data-target="#topItemsYear" type="button" role="tab">
              Year
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="month-tab" data-toggle="tab" data-target="#topItemsMonth" type="button" role="tab">
              Month
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 400px;">
      
      <div class="tab-content">

        <!-- Year Table -->
        <div class="tab-pane fade show active" id="topItemsYear" role="tabpanel">
          <table class="table table-striped table-valign-middle">
            <thead>
              <tr>
                
                <th>Item name</th>
                <th class="text-right" >Weight(Kg)</th>
                <th class="text-right">Value(Rs)</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topItemsYear as $item)
                <tr>
                  <td>{{ $item['item']['item_code'].' '.$item['item']['item_name']  }}</td>
                
                  <td class="text-right">{{ $item['total_weight'] }}</td>
                  <td class="text-right">{{ $item['total_amount'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Month Table -->
        <div class="tab-pane fade" id="topItemsMonth" role="tabpanel">
          <table class="table table-striped table-valign-middle">
            <thead>
              <tr>
                <th>Code</th>
                <th>Item name</th>
                <th class="text-right">Value</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topItemsMonth as $item)
                <tr>
                  <td>{{ $item['item']['item_code'] }}</td>
                  <td>{{ $item['item']['item_name'] }}</td>
                  <td class="text-right">{{ $item['total_amount'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>


            <!--Low Item Stock-->
             <div class="col-lg-6 mb-4">
            <div class="card card-info">
              <div class="card-header border-0">
                <h3 class="card-title">Low Stock Items</h3>
                <div class="card-tools">
                  <!---<a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>---->
                </div>
              </div>
              <div class="card-body table-responsive p-0" style="height: 400px;" >
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Item name</th>
                  
                    <th>Qty</th>
                    
                  </tr>
                  </thead>
                  <tbody>

                    @foreach($items as $item)
                  <tr>
                   
                    <td>
                      
                      {{$item['item_code']}}
                    </td>
                    <td>{{$item['item_name']}}</td>
                    
                    <td>
                      {{$item['closing_qty']}}
                    </td>
                  </tr>
                 @endforeach
                  
                 
                  </tbody>
                </table>
              </div>
            </div>
            </div>
            <!--Low Item Stock-->


            <!--Top Customers yearly-->
             <div class="col-lg-4 mb-4">
            <div class="card card-info">
              <div class="card-header border-0">
                <h3 class="card-title">Top Customers</h3>
                <div class="card-tools">

                         <select id="top_customers" class="form-control" >
                                <option value="yearly_sales">Sales (Yearly)</option>
                                <option value="monthly_sales">Sales (Monthly)</option>
                                 <option value="balance">Balance</option>
                            </select>

                  
                </div>
              </div>
              <div class="card-body table-responsive p-0" style="height: 370px;">

                <table class="table table-striped table-valign-middle" id="salesCustomers" >
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    
                  </tr>
                  </thead>
                  <tbody>

                    @foreach($topCustomersYear as $item)
                  <tr>
                    <td>
                      {{$item['name']}}
                    </td>
                    <td>{{$item['total_sales']}}</td>
                    
                  </tr>
                 @endforeach
                  
                 
                  </tbody>
                </table>

                <table class="table table-striped table-valign-middle" id="salesMCustomers" style="display:none;" >
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    
                  </tr>
                  </thead>
                  <tbody>

                    @foreach($topCustomersMonth as $item)
                  <tr>
                    <td>
                      {{$item['name']}}
                    </td>
                    <td>{{$item['total_sales']}}</td>
                    
                  </tr>
                 @endforeach
                  
                 
                  </tbody>
                </table>


                <table class="table table-striped table-valign-middle" id="balCustomers" style="display:none;" >
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    
                  </tr>
                  </thead>
                  <tbody>

                    @foreach($topBalanceCustomers as $item)
                  <tr>
                    <td>
                      {{$item['name']}}
                    </td>
                    <td>{{$item['balance']}}</td>
                    
                  </tr>
                 @endforeach
                  
                 
                  </tbody>
                </table>


              </div>
            </div>
            </div>
            <!--Top Customers yearly-->


             <!--Top Customers montly-->
             {{--<div class="col-lg-4 mb-4">
            <div class="card card-info">
              <div class="card-header border-0">
                <h3 class="card-title">Top Customers (Monthly)</h3>
                <div class="card-tools">
                  
                </div>
              </div>
              <div class="card-body table-responsive p-0"  >
                
                {{$totalReceivables}}
<br>
                {{$totalPayables}}

              </div>
            </div>
            </div>--}}
            <!--Top Customers montly-->



        </div>

        <!-- Charts Row --> 
          
          
         

        

         


         

        <!--END ROW-->

      </div>
    
    <!-- /.content -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
 <script src="{{asset('public/plugins/chart.js/Chart.min.js11')}}"></script>

     <script>
      
        
        const orderData = {
           // today_orders: 147,
            pending_orders: {{$order_detail['pending']}},
            //monthly_orders: 2847,
            total_orders: {{$order_detail['total_orders']}}
        };
        
       
        
        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0
            }).format(amount);
        }
        
        // Format number
        function formatNumber(number) {
            return new Intl.NumberFormat().format(number);
        }
        
       
        
       
        
       

        let salesChart;

function loadSalesChart(type = 'weekly') {
    $.ajax({
        url: "{{ route('sales.chart-data') }}",
        data: { type: type },
        success: function(response) {
            const ctx = document.getElementById('salesChart').getContext('2d');

            if (salesChart) {
                salesChart.destroy(); // destroy old chart before re-render
            }

            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.labels,
                    datasets: [{
                        label: 'Sales',
                        data: response.totals,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return (value / 1000) + 'K';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
}


        // Initialize charts
        function initCharts1() {
            
            
            // Order Status Chart
            const orderCtx = document.getElementById('orderChart').getContext('2d');
            new Chart(orderCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Pending'],
                    datasets: [{
                        data: [orderData.total_orders - orderData.pending_orders, orderData.pending_orders],
                        backgroundColor: ['#00b894', '#fdcb6e', '#74b9ff'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            
            // Load default chart (weekly)
    loadSalesChart('weekly');

    // When user changes dropdown
    $('#sale_chart').on('change', function() {
        loadSalesChart($(this).val());
    });

     $('#top_customers').on('change', function() {
       let tp =$(this).val();

          $('#salesCustomers').hide();
          $('#salesMCustomers').hide();
          $('#balCustomers').hide();

       if(tp=='yearly_sales'){
         $('#salesCustomers').show();
       }
       else if(tp=='monthly_sales'){
         $('#salesMCustomers').show();
       }
       else if(tp=='balance'){
          $('#balCustomers').show();
       }

    });

    

           // initCharts();

            initCharts1();
            
            
        });
    </script>

@endsection    
  