<style type="text/css">
  .sub-menu{ margin-left: 20px; }
</style>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('public/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{$company_config['short_name']}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item">
            <a href="{{url('/dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

      
         <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Sales
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/sale-demand')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Demand</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/quotation/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Quotation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/order/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sale Order</p>
                </a>
              </li>
    
              
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Production
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

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

             
              
              
            </ul>
          </li>
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Stock
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
                           
              <li class="nav-item">
                <a href="{{url('stock-list')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Stock List</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="{{url('items-stock')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Items Stock</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                QC
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
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
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                 Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
               <li class="nav-item">
                <a href="{{url('requisition/requests')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Requisition Requests</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="{{url('item/history')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('inventory/stock-wise')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item Stockwise</p>
                </a>
              </li>
             
            </ul>
          </li>
          

         
<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Configuration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                 Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                              
              <li class="nav-item">
                <a href="{{url('/finish-goods-production-standard')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production Std</p>
                </a>
              </li>
               
              
            </ul>
          </li>

         


         

              


             


                 
              

              
             
              


              
            </ul>
          </li>
         
          
          
          
                   
         
         


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>