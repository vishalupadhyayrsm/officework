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


// $$decform  = "ye";
// print_r($results);
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
                            <button onclick="showTab('tab3')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Leave Status</button>
                            <button onclick="showTab('tab5')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">RESIGNATION FORM</button>
                            <button onclick="showTab('tab10')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Gate Pass</button>
                            <button onclick="showTab('tab11')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Gate Pass Status</button>
                        <?php
                        } elseif ($usertype == 'intern' || $usertype == 'student') {
                        ?>
                            <button onclick="showTab('tab1')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">User Profile</button>
                            <button onclick="showTab('tab6')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Certificate Form</button>
                            <button onclick="showTab('tab5')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">RESIGNATION FORM</button>
                            <button onclick="showTab('tab10')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Gate Pass</button>
                            <?php if ($usertype == "intern") { ?>
                                <button onclick="showTab('tab11')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Gate Pass Status</button>
                            <?php } ?>
                        <?php
                        } else {
                        ?>
                            <button onclick="showTab('tab4')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">User Details</button>
                            <button onclick="showTab('tab3')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Leave Status</button>
                            <button onclick="showTab('tab7')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Certificate Request</button>
                            <button onclick="showTab('tab8')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Resignation List</button>
                            <button onclick="showTab('tab9')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Resume</button>
                            <button onclick="showTab('tab11')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Gate Pass Status</button>
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
                                <!--- code for multpage form start here ---->
                                <form id="multiPageForm" method="post" action="formsubmit.php/deceleration" class="form_data" enctype="multipart/form-data">
                                    <div class="form-page active" id="page1">
                                        <h2 style="text-align:center;">MIP Deceleration Form</h2>
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="name">IITB Email (if available):</label>
                                            <input type="email" class="form-control" id="name" name="iitbmail">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="emp_roll">Employee No/Student Roll No:</label>
                                            <input type="number" class="form-control" id="emp_roll" name="emproll">
                                        </div><br>

                                        <div class="form-group">
                                            <label for="emp_roll">University:</label>
                                            <input type="text" class="form-control" id="university" name="univesity" required>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="Aadhar">Aadhar Card:</label>
                                            <input type="text" class="form-control" placeholder="Please enter 12 digite Aadhar card number" id="aadahr" name="adhar" pattern="\d{12}" maxlength="12" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid 12-digit Aadhar Card number.
                                            </div>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="month">Gender:</label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="end_date">Local Address (In case of IIT Bombay Student please provide your hostel details here):</label>
                                            <input type="text" class="form-control" id="localadd" name="localadd" required>
                                            <br>
                                            <label for="Postal">Postal Code:</label>
                                            <input type="number" class="form-control" id="localadd" name="localpostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                                            <div id="error-message" style="color: red; display: none;">Please enter a 6-digit postal code.</div>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="end_date">Permanent Address:</label>
                                            <input type="text" class="form-control" id="localadd" name="permadd" required><br>
                                            <label for="Postal">Postal Code:</label>
                                            <input type="number" class="form-control" id="permaadd" name="permapostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                                            <div id="error-message" style="color: red; display: none;">Please enter a 6-digit postal code.</div>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="localadd">Home Contact No:</label>
                                            <input type="number" class="form-control" id="localadd" name="phone" required pattern="\d{10}" title="Please enter a 10-digit phone number">
                                            <span id="phone-error" style="color:red; display:none;">Invalid phone number. Please enter a 10-digit phone number.</span>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="localadd">Upload Image:</label>
                                            <!-- <input type="file" class="form-control" id="image" name="profileimage"> -->
                                            <input type="file" class="form-control" id="image" name="profileimage" accept=".jpg, .jpeg, .png" required>
                                            <div class="invalid-feedback" style="display:none;">
                                                Please upload a JPEG or PNG file.
                                            </div>
                                        </div><br>

                                        <button type="button" onclick="nextPage(2)" class="btn btn-primary">Next</button>
                                    </div>
                                    <!-- second page start here -->
                                    <div class="form-page" id="page2">
                                        <h2>Emergency Contact Details (First Person)</h2>
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="emergencyname1" name="emergencyname1" required>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="relationship1">Relationsip:</label>
                                            <input type="text" class="form-control" id="relationship1" name="relationship1" required>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="emecontact">Contact No:</label>
                                            <input type="number" class="form-control" id="localadd" name="emephone1" required pattern="\d{10}" title="Please enter a 10-digit phone number">
                                            <br>
                                            <span id="phone-error" style="color:red; display:none;">Invalid phone number. Please enter a 10-digit phone number.</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="localadd_emergency1">Contact address if different from above:</label>
                                            <input type="text" class="form-control" id="localadd_emergency1" name="localadd_emergency1" required>
                                            <br>
                                            <label for="localpostalcode_emergency1">Postal Code:</label>
                                            <input type="number" class="form-control" id="localpostalcode_emergency1" name="localpostalcode_emergency1" required minlength="6" maxlength="6" pattern="\d{6}">
                                            <div id="error-message" style="color: red; display: none;">Please enter a 6-digit postal code.</div>
                                        </div><br>

                                        <h2>Emergency Contact Details (Second Person)</h2>
                                        <div class="form-group">
                                            <label for="emergencyname2">Name:</label>
                                            <input type="text" class="form-control" id="emergencyname2" name="emergencyname2" required>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="relationship2">Relationsip:</label>
                                            <input type="text" class="form-control" id="relationship2" name="relationship2" required>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="emergencyname">Are there any medical conditions we should know about in the case of an emergency:</label>
                                            <input type="text" class="form-control" id="relationship" name="medicalcondition">
                                        </div><br>

                                        <button type="button" onclick="previousPage(1)" class="btn btn-primary">Previous</button>
                                        <button type="button" onclick="nextPage(3)" class="btn btn-primary">Next</button>
                                    </div>
                                    <!-- Third page start here  -->
                                    <div class="form-page" id="page3">
                                        <div class="form-group">
                                            <ol>
                                                <li>I will not, directly or indirectly, divulge any information connected with the project to any person(s) other than those
                                                    authorized by the principle investigator.
                                                </li><br>
                                                <li>
                                                    I shall keep and maintain systematic records of all data, results supplied by the client or generated in teh course of the project etc. and
                                                    will not divulge these to third party.
                                                </li><br>
                                                <li>
                                                    I shall not make / keep additional copies of any data / results / reports pertaining to the project without teh express permission of teh principle investigator.
                                                </li><br>
                                                <li>
                                                    I agree that all data generated in the project, paper/ drawings / computer software and other records in my possession pertaining to the project will
                                                    be the property of Indian Instittue of Technology Bombay and I shall have no claim on teh same and I will hand over all these documents to the project
                                                    investigator before I resign from or leave the project.
                                                </li><br>
                                                <li>
                                                    Even after my leaveing the institute / resignation / termination of appoinmanet, I will not disclose my confidential information pertainng to teh project
                                                    or otherwise made available to me during my tenure, to any third party.
                                                </li><br>
                                                <li>
                                                    I agree that all intellectual property generated through the project will be deemed assigned exclusively to National Center for Aerospace Innovation and Research,
                                                    Indian Institute of Technology Bombay for use / dissemination / transfer or licence for payment of royalty or transfer fee, as it may deem fit.
                                                </li><br>
                                            </ol>
                                            <br>
                                            <div class="form-group">
                                                <p>I have read teh above aggreement carefully and accept that this is a legally valid and binding obligation and hereby agree to the above.</p>
                                                <input type="checkbox" class="form-check-input" id="termsCheck" name="termcheck" required>
                                                <label class="form-check-label" for="termsCheck">
                                                    I agree to the above terms and conditions.
                                                </label>
                                            </div>



                                            <button type="button" onclick="previousPage(2)" class="btn btn-primary">Previous</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- code for dispaly the intern decelartion form that user has filled  -->
                <?php
                if (($usertype != "hr") && $decform  == 'yes') {
                ?>
                    <div id="tab1" class="container tab-content active-tab">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="resume-container">
                                    <input type="hidden" id="sid" name="sid" value="<?php echo $results[0]['sid']; ?>">
                                    <div class="profile-picture">
                                        <img id="profile-img" src="<?php echo $results[0]['profilepic']; ?>" alt="user_profile">
                                        <span id="edit-icon" class="edit-icon">edit</span>
                                        <input id="profile-pic-input" type="file" name="profilepic" style="display: none;">
                                    </div>
                                    <div class="profile-details">
                                        <h1 class="username"><?php echo $results[0]['name']; ?></h1>
                                        <p>University: <span class="text-display"><?php echo $results[0]['univesity']; ?></span><input class="input-display" type="text" name="university" value="<?php echo $results[0]['university']; ?>"></p>
                                        <p>Contact: <span class="text-display"><?php echo $results[0]['contact']; ?></span><input class="input-display" type="text" name="contact" value="<?php echo $results[0]['contact']; ?>"></p>
                                        <p>Email: <span class="text-display"><?php echo $results[0]['email']; ?></span><input class="input-display" type="email" name="email" value="<?php echo $results[0]['email']; ?>"></p>
                                        <p>Email: <span class="text-display"><?php echo $results[0]['iitbemail']; ?></span></p>
                                        <?php if (($usertype == "staff")) { ?>
                                            <p style="color:red;">Tenure End Date: <span class="text-display"><?php echo $results[0]['tenureenddate']; ?></span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="additional-details">
                                    <p>Roll Number/Emp Code: <span class="text-display"><?php echo $results[0]['emp_roll']; ?></span><input class="input-display" type="text" name="emp_roll" value="<?php echo $results[0]['emp_roll']; ?>" disabled></p>
                                    <p>Gender: <span class="text-display"><?php echo $results[0]['gender']; ?></span><input class="input-display" type="text" name="gender" value="<?php echo $results[0]['gender']; ?>"></p>
                                    <p>Aadhar: <span class="text-display"><?php echo $results[0]['aadhar']; ?></span><input class="input-display" type="text" name="aadhar" value="<?php echo $results[0]['aadhar']; ?>"></p>
                                    <p>Home Contact: <span class="text-display"><?php echo $results[0]['homecontact']; ?></span><input class="input-display" type="text" name="homecontact" value="<?php echo $results[0]['homecontact']; ?>"></p>
                                    <p>Local Address: <span class="text-display"><?php echo $results[0]['localaddress']; ?></span><input class="input-display" type="text" name="localaddress" value="<?php echo $results[0]['localaddress']; ?>"></p>
                                    <p>Medical Condition: <span class="text-display"><?php echo $results[0]['medicalcondition']; ?></span><input class="input-display" type="text" name="medicalcondition" value="<?php echo $results[0]['medicalcondition']; ?>"></p>
                                    <br>
                                    <h2 class="emergency_details">Emergency Contact Details (First Person)</h2>
                                    <p>Person Name: <span class="text-display"><?php echo $results[0]['emename1']; ?></span><input class="input-display" type="text" name="emename1" value="<?php echo $results[0]['emename1']; ?>"></p>
                                    <p>Relation: <span class="text-display"><?php echo $results[0]['emerelation']; ?></span><input class="input-display" type="text" name="emerelation" value="<?php echo $results[0]['emerelation']; ?>"></p>
                                    <p>Contact No: <span class="text-display"><?php echo $results[0]['emecontact']; ?></span><input class="input-display" type="text" name="emecontact" value="<?php echo $results[0]['emecontact']; ?>"></p>
                                    <p>Address: <span class="text-display"><?php echo $results[0]['emeadd']; ?></span><input class="input-display" type="text" name="emeadd" value="<?php echo $results[0]['emeadd']; ?>"></p>
                                </div>
                                <div class="additional-details">
                                    <h2 class="emergency_details">Emergency Contact Details (Second Person)</h2>
                                    <p>Person Name: <span class="text-display"><?php echo $results[0]['emesecondname']; ?></span><input class="input-display" type="text" name="emesecondname" value="<?php echo $results[0]['emesecondname']; ?>"></p>
                                    <p>Relation: <span class="text-display"><?php echo $results[0]['emesecrelation']; ?></span><input class="input-display" type="text" name="emesecrelation" value="<?php echo $results[0]['emesecrelation']; ?>"></p>
                                </div>
                                <button id="edit-btn" class="btn btn-primary" style="margin-left:25px;">Edit</button>
                                <button id="save-btn" class="btn btn-success" style="display: none;">Save</button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- code for dispalying the staff data to the user start here  -->
                <?php
                if ($usertype == 'staff' && $decform == 'yes') {
                ?>
                    <!--- disaplying the form for applying leave start here ----->
                    <div id="tab2" class="container tab-content">
                        <div class="row">
                            <!---- code for registering the leave from the user start here --->
                            <div class="col-md-6 offset-md-3">
                                <h2 class="all_heading" style="text-align:center;">Leave Application Form</h2>
                                <h3 class="allimp_notice">If you are applying the EL kindly apply here as well as Apply on Drona Also
                                    <a href="https://drona.ircc.iitb.ac.in/ircc/index.jsp?LogOut=You%20have%20been%20logged%20Off%20!" target="_blank">Click Here</a>
                                </h3>
                                <br>
                                <?php
                                if ($usertype == "staff") {
                                    $row = $results[0];
                                ?>
                                    <div class="col-md-8">
                                        <h2 class="mb-8 list_cl">Total CL:<span style="color:red;"> <?php echo htmlspecialchars($row['cl']); ?></span></h2>
                                        <h2 class="mb-8 list_cl">Total RH: <span style="color:red;"><?php echo htmlspecialchars($row['rh']); ?></span></h2>
                                    </div>
                                    <div class="col-md-8">
                                        <h2 class="mb-8 list_cl">Remainig CL: <?php echo htmlspecialchars($row['remainingcl']); ?></h2>
                                        <h2 class="mb-8 list_cl">Reamining RH: <?php echo htmlspecialchars($row['remainingrh']); ?></h2>
                                    </div>
                                    <br><br><br>
                                    <br>
                                    <form method="post" action="formsubmit.php/leaveapply" class="form_data">
                                        <div class="form-group">
                                            <label for="cl_start_date">CL Start Date:</label>
                                            <input type="date" class="form-control" id="cl_start_date" name="cl_start_date">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="cl_end_date">CL End Date:</label>
                                            <input type="date" class="form-control" id="cl_end_date" name="cl_end_date">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="cl_days">No. Of CL:</label>
                                            <input type="number" class="form-control" id="cl_days" name="cl" readonly>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="rh_start_date">RH Start Date:</label>
                                            <input type="date" class="form-control" id="rh_start_date" name="rh_start_date">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="rh_end_date">RH End Date:</label>
                                            <input type="date" class="form-control" id="rh_end_date" name="rh_end_date">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="rh_days">No. Of RH:</label>
                                            <input type="number" class="form-control" id="rh_days" name="rh" readonly>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="el_start_date">EL Start Date:</label>
                                            <input type="date" class="form-control" id="el_start_date" name="el_start_date">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="el_end_date">EL End Date:</label>
                                            <input type="date" class="form-control" id="el_end_date" name="el_end_date">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="el_days">No. Of EL:</label>
                                            <input type="number" class="form-control" id="el_days" name="el" readonly>
                                        </div><br>
                                        <div class="form-group">
                                            <label for="reason">Reason:</label>
                                            <input type="text" class="form-control" id="reason" name="reason" required>
                                        </div>
                                        <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>" />
                                        <br>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!------ code for dispalying the all the data to the user based on user type ------->
                    <div id="tab3" class="container tab-content">
                        <div class="row">
                            <div class="col-md-12 ">
                                <h2 class="mb-4" style="text-align:center;">Leave Status</h2>
                                <div id="tabulator-table"></div>
                                <!--<div class="pagination-btn" onclick="table.previousPage()">Previous</div>-->
                                <!--<div class="pagination-btn" onclick="table.nextPage()">Next</div>-->
                            </div>
                        </div>
                    </div>
                <?php
                } elseif ($usertype == 'hr') {
                ?>
                    <div id="tab3" class="container tab-content ">
                        <div class="row">
                            <div class="col-md-12 ">
                                <h2 class="mb-4 all_heading">Leave Status</h2>
                                <div id="tabulator-table"></div>
                                <!--<div class="pagination-btn" onclick="table.previousPage()">Previous</div>-->
                                <!--<div class="pagination-btn" onclick="table.nextPage()">Next</div>-->
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- code for dispalying the resigantion form for everyone -->
                <?php
                if ($usertype == 'staff' || $usertype == 'intern' || $usertype == 'student') {
                ?>
                    <div id="tab5" class="container tab-content">
                        <div class="row">
                            <marquee behavior="scroll" direction="left" scrollamount="5" class="allimp_notice" style="color:red;">
                                Please fill all the details very carefully.
                            </marquee>
                            <div class="col-md-12 ">
                                <div class="container col-md-6 mt-3">
                                    <h2 class="all_heading">RESIGNATION FORM</h2>
                                    <form method="post" action="formsubmit.php/resign">
                                        <input type="hidden" name="sid" value="<?php echo $decform = $results[0]['sid']; ?>">
                                        <!-- <div class="mb-3 mt-3">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="emp_roll">Emp/Roll No:</label>
                                <input type="text" class="form-control" id="emp_roll" placeholder="Enter Employee" name="emp_roll">
                            </div> -->
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

                                        <h2>
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
                                                    <label class="form-check-label" for="Drawer_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="Drawer_yesno" id="Drawer_no" value="no">
                                                    <label class="form-check-label" for="Drawer_no">No</label>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label" for="Cupboard Keys">Cupboard Keys</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="CupboardKeys_yesno" id="Cupboard Keys_yes" value="yes">
                                                    <label class="form-check-label" for="Cupboard Keys_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="CupboardKeys_yesno" id="Cupboard Keys_no" value="no">
                                                    <label class="form-check-label" for="Cupboard Keys_no">No</label>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label" for="labbook">Lab books returned</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="labbookyesno" id="labbookyes" value="yes">
                                                    <label class="form-check-label" for="labbookyes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="labbookyesno" id="labbookno" value="no">
                                                    <label class="form-check-label" for="labbookno">No</label>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="hardware">Laptop, hard drive, pendrive, etc</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="hardwareno" id="hardware" value="yes">
                                                    <label class="form-check-label" for="hardware">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="hardwareno" id="labbookno" value="no">
                                                    <label class="form-check-label" for="labbookno">No</label>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label" for="tools">Tools used/unused</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="toolsno" id="tools" value="yes">
                                                    <label class="form-check-label" for="tools">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="toolsno" id="labbookno" value="no">
                                                    <label class="form-check-label" for="labbookno">No</label>
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
                                                    <label class="form-check-label" for="labbookno">No</label>
                                                </div>
                                            </div>

                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab10" class="container tab-content">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="container col-md-6 mt-3">
                                    <h2 class="all_heading">Apply for Gate Pass</h2>
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

                <?php } ?>


                <!-- code for applying certficate for the intern -->
                <?php
                if ($usertype == 'intern' || $usertype == 'student') {
                ?>
                    <div id="tab6" class="container tab-content">
                        <div class="row">
                            <marquee behavior="scroll" direction="left" scrollamount="5" class="allimp_notice" style="color:red;">
                                Please fill all the details very carefully.
                            </marquee>
                            <div class="col-md-12 ">
                                <div class="container col-md-6 mt-3">
                                    <h2 class="all_heading">Certificate Form</h2>
                                    <form method="post" action="formsubmit.php/certificate">
                                        <input type="hidden" name="sid" value="<?php echo $decform = $results[0]['sid']; ?>">
                                        <div class="mb-3 mt-3">
                                            <label for="profname">Professor Name:</label>
                                            <input type="text" class="form-control" id="profname" name="profname" placeholder="Enter name Professor Name" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="pi" name="name" placeholder="Enter Your Certificate Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="collegename">College Name:</label>
                                            <input type="text" class="form-control" id="start_date" name="collegename" placeholder="University/College Name" required>
                                        </div><br>

                                        <div class="form-group">
                                            <label for="internshipdate">Start Date of Internship:</label>
                                            <input type="date" class="form-control" id="internshipdate" name="internshipdate" required>
                                        </div><br>

                                        <div class="form-group">
                                            <label for="internshipdateend">End Date of Internship:</label>
                                            <input type="date" class="form-control" id="internshipdate" name="internshipdateend" required>
                                        </div><br>

                                        <div class="mb-3 mt-3">
                                            <label for="point_internship">4-5 points about the project/work done during the Internship:</label>
                                            <input type="text" class="form-control" id="point_internship" name="point_internship" placeholder="Enter what you have learned during your internship ">
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>


                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        <?php } ?>


        <?php if ($usertype == 'hr') { ?>
            <!--  this code is for updating the details of user for the hr team  -->
            <div id="tab4" class="container tab-content  active-tab">
                <div class="row">
                    <div class="col-md-12 ">
                        <h2 class="mb-4 all_heading" style="text-align:center;">User Details</h2>
                        <div id="userdetails"></div>
                    </div>
                </div>
            </div>

            <!-- code for displaying the data of certifiate form teh user  -->
            <div id="tab7" class="container tab-content">
                <div class="row">
                    <div class="col-md-12 ">
                        <button id="openPopupBtn">Send Certificate</button>
                        <div class="container col-md-12 mt-3">
                            <h2 class="all_heading">Certificate Request</h2>
                            <div id="certificate"></div>
                        </div>

                        <!----code for sending the certificate to intern  --->
                        <div id="popupForm" class="popup">
                            <div class="popup-content">
                                <span class="close">&times;</span>
                                <form method="post" action="formsubmit.php/sendcertificate" enctype="multipart/form-data">
                                    <input type="hidden" name="sid" value="<?php echo htmlspecialchars($results[0]['sid']); ?>">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" required>
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" name="name" required>

                                    <label for="pdf">Select PDF:</label>
                                    <input type="file" id="pdf" name="pdf" accept="application/pdf" required>

                                    <button type="submit" name="submit">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- code for list of user resign -->
            <div id="tab8" class="container tab-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container col-md-12 mt-3">
                            <h2 class="all_heading">Resignation of User</h2>
                            <div id="resign"></div>
                        </div>
                    </div>
                </div>
            </div>

        <?php  } ?>

        <?php if ($usertype !== "student") { ?>

            <div id="tab11" class="container tab-content ">
                <div class="row">
                    <div class="col-md-12 ">
                        <?php if ($usertype == "hr") { ?>
                            <button id="openPopupBtngatepass">Send Gate Pass</button>
                        <?php } ?>
                        <h2 class="mb-4 all_heading" style="text-align:center;">Request For Gate Pass</h2>
                        <div id="gatepass"></div>

                        <!-- code for sedndinge teh gate pass to user  -->
                        <div id="popupFormgatepass" class="popup">
                            <div class="popup-content">
                                <span class="close">&times;</span>
                                <form method="post" action="formsubmit.php/sendgatepass" enctype="multipart/form-data">
                                    <input type="hidden" name="sid" value="<?php echo htmlspecialchars($results[0]['sid']); ?>">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" required>
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" name="name" required>

                                    <label for="pdf">Select PDF:</label>
                                    <input type="file" id="pdf" name="pdf" accept="application/pdf" required>

                                    <button type="submit" name="submit">Send</button>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        <?php } ?>

        </div>

        <!----- code for dispaly gate pass status   ---->


    </div>

    <br><br><br><br>

    <!-- code for footer start here -->
    <?php include 'footer.php' ?>;

    <!-- code for edit the data and send it to the database  -->
    <script>
        document.getElementById('edit-btn').addEventListener('click', function() {
            var inputs = document.querySelectorAll('.input-display');
            var textDisplays = document.querySelectorAll('.text-display');

            inputs.forEach(function(input) {
                if (input.name !== 'emp_roll') {
                    input.disabled = false;
                    input.style.display = 'inline';
                }
            });
            textDisplays.forEach(function(text) {
                text.style.display = 'none';
            });

            document.getElementById('edit-icon').style.display = 'inline';
            document.getElementById('edit-btn').style.display = 'none';
            document.getElementById('save-btn').style.display = 'inline-block';
        });

        document.getElementById('edit-icon').addEventListener('click', function() {
            document.getElementById('profile-pic-input').click();
        });

        document.getElementById('profile-pic-input').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-img').src = e.target.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });

        document.getElementById('save-btn').addEventListener('click', function() {
            var inputs = document.querySelectorAll('.input-display');
            var textDisplays = document.querySelectorAll('.text-display');
            var formData = new FormData();
            inputs.forEach(function(input) {
                input.disabled = true;
                input.style.display = 'none';
                formData.append(input.name, input.value);
            });
            textDisplays.forEach(function(text, index) {
                if (inputs[index]) {
                    text.innerText = inputs[index].value;
                    text.style.display = 'inline';
                } else {
                    console.error('Input element not found for text span:', text);
                }
            });

            document.getElementById('edit-icon').style.display = 'none';
            document.getElementById('edit-btn').style.display = 'inline-block';
            document.getElementById('save-btn').style.display = 'none';

            var profilePicInput = document.getElementById('profile-pic-input');
            if (profilePicInput.files.length > 0) {
                formData.append('profilepic', profilePicInput.files[0]);
            } else {
                var previousProfilePicUrl = document.getElementById('profile-img').src;
                console.log(previousProfilePicUrl);
                formData.append('previous_profilepic', previousProfilePicUrl);
            }

            // Append the sid value explicitly
            var sid = document.getElementById('sid').value;
            formData.append('sid', sid);

            // Log all form data entries
            console.log([...formData.entries()]);
            /* code for sending teh data to database */
            try {
                fetch('formsubmit.php/editprofile', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        if (data.status === "success") {
                            console.log("Data received successfully:", data.data);
                        } else {
                            console.error("Error:", data.message);
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error.message);
                    });
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error.message);
            }
        });


        /* code for cheking is year is changed or not  */
        function yearchanged() {
            var yearchanged = 2025;
            try {
                fetch('formsubmit.php/updatecl_ruh', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            year: yearchanged
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        if (data.status === "success") {
                            // console.log("Data received successfully:", data.data);
                        } else {
                            console.error("Error:", data.message);
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error.message);
                    });
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error.message);
            }
        }
        // setInterval(yearchanged, 1000);

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

    <script>
        /* code for displaying multipage form start here  */
        function nextPage(pageNumber) {
            const currentPage = document.querySelector('.form-page.active');
            const nextPage = document.getElementById('page' + pageNumber);
            if (currentPage) {
                currentPage.classList.remove('active');
            }
            if (nextPage) {
                nextPage.classList.add('active');
            }
        }

        function previousPage(pageNumber) {
            nextPage(pageNumber);
        }
        document.getElementById('multiPageForm').addEventListener('input', function(e) {
            const input = e.target;
            if (input.id === 'postal') {
                const errorMessage = document.getElementById('error-message');
                if (input.value.length !== 6) {
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            }
        });
        window.onload = function() {
            document.getElementById('page1').classList.add('active');
        }

        // code for the validating the contact number 
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            const phoneInput = document.getElementById('localadd');
            const phoneError = document.getElementById('phone-error');
            const phoneNumber = phoneInput.value;

            const phonePattern = /^\d{10}$/;

            if (!phonePattern.test(phoneNumber)) {
                phoneError.style.display = 'block';
                phoneInput.focus();
                event.preventDefault();
            } else {
                phoneError.style.display = 'none';
            }
        });
    </script>
    <!---- javascript code start here  ---->
    <script src="js/index.js"></script>
    <script src="js/certificate.js"></script>
    <script src="js/validation.js"></script>



    <!-- code for leave status start here -->
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
        // code for dispalying all the data in the table 
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
                                /* cdoe for calculating the differnec between the leave apply  */
                                function calculateDateDifference(startDate, endDate) {
                                    var start = new Date(startDate);
                                    var end = new Date(endDate);
                                    var timeDifference = end - start;
                                    var dayDifference = timeDifference / (1000 * 60 * 60 * 24);

                                    return dayDifference;
                                }
                                var clDateDifference = calculateDateDifference(cellData.clstartdate, cellData.clenddate);
                                var rhDateDifference = calculateDateDifference(cellData.rhstartdate, cellData.rhenddate);
                                console.log("CL Date Difference: " + clDateDifference + " days");
                                console.log("RH Date Difference: " + rhDateDifference + " days");


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
                        console.log(data);
                        // alert("Leave Status Updated Successfully")
                        //   console.log('Database update successful:', data);
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }

            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#tabulator-table", {
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


    <!-- code for dsiaplying list fo userdetails start here  -->
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
        // code for dispalying all the data in the table 
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


    <!-- code for displaying who applied for certificate  -->
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
        // code for dispalying all the data in the table 
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

    <!-- code for dispalying resgination list  -->
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

    <!-- code for dispalying gate pass status start here -->
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

    <!-- code for checking that if tenure is end or not  -->
    <script>
        var results = <?php echo json_encode($userdetails); ?>;
        // console.log(results);
        results.forEach(result => {
            console.log(result.tenureenddate);
            var newValue = result.tenureenddate;
            var dateParts = newValue.split("/");

            if (dateParts.length === 3) {
                var day = parseInt(dateParts[0], 10);
                var month = parseInt(dateParts[1], 10) - 1;
                var year = parseInt(dateParts[2], 10);
                var enteredDate = new Date(year, month, day);

                if (!isNaN(enteredDate.getTime())) {
                    var currentDate = new Date();
                    var timeDiff = enteredDate.getTime() - currentDate.getTime();
                    var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    if (daysDiff < 15) {
                        console.log("less than or equal to 15 days:", result.name, result.email);
                        var name = result.name;
                        var email = result.email;
                        sendtenuredetail(name, email)
                    } else {
                        console.log("greater than or equal to 15");
                    }
                } else {
                    console.error("Invalid date format entered:", newValue);
                    // cell.getElement().style.backgroundColor = "";
                }
            } else {
                console.error("Invalid date format entered:", newValue);
                // cell.getElement().style.backgroundColor = "";
            }
        });

        function sendtenuredetail(name, email) {
            console.log(name, email);
            fetch('formsubmit.php/tenurenotification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },

                    body: 'name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email)
                })
                .then(response => response.text())
                .then(data => {
                    // alert("")
                })
                .catch(error => {
                    console.error('Error updating database:', error);
                });
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>