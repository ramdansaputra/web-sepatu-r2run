<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $koneksi->begin_transaction();
    try {
        /* 1️⃣ hapus detail_transaksi yang terkait user */
        $sql = "
            DELETE dt
            FROM detail_transaksi dt
            JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
            WHERE t.id_user = ?
        ";
        $del = $koneksi->prepare($sql);
        $del->bind_param('i', $id);
        $del->execute();
        $del->close();

        /* 2️⃣ hapus keranjang (jika ada) */
        $del = $koneksi->prepare("DELETE FROM keranjang WHERE id_user = ?");
        $del->bind_param('i', $id);
        $del->execute();
        $del->close();

        /* 3️⃣ hapus transaksi */
        $del = $koneksi->prepare("DELETE FROM transaksi WHERE id_user = ?");
        $del->bind_param('i', $id);
        $del->execute();
        $del->close();

        /* 4️⃣ terakhir: hapus user */
        $del = $koneksi->prepare("DELETE FROM user WHERE id = ?");
        $del->bind_param('i', $id);
        $del->execute();
        $del->close();

        $koneksi->commit();
        header("Location: data_akun.php?hapus=sukses");
        exit;
    } catch (Exception $e) {
        $koneksi->rollback();
        echo "Gagal hapus: " . $e->getMessage();
    }
} else {
    echo "ID user tidak ditemukan.";
}
