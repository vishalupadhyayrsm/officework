<?php
// Start session
session_start();

// Establish connection to the database
$servername = "localhost";
$username = "root";
$dbpassword = ""; // Please replace with your actual database password
$dbname = "device_management_system";

// Create connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch userdetails data
$sql = "SELECT name, email, designation, sittingspace, field, lab FROM userdetails";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
