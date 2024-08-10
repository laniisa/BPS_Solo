<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="https://surakartakota.bps.go.id/" class="brand-link" style='background: linear-gradient(to top,#00497d,#0279C8)'>
        <img src="<?= base_url('assets/admin/img/BPS.png') ?>" alt="bps" class="brand-image img-circle" style="opacity: .9;">
        <span class="brand-text font-weight-dark" style="color: white; padding-left: 10px;">BPS Surakarta</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" class="bi bi-person-circle" viewBox="0 0 16 16">
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
                    <a href="<?= base_url('admin') ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dasboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/operator') ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/surat') ?>" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>Surat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/berkas') ?>" class="nav-link">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>Rekap</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
