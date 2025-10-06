<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    header("location:dashboard.php?hapus=gagal");
    exit;
}

$id = $_GET['id'];
// Escape id supaya aman dari SQL Injection (asumsi id berupa angka)
$id = mysqli_real_escape_string($koneksi, $id);

$sql = "DELETE FROM produk WHERE id_produk = '$id'";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("location:produk.php?hapus=berhasil");
} else {
    header("location:dashboard.php?hapus=gagal");
}
exit;
