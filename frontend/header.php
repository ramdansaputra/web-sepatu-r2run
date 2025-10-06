<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../backend/koneksi.php';

$jumlah_item = 0;

if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $sql = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM keranjang WHERE id_user = '$id_user'");
    $data = mysqli_fetch_assoc($sql);
    $jumlah_item = $data['total'];
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background-color: #fff;
            font-size: 14px;
        }

        .nav-left,
        .nav-center,
        .nav-right {
            display: flex;
            align-items: center;
        }

        .nav-left {
            flex: 1;
        }

        .nav-center {
            flex: 1;
            justify-content: center;
        }

        .nav-right {
            flex: 1;
            justify-content: flex-end;
        }

        .logo-img {
            height: 60px;
            width: auto;
        }

        .nav-center a {
            margin: 0 15px;
            text-decoration: none;
            color: #000;
            font-weight: 500;
        }

        .nav-right input {
            padding: 6px 12px;
            border-radius: 15px;
            border: 1px solid #ccc;
            outline: none;
            margin-right: 15px;
        }

        .icon-links a {
            text-decoration: none;
            margin-left: 15px;
            color: #000;
            font-size: 18px;
            cursor: pointer;
            transition: 0.2s;
            position: relative;
        }

        .icon-links a:hover {
            color: #555;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px 20px;
            }

            .nav-center {
                margin: 10px 0;
                justify-content: flex-start;
            }

            .nav-right {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .icon-links {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="nav-left">
            <a href="index.php"><img src="../images/logo.png" alt="Logo" class="logo-img"></a>
        </div>

        <nav class="nav-center">
            <a href="index.php">Home</a>
            <a href="produk.php">Product</a>
            <a href="order_history.php">Order History</a>
            <a href="about.php">About</a>
        </nav>

        <div class="nav-right">
            <div class="icon-links">
                <a href="profile.php" title="Profil"><i class="fas fa-user user-icon"></i></a>

                <a href="keranjang.php" title="Keranjang">
                    <i class="fas fa-shopping-cart user-icon"></i>
                    <?php if ($jumlah_item > 0): ?>
                        <span class="cart-count"><?php echo $jumlah_item; ?></span>
                    <?php endif; ?>
                </a>

                <a href="logout.php" title="Logout"><i class="fas fa-sign-out-alt user-icon"></i></a>
            </div>
        </div>
    </div>

</body>

</html>