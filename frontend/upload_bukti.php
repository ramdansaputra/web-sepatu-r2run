<?php
session_start();
include '../backend/koneksi.php';
include 'header.php';

// Proses upload bukti
if (isset($_POST['upload'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $bukti = $_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];

    // Buat nama file unik
    $bukti_unik = date('YmdHis') . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $bukti);

    // Pastikan folder tujuan ada
    $folder = "../bukti_transfer/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Proses pindah file
    if (move_uploaded_file($tmp, $folder . $bukti_unik)) {
        // Update transaksi HANYA bukti pembayaran
        $query = "UPDATE transaksi SET bukti_pembayaran='$bukti_unik' WHERE id_transaksi=$id_transaksi";
        mysqli_query($koneksi, $query);

        echo "<script>alert('Proof of transfer successfully uploaded.'); window.location.href='order_history.php';</script>";
    } else {
        echo "<script>alert('Failed to upload file. Make sure the folder exists.'); window.location.href='order_history.php';</script>";
    }
    exit;
}

// Ambil ID transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Proof of Payment</title>
    <link rel="stylesheet" href="css/upload_bukti.css">
</head>

<body>
    <!-- Navbar di atas -->

    <div class="upload-wrapper">
        <div class="upload-container">
            <h2>Upload proof of payment</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
                <input type="file" name="bukti" required>
                <button type="submit" name="upload">Upload Proof</button>
            </form>
        </div>
    </div>
</body>


<?php include 'footer.php'; ?>

</html>