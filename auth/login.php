<?php
session_start();
include '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'username' => $row['username'],
                'role' => $row['role']
            ];

            // Cegah user biasa mencoba akses login admin
            if ($row['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
                exit;
            } elseif ($row['role'] === 'customer' || $row['role'] === 'visitor') {
                header("Location: ../customer/dashboard.php");
                exit;
            } else {
                $error = "Role tidak dikenali!";
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email belum terdaftar!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Medisya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: #F5F5F5;
            overflow-x: hidden;
            position: relative;
        }

        .shape1, .shape2 {
            position: absolute;
            border-radius: 50%;
            z-index: -1;
            opacity: 0.15;
        }

        .shape1 {
            width: 300px;
            height: 300px;
            background-color: #20c997;
            top: -80px;
            left: -80px;
        }

        .shape2 {
            width: 200px;
            height: 200px;
            background-color: #ffc107;
            bottom: -60px;
            right: -60px;
        }

        .main-container {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .form-card {
            display: flex;
            width: 90%;
            max-width: 900px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            background-color: white;
        }

        .left-panel {
            background: linear-gradient(135deg, rgba(32, 201, 151, 0.8), rgba(23, 162, 184, 0.8));
            color: white;
            padding: 60px 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .right-panel {
            background: white;
            padding: 60px 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel h2 {
            font-weight: bold;
        }
        

        .left-panel p {
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .btn-register {
            border: 2px solid white;
            background: transparent;
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-register:hover {
            background: white;
            color: #20c997;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <div class="shape1"></div>
    <div class="shape2"></div>

    <div class="main-container">
        <div class="form-card">
            <!-- Left panel -->
            <div class="left-panel text-center">
                <h2>New Here?</h2>
                <p>Create an account to get started with Medisya</p>
                <a href="register.php" class="btn btn-register">REGISTER</a>
            </div>

            <!-- Right panel -->
            <div class="right-panel">
                <p class="text-center mb-4 text-muted fw-bold fs-2 text-green">Login</p>
                <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn w-100" style="background-color:rgb(36, 212, 197); color: white;">LOG IN</button>

            <!-- Error Message -->
            <?php if (!empty($error)): ?>
                <div class="mt-3 alert alert-danger text-center" role="alert">
                    <?= $error; ?>
                </div>
            <?php endif; ?>
        </form>
            </div>
        </div>
    </div>
</body>
</html>
