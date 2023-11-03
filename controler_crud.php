<?php
include('koneksi.php');
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // tampilan produk
    public function readProducts($search = '', $page = 1, $limit = 4)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM view_data";

        if (!empty($search)) {
            $search = $this->conn->real_escape_string($search);
            $query .= " WHERE 
              product_name LIKE '%$search%' OR 
              category_name LIKE '%$search%' OR
              description LIKE '%$search%'";
        }

        $query .= " LIMIT $limit OFFSET $offset";

        $result = $this->conn->query($query);

        if (!$result) {
            die("Error in query execution: " . $this->conn->error);
        }

        return $result;
    }

    public function getTotalRecords()
    {
        $totalRecordsQuery = "SELECT COUNT(*) AS total FROM view_data";
        $totalRecordsResult = $this->conn->query($totalRecordsQuery);
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
        return $totalRecords;
    }

    // tambah produk
    public function createProduct($product_name, $description, $price, $category_id, $product_code, $image)
    {
        // Gunakan prepared statement untuk menghindari SQL injection
        $stmt = $this->conn->prepare("INSERT INTO products (product_name, description, price, category_id, product_code, image) VALUES (?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssdiss", $product_name, $description, $price, $category_id, $product_code, $image);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($product_id, $product_name, $category_id, $product_code, $description, $price, $imagePath) {
        $stmt = $this->conn->prepare("UPDATE products SET product_name = ?, category_id = ?, product_code = ?, description = ?, price = ?, image = ? WHERE id = ?");

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("sissdsi", $product_name, $category_id, $product_code, $description, $price, $imagePath, $product_id);


        if ($stmt->execute()) {
            return true; // Product updated successfully
        } else {
            return false; // Error occurred while updating the product
        }
    }

    // hapus produk
    public function deleteProduct($id)
    {
        $id = $this->conn->real_escape_string($id);

        $query = "DELETE FROM products WHERE id = $id";

        if (mysqli_query($this->conn, $query)) {
            return true; // Produk berhasil dihapus
        } else {
            return false; // Terjadi kesalahan saat menghapus produk
        }
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}
