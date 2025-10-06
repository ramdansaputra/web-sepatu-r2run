<?php
session_start();
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['selected_items'])) {
    echo "No products selected.";
    exit;
}

$selected_items = $_POST['selected_items'];
// Simpan ID keranjang yang dipilih ke sesi, atau bisa langsung proses ke halaman pembayaran
$_SESSION['checkout_items'] = $selected_items;

// Redirect ke halaman pembayaran
header("Location: checkout.php"); // Ganti sesuai alur checkout kamu
exit;
