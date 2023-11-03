<?php
include('koneksi.php');
require('controler_crud.php');

// Ambil ID produk dari parameter URL
$product_id = $_GET['id'];

// Query untuk mengambil data produk berdasarkan ID
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
  echo "Produk tidak ditemukan.";
  exit;
}

$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve data from the form
  $product_name = $_POST['product_name'];
  $category_id = $_POST['category_id'];
  $product_code = $_POST['product_code'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  // Mengelola pengunggahan gambar
  $imagePath = $product['image']; // Mengambil path gambar yang ada sebagai default

  if (!empty($_FILES['product_image']['name'][0])) {
    $imageDirectory = 'uploud/'; // Ganti dengan direktori tempat Anda ingin menyimpan gambar

    $imagePaths = array();

    foreach ($_FILES['product_image']['tmp_name'] as $key => $tmp_name) {
      if ($_FILES['product_image']['error'][$key] == UPLOAD_ERR_OK) {
        $imageFileName = uniqid() . '_' . $_FILES['product_image']['name'][$key];
        $targetPath = $imageDirectory . $imageFileName;

        if (move_uploaded_file($tmp_name, $targetPath)) {
          $imagePaths[] = $targetPath;
        }
      }
    }

    if (!empty($imagePaths)) {
      $imagePath = json_encode($imagePaths); // Simpan sebagai JSON
    }
  }

  // Call the updateProduct function
    $product_id = $_GET['id']; // Retrieve product ID from the URL
    $product = new Product($conn);
    $result = $product->updateProduct($product_id, $product_name, $category_id, $product_code, $description, $price, $imagePath);

    if ($result) {
        echo '<script>alert("Product updated successfully!");</script>';
        header("location: Data_produk.php");
        exit;
    } else {
        echo "Error occurred while updating the product.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit-Produk</title>

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
              <h1 class="m-0"> EDIT PRODUK</h1>
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
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Perbarui Produk</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="product_name">Nama Produk:</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" required value="<?php echo $product['product_name']; ?>">
                  </div>
                  <div class="form-group">
                    <?php
                    $query = "SELECT * FROM product_categories";
                    $result = mysqli_query($conn, $query);
                    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    ?>
                    <label for="category_id">Kategori Produk:</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                      <?php
                      foreach ($categories as $category) {
                        $categoryId = $category['id'];
                        $categoryName = $category['category_name'];
                        $selected = ($categoryId == $product['category_id']) ? 'selected' : '';
                        echo "<option value='" . $categoryId . "' $selected>" . $categoryName . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="product_code">Kode Produk:</label>
                    <input type="text" name="product_code" id="product_code" class="form-control" required value="<?php echo $product['product_code']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="description">Deskripsi:</label>
                    <textarea name="description" id="description" class="form-control" required><?php echo $product['description']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="price">Harga:</label>
                    <input type="text" name="price" id="price" class="form-control" required value="<?php echo $product['price']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="product_image">Gambar Produk:</label>
                    <?php
                    if (!empty($product['image'])) {
                      $images = json_decode($product['image']);
                      if (is_array($images)) {
                        echo '<table>';
                        echo '<tr>';
                        foreach ($images as $image) {
                          echo "<td><img src='$image' alt='Product Image' width='100'></td>";
                        }
                        echo '</tr>';
                        echo '</table>';
                      }
                    }
                    ?>
                    <input type="file" name="product_image[]" id="product_image" class="form-control" accept="image/*" multiple>
                  </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
              </form>
            </div>
          </div>
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
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <script src="asset/plugins/jquery/jquery.min.js"></script>
  <script src="asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="asset/dist/js/adminlte.min.js"></script>
</body>

</html>