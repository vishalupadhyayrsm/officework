<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sign Up</title>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/logo.png">
    <link href="./css/style.css" rel="stylesheet">
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Register Here</h4>
                                    <form method="post" action="main.php">
                                        <div class="form-group">
                                            <label><strong>Username</strong></label>
                                            <input type="text" class="form-control" placeholder="username" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" class="form-control" placeholder="hello@example.com" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control" value="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="contact"><strong>Number:</strong></label>
                                            <input type="tel" class="form-control" id="contact" placeholder="Enter contact number" name="contact">
                                        </div>
                                        <div class="form-group">
                                            <label for="month">Joining as :</label>
                                            <select class="form-control" id="month" name="month">
                                                <option value="">Select</option>
                                                <option value="staff">Staff</option>
                                                <option value="intern">Intern</option>
                                                <option value="student">Student</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
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

                                        <div class="text-center mt-4">
                                            <button type="submit" name="register" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="index.php">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <!--endRemoveIf(production)-->
</body>

</html>