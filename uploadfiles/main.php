<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $producttype = htmlspecialchars($_POST['producttype']);
    $product = htmlspecialchars($_POST['product']);
    $date = htmlspecialchars($_POST['date']);

    // Process the form data
    echo "Joining as: " . $producttype . "<br>";
    echo "Product Brief: " . $product . "<br>";
    echo "Date: " . $date . "<br>";

    // Here you can add more processing logic, such as saving the data to a database or sending an email.
} else {
    echo "Form not submitted.";
}
