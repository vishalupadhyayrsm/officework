<?php
session_start();
include 'dbconfig.php';
// include 'fecthdata.php';
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
    $username = $_SESSION['username'];
    $usertype = $_SESSION['usertype'];
    $sid = $_SESSION['userid'];
    // echo $usertype;
    // code for checking that if the usertype is staff or not 
    try {
        if ($usertype == "staff") {
            $sql = "SELECT sg.`sid`, sg.`name`, sg.`email`, sg.`usertype`, sg.`contact`, sg.`cl`, sg.`rh`, sg.remainingcl, sg.remainingrh,sg.declarationform,lt.leaveid, lt.`startdate`, lt.`enddate`, lt.`reason`, lt.`leave_status` 
                    FROM `sigin` as sg LEFT JOIN leavetable as lt on lt.sid = sg.sid where sg.sid=:sid ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':sid', $sid);
            $stmt->execute();
        } else {
            $sql = "SELECT sg.`sid`, sg.`name`, sg.`email`, sg.`usertype`, sg.`contact`, sg.`cl`, sg.`rh`, sg.remainingcl, sg.remainingrh,sg.declarationform,lt.leaveid,lt.`startdate`, lt.`enddate`, lt.`reason`, lt.`leave_status` 
                    FROM `sigin` as sg LEFT JOIN leavetable as lt on lt.sid = sg.sid";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
    exit();
}
$declarationformdone = "yes";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Attendance Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
     <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <style>
    .form-page {
        display: none;
    }
    
    .form-page.active {
        display: block;
    }
    
    button {
        margin: 10px 0;
    }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <!--<span class="navbar-brand">Welcome: </span>-->
            <span  class="navbar-brand"> <?php echo $_SESSION['username']; ?></span>
            <div class="container">
                <div class="header-content">
                    <h2 class="model_name text-center">Machine Intelligence Program</h2>
                </div>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>
    <br>
    <!---- code for checking the if usertype == staff or intern ----->
   <?php
    if (($usertype == "staff" || $usertype == "admin") && $declarationformdone == 'yes') {
    ?>
        <div class="tabs">
            <button onclick="showTab('tab1')" class="btn btn-primary order_status_button click_here_button">Apply Leave</button>
            <button onclick="showTab('tab2')" class="btn btn-primary order_status_button click_here_button">Leave Status</button>
        </div>
    <?php
    }
    ?>
    <br>
    
    <!-----code for dispalying the deceleration form  start here  ------>
    <?php  
     if ($declarationformdone != 'yes') {
    ?>
    <div id="" class="container tab-content active-tab">
        <div class="row">
        <div class="col-md-6 offset-md-3">
         <!--- code for multpage form start here ---->
        <form id="multiPageForm" method="post" action="deceleratonform.php" class="form_data">
                    <div class="form-page active" id="page1">
                         <h2 style="text-align:center;">MIP Deceleraton Form</h2>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div><br>
                        <div class="form-group">
                            <label for="emp_roll">Employee No/Student Roll No:</label>
                            <input type="number" class="form-control" id="emp_roll" name="emproll" required>
                        </div><br>
                        <div class="form-group">
                            <label for="month">Gender:</label>
                            <select class="form-control" name="gender" required>
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <label for="end_date">Local Address (In case of IIT Bombay Student please provide your hostel details here):</label>
                            <input type="text" class="form-control" id="localadd" name="localadd"  required>
                            <br>
                            <label for="Postal">Postal Code:</label>
                            <input type="number" class="form-control" id="localadd" name="localpostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                            <div id="error-message" style="color: red; display: none;">Please enter a 6-digit postal code.</div>
                        </div><br>
                        <div class="form-group">
                            <label for="end_date">Permanent Address:</label>
                            <input type="text" class="form-control" id="localadd" name="permadd"  required><br>
                            <label for="Postal">Postal Code:</label>
                            <input type="number" class="form-control" id="permaadd" name="permapostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                            <div id="error-message" style="color: red; display: none;">Please enter a 6-digit postal code.</div>
                        </div><br>
                        <div class="form-group">
                            <label for="localadd">Home Contact No:</label>
                            <input type="number" class="form-control" id="localadd" name="phone" required pattern="\d{10}" title="Please enter a 10-digit phone number">
                            <span id="phone-error" style="color:red; display:none;">Invalid phone number. Please enter a 10-digit phone number.</span>
                        </div><br>
                         <div class="form-group">
                            <label for="localadd">Upload Image:</label>
                            <input type="file" class="form-control" id="image" name="profileimage">
                        </div><br>
                        
                        <button type="button" onclick="nextPage(2)" class="btn btn-primary">Next</button>
                    </div>
                    <!-- second page start here -->
                    <div class="form-page" id="page2">
                        <h2>Emergency Contact Details (First Person)</h2>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="emergencyname1" name="emergencyname1" required>
                        </div><br>
                        <div class="form-group">
                            <label for="relationship1">Relationsip:</label>
                            <input type="text" class="form-control" id="relationship1" name="relationship1" required>
                        </div><br>
                          <div class="form-group">
                            <label for="emecontact">Contact No:</label>
                            <input type="number" class="form-control" id="localadd" name="emephone1" required pattern="\d{10}" title="Please enter a 10-digit phone number">
                            <br>
                            <span id="phone-error" style="color:red; display:none;">Invalid phone number. Please enter a 10-digit phone number.</span>
                        </div>
                        <div class="form-group">
                            <label for="localadd_emergency1">Contact address if different from above:</label>
                            <input type="text" class="form-control" id="localadd_emergency1" name="localadd_emergency1"  required>
                            <br>
                            <label for="localpostalcode_emergency1">Postal Code:</label>
                            <input type="number" class="form-control" id="localpostalcode_emergency1" name="localpostalcode_emergency1" required minlength="6" maxlength="6" pattern="\d{6}">
                            <div id="error-message" style="color: red; display: none;">Please enter a 6-digit postal code.</div>
                        </div><br>
                        
                        <h2>Emergency Contact Details (Second Person)</h2>
                        <div class="form-group">
                            <label for="emergencyname2">Name:</label>
                            <input type="text" class="form-control" id="emergencyname2" name="emergencyname2" required>
                        </div><br>
                        <div class="form-group">
                            <label for="relationship2">Relationsip:</label>
                            <input type="text" class="form-control" id="relationship2" name="relationship2" required>
                        </div><br>
                        <div class="form-group">
                            <label for="emergencyname">Are there any medical conditions we should know about in the case of an emergency:</label>
                            <input type="text" class="form-control" id="relationship" name="medicalcondition" >
                        </div><br>
                        
                        <button type="button" onclick="previousPage(1)" class="btn btn-primary">Previous</button>
                        <button type="button" onclick="nextPage(3)" class="btn btn-primary">Next</button>
                    </div>
                    <!-- Third page start here  -->
                    <div class="form-page" id="page3">
                        <div class="form-group">
                           <ol>
                               <li>I will not, directly or indirectly, divulge any information connected with the project to any person(s) other than those
                               authorized by the principle investigator.
                               </li><br>
                               <li>
                                  I shall keep and maintain systematic records of all data, results supplied by the client or generated in teh course of the project etc. and 
                                  will not divulge these to third party.
                               </li><br>
                               <li>
                                   I shall not make / keep additional copies of any data / results / reports pertaining to the project without teh express permission of teh principle investigator.
                               </li><br>
                               <li>
                                   I agree that all data generated in the project, paper/ drawings / computer software and other records in my possession pertaining to the project will
                                   be the property of Indian Instittue of Technology Bombay and I shall  have no claim on teh same and I will hand over all these documents to the project
                                   investigator before I resign from or leave the project.
                               </li><br>
                               <li>
                                   Even after my leaveing the institute / resignation / termination of appoinmanet, I will not disclose my confidential information pertainng to teh project
                                   or otherwise made available to me during my tenure, to any third party.
                               </li><br>
                               <li>
                                   I agree that all intellectual property generated through the project will be deemed assigned exclusively to National Center for Aerospace Innovation and Research,
                                   Indian Institute of Technology Bombay for use / dissemination / transfer or licence for payment of royalty or transfer fee, as it may deem fit. 
                               </li><br>
                           </ol>
                           <br>
                           <div class="form-group">
                               <p>I have read teh above aggreement carefully and accept that this is a legally valid and binding obligation and hereby agree to the above.</p>
                            <input type="checkbox" class="form-check-input" id="termsCheck" name="termcheck" required>
                                <label class="form-check-label" for="termsCheck">
                                      I agree to the above terms and conditions.
                                </label>
                           </div>
                           
                        
                        
                        <button type="button" onclick="previousPage(2)" class="btn btn-primary">Previous</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </div>
            </form>
        </div>
        </div>
    </div>
    <?php 
     }
    ?>
    
    <?php 
    if($usertype == 'staff' && $declarationformdone == 'yes'){
    ?>
    <!--- disaplying the form for applying leave start here ----->
    <div id="tab1" class="container tab-content active-tab">
        <div class="row">
            <!---- code for registering the leave from the user start here --->
            <div class="col-md-6 offset-md-3">
                <?php
                if ($usertype == "staff") {
                    $row = $results[0]; 
                ?>
                <div class"col-md-4">
                    <h2 class="mb-4 list_cl">Total CL:<span style="color:red;"> <?php echo htmlspecialchars($row['cl']); ?></span></h2>
                    <h2 class="mb-4 list_cl">Total RH: <span style="color:red;"><?php echo htmlspecialchars($row['rh']); ?></span></h2>
                </div>
                <div class"col-md-4">
                    <h2 class="mb-4 list_cl">Remainig CL: <?php echo htmlspecialchars($row['remainingcl']); ?></h2>
                    <h2 class="mb-4 list_cl">Reamining RH: <?php echo htmlspecialchars($row['remainingrh']); ?></h2>
                    <br>
                </div> 
                <br>
                <form method="post" action="leaveupload.php" class="form_data">
                    <h2 style="text-align:center;">Leave Application Form</h2>
                    <br>
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div><br>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div><br>
                    <div class="form-group">
                        <label for="end_date">No. Of CL:</label>
                        <input type="number" class="form-control" id="end_date" name="cl" min="0" max="8" required>
                    </div><br>
                    <div class="form-group">
                        <label for="end_date">No. Of RH:</label>
                         <input type="number" class="form-control" id="end_date" name="rh" min="0" max="2" required>
                    </div><br>
                    
                    <!--    <div class="form-group">-->
                    <!--    <label for="month">CL/RH:</label>-->
                    <!--    <select class="form-control" name="cl_el" required>-->
                    <!--         <option value="">Select</option>-->
                    <!--        <option value="1">Cl</option>-->
                    <!--        <option value="2">RH</option>-->
                    <!--    </select>-->
                    <!--</div><br>-->
                    <!--<div class="form-group">-->
                    <!--    <label for="month">No.of CL/RH:</label>-->
                    <!--    <input type="text" class="form-control" id="end_date" name="noof_cl_el" required>-->
                    <!--</div><br>-->
                
                    <div class="form-group"> 
                        <label for="reason">Reason:</label>
                        <input type="text" class="form-control" id="reason" name="reason" required>
                    </div>
                     <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>" />
                     <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!------ code for dispalying the all the data to the user based on user type ------->
    <div id="tab2" class="container tab-content">
        <div class="row">
            <div class="col-md-12 ">
                <h2 class="mb-4" style="text-align:center;">Leave Status</h2>
                    <div id="tabulator-table"></div>
                    <!--<div class="pagination-btn" onclick="table.previousPage()">Previous</div>-->
                    <!--<div class="pagination-btn" onclick="table.nextPage()">Next</div>-->
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    
   
    <script>
        /* code for displaying multipage form start here  */
            function nextPage(pageNumber) {
                const currentPage = document.querySelector('.form-page.active');
                const nextPage = document.getElementById('page' + pageNumber);
                if (currentPage) {
                    currentPage.classList.remove('active');
                }
                if (nextPage) {
                    nextPage.classList.add('active');
                }
            }
            function previousPage(pageNumber) {
                nextPage(pageNumber);
            }
            document.getElementById('multiPageForm').addEventListener('input', function (e) {
                const input = e.target;
                if (input.id === 'postal') {
                    const errorMessage = document.getElementById('error-message');
                    if (input.value.length !== 6) {
                        errorMessage.style.display = 'block';
                    } else {
                        errorMessage.style.display = 'none';
                    }
                }
            });
            window.onload = function() {
                document.getElementById('page1').classList.add('active');
            }
            
        // code for the validating the contact number 
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            const phoneInput = document.getElementById('localadd');
            const phoneError = document.getElementById('phone-error');
            const phoneNumber = phoneInput.value;
            
            const phonePattern = /^\d{10}$/;
            
            if (!phonePattern.test(phoneNumber)) {
                phoneError.style.display = 'block';
                phoneInput.focus();
                event.preventDefault(); 
            } else {
                phoneError.style.display = 'none';
            }
        });
    

    </script>
    <!---- javascript code start here  ---->
    <script src="js/index.js"></script>
    <script>
        var tabId;
          function showTab(tabId) {
            var tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(function(tab) {
              tab.classList.remove('active-tab');
            });
            var selectedTab = document.getElementById(tabId);
            selectedTab.classList.add('active-tab');
          }
        
        // code for dispalying all the data in the table 
          if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($results); ?>;
            var columns = [
                {
                title: "User Name",
                field: "name",
                headerFilter: true
                // visible: <?php echo ($usertype == 'user') ? 'true' : 'true'; ?>,
                },
                {
                    title: "Contact No",
                    field: "contact",
                    headerFilter: true
                },
                {
                    title: "Total Cl",
                    field: "cl",
                    headerFilter: true,
                },
                {
                    title: "Remaining Cl",
                    field: "remainingcl",
                    headerFilter: true 
                },
                {
                    title: "Total RH",
                    field: "rh",
                    headerFilter: true 
                },
                {
                    title: "Remaining RH",
                    field: "remainingrh",
                    headerFilter: true 
                },
                {
                    title: "Leave Reason",
                    field: "reason",
                    headerFilter: true
                },
                {
                    title: "Start Date",
                    field: "startdate",
                    headerFilter: true
                },
                {
                    title: "End Date",
                    field: "enddate",
                    headerFilter: true
                },
            ];
         
            // code for updating the user leave status start here 
            <?php //if ($usertype != 'user') : ?>
              columns.push({
                title: "Leave Status",
                field: "leave_status",
                headerFilter: true,
                editor: <?php echo ($usertype == 'admin') ? "'input'" : "false"; ?>,
                cellEdited: function(cell) {
                    console.log(cell);
                  var userId = cell.getData().sid; 
                  var lid = cell.getData().leaveid; 
                  var newValue = cell.getValue();
                  cell.setValue(newValue);
                  updatestatus(lid, userId, newValue);
                },
              });
            <?php // endif; ?>
            
            // function of the updatestatus start here 
            function updatestatus(lid,userId,newValue){
                console.log(lid,userId,newValue);
              fetch('updateproductstatus.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  },
                  
                  body: 'lid=' + encodeURIComponent(lid) + '&status=' + encodeURIComponent(newValue)
                })
                .then(response => response.json())
                .then(data => {
                    alert("Product Status Updated Successfully")
                //   console.log('Database update successful:', data);
                })
                .catch(error => {
                  console.error('Error updating database:', error);
                });
            }
 
            var pageSize = 10; 
            var currentPage = 1; 
            var table = new Tabulator("#tabulator-table", {
              data: results,
              layout: "fitColumns",
              columns: columns,
              pagination: "local", // Enable local pagination
              paginationSize: pageSize, // Number of rows per page
              paginationSizeSelector: [10, 15, 30],
              paginationInitialPage: currentPage, // Initial page
            });
            // Add the following code to initialize pagination buttons
            var prevPageBtn = document.querySelector('.pagination-btn:first-of-type');
            var nextPageBtn = document.querySelector('.pagination-btn:last-of-type');

            if (prevPageBtn && nextPageBtn) {
              prevPageBtn.addEventListener('click', function() {
                table.previousPage();
              });

              nextPageBtn.addEventListener('click', function() {
                table.nextPage();
              });
            }
            function updateTableData() {
            // Fetch updated data from the server
            fetch('fetch_data.php') // Create a new PHP file (fetch_data.php) to handle fetching data
              .then(response => response.json())
              .then(data => {
                // Update Tabulator table with the latest data
                table.setData(data);
              })
              .catch(error => {
                console.error('Error fetching data:', error);
              });
             }

          } else {
            console.error('Tabulator library not defined or not loaded.');
          }
        </script>
    <script>
      if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($results); ?>;
            var columns = [
                {
                title: "User Name",
                field: "name",
                headerFilter: true
              },
               {
                title: "User Email",
                field: "email",
                headerFilter: true
              },
              {
                title: "Contact No",
                field: "phoneNo",
                headerFilter: true
                
              },
              {
                title: "Lab",
                field: "lab",
                headerFilter: true
              },
              
            ];
            // code for approved/disapproved user
            <?php if ($usertype != 'user') : ?>
              columns.push({
                title: "Approved/Disapproved User",
                field: "userapproved",
                headerFilter: true,
                formatter: function(cell, formatterParams, onRendered) {
                  var value = cell.getValue();
                  // console.log(value);
                  var buttonText = value === 'yes' ? 'Approved' : 'Disapproved';
                  var buttonColor = value === 'yes' ? 'btn-success' : 'btn-danger';
                //   var buttonHTML = '<button type="button" class="btn ' + buttonColor + '">' + buttonText + '</button>';
                  var buttonHTML = '<button type="button" class="btn ' + buttonColor + '" style="width: 100%;">' + buttonText + '</button>';
                  return buttonHTML;
                },
                cellClick: function(e, cell) {
                  // Toggle the value and update the database
                  var currentValue = cell.getValue();
                  // console.log(currentValue);
                  var newValue = currentValue === 'yes' ? 'no' : 'yes';
                  cell.setValue(newValue);
                  // console.log(newValue);
                  // Send an AJAX request to update the database
                  var userId = cell.getData().userid; // Assuming you have a 'userid' field in your data
                  // console.log(userId);
                  updateApprovalStatus(userId, newValue);
                }
              });
            <?php endif; ?>
            // function for approved or disapproved user 
            function updateApprovalStatus(userId, newValue) {
              fetch('approved.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  },
                  body: 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                })
                .then(response => response.json())
                .then(data => {
                    var datavalue = data.data;
                    console.log(datavalue);
                    if (datavalue == 'no') {
                        alert("User Successfully Disapproved");
                        window.location.href = "index1.php";
                    } else {
                        alert("User Successfully Approved");
                        window.location.href = "index1.php";
                    }
                    // Redirect if needed
                    // window.location.href = "index1.php";
                    // console.log('Database update successful:', data);
                })
                .catch(error => {
                  console.error('Error updating database:', error);
                });
            }
            
            var pageSize = 10; // Number of rows per page
            var currentPage = 1; // Initial page

            var table = new Tabulator("#usertable", {
              data: results,
              layout: "fitColumns",
              columns: columns,
              pagination: "local", // Enable local pagination
              paginationSize: pageSize, // Number of rows per page
              paginationSizeSelector: [10, 15, 30],
              paginationInitialPage: currentPage, // Initial page
            });
            // Add the following code to initialize pagination buttons
            var prevPageBtn = document.querySelector('.pagination-btn:first-of-type');
            var nextPageBtn = document.querySelector('.pagination-btn:last-of-type');

            if (prevPageBtn && nextPageBtn) {
              prevPageBtn.addEventListener('click', function() {
                table.previousPage();
              });

              nextPageBtn.addEventListener('click', function() {
                table.nextPage();
              });
            }
            function updateTableData() {
            // Fetch updated data from the server
            fetch('fetch_data.php') // Create a new PHP file (fetch_data.php) to handle fetching data
              .then(response => response.json())
              .then(data => {
                // Update Tabulator table with the latest data
                table.setData(data);
              })
              .catch(error => {
                console.error('Error fetching data:', error);
              });
             }

          } else {
            console.error('Tabulator library not defined or not loaded.');
          }
        </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>