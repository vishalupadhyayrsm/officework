<?php
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $startdate = $_POST['start_date']; 
        $end_date = $_POST['end_date'];
        $reason = $_POST['reason'];
        $sid = $_POST['userid'];
        $cl = $_POST['cl'];
        $rh= $_POST['rh'];
        
        // $cl_el = $_POST['cl_el'];
        // $no_cl_el = $_POST['noof_cl_el'];
        $status = 'pending';
        
        echo $startdate.",".$end_date.",".$reason.",".$sid.",".$cl.",".$rh;
        
        // code for getting the cl or rh deatils 
        // $selectQuery = "SELECT `remainingcl`, `remainingrh` FROM `sigin` WHERE sid = :sid";
        // $stmt = $conn->prepare($selectQuery);
        // $stmt->bindParam(':sid', $sid);
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // if($cl_el == 1){
        //     $remainingcl = $result['remainingcl'];
        //     if($remainingcl == 0){
        //         $newremainingcl = 8 - $no_cl_el ;
        //         $selectQuery = "UPDATE `sigin` SET `remainingcl` = :newremainingcl, `remainingrh` = :remainingrh WHERE sid = :sid";
        //         $stmt->bindParam(':newremainingcl', $newremainingcl);
        //     }else{
        //         $newremainingcl = $remainingcl - $no_cl_el ;
        //         $selectQuery = "UPDATE `sigin` SET `remainingcl` = :newremainingcl, `remainingrh` = :remainingrh WHERE sid = :sid";
        //         $stmt->bindParam(':newremainingcl', $newremainingcl);
        //     }
           
        //     $stmt->bindParam(':remainingrh', $result['remainingrh']);
        //     $stmt->bindParam(':sid', $sid);
        //     $stmt = $conn->prepare($selectQuery);
        // }
        // else{
        //     $remainingrh = $result['remainingrh'];
        //     if($remainingrh == 0){
        //          $newremainingrh = 2 - $no_cl_el; 
        //     }else{
        //          $newremainingrh = $remainingrh - $no_cl_el; 
        //     }
        //     $selectQuery = "UPDATE `sigin` SET `remainingcl` = :newremainingcl, `remainingrh` = :remainingrh WHERE sid = :sid";
        //     $stmt = $conn->prepare($selectQuery);
        //     $stmt->bindParam(':newremainingcl', $result['remainingcl']);
        //     $stmt->bindParam(':remainingrh', $newremainingrh);
        //     $stmt->bindParam(':sid', $sid);
        // }
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Prepare the SQL INSERT statement
        // $insertQuery = "INSERT INTO leavetable (sid, startdate, enddate, reason,leave_status) 
        //                 VALUES (:sid, :startdate, :end_date, :reason, :status)";
        // $stmt = $conn->prepare($insertQuery);
        // // Bind the parameters
        // $stmt->bindParam(':sid', $sid);
        // $stmt->bindParam(':startdate', $startdate);
        // $stmt->bindParam(':end_date', $end_date);
        // $stmt->bindParam(':reason', $reason);
        // $stmt->bindParam(':status', $status);
        
        // // Execute the statement
        // $stmt->execute();
        // if ($stmt->errorCode() === '00000') {
        //     $response = ['status' => 'success', 'message' => 'Leave request submitted successfully'];
        //     echo '<script>alert("Leave request submitted successfully."); window.location.href = "index.php";</script>';
        // } else {
        //     $errors = $stmt->errorInfo();
        //     echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $errors]);
        // }
        
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $e->getMessage()]);
}
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
