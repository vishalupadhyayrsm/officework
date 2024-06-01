<?php
// session_start();
// include 'main.php';
// session_destroy();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);
    $field = htmlspecialchars($_POST['field']);
    $lab = htmlspecialchars($_POST['lab']);
    echo "Email: " . $email . "<br>"; 
    echo "password: " . $password . "<br>";
    echo "cpassword: " . $cpassword . "<br>";
    echo "field: " . $field . "<br>";
    echo "lab: " . $lab . "<br>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register Here</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="logodiv">
        <div width="78px" class="d-inline-block align-top"></div>
        <h2 class="heading">Complaint Management System</h2>
    </div>

    <form class="modal-content" action="main.php" method="post">
        <div class="container">
            <h1>Sign Up</h1>

            <div class="form-group">
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" id="emailtxt" required>
            </div>

            <div class="form-group">
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="txtPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase letter, lowercase letter, and at least 8 characters" required>
                <i class="bi bi-eye-slash eye-slash" id="togglepassword"></i>
            </div>

            <div class="form-group">
                <label for="psw-repeat"><b>Confirm Password</b></label>
                <input type="password" placeholder="Repeat Password" name="cpassword" id="txtConfirmPassword" required>
                <i class="bi bi-eye-slash eye-slash" id="confirmpassword"></i>
            </div>

            <div class="form-group">
                <label for="field">Field:</label>
                <select class="form-control" id="field" name="field" required>
                    <option value="IOT">IOT</option>
                    <option value="AI/ML">AI/ML</option>
                    <option value="Full Stack">Full Stack</option>
                    <option value="Mtech">Mtech</option>
                    <option value="Phd">Phd</option>
                    <option value="PostDoc">PostDoc</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lab">Lab:</label>
                <select class="form-control" id="lab" name="lab" required>
                    <option value="NCAIR">NCAIR</option>
                    <option value="MMMF">MMMF</option>
                    <option value="Textile">Textile</option>
                    <option value="AMTF">AMTF</option>
                    <option value="AMEC">AMEC</option>
                    <option value="FDXM">FDXM</option>
                </select>
            </div>

            <div class="clearfix">
                <button type="submit" name="register" class="signupbtn" id="myBtn" onclick="return Validate()">Sign Up</button>
                <h5>Already Registered? <a href="login.php">Login Here</a></h5>
            </div>
        </div>
    </form>
    <footer>
        <div style="text-align: center">
            <p> General AI <br>
                Machine Intelligence Program <br>
                IIT-Bombay,Powai,Mumbai-400076, INDIA </p>
        </div>
    </footer>
    <script>
        //User  password can see  what he enter here
        const togglePassword = document.querySelector('#togglepassword');
        const password = document.querySelector('#txtPassword');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
        });

        //  User Confirm Password can See here
        const toggleConfirmPassword = document.querySelector('#confirmpassword');
        const cpassword = document.querySelector('#txtConfirmPassword');

        toggleConfirmPassword.addEventListener('click', function(a) {
            const ctype = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
            cpassword.setAttribute('type', ctype);
            this.classList.toggle('bi-eye');
        });


        function Validate() {
            var email = document.getElementById("emailtxt").value;
            var password = document.getElementById("txtPassword").value;
            var confirmPassword = document.getElementById("txtConfirmPassword").value;
            if (email == "") {
                alert("Please Fill Email")
            } else if (password == "") {
                alert("Please Fill the password")
            } else if (password != confirmPassword) {
                alert("Confirm Passwords Must Be same");
                return false;
            } else {
                return true;
            }
        }
    </script>
</body>

</html>