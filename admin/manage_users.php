<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$query = "SELECT id, username, email, role, user_level, gender, phone, city, created_at FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>List Users</title>
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

        .btn {
            font-size: 12px;
            padding: 5px 10px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; 
?>

<!-- Content -->
<div class="content">
    <div class="header mb-4">
        <h4>List Users</h4>
        <div>Total: <?= mysqli_num_rows($result); ?> users</div>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= ucfirst($user['gender']); ?></td>
                        <td><?= htmlspecialchars($user['phone']); ?></td>
                        <td><?= htmlspecialchars($user['city']); ?></td>
                        <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <a href="edit_users.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete Button -->
                            <a href="delete_users.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
