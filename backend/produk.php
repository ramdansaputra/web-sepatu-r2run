<?php
// session_start();
include 'koneksi.php';

// Ambil data produk + kategori
$query = "SELECT produk.*, kategori.nama_kategori 
          FROM produk 
          JOIN kategori ON produk.id_kategori = kategori.id_kategori
          ORDER BY produk.tanggal_ditambahkan DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="home.css">
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
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

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 98%;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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

        .btn-action {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85em;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-edit {
            background-color: rgb(0, 85, 255);
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-tambah {
            display: inline-block;
            padding: 10px 15px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px;
            transition: all 0.3s ease;
        }

        .btn-tambah:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        td:nth-child(4) {
            max-width: 200px;
            word-break: break-word;
        }

        @media (max-width: 768px) {

            th,
            td {
                padding: 8px 12px;
            }

            .btn-action {
                flex-direction: column;
            }
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
                <li class="active"><a href="produk.php"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="data_akun.php"><i class="fas fa-users"></i> Customers</a></li>
                <li><a href="transaksi.php"><i class="fa-solid fa-clipboard"></i> Transactions</a></li>
                <li><a href="verifikasi.php"><i class="fa-regular fa-square-check"></i> Verification</a></li>
                <li><a href="../frontend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-left">
                <h2>Product Data</h2>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="../images/avatar.png" alt="">
                    <span>Admin</span>
                </div>
            </div>
        </div>

        <div class="table-container">
            <a href="tambah.php" class="btn-tambah">+ Add Product</a>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th> <!-- Kolom Stok -->
                    <th>Size</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) :
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                        <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                        <td>
                            <?= strlen($row['deskripsi']) > 50 ? substr(htmlspecialchars($row['deskripsi']), 0, 50) . '...' : htmlspecialchars($row['deskripsi']); ?>
                        </td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td style="color: <?= $row['stok'] < 5 ? 'red' : 'black'; ?>;">
                            <?= $row['stok']; ?>
                        </td>
                        <td><?= htmlspecialchars($row['ukuran']); ?></td>
                        <td>
                            <?php if ($row['gambar']) : ?>
                                <img src="../images/<?= $row['gambar']; ?>" width="80">
                            <?php else : ?>
                                (No Image)
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-action">
                                <a href="edit.php?id=<?= $row['id_produk']; ?>" class="btn btn-edit">Edit</a>
                                <a href="hapus.php?id=<?= $row['id_produk']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Admin dashboard loaded');
        });
    </script>
</body>

</html>