<?php
include('koneksi.php');
require('controler_crud.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $product = new Product($conn);
    $result = $product->deleteProduct($id);

    if ($result) {
        echo '<script>alert("Produk berhasil dihapus!");</script>';
        // Redirect ke halaman produk setelah penghapusan
        header("Location: Data_produk.php");
        exit();
    } else {
        echo "Error: Gagal menghapus produk.";
    }
} else {
    echo "ID produk tidak valid.";
}
?>




