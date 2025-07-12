<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username      = $_POST['username'];
    $email         = $_POST['email'];
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $date_of_birth = $_POST['date_of_birth'];
    $gender        = $_POST['gender'];
    $address       = $_POST['address'];
    $city          = $_POST['city'];
    $phone         = $_POST['phone'];
    $role          = 'customer';
    $user_level    = 'basic';
    $created_at    = date('Y-m-d H:i:s');

    $query = "INSERT INTO users 
        (username, email, password, date_of_birth, gender, address, city, phone, role, user_level, created_at)
        VALUES 
        ('$username', '$email', '$password', '$date_of_birth', '$gender', '$address', '$city', '$phone', '$role', '$user_level', '$created_at')";

    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Gagal register: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna - Medisya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f1f4f6, #e2f0ec);
            min-height: 100vh;
            overflow-x: hidden;
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
            min height: 100vh;
            justify-content: center;
            align-items: start;
            padding: 40px 20px;
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
            background: linear-gradient(135deg, #20c997, #17a2b8);
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

        .btn-login {
            border: 2px solid white;
            background: transparent;
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            font-weight: bold; /* bold text */
            text-decoration: none;
        }

        .btn-login:hover {
            background: white;
            color: #20c997;
        }

        

        .form-control, .form-select {
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
                <h2>Welcome Back!</h2>
                <p>To keep connected with us please login with your personal info</p>
                <a href="login.php" class="btn btn-login">LOG IN</a>
            </div>

            <!-- Right panel -->
            <div class="right-panel">
                <p class="text-center mb-4 text-muted fw-bold fs-2 text-green">Register</p>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" class="form-control" required>
                    </div>
                    <div class="mb-3">
                    <label class="form-label d-block">Jenis Kelamin</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" required>
                        <label class="form-check-label" for="gender_male">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female">
                        <label class="form-check-label" for="gender_female">Perempuan</label>
                    </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <button type="submit" class="btn w-100" style="background-color: #20c997; color: white;">REGISTER</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
