<?php
session_start();
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$name     = $_POST['name'] ?? '';
$address  = $_POST['address'] ?? '';
$email    = $_POST['email'] ?? '';
$payment  = $_POST['payment'] ?? '';

$id_keranjang = $_POST['id_keranjang'] ?? [];
$id_produk    = $_POST['id_produk'] ?? [];
$id_ukuran    = $_POST['id_ukuran'] ?? [];
$quantity     = $_POST['quantity'] ?? [];
$harga        = $_POST['harga'] ?? [];

if (empty($name) || empty($address) || empty($email) || empty($payment) || empty($id_produk)) {
    echo "<script>alert('Data tidak lengkap!'); window.location.href='checkout_multiple.php';</script>";
    exit;
}

// Hitung total semua
$total = 0;
for ($i = 0; $i < count($id_produk); $i++) {
    $total += floatval($harga[$i]) * intval($quantity[$i]);
}

$koneksi->begin_transaction();

try {
    // Simpan ke tabel transaksi
    $query_transaksi = "INSERT INTO transaksi (id_user, tanggal_transaksi, total, status, metode_pembayaran, alamat_pengiriman)
                        VALUES (?, NOW(), ?, 'Pending', ?, ?)";
    $stmt = $koneksi->prepare($query_transaksi);
    $stmt->bind_param("idss", $id_user, $total, $payment, $address);
    $stmt->execute();

    $id_transaksi = $stmt->insert_id;
    if ($id_transaksi <= 0) {
        throw new Exception("Gagal membuat transaksi");
    }

    // Simpan semua detail
    $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_produk, id_ukuran, jumlah, harga_satuan, subtotal)
                     VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_detail = $koneksi->prepare($query_detail);

    for ($i = 0; $i < count($id_produk); $i++) {
        $sub = floatval($harga[$i]) * intval($quantity[$i]);
        $stmt_detail->bind_param("iiiidd", $id_transaksi, $id_produk[$i], $id_ukuran[$i], $quantity[$i], $harga[$i], $sub);
        $stmt_detail->execute();
    }

    // Hapus dari keranjang
    $query_hapus = "DELETE FROM keranjang WHERE id_keranjang = ? AND id_user = ?";
    $stmt_hapus = $koneksi->prepare($query_hapus);

    foreach ($id_keranjang as $idk) {
        $stmt_hapus->bind_param("ii", $idk, $id_user);
        $stmt_hapus->execute();
    }

    $koneksi->commit();

    // Hapus sesi
    unset($_SESSION['checkout_items']);

    echo "<script>alert('Transaction successful! Please upload proof.'); window.location.href='upload_bukti.php?id_transaksi=$id_transaksi';</script>";
    exit;
} catch (Exception $e) {
    $koneksi->rollback();
    echo "<script>alert('Failed to save transaction: " . $e->getMessage() . "'); window.location.href='checkout_multiple.php';</script>";
    exit;
}
