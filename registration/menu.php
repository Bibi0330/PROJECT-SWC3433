<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "syakila03"; // Your MySQL root password
$dbname = "admins";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    // If item already exists in cart, update quantity
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['item_id'] == $item_id) {
            $item['quantity'] += $quantity;
            $item['total_price'] += $quantity * $price;
            $found = true;
            break;
        }
    }

    // If item not found, add new item to cart
    if (!$found) {
        $_SESSION['cart'][] = [
            'item_id' => $item_id,
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $quantity * $price
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Dessert Shop - Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&family=Fruktur:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
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
/* Menu Section */
.menu {
    text-align: center;
    padding: 40px 20px;
}

.menu h2 {
    font-family: 'Caveat Brush', cursive;
    font-size: 3rem;
    color: #d72638;
    margin-bottom: 20px;
}

.categories {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.category {
    background-color: #ffe5ec;
    border: 2px solid #ffccd5;
    border-radius: 15px;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 280px;
    text-align: center;
    transition: all 0.3s ease;
}

.category:hover {
    transform: translateY(-5px);
    box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.2);
}

.category h3 {
    font-family: 'Fruktur', cursive;
    font-size: 1.5rem;
    color: #d72638;
    margin: 15px 0;
}

.category p {
    font-size: 0.9rem;
    margin: 10px 0;
}

.image-slider img {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 10px;
}

/* Form Styles */
form {
    margin-top: 15px;
}

form select,
form button {
    margin-top: 10px;
    padding: 8px 12px;
    border-radius: 5px;
    border: 1px solid #d72638;
    background-color: white;
    color: #d72638;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

form select:hover,
form button:hover {
    background-color: #d72638;
    color: white;
}

/* Cart Summary Section - Fixed at Bottom */
.cart-summary {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #fff7fa;
    border-top: 1px solid #ffa3b1;
    padding: 10px;
    box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.cart-summary h2 {
    font-family: 'Caveat Brush', cursive;
    font-size: 1.5rem;
    margin-bottom: 5px;
}

.cart-items {
    max-height: 150px; /* Ensure content doesn't overflow */
    overflow-y: auto;
    margin-bottom: 5px;
}

.cart-item {
    margin: 15px 0;
    padding: 15px;
    border: 1px dashed #d72638;
    border-radius: 10px;
    background-color: #ffccd5;
}

.cart-item p {
    font-size: 0.95rem;
    margin: 5px 0;
}

.cart-item .remove-item,
.cart-item .edit-item {
    text-decoration: none;
    color: #d72638;
    font-weight: bold;
    margin-right: 10px;
    transition: all 0.3s ease;
}

.cart-item .remove-item:hover,
.cart-item .edit-item:hover {
    color: #ff8fa3;
    text-decoration: underline;
}

/* Checkout Button */
.checkout-container {
    text-align: center; /* Center the checkout button in the pinned cart section */
    margin-top: 5px;
}

.checkout-button {
    text-decoration: none;
    padding: 10px 20px;
    background-color: #af077f;
    color: white;
    border-radius: 5px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.checkout-button:hover {
    background-color: #ff8fa3;
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

    <!-- Menu Section -->
    <section class="menu">
        <h2>Our Dessert Categories</h2>
        <div class="categories">
            <?php
            // Fetch menu items from the database
            $sql = "SELECT * FROM menu_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="category">
                        <div class="image-slider">
                            <img src="<?php echo $row['image_1']; ?>" alt="<?php echo $row['name']; ?> Image" class="slider-image">
                        </div>
                        <h3><?php echo $row['name']; ?></h3>
                        <p>
                            <?php echo $row['description']; ?>
                            <?php
                            if ($row['name'] === 'Iced Coffee' || $row['name'] === 'Lemonade' || $row['name'] === 'Matcha Latte' || $row['name'] === 'Hot Chocolate' || $row['name'] === 'Chai Tea' || $row['name'] === 'Mango Smoothie' || $row['name'] === 'Berry Blast Smoothie' || $row['name'] === 'Iced Lemon Tea') {
                                echo "<br>Size: Regular";
                            } else {
                                echo "<br>Available Sizes: Small, Medium, Large";
                            }
                            ?>
                        </p>
                        <p>Price: RM <?php echo number_format($row['price'], 2); ?></p>
                        
                        <!-- Add to Cart Form -->
                        <form method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                            <label for="quantity">Quantity:</label>
                            <select name="quantity" id="quantity">
                                <option value="1">1 pieces</option>
                                <option value="6">6 pieces / NotForDrinks</option>
                                <option value="12">12 pieces / NotForDrinks</option>
                            </select>
                            <button type="submit" name="add_to_cart">Add to Cart</button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No items found in the menu.</p>";
            }
            ?>
        </div>
    </section>

<!-- Cart Summary Section -->
<section class="cart-summary">
    <h2>Cart Summary</h2>
    <div class="cart-items">
        <?php
        if (!empty($_SESSION['cart'])) {
            $total = 0;
            foreach ($_SESSION['cart'] as $index => $cart_item) {
                echo "<div class='cart-item'>";
                echo "<p>" . $cart_item['name'] . " - Quantity: " . $cart_item['quantity'] . " - Total Price: RM " . number_format($cart_item['total_price'], 2) . "</p>";
                
                // Remove button
                echo "<a href='remove_item.php?index=$index' class='remove-item'>Remove</a> | ";
                
                // Edit button (opens a form to edit quantity)
                echo "<a href='#' class='edit-item' onclick='editItem($index)'>Edit</a>";
                echo "</div>";
                $total += $cart_item['total_price'];
            }
            echo "<p><strong>Total: RM " . number_format($total, 2) . "</strong></p>";
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>
    </div>
    <!-- Checkout Button aligned to the right -->
    <div class="checkout-container">
        <a href="checkout.php" class="checkout-button">Checkout</a>
    </div>
</section>

<script>
// Function to handle the edit action
function editItem(index) {
    // Prompt user for new quantity
    var newQuantity = prompt("Enter new quantity:");

    if (newQuantity && !isNaN(newQuantity) && newQuantity > 0) {
        // Create a form dynamically to submit the new quantity
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "edit_item.php?index=" + index;

        // Create the quantity input
        var quantityInput = document.createElement("input");
        quantityInput.type = "hidden";
        quantityInput.name = "quantity";
        quantityInput.value = newQuantity;

        form.appendChild(quantityInput);

        // Submit the form
        document.body.appendChild(form);
        form.submit();
    } else {
        alert("Invalid quantity.");
    }
}
</script>

</section>
</body>
</html>

<?php
$conn->close();
?>