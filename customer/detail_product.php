<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$id = (int) $_GET['id'];
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Produk tidak ditemukan.";
    exit;
}

$product = mysqli_fetch_assoc($result);
$image_url = !empty($product['images']) ? str_replace('http://localhost/medisya/', '../', $product['images']) : '../assets/products/default.jpg';
?>

<div class="container py-5">
  <div class="row">
    <div class="col-md-5">
      <img src="<?= htmlspecialchars($image_url); ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($product['name']); ?>">
    </div>
    <div class="col-md-7">
      <h2><?= htmlspecialchars($product['name']); ?></h2>
      <h4 class="text-success mb-3">Rp <?= number_format($product['price'], 0, ',', '.'); ?></h4>
      <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
      <a href="cart.php?add=<?= $product['id']; ?>" class="btn btn-success">Masukkan ke Keranjang</a>
      <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
</div>
