<?php
// Database connection details
$servername = "localhost";  // Default XAMPP server
$username = "root";         // Default XAMPP username
$password = "Billi4@billu";             // Default XAMPP password is empty
$dbname = "travel_symphony";  // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
