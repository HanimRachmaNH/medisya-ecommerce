<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $query = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_categories.php?success=1");
        exit;
    } else {
        $error = "Gagal menambahkan kategori: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h3 class="mb-4">Tambah Kategori Baru</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="manage_categories.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
