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
    if ($usertype == "system") {
        header("Location: ../system");
    }
    // code for checking that if the usertype is staff or not 
    try {

        if ($usertype == "staff") {
            $sql = "SELECT sg.`sid`,sg.`name`, sg.`email`, sg.`usertype`,sg.`tenureenddate`, sg.`contact`, sg.`cl`, sg.`rh`,sg.`el`, sg.remainingcl, sg.remainingrh,sg.remainingel, sg.declarationform,lt.leaveid, lt.`clstartdate`, lt.`clenddate`,lt.`rhstartdate`, lt.`rhenddate`, lt.`elstartdate`, lt.`elenddate`,  lt.`reason`, lt.`leave_status`,de.declarationform,de.emp_roll,de.`univesity`,de.name,de.iitbemail,de.aadhar,de.gender,de.localaddress,de.localpostal,de.permanentadd,de.permpostal, de.homecontact,de.emename1,de.emerelation,de.emeadd,de.emecontact,de.empostalcode,de.emesecondname,de.emesecrelation,de.medicalcondition,de.profilepic
             FROM `sigin` as sg LEFT JOIN leavetable as lt on lt.sid = sg.sid LEFT JOIN declarationform as de on de.sid = sg.sid where sg.sid=:sid ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':sid', $sid);
            $stmt->execute();
        } elseif ($usertype == "intern" || $usertype == "student") {
            $sql = "SELECT sg.`sid`,sg.`declarationform`, sg.`name`, sg.`email`, sg.`usertype`, sg.`contact`, sg.declarationform, de.`declarationform`, de.`name`,de.iitbemail,de.aadhar, de.`emp_roll`,de.`univesity`, de.`gender`, de.`localaddress`, de.`localpostal`, de.`permanentadd`, de.`permpostal`, de.`homecontact`, de.`emename1`, de.`emerelation`, de.`emeadd`, de.`emecontact`, de.`empostalcode`, de.`emesecondname`, de.`emesecrelation`, de.`medicalcondition`, de.`term`, de.`profilepic`
             FROM `sigin` as sg LEFT JOIN declarationform as de on de.sid = sg.sid where sg.sid=:sid ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':sid', $sid);
            $stmt->execute();
        } elseif ($usertype == "hr") {
            $sql = "SELECT sg.`sid`,sg.`declarationform`, sg.`name`, sg.`email`, sg.`usertype`, sg.`contact`, sg.`cl`, sg.`rh`,sg.`el`, sg.remainingcl, sg.remainingrh,sg.remainingel, sg.declarationform,lt.leaveid,lt.`reason`,lt.`clstartdate`, lt.`clenddate`,lt.`rhstartdate`, lt.`rhenddate`, lt.`elstartdate`, lt.`elenddate`, lt.`leave_status` 
                    FROM `sigin` as sg LEFT JOIN leavetable as lt on lt.sid = sg.sid";
            $stmt = $conn->prepare($sql);
            // $stmt->bindParam(':sid', $sid);
            $stmt->execute();
        }
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($results);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
    exit();
}

$sql = "SELECT `sid`, `name`, `email`,`empcode`,`password`,`startdate`,`enddate`,`userstatus`,`tenureenddate`, `usertype`, `contact`, `cl`, `rh`, `remainingcl`, `remainingrh`, `year`, `declarationform`, `resign` FROM `sigin`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$userdetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($userdetails);


$sql = "SELECT `cid`, `sid`, `piname`, `username`,`start_date`,`end_date`,`certificatestatus`, `collegename`, `workdone` FROM `certificate`";
// $sql = 'SELECT sg.`certificatestatus`, ce.`cid`, ce.`sid`, ce.`piname`, ce.`username`, ce.`start_date`, ce.`end_date`, ce.`certificatestatus` AS `ce_certificatestatus`, ce.`collegename`, ce.`workdone` FROM `sigin` AS sg LEFT JOIN `certificate` AS ce ON ce.`sid` = sg.`sid`';
$stmt = $conn->prepare($sql);
$stmt->execute();
$certificate = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT `rid`, `sid`, `pi_name`, `start_date`, `terminationdate`, `startingposition`, `endingpostion`, `reason_leaving`, `planafterleaving`, `imporove_suggestion`, `what_mostlike`, `what_leastlike`, `taking_anotherjob`, `new_place_job`, `improvement`, `Drawer_yesno`, `CupboardKeys_yesno`, `labbookyesno`, `hardwareno`,`otherremarks`, `anyothersno` FROM `resigndata`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resign = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($usertype == 'hr') {
    $sql = "SELECT `gid`,`sid`, `name`, `mobile`, `startdate`, `enddate`, `gender`, `purpose`,`gatepassstatus` FROM `gatepass`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $gatepass = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT `gid`,`sid`, `name`, `mobile`, `startdate`, `enddate`, `gender`, `purpose`,`gatepassstatus` FROM `gatepass` where sid=:sid ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sid', $sid);
    $stmt->execute();
    $gatepass = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$decform = $results[0]['declarationform'];
// echo $decform;
// $decform = "yes";

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
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!-- code for displaying the logo and name start here  -->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/logo.png" alt="">
                <img class="logo-compact" src="./images/logo-text.png" alt="">
                <img class="brand-title" src="./images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!-- code for dispalying the logo and name ends here   -->

        <!-- code for header start here  -->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                                <!-- code for search bar start here  -->
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <!-- code for dispaying the notification start here  -->
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-user"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="primary"><i class="ti-shopping-cart"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="danger"><i class="ti-bookmark"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="primary"><i class="ti-heart"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>David</strong> purchased Light Dashboard 1.0.</p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-image"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong> James.</strong> has added a<strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                    </ul>
                                    <!-- code for notification ends here  -->
                                    <!-- code for see all the notification start here nad i have to add the link -->
                                    <a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <!-- code for getting dropdown list start here  -->
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./profile.php" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="./page-login.html" class="dropdown-item">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                            <!-- code ends for dispaying the dropdown when user click on the profile  -->
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- code for header ends here  -->

        <!-- code for side bar start here to display all the list start here  -->
        <!-- <div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label first">Main Menu</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./home.php">HR</a></li>
                            <li><a href="./accountfinance.php">Accoutn and Finanance</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Apps</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text">Apps</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./app-profile.html">Profile</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Email</a>
                                <ul aria-expanded="false">
                                    <li><a href="./email-compose.html">Compose</a></li>
                                    <li><a href="./email-inbox.html">Inbox</a></li>
                                    <li><a href="./email-read.html">Read</a></li>
                                </ul>
                            </li>
                            <li><a href="./app-calender.html">Calendar</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-chart-bar-33"></i><span class="nav-text">Charts</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./chart-flot.html">Flot</a></li>
                            <li><a href="./chart-morris.html">Morris</a></li>
                            <li><a href="./chart-chartjs.html">Chartjs</a></li>
                            <li><a href="./chart-chartist.html">Chartist</a></li>
                            <li><a href="./chart-sparkline.html">Sparkline</a></li>
                            <li><a href="./chart-peity.html">Peity</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Components</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-world-2"></i><span class="nav-text">Bootstrap</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./ui-accordion.html">Accordion</a></li>
                            <li><a href="./ui-alert.html">Alert</a></li>
                            <li><a href="./ui-badge.html">Badge</a></li>
                            <li><a href="./ui-button.html">Button</a></li>
                            <li><a href="./ui-modal.html">Modal</a></li>
                            <li><a href="./ui-button-group.html">Button Group</a></li>
                            <li><a href="./ui-list-group.html">List Group</a></li>
                            <li><a href="./ui-media-object.html">Media Object</a></li>
                            <li><a href="./ui-card.html">Cards</a></li>
                            <li><a href="./ui-carousel.html">Carousel</a></li>
                            <li><a href="./ui-dropdown.html">Dropdown</a></li>
                            <li><a href="./ui-popover.html">Popover</a></li>
                            <li><a href="./ui-progressbar.html">Progressbar</a></li>
                            <li><a href="./ui-tab.html">Tab</a></li>
                            <li><a href="./ui-typography.html">Typography</a></li>
                            <li><a href="./ui-pagination.html">Pagination</a></li>
                            <li><a href="./ui-grid.html">Grid</a></li>

                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-plug"></i><span class="nav-text">Plugins</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./uc-select2.html">Select 2</a></li>
                            <li><a href="./uc-nestable.html">Nestedable</a></li>
                            <li><a href="./uc-noui-slider.html">Noui Slider</a></li>
                            <li><a href="./uc-sweetalert.html">Sweet Alert</a></li>
                            <li><a href="./uc-toastr.html">Toastr</a></li>
                            <li><a href="./map-jqvmap.html">Jqv Map</a></li>
                        </ul>
                    </li>
                    <li><a href="widget-basic.html" aria-expanded="false"><i class="icon icon-globe-2"></i><span class="nav-text">Widget</span></a></li>
                    <li class="nav-label">Forms</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-form"></i><span class="nav-text">Forms</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./form-element.html">Form Elements</a></li>
                            <li><a href="./form-wizard.html">Wizard</a></li>
                            <li><a href="./form-editor-summernote.html">Summernote</a></li>
                            <li><a href="form-pickers.html">Pickers</a></li>
                            <li><a href="form-validation-jquery.html">Jquery Validate</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Table</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-layout-25"></i><span class="nav-text">Table</span></a>
                        <ul aria-expanded="false">
                            <li><a href="table-bootstrap-basic.html">Bootstrap</a></li>
                            <li><a href="table-datatable-basic.html">Datatable</a></li>
                        </ul>
                    </li>

                    <li class="nav-label">Extra</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-single-copy-06"></i><span class="nav-text">Pages</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./page-register.html">Register</a></li>
                            <li><a href="./page-login.html">Login</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                                <ul aria-expanded="false">
                                    <li><a href="./page-error-400.html">Error 400</a></li>
                                    <li><a href="./page-error-403.html">Error 403</a></li>
                                    <li><a href="./page-error-404.html">Error 404</a></li>
                                    <li><a href="./page-error-500.html">Error 500</a></li>
                                    <li><a href="./page-error-503.html">Error 503</a></li>
                                </ul>
                            </li>
                            <li><a href="./page-lock-screen.html">Lock Screen</a></li>
                        </ul>
                    </li>
                </ul>
            </div>


        </div> -->
        <?php include 'sidebar.php' ?>
        <!-- code for side bar start here to display all the list start here  -->

        <!-- code for main body start here  -->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back!</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
                        </ol>
                    </div>
                </div>
                <!-- code for displaying the user detials here  -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total No of User</div>
                                    <div class="stat-digit">8500</div>
                                </div>
                                <!-- <div class="progress">
                                    <div class="progress-bar progress-bar-success w-85" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total Staff</div>
                                    <div class="stat-digit">7800</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total Intern</div>
                                    <div class="stat-digit">500</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total Student</div>
                                    <div class="stat-digit">650</div>
                                </div>

                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                </div>

                <div class="row">
                    <!-- code for user dispalying user details start here  -->
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-8">
                                        <!-- <div id="morris-bar-chart"></div> -->
                                        <div id="userdetails"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- code for dispalying the user details, certificate  and resign list start here  -->
                <div class="row">
                    <!-- code for displaying the certificate start here  -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Certificate list</h4>
                                <button id="openPopupBtn">Send Certificate</button>
                            </div>
                            <div class="card-body">
                                <div id="certificate"></div>
                            </div>
                        </div>
                    </div>
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
                                                <th>Product</th>
                                                <th>quantity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Lew Shawon</td>
                                                <td><span>Dell-985</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Lew Shawon</td>
                                                <td><span>Asus-565</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- code for dispalying the gate pass start here  -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gate Pass</h4>
                                <button id="openPopupBtn">Send Gate Pass</button>
                            </div>
                            <div class="card-body">
                                <!-- <div id="vmap13" class="vmap"></div> -->
                                <div id="gatepass"></div>
                            </div>
                        </div>
                    </div>
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
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Product</th>
                                                <th>quantity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Lew Shawon</td>
                                                <td><span>Dell-985</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Lew Shawon</td>
                                                <td><span>Asus-565</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>lew Shawon</td>
                                                <td><span>Dell-985</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- code for dispalying the resignation list start here  -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Resignation List</h4>
                                <!-- <button id="openPopupBtn">Send Gate Pass</button> -->
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
                                                <th>Name</th>
                                                <th>Product</th>
                                                <th>quantity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Lew Shawon</td>
                                                <td><span>Dell-985</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Lew Shawon</td>
                                                <td><span>Asus-565</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img width="35" src="./images/avatar/1.png" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>lew Shawon</td>
                                                <td><span>Dell-985</span></td>
                                                <td><span>456 pcs</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="row">
                    <div class="col-lg-6 col-xl-4 col-xxl-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Timeline</h4>
                            </div>
                            <div class="card-body">
                                <div class="widget-timeline">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge primary"></div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>10 minutes ago</span>
                                                <h6 class="m-t-5">Youtube, a video-sharing website, goes live.</h6>
                                            </a>
                                        </li>

                                        <li>
                                            <div class="timeline-badge warning">
                                            </div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>20 minutes ago</span>
                                                <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>
                                            </a>
                                        </li>

                                        <li>
                                            <div class="timeline-badge danger">
                                            </div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>30 minutes ago</span>
                                                <h6 class="m-t-5">Google acquires Youtube.</h6>
                                            </a>
                                        </li>

                                        <li>
                                            <div class="timeline-badge success">
                                            </div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>15 minutes ago</span>
                                                <h6 class="m-t-5">StumbleUpon is acquired by eBay. </h6>
                                            </a>
                                        </li>

                                        <li>
                                            <div class="timeline-badge warning">
                                            </div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>20 minutes ago</span>
                                                <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>
                                            </a>
                                        </li>

                                        <li>
                                            <div class="timeline-badge dark">
                                            </div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>20 minutes ago</span>
                                                <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>
                                            </a>
                                        </li>

                                        <li>
                                            <div class="timeline-badge info">
                                            </div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>30 minutes ago</span>
                                                <h6 class="m-t-5">Google acquires Youtube.</h6>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Todo</h4>
                            </div>
                            <div class="card-body px-0">
                                <div class="todo-list">
                                    <div class="tdl-holder">
                                        <div class="tdl-content widget-todo mr-4">
                                            <ul id="todo_list">
                                                <li><label><input type="checkbox"><i></i><span>Get up</span><a href='#' class="ti-trash"></a></label></li>
                                                <li><label><input type="checkbox" checked><i></i><span>Stand up</span><a href='#' class="ti-trash"></a></label></li>
                                                <li><label><input type="checkbox"><i></i><span>Don't give up the
                                                            fight.</span><a href='#' class="ti-trash"></a></label></li>
                                                <li><label><input type="checkbox" checked><i></i><span>Do something
                                                            else</span><a href='#' class="ti-trash"></a></label></li>
                                                <li><label><input type="checkbox" checked><i></i><span>Stand up</span><a href='#' class="ti-trash"></a></label></li>
                                                <li><label><input type="checkbox"><i></i><span>Don't give up the
                                                            fight.</span><a href='#' class="ti-trash"></a></label></li>
                                            </ul>
                                        </div>
                                        <div class="px-4">
                                            <input type="text" class="tdl-new form-control" placeholder="Write new item and hit 'Enter'...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xxl-6 col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Sold</h4>
                                <div class="card-action">
                                    <div class="dropdown custom-dropdown">
                                        <div data-toggle="dropdown">
                                            <i class="ti-more-alt"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Option 1</a>
                                            <a class="dropdown-item" href="#">Option 2</a>
                                            <a class="dropdown-item" href="#">Option 3</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart py-4">
                                    <canvas id="sold-product"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-xl-12 col-xxl-6 col-lg-6 col-md-12">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-sm-6 col-xxl-6 col-md-6">
                                <div class="card">
                                    <div class="social-graph-wrapper widget-facebook">
                                        <span class="s-icon"><i class="fa fa-facebook"></i></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">89</span> k</h4>
                                                <p class="m-0">Friends</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">119</span> k</h4>
                                                <p class="m-0">Followers</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 col-xxl-6 col-md-6">
                                <div class="card">
                                    <div class="social-graph-wrapper widget-linkedin">
                                        <span class="s-icon"><i class="fa fa-linkedin"></i></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">89</span> k</h4>
                                                <p class="m-0">Friends</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">119</span> k</h4>
                                                <p class="m-0">Followers</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 col-xxl-6 col-md-6">
                                <div class="card">
                                    <div class="social-graph-wrapper widget-googleplus">
                                        <span class="s-icon"><i class="fa fa-google-plus"></i></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">89</span> k</h4>
                                                <p class="m-0">Friends</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">119</span> k</h4>
                                                <p class="m-0">Followers</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 col-xxl-6 col-md-6">
                                <div class="card">
                                    <div class="social-graph-wrapper widget-twitter">
                                        <span class="s-icon"><i class="fa fa-twitter"></i></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">89</span> k</h4>
                                                <p class="m-0">Friends</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                                                <h4 class="m-1"><span class="counter">119</span> k</h4>
                                                <p class="m-0">Followers</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
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



    <!-- script for dispalying the tabulator data  -->
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
                        var sid = userData.sid; // Assuming sid is part of the row data
                        var emailid = userData.emailid; // Assuming emailid is part of the row data

                        return '<a href="userprofile.php?sid=' + sid + '" target="_blank">' + userName + '</a>';
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


            <?php if ($usertype == 'hr') : ?>
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
                        console.log(newValue, userId)
                        updateApprovalStatus(userId, newValue);
                    }
                });
            <?php endif; ?>
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
                        console.log(datavalue);
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
                    .then(response => response.json())
                    .then(data => {
                        var datavalue = data.data;
                        console.log(datavalue);
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
                editor: <?php echo ($usertype == 'hr') ? "'input'" : "false"; ?>,
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