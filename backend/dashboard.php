<?php
// session_start();

// if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
//     header('Location: ../frontend/login.php');
//     exit;
// }


include 'data_statistik.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="home.css" />
</head>
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

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>R2RUN</h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li>
                    <a href="produk.php"><i class="fas fa-box"></i> Products</a>
                </li>
                <li>
                    <a href="data_akun.php"><i class="fas fa-users"></i> Customers</a>
                </li>
                <li>
                    <a href="transaksi.php"><i class="fa-solid fa-clipboard"></i> Transactions</a>
                </li>
                <li><a href="verifikasi.php"><i class="fa-regular fa-square-check"></i> Verification</a></li>
                <li>
                    <a href="../frontend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <h2>Dashboard</h2>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="../images/avatar.png" alt="" />
                    <span>Admin</span>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <h1 class="page-title">Welcome, Admin</h1>

            <!-- Card Stats -->
            <div class="card-container">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Total Users</span>
                        <div class="card-icon users">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="card-value">
                        <?php echo number_format($pengguna['total']); ?>
                    </div>
                    <div class="card-footer">+12% from last month</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Total Transactions</span>
                        <div class="card-icon orders">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="card-value">
                        <?php echo number_format($pesanan['total']); ?>
                    </div>
                    <div class="card-footer">+5% from last month</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Total Revenue</span>
                        <div class="card-icon revenue">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="card-value">
                        Rp.<?php echo number_format($pendapatan['total'] ?? 0, 0, ',', '.'); ?>
                    </div>
                    <div class="card-footer">+8% from last month</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Total Products</span>
                        <div class="card-icon products">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                    <div class="card-value">
                        <?php echo number_format($produk['total']); ?>
                    </div>
                    <div class="card-footer">Active stock currently</div>
                </div>
            </div>

            <div class="table-container" style="margin-top: 30px;">
                <h2>Recent Transactions</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID Transaction</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT t.*, u.username AS nama 
                                FROM transaksi t
                                LEFT JOIN user u ON t.id_user = u.id
                                ORDER BY t.tanggal_transaksi DESC
                                LIMIT 10";
                        $query = mysqli_query($koneksi, $sql);
                        if ($query && mysqli_num_rows($query) > 0) {
                            while ($transaksi = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>" . $transaksi['id_transaksi'] . "</td>";
                                echo "<td>" . htmlspecialchars($transaksi['nama']) . "</td>";
                                echo "<td>" . $transaksi['tanggal_transaksi'] . "</td>";
                                echo "<td>Rp" . number_format($transaksi['total'], 0, ',', '.') . "</td>";
                                echo "<td>" . $transaksi['status'] . "</td>";
                                echo "<td>
                                        <a class='btn btn-detail' href='detail_transaksi.php?id=" . $transaksi['id_transaksi'] . "'>Detail</a>
                                        <a class='btn btn-edit' href='edit_transaksi.php?id=" . $transaksi['id_transaksi'] . "'>Edit</a>
                                        <a class='btn btn-delete' href='hapus_transaksi.php?id=" . $transaksi['id_transaksi'] . "' onclick='return confirm(\"Delete this transaction?\")'>Delete</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;'>No transactions found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Admin dashboard loaded');
        });
    </script>
</body>

</html>