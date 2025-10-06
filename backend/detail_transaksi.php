<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: transaksi.php");
    exit;
}

$id_transaksi = intval($_GET['id']);

// Fetch transaction data
$sql_transaksi = "SELECT t.*, u.username FROM transaksi t 
                  JOIN user u ON t.id_user = u.id
                  WHERE t.id_transaksi = $id_transaksi";
$query_transaksi = mysqli_query($koneksi, $sql_transaksi);
$transaksi = mysqli_fetch_assoc($query_transaksi);

if (!$transaksi) {
    echo "Transaction not found.";
    exit;
}

// Fetch transaction details
$sql_detail = "SELECT d.*, p.nama_produk, u.ukuran 
               FROM detail_transaksi d
               JOIN produk p ON d.id_produk = p.id_produk
               JOIN ukuran u ON d.id_ukuran = u.id_ukuran
               WHERE d.id_transaksi = $id_transaksi";
$query_detail = mysqli_query($koneksi, $sql_detail);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transaction Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="home.css" />
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
            width: 1200px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header h2 {
            margin: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .table-container {
            padding: 20px;
            margin-top: 30px;
        }

        .info-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        p {
            margin: 10px 0;
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 20px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            background-color: rgb(0, 0, 0);
            color: white;
            font-weight: 400;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a.back-link {
            display: block;
            width: 200px;
            text-align: center;
            margin: 20px auto;
            padding: 10px 0;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a.back-link:hover {
            background-color: #219150;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>R2RUN</h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="produk.php"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="data_akun.php"><i class="fas fa-users"></i> Customers</a></li>
                <li class="active"><a href="transaksi.php"><i class="fa-solid fa-clipboard"></i> Transactions</a></li>
                <li><a href="verifikasi.php"><i class="fa-regular fa-square-check"></i> Verification</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <h2>Transaction Details</h2>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="../images/avatar.png" alt="" />
                    <span>Admin</span>
                </div>
            </div>
        </div>

        <div class="table-container">
            <!-- Customer Info -->
            <div class="info-container">
                <p><strong>Customer Name:</strong> <?= htmlspecialchars($transaksi['username']) ?></p>
                <p><strong>Transaction Date:</strong> <?= htmlspecialchars($transaksi['tanggal_transaksi']) ?></p>
                <p><strong>Payment Method:</strong> <?= htmlspecialchars($transaksi['metode_pembayaran']) ?></p>
                <p><strong>Shipping Address:</strong> <?= htmlspecialchars($transaksi['alamat_pengiriman']) ?></p>
                <?php if ($transaksi['bukti_pembayaran']) : ?>
                    <p><strong>Proof of Transfer:</strong><br>
                        <img src="../bukti_transfer/<?= $transaksi['bukti_pembayaran']; ?>" width="300" alt="Bukti Transfer">
                    </p>
                <?php else : ?>
                    <p><strong>Bukti Transfer:</strong> Belum Upload</p>
                <?php endif; ?>
            </div>

            <!-- Transaction Details Table -->
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>

                <?php while ($detail = mysqli_fetch_assoc($query_detail)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['nama_produk']) ?></td>
                        <td><?= htmlspecialchars($detail['ukuran']) ?></td>
                        <td><?= htmlspecialchars($detail['jumlah']) ?></td>
                        <td>Rp<?= number_format($detail['harga_satuan'], 0, ',', '.') ?></td>
                        <td>Rp<?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <a class="back-link" href="transaksi.php">Back to Transactions</a>
        </div>
    </div>
</body>

</html>