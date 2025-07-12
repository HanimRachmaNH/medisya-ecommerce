<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $product_id = intval($_POST['product_id']);
    $order_id = intval($_POST['order_id']);
    $rating = intval($_POST['rating']);
    $comment = mysqli_real_escape_string($conn, trim($_POST['comment']));
    $created_at = date('Y-m-d H:i:s');

    // Cek jika sudah pernah beri feedback
    $check = mysqli_query($conn, "SELECT * FROM feedback WHERE user_id = $user_id AND product_id = $product_id");
    if (mysqli_num_rows($check) === 0) {
        $query = "INSERT INTO feedback (user_id, product_id, rating, comment, created_at)
                  VALUES ($user_id, $product_id, $rating, '$comment', '$created_at')";
        mysqli_query($conn, $query);
    }

    header("Location: invoice.php?order_id=$order_id");
    exit;
}
?>
