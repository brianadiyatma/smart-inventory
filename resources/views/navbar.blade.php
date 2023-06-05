<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">




    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ Auth::user()->name }}<i class="fas fa-user ml-3"></i></a>
      <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
        <li><a href="/profile/{{ Auth::user()->id }}" class="dropdown-item">Setting Profile</a></li>
        <li class="dropdown-divider"></li>
        @can('Admin')
        <li><a href="/usermanagement" class="dropdown-item">User Management</a></li>
        <li class="dropdown-divider"></li>
        @endcan
        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </li>
      </ul>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->

  <a href="/" class="brand-link logo-switch disabled">
    <img src="{{asset('img/Group1.png')}}" width="154" height="60" class="brand-image-xl logo-xl img ml-2">
    <img src="{{asset('assets/dist/img/logoinka.svg')}}" class="brand-image-xs logo-xs img" style="padding-top: 10px; width: 50px">

  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="/" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/materialstock" class="nav-link">
            <i class="nav-icon fas fa-th-large"></i>
            <p>
              Stock Material
            </p>
          </a>
        </li>
        @cannot("Manager")
            <li class="nav-item">
          <a href="/materialmove" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Move Material
            </p>
          </a>
        </li>
        @endcannot
        <li class="nav-item">
          <a href="/" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Transactions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can("Admin")
                <li class="nav-item">
              <a href="/new-transaksi" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Transaction</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="/transaksi" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Transaction List</p>
              </a>
            </li>
          </ul>
        </li>
        @cannot('Admin')
        <li class="nav-item">
          <a href="/pivot" class="nav-link">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>
              Bin Management
            </p>
          </a>
        </li>
        @endcannot
        @can('Admin')
        <li class="nav-item">
          <a href="/" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Material
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/material" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Materials</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/materialgroup" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Material Group</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/materialtype" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Material Type</p>
              </a>
            </li>
            <li class="dropdown-divider"></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>
              Layout & Storage
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/pivot" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bin Management</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/plant" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Plant</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/storloc" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Storage Location</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/type" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Storage Type</p>
              </a>
            </li>
            <li class="dropdown-divider"></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Master Table
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/uom" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>UoM</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/wbs" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>WBS</p>
              </a>
            </li>
            <li class="dropdown-divider"></li>
          </ul>
        </li>
        @endcan
        <li class="nav-item">
          @cannot('Operator')
            <a href="/" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>
              Report
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          @endcannot
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/generate" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Generate Report</p>
              </a>
            </li>
            <li class="dropdown-divider"></li>
            {{-- <li class="nav-item">
              <a href="/report1" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>STTP & BPM Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/report2" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inbound & Outbound Report</p>
              </a>
            </li> --}}
            <li class="dropdown-divider"></li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
