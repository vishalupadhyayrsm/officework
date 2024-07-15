<?php
session_start();
include 'dbconfig.php';
// include 'fecthdata.php';
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
    $username = $_SESSION['username'];
    $usertype = $_SESSION['usertype'];
    $sid = $_SESSION['userid'];
    $decform = $_SESSION['decform'];
    // code for checking that if the usertype is staff or not 
    try {
        $sql = "SELECT sg.`sid`,sg.`name`, sg.`email`, sg.`usertype`,sg.`tenureenddate`, sg.`contact`, sg.`cl`, sg.`rh`,sg.`el`, sg.remainingcl, sg.remainingrh,sg.remainingel, sg.declarationform,lt.leaveid, 
        lt.`clstartdate`, lt.`clenddate`,lt.`rhstartdate`, lt.`rhenddate`, lt.`elstartdate`, lt.`elenddate`,  lt.`reason`, lt.`leave_status`,de.declarationform,de.emp_roll,de.`univesity`,de.name,de.iitbemail,
        de.aadhar,de.gender,de.localaddress,de.localpostal,de.permanentadd,de.permpostal, de.homecontact,de.emename1,de.emerelation,de.emeadd,de.emecontact,de.empostalcode,de.emesecondname,de.emesecrelation,de.medicalcondition,de.profilepic
        FROM `sigin` as sg LEFT JOIN leavetable as lt on lt.sid = sg.sid LEFT JOIN declarationform as de on de.sid = sg.sid where sg.sid=:sid ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sid', $sid);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* code for dispalying the gatepass data start here  */
        $sql = "SELECT `gid`,`sid`, `name`, `mobile`, `startdate`, `enddate`, `gender`, `purpose`,`gatepassstatus` FROM `gatepass` where sid=:sid ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sid', $sid);
        $stmt->execute();
        $gatepass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ./login.php");
    exit();
}
$decform = $results[0]['declarationform'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MIP</title>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/logo.png">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        label {
            color: black;
        }
    </style>

</head>

<body>
    <div id="main-wrapper">

        <!-- code for sidebar start here  -->
        <?php include 'sidebar.php' ?>

        <!-- code for main body start here  -->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <!-- Code for dispalying all the form start here -->
                <div class="row">
                    <!-- code for applying form amzon product strat here  -->
                    <?php if ($usertype != 'intern' && $usertype != 'student') { ?>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Apply For Leave Here</h4>

                                </div>
                                <div class="card-body">
                                    <h3 style='font-size: 17px;color: red;'>If you are applying the EL kindly apply here as well as Apply on Drona Also
                                        <a href="https://drona.ircc.iitb.ac.in/ircc/index.jsp?LogOut=You%20have%20been%20logged%20Off%20!" target="_blank" style='color:blue;'>Click Here</a>
                                    </h3>
                                    <form method="post" action="formsubmit.php/leaveapply">
                                        <input type="hidden" name="sid" value="<?php echo $results[0]['sid']; ?>">
                                        <div class="mb-3 mt-3">
                                            <label for="name">CL Start Date:</label>
                                            <input type="date" class="form-control" id="cl_start_date" name="cl_start_date">
                                        </div>

                                        <div class="form-group">
                                            <label for="start_date">CL End Date:</label>
                                            <input type="date" class="form-control" id="cl_end_date" name="cl_end_date">
                                        </div>

                                        <div class="form-group">
                                            <label for="cl_days">No. Of CL:</label>
                                            <input type="number" class="form-control" id="cl_days" name="cl" readonly>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="rh_start_date">RH Start Date:</label>
                                            <input type="date" class="form-control" id="rh_start_date" name="rh_start_date">
                                        </div>
                                        <div class="form-group">
                                            <label for="rh_end_date">RH End Date:</label>
                                            <input type="date" class="form-control" id="rh_end_date" name="rh_end_date">
                                        </div><br>
                                        <div class="mb-3 mt-3">
                                            <label for="rh_days">No. Of RH:</label>
                                            <input type="number" class="form-control" id="rh_days" name="rh" readonly>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="el_start_date">EL Start Date:</label>
                                            <input type="date" class="form-control" id="el_start_date" name="el_start_date">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="el_end_date">EL End Date:</label>
                                            <input type="date" class="form-control" id="el_end_date" name="el_end_date">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="el_days">No. Of EL:</label>
                                            <input type="number" class="form-control" id="el_days" name="el" readonly>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="reason">Reason:</label>
                                            <input type="text" class="form-control" id="reason" name="reason" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- code for applying for amazon product here  start here   -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Order Inventory Here</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="formsubmit.php/amazonproduct" onsubmit="return validatePriceAndQuantity();">
                                    <input type="hidden" name="sid" value="<?php echo $results[0]['sid']; ?>">
                                    <div class="mb-3 mt-3">
                                        <label for="name">Product Name:</label>
                                        <input type="text" class="form-control" id="productname" name="productname" placeholder="Enter name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="start_date">Product Link:</label>
                                        <input type="text" class="form-control" id="productlink" name="productlink" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="end_date">Product Price:</label>
                                        <input type="text" class="form-control" id="productprice" name="prou" required>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="contact">Quantity:</label>
                                        <input type="text" class="form-control" id="quantitytxt" name="quantity" placeholder="Please Enter Quantity" required>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="purpose">Urgency:</label>
                                        <input type="text" class="form-control" id="purpose" name="urgency" placeholder="Purpose" required>
                                    </div>
                                    <!--<button type="submit" name="submit" class="btn btn-primary" onclick="return Validate()">Submit</button>-->
                                    <button type="submit" name="submit" class="btn btn-primary signupbtn" id="myBtn" onclick="return Validate()">Submit</button>
                                    <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if ($usertype !== 'student') { ?>
                        <!-- code for applying for Gate pass start here   -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Apply Gate Pass</h4>
                                    <br>

                                </div>
                                <div class="card-body">
                                    <h3 style='font-size: 17px;color: red;'>Please apply for a gate pass at least one day in advance.</h3>
                                    <form method="post" action="formsubmit.php/gatepass">
                                        <input type="hidden" name="sid" value="<?php echo $results[0]['sid']; ?>">
                                        <div class="mb-3 mt-3">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="start_date">Start Date:</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="end_date">End Date:</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="contact">Contact:</label>
                                            <input type="number" class="form-control" id="contact" name="contact" placeholder="Contact Number" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="gender">Gender:</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="purpose">Purpose:</label>
                                            <input type="text" class="form-control" id="purpose" name="purpose" placeholder="Purpose" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- code for applying for Certficate Start here start here   -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Apply For Certificate </h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="formsubmit.php/certificate">
                                    <input type="hidden" name="sid" value="<?php echo $results[0]['sid']; ?>">
                                    <div class="mb-3 mt-3">
                                        <label for="profname">Professor Name:</label>
                                        <input type="text" class="form-control" id="profname" name="profname" placeholder="Enter name Professor Name" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="pi" name="name" placeholder="Enter Your Certificate Name" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="collegename">College Name:</label>
                                        <input type="text" class="form-control" id="start_date" name="collegename" placeholder="University/College Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="internshipdate">Start Date of Internship:</label>
                                        <input type="date" class="form-control" id="internshipdate" name="internshipdate" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="end_date">End Date of Internship:</label>
                                        <input type="date" class="form-control" id="internshipdate" name="internshipdateend" required>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="point_internship">4-5 points about the project/work done during the Internship:</label>
                                        <input type="text" class="form-control" id="point_internship" name="point_internship" placeholder="Enter what you have learned during your internship ">
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if ($usertype == 'hr' || $usertype == 'admin') { ?>
                        <!-- code for uploading certificate start here-->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Upload Certificate Here</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="formsubmit.php/certificateupload" enctype="multipart/form-data">
                                        <div class="mb-3 mt-3">
                                            <label for="name">Name:</label>
                                            <input class="form-control form-white" type="text" name="cid" value="">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="name">Name:</label>
                                            <input class="form-control form-white" type="file" id="pdf" name="userpdf" accept="application/pdf" required>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                    <!--- code for generic complain start here ---->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" style="color:red;">Generic Complain</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="formsubmit.php/gencomplain" onsubmit="return validatePriceAndQuantity();">
                                    <input type="hidden" name="sid" value="<?php echo $results[0]['sid']; ?>">
                                    <div class="mb-3 mt-3">
                                        <label for="purpose">Please Write What is the issue:</label>
                                        <input type="text" class="form-control" id="issues" name="issues" placeholder="Write your Issues Here" required>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary signupbtn" id="myBtn">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- code for main body ends here  -->

        <!-- code for footer start here  -->
        <!--<div class="footer">-->
        <!--    <div class="copyright">-->
        <!--        <p>Copyright MIP <a href="#" target="_blank"></a>2024</p>-->
        <!--    </div>-->
        <!--</div>-->
        <!-- code for footer ends here  -->

    </div>

    <?php include 'footer.php'; ?>

    <!--**********************************
        Scripts
    ***********************************-->
    <!---code for validating the product price start here  --->
    <script>
        // Function to validate product price and quantity dynamically
        function validatePriceAndQuantity() {
            var productPrice = document.getElementById("productprice").value;
            var quantity = document.getElementById("quantitytxt").value;
            // Calculate total price
            var totalPrice = productPrice * quantity;
            console.log(totalPrice);
            if (totalPrice > 25000) {
                alert("Total product price is higher than 25000.");
                return false;
            }
            return true;
        }
        document.getElementById("myBtn").addEventListener("click", function(event) {
            if (!validatePriceAndQuantity()) {
                event.preventDefault();
            }
        });
        // Attach event listeners to input fields for product price and quantity
        document.getElementById("productprice").addEventListener("input", validatePriceAndQuantity);
        document.getElementById("quantitytxt").addEventListener("input", validatePriceAndQuantity);

        // code for validating total price 
        function validatePriceAndQuantity() {
            var productPrice = document.getElementById("productprice").value;
            var quantity = document.getElementById("quantitytxt").value;
            // Calculate total price
            var totalPrice = productPrice * quantity;
            console.log(totalPrice);
            if (totalPrice > 25000) {
                alert("Total product price is higher than 25000.");
                return false;
            }
            return true;
        }
    </script>
    <!--- code for validating teh leave appliction form ---->
    <script>
        /* code for vaildating the leave application form start here */
        function calculateDays(startDateId, endDateId, daysId) {
            const startDate = document.getElementById(startDateId).value;
            const endDate = document.getElementById(endDateId).value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const timeDiff = end - start;
                const days = timeDiff / (1000 * 3600 * 24) + 1; // +1 to include both start and end date
                document.getElementById(daysId).value = days >= 0 ? days : 0;
            } else {
                document.getElementById(daysId).value = 0; // Set to 0 if dates are not selected
            }
        }

        // Add event listeners for date changes
        document.getElementById('cl_start_date').addEventListener('change', () => calculateDays('cl_start_date', 'cl_end_date', 'cl_days'));
        document.getElementById('cl_end_date').addEventListener('change', () => calculateDays('cl_start_date', 'cl_end_date', 'cl_days'));

        document.getElementById('rh_start_date').addEventListener('change', () => calculateDays('rh_start_date', 'rh_end_date', 'rh_days'));
        document.getElementById('rh_end_date').addEventListener('change', () => calculateDays('rh_start_date', 'rh_end_date', 'rh_days'));

        document.getElementById('el_start_date').addEventListener('change', () => calculateDays('el_start_date', 'el_end_date', 'el_days'));
        document.getElementById('el_end_date').addEventListener('change', () => calculateDays('el_start_date', 'el_end_date', 'el_days'));

        // Initial setting of days to zero
        document.getElementById('cl_days').value = 0;
        document.getElementById('rh_days').value = 0;
        document.getElementById('el_days').value = 0;

        // Function to set default dates if not selected
        function setDefaultDates() {
            const dateFields = ['cl_start_date', 'cl_end_date', 'rh_start_date', 'rh_end_date', 'el_start_date', 'el_end_date'];
            dateFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value) {
                    field.value = '0000-00-00';
                }
            });
        }

        // Add event listener for form submission
        document.querySelector('.form_data').addEventListener('submit', setDefaultDates);
    </script>




    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>


    <!-- Vectormap -->
    <script src="./vendor/raphael/raphael.min.js"></script>
    <script src="./vendor/morris/morris.min.js"></script>

    <script src="./vendor/circle-progress/circle-progress.min.js"></script>
    <script src="./vendor/chart.js/Chart.bundle.min.js"></script>

    <script src="./vendor/gaugeJS/dist/gauge.min.js"></script>

    <!--  flot-chart js -->
    <script src="./vendor/flot/jquery.flot.js"></script>
    <script src="./vendor/flot/jquery.flot.resize.js"></script>

    <!-- Owl Carousel -->
    <script src="./vendor/owl-carousel/js/owl.carousel.min.js"></script>

    <!-- Counter Up -->
    <script src="./vendor/jqvmap/js/jquery.vmap.min.js"></script>
    <script src="./vendor/jqvmap/js/jquery.vmap.usa.js"></script>
    <script src="./vendor/jquery.counterup/jquery.counterup.min.js"></script>


    <script src="./js/dashboard/dashboard-1.js"></script>





</body>

</html>