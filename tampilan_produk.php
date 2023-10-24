<?php
include('koneksi.php');
session_start();
if ( !isset($_SESSION["login"])) {
  header("location: login.php");

  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard User</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!--Navbar-->
  <?php
  include('navbar.php');
  ?>
  <!--/Navbar-->

  <!-- Main Sidebar Container -->
  <?php
  include('sidebar.php');
  ?>
  <!--/sidebar-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">PRODUK</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Produk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  
    <!-- Main content -->
    <div class="row row-cols-1 row-cols-md-4 g-4 m-1">
        <?php
        //Eksekusi query SQL
          $query = "SELECT * FROM products";

          $result = mysqli_query($conn, $query);

          if (!$result) {
              die("Query error: " . mysqli_error($conn));
          }

          //Ambil hasil query dan simpan dalam array produk
          $produk = [];
          while ($row = mysqli_fetch_assoc($result)) {
              $produk[] = $row;
          }

        // Loop untuk menampilkan produk
        foreach ($produk as $item) {
        ?>
          <div class="col mt-1">
            <div class="card h-100">
              <img src="<?php echo $item['image']; ?>" class="card-img-top" alt="<?php echo $item['product_name']; ?>">
              <div class="card-body m-1">
                  <h5 class="card-title m-1"><?php echo $item['product_name']; ?></h5>
                  <p class="card-text m-1"><?php echo $item['description']; ?></p>
                  <p class="text-body-secondary m-1"><?php echo $item['price']; ?></p>
                  <p style="color: gold;" class="m-1">
                  <i class="fas fa-star"></i> 
                  <i class="fas fa-star"></i> 
                  <i class="fas fa-star"></i> 
                  <i class="fas fa-star"></i> 
                  <i class="fas fa-star-half-alt"></i>
                  </p>
                  <a href="#" class="btn btn-primary">Beli</a>
                  <a href="#" class="btn btn-link">Selengkapnya</a>
              </div>
            </div>
          </div>
        <?php
        } // Akhir loop produk
        mysqli_close($conn);
        ?>
      </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php
  include('footer.php');
  ?>
  <!--/Main Footer-->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="asset/dist/js/adminlte.min.js"></script>
</body>
</html>
