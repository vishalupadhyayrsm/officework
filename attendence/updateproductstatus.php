<?php
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $lid = $_POST['lid']; 
        $status = $_POST['status']; 
        // UPDATE `leave_status`='[value-6]' WHERE 1
        $stmt = $conn->prepare("UPDATE `leavetable` SET `leave_status` = :status WHERE `leaveid` = :lid");
        $stmt->bindParam(':lid', $lid);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        if ($stmt->errorCode() === '00000') {
            $response = ['status' => 'success', 'message' => 'Database update successful', 'data' => ['lid' => $lid, 'status' => $status]];
            echo json_encode($response);
        } else {
            $errors = $stmt->errorInfo();
            echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $errors]);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
