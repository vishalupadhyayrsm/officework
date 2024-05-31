<?php
session_start();
include 'dbconfig.php';
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
</head>

<body>
    <?php
    $usertype = "User";
    ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <span class="navbar-brand">Welcome: <?php echo $usertype; ?></span>
            <div class="container">
                <div class="header-content">
                    <h2 class="model_name text-center">Leave Application Form</h2>
                </div>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>
    <br>
    <div class="tabs">
        <button onclick="showTab('tab1')" class="btn btn-primary order_status_button click_here_button">Order Here</button>
        <button onclick="showTab('tab2')" class="btn btn-primary order_status_button click_here_button">Order Status</button>
    </div>

    <div id="tab1" class="container tab-content active-tab">
        <div class="row">
            <!---- code for registering the leave from the user start here --->
            <div class="col-md-6 offset-md-3">
                <!--<h2 class="mb-4">Date Input Form</h2>-->
                <h2 class="mb-4">CL: <?php echo "2"; ?></h2>
                <h2 class="mb-4">RH: <?php echo "2"; ?> </h2>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $startDate = $_POST['start_date'];
                    $endDate = $_POST['end_date'];
                    $reason = $_POST['reason'];

                    echo '<div class="alert alert-info">';
                    echo "<h4>Your Input:</h4>";
                    echo "Start Date: " . htmlspecialchars($startDate) . "<br>";
                    echo "End Date: " . htmlspecialchars($endDate) . "<br>";
                    echo "Reason: " . htmlspecialchars($reason) . "<br>";
                    echo '</div>';
                }
                ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <input type="text" class="form-control" id="reason" name="reason" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!------ code for dispalying the all the data to the user based on user type ------->
    <div id="tab2" class="container tab-content">
        <div class="row">
            <div class="col-md-12 ">
                <h2 class="mb-4">Displaying all the leave</h2>
                <div id="tabulator-table"></div>
                <!--<div class="pagination-btn" onclick="table.previousPage()">Previous</div>-->
                <!--<div class="pagination-btn" onclick="table.nextPage()">Next</div>-->
            </div>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            var tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(function(tab) {
                tab.classList.remove('active-tab');
            });
            var selectedTab = document.getElementById(tabId);
            selectedTab.classList.add('active-tab');
        }
    </script>
    <script>
        var tabId;

        function showTab(tabId) {
            var tabs = document.querySelectorAll('.tab-content');
            // console.log(tabId);
            tabs.forEach(function(tab) {
                tab.classList.remove('active-tab');
            });
            var selectedTab = document.getElementById(tabId);
            selectedTab.classList.add('active-tab');
        }


        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($results); ?>;
            var columns = [{
                    title: "User Name",
                    field: "userfullname",
                    headerFilter: true
                    // visible: <?php echo ($usertype == 'user') ? 'true' : 'true'; ?>,
                },
                {
                    title: "Contact No",
                    field: "phoneNo",
                    headerFilter: true
                },
                {
                    title: "Reason",
                    field: "quantity",
                    headerFilter: true
                },
                {
                    title: "Start Date",
                    field: "productprice",
                    headerFilter: true
                },
                {
                    title: "End Date",
                    field: "tpprice",
                    headerFilter: true
                },
                {
                    title: "Remaining CL",
                    field: "addedcart",
                    headerFilter: true,
                    // visible: <?php echo ($usertype == 'user') ? 'true' : 'false'; ?>,
                    // formatter: function(cell, formatterParams, onRendered) {
                    //     var value = cell.getValue();
                    //     if (value === 'yes') {
                    //         return 'Product Added To cart';
                    //     } else if (value === 'no') {
                    //         return 'This Product can not be ordered.';
                    //     } else {
                    //         return 'Not Added to cart Yet';
                    //     }
                    // }
                },
            ];

            // code for dispalying added to cart or not 
            <?php if ($usertype != 'user') : ?>
                columns.push({
                    title: "Add to Cart",
                    field: "addedcart",
                    headerFilter: true,
                    formatter: function(cell, formatterParams, onRendered) {
                        var value = cell.getValue();
                        if (value === 'yes') {
                            var celldata = cell.getElement();
                            celldata.disabled = true;
                            celldata.classList.add('disabled-cell');
                            var row = cell.getRow();
                            row.getElement().classList.add('green-row');
                            return 'Yes';
                        } else if (value === 'no') {
                            var cellEl = cell.getElement();
                            cellEl.disabled = true;
                            cellEl.classList.add('disabled-cell');
                            var row = cell.getRow();
                            row.getElement().classList.add('red-row');
                            return 'Denied';
                        } else {
                            var dropdown = document.createElement('select');
                            dropdown.classList.add('form-control');
                            dropdown.innerHTML = `
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">Denied</option>
                            `;
                            // Add event listener to the dropdown
                            dropdown.addEventListener('change', function(event) {
                                var selectedValue = event.target.value;
                                var cellData = cell.getData();
                                var username = cellData.username;
                                var userId = cellData.userId;
                                var pid = cellData.pid;

                                // Update the addedcartInfo with the new value
                                updateaddedcartInfo(pid, userId, selectedValue, username);
                            });

                            return dropdown;
                        }
                    }
                });

            <?php endif; ?>
            // function for that product is added  to card or not 
            function updateaddedcartInfo(pid, userId, newValue, username) {
                console.log(pid, userId, newValue, username);
                var currentDateTime = new Date().toLocaleString('en-IN', {
                    timeZone: 'Asia/Kolkata'
                });
                var addedusername = "<?php echo $usertype; ?>";
                fetch('update_addtocart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'pid=' + encodeURIComponent(pid) + '&userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue) + '&userId=' + encodeURIComponent(userId) +
                            '&datetime=' + encodeURIComponent(currentDateTime) + '&username=' + encodeURIComponent(addedusername)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        var alertdata = data['status'];
                        if (alertdata == 'no') {
                            alert("Product is Denied.");
                            window.location.href = 'index1.php';
                        } else {
                            alert("Product is Added to Cart.");
                            window.location.href = 'index1.php';
                        }

                    })
                    .catch(error => {
                        console.error('Error updating Add to Cart:', error);
                    });
            }


            // // code for updating the status of product 
            // columns.push({
            //   title: "Product status",
            //   field: "productstatus",
            //   headerFilter: true,
            //   visible: <?php echo ($usertype == 'user') ? 'false' : 'true'; ?>,
            // });

            // code for updating the user stats start here 
            <?php if ($usertype != 'use') : ?>
                columns.push({
                    title: "Product status",
                    field: "productstatus",
                    headerFilter: true,
                    editor: <?php echo ($usertype == 'purchaseteam' || $usertype == 'admin') ? "'input'" : "false"; ?>,
                    cellEdited: function(cell) {
                        var userId = cell.getData().userid;
                        var pid = cell.getData().pid;
                        var newValue = cell.getValue();
                        cell.setValue(newValue);
                        updatestatus(pid, userId, newValue);
                    },
                });
            <?php endif; ?>
            // function of the updatestatus start here 
            function updatestatus(pid, userId, newValue) {
                console.log(pid, userId, newValue);
                var pid
                fetch('updateproductstatus.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'pid=' + encodeURIComponent(pid) + '&status=' + encodeURIComponent(newValue)
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

            // code for updating the to whom handed the product 
            <?php if ($usertype != 'use') : ?>
                columns.push({
                    title: "Handed Over",
                    field: "handedover",
                    headerFilter: true,
                    editor: <?php echo ($usertype == 'purchaseteam' || $usertype == 'admin') ? "'input'" : "false"; ?>,
                    cellEdited: function(cell) {
                        var userId = cell.getData().userid;
                        //   console.log(userId)
                        var pid = cell.getData().pid;
                        //   console.log(pid);
                        var newValue = cell.getValue();
                        //   console.log(newValue);
                        cell.setValue(newValue);
                        updateHandedOverValue(pid, userId, newValue);
                    },
                });
            <?php endif; ?>

            // function for teh update the handed over the product
            function updateHandedOverValue(pid, userId, newValue) {
                console.log("updateHandedOver function is working");
                var pid
                fetch('update.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'pid=' + encodeURIComponent(pid) + 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert("Product Handed Over Updated Successfully")
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
            var columns = [{
                    title: "User Name",
                    field: "userfullname",
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