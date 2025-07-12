<?php 
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

  // Ambil kategori
  $category_query = "SELECT * FROM categories ORDER BY name ASC";
  $category_result = mysqli_query($conn, $category_query);

  // Tangkap filter kategori dari URL
  $selected_category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : null;

  // Query produk, dengan filter jika ada kategori yang dipilih
  if ($selected_category_id) {
      $product_query = "SELECT * FROM products WHERE category_id = $selected_category_id LIMIT 10";
  } else {
      $product_query = "SELECT * FROM products LIMIT 10";
  }
  $product_result = mysqli_query($conn, $product_query);
  ?>

<div class="container py-4">
  <div class="row">
    <!-- Sidebar kategori -->
    <div class="col-md-3 mb-4">
      <div class="card">
        <div class="card-header bg-primary text-white">Kategori Produk</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item <?= is_null($selected_category_id) ? 'fw-bold' : ''; ?>">
            <a href="dashboard.php" class="<?= is_null($selected_category_id) ? 'text-primary' : ''; ?>">Semua Produk</a>
          </li>
          <?php while ($cat = mysqli_fetch_assoc($category_result)): ?>
            <li class="list-group-item <?= ($selected_category_id == $cat['category_id']) ? 'fw-bold' : ''; ?>">
              <a href="dashboard.php?category_id=<?= $cat['category_id']; ?>" class="<?= ($selected_category_id == $cat['category_id']) ? 'text-primary' : ''; ?>">
                <?= htmlspecialchars($cat['name']); ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>

    <!-- Produk -->
    <div class="col-md-9">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (mysqli_num_rows($product_result) > 0): ?>
          <?php while ($product = mysqli_fetch_assoc($product_result)):
            $price = (float)$product['price'];
            $original_price = (float)$product['original_price'];
            $discount = ($original_price > $price) ? round((($original_price - $price) / $original_price) * 100) : 0;
            $image_url = !empty($product['images']) ? str_replace('http://localhost/medisya/', '../', $product['images']) : '../assets/products/default.jpg';
            $prod_id = $product['id'];
            // Ambil statistik feedback
            $fb_stats_q = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS cnt FROM feedback WHERE product_id = $prod_id";
            $fb_stats_res = mysqli_query($conn, $fb_stats_q);
            $fb_stats = mysqli_fetch_assoc($fb_stats_res);
            $avg_rating = $fb_stats['avg_rating'] ? number_format($fb_stats['avg_rating'],1) : '0.0';
            $fb_count = $fb_stats['cnt'];
          ?>
            <div class="col">
                <a href="detail_product.php?id=<?= $prod_id; ?>" class="text-decoration-none text-dark">
                <div class="card product-card h-100">
                <div class="position-relative">
                  <?php if ($discount > 0): ?>
                    <span class="badge badge-discount position-absolute top-0 start-0 m-2"><?= $discount ?>% off</span>
                  <?php endif; ?>
                  <img src="<?= htmlspecialchars($image_url); ?>" class="product-image" alt="<?= htmlspecialchars($product['name']); ?>">
                </div>
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                  <div class="d-flex align-items-center mb-2">
                    <div class="product-price">Rp <?= number_format($price, 0, ',', '.'); ?></div>
                    <?php if ($discount > 0): ?>
                      <div class="price-original">Rp <?= number_format($original_price, 0, ',', '.'); ?></div>
                    <?php endif; ?>
                  </div>
                  <div class="mb-2">
                      Rating: <?= $avg_rating ?> / 5 (<?= $fb_count ?> feedback)
                  </div>
                  <div class="mt-auto">
                    <a href="cart.php?add=<?= $prod_id; ?>" class="btn btn-success">Buy</a>
                    <button class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#feedbackModal<?= $prod_id; ?>">Lihat Feedback</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Feedback -->
            <div class="modal fade" id="feedbackModal<?= $prod_id; ?>" tabindex="-1" aria-labelledby="feedbackModalLabel<?= $prod_id; ?>" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel<?= $prod_id; ?>">Feedback untuk <?= htmlspecialchars($product['name']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <?php
                    $fb_q = "SELECT f.rating, f.comment, f.created_at, u.username FROM feedback f JOIN users u ON f.user_id = u.id WHERE f.product_id = $prod_id ORDER BY f.created_at DESC";
                    $fb_res = mysqli_query($conn, $fb_q);
                    if (mysqli_num_rows($fb_res) > 0):
                        while ($fb = mysqli_fetch_assoc($fb_res)):
                    ?>
                      <div class="mb-3 border-bottom pb-2">
                        <strong><?= htmlspecialchars($fb['username']); ?></strong>
                        <span class="ms-2">Rating: <?= $fb['rating']; ?>/5</span>
                        <p class="mb-1"><?= htmlspecialchars($fb['comment']); ?></p>
                        <small class="text-muted"><?= $fb['created_at']; ?></small>
                      </div>
                    <?php
                        endwhile;
                    else:
                    ?>
                      <div class="alert alert-secondary">Belum ada feedback untuk produk ini.</div>
                    <?php endif; ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>

          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-warning text-center">Tidak ada produk pada kategori ini.</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Medisya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    .product-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-image {
        object-fit: cover;
        height: 200px;
        width: 100%;
    }

    .badge-discount {
        background-color: #2e7d32;
        font-size: 0.75rem;
        padding: 0.4em 0.6em;
        border-radius: 8px;
    }

    .product-price {
        font-weight: 600;
        color: #2e7d32;
    }

    .price-original {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
        margin-left: 8px;
    }

    .card-body {
        padding: 1rem;
    }

    /* Modifikasi warna kategori */
    .card-header {
        background: linear-gradient(135deg, #20c997, #17a2b8) !important;
        color: white;
    }

    .list-group-item a {
        color: inherit;
    }

    .list-group-item a:hover {
        color: #20c997;
    }

    .list-group-item {
        border: none;
    }

    /* Kategori yang dipilih */
    .list-group-item.fw-bold a {
        color:  #20c997; 
    }

      /* Mengubah warna text-primary dengan gradasi */
    .text-primary {
      background: linear-gradient(135deg, #20c997, #17a2b8);
      -webkit-background-clip: text;  
      color: transparent;  
      font-weight: bold;  
    }


    .text-gradient {
    background: linear-gradient(135deg, #20c997, #17a2b8);
    -webkit-background-clip: text;
    color: transparent;
    font-weight: bold;
  }

  .text-gradient:hover {
      background: linear-gradient(135deg, #17a2b8, #20c997);
      -webkit-background-clip: text;
      color: transparent;
    }

  </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include '../includes/footer.php'; ?>