<?php
session_start();
include 'dbconfig.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phoneNo = $_POST['contact'];

    $checkUsernameQuery = "SELECT * FROM signin WHERE email = '$email'";
    $result = $conn->query($checkUsernameQuery);
    // print_r($result);
    if ($result->$num_rows > 0) {
        $response = array("status" => "error", "message" => "Username Already Exists");
        echo json_encode($response);
    } else {
        $hash_password = password_hash($password, PASSWORD_BCRYPT);
        $insertQuery = "INSERT INTO signin (`name`,`email`, `password`, `usertype`,`contactno`) 
        VALUES ('$name', '$email','$password','user','$phoneNo')";
        if ($conn->query($insertQuery) == TRUE) {
            echo "hello1";
            $response = array("status" => "success", "message" => "Record inserted successfully");
            echo '<script>alert("Successfully Registered"); window.location.href = "login.php";</script>';
        } else {
            $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
            echo "failed";
        }
    }
} elseif (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT `userid`,`email`,`username`,`userapproved`, `password`, `usertype` FROM `user` WHERE email = :username");
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
            // Check if the user is approved
            if ($result['userapproved'] == 'yes') {
                $hashedPassword = $result['password'];

                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['user_email'] = $result['email'];
                    $_SESSION['usertype'] = $result['usertype'];
                    $_SESSION['userid'] = $result['userid'];
                    header("Location: index1.php");
                    exit();
                } else {
                    $response = array("status" => "error", "message" => "Incorrect password");
                    //  echo "<script>alert('" . $response['message'] . "');</script>";
                    //   header("Location: login.php");
                    // echo "alert('" . $response['message'] . "');";
                    // echo json_encode($response);
                    echo "<script>alert('" . $response['message'] . "'); window.location.href = 'login.php';</script>";
                }
            } else {
                $response = array("status" => "error", "message" => "User not approved, Please Contact to Purchase team");
                // echo json_encode($response);
                echo "<script>alert('" . $response['message'] . "'); window.location.href = 'login.php';</script>";
            }
        } else {
            $response = array("status" => "error", "message" => "User not found");
            // echo json_encode($response);
            echo "<script>alert('" . $response['message'] . "'); window.location.href = 'login.php';</script>";
        }
    } catch (PDOException $e) {
        $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
        echo json_encode($response);
    }
}    
// $conn->close();
