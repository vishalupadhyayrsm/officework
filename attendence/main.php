<?php
session_start();
include 'dbconfig.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phoneNo = $_POST['contact'];
    $month = $_POST['month'];
    $monthNumber = date('n', strtotime($month));
    if ($monthNumber >= 1 && $monthNumber <= 3) {
        $cl = 8;
    } else if ($monthNumber >= 4 && $monthNumber <= 6) {
        $cl = 6;
    } else if ($monthNumber >= 7 && $monthNumber <= 9) {
        $cl = 4;
    } else {
        $cl = 2;
    }
    // echo $name;
    $checkUsernameQuery = "SELECT * FROM sigin WHERE email = '$email'";
    $result = $conn->query($checkUsernameQuery);
    if ($result->$num_rows > 0) {
        $response = array("status" => "error", "message" => "Username Already Exists");
        echo json_encode($response);
    } else {
        $hash_password = password_hash($password, PASSWORD_BCRYPT);
        $insertQuery = "INSERT INTO sigin (`name`, `email`, `password`, `usertype`,`cl`,`rh`,`contact`) 
        VALUES ('$name', '$email','$hash_password','user','$cl','2','$phoneNo')";
        // print_r($insertQuery);
        if ($conn->query($insertQuery) == TRUE) {
            $response = array("status" => "success", "message" => "Record inserted successfully");
            echo '<script>alert("Successfully Registered"); window.location.href = "login.php";</script>';
        } else {
            $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
            echo "failed";
        }
    }
} elseif (isset($_POST['login'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];
    try {
        // SELECT `sid`, `name`, `email`, `password`, `usertype`, `contact` FROM `sigin` WHERE email = 'vishalm.rsm@gmail.com';
        $stmt = $conn->prepare("SELECT `sid`, `name`, `email`, `password`, `usertype`, `contact`, `declarationform` FROM `sigin` WHERE email = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->errorCode() != 0) {
            $errors = $stmt->errorInfo();
            $response = array("status" => "error", "message" => "SQL error: " . $errors[2]);
            echo json_encode($response);
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $hashedPassword = $result['password'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_email'] = $result['email'];
                $_SESSION['usertype'] = $result['usertype'];
                $_SESSION['username'] = $result['name'];
                $_SESSION['userid'] = $result['sid'];
                $_SESSION['decform'] = $result['declarationform'];
                header("Location: index.php");
                exit();
            } else {
                $response = array("status" => "error", "message" => "Incorrect password");
                echo "<script>alert('" . $response['message'] . "'); window.location.href = 'login.php';</script>";
            }
        } else {
            $response = array("status" => "error", "message" => "User not found");
            echo "<script>alert('" . $response['message'] . "'); window.location.href = 'login.php';</script>";
        }
    } catch (PDOException $e) {
        $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
        echo json_encode($response);
    }
}    
// $conn->close();
