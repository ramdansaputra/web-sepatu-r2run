<?php
include '../backend/koneksi.php';


$sql = "SELECT produk.id_produk, produk.nama_produk, produk.gambar, produk.harga, kategori.nama_kategori 
        FROM produk 
        JOIN kategori ON produk.id_kategori = kategori.id_kategori 
        WHERE LOWER(kategori.nama_kategori) = 'running shoes'";

$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Running Shoes - Nike</title>
    <link rel="stylesheet" href="css/kategori.css">
</head>

<body>
    <?php include "header.php";?>
    <div class="product-page fade-in">
        <h2 class="page-title">Running Shoes</h2>

        <section class="video-section fade-in">
            <iframe width="100%" height="550" src="https://www.youtube.com/embed/Rg7kGWCltDs?si=-aJcUKOz3UfyKj67" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </section>

        <section class="highlight fade-in">
            <p class="sub-text">A’One</p>
            <h1>FOR THE REAL ONES</h1>
            <p class="description">Ready to go to work? A’ja Wilson’s first signature collection is here.</p>
        </section>

        <div class="product-grid fade-in">
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
                <p>There are no products for the Running Shoes category.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Smooth Scroll Animation -->
    <script>
        const fadeElements = document.querySelectorAll('.fade-in');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.1
        });

        fadeElements.forEach(el => observer.observe(el));
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>