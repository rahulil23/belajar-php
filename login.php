<?php
include('koneksi.php');
session_start(); // Mulai sesi


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data yang dikirimkan melalui form login
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Hindari SQL Injection
  $username = $conn->real_escape_string($username);

  // Cari pengguna berdasarkan username
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    // Pengguna ditemukan
    $row = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $row["password"])) {
      // Password benar, simpan informasi pengguna dalam sesi
      $_SESSION["login"] = $row["id"];
      $_SESSION["username"] = $row["username"];

      // Redirect ke halaman yang sesuai setelah login berhasil
      header("Location: dashboard.php");
    } else {
      $loginError = "Kombinasi username dan password salah";
    }
  } else {
    $error = "Pengguna tidak ditemukan";
  }

  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="asset/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="" class="h1"><b>RJ</b>SHOES</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>

        <?php if (isset($error)) : ?>
          <p><?php echo $error; ?></p>
        <?php endif; ?>


        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="username" name="username" class="form-control" placeholder="Username" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center mt-2 mb-3">
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div>
        <!-- /.social-auth-links -->

        <p class="mb-1">
          <a href="forgot-password.html">Lupa password</a>
        </p>
        <p class="mb-0">
          <a href="register.php" class="text-center">Daftar Akun</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="asset/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="asset/plugins/js/adminlte.min.js"></script>
</body>

</html>