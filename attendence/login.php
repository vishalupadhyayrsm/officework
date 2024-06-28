<?php
// session_start();
include 'main.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = (new Login())->login();
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Here</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="logo.ico">
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
                    <h2 class="model_name text-center">Machine Intelligence Program</h2>
                </div>
            </div>
        </nav>
    </header>

    <div class="container col-md-6 mt-5" style="height: 500px;">
        <h2 class="loginform">Login Here</h2>
        <form method="post" action="main.php">
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
            </div>
            <a href="updatepassword.php">Forgot Password?</a>
            <br><br>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="login">Login</button>
                <a href="signup.php" class="btn btn-secondary">Signup</a>

            </div>
        </form>
    </div>

    <?php
    include 'footerout.php';
    ?>


</body>

</html>