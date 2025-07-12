<?php
$host = "localhost";
$user = "root"; // sesuaikan kalau bukan root
$pass = "";     // sesuaikan kalau ada password
$dbname = "db_medisya"; // nama database hasil import

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
