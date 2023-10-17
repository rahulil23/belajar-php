<?php
include('koneksi.php');
session_start();
if ( !isset($_SESSION["login"])) {
  header("location: login.php");

  exit;
}
//queri sql
$query = "SELECT * FROM products";
$result = $conn->query($query);

if (!$result) {
    die("Error dalam eksekusi query: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data-Produk</title>

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
  <!--Navbar-->

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
            <h1 class="m-0"> DATA PRODUK</h1>
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
    <div class="card">
      <div class="card-header">
        <a href="tambah_produk.php" class="btn btn-primary" role="button" title="Tambah Data"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Nama produk</th>
            <th>Kategori Produk</th>
            <th>Kode produk</th>
            <th>deskripsi</th>
            <th>Harga</th>
            <th>aksi</th>
          </tr>
          </thead>
          <tbody>
          <?php
          $no = 1;
          while ($row = $result->fetch_assoc()) 
          {
            
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td>" . $row['category_id'] . "</td>";
            echo "<td>" . $row['product_code'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>";
            echo "<a href='edit_produk.php?id=" . $row['id'] . "' class='btn btn-success'>Ubah</a>";
            echo "<a href='hapus_produk.php?id=" . $row['id'] . "' class='btn btn-danger'>Hapus</a>";
            echo "</td>";
            echo "</tr>";
            $no++;
          }
          
        
          ?>
          </tbody>
          <tfoot>
          <tr>
          <th>No</th>
            <th>Nama produk</th>
            <th>Kategori Produk</th>
            <th>Kode produk</th>
            <th>deskripsi</th>
            <th>Harga</th>
            <th>aksi</th>
          </tr>
          </tfoot>
        </table>
      </div>    
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