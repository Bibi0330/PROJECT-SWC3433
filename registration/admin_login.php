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

// Handle admin login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check admin credentials
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Assuming the password in your database is hashed
        if (password_verify($password, $admin['password'])) {
            // Store admin details in session
            $_SESSION['username'] = $username;
            header("Location: admin_dashboard.php"); // Redirect to admin dashboard
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Admin Login Form Styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arvo', sans-serif;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            color: #b84c65;
            font-size: 32px;
            font-family: 'Caveat Brush', cursive;
        }

        form {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            width: 300px;
            font-family: 'Arial', sans-serif;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        form input[type="text"]:focus,
        form input[type="password"]:focus {
            border-color: #b84c65;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color:  #af077f;
            color: #f9d657;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #5f0d0d;
        }

        p {
            color: red;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form action="admin_login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
