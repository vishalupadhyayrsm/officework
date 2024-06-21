<?php
session_start();
include 'main.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Here</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <div class="header-content">
                    <h2 class="model_name text-center">Scanned Pdf file</h2>
                </div>
            </div>
        </nav>
    </header>

    <div class="container col-md-6 mt-3">
        <h2 style="text-align: center;padding: 15px;">Upload Here</h2>
        <form method="post" action="main.php">
            <div class="mb-3">
                <label for="month">Joining as :</label>
                <select class="form-control" id="month" name="producttype">
                    <option value="">Select</option>
                    <option value="Amazon">Amazon</option>
                    <option value="Vendor">Vendor</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="name">Product Brief:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="product">
            </div>
            <div class="mb-3">
                <label for="email">Date:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="date">
            </div>

            <button type="submit" name="register" class="btn btn-primary">Submit</button>
            <a href="login.php" class="btn btn-secondary">Login</a>
        </form>
    </div>

</body>

</html>