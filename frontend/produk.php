<?php
include '../backend/koneksi.php';

$query = "SELECT produk.*, kategori.nama_kategori 
          FROM produk 
          LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>All Product</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/produk.css">
    <link rel="stylesheet" href="css/header.css">


</head>

<body>
    <?php include 'header.php'; ?>

    <h2>All Product</h2>

    <div class="product-grid">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <a href="detail_produk.php?id=<?php echo $row['id_produk']; ?>" class="product-card">
                <img src="../images/<?= $row['gambar']; ?>" alt="<?= $row['nama_produk']; ?>" onerror="this.onerror=null;this.src='../images/default.jpg';">
                <h3><?php echo htmlspecialchars($row['nama_produk']); ?></h3>
                <p><?php echo htmlspecialchars($row['nama_kategori']) ?? 'Tanpa Kategori'; ?></p>
                <p class="price">Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
            </a>
        <?php endwhile; ?>
    </div>
</body>
<?php include 'footer.php'; ?>

</html>