<?php
// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $formData = $_POST;
    print_r($formData);
} else {
    // Invalid request
    echo "Invalid request";
}
