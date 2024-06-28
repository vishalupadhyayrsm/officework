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
// print_r($userdetails['tenureenddate']);


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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Attendance Management System</title>
    <link rel="icon" type="image/x-icon" href="logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/popup.css">
    <style>
        .form-page {
            display: none;
        }

        .form-page.active {
            display: block;
        }

        button {
            margin: 10px 0;
        }

        /* code for updating the tabel based on color start here  */
        .tab-content {
            display: none;
        }

        .active-tab {
            display: block;
        }

        .red-row {
            color: red;
        }

        .green-row {
            color: green;
        }

        .not-editable-row,
        .disabled-cell {
            pointer-events: none;
            opacity: 0.5;
        }

        .disabled-row {
            opacity: 0.5;
            pointer-events: none;
        }

        .disabled-cell {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
    <script>
        <?php if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) : ?>
            alert("Record inserted successfully");
            <?php unset($_SESSION['form_submitted']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['sid_exist']) && $_SESSION['sid_exist']) : ?>
            alert("You have alreday applied for Certificate");
            <?php unset($_SESSION['sid_exist']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['resign_sid_exist']) && $_SESSION['resign_sid_exist']) : ?>
            alert("You have alreday resign");
            <?php unset($_SESSION['resign_sid_exist']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['resign_form']) && $_SESSION['resign_form']) : ?>
            alert("Successfully Submitted");
            <?php unset($_SESSION['resign_form']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['dec_form']) && $_SESSION['dec_form']) : ?>
            alert("Successfully Submitted Decleration form");
            <?php unset($_SESSION['dec_form']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['leave_success']) && $_SESSION['leave_success']) : ?>
            alert("Leave Applied Successfully");
            <?php unset($_SESSION['leave_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['remainingrh']) && $_SESSION['remainingrh']) : ?>
            alert("No Rh Remaining");
            <?php unset($_SESSION['remainingrh']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['remainingcl']) && $_SESSION['remainingcl']) : ?>
            alert("No CL Remaining");
            <?php unset($_SESSION['remainingcl']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['gatepass']) && $_SESSION['gatepass']) : ?>
            alert("Your Gate Pass Request Successfully Applied");
            <?php unset($_SESSION['gatepass']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['certificate']) && $_SESSION['certificate']) : ?>
            alert("Certificate Send to user Successfully");
            <?php unset($_SESSION['certificate']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['certificatestatus']) && $_SESSION['certificatestatus']) : ?>
            alert("Certificate Status Updated Successfully");
            <?php unset($_SESSION['certificatestatus']); ?>
        <?php endif; ?>
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <!--<span class="navbar-brand">Welcome: </span>-->
            <span class="navbar-brand"> <?php echo $_SESSION['username']; ?></span>
            <div class="container">
                <div class="header-content">
                    <h2 class="model_name text-center">Machine Intelligence Program</h2>
                </div>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </nav>

    </header>
    <!-- code for disaplying the button details -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-2" style="border-right:1px solid black;">
                <!-- code for checking the if usertype == staff or intern -->
                <?php
                if ($decform  == 'yes') {
                ?>
                    <div class="d-flex flex-column">
                        <?php
                        if ($usertype == "staff") {
                        ?>
                            <button onclick="showTab('tab1')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">User Profile</button>
                            <button onclick="showTab('tab2')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Apply Leave</button>

                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                <br>
            </div>
            <!-- code for displaying teh  data in this div start here  -->
            <div class="col-12 col-md-10">
                <!-----code for dispalying the deceleration form  start here  ------>
                <?php
                if ($decform  !== 'yes') {
                ?>
                    <div id="" class="container tab-content active-tab">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">

                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>


            </div>

        </div>

        <br><br><br><br>

        <!-- code for footer start here -->
        <?php include 'footer.php' ?>;

        <script>
            var tabId;

            function showTab(tabId) {
                var tabs = document.querySelectorAll('.tab-content');
                tabs.forEach(function(tab) {
                    tab.classList.remove('active-tab');
                });
                var selectedTab = document.getElementById(tabId);
                selectedTab.classList.add('active-tab');
            }
        </script>



        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>