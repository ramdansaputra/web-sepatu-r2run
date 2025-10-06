<?php
include 'koneksi.php';

// Ambil data dari form
$id_produk     = mysqli_real_escape_string($koneksi, $_POST['id_produk']);
$nama_produk   = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
$id_kategori   = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
$deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
$harga         = mysqli_real_escape_string($koneksi, $_POST['harga']);
$stok          = mysqli_real_escape_string($koneksi, $_POST['stok']); // Tambahan: ambil stok

// Ambil ukuran yang dipilih
$ukuran_array = isset($_POST['ukuran']) ? $_POST['ukuran'] : [];
$ukuran = implode(',', $ukuran_array);

// Ambil data produk lama
$query = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
$result = mysqli_query($koneksi, $query);
$produk_lama = mysqli_fetch_assoc($result);

// Cek apakah user upload gambar baru
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $folder_tujuan = "../images/" . $nama_file;

    // Upload gambar baru
    if (move_uploaded_file($tmp_file, $folder_tujuan)) {
        $gambar = $nama_file;

        // Hapus gambar lama jika bukan default
        if ($produk_lama['gambar'] != 'default.png' && file_exists("../images/" . $produk_lama['gambar'])) {
            unlink("../images/" . $produk_lama['gambar']);
        }
    } else {
        echo "Gagal mengupload gambar baru.";
        exit;
    }
} else {
    // Jika tidak upload gambar baru, pakai gambar lama
    $gambar = $produk_lama['gambar'];
}

// Update produk
$sql_update = "UPDATE produk SET 
    nama_produk = '$nama_produk',
    id_kategori = '$id_kategori',
    deskripsi = '$deskripsi',
    harga = '$harga',
    stok = '$stok',  -- Tambahan: update stok
    gambar = '$gambar',
    ukuran = '$ukuran'
    WHERE id_produk = '$id_produk'";

if (mysqli_query($koneksi, $sql_update)) {
    header("Location: produk.php?pesan=berhasilupdate");
    exit;
} else {
    echo "Gagal mengupdate produk: " . mysqli_error($koneksi);
}
