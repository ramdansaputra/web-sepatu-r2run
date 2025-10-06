<?php
session_start();
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['id_user'];

$sql = "SELECT t.id_transaksi, t.tanggal_transaksi, t.total, t.status, t.metode_pembayaran, t.alamat_pengiriman
        FROM transaksi t
        WHERE t.id_user = ?
        ORDER BY t.tanggal_transaksi DESC";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php'; // Header tetap
?>

<link rel="stylesheet" href="css/order_history.css"> <!-- Tambah CSS khusus di sini -->

<h1>Your Order History</h1>
<div class="order-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="order">
                <h3>Transaction ID: <?= $row['id_transaksi'] ?></h3>
                <p>Transaction Date: <?= $row['tanggal_transaksi'] ?></p>
                <p>Subotal: Rp <?= number_format($row['total'], 0, ',', '.') ?></p>
                <p>Status: <?= $row['status'] ?></p>
                <p>Payment Method: <?= $row['metode_pembayaran'] ?></p>
                <p>Address: <?= $row['alamat_pengiriman'] ?></p>
                <a class="details-link" href="order_detail.php?id=<?= $row['id_transaksi'] ?>">View Details</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-order-message">
            <p>No orders found.</p>
        </div>
    <?php endif; ?>
</div>
