<?php
session_start();
include 'dbconfig.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
        $subject = "Welcome to the  team!";
        $message = 'Dear  ' .  $name . ',
                    <br/></br><br/>
                    <strong>Joining formalities</strong>
                    <br><br>
                    1.  89day/1 Year appointment- After joining the centre you will receive an email from IRCC asking for soft copy of documents related to education, experience etc.  along with the joining forms and two passport size photos. Hardcopy of the documents have to be submitted for scrutiny to IRCC on their request.    
                    <br>
                    2.Once joining formality is done you will receive the appointment letter mentioning the employee code.<br>
                    3.To create L-dap ID kindly email to system admin, ME dept. Employee code and L-dap ID should also be updated in our MIP data base.
                    <br>
                    4. Security office and security ID
                    <br><br>
                    <strong>Biometric/Attendance</strong>
                    <br>
                    1.Everyone should punch in while coming to office and punch out while leaving the office.
                    <br>
                    2.Your attendance will be calculated based on the biometric. 4:14 PM.This will be shared with IRCC for the payment of salary, fellowship and/or honorarium
                    <br>
                    3.Please inform Mr. Rahul Mistri/Ms. Manju in advance regarding leaves.
                    <br><br>
                    <strong>Leave Benefits</strong>
                    <br>
                    Leave Benefits 
                        (Casual Leave (Does not carry over)
                        89days -2days or pro-rata basis 
                        2 RH (Restricted Holiday))
                    <br>
                    A full-time (1 Year appointment) regular Project Staff will be eligible for 30 days of Earned Leave, 8 days of Casual Leave and 2 RH (Restricted Holiday) in a year. (on a pro-rata basis)
                    No encashment of Unused earned leave will be applicable. Fifteen days of balance EL will be allowed to be carried forwarded to the next year; the remaining unused EL will lapse.
                    <br>
                    Earned leaves are to be applied online in DRONA and joining report also has to be completed once resumed after leave. 
                    <span>Drona <a href="https://drona.ircc.iitb.ac.in/">Click Here</a></span>
                    <br>
                    Fill exit interview form at the time of resignation.
                    <br><br> 
                     <strong>Few items to be observed in the office towards maintaining a healthy atmosphere:</strong>
                    <br/></br><br/>
                    1. Please ensure the tidiness of your space/desk as much as possible.
                    <br>
                    2. Cleanliness in and around office.
                    <br>
                    3. It is the responsibility all the people using the pantry to maintain the cleanliness at ALL TIMES. Small discipline of washing the cups, plates and spoons as soon as using it and wiping the counter tops, tables, would help in keeping the place clean.
                    <br>
                    4. Once seating place is allotted, it is not to be changed. If required, please contact the admin team.
                    <br>
                    5. Kindly avoid throwing leftover food items in the pantry dustbin as it would stink on Saturdays and Sundays when the general housekeeping people would not take it away. For food waste, please use the dustbin in the corridor outside.
                    <br>
                    6. Spitting/gargling in the pantry sink is strictly prohibited.
                    <br>
                    7. If you are discussing something, please ensure that others won’t get disturbed/affected. By the loud sound of voices. All of us have our own deadlines to meet in project.
                    <br>
                    8. AC temperature to be kept at 24 °C.
                    <br>
                    9. If you have a visitor, kindly inform them about the office etiquette and ensure that it is followed at all times.
                    <br>
                    10. The last person leaving the office may kindly check if all the lights and ACs (except server room) is switched off and lock the premises accordingly.
                    <br>
                    11. Please remove the footwear outside the office during rainy season if it is soiled.

                    <br/></br><br/>
                    <strong>For Staff:</strong>
                    <br>
                    1. Everyone should punch in while coming to office and punch out while leaving the office.
                    <br>
                    2. Your attendance will be calculated based on the biometric.<br>
                    3. Please inform Mr. Rahul Mistri/Ms. Manju in advance regarding leaves.<br>
                    4. If anybody wants to take WFH (Work from Home) please inform the admin Team prior.<br>
                    5. Leave Benefits 
                        (Casual Leave (Does not carry over)
                        89days -2days or pro-rata basis 
                        2 RH (Restricted Holiday))
                    <br>
                    A full-time regular Project Staff will be eligible for 30 days of Earned Leave and 8 days of Casual Leave in a year. No encashment of Unused earned leave will be applicable.
                    Fifteen days of balance EL will be allowed to be carried forwarded to the next year; the remaining unused EL will lapse.
                    <br>
                    Earned leaves are to be applied online and joining report also has to be completed once resumed after leave 

                    <br>
                    We know that many are aware of all these but this email is particularly for the new colleagues who have started to work with us and for those who have forgotten.
                    <br>
                    Hope you understand the concern and we wish to stay healthy and achieve our dreams
                    <br>
                    Please feel free to get back to ADMIN TEAM if you have any queries in this regard.
                    <br/><br/><br>
                    Thanks & Regards,
                    <br/>
                    Machine Intelligence Program,
                    <br/>
            ';
        $emailid = $email;
        send_email($emailid, $subject, $message, $name);
        // echo '<script>alert("Successfully Registered"); window.location.href = "login.php";</script>';
        // if ($conn->query($insertQuery) == TRUE) {
        //     // code for sending the mail to the user whenever new useer registe
        //     $response = array("status" => "success", "message" => "Record inserted successfully");
        //     echo '<script>alert("Successfully Registered"); window.location.href = "login.php";</script>';
        // } else {
        //     $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
        //     echo "failed";
        // }
    }
} elseif (isset($_POST['login'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];
    try {
        // SELECT `sid`, `name`, `email`, `password`, `usertype`, `contact` FROM `sigin` WHERE email = 'vishalm.rsm@gmail.com';
        $stmt = $conn->prepare("SELECT `sid`, `name`, `email`, `password`, `usertype`, `contact`, `declarationform`,`resign` FROM `sigin` WHERE email = :username");
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
        $resign = $result['resign'];
        /* code for checking that if user is resigned or not  */
        if ($resign == 'yes') {
            echo "<script>alert('Your Account is deactivated'); window.location.href = 'login.php';</script>";
        } else {
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
        }
    } catch (PDOException $e) {
        $response = array("status" => "error", "message" => "Database error: " . $e->getMessage());
        echo json_encode($response);
    }
}
// $conn->close();


// code for sedning the php mail satrt here
function send_email($emailid, $subject, $message, $name)
{
    // echo $subject . '<br />' . $message;
    $emailid = "vishalm.rsm@gmail.com";

    require 'mailer/Exception.php';
    require 'mailer/PHPMailer.php';
    require 'mailer/SMTP.php';
    require 'config.php';


    $mail_host = mail_host;
    $mail_username = mail_username;
    $mail_password = mail_password;

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->SMTPDebug = 0; // Enable verbose debug output (set to 2 for detailed debugging)
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = $mail_host; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = $mail_username; // SMTP username
        $mail->Password = $mail_password; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 993; // TCP port to connect to

        // Recipients
        $mail->setFrom($mail_username, 'MIP');
        $mail->addAddress($emailid);
        $mail->addReplyTo($mail_username, 'MIP');
        // Content
        // echo "hello";
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
