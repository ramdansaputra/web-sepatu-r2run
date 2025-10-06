<?php
include "koneksi.php";

// Ambil data transaksi dan nama customer
$sql = "SELECT t.*, u.username AS nama 
        FROM transaksi t
        LEFT JOIN user u ON t.id_user = u.id
        WHERE t.status IN ('Shipped', 'Completed') 
        ORDER BY t.tanggal_transaksi DESC";


$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query error: " . mysqli_error($koneksi) . "<br>SQL: " . $sql);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="home.css">
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
            width: 1200px;
            /* Lebar tetap */

        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            /* Tambahin jarak bawah */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header h2 {
            margin: 0;
            /* hilangkan margin bawaan h2 */
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

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
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

        td a {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 3px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85em;
            transition: all 0.3s ease;
        }

        td a:first-child {
            background-color: #27ae60;
            color: white;
        }

        td a:nth-child(2) {
            background-color: rgb(0, 98, 255);
            color: white;
        }

        td a:last-child {
            background-color: #e74c3c;
            color: white;
        }

        td a:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {

            th,
            td {
                padding: 8px 12px;
            }
        }

        .empty-data {
            text-align: center;
            color: #999;
            padding: 20px;
        }
    </style>
</head>

<body>
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

                <li><a href="../frontend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <h2>Transaction Data</h2>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="../images/avatar.png" alt="">
                    <span>Admin</span>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer Name</th>
                    <th>Transaction Date</th>
                    <th>Subotal</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php if (mysqli_num_rows($query) > 0) : ?>
                    <?php while ($transaksi = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                            <td><?= $transaksi['id_transaksi']; ?></td>
                            <td><?= htmlspecialchars($transaksi['nama']); ?></td>
                            <td><?= $transaksi['tanggal_transaksi']; ?></td>
                            <td>Rp<?= number_format($transaksi['total'], 0, ',', '.'); ?></td>
                            <td><?= $transaksi['status'] === 'Pending' ? 'Pending' : $transaksi['status']; ?></td>
                            <td>
                                <a href="detail_transaksi.php?id=<?= $transaksi['id_transaksi']; ?>">Detail</a>
                                <a href="edit_transaksi.php?id=<?= $transaksi['id_transaksi']; ?>">Edit</a>
                                <a href="hapus_transaksi.php?id=<?= $transaksi['id_transaksi']; ?>" onclick="return confirm('Delete this transaction?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="empty-data">No transaction data.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>

</html>