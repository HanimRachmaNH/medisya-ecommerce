<!-- Include Bootstrap and Boxicons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<!-- Sidebar -->
<div class="sidebar d-flex flex-column justify-content-between">
    <div>
        <div class="menu-header text-center fw-bold fs-4 mb-4">Medisya</div>
        <a href="dashboard.php" class="nav-link"><i class='bx bxs-dashboard'></i><span>Dashboard</span></a>
        <a href="manage_users.php" class="nav-link"><i class='bx bx-user'></i><span>Users</span></a>
        <a href="manage_categories.php" class="nav-link"><i class='bx bx-category'></i><span>Categories</span></a>
        <a href="manage_products.php" class="nav-link"><i class='bx bx-box'></i><span>Products</span></a>
        <a href="../auth/logout.php" class="nav-link"><i class='bx bx-log-out'></i><span>Logout</span></a>
    </div>
</div>

<!-- Custom CSS -->
<style>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    background: linear-gradient(135deg, #20c997, #17a2b8);
    padding: 30px 0;
    color: #fff;
    z-index: 1000;
}

.sidebar .nav-link {
    color: #fff;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.15);
    border-left: 4px solid #fff;
    padding-left: 26px;
}

.sidebar .menu-header {
    color: #fff;
}
</style>
