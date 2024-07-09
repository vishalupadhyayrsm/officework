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
    // echo $usertype;
    // if ($usertype == "system") {
    //     header("Location: ../system");
    // }
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
                    <?php if ($usertype == 'staff') { ?>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Apply For Leave Here</h4>
                                </div>
                                <div class="card-body">
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
                    <!-- code for applying for Gate pass start here   -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Apply Gate Pass</h4>
                            </div>
                            <div class="card-body">
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
                    <!-- code for applying for Gate pass start here   -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Apply for Amazon Product Here</h4>
                            </div>
                            <div class="card-body">
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
                </div>

            </div>
        </div>
        <!-- code for main body ends here  -->

        <!-- code for footer start here  -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright MIP <a href="#" target="_blank"></a>2024</p>
            </div>
        </div>
        <!-- code for footer ends here  -->

    </div>



    <!--**********************************
        Scripts
    ***********************************-->
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