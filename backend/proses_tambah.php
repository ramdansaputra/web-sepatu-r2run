<?php
include "koneksi.php";

// Ambil data dari form
$nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
$id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
$deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
$harga       = mysqli_real_escape_string($koneksi, $_POST['harga']);
$stok        = mysqli_real_escape_string($koneksi, $_POST['stok']); // Tambahkan stok

// Cek jika ukuran dipilih
$ukuran_array = isset($_POST['ukuran']) ? $_POST['ukuran'] : [];
$ukuran = implode(',', $ukuran_array);

// Cek jika file gambar diupload
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $nama_file     = $_FILES['gambar']['name'];
    $tmp_file      = $_FILES['gambar']['tmp_name'];
    $folder_tujuan = "../images/" . $nama_file;

    // Pindahkan file
    if (move_uploaded_file($tmp_file, $folder_tujuan)) {
        $gambar = $nama_file;
    } else {
        echo "Upload gambar gagal.";
        exit;
    }
} else {
    $gambar = "default.png"; // gambar default jika tidak diupload
}

// Insert ke database
$sql = "INSERT INTO produk (id_kategori, nama_produk, deskripsi, harga, stok, gambar, ukuran, tanggal_ditambahkan) 
        VALUES ('$id_kategori', '$nama_produk', '$deskripsi', '$harga', '$stok', '$gambar', '$ukuran', NOW())";

if (mysqli_query($koneksi, $sql)) {
    header("Location: produk.php?pesan=berhasiltambah");
    exit;
} else {
    echo "Gagal menambahkan produk: " . mysqli_error($koneksi);
}
