<?php
include 'includes/db.php';
include 'includes/header.php';

$result = mysqli_query($conn, "SELECT products.*, categories.name AS category_name FROM products
                               JOIN categories ON products.category_id = categories.id");
?>

<h2>Daftar Produk</h2>
<div style="display: flex; flex-wrap: wrap;">
<?php while($row = mysqli_fetch_assoc($result)): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px; width:200px;">
        <img src="assets/<?= $row['image']; ?>" width="100%" height="150"><br>
        <strong><?= $row['name']; ?></strong><br>
        Kategori: <?= $row['category_name']; ?><br>
        Harga: Rp <?= number_format($row['price']); ?><br>
    </div>
<?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
