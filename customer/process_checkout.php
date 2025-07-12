<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Ambil data user
$query_user = "SELECT username, email, address FROM users WHERE id = $user_id";
$result_user = mysqli_query($conn, $query_user);
$user_data = mysqli_fetch_assoc($result_user);
$user_address = $user_data['address'];

// Ambil isi keranjang
$query = "SELECT cp.id AS cart_id, cp.product_id, cp.quantity, 
                 p.name, p.description, p.price, p.images, 
                 p.category_id, c.name AS category_name
          FROM cart_products cp
          JOIN products p ON cp.product_id = p.id
          JOIN categories c ON p.category_id = c.category_id
          WHERE cp.cart_id = $user_id";
$result = mysqli_query($conn, $query);

$total = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $cart_items[] = $row;
}

// Proses saat form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_date = date('Y-m-d H:i:s');
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $payment_type = mysqli_real_escape_string($conn, $_POST['payment_type']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name'] ?? '');
    $va = mysqli_real_escape_string($conn, $_POST['va'] ?? '');
    $paypal_id = mysqli_real_escape_string($conn, $_POST['paypal_id'] ?? '');

    // Simpan hanya ke session
    $_SESSION['payment_method'] = $payment_method;
    $_SESSION['bank_name'] = $bank_name;
    $_SESSION['va'] = $va;
    $_SESSION['paypal_id'] = $paypal_id;

    // Hitung total dengan pajak
    $tax = $total * 0.10;
    $total_with_tax = $total + $tax;

    // Simpan pesanan TANPA kolom bank_name dan paypal_id
    $order_query = "INSERT INTO orders (
        user_id, address, phone, total_price, payment_type, order_date, status
    ) VALUES (
        $user_id, '$user_address', '$phone', $total_with_tax, '$payment_type', '$order_date', 'Pending'
    )";

    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn);

        foreach ($cart_items as $item) {
            $insert_order_detail = "INSERT INTO order_products (
                order_id, product_id, category_id, category_name, name, description, 
                price, images, quantity, created_at, updated_at
            ) VALUES (
                $order_id,
                {$item['product_id']},
                {$item['category_id']},
                '" . mysqli_real_escape_string($conn, $item['category_name']) . "',
                '" . mysqli_real_escape_string($conn, $item['name']) . "',
                '" . mysqli_real_escape_string($conn, $item['description']) . "',
                {$item['price']},
                '" . mysqli_real_escape_string($conn, $item['images']) . "',
                {$item['quantity']},
                NOW(), NOW()
            )";
            mysqli_query($conn, $insert_order_detail);
        }

        // Bersihkan keranjang
        mysqli_query($conn, "DELETE FROM cart_products WHERE cart_id = $user_id");

        // Redirect ke invoice
        header("Location: invoice.php?order_id=$order_id");
        exit;
    } else {
        echo "Gagal menyimpan pesanan.";
    }
} else {
    header("Location: checkout.php");
    exit;
}
