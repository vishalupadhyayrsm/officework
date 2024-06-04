<?php
session_start();
// include 'dbconfig.php';
// Establish connection to the database
$servername = "localhost";
$username = "root";
$password = ""; // Please replace with your actual database password
$dbname = "device_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the action is for registration or login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $designation = htmlspecialchars($_POST['designation']);
    $sittingspace = htmlspecialchars($_POST['sittingspace']);
    $password = htmlspecialchars($_POST['password']);
    $field = htmlspecialchars($_POST['field']);
    $lab = htmlspecialchars($_POST['lab']);
echo  $name;
echo $email;
echo $designation;
echo $sittingspace;
echo $password;
echo $field;
echo $lab;

    $checkEmailQuery = "SELECT * FROM userdetails WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    // print_r($result);
    if ($result->$num_rows > 0) {
        $response = array("status" => "error", "message" => "Email Already Exists");
        echo json_encode($response);
    } else {
        // echo "hello";
        // Hash the password
        $hash_password = password_hash($password, PASSWORD_BCRYPT);
        echo $hash_password;
        // Insert new user
        $insertQuery = "INSERT INTO userdetails (`name`, `email`,`designation`,`sittingspace`, `password`, `field`, `lab`) VALUES ('$name','$email','$designation','$sittingspace','$hash_password','$field','$lab')";
        if ($conn->query($insertQuery) == TRUE) {
            $response = array("status" => "success", "message" => "Record inserted successfully");
            // header("Location: login.php");
            // echo "Success";
        } else {
            $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
            echo "failed";
        }
    }
}

 
$conn->close();
?>