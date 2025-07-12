<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek nama file aktif
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Kesehatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/medisya/assets/style.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background: linear-gradient(135deg, #20c997, #17a2b8);
            padding: 1.1rem 0;
        }
        .navbar-brand-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            margin-left: 10px;
        }
        .cart-profile-area {
            color: white;
        }
        .cart-icon, .profile-icon, .home-icon {
            font-size: 1.5rem;
        }
        .cart-text {
            font-size: 0.85rem;
        }
        .profile-icon {
            margin-left: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom text-white pt-5 pb-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo + Slogan -->
        <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="/medisya/dashboard.php">
                <img src="/medisya/assets/logo.jpg" alt="Logo" style="height: 40px;">
                <span class="navbar-brand-text">MEDISYA<br><small style="font-size: 0.8rem;">Your Health First</small></span>
            </a>
        </div>

        <!-- Cart + Riwayat Pesanan + Profile + Logout -->
        <div class="d-flex align-items-center cart-profile-area">
            <!-- Tampilkan tombol Home jika bukan di dashboard -->
            <?php if ($current_page !== 'dashboard.php'): ?>
                <div class="text-center me-4">
                    <a href="/medisya/customer/dashboard.php" class="text-white text-decoration-none d-block">
                        <i class="bi bi-house-fill home-icon"></i>
                    </a>
                </div>
            <?php endif; ?>

            <!-- Cart -->
            <div class="text-center me-4">
                <a href="/medisya/customer/cart.php" class="text-white text-decoration-none d-block">
                    <div>
                        <i class="bi bi-cart-check-fill cart-icon"></i>
                    </div>
                    <?php
                    $jumlah = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                    if ($jumlah > 0) {
                        $total = 0;
                        foreach ($_SESSION['cart'] as $item) {
                            $total += $item['harga'] * $item['jumlah'];
                        }
                        echo '<div class="cart-text">' . $jumlah . ' item - Rp ' . number_format($total, 0, ',', '.') . '</div>';
                    }
                    ?>
                </a>
            </div>
            <!-- Riwayat Pesanan -->
            <div class="text-center me-4">
            <?php if (isset($_SESSION['user'])): ?>
                    <a href="/medisya/customer/order_history.php" class="text-white text-decoration-none d-block">
                        <i class="bi bi-file-earmark-text cart-icon"></i>
                    </a>
                </div>
            <?php endif; ?>

            <!-- Profile -->
            <div class="text-center me-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/medisya/profile.php" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="bi bi-person-fill profile-icon"></i>
                        <span class="ms-2"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                    </a>
                <?php else: ?>
                    <a href="/medisya/auth/login.php" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="bi bi-person-fill profile-icon"></i>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Logout -->
            <?php if (isset($_SESSION['user'])): ?>
                <form action="/medisya/auth/logout.php" method="POST" style="margin: 0;">
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
