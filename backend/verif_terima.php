<?php
include "koneksi.php";

$id = intval($_GET['id'] ?? 0);
if ($id) {
    mysqli_query($koneksi, "UPDATE transaksi SET status = 'Shipped' WHERE id_transaksi = $id");
}
header("Location: verifikasi.php");
exit;
