<?php  
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Ambil alamat pengguna
$query_user = "SELECT address FROM users WHERE id = $user_id";
$result_user = mysqli_query($conn, $query_user);
$user_data = mysqli_fetch_assoc($result_user);
$user_address = $user_data['address'];

$user_name = $_SESSION['user']['name'];

// Ambil data keranjang
$query = "SELECT cp.id AS cart_id, cp.product_id, cp.quantity, p.name, p.description, p.price, p.images, p.category_id, c.name AS category_name
          FROM cart_products cp
          JOIN products p ON cp.product_id = p.id
          JOIN categories c ON p.category_id = c.category_id
          WHERE cp.cart_id = $user_id";
$result = mysqli_query($conn, $query);

$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $order_date = date('Y-m-d H:i:s');
    $status = 'pending';
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $payment_type = strtolower($payment_method) === 'cod' ? 'postpaid' : 'prepaid';

    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : ''; 
    $bank_name = isset($_POST['bank_name']) ? mysqli_real_escape_string($conn, $_POST['bank_name']) : ''; 
    $va = isset($_POST['va']) ? mysqli_real_escape_string($conn, $_POST['va']) : '';
    
    $order_query = "INSERT INTO orders (user_id, address, total_price, payment_type, order_date, phone, bank_name, va) 
                    VALUES ($user_id, '$user_address', $total, '$payment_type', '$order_date', '$phone', '$bank_name', '$va')";
    
    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn);

        $cart_query = "SELECT cp.product_id, cp.quantity, p.name, p.description, p.price, p.images, p.category_id, c.name AS category_name
                       FROM cart_products cp
                       JOIN products p ON cp.product_id = p.id
                       JOIN categories c ON p.category_id = c.category_id
                       WHERE cp.cart_id = $user_id";
        $cart_result = mysqli_query($conn, $cart_query);
        
        while ($cart_item = mysqli_fetch_assoc($cart_result)) {
            $insert_order_detail = "INSERT INTO order_products 
                (order_id, product_id, category_id, category_name, name, description, price, images, quantity, created_at, updated_at)
                VALUES (
                    $order_id,
                    {$cart_item['product_id']},
                    {$cart_item['category_id']},
                    '" . mysqli_real_escape_string($conn, $cart_item['category_name']) . "',
                    '" . mysqli_real_escape_string($conn, $cart_item['name']) . "',
                    '" . mysqli_real_escape_string($conn, $cart_item['description']) . "',
                    {$cart_item['price']},
                    '" . mysqli_real_escape_string($conn, $cart_item['images']) . "',
                    {$cart_item['quantity']},
                    NOW(), NOW())";
            mysqli_query($conn, $insert_order_detail);
        }

        mysqli_query($conn, "DELETE FROM cart_products WHERE cart_id = $user_id");

        header("Location: invoice.php?order_id=$order_id");
        exit;
    } else {
        echo "Terjadi kesalahan saat memproses pesanan.";
    }
}
?>

<!-- Tambahkan Bootstrap dan Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-5">
    <div class="card shadow rounded-4 mb-4">
        <div class="card-header text-center text-dark" style="background-color:  #20c997; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
            <h2 class="mb-0">Detail Pesanan</h2>
        </div>
        <div class="card-body">
            <h4 class="mb-4"></h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $subtotal = $row['price'] * $row['quantity'];
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td>Rp <?= number_format($row['price']); ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td>Rp <?= number_format($subtotal); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-end fs-5 fw-bold mt-3">
                Total: Rp <?= number_format($total); ?>
            </div>
        </div>
    </div>

    <form method="POST" action="" class="card shadow rounded-4 p-4">
        <h4 class="mb-3">Pilih Metode Pembayaran</h4>
        <div class="mb-3">
            <select name="payment_method" id="payment_method" class="form-select" required onchange="toggleBankField()">
                <option value="" disabled selected>Pilih Metode</option>
               
                <option value="Transfer Bank">Transfer Bank</option>
               
                <option value="COD">COD</option>
            </select>
        </div>

        <div class="mb-3" id="bank_field" style="display: none;">
            <label for="bank_name" class="form-label">Nama Bank</label>
            <input type="text" name="bank_name" id="bank_name" class="form-control">
        </div>

        <h4 class="mt-4 mb-3">Informasi Kontak</h4>

        <div class="mb-3">
            <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill">
                <i class="bi bi-credit-card-2-back-fill me-2"></i>Proses Pembayaran
            </button>
        </div>
    </form>
</div>

<script>
    function toggleBankField() {
        const paymentMethod = document.getElementById('payment_method').value;
        const bankField = document.getElementById('bank_field');
        const vaField = document.getElementById('va_field');

        if (paymentMethod === 'Transfer Bank') {
            bankField.style.display = 'block';
            vaField.style.display = 'block';
        } else {
            bankField.style.display = 'none';
            vaField.style.display = 'none';
        }
    }

    // Jalankan saat halaman dimuat untuk menyembunyikan jika default adalah COD
    document.addEventListener('DOMContentLoaded', toggleBankField);
</script>
