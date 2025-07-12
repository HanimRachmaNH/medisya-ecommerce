<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

$user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Cek apakah order milik user dan masih pending
    $check_query = "SELECT * FROM orders WHERE id = ? AND user_id = ? AND status = 'Pending'";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($order) {
        // Ubah status jadi Canceled
        $update_query = "UPDATE orders SET status = 'Canceled' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: invoice.php?order_id=" . $order_id);
        exit;
    } else {
        echo "Pesanan tidak ditemukan atau sudah tidak bisa dibatalkan.";
        exit;
    }
} else {
    echo "Permintaan tidak valid.";
    exit;
}
?>
