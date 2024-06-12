<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include_once("dbconfig.php");
include_once("api.php");

// Retrieve the request endpoint
$uri = explode("/", $_SERVER["REQUEST_URI"]);
$apidata = $uri[3];
$endpoint = $uri[4];
// echo $endpoint;

$result = array();

switch ($endpoint) {
    case "deceleration":
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
                $insertQuery = "INSERT INTO `declarationform`(`sid`,`declarationform`, `name`, `emp_roll`, `gender`, `localaddress`, `localpostal`, `permanentadd`, `permpostal`, `homecontact`, `emename1`, `emerelation`, `emeadd`, `emecontact`, `empostalcode`, `emesecondname`, `emesecrelation`, `medicalcondition`, `term`,`profilepic`) 
                                VALUES ('$sid','yes','$name','$emproll','$gender','$localadd','$localpostalcode','$permadd','$permapostalcode','$homephone','$emergencyname1','$relationship1',
                                '$localadd_emergency1','$emecontact1','$localpostalcode_emergency1','$emergencyname2','$relationship2','$medicalcondition','$termsCheck','$uploadedFilePath')";
                if ($conn->query($insertQuery) == TRUE) {

                    // $updateformdata = "UPDATE `sigin` SET `declarationform` = :declarationform WHERE sid = :sid";
                    // $stmt = $conn->prepare("UPDATE `sigin` SET `declarationform` = 'yes' WHERE sid = :sid");
                    // $stmt->bindParam(':sid', $sid);
                    // $stmt->execute();
                    $_SESSION['dec_form'] = true;
                    header("Location: ../index.php");
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
        break;

    case "resign":
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
                // $response = array("status" => "success", "message" => "Record inserted successfully");
                // echo '<script>alert("Successfully Submitted"); window.location.href = "index.php";</script>';
                $_SESSION['resign_form'] = true;
                header("Location: ../index.php");
                exit();
            } else {
                $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
                echo "failed";
            }
        }
        break;

    case "certificate":
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
            if ($conn->query($insertquery) == TRUE) {
                $response = array("status" => "success", "message" => "Record inserted successfully");
                // echo '<script>alert("Record inserted successfully");</script>';
                // echo '<script>console.log("Record inserted successfully");</script>';
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                exit();
                // echo '<script>alert("Your application has been sent to Admin"); window.location.href = "index.php";</script>';
            } else {
                $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
                echo "failed";
            }
        }
        break;
    case "editprofile":
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $sid = isset($_POST['sid']) ? $_POST['sid'] : '';
                $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
                $email = isset($_POST['email']) ? $_POST['email'] : '';
                $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
                $homecontact = isset($_POST['homecontact']) ? $_POST['homecontact'] : '';
                $localaddress = isset($_POST['localaddress']) ? $_POST['localaddress'] : '';
                $medicalcondition = isset($_POST['medicalcondition']) ? $_POST['medicalcondition'] : '';
                $emename1 = isset($_POST['emename1']) ? $_POST['emename1'] : '';
                $emerelation = isset($_POST['emerelation']) ? $_POST['emerelation'] : '';
                $emecontact = isset($_POST['emecontact']) ? $_POST['emecontact'] : '';
                $emeadd = isset($_POST['emeadd']) ? $_POST['emeadd'] : '';
                $emesecondname = isset($_POST['emesecondname']) ? $_POST['emesecondname'] : '';
                $emesecrelation = isset($_POST['emesecrelation']) ? $_POST['emesecrelation'] : '';
                $profilepic = isset($_FILES['profilepic']) ? $_FILES['profilepic'] : '';
                if (empty($profilepic['name'])) {
                    die('No file selected for upload.');
                }
                $uploadDirectory = 'uploads/';
                if (!file_exists($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }
                $uploadedFilePath = $uploadDirectory . basename($profilepic['name']);
                move_uploaded_file($profilepic['tmp_name'], $uploadedFilePath);
                $stmt = $conn->prepare("UPDATE `sigin` SET `email` = :email, `contact` = :contact WHERE sid = :sid");
                $stmt->bindParam(":sid", $sid);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":contact", $contact);
                $stmt->execute();

                $stmt = $conn->prepare("UPDATE `declarationform` SET 
                `gender` = :gender,
                `localaddress` = :localaddress,
                `homecontact` = :homecontact,
                `emename1` = :emename1,
                `emerelation` = :emerelation,
                `emeadd` = :emeadd,
                `emecontact` = :emecontact,
                `emesecondname` = :emesecondname,
                `emesecrelation` = :emesecrelation,
                `medicalcondition` = :medicalcondition,
                `profilepic` = :profilepic
                WHERE `sid` = :sid");

                $stmt->bindParam(':sid', $sid);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':localaddress', $localaddress);
                $stmt->bindParam(':homecontact', $homecontact);
                $stmt->bindParam(':emename1', $emename1);
                $stmt->bindParam(':emerelation', $emerelation);
                $stmt->bindParam(':emeadd', $emeadd);
                $stmt->bindParam(':emecontact', $emecontact);
                $stmt->bindParam(':emesecondname', $emesecondname);
                $stmt->bindParam(':emesecrelation', $emesecrelation);
                $stmt->bindParam(':medicalcondition', $medicalcondition);
                $stmt->bindParam(':profilepic', $uploadedFilePath);

                $stmt->execute();



                $response = array(
                    'status' => 'Success',
                    "data" => $profilepic,
                );
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        } catch (Exception $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Exception caught: ' . $e->getMessage(),
            );
            echo json_encode($response);
        }
        break;

    case "leaveapproved":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $lid = $_POST['lid'];
                $status = $_POST['status'];
                $stmt = $conn->prepare("UPDATE `leavetable` SET `leave_status` = :status WHERE `leaveid` = :lid");
                $stmt->bindParam(':lid', $lid);
                $stmt->bindParam(':status', $status);
                $stmt->execute();

                if ($stmt->errorCode() === '00000') {
                    $response = ['status' => 'success', 'message' => 'Database update successful', 'data' => ['lid' => $lid, 'status' => $status]];
                    echo json_encode($response);
                } else {
                    $errors = $stmt->errorInfo();
                    echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $errors]);
                }
            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
        break;

    default:
        break;
}
