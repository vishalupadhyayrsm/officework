<?php
// Start session
session_start();
// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Establish connection to the database
$servername = "localhost";
$username = "root";
$dbpassword = ""; // Please replace with your actual database password
$dbname = "device_management_system";

// Create connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's email from the session
$email = $_SESSION['email'];

// Prepare and execute SQL to get the jobtitle from the Users table
$sql = "SELECT designation FROM userdetails WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($designation);
$stmt->fetch();
$stmt->close();

$sql = "SELECT name FROM userdetails WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/homepage.css">
    <!-- Tabulator CSS -->
    <link href="https://unpkg.com/tabulator-tables@5.2.7/dist/css/tabulator.min.css" rel="stylesheet">
    <script src="homepage.js"></script>
    <style>
        .logout-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">About</a>
            </li>
        </ul>
        <div class="logout-container">
            <form id="logoutForm" action="logout.php" method="post" class="form-inline my-2 my-lg-0 ml-auto">
                <button type="submit" class="btn logout-btn">Logout</button>
            </form>
        </div>
        </div>
    </nav>
    <p>Job Title: <?php echo htmlspecialchars($designation); ?><br>
        User Name: <?php echo htmlspecialchars($name); ?>
    </p>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-center mb-3">
                <button class="btn btn-primary tab-button active" onclick="openTab(event, 'CAMERA')">CAMERA</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'ThinClientMachines')">ThinClientMachines</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'Desktop Machines')">Desktop Machines</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'Laptop Machines')">Laptop Machines</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'Printer Scanner')">Printer Scanner</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'Server Machines')">Server Machines</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'Wifi Devices')">Wifi Devices</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'User')">User</button>
            </div>
        </div>

        <div id="CAMERA" class="tab-content" style="display: block;">
            <form action="camera.php" method="POST">
                <div class="form-group">
                    <label for="cameraname">Camera Name:</label>
                    <input type="text" class="form-control" id="cameraname" name="cameraname">
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <input type="text" class="form-control" id="category" name="category">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="monitor">Monitor:</label>
                    <input type="text" class="form-control" id="monitor" name="monitor">
                </div>
                <div class="form-group">
                    <label for="ssd">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="form-group">
                    <label for="processor">Remark:</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                </div>
                <label for="lab"><b>Lab</b></label>
                <select class="form-control" id="lab" name="lab" required>
                    <option value="NCAIR">NCAIR</option>
                    <option value="MMMF">MMMF</option>
                    <option value="Textile">Textile</option>
                    <option value="AMTF">AMTF</option>
                    <option value="AMEC">AMEC</option>
                    <option value="FDXM">FDXM</option>
                </select>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="ThinClientMachines" class="tab-content">
            <form action="ThinClientMachines.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="machinename">Machine Name:</label>
                    <input type="text" class="form-control" id="machinename" name="machinename">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="ssd">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="user">User:</label>
                    <input type="text" class="form-control" id="user" name="user">
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>
                <div class="form-group">
                    <label for="processor">Remark:</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="Desktop Machines" class="tab-content">
            <form action="desktopmachines.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="model_number">Model Number:</label>
                    <input type="text" class="form-control" id="model_number" name="model_number">
                </div>
                <div class="form-group">
                    <label for="serial_number">Computer Name</label>
                    <input type="text" class="form-control" id="computername" name="computername">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="user">User:</label>
                    <input type="text" class="form-control" id="user" name="user">
                </div>
                <div class="form-group">
                    <label for="processor">Remark:</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                </div>
                <div class="form-group">
                    <label for="lancard">Extra Lan Card MAC:</label>
                    <input type="text" class="form-control" id="lancard" name="lancard">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="Laptop Machines" class="tab-content">
            <form action="laptopmachines.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="modelnumber">Model Number:</label>
                    <input type="text" class="form-control" id="modelnumber" name="modelnumber">
                </div>
                <div class="form-group">
                    <label for="computername">Computer Name:</label>
                    <input type="text" class="form-control" id="computername" name="computername">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="user">User:</label>
                    <input type="text" class="form-control" id="user" name="user">
                </div>
                <div class="form-group">
                    <label for="processor">Remark:</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="Server Machines" class="tab-content">
            <form action="servermachines.php" method="POST">
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="user">User:</label>
                    <input type="text" class="form-control" id="user" name="user">
                </div>
                <div class="form-group">
                    <label for="processor">Remark:</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="Printer Scanner" class="tab-content">
            <form action="Printer_scanner.php" method="POST">
                <div class="form-group">
                    <label for="printername">Printer Name:</label>
                    <input type="text" class="form-control" id="printername" name="printername">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="user">User:</label>
                    <input type="text" class="form-control" id="user" name="user">
                </div>
                <div class="form-group">
                    <label for="processor">Remark:</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
        <div id="Wifi Devices" class="tab-content">
            <form action="wifidevices.php" method="POST">
                <div class="form-group">
                    <label for="equipmentname">Equipment Name:</label>
                    <input type="text" class="form-control" id="equipmentname" name="equipmentname">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="user">User:</label>
                    <input type="text" class="form-control" id="user" name="user">
                </div>
                <div class="form-group">
                    <label for="processor">Remark:</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
        <div id="User" class="tab-content">
            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    TABLES
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="cameratable.php">Camera</a>
                    <a class="dropdown-item" href="ThinClientMachinestable.php">Thin Client Machines</a>
                    <a class="dropdown-item" href="desktopmachinestable.php">Desktop Machines</a>
                    <a class="dropdown-item" href="laptopmachinestable.php">Laptop Machines</a>
                    <a class="dropdown-item" href="printerscannertable.php">Printer/Scanner</a>
                    <a class="dropdown-item" href="servermachinestable.php">Server Machines</a>
                    <a class="dropdown-item" href="wifidevicestable.php">Wifi Devices</a>

                </div>
            </div>
        </div>


        <!-- Bootstrap JS, Popper.js, and jQuery -->
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- Popper.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        <script src="https://unpkg.com/tabulator-tables@5.2.7/dist/js/tabulator.min.js"></script>
        <script>
            function openTab(evt, tabName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tab-content");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tab-button");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " active";

                if (tabName === 'User') {
                    loadUserTable();
                }
            }

            function loadUserTable() {
                new Tabulator("#user-table", {
                    ajaxURL: "fetch_userdetails.php",
                    layout: "fitColumns",
                    columns: [{
                            title: "Name",
                            field: "name"
                        },
                        {
                            title: "Email",
                            field: "email"
                        },
                        {
                            title: "Designation",
                            field: "designation"
                        },
                        {
                            title: "sittingspace",
                            field: "sittingspace"
                        },
                        {
                            title: "field",
                            field: "field"
                        },
                        {
                            title: "lab",
                            field: "lab"
                        }
                    ],
                });
            }
        </script>
</body>

</html>