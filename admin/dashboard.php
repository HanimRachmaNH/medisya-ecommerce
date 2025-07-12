<?php 
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$adminName = $_SESSION['user']['username'];

// Ambil total dari database
$result_users = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$total_users = mysqli_fetch_assoc($result_users)['total_users'];

$result_products = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM products");
$total_products = mysqli_fetch_assoc($result_products)['total_products'];

$result_orders = mysqli_query($conn, "SELECT COUNT(*) AS total_orders FROM orders");
$total_orders = mysqli_fetch_assoc($result_orders)['total_orders'];

$limit = 5;  // Jumlah produk yang akan ditampilkan per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman yang sedang aktif
$offset = ($page - 1) * $limit;  // Menghitung offset berdasarkan halaman

// Ambil filter status dari URL
$statusFilter = $_GET['status'] ?? 'All';

// Query untuk mengambil orders dengan filter status dan pagination
$query = "
    SELECT 
        o.id AS order_id,
        o.user_id,
        u.username,
        o.order_date,
        o.total_price,
        o.status,
        GROUP_CONCAT(op.name SEPARATOR ', ') AS product_names
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_products op ON op.order_id = o.id
    WHERE o.order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
";

if ($statusFilter !== 'All') {
    $query .= " AND o.status = '" . mysqli_real_escape_string($conn, $statusFilter) . "'";
}

$query .= " GROUP BY o.id ORDER BY o.order_date DESC LIMIT $limit OFFSET $offset"; // Menambahkan LIMIT dan OFFSET

$result = mysqli_query($conn, $query);

// Hitung total data untuk pagination
$count_query = "SELECT COUNT(DISTINCT o.id) AS total FROM orders o WHERE o.order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
if ($statusFilter !== 'All') {
    $count_query .= " AND o.status = '" . mysqli_real_escape_string($conn, $statusFilter) . "'";
}
$count_result = mysqli_query($conn, $count_query);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Medisya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background-color: #f1f3f6;
            font-family: 'Segoe UI', sans-serif;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
        }

        .header {
            background-color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .header h4 {
            margin: 0;
            font-weight: bold;
        }

        .nav-tabs .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
            border-radius: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: none;
        }

        .table img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 13px;
        }

        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .dot-pending { background-color: #dc3545; }
        .dot-dispatch { background-color: #28a745; }
        .dot-completed { background-color: #6c757d; }

        .pagination {
            justify-content: end;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="content">
    <div class="header mb-4">
        <h4>Admin Dashboard</h4>
        <div>Welcome, <?= htmlspecialchars($adminName); ?></div>
    </div>

    <!-- Summary Cards Section -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Total Users</h6>
                <p class="fs-4"><?= $total_users; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Total Products</h6>
                <p class="fs-4"><?= $total_products; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Total Orders</h6>
                <p class="fs-4"><?= $total_orders; ?></p>
            </div>
        </div>
    </div>

    <!-- Order Table Section -->
    <div class="card p-4">
        <h5 class="mb-3">Recent Orders <small class="text-muted">Last 7 Days</small></h5>

        <!-- Tab Filter -->
        <ul class="nav nav-tabs mb-3">
            <?php
            $tabs = ['All', 'Pending', 'Shipped', 'Completed', 'Canceled'];
            foreach ($tabs as $tab) {
                $active = $statusFilter === $tab ? 'active' : '';
                echo "<li class='nav-item'><a class='nav-link $active' href='?status=$tab'>$tab</a></li>";
            }
            ?>
        </ul>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Item</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { 
                        $orderId = '#' . str_pad($row['order_id'], 6, '0', STR_PAD_LEFT);
                        $username = htmlspecialchars($row['username']);
                        $products = htmlspecialchars($row['product_names']);
                        $orderDate = date('d M Y', strtotime($row['order_date']));
                        $total = 'Rp' . number_format($row['total_price'], 0, ',', '.');
                        $status = $row['status'];
                        $statusClass = match ($status) {
                            'Pending' => 'dot-pending',
                            'Shipped' => 'dot-dispatch',
                            'Completed' => 'dot-completed',
                            'Canceled' => 'dot-canceled',
                            default => 'dot-secondary',
                        };
                    ?>
                        <tr>
                            <td><?= $orderId ?></td>
                            <td><?= $username ?></td>
                            <td><?= $products ?></td>
                            <td><?= $orderDate ?></td>
                            <td><span class="text-success"><?= $total ?></span></td>
                            <td><span class="status-dot <?= $statusClass ?>"></span> <?= $status ?></td>
                            <td>
                                <form method="POST" action="update_status.php" class="d-flex align-items-center">
                                    <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                    <select name="status" class="form-select form-select-sm me-2" 
                                        <?= in_array($status, ['Completed', 'Canceled']) ? 'disabled' : '' ?>>
                                        <?php
                                        $statuses = ['Pending', 'Shipped', 'Completed', 'Canceled'];
                                        foreach ($statuses as $s) {
                                            $selected = $s === $status ? 'selected' : '';
                                            echo "<option value=\"$s\" $selected>$s</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if (!in_array($status, ['Completed', 'Canceled'])): ?>
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Update">Update</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php
    $pagesPerBlock = 3;
    $currentBlock = ceil($page / $pagesPerBlock);
    $startPage = ($currentBlock - 1) * $pagesPerBlock + 1;
    $endPage = min($startPage + $pagesPerBlock - 1, $total_pages);
    $prevBlockPage = max(1, $startPage - $pagesPerBlock);
    $nextBlockPage = $endPage + 1;
    ?>

    <nav>
        <ul class="pagination justify-content-end">
            <?php if ($startPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $prevBlockPage ?>">«</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">«</span></li>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($endPage < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $nextBlockPage ?>">»</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">»</span></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>