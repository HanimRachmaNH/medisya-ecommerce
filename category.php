<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Cek apakah ID kategori ada dalam URL
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Ambil nama kategori berdasarkan ID kategori
    $category_query = "SELECT name FROM categories WHERE id = $category_id";
    $category_result = mysqli_query($conn, $category_query);
    
    if (mysqli_num_rows($category_result) > 0) {
        $category = mysqli_fetch_assoc($category_result);
        $category_name = $category['name'];
    } else {
        echo "<p>Kategori tidak ditemukan.</p>";
        exit;
    }

    // Ambil produk berdasarkan kategori
    $product_query = "SELECT * FROM products WHERE category_id = $category_id";
    $product_result = mysqli_query($conn, $product_query);
} else {
    echo "<p>ID kategori tidak ditemukan.</p>";
    exit;
}

?>

<div class="container">
    <h1>Produk dalam Kategori: <?= htmlspecialchars($category_name); ?></h1>
    
    <!-- Menampilkan produk dalam kategori -->
    <div class="row">
        <?php if (mysqli_num_rows($product_result) > 0): ?>
            <?php while ($product = mysqli_fetch_assoc($product_result)): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/<?= htmlspecialchars($product['images']); ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            <a href="product.php?id=<?= $product['id']; ?>" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada produk dalam kategori ini.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
