<?php
session_start();
include '../backend/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM user WHERE username='$username'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if ($data) {
    if (password_verify($password, $data['password'])) {
        // Simpan data ke session setelah login berhasil
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['id_user'] = $data['id']; // Sesuaikan dengan nama kolom ID di tabel kamu
        $_SESSION['role'] = $data['role'];

        // Redirect sesuai role
        if ($data['role'] == 'admin') {
            header("Location: ../backend/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "Password salah. <a href='login.php'>Coba lagi</a>";
    }
} else {
    echo "Username tidak ditemukan. <a href='login.php'>Coba lagi</a>";
}
