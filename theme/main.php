<?php
session_start();
include 'dbconfig.php';

// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
// require 'PHPMailer/src/Exception.php';

// // Create a new PHPMailer instance
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// $mail = new PHPMailer(true);

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phoneNo = $_POST['contact'];
    $month = $_POST['month'];
    $monthNumber = date('n', strtotime($month));

    if ($monthNumber >= 1 && $monthNumber <= 3) {
        $cl = 8;
    } elseif ($monthNumber >= 4 && $monthNumber <= 6) {
        $cl = 6;
    } elseif ($monthNumber >= 7 && $monthNumber <= 9) {
        $cl = 4;
    } else {
        $cl = 2;
    }

    $stmt = $conn->prepare("SELECT * FROM sigin WHERE email  = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($result);

    // Check if username already exists
    // $checkUsernameQuery = "SELECT * FROM sigin WHERE email = ?";
    // $stmt = $conn->prepare($checkUsernameQuery);
    // $stmt->bind_param('s', $email);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // echo "hello";


    if ($result->num_rows > 0) {
        $response = array("status" => "error", "message" => "Username Already Exists");
        echo json_encode($response);
    } else {
        $hash_password = password_hash($password, PASSWORD_BCRYPT);
        $insertQuery = "INSERT INTO sigin (`name`, `email`, `password`, `usertype`,`userstatus`,`cl`,`rh`,`contact`) 
        VALUES ('$name', '$email','$hash_password','user','yes','$cl','2','$phoneNo')";

        if ($conn->query($insertQuery) == TRUE) {
            // code for sending the mail to the user whenever new useer registe
            $response = array("status" => "success", "message" => "Record inserted successfully");
            echo '<script>alert("Successfully Registered"); window.location.href = "login.php";</script>';


            $subject = "Welcome to the team!";
            $message = 'Dear User,
                        <br/><br/>
                        <strong>Joining formalities</strong>
                        <br><br>
                        1.  89day/1 Year appointment- After joining the centre you will receive an email from IRCC asking for soft copy of documents related to education, experience etc. along with the joining forms and two passport size photos. Hardcopy of the documents have to be submitted for scrutiny to IRCC on their request.    
                        <br>
                        2. Once joining formality is done you will receive the appointment letter mentioning the employee code.<br>
                        3. To create L-dap ID kindly email to system admin, ME dept. Employee code and L-dap ID should also be updated in our MIP data base.
                        <br>
                        4. Security office and security ID
                        <br><br>
                        <strong>Biometric/Attendance</strong>
                        <br>
                        1. Everyone should punch in while coming to office and punch out while leaving the office.
                        <br>
                        2. Your attendance will be calculated based on the biometric. This will be shared with IRCC for the payment of salary, fellowship and/or honorarium.
                        <br>
                        3. Please inform Mr. Rahul Mistri/Ms. Manju in advance regarding leaves.
                        <br><br>
                        <strong>Leave Benefits</strong>
                        <br>
                        (for each 89-day contract) <br>
                        Casual Leave -2 days  <br>
                        Earned Leaves- 5 days
                        <br><br>
                        A full-time (1 Year appointment) regular Project Staff will be eligible for 30 days of Earned Leave, 8 days of Casual Leave and 2 RH (Restricted Holiday) in a year. (on a pro-rata basis)
                        No encashment of Unused earned leave will be applicable. Fifteen days of balance EL will be allowed to be carried forwarded to the next year; the remaining unused EL will lapse.
                        <br>
                        Casual Leave has to be applied through MIP data base system.
                        <br>
                        <span><a href="https://miphub.in/">Click Here</a></span>
                        <br><br>
                        Earned leaves are to be applied online in DRONA and joining report also has to be completed once resumed after leave. 
                        <span>Drona <a href="https://drona.ircc.iitb.ac.in/">Click Here</a></span>
                        <br>
                        Fill exit interview form at the time of resignation.
                        <br><br> 
                        <strong>Etiquette to be observed in the office towards maintaining a healthy atmosphere:</strong>
                        <br/><br/>
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
                        10. The last person leaving the office may kindly check if all the lights and ACs (except server room) are switched off and lock the premises accordingly.
                        <br>
                        11. Please remove the footwear outside the office during rainy season if it is soiled.
                        <br/><br>
                        <strong>IT Aspects</strong>
                        <br>
                        1. Computer maintenance will be handled by Mr. Rahul Kadam.<br>
                        2. Use of external hardware in your computer/laptop can be discussed with the IT Team & Manager and be dealt with accordingly.<br>
                        3. Any technical problems or malfunctions should be reported to the IT department.<br>
                        4. Employees must take reasonable steps to protect company hardware from theft, loss, or damage, especially when off-premises.<br>
                        5. Routine maintenance and updates will be managed by the IT department. Employees must not attempt unauthorized repairs or modifications.<br>
                        6. Any damage to or loss of hardware must be reported immediately. Employees may be held responsible for damages due to negligence or misuse.<br>
                        7. Upon termination of employment, all company hardware must be returned in good working condition. NoC will be issued based on the IT team’s confirmation of the return.<br>
                        <br/><br>
                        Please feel free to get back to ADMIN TEAM if you have any queries in this regard.
                        <br><br>
                        <address>
                        Thanks & Regards,<br>
                        Machine Intelligence Program,<br>
                        NCAIR office, 2nd Floor, Pre-Engineered Building,<br>
                        Opp. Hillside Power house, <br>      
                        IIT-Bombay, Powai, Mumbai- 400076<br>
                        Ph. +91.22.25764946
                        </address>';
            $emailid = $email;
            $name = "vishal";
            // send_email($emailid, $subject, $message, $name);

            $response = array("status" => "success", "message" => "Record inserted successfully");
            echo '<script>alert("Successfully Registered"); window.location.href = "login.php";</script>';
        } else {
            $response = array("status" => "error", "message" => "Error: " . $insertQuery . "<br>" . $conn->$error);
            echo json_encode($response);
        }
    }
} elseif (isset($_POST['login'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];

    try {
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
        $userstatus = $result['userstatus'];

        if ($userstatus == 'no') {
            echo "<script>alert('Your Account is deactivated. Please Contact Admin'); window.location.href = 'login.php';</script>";
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
                    } else if ($result['usertype'] == 'hr') {
                        header("Location: home.php");
                        exit();
                    } else {
                        header("Location: staff.php");
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

function send_email($emailid, $subject, $message, $name)
{
    global $mail;
    try {
        // Server settings
        $mail->SMTPDebug = false; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'mail.miphub.in'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'admin@miphub.in'; // SMTP username
        $mail->Password = 'Adminmiphub@123'; // SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('admin@miphub.in', 'MIP');
        $mail->addAddress($emailid); // Add recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
