<?php
session_start();
include '../backend/koneksi.php';
include 'header.php';

$id_produk = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id_produk <= 0) exit('ID produk tidak valid.');

$stmt = $koneksi->prepare("
    SELECT p.*, k.nama_kategori
    FROM produk p
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    WHERE p.id_produk = ?
");
$stmt->bind_param('i', $id_produk);
$stmt->execute();
$res = $stmt->get_result();
if (!$res->num_rows) exit('Produk tidak ditemukan.');
$produk = $res->fetch_assoc();

$ukuran_set = $koneksi->query("SELECT * FROM ukuran ORDER BY ukuran ASC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= htmlspecialchars($produk['nama_produk']) ?></title>
    <link rel="stylesheet" href="css/detail_produk.css">
</head>

<body>

    <main class="product-page">
        <div class="image-container">
            <img src="../images/<?= htmlspecialchars($produk['gambar'] ?: 'default.jpg') ?>"
                alt="<?= htmlspecialchars($produk['nama_produk']) ?>"
                onerror="this.onerror=null;this.src='../images/default.jpg';">
        </div>

        <div class="details">
            <h2><?= htmlspecialchars($produk['nama_produk']) ?></h2>
            <p class="category"><?= htmlspecialchars($produk['nama_kategori']) ?></p>
            <p class="price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
            <p class="stok">Stock: <?= (int)$produk['stok'] ?> pcs</p>

            <!-- inline error -->
            <?php if (isset($_GET['error'])): ?>
                <?php
                $msg = [
                    'ukuran' => 'Please select a size first.',
                    'stok_habis' => 'This product is out of stock.',
                    'stok_kurang' => 'Insufficient stock to add quantity.'
                ][$_GET['error']] ?? '';
                if ($msg): ?>
                    <div class="error-message"><?= $msg ?></div>
                <?php endif; ?>
            <?php endif; ?>

            <form method="post" action="tambah_keranjang.php">
                <input type="hidden" name="product_id" value="<?= $produk['id_produk'] ?>">

                <div class="sizes">
                    <div class="size-options">
                        <?php while ($u = $ukuran_set->fetch_assoc()): ?>
                            <label class="size-box">
                                <!-- !hapus required supaya form tetap terkirim -->
                                <input type="radio" name="selected_size" value="<?= htmlspecialchars($u['ukuran']) ?>">
                                <span><?= htmlspecialchars($u['ukuran']) ?></span>
                            </label>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="buttons">
                    <button type="submit" class="add-to-bag">Add to Bag</button>
                </div>
            </form>

            <div class="description">
                <h4>Description:</h4>
                <p><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>
            </div>
        </div>
    </main>

    <?php if (isset($_GET['error'])): ?>
        <script>
            (function() {
                const msgMap = {
                    'ukuran': 'Please select a size first.',
                    'stok_habis': 'Sorry, this product is out of stock.',
                    'stok_kurang': 'There is not enough stock to add quantity.'
                };
                alert(msgMap[<?= json_encode($_GET['error']) ?>] || 'There is an error.');
            })();
        </script>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>

</html>