<?php
session_start();

<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
=======
>>>>>>> Stashed changes
// Include the database connection file
include('connect.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $fullname = isset($_POST['FullName']) ? mysqli_real_escape_string($conn, $_POST['FullName']) : '';
    $email = isset($_POST['Email']) ? mysqli_real_escape_string($conn, $_POST['Email']) : '';
    $password = isset($_POST['Password']) ? $_POST['Password'] : '';

    // Check if all fields are filled
    if (empty($fullname) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit();
    }

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Hash the password for secure storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL query to insert the user data
    $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind the parameters to the SQL query
    $stmt->bind_param("sss", $fullname, $email, $hashed_password);

    // Execute the query and check if the data was inserted successfully
    if ($stmt->execute()) {
        echo "Account created successfully!";
        // Optionally, redirect to the login page or another page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: Could not create account. " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
<<<<<<< Updated upstream
========
// Include database connection file
include('connect.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // SQL query to check if user exists with the given email and password
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    // Check if the user exists
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        echo "Login successful!";
        // Redirect to a dashboard or another page
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid email or password. Please try again.";
    }
>>>>>>>> Stashed changes:login.php
}
?>

=======
}
?>
>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Silkscreen&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            background-color: white;
            color: teal;
========
            background-color: white; /* Changed background to white */
            color: teal; /* Set text color to teal */
>>>>>>>> Stashed changes:login.php
=======
            background-color: white; /* Changed background to white */
            color: teal; /* Set text color to teal */
>>>>>>> Stashed changes
        }

        .outer-box {
            width: 100vw;
            height: 100vh;
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            background-color: white;
========
            background-color: white; /* Changed background to white */
>>>>>>>> Stashed changes:login.php
=======
            background-color: white; /* Changed background to white */
>>>>>>> Stashed changes
        }

        .inner-box {
            width: 400px;
            margin: 0 auto;
            position: relative;
            top: 40%;
            transform: translateY(-50%);
            padding: 20px 40px;
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            background-color: white;
            backdrop-filter: blur(8px);
            border-radius: 8px;
            box-shadow: 2px 2px 5px teal;
========
=======
>>>>>>> Stashed changes
            background-color: white; /* White background */
            backdrop-filter: blur(8px);
            border-radius: 8px;
            box-shadow: 2px 2px 5px teal; /* Updated shadow color to teal */
<<<<<<< Updated upstream
>>>>>>>> Stashed changes:login.php
=======
>>>>>>> Stashed changes
        }

        .signup-header h1 {
            font-size: 2.5rem;
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            color: teal;
========
            color: teal; /* Teal header color */
>>>>>>>> Stashed changes:login.php
=======
            color: teal; /* Teal header color */
>>>>>>> Stashed changes
        }

        .signup-header p {
            font-size: 0.95rem;
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            color: teal;
========
            color: teal; /* Teal paragraph color */
>>>>>>>> Stashed changes:login.php
=======
            color: teal; /* Teal paragraph color */
>>>>>>> Stashed changes
            margin-top: 5px;
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
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            color: teal;
========
            color: teal; /* Teal label color */
>>>>>>>> Stashed changes:login.php
=======
            color: teal; /* Teal label color */
>>>>>>> Stashed changes
        }

        .signup-body p input {
            width: 100%;
            padding: 10px;
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            border: 2px solid teal;
            border-radius: 4px;
            font-size: 1rem;
            margin-top: 4px;
            color: teal;
        }

        .signup-body p input[type="submit"] {
            background-color: teal;
========
=======
>>>>>>> Stashed changes
            border: 2px solid teal; /* Teal border color */
            border-radius: 4px;
            font-size: 1rem;
            margin-top: 4px;
            color: teal; /* Teal text color */
        }

        .signup-body p input[type="submit"] {
            background-color: teal; /* Teal background for submit button */
<<<<<<< Updated upstream
>>>>>>>> Stashed changes:login.php
=======
>>>>>>> Stashed changes
            border: none;
            color: white;
            cursor: pointer;
        }

        .signup-body p input[type="submit"]:hover {
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            background-color: #004d4d;
        }

        .signup-footer p {
            color: teal;
========
=======
>>>>>>> Stashed changes
            background-color: #004d4d; /* Darker teal on hover */
        }

        .signup-footer p {
            color: teal; /* Teal footer text */
<<<<<<< Updated upstream
>>>>>>>> Stashed changes:login.php
=======
>>>>>>> Stashed changes
            text-align: center;
        }

        .signup-footer p a {
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            color: teal;
========
            color: teal; /* Teal link color */
>>>>>>>> Stashed changes:login.php
=======
            color: teal; /* Teal link color */
>>>>>>> Stashed changes
        }

        .circle {
            width: 200px;
            height: 200px;
            border-radius: 100px;
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
            background-color: teal;
========
            background-color: teal; /* Teal background for circles */
>>>>>>>> Stashed changes:login.php
=======
            background-color: teal; /* Teal background for circles */
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
                <h1>Sign Up</h1>
            </header>
            <main class="signup-body">
                <!-- Updated the action to point to signup.php -->
                <form action="signup.php" method="post">
                    <p>
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" placeholder="Enter your name" required name="FullName"/>
                    </p>
                    <p>
                        <label for="email">Your Email</label>
                        <input type="email" id="email" placeholder="example@gmail.com" required name="Email"/>
                    </p>
                    <p>
                        <label for="password">Your Password</label>
                        <input type="password" id="password" placeholder="at least 8 characters" required name="Password"/>
========
                <h1>Sign in</h1>
            </header>
            <main class="signup-body">
                <form action ="connect.php" method="post">

                    <p>
                        <label for="email">Your Email</label>
=======
                <h1>Sign Up</h1>
            </header>
            <main class="signup-body">
                <form action ="connect.php" method="post">
                    <p>
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" placeholder="Enter your name" required name ="FullName"/>
                    </p>
                    <p>
                        <label for="email">Your Email</label>
>>>>>>> Stashed changes
                        <input type="email" id="email" placeholder="example@gmail.com" required name ="Email"/>
                    </p>
                    <p>
                        <label for="password">Your Password</label>
                        <input type="password" id="password" placeholder="at least 8 characters" required name ="Password"/>
<<<<<<< Updated upstream
>>>>>>>> Stashed changes:login.php
=======
>>>>>>> Stashed changes
                    </p>
                    <p>
                        <input type="submit" id="submit" value="Create Account">
                    </p>
                </form>
            </main>

            <footer class="signup-footer">
<<<<<<< Updated upstream
<<<<<<<< Updated upstream:signup.PHP
                <p>Already have an Account? <a href="login.php">Login</a></p>
========
>>>>>>>> Stashed changes:login.php
=======
                <p>Already have an Account? <a href="login.html" target="Pet">Login</a> </p>
>>>>>>> Stashed changes
            </footer>

        </div>
        <div class="circle c1"></div>
        <div class="circle c2"></div>
    </div>

</body>
</html>
