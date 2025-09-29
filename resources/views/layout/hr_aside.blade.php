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
              
               </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Employees
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('employee-Enrollment')}}" class="nav-link">
                  <i class="far fa-image nav-icon"></i>
                  <p>Enroll New Employee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/employee/profile/')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Employee profile</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="../charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Employees</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Employees</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/employees')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Employees</p>
                </a>
              </li>
 -->              <li class="nav-item">
                <a href="{{url('/overtime/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Overtime</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('loan/request')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Loan Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/department')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Department</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/designation')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Designation</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Attendance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
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
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Salaries
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

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
          </li>

          
          
          
                   
         
         


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>