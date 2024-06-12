<?php
session_start();
include 'dbconfig.php';

if (isset($_POST['submit'])) {
    $sid = $_POST['sid'];
    $startdate = $_POST['start_date'];
    $terminationdate = $_POST['termination_date'];
    $principle = $_POST['principle'];
    $startingposition = $_POST['start_postion'];
    $ending_postion = $_POST['ending_postion'];
    $planafterleaving = $_POST['planafterleaving'];
    $imporove_suggestion = $_POST['imporove_suggestion'];
    $what_mostlike = $_POST['what_mostlike'];
    $what_leastlike = $_POST['what_leastlike'];
    $taking_anotherjob = $_POST['taking_anotherjob'];
    $new_place_job = $_POST['new_place_job'];
    $improvement = $_POST['improvement'];
    $reason_leaving = $_POST['reason_leaving'];
    $Drawer_yesno = $_POST['Drawer_yesno'];
    $CupboardKeys_yesno = $_POST['CupboardKeys_yesno'];
    $labbookyesno = $_POST['labbookyesno'];
    $hardwareno = $_POST['hardwareno'];
    $toolsno = $_POST['toolsno'];
    $anyothersno = $_POST['anyothersno'];

    $insertQuery = "INSERT INTO `resigndata`(`sid`, `pi_name`, `start_date`, `terminationdate`, `startingposition`, `endingpostion`, `reason_leaving`, `planafterleaving`, `imporove_suggestion`, `what_mostlike`, `what_leastlike`, `taking_anotherjob`, `new_place_job`, `improvement`, `Drawer_yesno`, `CupboardKeys_yesno`, `labbookyesno`, `hardwareno`, `anyothersno`) 
    VALUES ('$sid','$principle','$startdate','$terminationdate','$startingposition','$ending_postion','$reason_leaving','$planafterleaving','$imporove_suggestion','$what_mostlike','$what_leastlike','$taking_anotherjob','$new_place_job','$improvement','$Drawer_yesno','$CupboardKeys_yesno','$labbookyesno','$hardwareno','$anyothersno')";

    if ($conn->query($insertQuery) == TRUE) {
        // $stmt = $conn->prepare("UPDATE `sigin` SET `resign`='yes' WHERE sid = :sid");
        // $stmt->bindParam(":sid", $sid);
        // $stmt->execute();
        $response = array("status" => "success", "message" => "Record inserted successfully");
        echo '<script>alert("Successfully Submitted"); window.location.href = "index.php";</script>';
    } else {
        $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
        echo "failed";
    }
}
