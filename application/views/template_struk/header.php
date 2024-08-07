<!DOCTYPE html>
<html lang="en">
<head>
    <title>Struktural | <?= $title; ?></title>
    <!-- Other head elements -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>application/views/template_struk/css/header.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="https://surakartakota.bps.go.id/" role="button">
                <img src="<?= base_url('assets/admin/img/BPS.png') ?>" alt="bps" class="brand-image img-circle navbar-logo">
                <span class="brand-text font-weight-dark" style="color: white; padding-left: 13px;">BPS Surakarta</span>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle" role="button" title="Dark Mode" style="color: white">
                <i class="fa fa-moon"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link" id="userDropdown" role="button" title="User" style="color: white">
                <i class="fa fa-user"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li class="dropdown-item">
                    <?php if (!empty($user)): ?>
                        <a href="#" class="d-block"><?= $user['nama']; ?></a>
                    <?php else: ?>
                        <a href="#" class="d-block">User not found</a>
                    <?php endif; ?>
                </li>
                <li class="dropdown-item">
                    <a href="<?= base_url('login/logout'); ?>">Log Out</a>
                </li>
            </ul>
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
      const icon = darkModeToggle.querySelector('i');

      function updateDarkMode() {
          if (document.body.classList.contains('dark-mode')) {
              navbar.classList.remove('navbar-light');
              navbar.classList.add('navbar-dark');
              icon.classList.remove('fa-moon');
              icon.classList.add('fa-sun');
              icon.classList.add('rotate');
              setTimeout(() => icon.classList.remove('rotate'), 800);
              darkModeToggle.setAttribute('title', 'Light Mode');
              navbar.removeAttribute('style');
          } else {
              navbar.classList.remove('navbar-dark');
              navbar.classList.add('navbar-light');
              icon.classList.remove('fa-sun');
              icon.classList.add('fa-moon');
              icon.classList.add('rotate');
              setTimeout(() => icon.classList.remove('rotate'), 800);
              darkModeToggle.setAttribute('title', 'Dark Mode');
              navbar.setAttribute('style', 'background: linear-gradient(to top,#00497d,#0279C8); transition: background 0.5s;');
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

      // Dropdown toggle
      const userDropdown = document.getElementById('userDropdown');
      const dropdownMenu = userDropdown.nextElementSibling;

      userDropdown.addEventListener('click', function(event) {
          event.preventDefault();
          dropdownMenu.classList.toggle('show');
      });

      document.addEventListener('click', function(event) {
          if (!userDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
              dropdownMenu.classList.remove('show');
          }
      });

      // Function to close sidebar if open
      function closeSidebar() {
          if (document.body.classList.contains('sidebar-open')) {
              document.body.classList.remove('sidebar-open');
              document.body.classList.add('sidebar-collapse');
          }
      }

      // Event listener to detect clicks outside the sidebar
      document.addEventListener('click', function(event) {
          // Check if the click happened outside the sidebar and toggle button
          if (!event.target.closest('.main-sidebar') && !event.target.closest('[data-widget="pushmenu"]')) {
              closeSidebar();
          }
      });

      // Event listener to toggle sidebar when clicking the toggle button
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
