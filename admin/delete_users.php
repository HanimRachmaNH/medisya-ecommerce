<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_users.php?error=invalid_id");
    exit;
}

$user = intval($_GET['id']);

// Cek apakah produk ada di database
$checkQuery = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $checkQuery);
mysqli_stmt_bind_param($stmt, "i", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    header("Location: manage_users.php?error=not_found");
    exit;
}

// Hapus produk
$deleteQuery = "DELETE FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $deleteQuery);
mysqli_stmt_bind_param($stmt, "i", $user);

if (mysqli_stmt_execute($stmt)) {
    header("Location: manage_users.php?success=deleted");
} else {
    header("Location: manage_users.php?error=delete_failed");
}
exit;
?>
