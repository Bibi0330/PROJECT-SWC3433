<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login if not logged in
    header('Location: admin_login.php');
    exit();
}

// Directly including the database connection here:
$servername = "localhost";
$username = "root";
$password = "syakila03"; // Your MySQL root password
$dbname = "admins";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fantasy Dessert Shop</title>
    <style>
        /* General Reset */
        body, h1, h2, h3, p, ul, li, a, button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        /* Header Styling */
        .header {
            background-color: #af077f;
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-family: 'Arvo', serif;
            font-size: 20px;
        }

        .navbar ul {
            list-style: none;
            display: flex;
        }

        .navbar ul li {
            margin-right: 15px;
        }

        .navbar ul li a {
            color: #ffe600;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        /* Manage Menu Section */
        .menu {
            margin-top: 30px;
        }

        .menu h2 {
            font-family: 'Fruktur', serif;
            font-size: 28px;
            color: #b84c65;
            margin-bottom: 20px;
        }

        .categories {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .category {
            background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: calc(33.333% - 20px);
            box-sizing: border-box;
        }

        .category img {
            width: 100%;
            height: auto;
            max-height: 350px;
            object-fit: cover;
            border-radius: 5px;
        }

        .category h3 {
            font-family: 'Arvo', serif;
            color: #333;
            font-size: 18px;
            margin-top: 10px;
        }

        .category p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .menu-actions {
            margin-top: 10px;
        }

        .menu-actions .action-btn {
            background-color: #b84c65;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
            font-size: 14px;
        }

        .menu-actions .action-btn:hover {
            background-color: #8e4aad;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">
        <h1 style="font-size: 20px;">Admin Dashboard</h1>
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="view_analytics.php">View Analytics</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Manage Menu Section -->
    <section class="menu">
        <h2>Manage Dessert Menu</h2>
        <div class="categories">
            <?php
            // Fetch items from the database
            $sql = "SELECT * FROM menu_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='category'>";
                    echo "<img src='" . $row['image_1'] . "' alt='" . $row['name'] . " Image' class='menu-image'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "<p>Stock: " . $row['stock'] . "</p>";
                    echo "<p>Price: RM " . number_format($row['price'], 2) . "</p>";
                    echo "<div class='menu-actions'>";
                    echo "<button class='action-btn edit-item' onclick=\"editItem('" . $row['item_id'] . "')\">Edit</button>";
                    echo "<button class='action-btn delete-item' onclick=\"deleteItem('" . $row['item_id'] . "')\">Delete</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No items found in the menu.</p>";
            }
            ?>
        </div>
    </section>

    <script>
        // Function to delete an item from the menu
        function deleteItem(itemId) {
            if (confirm('Are you sure you want to delete this item?')) {
                window.location.href = 'delete_menu_item.php?id=' + itemId;
            }
        }

        // Function to edit an item from the menu
        function editItem(itemId) {
            window.location.href = 'edit_menu_item.php?id=' + itemId;
        }
    </script>
</body>
</html>

