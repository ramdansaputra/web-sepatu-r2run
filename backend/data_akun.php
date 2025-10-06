<?php
// session_start();
// if (!isset($_SESSION['admin'])) {
//     header("Location: login.php");
//     exit;
// }

include 'koneksi.php';

// Ambil semua user
$query = "SELECT * FROM user ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

// Cek query
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            /* ubah dari 98% ke 100% */
            margin: 20px 0;
            /* hilangkan auto, kasih jarak atas bawah saja */
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            /* buat radius lebih rapih */
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
            background-color: rgb(0, 85, 255);
            color: white;
        }

        td a:last-child {
            background-color: #e74c3c;
            color: white;
        }

        td a:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        button a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        button {
            border: none;
            background: none;
            margin-left: 20px;
            cursor: pointer;
        }

        @media (max-width: 768px) {

            th,
            td {
                padding: 8px 12px;
            }
        }

        .btn-edit,
        .btn-hapus {
            display: inline-block;
            padding: 5px 12px;
            margin: 0 5px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.85em;
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
                <li class="active"><a href="data_akun.php"><i class="fas fa-users"></i> Customers</a></li>
                <li><a href="transaksi.php"><i class="fa-solid fa-clipboard"></i> Transactions</a></li>
                <li><a href="verifikasi.php"><i class="fa-regular fa-square-check"></i> Verification</a></li>
                <li><a href="../frontend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <h2>Customer Data</h2>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="../images/avatar.png" alt="">
                    <span>Admin</span>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'hapus_berhasil'): ?>
            <div class="alert-sukses">✅ User successfully deleted.</div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td>
                                <a href="hapus_user.php?id=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">No user accounts found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>