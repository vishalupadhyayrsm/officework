<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include_once("../dbconfig.php");
include_once("api.php");

$email = $_SESSION['user_email'];
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$sid = $_SESSION['userid'];
// echo $sid;
// echo "hello";
// Retrieve the request endpoint
$uri = explode("/", $_SERVER["REQUEST_URI"]);
// print_r($uri);
$endpoint = $uri[3];
// $endpoint = $uri[3];
// echo $endpoint;
// Determine the action based on the endpoint
$action = isset($_GET['action']) ? $_GET['action'] : '';

$email = $_SESSION['user_email'];
// echo $endpoint;
switch ($endpoint) {
    case "CAMERA":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // echo 'heloo';
            $cameraname = $_POST['cameraname'];
            $category = $_POST['category'];
            $configuration = $_POST['configuration'];
            $IpAddress = $_POST['IpAddress'];
            $monitor = $_POST['monitor'];
            $status = $_POST['status'];
            $remark = $_POST['remark'];
            $lab = $_POST['lab'];
            $insertQuery = "INSERT INTO `camera`(`CameraName`, `category`, `configuration`, `IpAddress`, `monitor`, `status`, `remark`, `lab`) VALUES ('$cameraname','$category','$configuration','$IpAddress','$monitor','$status','$remark','$lab')";

            if ($conn->query($insertQuery) == TRUE) {
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                //  header("Location: index.php");
                exit();
                // echo "New record created successfully";
            }
        }
        break;

    case "ThinClientMachines":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $MachineName = $_POST['MachineName'];
            $SerialNumber = $_POST['SerialNumber'];
            $configuration = $_POST['configuration'];
            $location = $_POST['location'];
            $IpAddress = $_POST['IpAddress'];
            $user = $_POST['user'];
            $status = $_POST['status'];
            $remark = $_POST['remark'];

            $insertQuery = "INSERT INTO `thinclientmachines`(`MachineName`, `SerialNumber`, `configuration`, `location`, `IpAddress`, `user`, `status`, `remark`) 
        VALUES ('$MachineName', '$SerialNumber', '$configuration', '$location', '$IpAddress', '$user', '$status', '$remark')";

            if ($conn->query($insertQuery) == TRUE) {
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                exit();
            }
        }
        break;
    case "DesktopMachines":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $category = $_POST['category'];
            $ComputerName = $_POST['ComputerName'];
            $ExtraLanCard = $_POST['ExtraLanCard'];
            $configuration = $_POST['configuration'];
            $IpAddress = $_POST['IpAddress'];
            $user = $_POST['user'];
            $status = $_POST['status'];
            $remark = $_POST['remark'];

            $insertQuery = "INSERT INTO `desktopmachines`(`category`, `ComputerName`, `ExtraLanCard`, `configuration`, `IpAddress`, `user`, `status`, `remark`) 
        VALUES ('$category', '$ComputerName', '$ExtraLanCard', '$configuration', '$IpAddress', '$user', '$status', '$remark')";

            if ($conn->query($insertQuery) == TRUE) {
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                exit();
            }
        }
        break;

    case "LaptopMachines":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $SerialNumber = $_POST['SerialNumber'];
            $ModelNumber = $_POST['ModelNumber'];
            $ComputerName = $_POST['ComputerName'];
            $configuration = $_POST['configuration'];
            $IpAddress = $_POST['IpAddress'];
            $user = $_POST['user'];
            $status = $_POST['status'];
            $remark = $_POST['remark'];

            $insertQuery = "INSERT INTO `laptopmachines`(`SerialNumber`, `ModelNumber`, `ComputerName`, `configuration`, `IpAddress`, `user`, `status`, `remark`) 
        VALUES ('$SerialNumber', '$ModelNumber', '$ComputerName', '$configuration', '$IpAddress', '$user', '$status', '$remark')";

            if ($conn->query($insertQuery) == TRUE) {
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                exit();
            }
        }
        break;

    case "PrinterScanner":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $PrinterName = $_POST['PrinterName'];
            $category = $_POST['category'];
            $configuration = $_POST['configuration'];
            $IpAddress = $_POST['IpAddress'];
            $user = $_POST['user'];
            $status = $_POST['status'];
            $remark = $_POST['remark'];

            $insertQuery = "INSERT INTO `printerscanner`(`PrinterName`, `category`, `configuration`, `IpAddress`, `user`, `status`, `remark`) 
        VALUES ('$PrinterName', '$category', '$configuration', '$IpAddress', '$user', '$status', '$remark')";

            if ($conn->query($insertQuery) == TRUE) {
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                exit();
            }
        }
        break;

    case "ServerMachines":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = $_POST['servername'];
            $category = $_POST['category'];
            $configuration = $_POST['configuration'];
            $IpAddress = $_POST['IpAddress'];
            $user = $_POST['user'];
            $status = $_POST['status'];
            $remark = $_POST['remark'];

            $insertQuery = "INSERT INTO `servermachines`(`servername`, `category`, `configuration`, `IpAddress`, `user`, `status`, `remark`) 
        VALUES ('$servername', '$category', '$configuration', '$IpAddress', '$user', '$status', '$remark')";

            if ($conn->query($insertQuery) == TRUE) {
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                exit();
            }
        }
        break;

    case "WifiDevices":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $EquipmentName = $_POST['EquipmentName'];
            $category = $_POST['category'];
            $configuration = $_POST['configuration'];
            $IpAddress = $_POST['IpAddress'];
            $user = $_POST['user'];
            $status = $_POST['status'];
            $remark = $_POST['remark'];

            $insertQuery = "INSERT INTO `wifidevices`(`EquipmentName`, `category`, `configuration`, `IpAddress`, `user`, `status`, `remark`) 
        VALUES ('$EquipmentName', '$category', '$configuration', '$IpAddress', '$user', '$status', '$remark')";

            if ($conn->query($insertQuery) == TRUE) {
                $_SESSION['form_submitted'] = true;
                header("Location: ../index.php");
                exit();
            }
        }
        break;
        
    case "Complaint":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $devicename = $_POST['devicename'];
                $description = $_POST['description'];
                $issuedon = $_POST['issuedon'];
                $email = $_POST['email'];
                // $sid = $_POST['sid'];
                
                // Select query to fetch user details
                $selectQuery = "SELECT `sid`, `name`, `empcode`, `email`, `usertype` FROM `sigin` WHERE sid = :sid";
                $stmt = $conn->prepare($selectQuery);
                $stmt->bindParam(':sid', $sid, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                // print_r($result); 
                if ($result) {
                    $email = $result['email'];
                    $name = $result['name'];
                    $usertype = $result['usertype'];
                    // Insert query with placeholders to prevent SQL injection
                    $insertQuery = "INSERT INTO `complaintform`(`devicename`, `description`, `issuedon`, `email`, `name`, `usertype`) 
                                    VALUES (:devicename, :description, :issuedon, :email, :name, :usertype)";
                    $stmt = $conn->prepare($insertQuery);
                    $stmt->bindParam(':devicename', $devicename, PDO::PARAM_STR);
                    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
                    $stmt->bindParam(':issuedon', $issuedon, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':usertype', $usertype, PDO::PARAM_STR);
            
                    if ($stmt->execute()) {
                        $_SESSION['complaint_submitted'] = true;
                        header("Location: /system");
                        exit();
                    } else {
                        // Handle error in insertion
                        echo "Error: Could not submit complaint.";
                    }
                } else {
                    // Handle error if user not found
                    echo "Error: User not found.";
                }
            }

        break;
        
    default:
        break;
}

switch ($action) {
    case 'complainttable':
        if ($usertype === 'systemadmin') {
        $sql = "SELECT * FROM complaintform";
        // $sql = 'SELECT complaintform.*, sigin.* FROM complaintform LEFT JOIN sigin ON complaintform.sid = sigin.sid;';
        // $sql  ="SELECT * FROM table1 UNION ALL SELECT * FROM table2";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    } else {
        $sql = "SELECT * FROM complaintform WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
    }

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

        break;

    case 'cameratable':
    // SQL query to fetch all data from the camera table
        $selectQuery = "SELECT * FROM camera";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;

    case 'thinclientmachinestable':
        $selectQuery = "SELECT * FROM thinclientmachines";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;

    case 'desktopmachinestable':
        $selectQuery = "SELECT * FROM desktopmachines";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;

    case 'laptopmachinestable':
        $selectQuery = "SELECT * FROM laptopmachines";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;

    case 'printerscannertable':
        $selectQuery = "SELECT * FROM printerscanner";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;

    case 'servermachinestable':
        $selectQuery = "SELECT * FROM servermachines";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;
    
    case 'wifidevicestable':
        $selectQuery = "SELECT * FROM wifidevices";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;
    
    case 'usertable':
        $selectQuery = "SELECT * FROM userdetails";
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if there are results
        if ($stmt->rowCount() > 0) {
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } else {
            echo json_encode([]);
        }

    break;
    
        case 'updatestatus':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the data from the request
                $sno = $_POST['sno'];
                $status = $_POST['status'];
           
        try {
            // Prepare an update statement
            $stmt = $conn->prepare("UPDATE complaintform SET status = :status WHERE sno = :sno");
            // Bind the parameters
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':sno', $sno, PDO::PARAM_INT);

            // Execute the statement
            if ($stmt->execute()) {
                // Send a success response
                echo json_encode(['success' => true, 'message' => 'Data updated successfully']);
            } else {
                // Send an error response
                echo json_encode(['success' => false, 'message' => 'Error updating data']);
            }
        } catch (PDOException $e) {
            // Send an error response
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
            break;


    default:
        break;
}
?>