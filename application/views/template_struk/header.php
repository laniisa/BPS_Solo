<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Disposisi Surat</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/assets/vendor/animate.css/animate.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/assets/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/assets/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="<?= base_url('assets/assets/css/style.css') ?>">
</head>

<body>

  <!-- Header section -->
  <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <div class="logo me-auto">
        <h1><a href="<?= site_url('struktural') ?>">Disposisi</a></h1>
      </div>

      <!-- Navbar -->
      <nav id="navbar" class="navbar order-last order-lg-0 navbar-expand-lg">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link scrollto" href="<?= site_url('pelanggan') ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link scrollto" href="<?= site_url('pelanggan#why-us') ?>">About</a></li>
          <li class="nav-item"><a class="nav-link scrollto" href="<?= site_url('pelanggan#events') ?>">Event</a></li>
          <li class="nav-item"><a class="nav-link scrollto" href="<?= site_url('pelanggan#gallery') ?>">Gallery</a></li>
          <li class="nav-item"><a class="nav-link scrollto" href="<?= site_url('pelanggan#testimonials') ?>">Ulasan</a></li>
          <li class="nav-item"><a class="nav-link scrollto" href="<?= site_url('pelanggan/makanan') ?>">Menu</a></li>
          <li class="nav-item"><a class="nav-link scrollto" href="<?= site_url('pelanggan/kontak') ?>">Kontak</a></li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $user['username']; ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="<?= site_url('pelanggan/profil') ?>">Profil</a></li>
              <li><a class="dropdown-item" href="<?= site_url('pelanggan/pesan') ?>">Reservasi</a></li>
              <li><a class="dropdown-item" href="<?= site_url('pelanggan/ulasan') ?>">Buat Ulasan</a></li>
              <li><a class="dropdown-item" href="<?= base_url('login/logout'); ?>">Log Out</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>

  <!-- Your content goes here -->

  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/vendor/glightbox/js/glightbox.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/vendor/swiper/swiper-bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/vendor/php-email-form/validate.js') ?>"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url('assets/assets/js/main.js') ?>"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const currentPath = window.location.pathname;
      const links = document.querySelectorAll('.nav-link.scrollto');
      const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
      const navbar = document.querySelector('#navbar');
      
      // Toggle mobile nav
      mobileNavToggle.addEventListener('click', function() {
        navbar.classList.toggle('navbar-mobile');
        this.classList.toggle('bi-list');
        this.classList.toggle('bi-x');
      });

      // Smooth scroll
      links.forEach(link => {
        link.addEventListener('click', function(event) {
          const href = link.getAttribute('href');
          const isHomeLink = href.startsWith('<?= site_url('pelanggan') ?>#');
          const targetId = href.split('#')[1];
          const targetElement = document.getElementById(targetId);

          if (isHomeLink && currentPath !== '<?= site_url('pelanggan') ?>') {
            event.preventDefault();
            window.location.href = href;
          } else if (targetElement) {
            event.preventDefault();
            window.scrollTo({
              top: targetElement.offsetTop - document.querySelector('#header').offsetHeight,
              behavior: 'smooth'
            });

            // Close mobile nav on click
            if (navbar.classList.contains('navbar-mobile')) {
              navbar.classList.remove('navbar-mobile');
              mobileNavToggle.classList.toggle('bi-list');
              mobileNavToggle.classList.toggle('bi-x');
            }
          }
        });
      });

      // Active link
      const setActiveLink = () => {
        links.forEach(link => {
          if (link.href === window.location.href) {
            link.classList.add('active');
          } else {
            link.classList.remove('active');
          }
        });
      };
      setActiveLink();
      window.addEventListener('scroll', setActiveLink);
    });
  </script>
</body>
</html>
