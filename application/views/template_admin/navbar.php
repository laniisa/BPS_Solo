<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disposisi | <?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
    <!-- Custom Navbar CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>application\views\template_admin\css\navbar.css">

    <style>
        /* Prevent body from horizontal scrolling */
        html, body {
            width: 100%-250px;
            overflow-x: hidden;
        }

        /* Navbar background */
        .main-header.navbar {
            background: linear-gradient(to top, #00497d, #0279C8) !important;
            transition: background 0.5s;
        }

        /* Ensure no overflow in navbar */
       

.navbar-nav {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
}

@media (max-width: 768px) {
  .navbar-nav {
    flex-wrap: wrap; /* Navbar item akan wrap di layar kecil */
  }
}


        /* Fix navbar items in mobile view */
        .navbar-nav.ml-auto {
            margin-left: auto;
        }

        /* Fix navbar button colors */
       

        /* Fix button size and ensure they fit */
        .nav-link i {
            font-size: 20px; /* Ensure the icons are large enough to be visible */
        }

        /* Increase padding on navbar items for better spacing */
        .navbar-nav .nav-item {
            padding-right: 10px;
            padding-left: 10px;
        }

        /* Fix the layout issue with collapsed items */
        .main-header .navbar-expand .navbar-nav {
            flex-direction: row;
            justify-content: flex-end;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Dark Mode Toggle -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="darkModeToggle" role="button" title="Dark Mode">
                <i class="fa fa-moon" aria-hidden="true"></i>
            </a>
        </li>
        
        <!-- Logout -->
        <li class="nav-item">
            <a href="<?= base_url('login/logout'); ?>" class="nav-link" role="button" title="Logout">
                <i class="fa fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

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
