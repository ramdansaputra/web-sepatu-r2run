<?php
session_start();
header('Content-Type: application/json'); // agar return berupa JSON
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access.'
    ]);
    exit;
}

$id_user      = $_SESSION['id_user'];
$id_keranjang = isset($_GET['id_keranjang']) ? (int)$_GET['id_keranjang'] : 0;
$quantity     = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 0;

if ($id_keranjang <= 0 || $quantity < 1) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid data submitted.'
    ]);
    exit;
}

// Ambil id_produk dari keranjang
$stmt = $koneksi->prepare("SELECT id_produk FROM keranjang WHERE id_keranjang = ? AND id_user = ?");
$stmt->bind_param('ii', $id_keranjang, $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak ditemukan.'
    ]);
    exit;
}

$id_produk = $result->fetch_assoc()['id_produk'];

// Ambil stok dari produk
$stmt = $koneksi->prepare("SELECT stok FROM produk WHERE id_produk = ?");
$stmt->bind_param('i', $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Product not found.'
    ]);
    exit;
}

$stok = $result->fetch_assoc()['stok'];

if ($quantity > $stok) {
    echo json_encode([
        'success' => false,
        'message' => 'Quantity exceeds available stock.'
    ]);
    exit;
}

// Update quantity ke keranjang
$stmt = $koneksi->prepare("UPDATE keranjang SET quantity = ? WHERE id_keranjang = ? AND id_user = ?");
$stmt->bind_param('iii', $quantity, $id_keranjang, $id_user);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Quantity successfully updated.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update quantity.'
    ]);
}
