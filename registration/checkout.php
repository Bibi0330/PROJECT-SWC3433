<?php
session_start();

// Redirect to the menu page if the cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: menu.php');
    exit();
}

// Calculate total price
$total = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    $total += $cart_item['total_price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Fantasy Dessert Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&family=Fruktur:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
    <style>
        /* General Styles (use same styles from your original code) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
    margin: 0;
    font-family: 'Arvo', serif;
    background-color: #fff1f4;
    color: #5c5c5c;
    line-height: 1.6;
}

/* Header Section */
body {
            margin: 0;
            font-family: 'Arvo', serif;
            background-color: #fff1f4;
            color: #5c5c5c;
            line-height: 1.6;
        }
        
        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #af077f;
            border-bottom: 3px solid #ffa3b1;
        }
        
        .header .logo img {
            max-height: 80px;
        }
        
        .navbar ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        
        .navbar ul li {
            margin-left: 20px;
        }
        
        .navbar ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 5px 10px;
            transition: all 0.3s ease;
        }
        
        .navbar ul li a:hover {
            background-color: #ff8fa3;
            color: white;
            border-radius: 5px;
        }
        .checkout-summary {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .checkout-summary h2 {
            font-family: 'Caveat Brush', cursive;
            font-size: 24px;
            color: #b84c65;
            margin-bottom: 20px;
        }

        .checkout-items {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .checkout-items p {
            margin-bottom: 10px;
        }

        .checkout-items strong {
            font-size: 18px;
        }

        .confirmation-box {
            border: 2px solid #b84c65;
            padding: 15px;
            margin-top: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .order-button {
            padding: 10px 20px;
            background-color: #9a4051;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        .order-button:hover {
            background-color: #ffe600;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="Project.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="faq.html">Faq</a></li>
            </ul>
        </nav>
    </header>

    <!-- Checkout Summary Section -->
    <section class="checkout-summary">
        <h2>Your Order Summary</h2>
        <div class="checkout-items">
            <?php
            // Display cart items
            foreach ($_SESSION['cart'] as $cart_item) {
                echo "<p>" . $cart_item['name'] . " - Quantity: " . $cart_item['quantity'] . " - Total Price: RM " . number_format($cart_item['total_price'], 2) . "</p>";
            }
            ?>
            <p><strong>Total: RM <?php echo number_format($total, 2); ?></strong></p>
        </div>

        <!-- Confirmation Box -->
        <div class="confirmation-box">
            <h3>Confirm your order:</h3>
            <p><strong>Total Price: RM <?php echo number_format($total, 2); ?></strong></p>
            <p>Once you confirm the order, we will process your items for delivery. Are you ready to proceed?</p>
        </div>

        <!-- Order Button -->
        <a href="order_confirmation.php" class="order-button">Order Now</a>
    </section>

</body>
</html>
