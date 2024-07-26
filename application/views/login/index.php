
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
  <link rel="stylesheet" href="<?= base_url('assets/admin/dist/css/adminlte.min.css'); ?>"/>

  <link rel="stylesheet" href="<?= base_url('assets/login/css/bootstrap-login-form.min.css'); ?>" />

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="https://surakartakota.bps.go.id/"><b>BPS</b>&nbsp Surakarta</a>
  </div>
  <!-- /.login-logo -->
  <div class="card border-0 shadow">
    <div class="card-body login-card-body">
      <div class="d-flex justify-content-center mb-4">
        <svg xmlns="https://surakartakota.bps.go.id/backend/images/Header-Frontend-Besar-ind.png" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" >
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
          <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        </svg>
      </div>

      <form action="<?= base_url('login'); ?>" method="post">
        <div class="input-group mb-3">
          <input type="username" class="form-control" placeholder="Email" name="email" id="email" value="<?= set_value('email');?>" required>
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
          <!-- /.col -->
          <div class="text-center nt-3">
            <button type="submit" class="btn btn-block" style="background-color: #00497d; color: #ffffff;">login</button>
          </div><a href="<?= base_url('login/regis'); ?>" class="text-center" style="color: #00497d;">Register</a>
          <!-- /.col -->
        </div>
      </form>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
