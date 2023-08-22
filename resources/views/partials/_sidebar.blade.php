  <!-- Sidebar -->
  <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #1d1d1d">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
          <div class="sidebar-brand-icon">
              <i class="fas fa-gas-pump"></i>
          </div>
          <div class="sidebar-brand-text mx-3">
              Mattel Gas

          </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{Request::path() == '/' ? 'active' : ''}}">
          <a class="nav-link" href="/">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Home</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Menu
      </div>
      <li class="nav-item {{Request::path() == 'transactions' ? 'active' : ''}}">
          <a class="nav-link" href="/transactions">
              <i class="fas fa-fw fa-chart-area"></i>
              <span>Transactions</span></a>
      </li>
      @role('cashier|manager')
      <li class="nav-item {{Request::path() == 'clients' ? 'active' : ''}}">
          <a class="nav-link" href="/clients">
              <i class="fas fa-fw fa-users"></i>
              <span>Clients</span></a>
      </li>
      @endrole
      @role('manager|admin')
      <li class="nav-item {{Request::path() == 'stocks' ? 'active' : ''}}">
          <a class="nav-link" href="stocks">
              <i class="fas fa-fw fa-table"></i>
              <span>Stocks Inventory</span></a>
      </li>
      <li class="nav-item {{Request::path() == 'products' ? 'active' : ''}}">
          <a class="nav-link" href="/products/1">
              <i class="fas fa-fw fa-gas-pump"></i>
              <span>Gas Prices</span></a>
      </li>
      @endrole


      <!-- Divider -->


      <!-- Nav Item - Utilities Collapse Menu -->
      @role('admin')
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#clientUtilities" aria-expanded="true" aria-controls="collapseUtilities">
              <i class="fas fa-fw fa-users"></i>
              <span>Clients</span>
          </a>
          <div id="clientUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Clients Menu:</h6>
                  <a class="collapse-item" href="/clients">Clients</a>
                  <a class="collapse-item" href="/creditors">Creditors</a>
              </div>
          </div>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
              <i class="fas fa-fw fa-wrench"></i>
              <span>Settings</span>
          </a>
          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Settings:</h6>
                  <a class="collapse-item" href="/settings">Settings</a>
                  <a class="collapse-item" href="/register">Register New User</a>
              </div>
          </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      @endrole

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
  </ul>
  <!-- End of Sidebar -->