<?php 
session_start();
include 'includes/db.php';
include 'includes/headerpublic.php';

$logged_in = isset($_SESSION['user']); 

$query = "SELECT * FROM products LIMIT 3";  
$result = mysqli_query($conn, $query);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
    }

    .product-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: transform 0.25s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-4px);
    }

    .product-image {
        object-fit: contain;
        height: 160px;
        width: 100%;
        background-color: #f9f9f9;
        padding: 1rem;
    }

    .badge-discount {
        background-color: #28a745;
        font-size: 0.7rem;
        padding: 0.3em 0.6em;
        border-radius: 6px;
    }

    .product-price {
        font-weight: 600;
        color: #28a745;
    }

    .price-original {
        text-decoration: line-through;
        color: #999;
        font-size: 0.85rem;
        margin-left: 6px;
    }

    .card-body {
        padding: 0.9rem 1rem;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 600;
    }

    .features-section {
        background: linear-gradient(to right, #e3f2fd, #f1f9ff);
        padding: 4rem 0;
    }

    .feature-icon {
        width: 56px;
        height: 56px;
        background-color: #0d6efd;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
</style>

    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(to right, #e0f7f5, #f8fcfb);">
    <div class="container">
        <div class="row align-items-center justify-content-between">
        <div class="col-md-6 mb-4 mb-md-0">
            <h6 class="text-primary fw-semibold mb-2">MEDISYA</h6>
            <h1 class="fw-bold display-5 text-dark mb-3">Solusi Belanja <br> Alat Kesehatan</h1>
            <p class="text-muted mb-4">Temukan berbagai produk kesehatan terpercaya dengan mudah dan aman melalui Medisya. Belanja alat medis jadi lebih cepat dan praktis!</p>
            <a href="#products" class="btn btn-primary px-4 py-2 rounded-pill">Lihat Produk</a>
        </div>
        <div class="col-md-5 d-flex justify-content-center">
            <div style="
            width: 320px;
            height: 320px;
            background: url('assets/medisyahero.jpg') center/cover no-repeat;
            border-radius: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.6);
            "></div>
        </div>
        </div>
    </div>
    </section>



<!-- Feature Cards -->
<section class="py-5 features-section">
    <div class="container text-center">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white">
                    <div class="feature-icon mx-auto"><i class="bi bi-tags"></i></div>
                    <h6>Promo Spesial</h6>
                    <p class="text-muted">Diskon hingga 30% setiap minggu</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white">
                    <div class="feature-icon mx-auto"><i class="bi bi-calendar-check"></i></div>
                    <h6>Pemesanan</h6>
                    <p class="text-muted">Langsung melalui sistem</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white">
                    <div class="feature-icon mx-auto"><i class="bi bi-heart-pulse"></i></div>
                    <h6>Produk Medis</h6>
                    <p class="text-muted">Bergaransi dan berkualitas</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 shadow-sm rounded bg-white">
                    <div class="feature-icon mx-auto"><i class="bi bi-geo-alt"></i></div>
                    <h6>Lokasi</h6>
                    <p class="text-muted">Tersedia seluruh Indonesia</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Produk Populer -->
<div class="container py-4" id="products">
    <h3 class="text-center fw-bold mb-4">Produk Populer</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($product = mysqli_fetch_assoc($result)): 
                $price = (float)$product['price'];
                $original_price = (float)$product['original_price'];
                $discount = ($original_price > $price) ? round((($original_price - $price) / $original_price) * 100) : 0;
                $image_url = !empty($product['images']) ? $product['images'] : 'http://localhost/medisya/assets/products/default.jpg';
            ?>
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <?php if ($discount > 0): ?>
                                <span class="badge badge-discount position-absolute top-0 start-0 m-2"><?= $discount ?>% off</span>
                            <?php endif; ?>
                            <img src="<?= htmlspecialchars($image_url); ?>" class="product-image" alt="<?= htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                            <div class="d-flex align-items-center mb-2">
                                <div class="product-price">Rp <?= number_format($price, 0, ',', '.'); ?></div>
                                <?php if ($discount > 0): ?>
                                    <div class="price-original">Rp <?= number_format($original_price, 0, ',', '.'); ?></div>
                                <?php endif; ?>
                            </div>
                            <a href="auth/login.php" class="btn btn-outline-primary w-100">BUY</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada produk untuk ditampilkan.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Jadwal / Pengiriman -->
<section class="py-5" style="background-color: #e6f4fa;">
    <div class="container text-center">
        <h3 class="fw-bold">Jadwal Pengiriman</h3>
        <p class="text-muted mb-4">Pesanan diproses setiap hari kerja dan dikirim melalui ekspedisi pilihan Anda.</p>
        <div class="feature-icon mx-auto"><i class="bi bi-truck"></i></div>
    </div>
</section>

    <!-- Kenapa Pilih Medisya -->
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="fw-bold text-center mb-4">Kenapa Pilih Medisya?</h3>
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <i class="bi bi-shield-check text-success fs-1 mb-2"></i>
                    <p class="fw-semibold">Produk Terverifikasi</p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-truck text-primary fs-1 mb-2"></i>
                    <p class="fw-semibold">Pengiriman Cepat</p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-wallet2 text-warning fs-1 mb-2"></i>
                    <p class="fw-semibold">Harga Kompetitif</p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-headset text-danger fs-1 mb-2"></i>
                    <p class="fw-semibold">Layanan Bantuan 24/7</p>
                </div>
            </div>
        </div>
    </section>

<!-- Tambahkan ini di bagian <head> atau sebelum akhir </body> jika belum ada -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<?php include 'includes/footerpublic.php'; ?>
