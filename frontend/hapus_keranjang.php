<?php
session_start();
include '../backend/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

// Ambil ID keranjang dari URL
if (isset($_GET['id'])) {
    $id_keranjang = (int)$_GET['id'];
    $id_user = $_SESSION['id_user'];

    // Pastikan item yang dihapus memang milik user yang sedang login
    $query = "DELETE FROM keranjang WHERE id_keranjang = ? AND id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('ii', $id_keranjang, $id_user);

    if ($stmt->execute()) {
        // Berhasil dihapus
        header('Location: keranjang.php');
        exit;
    } else {
        echo "Gagal menghapus item dari keranjang.";
    }
} else {
    echo "ID item tidak ditemukan.";
}
