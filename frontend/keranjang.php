<?php
session_start();
include '../backend/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['id_user'];

$query = "SELECT k.id_keranjang, k.id_produk, p.nama_produk, p.gambar, p.harga, u.ukuran, u.id_ukuran, k.quantity
          FROM keranjang k
          JOIN produk p ON k.id_produk = p.id_produk
          JOIN ukuran u ON k.id_ukuran = u.id_ukuran
          WHERE k.id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bag</title>
    <link rel="stylesheet" href="css/keranjang.css">
    <style>
        .keranjang-item {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
        }

        .item-info {
            flex-grow: 1;
        }

        .checkout-footer {
            text-align: right;
            margin-top: 30px;
        }

        .checkout-btn-global {
            background: black;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .checkbox-select {
            margin-right: 10px;
            transform: scale(1.3);
        }

        .hapus-btn {
            background: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .update-btn {
            padding: 5px 10px;
            margin-top: 5px;
            background-color: #ddd;
            border: none;
            cursor: pointer;
        }

        .total-container {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        input[type=number] {
            width: 60px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <main class="keranjang-container">
        <h2>Bag</h2>

        <!-- Form utama checkout -->
        <form action="checkout_selected.php" method="POST" id="checkout-form">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($item = $result->fetch_assoc()):
                    $subtotal = $item['harga'] * $item['quantity'];
                ?>
                    <div class="keranjang-item">
                        <input type="checkbox" class="checkbox-select" name="selected_items[]" value="<?= $item['id_keranjang'] ?>"
                            data-subtotal="<?= $subtotal ?>" onchange="updateTotal()">

                        <img src="../images/<?= htmlspecialchars($item['gambar']) ?>" width="120">
                        <div class="item-info">
                            <h4><?= htmlspecialchars($item['nama_produk']) ?></h4>
                            <p>Size: <?= htmlspecialchars($item['ukuran']) ?></p>
                            <p>Price: Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <p>Subtotal: Rp <?= number_format($subtotal, 0, ',', '.') ?></p>

                            <!-- Ganti form dengan JS-based update -->
                            <label>Quantity:</label>
                            <input type="number" id="qty-<?= $item['id_keranjang'] ?>" value="<?= $item['quantity'] ?>" min="1">
                            <a href="#" class="update-btn" onclick="updateQuantity(<?= $item['id_keranjang'] ?>)">Update</a>

                            <div class="action-buttons" style="margin-top:10px;">
                                <a href="hapus_keranjang.php?id=<?= $item['id_keranjang'] ?>" class="hapus-btn">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <!-- Total dinamis -->
                <div class="total-container">
                    <h3 id="total-harga">Total Price: Rp 0</h3>
                </div>

                <!-- Tombol checkout -->
                <div class="checkout-footer">
                    <button type="submit" class="checkout-btn-global" onclick="return cekCentang()">Checkout</button>
                </div>

            <?php else: ?>
                <div class="empty-cart-message">
                    <p>Your cart is empty.</p>
                </div>
            <?php endif; ?>
        </form>
    </main>

    <script>
        function updateTotal() {
            const checkboxes = document.querySelectorAll('.checkbox-select');
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.getAttribute('data-subtotal'));
                }
            });
            document.getElementById('total-harga').innerText = 'Total Price: Rp ' + total.toLocaleString('id-ID');
        }

        function cekCentang() {
            const checked = document.querySelectorAll('.checkbox-select:checked');
            if (checked.length === 0) {
                alert("Select at least one product to checkout.");
                return false;
            }
            return true;
        }

        function updateQuantity(id_keranjang) {
            const qty = document.getElementById('qty-' + id_keranjang).value;

            if (qty < 1) {
                alert("Quantity minimal 1");
                return;
            }

            fetch(`update_quantity.php?id_keranjang=${id_keranjang}&quantity=${qty}`)
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Tampilkan pesan dari server
                    if (data.success) {
                        location.reload(); // Reload jika berhasil
                    }
                })
                .catch(error => {
                    alert("An error occurred while contacting the server.");
                    console.error(error);
                });
        }


        document.addEventListener('DOMContentLoaded', updateTotal);
    </script>
</body>


</html>
