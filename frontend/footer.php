<footer class="site-footer">
    <div class="footer-container">
        <nav class="footer-nav">
            <div class="footer-section">
                <h4>Company</h4>
                <ul>
                    <li><a href="about.php">About R2Run</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>History</h4>
                <ul>
                    <li><a href="order_history.php">Order History</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Us</h4>
                <div class="footer-section social-section">
                    <a href="https://www.facebook.com/share/1GBCxfcyGG/"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/pandiannn_?igsh=MXFmMTFrOTgwMHozcw=="><i class="fab fa-instagram"></i></a>
                    <a href="https://x.com/ramdandsaputra?t=5RNnbLyZ7JgsS4iOgdX9KQ&s=08 "><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </nav>
        <div class="footer-bottom">
            <span>© 2025 R2Run, Inc. All rights reserved · Indonesia <i class="fas fa-globe"></i></span>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background-color: #111;
        color: #fff;
        padding: 50px 20px;
        border-top: 1px solid #333;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-nav {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .footer-section h4 {
        margin-bottom: 15px;
        font-weight: bold;
        font-size: 16px;
        text-transform: uppercase;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-section ul li {
        margin: 10px 0;
    }

    .footer-section ul li a {
        text-decoration: none;
        color: #ccc;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
        color: #fff;
    }

    .social-section {
        display: flex;
        align-items: flex-start;
        margin-top: 10px;
    }

    .social-section a {
        margin-right: 15px;
        font-size: 24px;
        color: #ccc;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .social-section a:hover {
        color: #fff;
        transform: scale(1.1);
    }

    .footer-bottom {
        text-align: center;
        border-top: 1px solid #333;
        padding-top: 20px;
        font-size: 12px;
        color: #777;
    }

    .footer-bottom i {
        margin-left: 5px;
    }

    @media (max-width: 768px) {
        .footer-nav {
            grid-template-columns: 1fr;
        }
    }
</style>
