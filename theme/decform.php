<?php
session_start();
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$sid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Focus - Bootstrap Admin Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/logo.png">
    <!-- Form step -->
    <link href="./vendor/jquery-steps/css/jquery.steps.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">
    <style>
        label {
            color: black;
        }
    </style>
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">

        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/logo.png" alt="">
                <img class="logo-compact" src="./images/mip.png" alt="">
                <img class="brand-title" src="./images/mip.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <!--<li class="nav-item dropdown notification_dropdown">-->
                            <!--    <a class="nav-link" href="#" role="button" data-toggle="dropdown">-->
                            <!--        <i class="mdi mdi-bell"></i>-->
                            <!--        <div class="pulse-css"></div>-->
                            <!--    </a>-->
                            <!--<div class="dropdown-menu dropdown-menu-right">-->
                            <!--    <ul class="list-unstyled">-->
                            <!--        <li class="media dropdown-item">-->
                            <!--            <span class="success"><i class="ti-user"></i></span>-->
                            <!--            <div class="media-body">-->
                            <!--                <a href="#">-->
                            <!--                    <p><strong>Martin</strong> has added a <strong>customer</strong>-->
                            <!--                        Successfully-->
                            <!--                    </p>-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--            <span class="notify-time">3:20 am</span>-->
                            <!--        </li>-->
                            <!--        <li class="media dropdown-item">-->
                            <!--            <span class="primary"><i class="ti-shopping-cart"></i></span>-->
                            <!--            <div class="media-body">-->
                            <!--                <a href="#">-->
                            <!--                    <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--            <span class="notify-time">3:20 am</span>-->
                            <!--        </li>-->
                            <!--        <li class="media dropdown-item">-->
                            <!--            <span class="danger"><i class="ti-bookmark"></i></span>-->
                            <!--            <div class="media-body">-->
                            <!--                <a href="#">-->
                            <!--                    <p><strong>Robin</strong> marked a <strong>ticket</strong> as-->
                            <!--                        unsolved.-->
                            <!--                    </p>-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--            <span class="notify-time">3:20 am</span>-->
                            <!--        </li>-->
                            <!--        <li class="media dropdown-item">-->
                            <!--            <span class="primary"><i class="ti-heart"></i></span>-->
                            <!--            <div class="media-body">-->
                            <!--                <a href="#">-->
                            <!--                    <p><strong>David</strong> purchased Light Dashboard 1.0.</p>-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--            <span class="notify-time">3:20 am</span>-->
                            <!--        </li>-->
                            <!--        <li class="media dropdown-item">-->
                            <!--            <span class="success"><i class="ti-image"></i></span>-->
                            <!--            <div class="media-body">-->
                            <!--                <a href="#">-->
                            <!--                    <p><strong> James.</strong> has added a<strong>customer</strong>-->
                            <!--                        Successfully-->
                            <!--                    </p>-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--            <span class="notify-time">3:20 am</span>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--    <a class="all-notification" href="#">See all notifications <i-->
                            <!--            class="ti-arrow-right"></i></a>-->
                            <!--</div>-->
                            <!--</li>-->
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!--<a href="./app-profile.html" class="dropdown-item">-->
                                    <!--    <i class="icon-user"></i>-->
                                    <!--    <span class="ml-2">Profile </span>-->
                                    <!--</a>-->
                                    <!--<a href="./email-inbox.html" class="dropdown-item">-->
                                    <!--    <i class="icon-envelope-open"></i>-->
                                    <!--    <span class="ml-2">Inbox </span>-->
                                    <!--</a>-->
                                    <a href="./page-login.html" class="dropdown-item">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                </ul>
            </div>
        </div>

        <div class="content-body">
            <div class="container-fluid">
                <!--<div class="row page-titles mx-0">-->
                <!--    <div class="col-sm-6 p-md-0">-->
                <!--        <div class="welcome-text">-->
                <!--            <h4>Hi, welcome back!</h4>-->
                <!--            <p class="mb-0">Your business dashboard template</p>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">-->
                <!--        <ol class="breadcrumb">-->
                <!--            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>-->
                <!--            <li class="breadcrumb-item active"><a href="javascript:void(0)">Components</a></li>-->
                <!--        </ol>-->
                <!--    </div>-->
                <!--</div>-->
                <!-- row -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Declaration Form</h4>
                            </div>
                            <div class="card-body">
                                <form id="multiPageForm" action="formsubmit.php/deceleration" method="POST" enctype="multipart/form-data">
                                    <div class="step-indicator">
                                        <span class="step"></span>
                                        <span class="step"></span>
                                        <span class="step"></span>
                                        <span class="step"></span>
                                    </div>

                                    <div class="form-section" id="section1">
                                        <h4>1. Personal Info</h4>
                                        <div class="form-group">
                                            <label class="text-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">IITB Email (if available)</label>
                                            <input type="email" class="form-control" id="email" name="iitbemail">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Employee No/Student Roll No</label>
                                            <input type="text" class="form-control" id="emp_roll" name="emp_roll">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">University</label>
                                            <input type="text" class="form-control" id="university" name="university" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Aadhar Card</label>
                                            <input type="text" class="form-control" placeholder="Please enter 12 digit Aadhar card number" id="aadhar" name="aadhar" pattern="\d{12}" maxlength="12" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Gender</label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-label">Write About Yourself</label>
                                            <input type="text" class="form-control" placeholder="Write About Your Self" id="aboutuser" name="aboutuser" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Write your Skill Set</label>
                                            <input type="text" class="form-control" placeholder="Write your skill set" id="aboutuser" name="skill" required>
                                        </div>
                                    </div>


                                    <div class="form-section" id="section2">
                                        <h4>2. Address Information</h4>
                                        <div class="form-group">
                                            <label class="text-label">Local Address</label>
                                            <input type="text" class="form-control" id="localadd" name="localadd" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Postal Code</label>
                                            <input type="text" class="form-control" placeholder="6-digit Postal Code" id="localpostalcode" name="localpostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Upload Image</label>
                                            <input type="file" class="form-control" id="image" name="profileimage" accept=".jpg, .jpeg, .png" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Permanent Address</label>
                                            <input type="text" class="form-control" id="permadd" name="permadd" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Permanent Address Postal Code</label>
                                            <input type="text" class="form-control" placeholder="6-digit Postal Code" id="permapostalcode" name="permapostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Home Contact No</label>
                                            <input type="tel" class="form-control" id="homephone" name="homephone" minlength="10" required pattern="\d{10}">
                                        </div>
                                    </div>

                                    <div class="form-section" id="section3">
                                        <h4>Emergency Contact Details (First Person)</h4>
                                        <div class="form-group">
                                            <label class="text-label">Name</label>
                                            <input type="text" class="form-control" id="emergencyname1" name="emergencyname1" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Relationship</label>
                                            <input type="text" class="form-control" id="relationship1" name="relationship1" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Contact No</label>
                                            <input type="tel" class="form-control" id="emephone1" name="emephone1" required pattern="\d{10}">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Contact address (if different from above)</label>
                                            <input type="text" class="form-control" id="localadd_emergency1" name="localadd_emergency1">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Postal Code</label>
                                            <input type="text" class="form-control" placeholder="6-digit Postal Code" id="localpostalcode_emergency1" name="localpostalcode_emergency1" minlength="6" maxlength="6" pattern="\d{6}">
                                        </div>
                                    </div>

                                    <div class="form-section" id="section4">
                                        <h4>Emergency Contact Details (Second Person)</h4>
                                        <div class="form-group">
                                            <label class="text-label">Name</label>
                                            <input type="text" class="form-control" id="emergencyname2" name="emergencyname2" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Relationship</label>
                                            <input type="text" class="form-control" id="relationship2" name="relationship2" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Medical Conditions</label>
                                            <textarea class="form-control" id="medicalcondition" name="medicalcondition" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-navigation">
                                        <button type="button" class="btn btn-secondary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                        <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                        <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">MIP</a>2024</p>
            </div>
        </div>

    </div>
    <script>
        var currentTab = 0;
        showTab(currentTab);

        function showTab(n) {
            var x = document.getElementsByClassName("form-section");
            // hide sections
            for (var i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            // show curent section
            x[n].style.display = "block";

            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }

            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }

            fixStepIndicator(n);
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("form-section");
            if (n == 1 && !validateForm()) return false;
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                document.getElementById("multiPageForm").submit();
                return false;
            }
            showTab(currentTab);
        }

        function validateForm() {
            var x, y, i, valid = true;
            x = document.getElementsByClassName("form-section");
            y = x[currentTab].getElementsByTagName("input");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "" && y[i].hasAttribute('required')) {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid;
        }

        function fixStepIndicator(n) {
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            x[n].className += " active";
        }

        document.getElementById("multiPageForm").addEventListener('input', function(e) {
            if (e.target.tagName.toLowerCase() === 'input') {
                e.target.classList.remove('is-invalid');
            }
        });

        // form submission
        document.getElementById("multiPageForm").onsubmit = function(e) {
            e.preventDefault();
            if (validateForm()) {
                var formData = new FormData(this);
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                alert('Form submitted successfully!');
            } else {
                alert('Please fill in all required fields correctly before submitting.');
            }
        };
    </script>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>



    <script src="./vendor/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="./vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="./js/plugins-init/jquery.validate-init.js"></script>



    <!-- Form step init -->
    <script src="./js/plugins-init/jquery-steps-init.js"></script>



</body>

</html>