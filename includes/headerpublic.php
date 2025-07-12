<!-- header.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medisya - Solusi Belanja Alat Kesehatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <style>
        :root {
            --primary: #007acc;
            --accent: #00bcd4;
            --bg-light: #f5fbff;
            --font-main: 'Segoe UI', sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-light);
        }

        .navbar-custom {
            background-color: white;
            padding: 1.2rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar-brand-text {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--primary);
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #333;
            margin: 0 10px;
        }

        .btn-login, .btn-register {
            font-weight: 500;
            border-radius: 25px;
        }

        .btn-login {
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-login:hover {
            background-color: var(--primary);
            color: #fff;
        }

        .btn-register {
            background-color: var(--accent);
            color: #fff;
        }

        .btn-register:hover {
            background-color: #0097a7;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Brand -->
            <a class="navbar-brand" href="index.php">
                <img src="assets/logo.jpg" alt="Logo">
                <span class="navbar-brand-text">Medisya</span>
            </a>

            <!-- Navigation Links -->
            <div class="d-flex align-items-center">
                <a href="auth/login.php" class="btn btn-login me-2">
                    </i> Login
                </a>
                <a href="auth/register.php" class="btn btn-register me-3">
                    </i> Register
                </a>
                <a href="auth/login.php" class="text-decoration-none">
                </a>
            </div>
        </div>
    </nav>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
