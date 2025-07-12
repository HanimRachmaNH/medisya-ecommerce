<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$query = "SELECT category_id, name, description, created_at FROM categories";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
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

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #0d6efd;
            padding: 30px 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
        }

        .sidebar .menu-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: #fff;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-size: 17px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #0b5ed7;
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

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: none;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; 
?>


<!-- Content -->
<div class="content">
<div class="header mb-4 d-flex justify-content-between align-items-center">
    <h4>Manage Categories</h4>
    <div>
        <a href="add_categories.php" class="btn btn-success me-3">+ Tambah Category</a>
        Total: <?= mysqli_num_rows($result); ?> Categories
    </div>
</div>


    <div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Category ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($categories = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $categories['category_id']; ?></td>
                    <td><?= htmlspecialchars($categories['name']); ?></td>
                    <td><?= htmlspecialchars($categories['description']); ?></td>
                    <td><?= date('d M Y', strtotime($categories['created_at'])); ?></td>
                    <td>
                        <a href="edit_categories.php?id=<?= $categories['category_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_categories.php?id=<?= $categories['category_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this categories?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
