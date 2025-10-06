<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id_produk = $_GET['id'];

// Ambil data produk
$sql_produk = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
$result_produk = mysqli_query($koneksi, $sql_produk);

if (mysqli_num_rows($result_produk) == 0) {
    echo "Produk tidak ditemukan!";
    exit;
}

$produk = mysqli_fetch_assoc($result_produk);

// Ambil semua ukuran
$result_ukuran = mysqli_query($koneksi, "SELECT * FROM ukuran");

// Ambil ukuran yang sudah dipilih produk dari kolom produk.ukuran (dipisah dengan koma)
$ukuran_terpilih = explode(',', $produk['ukuran']);

// Ambil semua kategori
$result_kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Produk</title>
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

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-container label {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 10px;
            font-weight: normal;
        }

        form input[type="file"] {
            margin-bottom: 20px;
        }

        form input[type="submit"] {
            background-color: #111;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #333;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #111;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Product</h2>

        <form action="proses_edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_produk" value="<?= htmlspecialchars($produk['id_produk']); ?>">

            <label>Product Name</label>
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']); ?>" required>

            <label>Category</label>
            <select name="id_kategori" required>
                <option value="">-- Select Category --</option>
                <?php while ($row = mysqli_fetch_assoc($result_kategori)) : ?>
                    <option value="<?= $row['id_kategori'] ?>" <?= ($row['id_kategori'] == $produk['id_kategori']) ? 'selected' : '' ?>>
                        <?= $row['nama_kategori'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Description</label>
            <textarea name="deskripsi" required><?= htmlspecialchars($produk['deskripsi']); ?></textarea>

            <label>Size</label>
            <div class="checkbox-container">
                <?php mysqli_data_seek($result_ukuran, 0); ?>
                <?php while ($row = mysqli_fetch_assoc($result_ukuran)) : ?>
                    <label>
                        <input type="checkbox" name="ukuran[]" value="<?= $row['ukuran'] ?>" <?= in_array($row['ukuran'], $ukuran_terpilih) ? 'checked' : '' ?>>
                        <?= $row['ukuran'] ?>
                    </label>
                <?php endwhile; ?>
            </div>

            <label>Price</label>
            <input type="number" name="harga" value="<?= htmlspecialchars($produk['harga']); ?>" required>

            <label>Stock</label>
            <input type="number" name="stok" value="<?= htmlspecialchars($produk['stok']); ?>" min="0" required>

            <label>Change Image</label>
            <input type="file" name="gambar" accept="image/*">

            <input type="submit" value="Update">
        </form>

        <div class="back-link">
            <p><a href="produk.php">← Back to Product List</a></p>
        </div>
    </div>

</body>

</html>