<?php
session_start();
include 'dbconfig.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sid = $_SESSION['userid'] ?? '';
    $name = $_POST['name'] ?? '';
    $emproll = $_POST['emproll'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $localadd = $_POST['localadd'] ?? '';
    $localpostalcode = $_POST['localpostalcode'] ?? '';
    $permadd = $_POST['permadd'] ?? '';
    $permapostalcode = $_POST['permapostalcode'] ?? '';
    $homephone = $_POST['phone'] ?? '';
    $emergencyname1 = $_POST['emergencyname1'] ?? '';
    $relationship1 = $_POST['relationship1'] ?? '';
    $localadd_emergency1 = $_POST['localadd_emergency1'] ?? '';
    $emecontact1 = $_POST['emephone1'] ?? '';
    $localpostalcode_emergency1 = $_POST['localpostalcode_emergency1'] ?? '';
    $emergencyname2 = $_POST['emergencyname2'] ?? '';
    $relationship2 = $_POST['relationship2'] ?? '';
    $medicalcondition = $_POST['medicalcondition'] ?? '';
    $termsCheck = $_POST['termcheck'] ?? '';
    $video = $_FILES['profileimage'] ?? '';

    if (empty($video['name'])) {
        die('No file selected for upload.');
    }
    $uploadDirectory = 'uploads/';
    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $uploadedFilePath = $uploadDirectory . basename($video['name']);
    if (move_uploaded_file($video['tmp_name'], $uploadedFilePath)) {
        // echo "Successfully uploaded";

        $insertQuery = "INSERT INTO `declarationform`(`sid`,`declarationform`, `name`, `emp_roll`, `gender`, `localaddress`, `localpostal`, `permanentadd`, `permpostal`, `homecontact`, `emename1`, `emerelation`, `emeadd`, `emecontact`, `empostalcode`, `emesecondname`, `emesecrelation`, `medicalcondition`, `term`,`profilepic`) 
                        VALUES ('$sid','yes','$name','$emproll','$gender','$localadd','$localpostalcode','$permadd','$permapostalcode','$homephone','$emergencyname1','$relationship1',
                        '$localadd_emergency1','$emecontact1','$localpostalcode_emergency1','$emergencyname2','$relationship2','$medicalcondition','$termsCheck','$uploadedFilePath')";
        if ($conn->query($insertQuery) == TRUE) {

            // $updateformdata = "UPDATE `sigin` SET `declarationform` = :declarationform WHERE sid = :sid";
            // $stmt = $conn->prepare("UPDATE `sigin` SET `declarationform` = 'yes' WHERE sid = :sid");
            // $stmt->bindParam(':sid', $sid);
            // $stmt->execute();
            echo '<script>alert("Successfully Registered"); window.location.href = "index.php";</script>';
            exit;
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->$error;
        }
    } else {
        die('Error uploading the file.');
    }
} else {
    header("Location: index.php");
    exit;
}
