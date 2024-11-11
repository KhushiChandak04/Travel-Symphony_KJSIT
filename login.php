<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form inputs
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $password = isset($_POST['Password']) ? trim($_POST['Password']) : '';

    // Check if email and password are filled
    if (empty($email) || empty($password)) {
        echo '<div class="message">Please fill in both the email and password fields.</div>';
    } else {
        // Database connection details
        $servername = "localhost";
        $username = "root"; // Default username for XAMPP
        $db_password = "Billi4@billu"; // Your actual password for XAMPP
        $dbname = "travel_symphony"; // Replace with your actual database name

        // Create connection
        $conn = new mysqli($servername, $username, $db_password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to check if the user exists with the provided email
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Fetch the user data
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables for the logged-in user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];

                // Redirect to the index page after successful login
                header("Location: index.php");
                exit();
            } else {
                echo '<div class="message">Incorrect password. Please try again.</div>';
            }
        } else {
            echo '<div class="message">No account found with this email. Please register below.</div>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>

    <!-- Link Google Fonts for Varela Round -->
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

    <style>
        /* Basic styling */
        body {
            font-family: 'Varela Round', sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
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
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: teal;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0,128,128,0.2);
        }
        input[type="submit"], .register-btn {
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
        input[type="submit"]:hover, .register-btn:hover {
            background-color: #006666;
        }
        .message {
            color: red;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .register-btn {
            text-align: center;
            background-color: gray;
            margin-top: 10px;
        }
        .register-btn:hover {
            background-color: darkgray;
        }
        .register-link {
            text-align: center;
            display: block;
            margin-top: 20px;
            text-decoration: none;
        }
        .register-link button {
            font-family: 'Varela Round', sans-serif;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="email">Email</label>
            <input type="email" name="Email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="Password" id="password" required>

            <input type="submit" value="Login">

            <!-- If the user is not registered, show the Register button -->
            <a href="signup.php" class="register-link">
                <button type="button" class="register-btn">Register</button>
            </a>
        </form>
    </div>
</body>
</html>
