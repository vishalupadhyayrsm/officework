<?php
// // Start or resume the session
session_start();

// Check if the user is already logged in, redirect to home1.php
if (isset($_SESSION['email'])) {
    header("Location: homepage.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$database = "device_management_system";

// Create a connection to the database
$conn = new mysqli($host, $user, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    // Get user inputs from the form
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo $password;
 // Retrieve hashed password from the database based on the entered email
 $sql = "SELECT * FROM userdetails WHERE email = ?";
 $stmt = $conn->prepare($sql);
 $stmt->bind_param("s", $email);
 $stmt->execute();
 $result = $stmt->get_result();

 if ($result->num_rows > 0) {
    echo('inside');
     // User exists in the database
     $row = $result->fetch_assoc();
     $hashed_password = $row['password'];
     echo $hashed_password;

     if (password_verify($password, $hashed_password)) {
         $_SESSION['email'] = $email;
         // Redirect to homepage.php
         header("Location: homepage.php");
         exit();
     } else {
         echo "Invalid password";
     }
 } else {
     // User does not exist
     echo "User does not exist";
 }

 $stmt->close();
 $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <style>
 
    </style>
    <title>Login Page</title>
</head>

<body>

    <div class="container login-container">
        <h2 class="login-heading">NCAIR LOGIN</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your Password" required>
            </div>
            <button type="submit" class="btn btn-primary login-button"  name="login">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
