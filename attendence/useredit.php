<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $formData = $_POST;
    var_dump($formData);
    echo "hello";
} else {
    // Invalid request
    echo "Invalid request";
}
