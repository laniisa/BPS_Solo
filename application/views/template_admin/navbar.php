<!DOCTYPE html>
<html lang="en">
<head>
    <title>Disposisi | <?= $title; ?></title>
    <!-- Other head elements -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>application\views\template_admin\css\navbar.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light fixed-top" style='background: linear-gradient(to top,#00497d,#0279C8); transition: background 0.5s;'>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: white"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle" role="button" title="Dark Mode" style="color: white">
                <i class="fa fa-moon" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('login/logout'); ?>" class="nav-link" role="button" title="Logout" style="color: white">
                <i class="fa fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Dark Mode Toggle Script -->
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
  document.addEventListener('DOMContentLoaded', function() {
    function closeSidebar() {
        if (document.body.classList.contains('sidebar-open')) {
            document.body.classList.remove('sidebar-open');
            document.body.classList.add('sidebar-collapse');
        }
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.main-sidebar') && !event.target.closest('[data-widget="pushmenu"]')) {
            closeSidebar();
        }
    });

    document.querySelector('[data-widget="pushmenu"]').addEventListener('click', function(event) {
        if (document.body.classList.contains('sidebar-open')) {
            closeSidebar();
        } else {
            document.body.classList.add('sidebar-open');
        }
    });
});
</script>
</body>
</html>