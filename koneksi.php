<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "pos_shop";

$conn = new mysqli($hostname, $username, $password, $database);

if (!$conn) {
    echo mysqli_connect_error();
    die;
}

?>