<?php
include 'dbconfig.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $email = $_POST['email'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE sigin SET password = :pass WHERE email = :email");
            $stmt->bindParam(":pass", $hashedPassword);
            $stmt->bindParam(":email", $email);
            if ($stmt->execute()) {
                echo '<script>alert("Password updated successfully!"); window.location.href = "login.php";</script>';
                // echo "Password updated successfully!";
            } else {
                echo "Error updating password: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo '<script>alert("Passwords do not match!"); window.location.href = "updatepassword.php";</script>';
            // echo "";
        }
    } else {
        echo '<script>alert("Please fill in all fields!"); window.location.href = "updatepassword.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="container col-md-6 mt-5">
        <div class="container col-md-6 mt-5">
            <h2 style="text-align:center;">Change Password</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="pwd">Confirm Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="confirm_password" required>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="login">Update</button>
                    <a href="signup.php" class="btn btn-secondary">Signup</a>

                </div>
            </form>
        </div>


        <!--<form method="POST">-->
        <!--    <label for="email">Email:</label>-->
        <!--    <input type="email" id="email" name="email" required><br><br>-->
        <!--    <label for="new_password">New Password:</label>-->
        <!--    <input type="password" id="new_password" name="new_password" required><br><br>-->
        <!--    <label for="confirm_password">Confirm Password:</label>-->
        <!--    <input type="password" id="confirm_password" name="confirm_password" required><br><br>-->
        <!--    <button type="submit">Change Password</button>-->
        <!--</form>-->
    </div>
</body>

</html>