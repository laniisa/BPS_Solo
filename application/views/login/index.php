<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>" />
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/dist/css/adminlte.min.css'); ?>" />
  <style>
    .position-fixed {
        position: fixed !important;
    }
    .top-0 {
        top: 0 !important;
    }
    .start-50 {
        left: 50% !important;
    }
    .translate-middle-x {
        transform: translateX(-50%) !important;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="https://surakartakota.bps.go.id/"><b>BPS</b>&nbsp;Surakarta</a>
  </div>
  <!-- /.login-logo -->
  <div class="card border-0 shadow">
    <div class="card-body login-card-body">
      <div class="d-flex justify-content-center mb-4">
        <img src="<?= base_url('assets/img/BPS.png'); ?>" alt="bps" class="brand-image img-circle" style="opacity: .9; background-color: white; height: 100px">
      </div>

      <!-- Alert Section -->
      <?php if ($this->session->flashdata('pesan')): ?>
          <div class="alert alert-dismissible fade show text-center position-fixed top-0 start-50 translate-middle-x" 
               style="z-index: 1050; width: 100%; max-width: 400px; margin-top: 10px;">
              <?= $this->session->flashdata('pesan'); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      <?php endif; ?>

      <form action="<?= base_url('login'); ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?= set_value('email');?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="text-center nt-3">
          <button type="submit" class="btn btn-block" style="background-color: #0279C8; color: #ffffff;">Login</button>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/admin/dist/js/adminlte.min.js'); ?>"></script>

<!-- JavaScript for Auto-Dismiss Alert -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alertBox = document.querySelector('.alert-dismissible');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 5000); // Alert disappears after 5 seconds
        }
    });
</script>
</body>
</html>
