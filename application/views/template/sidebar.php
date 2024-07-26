  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4" style="posiition: fixed; heu=ight:100%; overflow-y: auto">
    <!-- Brand Logo -->
    <a href="https://surakartakota.bps.go.id/" class="brand-link" style='background: linear-gradient(#0078C7,#008EC3)'>
      <img src="assets/admin/img/BPS.png" alt="bps"  class="brand-image img-circle elevation-3" style="opacity: .9; background-color: white" >
      <span class="brand-text font-weight-dark" style="color: white; padding-left: 15px;">BPS Surakarta</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" class="bi bi-person-circle" viewBox="0 0 16 16" >
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
          <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        </svg>
        </div>
        <div class="info">
        <?php if (!empty($user)): ?>
            <a href="#" class="d-block"><?= $user['nama']; ?></a>
        <?php else: ?>
            <a href="#" class="d-block">User not found</a>
        <?php endif; ?>
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
          <li class="nav-item">
            <a href="../view/dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Operator</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Struktural</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fungsional</p>
                </a>
              </li>
            </ul>
          </li>
        <li class="nav-item">
                <a href="../view/table.php" class="nav-link">
                <i class="nav-icon fas fa-envelope-open-text"></i>
                  <p>Surat</p>
                </a>
        </li>
        <li class="nav-item">
                <a href="../view/table.php" class="nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                  <p>Berkas</p>
                </a>
        </li>  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>