<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id']; // Ambil ID user dari session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form feedback
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Simpan feedback ke database
    $insert_query = "INSERT INTO feedback (user_id, product_id, rating, comment) 
                     VALUES ($user_id, $product_id, $rating, '$comment')";
    if (mysqli_query($conn, $insert_query)) {
        echo "<p>Feedback berhasil dikirim.</p>";
    } else {
        echo "<p>Gagal mengirim feedback. Coba lagi nanti.</p>";
    }
}

// Ambil produk untuk ditampilkan di halaman feedback
$product_id = $_GET['product_id'];
$product_query = "SELECT * FROM products WHERE id = $product_id";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);
?>

<h2>Berikan Umpan Balik untuk Produk: <?= htmlspecialchars($product['name']); ?></h2>

<form method="POST" action="feedback.php?product_id=<?= $product_id; ?>">
    <div class="form-group">
        <label for="rating">Rating:</label>
        <select name="rating" id="rating" class="form-control" required>
            <option value="1">1 - Buruk</option>
            <option value="2">2 - Cukup</option>
            <option value="3">3 - Baik</option>
            <option value="4">4 - Sangat Baik</option>
            <option value="5">5 - Luar Biasa</option>
        </select>
    </div>

    <div class="form-group">
        <label for="comment">Komentar:</label>
        <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
    </div>

    <input type="hidden" name="product_id" value="<?= $product_id; ?>">
    <button type="submit" class="btn btn-primary">Kirim Feedback</button>
</form>

<h3>Umpan Balik Pengguna Lain</h3>

<?php
// Tampilkan feedback yang sudah ada untuk produk ini
$feedback_query = "SELECT f.*, u.username FROM feedback f
                   JOIN users u ON f.user_id = u.id
                   WHERE f.product_id = $product_id ORDER BY f.created_at DESC";
$feedback_result = mysqli_query($conn, $feedback_query);

if (mysqli_num_rows($feedback_result) > 0):
    while ($feedback = mysqli_fetch_assoc($feedback_result)):
?>
        <div class="feedback">
            <p><strong><?= htmlspecialchars($feedback['username']); ?></strong> - Rating: <?= $feedback['rating']; ?>/5</p>
            <p><?= nl2br(htmlspecialchars($feedback['comment'])); ?></p>
            <p><small>Diposting pada: <?= $feedback['created_at']; ?></small></p>
        </div>
        <hr>
<?php
    endwhile;
else:
    echo "<p>Belum ada feedback untuk produk ini.</p>";
endif;
?>

<?php include '../includes/footer.php'; ?>
