<?php
session_start();
include 'dbconfig.php';

// Check if the action is for registration or login
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST['cpassword'];
    $field = $_POST['field'];
    $lab = $_POST['lab'];

    // echo $username;
    $checkUsernameQuery = "SELECT * FROM user WHERE username = '$email'";
    $result = $conn->query($checkUsernameQuery);

    // print_r($result);
    if ($result->$num_rows > 0) {
        $response = array("status" => "error", "message" => "Username Already Exists");
        echo json_encode($response);
    } else {
        // echo "hello";
        // Hash the password
        $hash_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user
        $insertQuery = "INSERT INTO user (`usertype`,`username`, `email`, `password`, `field`, `lab`) VALUES ('user','$username','$email','$hash_password','$field','$lab')";
        if ($conn->query($insertQuery) == TRUE) {
            $response = array("status" => "success", "message" => "Record inserted successfully");
            header("Location: login.php");
            // echo "Success";
        } else {
            $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
            echo "failed";
        }
    }
} elseif (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // try {
    //     $stmt = $conn->prepare("SELECT `userid`,`email`,`username`,`userapproved`, `password`, `usertype` FROM `user` WHERE email = :username");
    //     $stmt->bindParam(':username', $username);
    //     $stmt->execute();

    //     if ($stmt->errorCode() != 0) {
    //         $errors = $stmt->errorInfo();
    //         $response = array("status" => "error", "message" => "SQL error: " . $errors[2]);
    //         echo json_encode($response);
    //         exit();
    //     }

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
                    echo json_encode($response);
                }
            } else {
                $response = array("status" => "error", "message" => "User not approved");
                echo json_encode($response);
            }
        } else {
            $response = array("status" => "error", "message" => "User not found");
            echo json_encode($response);
        }
    // } catch (PDOException $e) {
    //     $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
    //     echo json_encode($response);
    // }
}    
// $conn->close();
