<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "online_shop";

$conn = new mysqli($hostname, $username, $password, $database);

if (!$conn) {
    echo mysqli_connect_error();
    die;
}
echo "Koneksi berhasil";

?>