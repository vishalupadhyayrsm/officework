<?php
// // Start or resume the session
// session_start();

// // Check if the user is already logged in, redirect to home1.php
// if (isset($_SESSION['user'])) {
//     header("Location: home.php");
//     exit();
// }

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$database = "userdoc";

// Create a connection to the database
$conn = new mysqli($host, $user, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    // Get user inputs from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database based on the entered email
    $sql = "SELECT * FROM user WHERE Email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists in the database
        $_SESSION['user'] = $email;
        // Redirect to home1.php
        header("Location: home.php");
        exit();
    } else {
        // User does not exist
        echo "Invalid login credentials";
    }

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <style>
 
    </style>
    <title>Login Page</title>
</head>

<body>

    <div class="container login-container">
        <h2 class="login-heading">NCAIR LOGIN</h2>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your Password" required>
            </div>
            <button type="submit" class="btn btn-primary login-button">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
