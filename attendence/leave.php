<?php
include 'dbconfig.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

// Check if data is received
if ($data !== null && isset($data['message']) && isset($data['year'])) {
    try {
        $stmt = $conn->prepare("UPDATE `sigin` SET `cl` = 0, `rh` = 0, `remainingcl` = 0, `remainingrh` = 0");
        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Database update successful'];
            echo json_encode($response);
        } else {
            $errors = $stmt->errorInfo();
            echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $errors]);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $e->getMessage()]);
    }
} else {
    $errorResponse = [
        'status' => 'error',
        'message' => 'Invalid data received'
    ];
    header('Content-Type: application/json');
    echo json_encode($errorResponse);
}
?>
