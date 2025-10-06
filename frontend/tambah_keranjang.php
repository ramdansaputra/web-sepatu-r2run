<?php
/* ----------- tambah_keranjang.php ------------ */
session_start();
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id_user   = (int) $_SESSION['id_user'];
$id_produk = (int) ($_POST['product_id']   ?? 0);
$ukuranTxt = trim($_POST['selected_size'] ?? '');

/* validasi ukuran */
if ($ukuranTxt === '') {
    header("Location: detail_produk.php?id=$id_produk&error=ukuran");
    exit;
}

/* ambil id_ukuran */
$stmt = $koneksi->prepare("SELECT id_ukuran FROM ukuran WHERE ukuran = ?");
$stmt->bind_param('s', $ukuranTxt);
$stmt->execute();
$res = $stmt->get_result();
if (!$res->num_rows) {
    header("Location: detail_produk.php?id=$id_produk&error=ukuran");
    exit;
}
$id_ukuran = (int) $res->fetch_assoc()['id_ukuran'];
$stmt->close();

/* cek stok produk */
$stmt = $koneksi->prepare("SELECT stok FROM produk WHERE id_produk = ?");
$stmt->bind_param('i', $id_produk);
$stmt->execute();
$res  = $stmt->get_result();
if (!$res->num_rows) {
    exit('Produk tidak ditemukan.');
}
$stok = (int) $res->fetch_assoc()['stok'];
$stmt->close();

if ($stok <= 0) {
    header("Location: detail_produk.php?id=$id_produk&error=stok_habis");
    exit;
}

/* cek apakah kombinasi sudah ada di keranjang */
$stmt = $koneksi->prepare("
    SELECT id_keranjang, quantity
    FROM keranjang
    WHERE id_user = ? AND id_produk = ? AND id_ukuran = ?
    LIMIT 1
");
$stmt->bind_param('iii', $id_user, $id_produk, $id_ukuran);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows) {
    $stmt->bind_result($id_keranjang, $qty_now);
    $stmt->fetch();
    if ($qty_now + 1 > $stok) {
        header("Location: detail_produk.php?id=$id_produk&error=stok_kurang");
        exit;
    }
    $upd = $koneksi->prepare("
        UPDATE keranjang SET quantity = quantity + 1
        WHERE id_keranjang = ?
    ");
    $upd->bind_param('i', $id_keranjang);
    $upd->execute();
    $upd->close();
    $stmt->close();
} else {
    $stmt->close();
    $ins = $koneksi->prepare("
        INSERT INTO keranjang (id_user, id_produk, id_ukuran, quantity)
        VALUES (?, ?, ?, 1)
    ");
    $ins->bind_param('iii', $id_user, $id_produk, $id_ukuran);
    $ins->execute();
    $ins->close();
}

/* sukses: ke halaman keranjang */
header('Location: keranjang.php');
exit;
