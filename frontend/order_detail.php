<?php
session_start();
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID transaksi tidak ditemukan.";
    exit;
}

$id_transaksi = intval($_GET['id']);

// Ambil detail transaksi
$sql_transaksi = "SELECT * FROM transaksi WHERE id_transaksi = ? AND id_user = ?";
$stmt = $koneksi->prepare($sql_transaksi);
$stmt->bind_param('ii', $id_transaksi, $_SESSION['id_user']);
$stmt->execute();
$result_transaksi = $stmt->get_result();

if ($result_transaksi->num_rows == 0) {
    echo "Transaksi tidak ditemukan.";
    exit;
}

$transaksi = $result_transaksi->fetch_assoc();

// Ambil detail produk yang dibeli
$sql_detail = "SELECT dp.jumlah, p.nama_produk, p.harga, p.gambar
               FROM detail_transaksi dp
               JOIN produk p ON dp.id_produk = p.id_produk
               WHERE dp.id_transaksi = ?";
$stmt = $koneksi->prepare($sql_detail);
$stmt->bind_param('i', $id_transaksi);
$stmt->execute();
$result_detail = $stmt->get_result();

// Panggil header agar layout konsisten
include 'header.php';
?>
<link rel="stylesheet" href="css/order_detail.css">

<!-- Tidak perlu buka <body> lagi karena sudah dibuka di header.php -->
<div class="order-detail-container">
    <h1 style="text-align: center; margin-bottom: 30px;">Order Details</h1>

    <div class="order-info">
        <p><strong>Transaction ID:</strong> <?= $transaksi['id_transaksi'] ?></p>
        <p><strong>Transaction Date:</strong> <?= $transaksi['tanggal_transaksi'] ?></p>
        <p><strong>Status:</strong> <?= $transaksi['status'] ?></p>
        <p><strong>Payment Method:</strong> <?= $transaksi['metode_pembayaran'] ?></p>
        <p><strong>Addres:</strong> <?= $transaksi['alamat_pengiriman'] ?></p>
        <p><strong>Subtotal:</strong> Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></p>
    </div>

    <h3 style="margin-top: 30px;">Purchased Products</h3>
    <?php while ($item = $result_detail->fetch_assoc()): ?>
        <div class="product-item">
            <img src="../images/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_produk']) ?>">
            <div class="product-details">
                <p><strong><?= htmlspecialchars($item['nama_produk']) ?></strong></p>
                <p>Quantity: <?= $item['jumlah'] ?></p>
                <p>Price: Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
            </div>
        </div>
    <?php endwhile; ?>
</div>