<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Ambil status saat ini dari database
    $stmt = mysqli_prepare($conn, "SELECT status FROM orders WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $orderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $currentStatus);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Jika status sudah Completed, tolak update
    if ($currentStatus === 'Completed') {
        header("Location: dashboard.php?msg=Order already completed");
        exit;
    }

    // Update status jika belum Completed
    $stmt = mysqli_prepare($conn, "UPDATE orders SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $newStatus, $orderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: dashboard.php?msg=Status updated");
exit;
?>
