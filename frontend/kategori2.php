<?php
include '../backend/koneksi.php';


$sql = "SELECT produk.id_produk, produk.nama_produk, produk.gambar, produk.harga, kategori.nama_kategori 
        FROM produk 
        JOIN kategori ON produk.id_kategori = kategori.id_kategori 
        WHERE LOWER(kategori.nama_kategori) = 'basketball shoes'";

$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basketball Shoes - Nike</title>
    <link rel="stylesheet" href="css/kategori.css">
</head>

<body>
    <?php include "header.php"; ?>
    <div class="product-page">
        <h2>Basketball Shoes</h2>

        <section class="video-section">
            <iframe width="100%" height="550" src="https://www.youtube.com/embed/ttCmbb-jb_U?si=yL-Af2d94QZ69JiZ"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </section>

        <section class="highlight">
            <p class="sub-text">A’One</p>
            <h1>FOR THE REAL ONES</h1>
            <p class="description">Ready to go to work? A’ja Wilson’s first signature collection is here.</p>
        </section>

        <div class="product-grid">
            <?php if ($result && $result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="product-card">
                        <a href="detail_produk.php?id=<?= $row['id_produk']; ?>">
                            <img src="../images/<?= $row['gambar']; ?>" alt="<?= $row['nama_produk']; ?>" onerror="this.onerror=null;this.src='../images/default.jpg';">
                            <div class="product-info">
                                <h3><?= $row['nama_produk']; ?></h3>
                                <p class="category"><?= $row['nama_kategori']; ?></p>
                                <p class="price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>Tidak ada produk untuk kategori Basketball Shoes.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>