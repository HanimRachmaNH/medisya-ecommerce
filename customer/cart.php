<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// TAMBAH PRODUK KE KERANJANG
if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);

    $check_query = "SELECT * FROM cart_products WHERE cart_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($check_result) > 0) {
        $update_query = "UPDATE cart_products SET quantity = quantity + 1 WHERE cart_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($stmt);
    } else {
        $product_query = "SELECT * FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $product_query);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $product_result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($product_result);

        if ($product) {
            $insert_query = "INSERT INTO cart_products 
                (cart_id, product_id, category_id, category_name, name, description, price, images, quantity, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param(
                $stmt,
                "iiisssds",
                $user_id,
                $product['id'],
                $product['category_id'],
                $product['category_name'],
                $product['name'],
                $product['description'],
                $product['price'],
                $product['images']
            );
            mysqli_stmt_execute($stmt);
        }
    }

    header("Location: cart.php?msg=added");
    exit;
}

// HAPUS PRODUK
if (isset($_GET['remove'])) {
    $cart_product_id = intval($_GET['remove']);
    $delete_query = "DELETE FROM cart_products WHERE id = ? AND cart_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "ii", $cart_product_id, $user_id);
    mysqli_stmt_execute($stmt);
    header("Location: cart.php?msg=removed");
    exit;
}

// INCREASE / DECREASE QUANTITY
if (isset($_GET['increase'])) {
    $cart_product_id = intval($_GET['increase']);
    $update_query = "UPDATE cart_products SET quantity = quantity + 1 WHERE id = ? AND cart_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "ii", $cart_product_id, $user_id);
    mysqli_stmt_execute($stmt);
    header("Location: cart.php");
    exit;
}

if (isset($_GET['decrease'])) {
    $cart_product_id = intval($_GET['decrease']);

    $check_query = "SELECT quantity FROM cart_products WHERE id = ? AND cart_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $cart_product_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check && $row_check['quantity'] > 1) {
        $update_query = "UPDATE cart_products SET quantity = quantity - 1 WHERE id = ? AND cart_id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ii", $cart_product_id, $user_id);
        mysqli_stmt_execute($stmt);
    } else {
        $delete_query = "DELETE FROM cart_products WHERE id = ? AND cart_id = ?";
        $stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($stmt, "ii", $cart_product_id, $user_id);
        mysqli_stmt_execute($stmt);
    }

    header("Location: cart.php");
    exit;
}

// AMBIL SEMUA PRODUK DI KERANJANG
$query = "SELECT * FROM cart_products WHERE cart_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!-- Tambahkan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-5">
    <h2>Keranjang Belanja</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): 
                    $subtotal = $row['price'] * $row['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td>Rp <?= number_format($row['price']); ?></td>
                        <td>
                            <a href="cart.php?decrease=<?= $row['id']; ?>" class="btn btn-sm btn-warning">-</a>
                            <?= $row['quantity']; ?>
                            <a href="cart.php?increase=<?= $row['id']; ?>" class="btn btn-sm btn-success">+</a>
                        </td>
                        <td>Rp <?= number_format($subtotal); ?></td>
                        <td>
                            <a href="javascript:void(0);" 
                               class="btn btn-danger btn-sm delete-item"
                               data-id="<?= $row['id']; ?>" 
                               data-name="<?= htmlspecialchars($row['name']); ?>">
                               Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp <?= number_format($total); ?></strong></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="dashboard.php" class="btn btn-warning">
                <i class="bi bi-plus-circle me-1"></i> Tambah Produk Lain
            </a>
            <a href="checkout.php" class="btn btn-success">
                <i class="bi bi-arrow-right-circle me-1"></i> Lanjutkan Checkout
            </a>
        </div>
        
        <?php else: ?>
    <div class="text-center py-5">
        <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="Cart Empty" width="150" class="mb-4">
        <h4 class="text-muted">Keranjang Anda kosong</h4>
        <p class="text-secondary">Ayo mulai belanja dan temukan produk kesehatan terbaik untuk Anda.</p>
        <a href="dashboard.php" class="btn btn-primary mt-3">Lihat Produk</a>
    </div>
<?php endif; ?>

</div>

<script>
    // Konfirmasi hapus dengan SweetAlert
    document.querySelectorAll('.delete-item').forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-id');
            const itemName = this.getAttribute('data-name');

            Swal.fire({
                title: 'Hapus produk?',
                text: `Produk: ${itemName}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `cart.php?remove=${itemId}`;
                }
            });
        });
    });

    // Tampilkan notifikasi jika ada parameter msg
    const urlParams = new URLSearchParams(window.location.search);
    const msg = urlParams.get('msg');
    if (msg === 'added') {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Produk telah ditambahkan ke keranjang.',
            timer: 2000,
            showConfirmButton: false
        });
    } else if (msg === 'removed') {
        Swal.fire({
            icon: 'success',
            title: 'Dihapus!',
            text: 'Produk berhasil dihapus dari keranjang.',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>

