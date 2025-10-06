<?php
session_start();
include '../backend/koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];

// Set role default untuk user yang mendaftar
$role = 'customer'; // Role diset otomatis

// Cek apakah username atau email sudah terdaftar
$cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' OR email='$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "Username atau Email sudah digunakan. <a href='register.php'>Coba lagi</a>";
    exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query insert data menggunakan prepared statement
$stmt = $koneksi->prepare("INSERT INTO user (username, password, email, role, alamat) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $username, $hashed_password, $email, $role, $alamat);

if ($stmt->execute()) {
    // Registrasi berhasil, redirect ke halaman login
    header("Location: login.php");
    exit;
} else {
    echo "Registrasi gagal: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
