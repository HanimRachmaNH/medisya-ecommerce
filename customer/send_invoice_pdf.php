<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../includes/db.php';
session_start();

if (!isset($_SESSION['user']) || !isset($_POST['order_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user']['id'];
$order_id = intval($_POST['order_id']);

// Ambil data order
$order_query = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    die("Order tidak ditemukan.");
}

$user_query = "SELECT username, email FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$product_query = "SELECT p.name, op.quantity, op.price 
                  FROM order_products op
                  JOIN products p ON op.product_id = p.id
                  WHERE op.order_id = $order_id";
$product_result = mysqli_query($conn, $product_query);

// Generate HTML untuk invoice
ob_start();
?>
<h2 style="text-align:center;">Invoice Pembelian - Medisya</h2>
<p><strong>Nama:</strong> <?= htmlspecialchars($user['username']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Tanggal:</strong> <?= $order['order_date'] ?></p>
<p><strong>Alamat:</strong> <?= htmlspecialchars($order['address']) ?></p>
<hr>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $total = 0;
        while ($row = mysqli_fetch_assoc($product_result)) {
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>Rp <?= number_format($row['price']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td>Rp <?= number_format($subtotal) ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="4" align="right"><strong>Pajak (10%)</strong></td>
            <td>Rp <?= number_format($total * 0.10) ?></td>
        </tr>
        <tr>
            <td colspan="4" align="right"><strong>Total Termasuk Pajak</strong></td>
            <td><strong>Rp <?= number_format($total * 1.10) ?></strong></td>
        </tr>
    </tbody>
</table>
<?php
$html = ob_get_clean();

// 1. Generate PDF dengan Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$pdf_output = $dompdf->output();

// 2. Kirim PDF via Email dengan PHPMailer
$mail = new PHPMailer(true);

try {
    // Konfigurasi SMTP kamu
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Ganti dengan SMTP server kamu
    $mail->SMTPAuth = true;
    $mail->Username = 'rachmahanim13@gmail.com'; // Email pengirim
    $mail->Password = 'kfbg waol uoei qehh';    // Password email
    $mail->SMTPSecure = 'tls'; // atau ssl
    $mail->Port = 587;

    // Info pengirim & penerima
    $mail->setFrom('rachmahanim13@gmail.com', 'Medisya');
    $mail->addAddress($user['email'], $user['username']);

    // Lampirkan PDF
    $mail->addStringAttachment($pdf_output, 'Invoice_Medisya.pdf');

    $mail->isHTML(true);
    $mail->Subject = 'Invoice Pembelian Anda';
    $mail->Body    = '<p>Halo <strong>' . htmlspecialchars($user['username']) . '</strong>,</p>
                      <p>Terlampir invoice pembelian Anda di Medisya.</p>
                      <p>Terima kasih telah berbelanja!</p>';

    $mail->send();
    echo "<script>
        alert('Invoice berhasil dikirim ke email Anda.');
        window.location.href = 'invoice.php?order_id=$order_id';
    </script>";

} catch (Exception $e) {
    echo "Email gagal dikirim. Mailer Error: {$mail->ErrorInfo}";
}
