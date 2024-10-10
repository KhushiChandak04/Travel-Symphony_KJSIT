<?php
// Start session only if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the form has been submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form inputs and prevent undefined array key warnings
    $fullname = isset($_POST['FullName']) ? trim($_POST['FullName']) : '';
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $password = isset($_POST['Password']) ? trim($_POST['Password']) : '';

    // Ensure that all fields are filled
    if (empty($fullname) || empty($email) || empty($password)) {
        die("Please fill all the fields.");
    }

    // Check if the email format is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Hash the password for security (for registration only)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection details
    $servername = "localhost";
    $username = "root"; // Default username for XAMPP
    $db_password = "Billi4@billu"; // Your actual password for XAMPP
    $dbname = "travel_symphony"; // Replace with your actual database name

    // Create a connection
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Depending on the form type, insert user data (for registration) or verify user credentials (for login)
    if (isset($_POST['login'])) {
        // Handle login process
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Store user information in session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['fullname'];

                    // Redirect to dashboard or home page after successful login
                    header("Location: index.php");
                    exit();
                } else {
                    die("Incorrect password.");
                }
            } else {
                die("No user found with this email.");
            }

            $stmt->close();
        } else {
            die("Error preparing the statement: " . $conn->error);
        }
    } else if (isset($_POST['register'])) {
        // Handle registration process
        $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $fullname, $email, $hashed_password);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Account created successfully!";
            } else {
                die("Error: Could not create account. Please try again.");
            }

            $stmt->close();
        } else {
            die("Error preparing the statement: " . $conn->error);
        }
    } else {
        die("Invalid form submission.");
    }

    // Close the database connection
    $conn->close();
} else {
    // Show error if the request is not a POST request
    die("Invalid request method.");
}
?>
