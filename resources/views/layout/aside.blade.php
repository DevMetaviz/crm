
<!-- Main Sidebar Container -->
  <aside class="main-sidebar1 main-custom-sidebar sidebar-dark-primary1" >

    <style type="text/css">
  .sub-menu{ margin-left: 20px; }
</style>

    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('public/images/logo.png')}}" alt="Metaviz Logo" class="brand-image img-circle1 elevation-3-1" style="/*opacity: .8;*/margin: auto;display: block;float: unset;    max-width: 60px;max-height: unset;">
      <!----<span class="brand-text font-weight-light">{{$company_config['short_name']}}</span>-->
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3-1 d-flex">
        <div class="image">
          <img src="{{asset('public/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          

          <?php
                  $menus=Auth::user()->menu();
          ?>

          @foreach($menus as $menu)
          <?php
                  $sub_menus=$menu->sub_menu;

                  $sub_menu_count=count($sub_menus);
          ?>
          <li class="nav-item">
            <a href="{{url($menu['link'])}}" class="nav-link">
              <i class="nav-icon {{$menu['icon']}}"></i>
              <p>
                {{$menu['text']}} 
                 
                 @if($sub_menu_count>0)
                <i class="right fas fa-angle-left"></i>
                 @endif
              </p>
            </a>

             @if($sub_menu_count>0)
                <ul class="nav nav-treeview1 nav-treeview-custom">
                  @foreach($sub_menus as $sub_menu)
                  <?php
                  $sub_sub_menus=$sub_menu->sub_menu;

                  $sub_sub_menu_count=count($sub_sub_menus);
                 ?>
              <li class="nav-item">
                <a href="{{url($sub_menu['link'])}}" class="nav-link">
                  <!---<i class="far fa-circle nav-icon"></i>-->
                  <p>{{$sub_menu['text']}} </p>
                </a>
                 @if($sub_sub_menu_count>0)
                <ul class="nav nav-treeview-custom-s">
                  @foreach($sub_sub_menus as $sub_sub_menu)
              <li class="nav-item">
                <a href="{{url($sub_sub_menu['link'])}}" class="nav-link">
                  <!--<i class="far fa-circle nav-icon"></i>-->
                  <p>{{$sub_sub_menu['text']}}</p>
                </a>
              </li>
               @endforeach
            </ul>
              @endif

              </li>
                @endforeach
            </ul>
            @endif


          </li>
          @endforeach

          <!--<li class="nav-item">
            <a href="{{url('/dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>-->

          


         

          <!--<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Cash & Bank
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">
              <li class="nav-item">
                <a href="{{url('/voucher/expense/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expense</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/voucher/payment/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/voucher/receipt/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Receipt</p>
                </a>
              </li>
            </ul>
          </li>--->

           <?php $t=Auth::user()->have_right(6); ?>
              @if(Auth::user()->have_right(6) || true )
              <!--<li class="nav-item">
                <a href="{{url('/purchase/demand')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Demand</p>
                </a>
              </li>-->
              @endif

              <!--
              purchase/ledger ==== Ledger
              /sale-demand  Demand
              /quotation/create Quotation
              stock/transfer Stock Transfer
              salesman/sale Salesman Sales
              sale/ledger Sale Ledger
              sale/ledger/summary Sale Ledger Summary
              customer/store Customer Store
              -->

               
         
          
         


          <!---<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">
                
              <li class="nav-item">
                <a href="{{url('customer/store')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Store</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('customer/store/detail')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store Detail</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('customer/store/summary')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stroe Summary</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('customers/receivable')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Receivable</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('customer/receivable')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Receivable1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/configure/rate')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Rate</p>
                </a>
              </li>
            </ul>
          </li>---->



          <!----<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Production
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">

              <li class="nav-item">
                <a href="{{url('production-demand')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Demand</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('production-plan')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Plan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('transfer-note')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transfer Note</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('plan-ticket')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Plan Ticket</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('select/batch/stage')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stages</p>
                </a>
              </li>
                            
            </ul>
          </li>-->
          {{---
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Stock
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">
              
                            <li class="nav-item">
                <a href="{{url('stocks-under-qc')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Under QC</p>
                </a>
              </li>

                           
              <li class="nav-item">
                <a href="{{url('stock-list')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Stock List</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{url('return-note-list')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Return Notes</p>
                </a>
              </li> -->
               
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-check-circle"></i>
              <p>
                QC
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">
              <li class="nav-item">
                <a href="{{url('sampling/pending')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Pending Sampling</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('sampling/list/')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Sampling List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('lab-test-results')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Results</p>
                </a>
              </li>
               <!-- <li class="nav-item">
                <a href="{{url('QC/test/result')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>QC Result</p>
                </a>
              </li> -->
            </ul>
          </li>--}}
          <!--<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                 Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">
              
               <li class="nav-item">
                <a href="{{url('requisition/requests')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Requisition Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/store-issuance')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store Issuance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/issuance-return/history')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Issuance Return</p>
                </a>
              </li>

             
              
              <li class="nav-item">
                <a href="{{url('inventory/stock-wise')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item Stockwise</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('items-stock-batch-wise')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item Stock Batchwise</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('inventory/near-expiry')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Near Expiry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('inventory/expired')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expired</p>
                </a>
              </li>
            </ul>
          </li>-->
          
{{----
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Attendance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">
              <li class="nav-item">
                <a href="{{url('import-attendance')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Mark Attendance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('employee/attendance')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attendance Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('employees/monthly-attendance/report')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Attendance Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('employees/attendance')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daily Attendance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('employees/monthly-attendance')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Attendance</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{url('leave/adjustment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave Adjustment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('attendance/register')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attendance Register</p>
                </a>
              </li>
              
              
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Salaries
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">

              <li class="nav-item">
                <a href="{{url('make-salary')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Make Salary</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('generate-salary')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Genrate Salary</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('HR-Penality')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>HR Penality</p>
                </a>
              </li>
              
            </ul>
          </li>--}}

         {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom">

              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                 Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview-custom-s">
              <li class="nav-item">
                <a href="{{url('/inventory/Add')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Inventory Item</p>
                </a>
              </li>
                  <!--<li class="nav-item">
                <a href="{{url('configuration/inventory/department')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventory Department</p>
                </a>
              </li>-->
              <li class="nav-item">
                <a href="{{url('configuration/inventory/category')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('configuration/inventory/type')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventory Sub Category</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/account/rates')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daily Rates</p>
                </a>
              </li>
              
              <!--<li class="nav-item">
                <a href="{{url('configuration/origin')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Origin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('configuration/inventory/size')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item Size</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('configuration/inventory/color')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item Color</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('configuration/unit')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item Unit</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('gtin/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>GTIN No</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/finish-goods-production-standard')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production Std</p>
                </a>
              </li>-->
               
              
            </ul>
          </li>

          <li class="nav-item">
                <a href="{{url('/customer/create')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Customer</p>
                </a>
              </li>

              <!--<li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Export
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview-custom-s">
                  <li class="nav-item">
                    <a href="{{url('/configuration/currency/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Currency</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/ports')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ports</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/packing-types/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Packing Type</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/freight-types/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Freight Type</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/transport-methods/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Transportation</p>
                    </a>
                  </li>
                </ul>
              </li>-->


          <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Vendors
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview-custom-s">
                  <li class="nav-item">
                    <a href="{{url('/configuration/vendor/create')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Vendors</p>
                    </a>
                  </li>
                  <!--<li class="nav-item">
                    <a href="{{url('/configuration/vendor/type/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Vendor Type</p>
                    </a>
                  </li>--->
                </ul>
              </li>

             <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    QC
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview-custom-s">
                  <li class="nav-item">
                    <a href="{{url('configuration/inventory/parameters')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Product Parameter</p>
                    </a>
                  </li>
                
                </ul>
              </li>


             


               <li class="nav-item">
                <a href="{{url('configuration/expenses')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Expenses</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('voucher/types')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Voucher Type</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('configuration/transport-methods')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Transport Methods</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{url('configuration/departments')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Departments</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{url('config/commission/area-wise/')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Salesman Commission</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('configuration/production/process')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Production Process</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{url('configuration/production/process/parameters')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Process Parameter</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('configuration/product/procedure')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Product procedure</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('configuration/table')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Process Table</p>
                </a>
              </li>

              
              <li class="nav-item">
                <a href="{{url('configuration/allowances')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Allowance</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('HR-Penality')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>HR Penality</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/configuration/leave')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Leave Type</p>
                </a>
              </li>

               <li class="nav-item">
                <a href="{{url('/configuration/attendance-status')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Attendance Status</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/define/shift')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Shift</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/shifts')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Shifts</p>
                </a>
              </li>

              
              

              


              <li class="nav-item">
                <a href="{{url('sub-sub-account/types')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Account Type</p>
                </a>
              </li>

             

              

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Security Rights
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview-custom-s">
                  <li class="nav-item">
                    <a href="{{url('/configuration/add-new-user')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Users</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/roles/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Roles</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/security/rights')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Rights</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Others Configurations
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview-custom-s">
                  <li class="nav-item">
                    <a href="{{url('/configuration/countries')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Country</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/states/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Province/State</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/regions/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Region</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/districts/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>District</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/cities')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>City</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/configuration/territories/')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Territory</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="{{url('company/config')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Company Config</p>
                </a>
              </li>


              
            </ul>
          </li>
          --}}

          
          
                   
         
         


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>