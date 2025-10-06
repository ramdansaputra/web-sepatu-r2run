<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id_transaksi = intval($_GET['id']);

    // Hapus detail transaksi dulu
    mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE id_transaksi = $id_transaksi");

    // Hapus transaksi
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = $id_transaksi");

    echo "<script>alert('Transaction successfully deleted.'); window.location.href='transaksi.php';</script>";
} else {
    header("Location: transaksi.php");
    exit;
}
