<?php
session_start();
include 'dbconfig.php';

if (isset($_POST['submit'])) {
    $sid = $_POST['sid'];
    $profname = $_POST['profname'];
    $name = $_POST['name'];
    $collegename = $_POST['collegename'];
    $internshipdate = $_POST['internshipdate'];
    $internshipdateend = $_POST['internshipdateend'];
    $point_internship = $_POST['point_internship'];

    $insertquery = "INSERT INTO `certificate`( `sid`, `piname`, `username`, `collegename`, `start_date`, `end_date`, `workdone`) 
    VALUES ('$sid','$profname','$name','$collegename','$internshipdate','$internshipdateend',' $point_internship')";
    echo "hello";

    if ($conn->query($insertquery) == TRUE) {
        $response = array("status" => "success", "message" => "Record inserted successfully");
        echo '<script>alert("Your application has been sent to Admin"); window.location.href = "index.php";</script>';
    } else {
        $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
        echo "failed";
    }
}
