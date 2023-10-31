<?php
include('koneksi.php');
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");

    exit;
}

// Pagination settings
$limit = 4;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// fungsi pencarian
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query = "SELECT * FROM view_data WHERE 
      product_name LIKE '%$search%' OR 
      category_name LIKE '%$search%' OR
      description LIKE '%$search%'";
} else {
    $query = "SELECT * FROM view_data";
}

// limit dan offset
$query .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($query);
if (!$result) {
    die("Error in query execution: " . $conn->error);
}

$totalRecordsQuery = "SELECT COUNT(*) AS total FROM view_data";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);
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
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="tambah_produk.php" class="btn btn-primary" role="button" title="Tambah Data"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
                                    <div class="float-right">
                                        <form id="search" method="get">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control" placeholder="Cari Produk">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Cari</button>
                                                </div>
                                                <a href="Data_produk.php" class="btn btn-secondary"><i class="fas fa-sync"></i></a>
                                            </div>
                                        </form>
                                    </div>
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
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = ($page - 1) * $limit + 1;
                                            while ($row = $result->fetch_assoc()) {

                                                echo "<tr>";
                                                echo "<td>" . $no . "</td>";
                                                echo "<td>" . $row['product_name'] . "</td>";
                                                echo "<td>" . $row['category_name'] . "</td>";
                                                echo "<td>" . $row['product_code'] . "</td>";
                                                echo "<td>" . $row['description'] . "</td>";
                                                echo "<td>" . $row['price'] . "</td>";
                                                // Periksa apakah $row['image'] adalah null
                                                if ($row['image'] === null) {
                                                    echo "<td>Gambar tidak tersedia</td>";
                                                } else {
                                                    // Data tidak null, lanjutkan dengan json_decode
                                                    $imagePaths = json_decode($row['image'], true);

                                                    if (is_array($imagePaths)) {
                                                        echo "<td>";
                                                        foreach ($imagePaths as $imagePath) {
                                                            echo "<img src='" . $imagePath . "' alt='Product Image' width='100'><br>";
                                                        }
                                                        echo "</td>";
                                                    } else {
                                                        // Jika $imagePaths bukan array, tampilkan pesan kesalahan
                                                        echo "<td>Error: Data gambar tidak valid.</td>";
                                                    }
                                                }
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
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <?php
                                            if (isset($_GET['search'])) {
                                                if ($page > 1) {
                                                    echo "<li class='page-item'><a class='page-link' href='Data_produk.php?search=$search&page=" . ($page - 1) . "'>Previous</a></li>";
                                                }

                                                for ($i = 1; $i <= $totalPages; $i++) {
                                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'>";
                                                    echo "<a class='page-link' href='Data_produk.php?search=$search&page=$i'>$i</a>";
                                                    echo "</li>";
                                                }

                                                if ($page < $totalPages) {
                                                    echo "<li class='page-item'><a class='page-link' href='Data_produk.php?search=$search&page=" . ($page + 1) . "'>Next</a></li>";
                                                }
                                            } else {
                                                if ($page > 1) {
                                                    echo "<li class='page-item'><a class='page-link' href=Data_Produk.php?page=" . ($page - 1) . "'>Previous</a></li>";
                                                }

                                                for ($i = 1; $i <= $totalPages; $i++) {
                                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'>";
                                                    echo "<a class='page-link' href='Data_produk.php?page=$i'>$i</a>";
                                                    echo "</li>";
                                                }

                                                if ($page < $totalPages) {
                                                    echo "<li class='page-item'><a class='page-link' href='Data_produk.php?page=" . ($page + 1) . "'>Next</a></li>";
                                                }
                                            }

                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <!--card body-->
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
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
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    var rowText = $(this).text().toLowerCase();
                    $(this).toggle(
                        rowText.indexOf(value) > -1
                    );
                });
            });
        });
    </script>


</body>

</html>