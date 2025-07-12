<?php  
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query);

// Handle Edit Profile
if (isset($_POST['save_profile'])) {
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender']; // Sudah lowercase dari form
    $address = $_POST['address'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $paypal_id = $_POST['paypal_id'];

    $update = mysqli_query($conn, "UPDATE users SET 
        email = '$email',
        date_of_birth = '$date_of_birth',
        gender = '$gender',
        address = '$address',
        city = '$city',
        phone = '$phone',
        paypal_id = '$paypal_id'
        WHERE id = $user_id");

    if ($update) {
        $success = "Profil berhasil diperbarui.";
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
        $user = mysqli_fetch_assoc($query);
    } else {
        $error = "Gagal memperbarui profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .profile-card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      background: #fff;
    }
    .profile-avatar {
      width: 120px;
      height: 120px;
      background-color: #dce1e7;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 40px;
      color: #6c757d;
      margin: 0 auto 15px auto;
    }
    .profile-avatar img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }
    .form-section {
      padding: 30px;
    }
    .form-control, .form-select {
      border-radius: 10px;
    }
    .btn-primary {
      border-radius: 8px;
      padding: 0.5rem 1.5rem;
    }
    textarea.form-control {
      resize: none;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="profile-card p-4">
        <h3 class="text-center mb-4">PROFILE</h3>

        <?php if (isset($success)): ?>
          <div class="alert alert-success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="row">
            <!-- LEFT: AVATAR -->
            <div class="col-md-4 text-center">
              <div class="profile-avatar">
                <span>👤</span>
              </div>
              <!-- Dihilangkan input file -->
            </div>

            <!-- RIGHT: FORM INPUT -->
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label>Email:</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label>Tanggal Lahir:</label>
                  <input type="date" name="date_of_birth" class="form-control" value="<?= htmlspecialchars($user['date_of_birth']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <label>Jenis Kelamin:</label>
                  <select name="gender" class="form-select">
                    <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Perempuan</option>
                    <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Lainnya</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label>No HP:</label>
                  <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <label>Alamat:</label>
                  <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <label>Kota:</label>
                  <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($user['city']); ?>">
                </div>
                <div class="col-md-12 mb-3">
                  <label>PayPal ID:</label>
                  <input type="text" name="paypal_id" class="form-control" value="<?= htmlspecialchars($user['paypal_id']); ?>">
                </div>
              </div>
              <div class="text-end">
                <button type="submit" name="save_profile" class="btn btn-primary">Update Information</button>
              </div>
            </div>
          </div>
        </form>

      </div>
      <div class="text-end mt-3">
        <a href="customer/dashboard.php" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
        <a href="auth/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
