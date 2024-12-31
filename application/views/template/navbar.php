<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Disposisi Surat | <?= $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
  
  <style>
    /* Default Light Mode Styles */
    .navbar-light {
      background-color: #007bff;
    }

    /* Dark Mode Styles */
    .dark-mode .navbar-dark {
      background-color: #343a40; /* Dark background for navbar */
    }

    .main-header.navbar {
            background: linear-gradient(to top, #00497d, #0279C8) !important;
            transition: background 0.5s;
        }

    .dark-mode .nav-link {
      color: white !important;
    }

    .dark-mode .nav-link:hover {
      color: #ffc107;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Dark Mode Toggle -->
      <li class="nav-item">
        <a class="nav-link" href="#" id="darkModeToggle" role="button" title="Toggle Dark Mode">
          <i class="fas fa-moon"></i> <!-- Icon for dark mode -->
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
            <a href="<?= base_url('login/logout'); ?>" class="nav-link" role="button" title="Logout">
                <i class="fa fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->
</div>

<!-- JavaScript for Dark Mode Toggle -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
        const darkModeToggle = document.getElementById('darkModeToggle');
        const navbar = document.querySelector('.main-header.navbar');
        const sidebar = document.querySelector('.main-sidebar');
        const icon = darkModeToggle.querySelector('i');

        function updateDarkMode() {
            if (document.body.classList.contains('dark-mode')) {
                navbar.classList.remove('navbar-light');
                navbar.classList.add('navbar-dark');
                sidebar.classList.remove('sidebar-light-primary');
                sidebar.classList.add('sidebar-dark-primary');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                icon.classList.add('rotate');
                setTimeout(() => icon.classList.remove('rotate'), 800);
                darkModeToggle.setAttribute('title', 'Light Mode'); 
                navbar.removeAttribute('style');
                sidebar.querySelector('.brand-link').removeAttribute('style');
            } else {
                navbar.classList.remove('navbar-dark');
                navbar.classList.add('navbar-light');
                sidebar.classList.remove('sidebar-dark-primary');
                sidebar.classList.add('sidebar-light-primary');
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                icon.classList.add('rotate');
                setTimeout(() => icon.classList.remove('rotate'), 800);
                darkModeToggle.setAttribute('title', 'Dark Mode');
                navbar.setAttribute('style', 'background: linear-gradient(to top,#00497d,#0279C8); transition: background 0.5s;');
                sidebar.querySelector('.brand-link').setAttribute('style', 'background: linear-gradient(to top,#00497d,#0279C8); transition: background 0.5s;');
            }
        }

        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
            updateDarkMode();
        }

        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            updateDarkMode();

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    });
</script>
</body>
</html>
