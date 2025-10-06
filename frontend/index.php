<?php
session_start();
include 'header.php';
include '../backend/koneksi.php';

// Cek login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'customer') {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Ambil kategori
$query_kategori = "SELECT * FROM kategori";
$result_kategori = mysqli_query($koneksi, $query_kategori);

// Ambil produk trending (3 produk terbaru)
$query_produk = "SELECT produk.*, kategori.nama_kategori 
                 FROM produk 
                 JOIN kategori ON produk.id_kategori = kategori.id_kategori 
                 ORDER BY produk.tanggal_ditambahkan DESC 
                 LIMIT 3";
$result_produk = mysqli_query($koneksi, $query_produk);
?>

<link rel="stylesheet" href="css/index.css">

<div class="hero">
    <div class="hero-content">
        <h1>Find Your Perfect Run</h1>
        <p>Discover the best shoes for your style and performance.</p>
        <a href="produk.php" class="btn">Shop Now</a>
    </div>
    
    <div class="hero-image">
        <img src="../images/vomero_no_bg.png" alt="">
    </div>
</div>

<!-- Shop by Category -->
<section class="categories">
    <h2>Shop by Categories</h2>
    <div class="category-list">
        <div class="category-item">
            <a href="kategori1.php"><img src="../images/runningshoes.jpg" alt="Running Shoes"></a>
            <p>Running Shoes</p>
        </div>
        <div class="category-item">
            <a href="kategori2.php"><img src="../images/basketball_shoes.jpg" alt="Basketball Shoes"></a>
            <p>Basketball Shoes</p>
        </div>
        <div class="category-item">
            <a href="kategori3.php"><img src="../images/football_shoes.jpg" alt="Football Shoes"></a>
            <p>Football Shoes</p>
        </div>
    </div>
</section>

<!-- Trending Products -->
<section class="trending">
    <h2>Trending Products</h2>
    <div class="products">
        <?php while ($produk = mysqli_fetch_assoc($result_produk)) { ?>
            <div class="product">
                <a href="detail_produk.php?id=<?php echo $produk['id_produk']; ?>">
                    <img src="../images/<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['nama_produk']; ?>">
                </a>
                <p class="title"><?php echo $produk['nama_produk']; ?></p>
                <p class="category"><?php echo $produk['nama_kategori']; ?></p>
                <p class="price">Rp<?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
            </div>
        <?php } ?>
    </div>
</section>

<?php include 'footer.php'; ?>