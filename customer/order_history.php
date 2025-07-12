<?php
session_start();
include '../includes/db.php';
include '../includes/header.php'; // Sesuaikan dengan strukturmu

if (!isset($_SESSION['user'])) {
    echo "<div class='alert alert-danger'>Anda harus login terlebih dahulu.</div>";
    exit;
}

$user_id = $_SESSION['user']['id'];

$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="container my-4">
    <h3 class="mb-4">Riwayat Pesanan Anda</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>#<?= str_pad($row['id'], 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= date('d M Y', strtotime($row['order_date'])) ?></td>
                        <td>Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge bg-<?= match($row['status']) {
                                'Pending' => 'warning',
                                'Shipped' => 'info',
                                'Completed' => 'success',
                                'Canceled' => 'danger',
                                default => 'secondary',
                            } ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="invoice.php?order_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Lihat Invoice</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

