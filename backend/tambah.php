<?php
include 'koneksi.php';

// Fetch categories from database
$result_kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <style>
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

        .checkbox-group label {
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

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Add Product</h2>

        <form action="proses_tambah.php" method="post" enctype="multipart/form-data">
            <label>Product Name</label>
            <input type="text" name="nama_produk" required>

            <label>Category</label>
            <select name="id_kategori" required>
                <option value="">-- Select Category --</option>
                <?php while ($row = mysqli_fetch_assoc($result_kategori)) : ?>
                    <option value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
                <?php endwhile; ?>
            </select>

            <label>Description</label>
            <textarea name="deskripsi" required></textarea>

            <label>Price</label>
            <input type="number" name="harga" required>

            <label>Stock</label>
            <input type="number" name="stok" min="0" required>

            <label>Size</label>
            <div class="checkbox-group">
                <?php
                $result_ukuran = mysqli_query($koneksi, "SELECT * FROM ukuran");
                while ($row = mysqli_fetch_assoc($result_ukuran)) :
                ?>
                    <label>
                        <input type="checkbox" name="ukuran[]" value="<?= $row['ukuran'] ?>"> <?= $row['ukuran'] ?>
                    </label>
                <?php endwhile; ?>
            </div>

            <label>Image</label>
            <input type="file" name="gambar" accept="image/*" required>

            <input type="submit" value="Save">
        </form>
    </div>

</body>

</html>