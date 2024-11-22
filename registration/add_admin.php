<?php
$servername = "localhost";
$username = "root";
$password = "syakila03"; // Your MySQL root password
$dbname = "admins";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add an admin
$admin_username = "admin"; // Replace with desired admin username
$admin_password = password_hash("admin123", PASSWORD_DEFAULT); // Replace 'admin123' with your desired password

$sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $admin_username, $admin_password);

if ($stmt->execute()) {
    echo "Admin added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
