<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $serial_number = $_POST['serial_number'];
    $configuration = $_POST['configuration'];
    $processor = $_POST['processor'];
    $ssd = $_POST['ssd'];
    $ip = $_POST['ip'];
    $location_user = $_POST['location_user'];

    echo ($serial_number . $configuration . $processor . $ssd . $ip . $location_user );
}
?>