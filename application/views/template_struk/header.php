<!DOCTYPE html>
<html lang="en">
<head>
    <title>Struktural | <?= $title; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>application/views/template_struk/css/header.css">
</head>
<body class="hold-transition sidebar-collapse layout-fixed">
<nav class="main-header navbar navbar-expand navbar-light" style="display: flex; align-items: center;">
    <ul class="navbar-nav" style="display: flex; align-items: center;">
        <li class="nav-item" style="display: flex; align-items: center;">
            <a class="nav-link d-flex align-items-center" href="https://surakartakota.bps.go.id/" style="display: flex; align-items: center;">
                <img src="<?= base_url('assets/admin/img/BPS.png') ?>" alt="bps" class="brand-image img-circle navbar-logo" style="height: 35px; width: auto;">
                <span style="color: white; padding-left: 10px; font-size: 1.2rem; line-height: 35px;"><b>BPS Surakarta</b></span>
            </a>
        </li>
        <li class="nav-item" style="display: flex; align-items: center;"> 
            <a class="nav-link" href="<?= base_url('struktural/index') ?>" role="button">
                <span class="brand-text smaller-text" style="font-family: 'Arial'; font-size: 0.80rem; color: white;">Home</span>
            </a>
        </li>
        <li class="nav-item" style="display: flex; align-items: center;">
            <a class="nav-link" href="<?= base_url('struktural/surat') ?>" role="button">
                <span class="brand-text smaller-text" style="font-family: 'Arial'; font-size: 0.80rem; color: white;">Surat</span>
            </a>
        </li>
        <li class="nav-item" style="display: flex; align-items: center;">
            <a class="nav-link" href="#" role="button">
                <span class="brand-text smaller-text" style="font-family: 'Arial'; font-size: 0.80rem; color: white;">Rekap</span>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto" style="display: flex; align-items: center;">
        <li class="nav-item" style="display: flex; align-items: center;">
            <a class="nav-link" href="#" id="darkModeToggle" role="button" title="Dark Mode" style="color: white">
                <i class="fa fa-moon"></i>
            </a>
        </li>
        <li class="nav-item dropdown" style="display: flex; align-items: center;">
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Dark Mode Toggle Script -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const navbar = document.querySelector('.main-header.navbar');
    const icon = darkModeToggle.querySelector('i');
    const userDropdown = document.getElementById('userDropdown');
    const dropdownMenu = userDropdown.nextElementSibling;

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

    userDropdown.addEventListener('click', function(event) {
        event.preventDefault();
        const isHidden = dropdownMenu.classList.contains('hide');
        if (isHidden) {
            dropdownMenu.classList.remove('hide');
            dropdownMenu.classList.add('show');
            dropdownMenu.classList.add('dropdown-menu-right'); // Adjust to slide from the right
        } else {
            dropdownMenu.classList.remove('show');
            dropdownMenu.classList.add('hide');
            dropdownMenu.classList.remove('dropdown-menu-right'); // Reset position
        }
    });

    document.addEventListener('click', function(event) {
        if (!userDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
            dropdownMenu.classList.add('hide');
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
