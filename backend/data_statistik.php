<?php
include 'koneksi.php';

// Total Pengguna
$q1 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM user");
if (!$q1) die("Query Total Pengguna Error: " . mysqli_error($koneksi));
$pengguna = mysqli_fetch_assoc($q1);

// Total Pesanan
$q2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi");
if (!$q2) die("Query Total Pesanan Error: " . mysqli_error($koneksi));
$pesanan = mysqli_fetch_assoc($q2);

// Total Pendapatan
$q3 = mysqli_query($koneksi, "SELECT SUM(total) as total FROM transaksi");
if (!$q3) die("Query Total Pendapatan Error: " . mysqli_error($koneksi));
$pendapatan = mysqli_fetch_assoc($q3);

// Total Produk
$q4 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk");
if (!$q4) die("Query Total Produk Error: " . mysqli_error($koneksi));
$produk = mysqli_fetch_assoc($q4);
?>
