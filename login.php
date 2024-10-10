<?php
session_start();

// Include the database connection file
include('connect.php');

// Check if the form has been submitted for login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Email'])) {
    // Get the email and password from the form
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = mysqli_real_escape_string($conn, $_POST['Password']);
    
    // SQL query to check if user exists with the given email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind the email parameter to the SQL query
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            echo "Login successful!";
            // Redirect to a dashboard or another page
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo "User not found.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
    exit();
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
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Silkscreen&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: white;
            color: teal;
        }

        .outer-box {
            width: 100vw;
            height: 100vh;
            background-color: white;
        }

        .inner-box {
            width: 400px;
            margin: 0 auto;
            position: relative;
            top: 40%;
            transform: translateY(-50%);
            padding: 20px 40px;
            background-color: white;
            backdrop-filter: blur(8px);
            border-radius: 8px;
            box-shadow: 2px 2px 5px teal;
        }

        .signup-header h1 {
            font-size: 2.5rem;
            color: teal;
        }

        .signup-body {
            margin: 20px 0;
        }

        .signup-body p {
            margin: 10px 0;
        }

        .signup-body p label {
            display: block;
            font-weight: bold;
            color: teal;
        }

        .signup-body p input {
            width: 100%;
            padding: 10px;
            border: 2px solid teal;
            border-radius: 4px;
            font-size: 1rem;
            margin-top: 4px;
            color: teal;
        }

        .signup-body p input[type="submit"] {
            background-color: teal;
            border: none;
            color: white;
            cursor: pointer;
        }

        .signup-body p input[type="submit"]:hover {
            background-color: #004d4d;
        }

        .signup-footer p {
            color: teal;
            text-align: center;
        }

        .signup-footer p a {
            color: teal;
        }

        .circle {
            width: 200px;
            height: 200px;
            border-radius: 100px;
            background-color: teal;
            position: absolute;
            opacity: 0.3;
        }

        .c1 {
            top: 100px;
            left: 30%;
        }

        .c2 {
            bottom: 200px;
            right: 40%;
        }
    </style>
</head>
<body>

    <div class="outer-box">
        <div class="inner-box">
            <header class="signup-header">
                <h1>Sign In</h1>
            </header>
            <main class="signup-body">
                <form action="login.php" method="post">
                    <p>
                        <label for="email">Your Email</label>
                        <input type="email" id="email" placeholder="example@gmail.com" required name="Email"/>
                    </p>
                    <p>
                        <label for="password">Your Password</label>
                        <input type="password" id="password" placeholder="at least 8 characters" required name="Password"/>
                    </p>
                    <p>
                        <input type="submit" id="submit" value="Login">
                    </p>
                </form>
            </main>

            <footer class="signup-footer">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </footer>
        </div>
        <div class="circle c1"></div>
        <div class="circle c2"></div>
    </div>

</body>
</html>
