<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? "Yes" : "No";

    echo "<div class='mt-3'><h3>Submitted Details:</h3>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Password:</strong> $password</p>";
    echo "<p><strong>Remember me:</strong> $remember</p>";
    echo "</div>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <div class="header-content">
                    <h2 class="model_name text-center">Leave Application Form</h2>
                </div>
            </div>
        </nav>
    </header>

    <div class="container col-md-6 mt-5">
        <h2 class="loginform">Login Here</h2>
        <form method="post">
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
            </div>
            <a href="forgot_password.php">Forgot Password?</a>
            <br><br>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="signup.php" class="btn btn-secondary">Signup</a>

            </div>
        </form>
    </div>

</body>

</html>