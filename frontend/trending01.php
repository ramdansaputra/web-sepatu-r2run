<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nike Product Page</title>
    <link rel="stylesheet" href="detail_produk.css" />
</head>

<body>
   
    <main class="product-page">
        <div class="image-container">
            <img src="images/vomero18.png" alt="Nike Vomero 18" />
        </div>
        <div class="details">
            <h2>Nike Vomero 18</h2>
            <p class="category">Running Shoes</p>
            <p class="price">Rp 2.249.000</p>

            <div class="sizes">
                <label class="size-box">
                    <input type="radio" name="size" value="39" /> 39
                </label>
                <label class="size-box">
                    <input type="radio" name="size" value="40" /> 40
                </label>
                <label class="size-box">
                    <input type="radio" name="size" value="41" /> 41
                </label>
                <label class="size-box">
                    <input type="radio" name="size" value="42" /> 42
                </label>
                <label class="size-box">
                    <input type="radio" name="size" value="43" /> 43
                </label>
                <label class="size-box">
                    <input type="radio" name="size" value="45" /> 45
                </label>
            </div>

            <div class="buttons">
                <a href="checkout.php"><button class="checkout">Checkout</button></a>
                <a href="add_to_bag.php"><button class="add-to-bag">Add to bag</button></a>
            </div>

            <div class="description">
                <h4>Description :</h4>
                <p>
                    Comfortable, durable and timeless—it's number one for a reason.
                    The classic ‘80s construction is paired with a puffy Swoosh logo
                    and metal dubrae for style that tracks whether you're on court or
                    on the go.
                </p>
                <ul>
                    <li>Colour Shown: White/Black/Metallic Gold/White</li>
                    <li>Style: HF2014-100</li>
                    <li>Country/Region of Origin: Vietnam</li>
                </ul>
            </div>
        </div>
    </main>

    <script>
        // JS fallback for selected size highlighting
        const labels = document.querySelectorAll('.size-box');
        labels.forEach(label => {
            label.addEventListener('click', () => {
                labels.forEach(l => l.classList.remove('active'));
                label.classList.add('active');
            });
        });
    </script>
</body>

</html>