    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('Admin');?>" class="brand-link">
        <img src="<?= base_url('assets/');?>images/icon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
        <span class="brand-text font-weight-light">CPANEL ADMIN</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-header">Main Navigation</li>
           <li class="nav-item">
            <a href="<?= base_url('Admin')?>" class="nav-link <?php if($page == 'Dashboard' || $page == 'Detail Pelanggaran'){echo 'active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/klaster')?>" class="nav-link <?php if($parent == 'Data Klaster'){echo 'active';} ?>">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Klaster
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/user')?>" class="nav-link <?php if($parent == 'Data User'){echo 'active';} ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#logOutModal">
              <i class="nav-icon fa-fw fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>