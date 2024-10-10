<?php
// Check if a session is already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include('connect.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $email = isset($_POST['Email']) ? mysqli_real_escape_string($conn, $_POST['Email']) : '';
    $password = isset($_POST['Password']) ? $_POST['Password'] : '';

    // Check if all fields are filled
    if (empty($email) || empty($password)) {
        echo "Both fields are required.";
        exit();
    }

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Prepare an SQL query to retrieve the user data
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind the parameters to the SQL query
    $stmt->bind_param("s", $email);

    // Execute the query and check if the user exists
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];

            // Redirect to the dashboard or home page
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with this email.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .login-container {
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: teal;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, input {
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: teal;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: darkcyan;
        }
        .signup-link {
            text-align: center;
            margin-top: 20px;
        }
        .signup-link a {
            color: teal;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form action="Login.php" method="post">
        <label for="email">Your Email</label>
        <input type="email" id="email" placeholder="example@gmail.com" required name="Email">
        
        <label for="password">Your Password</label>
        <input type="password" id="password" placeholder="at least 8 characters" required name="Password">
        
        <input type="submit" value="Login">
    </form>

    <div class="signup-link">
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</div>

</body>
</html>
