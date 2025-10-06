<?php

include "koneksi.php";

$sql = "
    SELECT  t.*,
            u.username AS nama
    FROM    transaksi t
    LEFT JOIN user u ON t.id_user = u.id
    WHERE   t.status = 'Pending'
    ORDER BY t.tanggal_transaksi DESC
";
$query = mysqli_query($koneksi, $sql);
if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Verification</title>

    <!-- Font Awesome + stylesheet global (home.css) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="home.css">

    <!-- CSS kecil tambahan (sama dgn transaksi.php) -->
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background: #f8f9fa;
            min-height: 100vh;
            width: 1200px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .header h2 {
            margin: 0
        }

        .user-profile {
            display: flex;
            align-items: center
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden
        }

        th,
        td {
            padding: 12px 20px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0
        }

        th {
            background: #000;
            color: #fff;
            font-weight: 400;
            text-transform: uppercase;
            font-size: .9em
        }

        tr:hover {
            background: #f5f5f5
        }

        tr:nth-child(even) {
            background: #f9f9f9
        }

        td a {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 3px;
            border-radius: 4px;
            text-decoration: none;
            font-size: .85em;
            transition: .3s
        }

        .btn-accept {
            background: #27ae60;
            color: #fff
        }

        .btn-reject {
            background: #e74c3c;
            color: #fff
        }

        td a:hover {
            opacity: .9;
            transform: translateY(-2px)
        }

        .empty-data {
            text-align: center;
            color: #999;
            padding: 20px
        }
    </style>
</head>

<body>
    <!-- ========== SIDEBAR (copy dari transaksi.php) ========== -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>R2RUN</h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="produk.php"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="data_akun.php"><i class="fas fa-users"></i> Customers</a></li>
                <li><a href="transaksi.php"><i class="fa-solid fa-clipboard"></i> Transactions</a></li>
                <li class="active"><a href="verifikasi.php"><i class="fa-regular fa-square-check"></i> Verification</a></li>
                <li><a href="../frontend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- ========== MAIN CONTENT ========== -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h2>Transaction Verification</h2>
            <div class="user-profile">
                <img src="../images/avatar.png" alt="">
                <span>Admin</span>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Subtotal</th>
                    <th>Proof of Transfer</th>
                    <th>Action</th>
                </tr>

                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= $row['id_transaksi']; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= $row['tanggal_transaksi']; ?></td>
                            <td>Rp<?= number_format($row['total'], 0, ',', '.'); ?></td>
                            <!-- Kolom bukti pembayaran -->
                            <td>
                                <?php if (!empty($row['bukti_pembayaran'])): ?>
                                    <a href="../bukti_transfer/<?= urlencode($row['bukti_pembayaran']); ?>" target="_blank">Look</a>
                                <?php else: ?>
                                    <span style="color:#999;">-</span>
                                <?php endif; ?>
                            </td>
                            <!-- Tombol aksi -->
                            <td>
                                <a class="btn-accept" href="verif_terima.php?id=<?= $row['id_transaksi']; ?>"
                                    onclick="return confirm('Accept transactions #<?= $row['id_transaksi']; ?>?')">Accept</a>

                                <a class="btn-reject" href="verif_tolak.php?id=<?= $row['id_transaksi']; ?>"
                                    onclick="return confirm('Reject transaction #<?= $row['id_transaksi']; ?>?')">Reject</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-data">No transactions waiting for verification.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>

</html>
