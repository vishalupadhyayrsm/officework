<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle text input fields
    $productType = $_POST['producttype'];
    $product = $_POST['product'];
    $date = $_POST['date'];

    // Retrieve the new filename
    $newFilename = $_POST['newfilename'];

    // Handle file upload
    if (isset($_FILES['uploadedfile']) && $_FILES['uploadedfile']['error'] == 0) {
        // Determine upload directory based on product type
        $uploadDirectory = ($productType == 'Amazon') ? 'amazon/' : 'vendor/';

        // Sanitize and create a unique filename
        $uploadFile = $uploadDirectory . $newFilename;

        // Check if the directory exists, if not, create it
        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0777, true)) {
                die("Failed to create directory: " . htmlspecialchars($uploadDirectory));
            }
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $uploadFile)) {
            echo "File was successfully uploaded.<br>";
        } else {
            echo "Failed to upload file.<br>";
        }
    } else {
        echo "No file uploaded or file upload error.<br>";
        if (isset($_FILES['uploadedfile']['error'])) {
            echo "Error code: " . $_FILES['uploadedfile']['error'] . "<br>";
        }
    }

    // Display input data
    echo "Product Type: " . htmlspecialchars($productType) . "<br>";
    echo "Product Brief: " . htmlspecialchars($product) . "<br>";
    echo "Date: " . htmlspecialchars($date) . "<br>";
}
