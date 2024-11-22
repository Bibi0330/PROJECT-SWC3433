<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get item details from form submission
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];

    // Check if the cart session variable is already defined
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Create the item array to add to the cart
    $item = [
        'item_id' => $item_id,
        'name' => $item_name,
        'price' => $price,
        'quantity' => 1, // Default quantity is 1, you can let the user adjust this later if needed
    ];

    // Check if the item is already in the cart
    $item_found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['item_id'] == $item_id) {
            // If the item is already in the cart, increase its quantity
            $cart_item['quantity'] += 1;
            $item_found = true;
            break;
        }
    }

    // If the item is not in the cart, add it
    if (!$item_found) {
        $_SESSION['cart'][] = $item;
    }

    // Redirect to the menu page or cart page with a success message
    header('Location: menu.php'); // Redirect back to the menu page or change to cart.php if needed
    exit();
}
?>
