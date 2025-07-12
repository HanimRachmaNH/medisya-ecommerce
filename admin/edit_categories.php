<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Fetch existing category details
    $query = "SELECT * FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);

    if (!$category) {
        die("Category not found.");
    }

    // Handle form submission to update category details
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $update_query = "UPDATE categories SET name = '$name', description = '$description' WHERE category_id = $category_id";
        if (mysqli_query($conn, $update_query)) {
            header("Location: manage_categories.php");
            exit;
        } else {
            $error = "Failed to update category.";
        }
    }
} else {
    die("Category ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
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
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Content -->
<div class="content">
    <div class="header mb-4">
        <h4>Edit Category</h4>
    </div>

    <div class="card p-4">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form action="edit_categories.php?id=<?= $category['category_id']; ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($category['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Category Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($category['description']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
