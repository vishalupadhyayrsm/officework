<?php
session_start();
include 'dbconfig.php';

$sid = isset($_GET['sid']) ? $_GET['sid'] : null;

$sql = "SELECT sg.`sid`,sg.`name`, sg.`email`, sg.`usertype`,sg.`tenureenddate`, sg.`contact`, sg.`cl`, sg.`rh`,sg.`el`, sg.remainingcl, sg.remainingrh,sg.remainingel, sg.declarationform,lt.leaveid, lt.`clstartdate`, lt.`clenddate`,lt.`rhstartdate`, lt.`rhenddate`, lt.`elstartdate`, lt.`elenddate`,  lt.`reason`, lt.`leave_status`,de.declarationform,de.emp_roll,de.`univesity`,de.name,de.iitbemail,de.aadhar,de.gender,de.localaddress,de.localpostal,de.permanentadd,de.permpostal, de.homecontact,de.emename1,de.emerelation,de.emeadd,de.emecontact,de.empostalcode,de.emesecondname,de.emesecrelation,de.medicalcondition,de.profilepic
FROM `sigin` as sg LEFT JOIN leavetable as lt on lt.sid = sg.sid LEFT JOIN declarationform as de on de.sid = sg.sid where sg.sid=:sid ";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':sid', $sid);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($results);

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
                <!-- <button id="edit-btn" class="btn btn-primary" style="margin-left:25px;">Edit</button>
                <button id="save-btn" class="btn btn-success" style="display: none;">Save</button> -->
            </div>
        </div>
    </div>



    <?php include 'footer.php' ?>;


</body>

</html