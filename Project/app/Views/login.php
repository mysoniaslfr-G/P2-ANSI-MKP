<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MKP 2025 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('template/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- sweetalert2 -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('template/plugins/sweetalert2/sweetalert2.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('template/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    Sistem Monitoring<br>  <b> Keuangan & Pembayaran</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masukkan Username dan Password Anda</p>

      <!-- Login Form -->
      <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>
        
        <!-- Username -->
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username') ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        
        <!-- Password -->
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <!-- Remember Me -->
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url('template/plugins/jquery/jquery.min.js') ?>"></script>

<!-- sweetalert2 -->
<script src="<?= base_url('template/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?= base_url('template/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('template/js/adminlte.min.js') ?>"></script>

<?php if (session()->getFlashdata('alert')): ?>
  <script>
    let alert = <?= json_encode(session()->getFlashdata('alert')) ?>;
    Swal.fire({
      icon: alert[0], // success, error, info, warning, question
      title: alert[1],
      showConfirmButton: false,
      timer: 5000, // waktu dalam milidetik
      timerProgressBar: true,
    });
  </script>
<?php endif; ?>




</body>
</html>
