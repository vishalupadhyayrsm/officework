<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    // $serial_number = $_POST
    // Database connection parameters
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "device_management_system";

    // Create a connection to the database
    $conn = new mysqli($host, $user, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $cameraname = $_POST['cameraname'];
    $category = $_POST['category'];
    $configuration = $_POST['configuration'];
    $ip = $_POST['ip'];
    $monitor = $_POST['monitor'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO camera (CameraName, category, configuration, IpAddress , monitor, status, remark) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $cameraname, $category, $configuration, $ip, $monitor, $status, $remark);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    // Close the statement and connection
    $stmt->close();
    $conn->close();

    echo $cameraname;
    echo $category;
    echo $configuration;
    echo $ip;
    echo $monitor;
    echo $status;
    echo $remark;
}
?>

