<?php
session_start();
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user']) || !isset($_SESSION['checkout_items'])) {
    header("Location: keranjang.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$checkout_items = $_SESSION['checkout_items'];

$placeholders = implode(',', array_fill(0, count($checkout_items), '?'));
$types = str_repeat('i', count($checkout_items));

$params = [];
foreach ($checkout_items as $id) {
    $params[] = (int)$id;
}

$query = "SELECT k.id_keranjang, k.quantity, p.id_produk, p.nama_produk, p.gambar, p.harga, p.deskripsi, u.ukuran, u.id_ukuran
          FROM keranjang k
          JOIN produk p ON k.id_produk = p.id_produk
          JOIN ukuran u ON k.id_ukuran = u.id_ukuran
          WHERE k.id_user = ? AND k.id_keranjang IN ($placeholders)";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i$types", $id_user, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$produk_dipilih = [];
$total_harga = 0;

while ($row = $result->fetch_assoc()) {
    $produk_dipilih[] = $row;
    $total_harga += $row['harga'] * $row['quantity'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/checkout.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main class="checkout-container">
        <form action="proses_checkout.php" method="POST" class="form-section">
            <h3>Delivery</h3>
            <p>Enter your name and address:</p>
            <input type="text" placeholder="Name" name="name" required />
            <input type="text" placeholder="Address" name="address" required />
            <input type="email" placeholder="Email" name="email" required />

            <div class="payment-section">
                <h3 class="payment-title">How would you like to pay?</h3>
                <div class="payment-methods">
                    <!-- BRI -->
                    <label class="payment-card selected">
                        <input type="radio" name="payment" value="BRI" checked>
                        <div class="bank-logo">
                            <img src="../images/Logo Bank BRI (1).jpg" alt="BRI">
                        </div>
                        <div class="bank-info">
                            <span class="bank-name">BRI</span>
                            <span class="bank-desc">No. Rek: 1234 5678 9012 3456</span>
                        </div>
                        <div class="checkmark"></div>
                    </label>

                    <!-- BCA -->
                    <label class="payment-card">
                        <input type="radio" name="payment" value="BCA">
                        <div class="bank-logo">
                            <img src="../images/Logo_Bank_BCA.png" alt="BCA">
                        </div>
                        <div class="bank-info">
                            <span class="bank-name">BCA</span>
                            <span class="bank-desc">No. Rek: 9876 5432 1098 7654</span>
                        </div>
                        <div class="checkmark"></div>
                    </label>
                </div>
            </div>

            <!-- Simpan produk yang akan di-checkout -->
            <?php foreach ($produk_dipilih as $produk): ?>
                <input type="hidden" name="id_keranjang[]" value="<?= $produk['id_keranjang'] ?>">
                <input type="hidden" name="id_produk[]" value="<?= $produk['id_produk'] ?>">
                <input type="hidden" name="id_ukuran[]" value="<?= $produk['id_ukuran'] ?>">
                <input type="hidden" name="quantity[]" value="<?= $produk['quantity'] ?>">
                <input type="hidden" name="harga[]" value="<?= $produk['harga'] ?>">
            <?php endforeach; ?>

            <input type="submit" class="submit-btn" value="Place Order">
        </form>

        <div class="summary-section">
            <h4>Order Summary</h4>
            <div class="summary-row">
                <span>Shipping</span>
                <span>Free</span>
            </div>
            <div class="summary-row total">
                <span>Subtotal</span>
                <span>Rp <?= number_format($total_harga, 0, ',', '.') ?></span>
            </div>

            <?php foreach ($produk_dipilih as $produk): ?>
                <div class="product-summary">
                    <img src="../images/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>" />
                    <div class="product-info">
                        <p><strong><?= htmlspecialchars($produk['nama_produk']) ?></strong></p>
                        <p><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>
                        <p>Size: <?= htmlspecialchars($produk['ukuran']) ?></p>
                        <p>Quantity: <?= $produk['quantity'] ?></p>
                        <p>Rp <?= number_format($produk['harga'] * $produk['quantity'], 0, ',', '.') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        const cards = document.querySelectorAll(".payment-card");
        cards.forEach(card => {
            card.addEventListener("click", () => {
                cards.forEach(c => c.classList.remove("selected"));
                card.classList.add("selected");
                card.querySelector("input[type='radio']").checked = true;
            });
        });
    </script>
</body>
<?php include 'footer.php'; ?>

</html>