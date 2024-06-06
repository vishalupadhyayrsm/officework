<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$database = "userdetails";

// Create a connection to the database
$conn = new mysqli($host, $user, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
}
?>