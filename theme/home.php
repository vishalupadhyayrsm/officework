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

    try {
        $sql = "SELECT sg.`sid`, sg.`declarationform`, sg.`name`, sg.`email`, sg.`usertype`, sg.`contact`, sg.`cl`, sg.`rh`, sg.`el`, sg.remainingcl, sg.remainingrh, sg.remainingel, sg.declarationform, lt.leaveid, lt.`reason`, lt.`clstartdate`, lt.`clenddate`, lt.`rhstartdate`, lt.`rhenddate`, lt.`elstartdate`, lt.`elenddate`, lt.`leave_status`, counts.total_records, counts.student_count, counts.staff_count, counts.intern_count
            FROM sigin AS sg LEFT JOIN leavetable AS lt ON lt.sid = sg.sid CROSS JOIN ( SELECT COUNT(sg.sid) AS total_records, SUM(CASE WHEN sg.usertype = 'student' THEN 1 ELSE 0 END) AS student_count, SUM(CASE WHEN sg.usertype = 'staff' THEN 1 ELSE 0 END) AS staff_count, SUM(CASE WHEN sg.usertype = 'intern' THEN 1 ELSE 0 END) AS intern_count FROM sigin AS sg ) AS counts";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* code for fecthing teh userdeatils start here  */
        $sql = "SELECT `sid`, `name`, `email`,`empcode`,`password`,`startdate`,`enddate`,`userstatus`,`tenureenddate`, `usertype`, `contact`, `cl`, `rh`, `remainingcl`, `remainingrh`, `year`, `declarationform`, `resign` FROM `sigin`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $userdetails = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /* code for fecthing the certificate details start here */
        $sql = "SELECT `cid`, `sid`, `piname`, `username`,`start_date`,`end_date`,`certificatestatus`, `collegename`, `workdone`,`userresponse` FROM `certificate`";
        // $sql = 'SELECT sg.`certificatestatus`, ce.`cid`, ce.`sid`, ce.`piname`, ce.`username`, ce.`start_date`, ce.`end_date`, ce.`certificatestatus` AS `ce_certificatestatus`, ce.`collegename`, ce.`workdone` FROM `sigin` AS sg LEFT JOIN `certificate` AS ce ON ce.`sid` = sg.`sid`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $certificate = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* code for fecthing the gate pass data start here */
        $sql = "SELECT `rid`, `sid`, `pi_name`, `start_date`, `terminationdate`, `startingposition`, `endingpostion`, `reason_leaving`, `planafterleaving`, `imporove_suggestion`, `what_mostlike`, `what_leastlike`, `taking_anotherjob`, `new_place_job`, `improvement`, `Drawer_yesno`, `CupboardKeys_yesno`, `labbookyesno`, `hardwareno`,`otherremarks`, `anyothersno`,`resignstatus` FROM `resigndata`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resign = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* code for dispalying the  gate pass start here  */
        $sql = "SELECT `gid`,`sid`, `name`, `mobile`, `startdate`, `enddate`, `gender`, `purpose`,`gatepassstatus` FROM `gatepass`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $gatepass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ./index.php");
    exit();
}

$decform = $results[0]['declarationform'];
if ($decform !== 'yes') {
    header("Location: ./decform.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MIP</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/logo.png">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        th,
        td {
            color: black;
        }
    </style>
</head>

<body>

    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <?php include 'sidebar.php' ?>

        <!-- code for main body start here  -->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <?php if ($usertype !== 'admin') { ?>
                    <div class="row page-titles mx-0">
                        <div class="col-sm-6 p-md-0">
                            <div class="welcome-text">
                                <h4>Hi, welcome back! HR</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
                            </ol>
                        </div>
                    </div>
                <?php } ?>
                <!-- code for displaying the user detials here  -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total No of User</div>
                                    <div class="stat-digit"><?php echo $results[0]['total_records'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total Staff</div>
                                    <div class="stat-digit"><?php echo $results[0]['staff_count'] ?></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total Intern</div>
                                    <div class="stat-digit"><?php echo $results[0]['intern_count'] ?></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total Student</div>
                                    <div class="stat-digit"><?php echo $results[0]['student_count'] ?></div>
                                </div>

                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                </div>

                <div class="row">
                    <!-- code for user dispalying user details start here  -->
                    <?php if ($usertype == 'hr' || $usertype == 'admin' || $usertype == 'account') { ?>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">User Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-8">
                                            <div id="userdetails"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($usertype == 'hr' || $usertype == 'account') { ?>
                        <!-- code for dispalying the leave status start here  -->
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Leave Status</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-8">
                                            <div id="leave"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- code for dispalying the user details, certificate  and resign list start here  -->
                <div class="row">
                    <?php if ($usertype == 'hr' || $usertype == 'admin') { ?>
                        <!-- code for displaying the certificate start here  -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">All Certificate list</h4>
                                    <a href="javascript:void()" data-toggle="modal" data-target="#sendcertificate" class="btn btn-primary btn-event w-20">
                                        <span class="align-middle"></span>Send Certificate
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div id="certificate"></div>
                                </div>
                            </div>
                        </div>
                        <!-- code for sedning certifciate start  here  -->
                        <div class="modal fade none-border" id="sendcertificate">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><strong>Send Certificate</strong></h4>
                                        <!--<button id="openPopupBtncertficiate">Send Certificate</button>-->
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="formsubmit.php/sendcertificate" enctype="multipart/form-data">
                                            <input type="hidden" name="sid" value="<?php echo htmlspecialchars($results[0]['sid']); ?>">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label">Name</label>
                                                    <input class="form-control form-white" placeholder="Enter name" type="text" id="name" name="name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Email</label>
                                                    <input class="form-control form-white" placeholder="Enter Email" type="email" id="email" name="email" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="pdf">Select PDF:</label>
                                                    <input class="form-control form-white" type="file" id="pdf" name="pdf" accept="application/pdf" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" name="submit" class="btn btn-danger waves-effect waves-light save-category">Send</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!---- code for  sendieng teh certificate start here --->
                                    <!--   <div id="popupForm" class="popup">-->
                                    <!--    <div class="popup-content">-->
                                    <!--        <span class="close">&times;</span>-->
                                    <!--        <form method="post" action="formsubmit.php/sendcertificate" enctype="multipart/form-data">-->
                                    <!--            <input type="hidden" name="sid" value="<?php echo htmlspecialchars($results[0]['sid']); ?>">-->
                                    <!--            <label for="email">Email:</label>-->
                                    <!--            <input type="email" id="email" name="email" required>-->
                                    <!--            <label for="name">Name:</label>-->
                                    <!--            <input type="text" id="name" name="name" required>-->

                                    <!--            <label for="pdf">Select PDF:</label>-->
                                    <!--            <input type="file" id="pdf" name="pdf" accept="application/pdf" required>-->

                                    <!--            <button type="submit" name="submit">Send</button>-->
                                    <!--        </form>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                            </div>
                        </div>
                        <!-- code for sending certificate ends here  -->
                        <!-- code for dispalying  certificate ends here  -->

                        <!-- code for dispalying the new certificate list start as notification -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">New Certificate Request</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-table-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- code for dispalying the gate pass start here  -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gate Pass</h4>
                                <!-- <button id="openPopupBtn" class='badge badge-success'>Send Gate Pass</button> -->
                                <a href="javascript:void()" data-toggle="modal" data-target="#gatepassdata" class="btn btn-primary btn-event w-20">
                                    <span class="align-middle"></span>Send Gate Pass
                                </a>
                            </div>
                            <div class="card-body">
                                <!-- <div id="vmap13" class="vmap"></div> -->
                                <div id="gatepass"></div>
                            </div>
                        </div>
                    </div>
                    <!-- code for sedning gate pass start  here  -->
                    <div class="modal fade none-border" id="gatepassdata">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><strong>Send Gate Pass</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="formsubmit.php/sendgatepass" enctype="multipart/form-data">
                                        <input type="hidden" name="sid" value="<?php echo htmlspecialchars($results[0]['sid']); ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Name</label>
                                                <input class="form-control form-white" placeholder="Enter name" type="text" id="name" name="name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Email</label>
                                                <input class="form-control form-white" placeholder="Enter Email" type="email" id="email" name="email" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pdf">Select PDF:</label>
                                                <input class="form-control form-white" type="file" id="pdf" name="pdf" accept="application/pdf" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                            <button type="submit" name="submit" class="btn btn-danger waves-effect waves-light save-category">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- code for sending gate pass ends here  -->


                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">New Gate Paass Request</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Purpose</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="newgatepass"></tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- code for dispalying the resignation list start here  -->
                    <?php if ($usertype == 'hr' || $usertype == 'admin') { ?>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Resignation List</h4>
                                </div>
                                <div class="card-body">
                                    <!-- <div id="vmap13" class="vmap"></div> -->
                                    <div id="resign"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">New Resignation</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>PI Name</th>
                                                    <th>Product</th>
                                                    <th>quantity</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="newresign"></tbody>
                                            <!--<tbody>-->
                                            <!--    <tr>-->
                                            <!--        <td>-->
                                            <!--            <div class="round-img">-->
                                            <!--                <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>-->
                                            <!--            </div>-->
                                            <!--        </td>-->
                                            <!--        <td>Lew Shawon</td>-->
                                            <!--        <td><span>Dell-985</span></td>-->
                                            <!--        <td><span>456 pcs</span></td>-->
                                            <!--        <td><span class="badge badge-success">Done</span></td>-->
                                            <!--    </tr>-->
                                            <!--    <tr>-->
                                            <!--        <td>-->
                                            <!--            <div class="round-img">-->
                                            <!--                <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>-->
                                            <!--            </div>-->
                                            <!--        </td>-->
                                            <!--        <td>Lew Shawon</td>-->
                                            <!--        <td><span>Asus-565</span></td>-->
                                            <!--        <td><span>456 pcs</span></td>-->
                                            <!--        <td><span class="badge badge-warning">Pending</span></td>-->
                                            <!--    </tr>-->
                                            <!--    <tr>-->
                                            <!--        <td>-->
                                            <!--            <div class="round-img">-->
                                            <!--                <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>-->
                                            <!--            </div>-->
                                            <!--        </td>-->
                                            <!--        <td>lew Shawon</td>-->
                                            <!--        <td><span>Dell-985</span></td>-->
                                            <!--        <td><span>456 pcs</span></td>-->
                                            <!--        <td><span class="badge badge-success">Done</span></td>-->
                                            <!--    </tr>-->
                                            <!--</tbody>-->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>



                <!--<div class="row">-->
                <!--    <div class="col-lg-6 col-xl-4 col-xxl-6 col-md-6">-->
                <!--        <div class="card">-->
                <!--            <div class="card-header">-->
                <!--                <h4 class="card-title">Timeline</h4>-->
                <!--            </div>-->
                <!--            <div class="card-body">-->
                <!--                <div class="widget-timeline">-->
                <!--                    <ul class="timeline">-->
                <!--                        <li>-->
                <!--                            <div class="timeline-badge primary"></div>-->
                <!--                            <a class="timeline-panel text-muted" href="#">-->
                <!--                                <span>10 minutes ago</span>-->
                <!--                                <h6 class="m-t-5">Youtube, a video-sharing website, goes live.</h6>-->
                <!--                            </a>-->
                <!--                        </li>-->

                <!--                        <li>-->
                <!--                            <div class="timeline-badge warning">-->
                <!--                            </div>-->
                <!--                            <a class="timeline-panel text-muted" href="#">-->
                <!--                                <span>20 minutes ago</span>-->
                <!--                                <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>-->
                <!--                            </a>-->
                <!--                        </li>-->

                <!--                        <li>-->
                <!--                            <div class="timeline-badge danger">-->
                <!--                            </div>-->
                <!--                            <a class="timeline-panel text-muted" href="#">-->
                <!--                                <span>30 minutes ago</span>-->
                <!--                                <h6 class="m-t-5">Google acquires Youtube.</h6>-->
                <!--                            </a>-->
                <!--                        </li>-->

                <!--                        <li>-->
                <!--                            <div class="timeline-badge success">-->
                <!--                            </div>-->
                <!--                            <a class="timeline-panel text-muted" href="#">-->
                <!--                                <span>15 minutes ago</span>-->
                <!--                                <h6 class="m-t-5">StumbleUpon is acquired by eBay. </h6>-->
                <!--                            </a>-->
                <!--                        </li>-->

                <!--                        <li>-->
                <!--                            <div class="timeline-badge warning">-->
                <!--                            </div>-->
                <!--                            <a class="timeline-panel text-muted" href="#">-->
                <!--                                <span>20 minutes ago</span>-->
                <!--                                <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>-->
                <!--                            </a>-->
                <!--                        </li>-->

                <!--                        <li>-->
                <!--                            <div class="timeline-badge dark">-->
                <!--                            </div>-->
                <!--                            <a class="timeline-panel text-muted" href="#">-->
                <!--                                <span>20 minutes ago</span>-->
                <!--                                <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>-->
                <!--                            </a>-->
                <!--                        </li>-->

                <!--                        <li>-->
                <!--                            <div class="timeline-badge info">-->
                <!--                            </div>-->
                <!--                            <a class="timeline-panel text-muted" href="#">-->
                <!--                                <span>30 minutes ago</span>-->
                <!--                                <h6 class="m-t-5">Google acquires Youtube.</h6>-->
                <!--                            </a>-->
                <!--                        </li>-->
                <!--                    </ul>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--    <div class="col-xl-4 col-xxl-6 col-lg-6 col-md-6 col-sm-12">-->
                <!--        <div class="card">-->
                <!--            <div class="card-header">-->
                <!--                <h4 class="card-title">Todo</h4>-->
                <!--            </div>-->
                <!--            <div class="card-body px-0">-->
                <!--                <div class="todo-list">-->
                <!--                    <div class="tdl-holder">-->
                <!--                        <div class="tdl-content widget-todo mr-4">-->
                <!--                            <ul id="todo_list">-->
                <!--                                <li><label><input type="checkbox"><i></i><span>Get up</span><a href='#' class="ti-trash"></a></label></li>-->
                <!--                                <li><label><input type="checkbox" checked><i></i><span>Stand up</span><a href='#' class="ti-trash"></a></label></li>-->
                <!--                                <li><label><input type="checkbox"><i></i><span>Don't give up the-->
                <!--                                            fight.</span><a href='#' class="ti-trash"></a></label></li>-->
                <!--                                <li><label><input type="checkbox" checked><i></i><span>Do something-->
                <!--                                            else</span><a href='#' class="ti-trash"></a></label></li>-->
                <!--                                <li><label><input type="checkbox" checked><i></i><span>Stand up</span><a href='#' class="ti-trash"></a></label></li>-->
                <!--                                <li><label><input type="checkbox"><i></i><span>Don't give up the-->
                <!--                                            fight.</span><a href='#' class="ti-trash"></a></label></li>-->
                <!--                            </ul>-->
                <!--                        </div>-->
                <!--                        <div class="px-4">-->
                <!--                            <input type="text" class="tdl-new form-control" placeholder="Write new item and hit 'Enter'...">-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--    <div class="col-sm-12 col-md-12 col-xxl-6 col-xl-4 col-lg-6">-->
                <!--        <div class="card">-->
                <!--            <div class="card-header">-->
                <!--                <h4 class="card-title">Product Sold</h4>-->
                <!--                <div class="card-action">-->
                <!--                    <div class="dropdown custom-dropdown">-->
                <!--                        <div data-toggle="dropdown">-->
                <!--                            <i class="ti-more-alt"></i>-->
                <!--                        </div>-->
                <!--                        <div class="dropdown-menu dropdown-menu-right">-->
                <!--                            <a class="dropdown-item" href="#">Option 1</a>-->
                <!--                            <a class="dropdown-item" href="#">Option 2</a>-->
                <!--                            <a class="dropdown-item" href="#">Option 3</a>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--            <div class="card-body">-->
                <!--                <div class="chart py-4">-->
                <!--                    <canvas id="sold-product"></canvas>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->

                <!--</div>-->

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

    <!-- code for leave status start here -->
    <script>
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($results); ?>;
            var columns = [{
                    title: "User Name",
                    field: "name",
                    headerFilter: true
                    // visible: <?php echo ($usertype == 'user') ? 'true' : 'true'; ?>,
                },
                {
                    title: "Total CL",
                    field: "cl",
                    headerFilter: true,
                },
                {
                    title: "Total RH",
                    field: "rh",
                    headerFilter: true
                },
                {
                    title: "Remaining CL",
                    field: "remainingcl",
                    headerFilter: true
                },
                {
                    title: "Remaining RH",
                    field: "remainingrh",
                    headerFilter: true
                },
                {
                    title: "Reason For Leave",
                    field: "reason",
                    headerFilter: true
                },

                {
                    title: "CL Start Date",
                    field: "clstartdate",
                    headerFilter: true
                },
                {
                    title: "CL End Date",
                    field: "clenddate",
                    headerFilter: true
                },
                {
                    title: "RH Start Date",
                    field: "rhstartdate",
                    headerFilter: true
                },
                {
                    title: "RH End Date",
                    field: "rhenddate",
                    headerFilter: true
                },
                {
                    title: "EL Start Date",
                    field: "elstartdate",
                    headerFilter: true
                },
                {
                    title: "EL End Date",
                    field: "elenddate",
                    headerFilter: true
                },
            ];

            // code for updating the user leave status start here 
            columns.push({
                title: "Leave Status",
                field: "leave_status",
                headerFilter: true,
                formatter: function(cell, formatterParams, onRendered) {
                    var value = cell.getValue();
                    var cellEl = cell.getElement();
                    var row = cell.getRow();
                    if (value === 'yes') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('green-row');
                        return 'Approved';
                    } else if (value === 'no') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('red-row');
                        return 'Denied';
                    } else {
                        <?php if ($usertype == 'hr' || $usertype == 'account') : ?>
                            var dropdown = document.createElement('select');
                            dropdown.classList.add('form-control');
                            dropdown.innerHTML = `
                                        <option value="">Select</option>
                                        <option value="yes">Approved</option>
                                        <option value="no">Dissapproved</option>
                                    `;
                            // Add event listener to the dropdown
                            dropdown.addEventListener('change', function(event) {
                                var selectedValue = event.target.value;
                                var cellData = cell.getData();
                                var username = cellData.name;
                                var sid = cellData.sid;
                                var lid = cellData.leaveid;
                                console.log(lid, selectedValue, sid, username);
                                /* cdoe for calculating the differnec between the leave apply  */
                                function calculateDateDifference(startDate, endDate) {
                                    var start = new Date(startDate);
                                    var end = new Date(endDate);
                                    if (start.getTime() === end.getTime()) {
                                        return 1;
                                    }
                                    var timeDifference = end - start;
                                    var dayDifference = timeDifference / (1000 * 60 * 60 * 24);
                                    // console.log(dayDifference)
                                    if (dayDifference === 0) {
                                        dayDifference = 1;
                                    }
                                    return dayDifference;
                                }
                                // console.log()
                                var clDateDifference = calculateDateDifference(cellData.clstartdate, cellData.clenddate);
                                var rhDateDifference = calculateDateDifference(cellData.rhstartdate, cellData.rhenddate);
                                if (isNaN(rhDateDifference) || rhDateDifference === "") {
                                    rhDateDifference = 0;
                                }
                                // console.log("CL Date Difference: " + clDateDifference + " days");
                                // console.log("RH Date Difference: " + rhDateDifference + " days");


                                updatestatus(lid, selectedValue, sid, username, clDateDifference, rhDateDifference);
                            });

                            return dropdown;
                        <?php else : ?>
                            return '';
                        <?php endif; ?>
                    }
                }
            });

            // function for updating the leave status start here 
            function updatestatus(lid, selectedValue, sid, username, clDateDifference, rhDateDifference) {
                console.log(lid, selectedValue, sid, username, clDateDifference, rhDateDifference);
                fetch('formsubmit.php/leaveapproved', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },

                        body: 'lid=' + encodeURIComponent(lid) + '&status=' + encodeURIComponent(selectedValue) +
                            '&cl=' + encodeURIComponent(clDateDifference) + '&rh=' + encodeURIComponent(rhDateDifference) +
                            '&sid=' + encodeURIComponent(sid)
                    })
                    .then(response => response.text())
                    .then(data => {
                        // console.log(data);
                        // alert("Leave Status Updated Successfully")
                        //   console.log('Database update successful:', data);
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }

            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#leave", {
                data: results,
                layout: "fitData",
                columns: columns,
                pagination: "local",
                paginationSize: pageSize,
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage,
            });
            // Add the following code to initialize pagination buttons
            var prevPageBtn = document.querySelector('.pagination-btn:first-of-type');
            var nextPageBtn = document.querySelector('.pagination-btn:last-of-type');

            if (prevPageBtn && nextPageBtn) {
                prevPageBtn.addEventListener('click', function() {
                    table.previousPage();
                });

                nextPageBtn.addEventListener('click', function() {
                    table.nextPage();
                });
            }
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>

    <!-- script for dispalying the user details start here   -->
    <script>
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($userdetails); ?>;
            var columns = [{
                    title: "User Name",
                    field: "name",
                    headerFilter: true,
                    formatter: function(cell) {
                        var userName = cell.getValue();
                        var userData = cell.getRow().getData();
                        var userId = userData.id;
                        var sid = userData.sid;
                        var emailid = userData.emailid;

                        return '<a href="profile.php?sid=' + sid + '" target="_blank" style="color: black;font-weight: bold;">' + userName + '</a>';
                    }
                },

                {
                    title: "Email",
                    field: "email",
                    headerFilter: true
                }, {
                    title: "IITB Email",
                    field: "email",
                    headerFilter: true
                }, {
                    title: "Staff / Intern / Student",
                    field: "usertype",
                    headerFilter: true
                }, {
                    title: "Contact No",
                    field: "contact",
                    headerFilter: true
                }, {
                    title: "Joining Date",
                    field: "startdate",
                    headerFilter: true
                }, {
                    title: "Deceleration Form",
                    field: "declarationform",
                    headerFilter: true
                }, {
                    title: "Employee Code",
                    field: "empcode",
                    headerFilter: true,
                    editor: <?php echo ($usertype == 'hr' || $usertype == 'admin') ? "'input'" : "false"; ?>,
                    cellEdited: function(cell) {
                        var userId = cell.getData().sid;
                        var newValue = cell.getValue();
                        console.log(userId, newValue);
                        updateempcode(userId, newValue);
                    }
                },
                {
                    title: "Tenure End Date",
                    field: "tenureenddate",
                    headerFilter: true,
                    editor: <?php echo ($usertype == 'hr' || $usertype == 'admin') ? "'input'" : "false"; ?>,
                    cellEditing: function(cell) {
                        var originalValue = cell.getValue();
                        console.log("Original tenure end date:", originalValue);
                    },
                    cellEdited: function(cell) {
                        var userId = cell.getData().sid;
                        var newValue = cell.getValue();
                        var row = cell.getRow();
                        console.log(userId, newValue, row);
                        // Update tenure end date
                        updateemptenure(userId, newValue);
                        var dateParts = newValue.split("/");
                        if (dateParts.length === 3) {
                            var day = parseInt(dateParts[0], 10);
                            var month = parseInt(dateParts[1], 10) - 1;
                            var year = parseInt(dateParts[2], 10);
                            var enteredDate = new Date(year, month, day);
                            if (!isNaN(enteredDate.getTime())) {
                                var currentDate = new Date();
                                var timeDiff = enteredDate - currentDate;
                                var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                                if (daysDiff < 15) {
                                    cell.getElement().style.backgroundColor = "red";
                                } else {
                                    cell.getElement().style.backgroundColor = "";
                                }
                            } else {
                                console.error("Invalid date format entered:", newValue);
                                cell.getElement().style.backgroundColor = "";
                            }
                        } else {
                            console.error("Invalid date format entered:", newValue);
                            cell.getElement().style.backgroundColor = "";
                        }
                    }
                },

                {
                    title: "Resign Date",
                    field: "enddate",
                    headerFilter: true
                },
            ];


            <?php if ($usertype == 'hr' || $usertype == 'admin') : ?>
                columns.push({
                    title: "Approved/Disapproved User",
                    field: "userstatus",
                    headerFilter: true,
                    formatter: function(cell, formatterParams, onRendered) {
                        var value = cell.getValue();
                        var buttonText = value === 'yes' ? 'Approved' : 'Disapproved';
                        var buttonColor = value === 'yes' ? 'btn-success' : 'btn-danger';
                        var buttonHTML = '<button type="button" class="btn ' + buttonColor + '" style="width: 100%;">' + buttonText + '</button>';
                        return buttonHTML;
                    },
                    cellClick: function(e, cell) {
                        var currentValue = cell.getValue();
                        var newValue = currentValue === 'yes' ? 'no' : 'yes';
                        cell.setValue(newValue);
                        var userId = cell.getData().sid;
                        // console.log(newValue, userId)
                        updateApprovalStatus(userId, newValue);
                    }
                });
            <?php endif; ?>

            //code for assigning teh user 
            <?php if ($usertype == 'admin') : ?>
                columns.push({
                    title: "Assign User ",
                    field: "usertype",
                    headerFilter: true,
                    formatter: function(cell, formatterParams, onRendered) {
                        var value = cell.getValue();
                        var dropdownHTML = `
                        <select class="form-select" style="width: 100%;" onchange="assignUserData(${cell.getData().sid}, this.value)">
                            <option value="" ${value ? '' : 'selected'}>Select Role</option>
                            <option value="hr" ${value === 'hr' ? 'selected' : ''}>HR</option>
                            <option value="account" ${value === 'account' ? 'selected' : ''}>Account</option>
                            <option value="purchase" ${value === 'purchase' ? 'selected' : ''}>Purchase</option>
                            <option value="system" ${value === 'system' ? 'selected' : ''}>System</option>
                        </select>`;
                        return dropdownHTML;
                    }
                });
            <?php endif; ?>


            // code for assigning user to partiualr access
            function assignUserData(userId, newValue) {
                fetch('formsubmit.php/assignuser', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.text())
                    .then(data => {
                        var datavalue = data.data;
                        if (datavalue === 'no') {
                            alert("User Cannot be assigned");
                        } else {
                            alert("User Successfully Assigned");
                            window.location.href = '../home.php'
                        }
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }


            // function for approved or disapproved user 
            function updateApprovalStatus(userId, newValue) {
                fetch('formsubmit.php/userapproved', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.json())
                    .then(data => {
                        var datavalue = data.data;
                        if (datavalue == 'no') {
                            alert("User Successfully Disapproved");
                            // window.location.href = "../index1.php";
                        } else {
                            alert("User Successfully Approved");
                            // window.location.href = "index1.php";
                        }
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }
            /* code for sending the update empcode */
            function updateempcode(userId, newValue) {
                fetch('formsubmit.php/updateempcode', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.text())
                    .then(data => {
                        var datavalue = data.data;
                        console.log(datavalue);
                        if (datavalue == 'no') {
                            alert("Employee Code not updated");
                            // window.location.href = "../index1.php";
                        } else {
                            alert("Employee Code Successfully Update");
                            // window.location.href = "index1.php";
                        }
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }
            /* code for updating the tenure in th database by admin */
            function updateemptenure(userId, newValue) {
                fetch('formsubmit.php/updateemptenure', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.json())
                    .then(data => {
                        var datavalue = data.data;
                        console.log(datavalue);
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }
            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#userdetails", {
                data: results,
                layout: "fitData",
                columns: columns,
                pagination: "local", // Enable local pagination
                paginationSize: pageSize, // Number of rows per page
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage, // Initial page
            });
            // Add the following code to initialize pagination buttons
            var prevPageBtn = document.querySelector('.pagination-btn:first-of-type');
            var nextPageBtn = document.querySelector('.pagination-btn:last-of-type');

            if (prevPageBtn && nextPageBtn) {
                prevPageBtn.addEventListener('click', function() {
                    table.previousPage();
                });

                nextPageBtn.addEventListener('click', function() {
                    table.nextPage();
                });
            }
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>
    <!-- script for dispalaying the tabulator data ends here  -->

    <!-- code for dispalying the certificate start here  -->
    <script>
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($certificate); ?>;
            var columns = [{
                    title: "User Name",
                    field: "username",
                    headerFilter: true
                    // visible: <?php echo ($usertype == 'user') ? 'true' : 'true'; ?>,
                },
                {
                    title: "PI Name",
                    field: "piname",
                    headerFilter: true
                },
                {
                    title: "College Name",
                    field: "collegename",
                    headerFilter: true,
                },
                {
                    title: "Start Date",
                    field: "start_date",
                    headerFilter: true
                },
                {
                    title: "End Date",
                    field: "start_date",
                    headerFilter: true
                },
                {
                    title: "Work Done",
                    field: "workdone",
                    headerFilter: true
                },
                {
                    title: "User Response",
                    field: "userresponse",
                    headerFilter: true
                },
            ];

            // code for updating the user leave status start here 
            <?php //if ($usertype != 'user') : 
            ?>
            columns.push({
                title: "Certificate Status",
                field: "certificatestatus",
                headerFilter: true,
                editor: <?php echo ($usertype == 'hr') ? "'input'" : "false"; ?>,
                cellEdited: function(cell) {
                    // console.log(cell);
                    var userId = cell.getData().sid;
                    var lid = cell.getData().leaveid;
                    var newValue = cell.getValue();
                    cell.setValue(newValue);
                    // console.log(userId, newValue);
                    updatestatus(userId, newValue);
                },
            });
            <?php // endif; 
            ?>

            // function of the updatestatus start here 
            function updatestatus(userId, newValue) {
                // console.log(userId, newValue);
                fetch('formsubmit.php/certificatestatus', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },

                        body: 'sid=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.json())
                    .then(data => {
                        var datavalue = data.data;
                        console.log(datavalue);
                        if (datavalue == 'no') {
                            alert("User certificate not Sent");
                            // window.location.href = "../index1.php";
                        } else {
                            alert("Certificate Successfully Sent");
                            // window.location.href = "index1.php";
                        }
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }

            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#certificate", {
                data: results,
                layout: "fitColumns",
                columns: columns,
                pagination: "local", // Enable local pagination
                paginationSize: pageSize, // Number of rows per page
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage, // Initial page
            });
            // Add the following code to initialize pagination buttons
            var prevPageBtn = document.querySelector('.pagination-btn:first-of-type');
            var nextPageBtn = document.querySelector('.pagination-btn:last-of-type');

            if (prevPageBtn && nextPageBtn) {
                prevPageBtn.addEventListener('click', function() {
                    table.previousPage();
                });

                nextPageBtn.addEventListener('click', function() {
                    table.nextPage();
                });
            }

            function updateTableData() {
                // Fetch updated data from the server
                fetch('fetch_data.php') // Create a new PHP file (fetch_data.php) to handle fetching data
                    .then(response => response.json())
                    .then(data => {
                        // Update Tabulator table with the latest data
                        table.setData(data);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }

        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>
    <!-- code for dispalying teh gate pass start here  -->
    <script>
        var tabId;
        // code for dispalying all the data in the table 
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($gatepass); ?>;
            var columns = [{
                    title: "Name",
                    field: "name",
                    headerFilter: true
                },
                {
                    title: "Contact Number",
                    field: "mobile",
                    headerFilter: true
                },
                {
                    title: "Start Date",
                    field: "startdate",
                    headerFilter: true
                },
                {
                    title: "End Date",
                    field: "enddate",
                    headerFilter: true
                },
                {
                    title: "Gender",
                    field: "gender",
                    headerFilter: true
                },
                {
                    title: "Purpose",
                    field: "purpose",
                    headerFilter: true
                }
            ];

            columns.push({
                title: "Certificate Status",
                field: "gatepassstatus",
                headerFilter: true,
                editor: <?php echo ($usertype == 'hr' || $usertype == 'account') ? "'input'" : "false"; ?>,
                cellEdited: function(cell) {
                    var userId = cell.getData().sid;
                    var newValue = cell.getValue();
                    cell.setValue(newValue);
                    console.log(userId, newValue);
                    updategatestatus(userId, newValue);
                },
            });

            function updategatestatus(userId, newValue) {
                console.log(userId, newValue);
                fetch('formsubmit.php/gatepassstatus', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },

                        body: 'sid=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert("Gatepass Status Update Successfully")
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }

            // function of the updatestatus start here
            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#gatepass", {
                data: results,
                layout: "fitColumns",
                columns: columns,
                pagination: "local",
                paginationSize: pageSize,
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage,
            });
            // Add the following code to initialize pagination buttons
            var prevPageBtn = document.querySelector('.pagination-btn:first-of-type');
            var nextPageBtn = document.querySelector('.pagination-btn:last-of-type');

            if (prevPageBtn && nextPageBtn) {
                prevPageBtn.addEventListener('click', function() {
                    table.previousPage();
                });

                nextPageBtn.addEventListener('click', function() {
                    table.nextPage();
                });
            }
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>

    <!-- code for dispalying resgination list  -->
    <script>
        // code for dispalying all the data in the table 
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($resign); ?>;
            var columns = [{
                    title: "PI Name",
                    field: "pi_name",
                    headerFilter: true
                },
                {
                    title: "Start Date",
                    field: "start_date",
                    headerFilter: true,
                },
                {
                    title: "End Date",
                    field: "terminationdate",
                    headerFilter: true
                },
                {
                    title: "Start Position",
                    field: "startingposition",
                    headerFilter: true
                },
                {
                    title: "Ending Position",
                    field: "endingpostion",
                    headerFilter: true
                },
                {
                    title: "Reason For Leaving",
                    field: "reason_leaving",
                    headerFilter: true
                },
                {
                    title: "Plan After Leaving",
                    field: "planafterleaving",
                    headerFilter: true
                },
                {
                    title: "Feedback",
                    field: "imporove_suggestion",
                    headerFilter: true
                },
                {
                    title: "Most Liked",
                    field: "what_mostlike",
                    headerFilter: true
                },
                {
                    title: "Least Liked",
                    field: "what_leastlike",
                    headerFilter: true
                },
                {
                    title: "Another Job",
                    field: "taking_anotherjob",
                    headerFilter: true
                },
                {
                    title: "New Job Place",
                    field: "new_place_job",
                    headerFilter: true
                },
                {
                    title: "Imporovement",
                    field: "improvement",
                    headerFilter: true
                },
                {
                    title: "Cupboard Key",
                    field: "CupboardKeys_yesno",
                    headerFilter: true
                },
                {
                    title: "Drawer Key",
                    field: "Drawer_yesno",
                    headerFilter: true
                },
                {
                    title: "Lab Book",
                    field: "labbookyesno",
                    headerFilter: true
                },
                {
                    title: "hardware",
                    field: "hardwareno",
                    headerFilter: true
                },
                {
                    title: "Otherremark",
                    field: "otherremarks",
                    headerFilter: true
                },
                {
                    title: "Resign Status",
                    field: "resignstatus",
                    headerFilter: true
                },
            ];

            /* code for upadating the resignation status start here */
            columns.push({
                title: "Approve / Disapprove",
                field: "leave_status",
                headerFilter: true,
                formatter: function(cell, formatterParams, onRendered) {
                    var value = cell.getValue();
                    var cellEl = cell.getElement();
                    var row = cell.getRow();
                    if (value === 'yes') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('green-row');
                        return 'Approved';
                    } else if (value === 'no') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('red-row');
                        return 'Denied';
                    } else {
                        <?php if ($usertype == 'hr') : ?>
                            var dropdown = document.createElement('select');
                            dropdown.classList.add('form-control');
                            dropdown.innerHTML = `
                                    <option value="">Select</option>
                                    <option value="yes">Approved</option>
                                    <option value="no">Dissapproved</option>
                                    `;
                            // Add event listener to the dropdown
                            dropdown.addEventListener('change', function(event) {
                                var selectedValue = event.target.value;
                                var cellData = cell.getData();
                                var username = cellData.name;
                                var sid = cellData.sid;
                                var lid = cellData.leaveid;
                                console.log(lid, selectedValue, sid, username);
                                // updatestatus(lid, selectedValue, sid, username);
                            });

                            return dropdown;
                        <?php else : ?>
                            return '';
                        <?php endif; ?>
                    }
                }
            });
            <?php // endif; 
            ?>
            // function of the updatestatus start here 
            function updatestatus(lid, userId, newValue) {
                console.log(lid, userId, newValue);
                fetch('updateproductstatus.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },

                        body: 'lid=' + encodeURIComponent(lid) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert("Product Status Updated Successfully")
                        //   console.log('Database update successful:', data);
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }
            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#resign", {
                data: results,
                layout: "fitData",
                columns: columns,
                pagination: "local",
                paginationSize: pageSize,
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage,
            });
            // Add the following code to initialize pagination buttons
            var prevPageBtn = document.querySelector('.pagination-btn:first-of-type');
            var nextPageBtn = document.querySelector('.pagination-btn:last-of-type');

            if (prevPageBtn && nextPageBtn) {
                prevPageBtn.addEventListener('click', function() {
                    table.previousPage();
                });

                nextPageBtn.addEventListener('click', function() {
                    table.nextPage();
                });
            }
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>
    <!--<script src='./js/index.js'></script>-->

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