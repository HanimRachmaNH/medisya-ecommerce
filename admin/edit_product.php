<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit;
}

$id = $_GET['id'];

// Ambil data produk
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];
    $images = $_POST['images'];
    $quantity = $_POST['quantity'];

    $update = "UPDATE products SET
        category_id = '$category_id',
        name = '$name',
        description = '$description',
        price = '$price',
        original_price = '$original_price',
        images = '$images',
        quantity = '$quantity'
        WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: manage_products.php?updated=1");
        exit;
    } else {
        $error = "Gagal memperbarui produk: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h3 class="mb-4">Edit Produk</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Kategori ID</label>
                <input type="number" name="category_id" class="form-control" value="<?= $product['category_id']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Harga Asli</label>
                <input type="number" step="0.01" name="original_price" class="form-control" value="<?= $product['original_price']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Link Gambar</label>
                <input type="text" name="images" class="form-control" value="<?= htmlspecialchars($product['images']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="quantity" class="form-control" value="<?= $product['quantity']; ?>" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="manage_products.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
