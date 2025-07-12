<?php 
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

$user_id = $_SESSION['user']['id'];

if (!isset($_GET['order_id'])) {
    echo "Order ID tidak ditemukan.";
    exit;
}

$order_id = intval($_GET['order_id']);

$order_query = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    echo "Pesanan tidak ditemukan atau Anda tidak memiliki akses.";
    exit;
}

$user_query = "SELECT username, email FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$product_query = "SELECT p.id AS product_id, p.name, op.quantity, op.price, op.category_name
                  FROM order_products op
                  JOIN products p ON op.product_id = p.id
                  WHERE op.order_id = $order_id";
$product_result = mysqli_query($conn, $product_query);

$payment_type_map = [
    'cod' => 'COD (Bayar di Tempat)',
    'bank_transfer' => 'Transfer Bank',
    'qris' => 'QRIS',
    'gopay' => 'GoPay',
    'shopeepay' => 'ShopeePay',
    'credit_card' => 'Kartu Kredit',
    'paypal' => 'PayPal',
];

$payment_type_display = $payment_type_map[strtolower(trim($order['payment_type']))] ?? htmlspecialchars($order['payment_type']);
?>

<style>
    .card { border-radius: 1rem; }
    .card-header h3 { font-weight: bold; }
    .badge { font-size: 0.9rem; padding: 0.5em 0.75em; }
    table th, table td { vertical-align: middle !important; }
    .btn-outline-danger i, .btn-success i { margin-right: 5px; }
    .alert-success { display: flex; align-items: center; gap: 0.5rem; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container my-5">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-gradient text-white rounded-top-4" style="background: linear-gradient(135deg, #20c997, #17a2b8);">
            <h3 class="mb-0">Invoice Pembelian</h3>
        </div>
        <div class="card-body">

            <!-- Informasi Pembeli -->
            <div class="mb-5">
                <h5 class="fw-bold mb-4 text-primary">
                    <i class="bi bi-person-circle me-2"></i>Informasi Pembeli
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 border rounded-3 shadow-sm bg-white h-100">
                            <h6 class="text-muted mb-3">Data Diri</h6>
                            <p class="mb-2"><strong>Nama:</strong> <?= htmlspecialchars($user['username']) ?></p>
                            <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                            <p class="mb-0"><strong>No. HP:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                            <p class="mb-0"><strong>Nama Bank:</strong> <?= htmlspecialchars($order['bank_name']) ?></p>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 border rounded-3 shadow-sm bg-white h-100">
                            <h6 class="text-muted mb-3">Pengiriman & Status</h6>
                            <p class="mb-2"><strong>Alamat:</strong> <?= htmlspecialchars($order['address']) ?></p>
                            <p class="mb-2"><strong>Tanggal Pesanan:</strong> <?= $order['order_date'] ?></p>
                            <p class="mb-0">
                                <strong>Status:</strong>
                                <span class="badge bg-<?= 
                                    $order['status'] === 'Completed' ? 'success' : 
                                    ($order['status'] === 'Pending' ? 'warning text-dark' : 'secondary') ?>">
                                    <?= htmlspecialchars($order['status']) ?>
                                </span>
                            </p>

                            <?php if ($order['status'] === 'Completed'): ?>
                                <div class="mt-4">
                                    <form id="invoiceForm" method="POST" action="send_invoice_pdf.php" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?= $order_id ?>">
                                        <<button type="submit" class="btn btn-success">
                                            <i class="bi bi-send-check"></i> Kirim Invoice ke Email
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <p! 

        <-- Metode Pembayaran -->
<div class="mb-5">
    <h5 class="fw-bold mb-4 text-primary">
        <i class="bi bi-credit-card-2-front me-2"></i>Metode Pembayaran
    </h5>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="p-4 border rounded-3 shadow-sm bg-white h-100">
                <p class="text-muted mb-1">Jenis Pembayaran</p>
                <p class="fw-semibold mb-0"><?= $payment_type_display ?></p>
                <p class="mb-0">Nomor Virtual Account : 1234567890</p>
                <p class="fw-semibold mb-0">Jika COD maka pembayaran dilakukan setelah pesanan tiba (Cash on Delivery).</p>
            </div>
        </div>

        <!-- Jika Pembayaran Transfer Bank, tampilkan nama bank -->
        <?php if (strtolower($order['payment_type']) === 'bank_transfer' && !empty($order['bank_name'])): ?>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 shadow-sm bg-white h-100">
                    <p class="text-muted mb-1">Bank Tujuan</p>
                    <p class="fw-semibold mb-0"><?= htmlspecialchars($order['bank_name']) ?: '-' ?></p>
                    <p class="mb-0">Nomor VA : 1234567890</p>
                    <p class="mb-0">Jika COD maka pembayaran lewat VA ditempat</p>
                </div>
            </div>
        <?php elseif (strtolower($order['payment_type']) === 'bank_transfer'): ?>
            <!-- Jika pembayaran bank transfer tapi bank_name kosong, beri tanda - -->
            <div class="col-md-4">
                <div class="p-4 border rounded-3 shadow-sm bg-white h-100">
                    <p class="text-muted mb-1">Bank Tujuan</p>
                    <p class="fw-semibold mb-0">-</p>
                    <p class="mb-0">Nomor VA : 1234567890</p>
                    <p class="mb-0">Jika COD maka pembayaran lewat VA ditempat</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Jika metode COD (Postpaid), tampilkan catatan pembayaran -->
        <?php if (strtolower($order['payment_type']) === 'cod'): ?>
            <div class="col-md-4">
                <div class="p-4 border rounded-3 shadow-sm bg-white h-100">
                    <p class="text-muted mb-1">Catatan Pembayaran</p>
                    <p class="fw-semibold mb-0">Pembayaran dilakukan setelah pesanan tiba (Cash on Delivery).</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

            <?php if ($order['status'] === 'Pending'): ?>
                <form id="cancelForm" method="POST" action="cancel_order.php" class="mb-4">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <button type="button" id="cancelButton" class="btn btn-outline-danger">
                        <i class="bi bi-x-circle-fill"></i> Batalkan Pesanan
                    </button>
                </form>
            <?php endif; ?>

            <!-- Produk -->
            <h5 class="mb-3">Daftar Produk</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $total = 0;
                        $products = [];
                        while ($row = mysqli_fetch_assoc($product_result)) {
                            $product_id = $row['product_id'];
                            $subtotal = $row['price'] * $row['quantity'];
                            $total += $subtotal;
                            $products[] = $row;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td>Rp <?= number_format($row['price']) ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td>Rp <?= number_format($subtotal) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Pajak (10%)</strong></td>
                            <td>Rp <?= number_format($total * 0.10) ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total Termasuk Pajak</strong></td>
                            <td><strong>Rp <?= number_format($total * 1.10) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Feedback -->
            <?php if ($order['status'] === 'Completed'): ?>
                <div class="mt-5">
                    <h5 class="mb-3">Feedback Produk</h5>
                    <?php foreach ($products as $row): 
                        $product_id = $row['product_id'];
                        $feedback_check_query = "SELECT * FROM feedback WHERE user_id = $user_id AND product_id = $product_id";
                        $feedback_check_result = mysqli_query($conn, $feedback_check_query);
                        $has_feedback = mysqli_num_rows($feedback_check_result) > 0;
                    ?>
                    <div class="mb-4">
                        <h6><?= htmlspecialchars($row['name']) ?></h6>
                        <?php if ($has_feedback): ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill"></i> Anda sudah memberikan feedback untuk produk ini.
                            </div>
                        <?php else: ?>
                            <div class="card bg-light border-0 p-3">
                                <form method="POST" action="submit_feedback.php">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <input type="hidden" name="order_id" value="<?= $order_id ?>">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-3">
                                            <label for="rating_<?= $product_id ?>" class="form-label">
                                                <i class="bi bi-star-fill text-warning me-1"></i>Rating
                                            </label>
                                            <select name="rating" id="rating_<?= $product_id ?>" class="form-select" required>
                                                <option value="">Pilih Rating</option>
                                                <option value="1">1 - Buruk</option>
                                                <option value="2">2 - Cukup</option>
                                                <option value="3">3 - Biasa</option>
                                                <option value="4">4 - Bagus</option>
                                                <option value="5">5 - Sangat Bagus</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="comment_<?= $product_id ?>" class="form-label">
                                                <i class="bi bi-chat-text me-1"></i>Komentar
                                            </label>
                                            <input type="text" name="comment" id="comment_<?= $product_id ?>" class="form-control" placeholder="Tulis komentar Anda di sini..." required>
                                        </div>
                                        <div class="col-md-3 d-grid">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-send-fill me-1"></i> Kirim Feedback
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.getElementById("cancelButton")?.addEventListener("click", function () {
    Swal.fire({
        title: 'Batalkan Pesanan?',
        text: "Apakah Anda yakin ingin membatalkan pesanan ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("cancelForm").submit();
        }
    });
});

document.getElementById("sendInvoiceBtn")?.addEventListener("click", function () {
    Swal.fire({
        title: 'Invoice Terkirim',
        text: "Invoice Anda telah dikirim ke email.",
        icon: 'success',
        confirmButtonText: 'Oke'
    });
});
</script>

<?php include '../includes/footer.php'; ?>
