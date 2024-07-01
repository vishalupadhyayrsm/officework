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
                <marquee behavior="scroll" direction="left" scrollamount="6" class="allimp_notice" style="color:red;">
                    Please fill all the details very carefully.
                </marquee>
                <!-- Code for dispalying all the form start here -->
                <div class="row">
                    <div class='col-lg-2'></div>
                    <!-- code for applying Resignation start here  -->
                    <div class="col-lg-8">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">Resignation Form</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="formsubmit.php/resign">
                                    <input type="hidden" name="sid" value="<?php echo $decform = $results[0]['sid']; ?>">
                                    <div class="mb-3 mt-3">
                                        <label for="pi">Principal Investigator (PI):</label>
                                        <input type="text" class="form-control" id="pi" name="principle" placeholder="PI name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="end_date">Termination Date:</label>
                                        <input type="date" class="form-control" id="end_date" name="termination_date" required>
                                    </div><br>

                                    <div class="mb-3 mt-3">
                                        <label for="startposition">Starting Position:</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter your designation" name="start_postion">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="endingposition">Ending Position:</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter you ending designation" name="ending_postion">
                                    </div>

                                    <div class="mb-3">
                                        <label for="reason_leaving">REASONS FOR LEAVING:</label>
                                        <select class="form-control" id="reason_leaving" name="reason_leaving">
                                            <option value="Took another position">Took another position </option>
                                            <option value="Dissatisfaction with salary">Dissatisfaction with salary</option>
                                            <option value="Pregnancy/home/family needs">Pregnancy/home/family needs</option>
                                            <option value="Dissatisfaction with type of work">Dissatisfaction with type of work</option>
                                            <option value="Poor health/physical disability">Poor health/physical disability</option>
                                            <option value="Dissatisfaction with supervisor">Dissatisfaction with supervisor</option>
                                            <option value="Relocation to another city">Relocation to another city</option>
                                            <option value="Dissatisfaction with co-workers">Dissatisfaction with co-workers</option>
                                            <option value="Travel difficulties">Travel difficulties</option>
                                            <option value="Dissatisfaction with working conditions">Dissatisfaction with working conditions</option>
                                            <option value="To attend school">To attend school</option>
                                            <option value="Dissatisfaction with benefits">Dissatisfaction with benefits</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="PlansAfterLeaving">Plans After Leaving:</label>
                                        <input type="text" class="form-control" id="planafterleaving" placeholder="Plans after leaving" name="planafterleaving">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="imporove_suggestion">COMMENTS/SUGGESTIONS FOR IMPROVEMENT:</label>
                                        <input type="text" class="form-control" id="imporove_suggestion" placeholder="Suggest us what to imporove" name="imporove_suggestion">
                                    </div>

                                    <h2 style="font-size: 22px; font-weight:bold;">
                                        We are interested in what our employees have to say about their work experience with Please Share your Experienace
                                    </h2>
                                    <div class="mb-3 mt-3">
                                        <label for="what_mostlike">What did you like most about your job?:</label>
                                        <input type="text" class="form-control" id="what_mostlike" placeholder="What you like here most" name="what_mostlike">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="what_leastlike">What did you like least about your job?:</label>
                                        <input type="text" class="form-control" id="what_leastlike" placeholder="What you like least here" name="what_leastlike">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="taking_anotherjob"> If you are taking another job, what kind of work will you be doing? :</label>
                                        <input type="text" class="form-control" id="taking_anotherjob" placeholder="Describe your next Job" name="taking_anotherjob">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="new_place_job">What has your new place of employment offered you that is more attractive than your present job? :</label>
                                        <input type="text" class="form-control" id="new_place_job" placeholder="New job place" name="new_place_job">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="improvement">Could the Centre have made any improvements that might have influenced you to work better?:</label>
                                        <input type="text" class="form-control" id="improvement" placeholder="Enter your improvement" name="improvement">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="otherremark">Other Remakrs:</label>
                                        <input type="text" class="form-control" id="otherremarks" placeholder="Other Remarks" name="otherremarks">
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label for="improvement">Have you returned the following to the Centre (Tick as appropriate):</label>

                                        <div class="form-check">
                                            <label class="form-check-label" for="Drawer">Drawer keys</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="Drawer_yesno" id="Drawer_yes" value="yes">
                                                <label class="form-check-label" for="Drawer_yes" style="margin-top:0px;">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="Drawer_yesno" id="Drawer_no" value="no">
                                                <label class="form-check-label" for="Drawer_no" style="margin-top:0px;">No</label>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label" for="Cupboard Keys">Cupboard Keys</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="CupboardKeys_yesno" id="Cupboard Keys_yes" value="yes">
                                                <label class="form-check-label" for="Cupboard Keys_yes" style="margin-top:0px;">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="CupboardKeys_yesno" id="Cupboard Keys_no" value="no">
                                                <label class="form-check-label" for="Cupboard Keys_no" style="margin-top:0px;">No</label>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label" for="labbook">Lab books returned</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="labbookyesno" id="labbookyes" value="yes">
                                                <label class="form-check-label" for="labbookyes" style="margin-top:0px;">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="labbookyesno" id="labbookno" value="no">
                                                <label class="form-check-label" for="labbookno" style="margin-top:0px;">No</label>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="hardware">Laptop, hard drive, pendrive, etc</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hardwareno" id="hardware" value="yes">
                                                <label class="form-check-label" for="hardware" style="margin-top:0px;">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hardwareno" id="labbookno" value="no">
                                                <label class="form-check-label" for="labbookno" style="margin-top:0px;">No</label>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label" for="tools">Tools used/unused</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="toolsno" id="tools" value="yes">
                                                <label class="form-check-label" for="tools" style="margin-top:0px;">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="toolsno" id="labbookno" value="no">
                                                <label class="form-check-label" for="labbookno" style="margin-top:0px;">No</label>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label" for="anyothers">Any other office hardware</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="anyothersno" id="anyothers" value="yes">
                                                <label class="form-check-label" for="anyothers">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="anyothersno" id="labbookno" value="no">
                                                <label class="form-check-label" for="labbookno" style="margin-top:0px;">No</label>
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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