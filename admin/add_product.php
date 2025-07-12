<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];
    $images = $_POST['images'];
    $quantity = $_POST['quantity'];
    $rating = $_POST['rating'];

    $query = "INSERT INTO products (category_id, name, description, price, original_price, images, quantity, rating)
              VALUES ('$category_id', '$name', '$description', '$price', '$original_price', '$images', '$quantity', '$rating')";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_products.php?success=1");
        exit;
    } else {
        $error = "Gagal menambahkan produk: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h3 class="mb-4">Tambah Produk Baru</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Kategori ID</label>
                <input type="number" name="category_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga Asli</label>
                <input type="number" step="0.01" name="original_price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Link Gambar</label>
                <input type="text" name="images" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Rating</label>
                <input type="number" step="0.1" name="rating" class="form-control" value="0" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="manage_products.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
