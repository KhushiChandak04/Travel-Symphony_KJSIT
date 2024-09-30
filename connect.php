<?php
<<<<<<< Updated upstream
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
=======
// Start session
session_start();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form inputs and prevent undefined array key warnings
    $fullname = isset($_POST['FullName']) ? $_POST['FullName'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $password = isset($_POST['Password']) ? $_POST['Password'] : '';

    // Ensure that all fields are filled
    if (empty($fullname) || empty($email) || empty($password)) {
        die("Please fill all the fields.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection details
    $servername = "localhost";
    $username = "root"; // Default username for XAMPP
    $password = ""; // Default password for XAMPP (empty)
    $dbname = "travel_symphony"; // Replace with your actual database name

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Prepare an SQL statement to insert the user data
    $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Account created successfully!";
        } else {
            echo "Error: Could not create account. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
>>>>>>> Stashed changes
}
?>
