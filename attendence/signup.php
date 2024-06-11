<?php
session_start();
include 'main.php';
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Regiter Here</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
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

    <div class="container col-md-6 mt-3">
        <h2 style="text-align: center;padding: 15px;">Register Here</h2>
        <form method="post" action="main.php">
            <div class="mb-3 mt-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
            </div>
            <div class="mb-3">
                <label for="contact">Contact Number:</label>
                <input type="tel" class="form-control" id="contact" placeholder="Enter contact number" name="contact">
            </div>
            <div class="mb-3">
                <label for="month">Joining as :</label>
                <select class="form-control" id="month" name="month">
                    <option value="">Select</option>
                    <option value="staff">Staff</option>
                    <option value="intern">Intern</option>
                    <option value="staff">Student</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="month">Select Joining Month:</label>
                <select class="form-control" id="month" name="month">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

            <button type="submit" name="register" class="btn btn-primary">Submit</button>
            <a href="login.php" class="btn btn-secondary">Login</a>
        </form>
    </div>

</body>

</html>