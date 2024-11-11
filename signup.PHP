<?php 
// Start session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form inputs and prevent undefined array key warnings
    $fullname = isset($_POST['FullName']) ? trim($_POST['FullName']) : '';
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $password = isset($_POST['Password']) ? trim($_POST['Password']) : '';

    // Check if all fields are filled
    if (empty($fullname) || empty($email) || empty($password)) {
        die("Please fill all the fields.");
    }

    // Check if email format is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection details
    $servername = "localhost";
    $username = "root"; // Default username for XAMPP
    $db_password = "Billi4@billu"; // Your actual password for XAMPP
    $dbname = "travel_symphony"; // Replace with your actual database name

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email is already registered
    $check_sql = "SELECT * FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Email is already registered, show login option
        echo '<div class="message">Email is already registered. <a href="login.php">Click here to login</a></div>';
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $fullname, $email, $hashed_password);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redirect to login page after successful registration
                header("Location: login.php");
                exit(); // Make sure to exit to stop further execution
            } else {
                die("Error: Could not create account. Please try again.");
            }

            $stmt->close();
        } else {
            die("Error preparing the statement: " . $conn->error);
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- Link to Google Fonts for Varela Round -->
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

    <style>
        /* General styling */
        body {
            font-family: 'Varela Round', sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.15);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: teal;
            margin-bottom: 20px;
            font-size: 24px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: teal;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0,128,128,0.2);
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: teal;
            border: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #006666;
        }
        .message {
            color: red;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .message a {
            color: teal;
            text-decoration: none;
            font-weight: bold;
        }
        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <label for="fullname">Full Name</label>
            <input type="text" name="FullName" id="fullname" required>

            <label for="email">Email</label>
            <input type="email" name="Email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="Password" id="password" required>

            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>
