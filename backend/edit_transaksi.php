<?php
include "koneksi.php";

// Validasi ID transaksi
if (!isset($_GET['id'])) {
    header("Location: transaksi.php");
    exit;
}

$id_transaksi = intval($_GET['id']);

// Ambil data transaksi
$sql = "SELECT * FROM transaksi WHERE id_transaksi = $id_transaksi";
$query = mysqli_query($koneksi, $sql);
$transaksi = mysqli_fetch_assoc($query);

if (!$transaksi) {
    echo "Transaksi tidak ditemukan.";
    exit;
}

// Proses update status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    $update = "UPDATE transaksi SET status = ? WHERE id_transaksi = ?";
    $stmt = $koneksi->prepare($update);
    $stmt->bind_param('si', $status, $id_transaksi);

    if ($stmt->execute()) {
        echo "<script>alert('Status successfully updated'); window.location.href='transaksi.php';</script>";
    } else {
        echo "Gagal update status: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status Transaksi</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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


        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            background-color: #111;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #333;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #219150;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 style="color: white;">R2RUN</h2>
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
                <h2>Edit Transaction Status ID <?= $id_transaksi ?></h2>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="../images/avatar.png" alt="">
                    <span>Admin</span>
                </div>
            </div>
        </div>

        <div class="form-container">
            <form method="POST">
                <label for="status">Transaction Status:</label>
                <select name="status" class="form-control">
                    <option value="Pending" <?= $transaksi['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Shipped" <?= $transaksi['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="Completed" <?= $transaksi['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>


                <button type="submit">Update Status</button>
            </form>

            <a href="transaksi.php" class="back-link">Back to Transaction List</a>
        </div>
    </div>

</body>

</html>