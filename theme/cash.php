<?php
session_start();
include 'dbconfig.php';
// include 'fecthdata.php';
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
    $username = $_SESSION['username'];
    $usertype = $_SESSION['usertype'];
    $sid = $_SESSION['userid'];
    $decform = $_SESSION['decform'];

    // code for checking that if the usertype is staff or not 
    try {
        $sql = "SELECT sg.`sid`,sg.`name`, sg.`email`, sg.`usertype`,sg.`tenureenddate`, sg.`contact`, sg.`cl`, sg.`rh`,sg.`el`, sg.remainingcl, sg.remainingrh,sg.remainingel, sg.declarationform,lt.leaveid, 
        lt.`clstartdate`, lt.`clenddate`,lt.`rhstartdate`, lt.`rhenddate`, lt.`elstartdate`, lt.`elenddate`,  lt.`reason`, lt.`leave_status`,de.declarationform,de.emp_roll,de.`univesity`,de.name,de.iitbemail,
        de.aadhar,de.gender,de.localaddress,de.localpostal,de.permanentadd,de.permpostal, de.homecontact,de.emename1,de.emerelation,de.emeadd,de.emecontact,de.empostalcode,de.emesecondname,de.emesecrelation,de.medicalcondition,de.profilepic
        FROM `sigin` as sg LEFT JOIN leavetable as lt on lt.sid = sg.sid LEFT JOIN declarationform as de on de.sid = sg.sid where sg.sid=:sid ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sid', $sid);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $sql = "SELECT us.sid,us.name,us.email,us.contact,pd.pid ,pd.sid, pd.productname,pd.datetime, pd.productlink, pd.productprice,
                pd.tpprice,pd.quantity, pd.urgency,pd.addedcart,pd.orderstatus,pd.productstatus,
                 pd.addedcartdate,pd.addedby,pd.handedover
                 FROM sigin AS us JOIN product AS pd ON us.sid = pd.sid
                 ORDER BY pd.pid DESC";
        $stmt = $conn->prepare($sql);
        // $stmt->bindParam(':email', $email);
        $stmt->execute();
        $amazon = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // inventory data fetch
        $inventory_query = "SELECT * FROM cash";
        $stmt = $conn->query($inventory_query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $rows = [];
        $row = $rows[5];

        $inventory_json_data = json_encode($rows);


        // fetching current balance for current user
        $fetchBalanceQuery = "SELECT balance, document FROM sigin WHERE sid = :userId";
        $fetchStmt = $conn->prepare($fetchBalanceQuery);
        $fetchStmt->bindParam(':userId', $sid);
        $fetchStmt->execute();
        $userData = $fetchStmt->fetch(PDO::FETCH_ASSOC);
        $balance = $userData['balance'];
        $d_no = $userData['document'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ./index.php");
    exit();
}

$decform = $results[0]['declarationform'];
if ($decform !== 'yes') {
    header("Location: ./decform.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MIP</title>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/logo.png">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        label {
            color: black;
        }

        a {
            color: blue;
        }

        .col {
            display: inline-block;
            white-space: nowrap;
            color: grey;
        }
    </style>
    <script>

    </script>
</head>

<body>
    <div id="main-wrapper">
        <!-- code for sidebar start here  -->
        <?php include 'sidebar.php' ?>
        <!-- code for sidebar ends here   -->

        <!-- code for main body start here  -->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back! <?php echo $username; ?></h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
                        </ol>
                    </div>
                </div>


                <!-- code for dispalying the user details, certificate  and resign list start here  -->
                <div class="row">

                    <!----code for filling teh cash form start from here --->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"">Add Cash Details</h4>
                                <div class=" row">
                                    <div align="right" class="col"><b>Document Number:</b> <?php echo $d_no; ?></div>
                                    <div align="right" class="col"><b>Balance:</b> <span id="balancespan"></span>Rs.<?php echo $balance; ?><span></span></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="formsubmit.php/cash" method="post">
                                <div class="mb-3">
                                    <label for="party_name">User Name:</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="party_name">Name of party:</label>
                                    <input type="text" class="form-control" id="party_name" name="party_name" placeholder="Name of party" required>
                                </div>
                                <div class="mb-3">
                                    <label for="invoice">Invoice No.</label>
                                    <input type="text" class="form-control" id="invoice" name="invoice" required placeholder="Invoice Number">
                                </div>
                                <div class="mb-3">
                                    <label for="particulars">Particulars</label>
                                    <input type="text" class="form-control" id="particulars" name="particulars" required placeholder="Enter Particular">
                                </div>
                                <div class="mb-3">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" min="1" step="any" required placeholder="Enter Amount" onKeyUp="validateAmount(this.value)">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-----code for dispalying the new cash request -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Cash Details</h4>
                        </div>
                        <div class="card-body">
                            <form action="formsubmit.php/add_cash" method="post">
                                <div class="mb-3">
                                    <label for="doc_no">Docuement No:</label>
                                    <input type="text" class="form-control" id="doc_no" name="docno" required placeholder="Docuement Number">
                                </div>
                                <div class="mb-3">
                                    <label for="add_cash_amount">Enter the amount</label>
                                    <input type="number" class="form-control" id="add_cash_amount" name="add_cash_amount" min="1" step="any" required placeholder="Enter the amount">
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" id="add_cash" name="add_cash" value="Add cash">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <!-- code for dispalying the amzazon product list start list start here  -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Inventory Order</h4>
                        </div>
                        <div class="card-body">
                            <div id="inventory-table"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- code for main body ends here  -->


    </div>
    <?php include 'footer.php'; ?>

    <!---code for generationg the qr code--->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        // URL of the PDF file from PHP
        var pdfUrl = "<?php echo $certificate[0]['sid']; ?>";
        // var pdfUrl = "<?php //echo htmlspecialchars($pdfUrl, ENT_QUOTES, 'UTF-8'); 
                            ?>";
        var viewPageUrl = 'https://miphub.in/viewcertificate.php?file=' + encodeURIComponent(pdfUrl);

        // Generate the QR code
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: viewPageUrl,
            width: 256,
            height: 256,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>

    <!-- code for leave status start here -->
    <script>
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($results); ?>;
            var columns = [{
                    title: "User Name",
                    field: "name",
                    headerFilter: true
                    // visible: <?php echo ($usertype == 'user') ? 'true' : 'true'; ?>,
                },
                {
                    title: "Total CL",
                    field: "cl",
                    headerFilter: true,
                },
                {
                    title: "Total RH",
                    field: "rh",
                    headerFilter: true
                },
                {
                    title: "Remaining CL",
                    field: "remainingcl",
                    headerFilter: true
                },
                {
                    title: "Remaining RH",
                    field: "remainingrh",
                    headerFilter: true
                },
                {
                    title: "Reason For Leave",
                    field: "reason",
                    headerFilter: true
                },

                {
                    title: "CL Start Date",
                    field: "clstartdate",
                    headerFilter: true
                },
                {
                    title: "CL End Date",
                    field: "clenddate",
                    headerFilter: true
                },
                {
                    title: "RH Start Date",
                    field: "rhstartdate",
                    headerFilter: true
                },
                {
                    title: "RH End Date",
                    field: "rhenddate",
                    headerFilter: true
                },
                {
                    title: "EL Start Date",
                    field: "elstartdate",
                    headerFilter: true
                },
                {
                    title: "EL End Date",
                    field: "elenddate",
                    headerFilter: true
                },
            ];

            // code for updating the user leave status start here 
            columns.push({
                title: "Leave Status",
                field: "leave_status",
                headerFilter: true,
                formatter: function(cell, formatterParams, onRendered) {
                    var value = cell.getValue();
                    var cellEl = cell.getElement();
                    var row = cell.getRow();
                    if (value === 'yes') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('green-row');
                        return 'Approved';
                    } else if (value === 'no') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('red-row');
                        return 'Denied';
                    } else {
                        <?php if ($usertype == 'hr') : ?>
                            var dropdown = document.createElement('select');
                            dropdown.classList.add('form-control');
                            dropdown.innerHTML = `
                                        <option value="">Select</option>
                                        <option value="yes">Approved</option>
                                        <option value="no">Dissapproved</option>
                                    `;
                            // Add event listener to the dropdown
                            dropdown.addEventListener('change', function(event) {
                                var selectedValue = event.target.value;
                                var cellData = cell.getData();
                                var username = cellData.name;
                                var sid = cellData.sid;
                                var lid = cellData.leaveid;
                                console.log(lid, selectedValue, sid, username);
                                /* cdoe for calculating the differnec between the leave apply  */
                                function calculateDateDifference(startDate, endDate) {
                                    var start = new Date(startDate);
                                    var end = new Date(endDate);
                                    if (start.getTime() === end.getTime()) {
                                        return 1;
                                    }
                                    var timeDifference = end - start;
                                    var dayDifference = timeDifference / (1000 * 60 * 60 * 24);
                                    console.log(dayDifference)
                                    if (dayDifference === 0) {
                                        dayDifference = 1;
                                    }
                                    return dayDifference;
                                }
                                console.log()
                                var clDateDifference = calculateDateDifference(cellData.clstartdate, cellData.clenddate);
                                var rhDateDifference = calculateDateDifference(cellData.rhstartdate, cellData.rhenddate);
                                if (isNaN(rhDateDifference) || rhDateDifference === "") {
                                    rhDateDifference = 0;
                                }
                                console.log("CL Date Difference: " + clDateDifference + " days");
                                console.log("RH Date Difference: " + rhDateDifference + " days");


                                updatestatus(lid, selectedValue, sid, username, clDateDifference, rhDateDifference);
                            });

                            return dropdown;
                        <?php else : ?>
                            return '';
                        <?php endif; ?>
                    }
                }
            });

            // function for updating the leave status start here 
            function updatestatus(lid, selectedValue, sid, username, clDateDifference, rhDateDifference) {
                console.log(lid, selectedValue, sid, username, clDateDifference, rhDateDifference);
                fetch('formsubmit.php/leaveapproved', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },

                        body: 'lid=' + encodeURIComponent(lid) + '&status=' + encodeURIComponent(selectedValue) +
                            '&cl=' + encodeURIComponent(clDateDifference) + '&rh=' + encodeURIComponent(rhDateDifference) +
                            '&sid=' + encodeURIComponent(sid)
                    })
                    .then(response => response.text())
                    .then(data => {
                        // console.log(data);
                        // alert("Leave Status Updated Successfully")
                        //   console.log('Database update successful:', data);
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }

            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#leave", {
                data: results,
                layout: "fitData",
                columns: columns,
                pagination: "local",
                paginationSize: pageSize,
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage,
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
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>
    <!---code for dispalying the amzon product start here --->
    <script>
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($amazon); ?>;
            var columns = [{
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
                    title: "Product Name",
                    field: "productname",
                    headerFilter: true
                },
                {
                    title: "Order Date",
                    field: "datetime",
                    headerFilter: true
                },
                {
                    title: "Product Url",
                    field: "productlink",
                    headerFilter: true,
                    formatter: "link",
                    formatterParams: {
                        target: "_blank"
                    },
                    width: 350
                },
                {
                    title: "Product Urgency",
                    field: "urgency",
                    headerFilter: true
                },
                {
                    title: "Product Quantity",
                    field: "quantity",
                    headerFilter: true
                },
                {
                    title: "Product Price",
                    field: "productprice",
                    headerFilter: true
                },
                {
                    title: "Total Product Price",
                    field: "tpprice",
                    headerFilter: true
                },
                {
                    title: "Product added to cart",
                    field: "addedcart",
                    headerFilter: true,
                    visible: <?php echo ($usertype == 'staff' || $usertype == 'intern' || $usertype == 'student') ? 'true' : 'false'; ?>,
                    formatter: function(cell, formatterParams, onRendered) {
                        var value = cell.getValue();
                        if (value === 'yes') {
                            return 'Product Added To cart';
                        } else if (value === 'no') {
                            return 'This Product can not be ordered.';
                        } else {
                            return 'Not Added to cart Yet';
                        }
                    }
                },
            ];

            columns.push({
                title: "Added to Cart",
                field: "addedcartdate",
                headerFilter: true,
            });

            columns.push({
                title: "Added By",
                field: "addedby",
                headerFilter: true,
                visible: <?php echo ($usertype == 'user') ? 'true' : 'true'; ?>,
            });

            // code for dispalying added to cart or not 
            <?php if ($usertype == 'purchase' || $usertype == 'admin') : ?>
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
                                var username = cellData.name;
                                var userId = cellData.sid;
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
                fetch('formsubmit.php/addedtocart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'pid=' + encodeURIComponent(pid) + '&userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue) + '&userId=' + encodeURIComponent(userId) +
                            '&datetime=' + encodeURIComponent(currentDateTime) + '&username=' + encodeURIComponent(addedusername)
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        var alertdata = data['status'];
                        if (alertdata == 'no') {
                            alert("Product is Denied.");
                            // window.location.href = 'index1.php';
                        } else {
                            alert("Product is Added to Cart.");
                            // window.location.href = 'index1.php';
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
                    editor: <?php echo ($usertype == 'purchase' || $usertype == 'admin') ? "'input'" : "false"; ?>,
                    cellEdited: function(cell) {
                        var userId = cell.getData().sid;
                        var pid = cell.getData().pid;
                        var newValue = cell.getValue();
                        cell.setValue(newValue);
                        updatestatus(pid, userId, newValue);
                    },
                });
            <?php endif; ?>
            // function of the updatestatus start here 
            function updatestatus(pid, userId, newValue) {
                var pid
                fetch('formsubmit.php/productstatus', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'pid=' + encodeURIComponent(pid) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.text())
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
                    editor: <?php echo ($usertype == 'purchase' || $usertype == 'admin') ? "'input'" : "false"; ?>,
                    cellEdited: function(cell) {
                        var userId = cell.getData().sid;
                        var pid = cell.getData().pid;
                        var newValue = cell.getValue();
                        cell.setValue(newValue);
                        updateHandedOverValue(pid, userId, newValue);
                    },
                });
            <?php endif; ?>
            // function for teh update the handed over the product
            function updateHandedOverValue(pid, userId, newValue) {
                var pid
                fetch('formsubmit.php/handedover', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'pid=' + encodeURIComponent(pid) + 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert("Product Handed Over Updated Successfully")
                        //   console.log('Database update successful:', data);
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }


            // code for approved/disapproved user
            // <?php if ($usertype != 'user') : ?>
            //   columns.push({
            //     title: "Approved/Disapproved User",
            //     field: "userapproved",
            //     headerFilter: true,
            //     formatter: function(cell, formatterParams, onRendered) {
            //       var value = cell.getValue();
            //       var buttonText = value === 'yes' ? 'Approved' : 'Disapproved';
            //       var buttonColor = value === 'yes' ? 'btn-success' : 'btn-danger';
            //       var buttonHTML = '<button type="button" class="btn ' + buttonColor + '" style="width: 100%;">' + buttonText + '</button>';
            //       return buttonHTML;
            //     },
            //     cellClick: function(e, cell) {
            //       var currentValue = cell.getValue();
            //       var newValue = currentValue === 'yes' ? 'no' : 'yes';
            //       cell.setValue(newValue);
            //       var userId = cell.getData().userid; 
            //       updateApprovalStatus(userId, newValue);
            //     }
            //   });
            // <?php endif; ?>
            // function updateApprovalStatus(userId, newValue) {
            //   fetch('approved.php', {
            //       method: 'POST',
            //       headers: {
            //         'Content-Type': 'application/x-www-form-urlencoded'
            //       },
            //       body: 'userId=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
            //     })
            //     .then(response => response.json())
            //     .then(data => {
            //         var datavalue = data.data;
            //         console.log(datavalue);
            //         if (datavalue == 'no') {
            //             alert("User Successfully Disapproved");
            //             window.location.href = "index1.php";
            //         } else {
            //             alert("User Successfully Approved");
            //             window.location.href = "index1.php";
            //         }
            //     })
            //     .catch(error => {
            //       console.error('Error updating database:', error);
            //     });
            // }



            var pageSize = 10; // Number of rows per page
            var currentPage = 1; // Initial page

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


    <!-- code for dispalying the certificate start here  -->
    <script>
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($certificate); ?>;
            var columns = [{
                    title: "User Name",
                    field: "username",
                    headerFilter: true
                    // visible: <?php echo ($usertype == 'user') ? 'true' : 'true'; ?>,
                },
                {
                    title: "PI Name",
                    field: "piname",
                    headerFilter: true
                },
                {
                    title: "College Name",
                    field: "collegename",
                    headerFilter: true,
                },
                {
                    title: "Start Date",
                    field: "start_date",
                    headerFilter: true
                },
                {
                    title: "End Date",
                    field: "start_date",
                    headerFilter: true
                },
                {
                    title: "Work Done",
                    field: "workdone",
                    headerFilter: true
                },
            ];

            // code for updating the user leave status start here 
            <?php //if ($usertype != 'user') : 
            ?>
            columns.push({
                title: "Certificate Status",
                field: "certificatestatus",
                headerFilter: true,
                editor: <?php echo ($usertype == 'hr') ? "'input'" : "false"; ?>,
                cellEdited: function(cell) {
                    // console.log(cell);
                    var userId = cell.getData().sid;
                    var lid = cell.getData().leaveid;
                    var newValue = cell.getValue();
                    cell.setValue(newValue);
                    // console.log(userId, newValue);
                    updatestatus(userId, newValue);
                },
            });
            <?php // endif; 
            ?>

            // function of the updatestatus start here 
            function updatestatus(userId, newValue) {
                // console.log(userId, newValue);
                fetch('formsubmit.php/certificatestatus', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },

                        body: 'sid=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.json())
                    .then(data => {
                        var datavalue = data.data;
                        console.log(datavalue);
                        if (datavalue == 'no') {
                            alert("User Successfully Disapproved");
                            // window.location.href = "../index1.php";
                        } else {
                            alert("User Successfully Approved");
                            // window.location.href = "index1.php";
                        }
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }

            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#certificate", {
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
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }

        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>
    <!-- code for dispalying teh gate pass start here  -->
    <script>
        var tabId;
        // code for dispalying all the data in the table 
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($gatepass); ?>;
            var columns = [{
                    title: "Name",
                    field: "name",
                    headerFilter: true
                },
                {
                    title: "Contact Number",
                    field: "mobile",
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
                {
                    title: "Gender",
                    field: "gender",
                    headerFilter: true
                },
                {
                    title: "Purpose",
                    field: "purpose",
                    headerFilter: true
                }
            ];

            columns.push({
                title: "Certificate Status",
                field: "gatepassstatus",
                headerFilter: true,
                editor: <?php echo ($usertype == 'hr') ? "'input'" : "false"; ?>,
                cellEdited: function(cell) {
                    var userId = cell.getData().sid;
                    var newValue = cell.getValue();
                    cell.setValue(newValue);
                    console.log(userId, newValue);
                    updategatestatus(userId, newValue);
                },
            });

            function updategatestatus(userId, newValue) {
                console.log(userId, newValue);
                fetch('formsubmit.php/gatepassstatus', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },

                        body: 'sid=' + encodeURIComponent(userId) + '&status=' + encodeURIComponent(newValue)
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert("Gatepass Status Update Successfully")
                    })
                    .catch(error => {
                        console.error('Error updating database:', error);
                    });
            }

            // function of the updatestatus start here
            var pageSize = 10;
            var currentPage = 1;
            var table = new Tabulator("#gatepass", {
                data: results,
                layout: "fitColumns",
                columns: columns,
                pagination: "local",
                paginationSize: pageSize,
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage,
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
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>
    <!-- code for dispalying resgination list  -->
    <script>
        // code for dispalying all the data in the table 
        if (typeof Tabulator !== 'undefined') {
            var results = <?php echo json_encode($resign); ?>;
            var columns = [{
                    title: "PI Name",
                    field: "pi_name",
                    headerFilter: true
                },
                {
                    title: "Start Date",
                    field: "start_date",
                    headerFilter: true,
                },
                {
                    title: "End Date",
                    field: "terminationdate",
                    headerFilter: true
                },
                {
                    title: "Start Position",
                    field: "startingposition",
                    headerFilter: true
                },
                {
                    title: "Ending Position",
                    field: "endingpostion",
                    headerFilter: true
                },
                {
                    title: "Reason For Leaving",
                    field: "reason_leaving",
                    headerFilter: true
                },
                {
                    title: "Plan After Leaving",
                    field: "planafterleaving",
                    headerFilter: true
                },
                {
                    title: "Feedback",
                    field: "imporove_suggestion",
                    headerFilter: true
                },
                {
                    title: "Most Liked",
                    field: "what_mostlike",
                    headerFilter: true
                },
                {
                    title: "Least Liked",
                    field: "what_leastlike",
                    headerFilter: true
                },
                {
                    title: "Another Job",
                    field: "taking_anotherjob",
                    headerFilter: true
                },
                {
                    title: "New Job Place",
                    field: "new_place_job",
                    headerFilter: true
                },
                {
                    title: "Imporovement",
                    field: "improvement",
                    headerFilter: true
                },
                {
                    title: "Cupboard Key",
                    field: "CupboardKeys_yesno",
                    headerFilter: true
                },
                {
                    title: "Drawer Key",
                    field: "Drawer_yesno",
                    headerFilter: true
                },
                {
                    title: "Lab Book",
                    field: "labbookyesno",
                    headerFilter: true
                },
                {
                    title: "hardware",
                    field: "hardwareno",
                    headerFilter: true
                },
                {
                    title: "Otherremark",
                    field: "otherremarks",
                    headerFilter: true
                },
                {
                    title: "Resign Status",
                    field: "resignstatus",
                    headerFilter: true
                },
            ];

            /* code for upadating the resignation status start here */
            columns.push({
                title: "Approve / Disapprove",
                field: "leave_status",
                headerFilter: true,
                formatter: function(cell, formatterParams, onRendered) {
                    var value = cell.getValue();
                    var cellEl = cell.getElement();
                    var row = cell.getRow();
                    if (value === 'yes') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('green-row');
                        return 'Approved';
                    } else if (value === 'no') {
                        cellEl.disabled = true;
                        cellEl.classList.add('disabled-cell');
                        row.getElement().classList.add('red-row');
                        return 'Denied';
                    } else {
                        <?php if ($usertype == 'hr') : ?>
                            var dropdown = document.createElement('select');
                            dropdown.classList.add('form-control');
                            dropdown.innerHTML = `
                                    <option value="">Select</option>
                                    <option value="yes">Approved</option>
                                    <option value="no">Dissapproved</option>
                                    `;
                            // Add event listener to the dropdown
                            dropdown.addEventListener('change', function(event) {
                                var selectedValue = event.target.value;
                                var cellData = cell.getData();
                                var username = cellData.name;
                                var sid = cellData.sid;
                                var lid = cellData.leaveid;
                                console.log(lid, selectedValue, sid, username);
                                // updatestatus(lid, selectedValue, sid, username);
                            });

                            return dropdown;
                        <?php else : ?>
                            return '';
                        <?php endif; ?>
                    }
                }
            });
            <?php // endif; 
            ?>
            // function of the updatestatus start here 
            function updatestatus(lid, userId, newValue) {
                console.log(lid, userId, newValue);
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
            var table = new Tabulator("#resign", {
                data: results,
                layout: "fitData",
                columns: columns,
                pagination: "local",
                paginationSize: pageSize,
                paginationSizeSelector: [10, 15, 30],
                paginationInitialPage: currentPage,
                initialSort: [{
                    column: "date",
                    dir: "desc"
                }], // Sort by date descending initially
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
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>



    <!-- Tabulator for Inventory -->

    <script>
        var rowData = <?php echo $inventory_json_data; ?>; // Assuming $inventory_json_data is properly defined
        var pageSize = 10;
        var currentPage = 1;

        var table = new Tabulator("#inventory-table", {
            layout: "fitColumns",
            data: rowData,
            columns: [{
                    title: "Sr No.",
                    field: "uid",
                    sorter: "number"
                },
                {
                    title: "Date",
                    field: "date"
                },
                {
                    title: "User Name",
                    field: "username"
                },
                {
                    title: "Name of party",
                    field: "party_name"
                },
                {
                    title: "Particulars",
                    field: "particulars"
                },
                {
                    title: "Invoices",
                    field: "invoice"
                },
                {
                    title: "Amount",
                    field: "amount"
                },
                {
                    title: "Balance",
                    field: "balance"
                },
                {
                    title: "Document",
                    field: "document"
                }
            ],
            pagination: "local",
            paginationSize: pageSize,
            paginationSizeSelector: [10, 15, 30],
            paginationInitialPage: currentPage,
            initialSort: [{
                column: "date",
                dir: "desc"
            }], // Sort by date descending initially
        });

        // Initialize pagination buttons if necessary
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
    </script>




    <!-- validate amount script-->
    <script>
        function validateAmount(amount) {
            var currBal = <?php echo $balance; ?>;
            console.log(currBal);
            console.log(amount);
            if (currBal < amount) {
                document.getElementById("submit").disabled = true;
                alert("Amount exceeds available balance.");

            } else {
                document.getElementById("submit").disabled = false;
            }
        }
    </script>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>
    <!-- Vectormap -->
    <script src="./vendor/raphael/raphael.min.js"></script>
    <script src="./vendor/morris/morris.min.js"></script>
    <script src="./vendor/circle-progress/circle-progress.min.js"></script>
    <script src="./vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="./vendor/gaugeJS/dist/gauge.min.js"></script>
    <script src="./vendor/flot/jquery.flot.js"></script>
    <script src="./vendor/flot/jquery.flot.resize.js"></script>
    <script src="./vendor/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="./vendor/jqvmap/js/jquery.vmap.min.js"></script>
    <script src="./vendor/jqvmap/js/jquery.vmap.usa.js"></script>
    <script src="./vendor/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="./js/dashboard/dashboard-1.js"></script>

</body>

</html>