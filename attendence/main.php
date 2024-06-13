<?php
session_start();
include 'dbconfig.php';

// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
// require 'PHPMailer/src/Exception.php';
// Create a new PHPMailer instance
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

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
        $insertQuery = "INSERT INTO sigin (`name`, `email`, `password`, `usertype`,`userstatus`,`cl`,`rh`,`contact`) 
        VALUES ('$name', '$email','$hash_password','user',`yes`,'$cl','2','$phoneNo')";

        if ($conn->query($insertQuery) == TRUE) {
            // code for sending the mail to the user whenever new useer registe
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
        $stmt = $conn->prepare("SELECT `sid`, `name`, `email`, `password`, `usertype`,`userstatus`, `contact`, `declarationform`,`resign` FROM `sigin` WHERE email = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->errorCode() != 0) {
            $errors = $stmt->errorInfo();
            $response = array("status" => "error", "message" => "SQL error: " . $errors[2]);
            echo json_encode($response);
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $response['resign'];
        $userstatus = $result['userstatus'];
        /* code for checking that if user is resigned or not  */
        if ($userstatus == 'no') {
            echo "<script>alert('Your Account is deactivated Please Contact to Admin'); window.location.href = 'login.php';</script>";
        } else {
            if ($result) {
                $hashedPassword = $result['password'];
                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['user_email'] = $result['email'];
                    $_SESSION['usertype'] = $result['usertype'];
                    $_SESSION['username'] = $result['name'];
                    $_SESSION['userid'] = $result['sid'];
                    $_SESSION['decform'] = $result['declarationform'];

                    if ($result['usertype'] == 'system') {
                        header("Location: system/index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $response = array("status" => "error", "message" => "Incorrect password");
                    echo "<script>alert('" . $response['message'] . "'); window.location.href = 'login.php';</script>";
                }
            } else {
                $response = array("status" => "error", "message" => "User not found");
                echo "<script>alert('" . $response['message'] . "'); window.location.href = 'login.php';</script>";
            }
        }
    } catch (PDOException $e) {
        $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
        echo json_encode($response);
    }
}
// $conn->close();


// code for sedning the php mail satrt here
// function send_email($emailid, $subject, $message, $name)
// {
//     // echo $subject . '<br />' . $message;
//     $emailid = "vishalm.rsm@gmail.com";

//     require 'mailer/Exception.php';
//     require 'mailer/PHPMailer.php';
//     require 'mailer/SMTP.php';
//     require 'config.php';
//     // $mail = new PHPMailer(true);


//     $mail_host = mail_host;
//     $mail_username = mail_username;
//     $mail_password = mail_password;

//     $mail = new PHPMailer(true);

//     try {
//         $mail->SMTPOptions = array(
//             'ssl' => array(
//                 'verify_peer' => false,
//                 'verify_peer_name' => false,
//                 'allow_self_signed' => true
//             )
//         );

//         $mail->SMTPDebug = false; // Enable verbose debug output (set to 2 for detailed debugging)
//         $mail->isSMTP(); // Send using SMTP
//         $mail->Host = $mail_host; // Set the SMTP server to send through
//         $mail->SMTPAuth = true; // Enable SMTP authentication
//         $mail->Username = $mail_username;
//         $mail->Password = $mail_password;
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port = 587;

//         // Recipients
//         $mail->setFrom($mail_username, 'MIP');
//         $mail->addAddress($emailid);
//         $mail->addReplyTo($mail_username, 'MIP');
//         // Content
//         // echo "hello";
//         $mail->isHTML(true);
//         $mail->Subject = $subject;
//         $mail->Body = $message;
//         $mail->send();
//         echo 'Message has been sent';
//     } catch (Exception $e) {
//         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//     }
// }
