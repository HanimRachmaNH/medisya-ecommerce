<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Pastikan ID pengguna ada di URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Ambil data pengguna berdasarkan ID
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo "User not found!";
        exit;
    }

    $user = $result->fetch_assoc();
}

// Proses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $user_level = $_POST['user_level'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $password = $_POST['password']; // Ambil password baru jika diubah

    // Jika password diubah, hash password baru
    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Jika tidak ada perubahan password, tetap menggunakan password lama
        $password_hashed = $user['password'];
    }

    // Update data pengguna di database
    $query = "UPDATE users SET username = ?, email = ?, role = ?, user_level = ?, gender = ?, phone = ?, city = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssi", $username, $email, $role, $user_level, $gender, $phone, $city, $password_hashed, $user_id);
    
    if ($stmt->execute()) {
        header("Location: manage_users.php");
        exit;
    } else {
        echo "Error updating user!";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h4>Edit User</h4>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input type="text" id="role" name="role" class="form-control" value="<?= htmlspecialchars($user['role']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="user_level" class="form-label">User Level</label>
            <input type="text" id="user_level" name="user_level" class="form-control" value="<?= htmlspecialchars($user['user_level']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <input type="text" id="gender" name="gender" class="form-control" value="<?= htmlspecialchars($user['gender']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" id="city" name="city" class="form-control" value="<?= htmlspecialchars($user['city']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password (Leave empty if not changing)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
