<?php
session_start();
include '../dbconfig.php';
// Check if user is not logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page
    header("Location: ../login.php");
    exit;
}
$email = $_SESSION['user_email'];
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
 $sid = $_SESSION['userid'];
//  echo $sid;
$formFields = array(
    'CAMERA' => array(
        array(
            'label' => 'Camera Name:',
            'type' => 'text',
            'id' => 'cameraname',
            'name' => 'cameraname',
            'required' => true
        ),
        array(
            'label' => 'Category:',
            'type' => 'text',
            'id' => 'category',
            'name' => 'category',
            'required' => true
        ),
        array(
            'label' => 'Configuration:',
            'type' => 'text',
            'id' => 'configuration',
            'name' => 'configuration',
            'required' => true

        ),
        array(
            'label' => 'IpAddress:',
            'type' => 'text',
            'id' => 'IpAddress',
            'name' => 'IpAddress',
            'required' => true

        ),
        array(
            'label' => 'Monitor:',
            'type' => 'text',
            'id' => 'monitor',
            'name' => 'monitor',
            'required' => true

        ),
        array(
            'label' => 'Status:',
            'type' => 'text',
            'id' => 'status',
            'name' => 'status',
            'required' => true

        ),
        array(
            'label' => 'Remark:',
            'type' => 'text',
            'id' => 'remark',
            'name' => 'remark',
            'required' => true

        ),
        array(
            'label' => 'Lab',
            'type' => 'select',
            'id' => 'lab',
            'name' => 'lab',
            'options' => array(
                'NCAIR' => 'NCAIR',
                'MMMF' => 'MMMF',
                'Textile' => 'Textile',
                'AMTF' => 'AMTF',
                'AMEC' => 'AMEC',
                'FDXM' => 'FDXM'
            ),
            'required' => true
        )
    ),
    'ThinClientMachines' => array(
        array(
            'label' => 'Serial Number:',
            'type' => 'text',
            'id' => 'SerialNumber',
            'name' => 'SerialNumber',
            'required' => true

        ),
        array(
            'label' => 'Machine Name:',
            'type' => 'text',
            'id' => 'MachineName',
            'name' => 'MachineName',
            'required' => true

        ),
        array(
            'label' => 'Configuration:',
            'type' => 'text',
            'id' => 'configuration',
            'name' => 'configuration',
            'required' => true

        ),
        array(
            'label' => 'Status:',
            'type' => 'text',
            'id' => 'status',
            'name' => 'status',
            'required' => true

        ),
        array(
            'label' => 'IpAddress:',
            'type' => 'text',
            'id' => 'IpAddress',
            'name' => 'IpAddress',
            'required' => true

        ),
        array(
            'label' => 'User:',
            'type' => 'text',
            'id' => 'user',
            'name' => 'user',
            'required' => true

        ),
        array(
            'label' => 'Location:',
            'type' => 'text',
            'id' => 'location',
            'name' => 'location',
            'required' => true

        ),
        array(
            'label' => 'Remark:',
            'type' => 'text',
            'id' => 'remark',
            'name' => 'remark',
            'required' => true

        )
    ),
    'DesktopMachines' => array(
        array(
            'label' => 'Model Number:',
            'type' => 'text',
            'id' => 'ModelNumber',
            'name' => 'ModelNumber',
            'required' => true

        ),
        array(
            'label' => 'Computer Name:',
            'type' => 'text',
            'id' => 'ComputerName',
            'name' => 'ComputerName',
            'required' => true

        ),
        array(
            'label' => 'Category:',
            'type' => 'text',
            'id' => 'category',
            'name' => 'category',
            'required' => true

        ),
        array(
            'label' => 'Configuration:',
            'type' => 'text',
            'id' => 'configuration',
            'name' => 'configuration',
            'required' => true

        ),
        array(
            'label' => 'Status:',
            'type' => 'text',
            'id' => 'status',
            'name' => 'status',
            'required' => true

        ),
        array(
            'label' => 'IpAddress:',
            'type' => 'text',
            'id' => 'IpAddress',
            'name' => 'IpAddress',
            'required' => true

        ),
        array(
            'label' => 'User:',
            'type' => 'text',
            'id' => 'user',
            'name' => 'user',
            'required' => true

        ),
        array(
            'label' => 'Remark:',
            'type' => 'text',
            'id' => 'remark',
            'name' => 'remark',
            'required' => true

        ),
        array(
            'label' => 'Extra Lan Card MAC:',
            'type' => 'text',
            'id' => 'ExtraLanCard',
            'name' => 'ExtraLanCard',
            'required' => true

        )
    ),
    'LaptopMachines' => array(
        array(
            'label' => 'Serial Number:',
            'type' => 'text',
            'id' => 'SerialNumber',
            'name' => 'SerialNumber',
            'required' => true

        ),
        array(
            'label' => 'Configuration:',
            'type' => 'text',
            'id' => 'configuration',
            'name' => 'configuration',
            'required' => true

        ),
        array(
            'label' => 'Model Number:',
            'type' => 'text',
            'id' => 'ModelNumber',
            'name' => 'ModelNumber',
            'required' => true

        ),
        array(
            'label' => 'Computer Name:',
            'type' => 'text',
            'id' => 'ComputerName',
            'name' => 'ComputerName',
            'required' => true

        ),
        array(
            'label' => 'Status:',
            'type' => 'text',
            'id' => 'status',
            'name' => 'status',
            'required' => true

        ),
        array(
            'label' => 'IpAddress:',
            'type' => 'text',
            'id' => 'IpAddress',
            'name' => 'IpAddress',
            'required' => true

        ),
        array(
            'label' => 'User:',
            'type' => 'text',
            'id' => 'user',
            'name' => 'user',
            'required' => true

        ),
        array(
            'label' => 'Remark:',
            'type' => 'text',
            'id' => 'remark',
            'name' => 'remark',
            'required' => true

        )
    ),
    'ServerMachines' => array(
        array(
            'label' => 'Configuration:',
            'type' => 'text',
            'id' => 'configuration',
            'name' => 'configuration',
            'required' => true

        ),
        array(
            'label' => 'Server Name:',
            'type' => 'text',
            'id' => 'servername',
            'name' => 'servername',
            'required' => true

        ),
        array(
            'label' => 'Category:',
            'type' => 'text',
            'id' => 'category',
            'name' => 'category',
            'required' => true

        ),
        array(
            'label' => 'Status:',
            'type' => 'text',
            'id' => 'status',
            'name' => 'status',
            'required' => true

        ),
        array(
            'label' => 'IpAddress:',
            'type' => 'text',
            'id' => 'IpAddress',
            'name' => 'IpAddress',
            'required' => true

        ),
        array(
            'label' => 'User:',
            'type' => 'text',
            'id' => 'user',
            'name' => 'user',
            'required' => true

        ),
        array(
            'label' => 'Remark:',
            'type' => 'text',
            'id' => 'remark',
            'name' => 'remark',
            'required' => true

        )
    ),
    'PrinterScanner' => array(
        array(
            'label' => 'Printer Name:',
            'type' => 'text',
            'id' => 'PrinterName',
            'name' => 'PrinterName',
            'required' => true

        ),
        array(
            'label' => 'Category:',
            'type' => 'text',
            'id' => 'category',
            'name' => 'category',
            'required' => true

        ),
        array(
            'label' => 'Configuration:',
            'type' => 'text',
            'id' => 'configuration',
            'name' => 'configuration',
            'required' => true

        ),
        array(
            'label' => 'Status:',
            'type' => 'text',
            'id' => 'status',
            'name' => 'status',
            'required' => true

        ),
        array(
            'label' => 'IpAddress:',
            'type' => 'text',
            'id' => 'IpAddress',
            'name' => 'IpAddress',
            'required' => true

        ),
        array(
            'label' => 'User:',
            'type' => 'text',
            'id' => 'user',
            'name' => 'user',
            'required' => true

        ),
        array(
            'label' => 'Remark:',
            'type' => 'text',
            'id' => 'remark',
            'name' => 'remark',
            'required' => true

        )
    ),
    'WifiDevices' => array(
        array(
            'label' => 'Equipment Name:',
            'type' => 'text',
            'id' => 'EquipmentName',
            'name' => 'EquipmentName',
            'required' => true

        ),
        array(
            'label' => 'Category:',
            'type' => 'text',
            'id' => 'category',
            'name' => 'category',
            'required' => true

        ),
        array(
            'label' => 'Configuration:',
            'type' => 'text',
            'id' => 'configuration',
            'name' => 'configuration',
            'required' => true

        ),
        array(
            'label' => 'Status:',
            'type' => 'text',
            'id' => 'status',
            'name' => 'status',
            'required' => true

        ),
        array(
            'label' => 'IpAddress:',
            'type' => 'text',
            'id' => 'IpAddress',
            'name' => 'IpAddress',
            'required' => true

        ),
        array(
            'label' => 'User:',
            'type' => 'text',
            'id' => 'user',
            'name' => 'user',
            'required' => true

        ),
        array(
            'label' => 'Remark:',
            'type' => 'text',
            'id' => 'remark',
            'name' => 'remark',
            'required' => true

        )
    )
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Management System</title>
     <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
    <link rel="stylesheet" href="../vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style>
      body {
            font-family: Georgia, serif
        }
        .logout-btn {
            background-color: red;
            color: white;
        }

        .custom-pointer {
            cursor: pointer;
        }
        .click_here_button{
            width: 100%;
    margin: 5px 0px 0px 0px;
        }
            .nav-header {
        left: 0rem;
    }
    label{color:black;}

    </style>
</head>

<body>
      <div class="nav-header">
            <a href="#" class="brand-logo">
                <img class="logo-abbr" src="../images/logo.png" alt="">
                <img class="logo-compact" src="../images/mip.png" alt="">
                <img class="brand-title" src="../images/mip.png" alt="">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
    
    <div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="search_bar dropdown">
                        <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                            <i class="mdi mdi-magnify"></i>
                        </span>
                        <!-- code for search bar start here  -->
                        <div class="dropdown-menu p-0 m-0">
                            <form>
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>
                </div>

                <ul class="navbar-nav header-right">
                    <!-- code for getting dropdown list start here  -->
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-account"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="../logout.php" class="dropdown-item">
                                <i class="icon-key"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
    
    <!--<nav class="navbar navbar-dark bg-dark">-->
    <!--    <ul class="navbar-nav d-flex flex-row">-->
    <!--        <li class="nav-item px-3">-->
    <!--            <a class="nav-link text-white" href="#"><b><?php echo htmlspecialchars($username); ?></b></a>-->
    <!--        </li>-->
    <!--    </ul>-->
    <!--    <div class="logout-container">-->
    <!--        <form id="logoutForm" action="logout.php" method="post" class="form-inline my-2 my-lg-0 ml-auto">-->
    <!--            <button type="submit" class="btn logout-btn">Logout</button>-->
    <!--        </form>-->
    <!--    </div>-->
    <!--    </div>-->
    <!--</nav>-->

    <div class="container-fluid d-flex align-items-center">
        <div class="row flex-grow-1">
            <div class="col-12 col-md-2" style="border-right:1px solid black; width: 250px;">
                <!-- Tab Button Names -->
                <?php  if ($usertype === 'systemadmin') : ?>
                    <button class="btn btn-primary tab-button active click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'CAMERA')">Camera</button>
                    <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'ThinClientMachines')">ThinClient Machines</button>
                    <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'DesktopMachines')">Desktop Machines</button>
                    <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'LaptopMachines')">Laptop Machines</button>
                    <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'PrinterScanner')">Printer Scanner</button>
                    <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'ServerMachines')">Server Machines</button>
                    <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'WifiDevices')">Wifi Devices</button>
                <?php endif; ?>
                <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'Complaint')">Complaint</button>
                <button class="btn btn-primary tab-button click_here_button mb-2 mt-2 md-2" onclick="openTab(event, 'Table');openSubTab(event, 'ComplaintTable')">Table</button>
            </div>
            <div class="col-12 col-md-10 d-flex flex-column justify-content-center">
            <!--//alert device registration-->
             <?php if(isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Device registered successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['form_submitted']); ?>
            <?php endif; ?>
            <!--//alert complaint registration-->
             <?php if(isset($_SESSION['complaint_submitted']) && $_SESSION['complaint_submitted'] === true): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Complaint registered successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['complaint_submitted']); ?>
            <?php endif; ?>
                <!-- ////////////Forms/////////////////////// -->
                <?php if ($usertype === 'systemadmin') : ?>
                    <?php foreach ($formFields as $category => $fields) : ?>
                        <div id="<?= $category ?>" class="tab-content"  style="background-color: rgb(219 234 250); padding: 20px; border-radius: 10px; margin: 15px auto; width: 70%; ">
                            <form id="<?= strtolower(str_replace(' ', '', $category)) ?>Form" action="formsubmit.php/<?= $category ?>" method="POST">
                                <input type="hidden" name="category" value="<?= $category ?>">
                                <h3 style="text-align: center;"><?= $category ?> Form</h3>
                                <?php foreach ($fields as $field) : ?>
                                    <div class="form-group">
                                        <label for="<?= $field['id'] ?>"><?= $field['label'] ?></label>
                                        <?php if ($field['type'] === 'select') : ?>
                                            <select class="form-control" id="<?= $field['id'] ?>" name="<?= $field['name'] ?>" required>
                                                <?php foreach ($field['options'] as $value => $option) : ?>
                                                    <option value="<?= $value ?>"><?= $option ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else : ?>
                                            <input type="<?= $field['type'] ?>" class="form-control" id="<?= $field['id'] ?>" name="<?= $field['name'] ?>" required>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                                <button type="submit" class="btn btn-success mb-2">Submit</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div id="Complaint" class="tab-content" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <form id="complaintform" action="formsubmit.php/Complaint" method="POST">
                        <h3 style="text-align: center;">Register your complaint here</h3>
                        <!-- Hidden input field to store the user's email -->
                         <input type="hidden" id="email" name="sid" value="<?php echo htmlspecialchars($sid); ?>">
                        <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <div class="form-group">
                            <label for="device-name">Device Name:</label>
                            <select class="form-control" id="devicename" name="devicename">
                                <option value="mouse">Mouse</option>
                                <option value="keyboard">Keyboard</option>
                                <option value="wifi">Wifi</option>
                                <option value="NUC">NUC</option>
                                <option value="printer">Printer</option>
                                <option value="monitor">Monitor</option>
                                <option value="laptop">Laptop</option>
                                <option value="camera">Camera</option>
                                <option value="ThinClientMachine">ThinClientMachine</option>
                                <option value="scanner">Scanner</option>
                                <option value="other device">Other device</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <select class="form-control" id="description" name="description">
                                <option value="mouse_not_working">Mouse not working</option>
                                <option value="keyboard_keys_stuck">Keyboard not working</option>
                                <option value="Internet not working">Internet not working</option>
                                <option value="printer_jam">Printer paper jam</option>
                                <option value="monitor_no_display">Monitor no display</option>
                                <option value="laptop_overheating">Laptop overheating</option>
                                <option value="scanner_not_scanning">Scanner not scanning</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="issuedon">Issued-on:</label>
                            <input type="text" class="form-control" id="issuedon" name="issuedon" readonly>
                        </div>
                        <button type="submit" class="btn btn-success mb-2">Submit</button>
                    </form>
                </div>
                <div class="tab-content " id="Table" style="display: none;">
                    <?php if ($usertype === 'systemadmin') : ?>
                        <div class="dropdown show">
                            <button class="btn btn-secondary dropdown-toggle mt-2" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                TABLES
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item custom-pointer " onclick="openSubTab(event, 'CameraTable')" style='color:black;'>Camera</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'ThinClientMachinesTable')"style='color:black;'>Thin Client Machines</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'DesktopMachinesTable')"style='color:black;'>Desktop Machines</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'LaptopMachinesTable')"style='color:black;'>Laptop Machines</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'PrinterScannerTable')"style='color:black;'>Printer/Scanner</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'ServerMachinesTable')"style='color:black;'>Server Machines</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'WifiDevicesTable')"style='color:black;'>Wifi Devices</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'UserTable')"style='color:black;'>User Table</a>
                                <a class="dropdown-item custom-pointer" onclick="openSubTab(event, 'ComplaintTable')"style='color:black;'>Complaints</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- //default tabualtor space//     -->
                <div id="CameraTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="camera-table-heading">Camera Table</h4>
                    <div id="camera-table-sub"></div>
                </div>
                <div id="ThinClientMachinesTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="thinclientmachines-table-heading">ThinClientMachines Table</h4>
                    <div id="thinclientmachines-table-sub"></div>
                </div>
                <div id="DesktopMachinesTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="desktopmachines-table-heading">DesktopMachines Table</h4>
                    <div id="desktopmachines-table-sub"></div>
                </div>
                <div id="LaptopMachinesTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="laptopmachines-table-heading">LaptopMachines Table</h4>
                    <div id="laptopmachines-table-sub"></div>
                </div>
                <div id="PrinterScannerTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="printerscanner-table-heading">PrinterScanner Table</h4>
                    <div id="printerscanner-table-sub">
                        <h2>Printer/Scanner Table</h2>
                    </div>
                </div>
                <div id="ServerMachinesTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="servermachines-table-heading">ServerMachines Table</h4>
                    <div id="servermachines-table-sub"></div>
                </div>
                <div id="WifiDevicesTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="wifidevices-table-heading">Wifi Devices Table</h4>
                    <div id="wifidevices-table-sub"></div>
                </div>
                <div id="UserTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="user-table-heading">User Table</h4>
                    <div id="user-table-sub"></div>
                </div>
                <div id="ComplaintTable" class="sub-tab-content" style="display: none;text-align: center;">
                    <h4 id="complaint-table-heading"></h4>
                    <div id="complaint-table-sub">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    
    <?php include '../footer.php' ?>
    

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- popper -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
        <!-- bootstrapjs -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- tabulator library -->
        <script src="https://unpkg.com/tabulator-tables@5.2.7/dist/js/tabulator.min.js"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
        <script>
            function openTab(evt, tabName) {
                var i, tabcontent, tablinks, subTabContent, dropdownMenu;
                tabcontent = document.getElementsByClassName("tab-content");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                subTabContent = document.getElementsByClassName("sub-tab-content");
                for (i = 0; i < subTabContent.length; i++) {
                    subTabContent[i].style.display = "none";
                }
                dropdownMenu = document.querySelector(".dropdown-menu.show");
                if (dropdownMenu) {
                    dropdownMenu.classList.remove("show");
                }
                tablinks = document.getElementsByClassName("tab-button");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " active";
            }

            function openSubTab(evt, subTabName) {
                var i, subTabContent, subTabLinks;
                subTabContent = document.getElementsByClassName("sub-tab-content");
                for (i = 0; i < subTabContent.length; i++) {
                    subTabContent[i].style.display = "none";
                }
                subTabLinks = document.getElementsByClassName("dropdown-item custom-pointer");
                for (i = 0; i < subTabLinks.length; i++) {
                    subTabLinks[i].classList.remove("active");
                }
                document.getElementById(subTabName).style.display = "block";
                evt.currentTarget.classList.add("active");

                if (subTabName == 'CameraTable') {
                    loadCameraTableSub();
                } else if (subTabName === 'ThinClientMachinesTable') {
                    loadThinClientMachinesTableSub();
                } else if (subTabName === 'DesktopMachinesTable') {
                    loadDesktopMachinesTableSub();
                } else if (subTabName === 'LaptopMachinesTable') {
                    loadLaptopMachinesTableSub();
                } else if (subTabName === 'PrinterScannerTable') {
                    loadPrinterScannerTableSub();
                } else if (subTabName === 'ServerMachinesTable') {
                    loadServerMachinesTableSub();
                } else if (subTabName === 'WifiDevicesTable') {
                    loadWifiDevicesTableSub();
                } else if (subTabName === 'UserTable') {
                    loadUserTableSub();
                } else if (subTabName === 'ComplaintTable') {
                    loadComplaintTableSub();
                }
            }
            // Update the table name heading
            document.getElementById("complaint-table-heading").innerText = "Complaint Table";

            document.addEventListener('DOMContentLoaded', function() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); 
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;
                document.getElementById('issuedon').value = today;
            });
            // Initialize default tab
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelector(".tab-button").click();
            });
            function loadCameraTableSub() {
                new Tabulator("#camera-table-sub", {
                    ajaxURL: "formsubmit.php/?action=cameratable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                        }, {
                            title: "Camera Name",
                            field: "CameraName",
                            width: 150,
    
                        },
                        {
                            title: "Category",
                            field: "category",
                            width: 150,
        
                        },
                        {
                            title: "Configuration",
                            field: "configuration",
                            width: 150,
        
                        },
                        {
                            title: "Monitor",
                            field: "monitor",
                            width: 150,

                        },
                        {
                            title: "IpAddress",
                            field: "IpAddress",
                            width: 150,
        
                        },
                        {
                            title: "Status",
                            field: "status",
                            width: 150,

                        },
                        {
                            title: "Remark",
                            field: "remark",
                            width: 150,
        
                        },
                        {
                            title: "lab",
                            field: "lab",
                            width: 150,
        
                        },
                    ],
                });
            }

            function loadThinClientMachinesTableSub() {
                new Tabulator("#thinclientmachines-table-sub", {
                    ajaxURL: "formsubmit.php/?action=thinclientmachinestable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                            sorter: "string",
                            width: 150,
                        },
                        {
                            title: "SerialNumber",
                            field: "SerialNumber",
                            sorter: "string",
                            width: 150,
                        },
                        {
                            title: "Machine Name",
                            field: "MachineName",
                            width: 150,
                        },
                        {
                            title: "user",
                            field: "user",
                            width: 150,
                        },
                        {
                            title: "Configuration",
                            field: "configuration",
                            width: 150,
                        },
                        {
                            title: "IpAddress",
                            field: "IpAddress",
                            width: 150,
                        },
                        {
                            title: "location",
                            field: "location",
                            width: 150,
                        },
                        {
                            title: "Status",
                            field: "status",
                            width: 150,
                        },
                        {
                            title: "Remark",
                            field: "remark",
                            width: 150,
                        },
                    ],
                });
                // Update the table name heading
                document.getElementById("thinclientmachines-table-heading").innerText = "ThinClient Machines Table";
            }

            function loadDesktopMachinesTableSub() {
                new Tabulator("#desktopmachines-table-sub", {
                    ajaxURL: "formsubmit.php/?action=desktopmachinestable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                            width: 150,
                        },
                        {
                            title: "Computer Name",
                            field: "ComputerName"
                        },
                        {
                            title: "Configuration",
                            field: "configuration"
                        },
                        {
                            title: "Status",
                            field: "status"
                        },
                        {
                            title: "IpAddress",
                            field: "IpAddress"
                        },
                        {
                            title: "User",
                            field: "user"
                        },
                        {
                            title: "Extra LAN",
                            field: "ExtraLanCard"
                        },
                        {
                            title: "Remark",
                            field: "remark"
                        },
                    ],
                });
                // Update the table name heading
                document.getElementById("desktopmachines-table-heading").innerText = "Desktop Machines Table";
            }

            function loadLaptopMachinesTableSub() {
                new Tabulator("#laptopmachines-table-sub", {
                    ajaxURL: "formsubmit.php/?action=laptopmachinestable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                            width: 150,
                        }, {
                            title: "SerialNumber",
                            field: "SerialNumber",
                            sorter: "string",
                            width: 150,
                        },
                        {
                            title: "ModelNumber",
                            field: "ModelNumber",
                            sorter: "string",
                            width: 150,
                        },
                        {
                            title: "Computer Name",
                            field: "ComputerName",
                            width: 150,
                        },
                        {
                            title: "Configuration",
                            field: "configuration",
                            width: 150,
                        },
                        {
                            title: "IpAddress",
                            field: "IpAddress",
                            width: 150,
                        },
                        {
                            title: "User",
                            field: "user",
                            width: 150,
                        },
                        {
                            title: "Status",
                            field: "status",
                            width: 150,
                        },
                        {
                            title: "Remark",
                            field: "remark",
                            width: 150,
                        },
                    ],
                });
                // Update the table name heading
                document.getElementById("laptopmachines-table-heading").innerText = "Laptop Machines Table";
            }

            function loadPrinterScannerTableSub() {
                new Tabulator("#printerscanner-table-sub", {
                    ajaxURL: "formsubmit.php/?action=printerscannertable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                            width: 150,
                        }, {
                            title: "Printer Name",
                            field: "PrinterName",
                            width: 150,
                        },
                        {
                            title: "Category",
                            field: "category",
                            width: 150,
                        },
                        {
                            title: "Configuration",
                            field: "configuration",
                            width: 150,
                        },
                        {
                            title: "IpAddress",
                            field: "IpAddress",
                            width: 150,
                        },
                        {
                            title: "user",
                            field: "user",
                            width: 150,
                        },
                        {
                            title: "Status",
                            field: "status",
                            width: 150,
                        },
                        {
                            title: "Remark",
                            field: "remark",
                            width: 150,
                        },
                    ],
                });

                // Update the table name heading
                document.getElementById("printerscanner-table-heading").innerText = "Printer Scanner Table";
            }

            function loadServerMachinesTableSub() {
                new Tabulator("#servermachines-table-sub", {
                    ajaxURL: "formsubmit.php/?action=servermachinestable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                            sorter: "string",
                            width: 150,
                        },
                        {
                            title: "Configuration",
                            field: "configuration",
                            width: 150,
                        },
                        {
                            title: "Category",
                            field: "category",
                            width: 150,
                        },
                        {
                            title: "Server Name",
                            field: "ServerName",
                            width: 150,
                        },
                        {
                            title: "IpAddress",
                            field: "IpAddress",
                            width: 150,
                        },
                        {
                            title: "Status",
                            field: "status",
                            width: 150,
                        },
                        {
                            title: "user",
                            field: "user",
                            width: 150,
                        },
                        {
                            title: "Remark",
                            field: "remark",
                            width: 150,
                        },
                    ],
                });
                // Update the table name heading
                document.getElementById("servermachines-table-heading").innerText = "Server Machines Table";
            }

            function loadWifiDevicesTableSub() {
                new Tabulator("#wifidevices-table-sub", {
                    ajaxURL: "formsubmit.php/?action=wifidevicestable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                            width: 150,
                        },
                        {
                            title: "Equipment Name",
                            field: "EquipmentName",
                            width: 150,
                        },
                        {
                            title: "Configuration",
                            field: "configuration",
                            width: 150,
                        },
                        {
                            title: "Category",
                            field: "category",
                            width: 150,
                        },
                        {
                            title: "IpAddress",
                            field: "IpAddress",
                            width: 150,
                        },
                        {
                            title: "Status",
                            field: "status",
                            width: 150,
                        },
                        {
                            title: "user",
                            field: "user",
                            width: 150,
                        },
                        {
                            title: "Remark",
                            field: "remark",
                            width: 150,
                        },
                    ],
                });
                // Update the table name heading
                document.getElementById("wifidevices-table-heading").innerText = "Wifi Devices Table";
            }

            function loadUserTableSub() {
                new Tabulator("#user-table-sub", {
                    ajaxURL: "formsubmit.php/?action=usertable",
                    layout: "fitColumns",
                    columns: [{
                            title: "sno",
                            field: "sno",
                            width: 150,
                        },
                        {
                            title: "Name",
                            field: "name",
                            width: 150,
                        },
                        {
                            title: "Email",
                            field: "email",
                            width: 150,
                        },
                        {
                            title: "designation",
                            field: "designation",
                            width: 150,
                        },
                        {
                            title: "sitting space",
                            field: "sittingspace",
                            width: 150,
                        },
                        {
                            title: "field",
                            field: "field",
                            width: 150,
                        },
                        {
                            title: "lab",
                            field: "lab",
                            width: 150,
                        },
                    ],
                });
                // Update the table name heading
                document.getElementById("user-table-heading").innerText = "User Table";
            }

            function loadComplaintTableSub() {
                new Tabulator("#complaint-table-sub", {
                    ajaxURL: "formsubmit.php/?action=complainttable",
                    layout: "fitColumns",
                    columns: [
                        {
                            title: "User Name",
                            field: "name",
                            // width: 150,
                        },
                        {
                            title: "User Email",
                            field: "email",
                            // width: 150,
                        },
                        {
                            title: "User Type",
                            field: "usertype",
                            // width: 150,
                        },
                        {
                            title: "Device name",
                            field: "devicename",
                            // width: 150,
                        },
                        {
                            title: "Description",
                            field: "description",
                            // width: 150,
                        },
                        {
                            title: "issued on",
                            field: "issuedon",
                            // width: 150,
                        },
                        {
                            title: "status",
                            field: "status",
                            // width: 150,
                             editor: <?php echo ($usertype === 'systemadmin') ? '"input"' : 'false'; ?>,
                            cellEdited: function(cell) {
                                var updatedData = cell.getData();
                                $.ajax({
                                    url: 'formsubmit.php/?action=updatestatus', 
                                    type: 'POST',
                                    data: updatedData,
                                    success: function(response) {
                                        // Handle success response
                                        console.log("Data updated successfully");
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error response
                                        console.error("Error updating data: ", error);
                                    }
                                });
                            }
                        },
                        {
                            title: "Isse Resolved Status",
                            field: "",
                            editor: <?php echo ($usertype === 'systemadmin') ? '"input"' : 'false'; ?>,
                            cellEdited: function(cell) {
                                var updatedData = cell.getData();
                                $.ajax({
                                    url: 'formsubmit.php/?action=updatestatus', 
                                    type: 'POST',
                                    data: updatedData,
                                    success: function(response) {
                                        console.log("Data updated successfully");
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error updating data: ", error);
                                    }
                                });
                            }
                        },
                    ],
                });
                // Update the table name heading
                document.getElementById("complaint-table-heading").innerText = "Complaint Table";
            }
             
            setTimeout(function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 200); // Ensure the alert is removed from the DOM after the fade transition
            }
        }, 2000); // 5000ms = 5 seconds
        </script>
</body>
</html>