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

        // code for getting all the invoice start  here 
        $sqlquery = "SELECT ai.ivid, ai.sid, ai.companyname, ai.invoicenumber, ai.invoicedate, ai.amount, ai.invoiceactivity, ai.service, ai.filename,ai.month,ai.year,ai.date, s.name 
        FROM allinvoice ai 
        LEFT JOIN sigin s ON s.sid = ai.sid";
        $stmt = $conn->prepare($sqlquery);
        $stmt->execute(); // Execute the prepared statement first
        $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //code for egtting all teh indentor list start here 
        $indentorquery = "SELECT indentor.`inid`, indentor.`sid`, indentor.`indentorname`, indentor.`invoicedate`, indentor.`documentno`, indentor.`amount`, indentor.`cost_center_wbs`, 
         indentor.`item`, indentor.`vendor_invoice_ref`, indentor.`created_on`, indentor.`indentor_emp_id`, indentor.`uploadate`, indentor.`filelocation`, sg.`sid` AS `sigin_sid`, 
         sg.`name` AS `sigin_name` FROM `indentor` LEFT JOIN `sigin` AS sg ON sg.`sid` = indentor.`sid`;";
        $stmt = $conn->prepare($indentorquery);
        $stmt->execute(); // Execute the prepared statement first
        $indentor = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* code for dispalying the gatepass data start here  */
        $sql = "SELECT `gid`,`sid`, `name`, `mobile`, `startdate`, `enddate`, `gender`, `purpose`,`gatepassstatus` FROM `gatepass` where sid=:sid ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sid', $sid);
        $stmt->execute();
        $gatepass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ./index.php");
    exit();
}
$decform = $results[0]['declarationform'];
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
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>-->
    <script src="pdf.min.js"></script>
    <script src="pdf.worker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js"></script>

    <style>
        label {
            color: black;
        }
    </style>
</head>

<body>
    <div id="main-wrapper">
        <!-- code for sidebar start here  -->
        <?php include 'sidebar.php' ?>

        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <?php if ($usertype !== 'admin') { ?>
                    <div class="row page-titles mx-0">
                        <div class="col-sm-6 p-md-0">
                            <div class="welcome-text">
                                <h4>Hi, welcome back! Account</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
                            </ol>
                        </div>
                    </div>
                <?php } ?>
                <!-- code for dispalying the user details, certificate  and resign list start here  -->
                <div class="row">
                    <!-- code for uploadig the amozon prodcut order details start here -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Upload Invoice</h4>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="dropdown">Select Source:</label>
                                    <select id="dropdown" class="form-control">
                                        <option value="">Select</option>
                                        <option value="amazon">Amazon</option>
                                        <option value="electronic">Electronic.com</option>
                                        <option value="dgk">dgk</option>
                                        <option value="credence">Credence</option>
                                        <option value="bl">Balmer Lawrie</option>
                                        <option value="dmart">D-Mart</option>
                                        <option value="ola">OLA</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div><br>

                                <div class="form-group">
                                    <label for="pdfInput">Select Invoice:</label>
                                    <input type="file" class="form-control" id="pdfInput" accept=".pdf">
                                </div><br>
                                <button id="submitBtn" class="btn btn-success">Submit</button>
                            </div>
                        </div>

                    </div>

                    <!----code for uploading the indentor start here --->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Upload Indentor</h4>
                            </div>
                            <div class='card-body'>
                                <div class="form-group">
                                    <label for="pdfInput">Select Indentor Document:</label>
                                    <input type="file" class="form-control" id="fileInput" accept="image/*,application/pdf">
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount:</label>
                                    <input type="number" class="form-control" id="amountInput" step="0.01" placeholder="Enter amount">
                                </div>
                                <button id="submitButton" class="btn btn-success">Submit</button>
                            </div>


                            <!--<div class="card-body">-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="pdfInput">Select Indentor Document:</label>-->
                            <!--        <input type="file" class="form-control" id="fileInput" accept="image/*,application/pdf">-->
                            <!--    </div><br>-->

                            <!--    <div class="form-group">-->
                            <!--        <label for="amount">Amount:</label>-->
                            <!--        <input type="number" class="form-control" id="amount" placeholder="Please enter the total amount">-->
                            <!--    </div><br>-->
                            <!--    <button id="submitBtn" class="btn btn-success">Submit</button> -->
                            <!--</div>-->
                        </div>
                    </div>

                </div>

                <!----code for uploading the indentor ends here -->
                <!----code for displaying the invoice details start here  ---->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Download Monthly Invoice data </h4>
                        </div>
                        <div class="card-body">
                            <form action="formsubmit.php/downloadinvoice" method="post">
                                <div class="form-group">
                                    <label for="dropdown">Month:</label>
                                    <select name="month" id="month" class="form-control">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="year">Year:</label>
                                    <select name="year" id="year" class="form-control">
                                        <?php
                                        $currentYear = date("Y");
                                        for ($year = $currentYear; $year >= 2000; $year--) {
                                            echo "<option value='$year'>$year</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Download</button>
                            </form>
                        </div>
                    </div>

                </div>

                <!---code for displaying the invoice list start here  --->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Invoice</h4>
                        </div>
                        <div class="card-body">
                            <div id="allinvoice"></div>
                        </div>
                    </div>

                </div>

                <!---code for dispalying teh indentor list start here --->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Indentor</h4>
                        </div>
                        <div class="card-body">
                            <div id="allindentor"></div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <?php include 'footer.php'; ?>
        <script>
            //code for getting text data from the pdf file    
            function extractTextFromPDF(file) {
                return new Promise((resolve, reject) => {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var arrayBuffer = event.target.result;

                        pdfjsLib.getDocument(arrayBuffer).promise.then(function(pdf) {
                            var pagesPromises = [];
                            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                                pagesPromises.push(pdf.getPage(pageNum));
                            }
                            return Promise.all(pagesPromises);
                        }).then(function(pages) {
                            var pageTextPromises = pages.map(function(page) {
                                return page.getTextContent().then(function(textContent) {
                                    return textContent.items.map(function(item) {
                                        return item.str;
                                    }).join(' ');
                                });
                            });
                            return Promise.all(pageTextPromises);
                        }).then(function(pageTexts) {
                            var extractedText = pageTexts.join(' ');
                            resolve(extractedText);
                        }).catch(function(reason) {
                            reject(reason);
                        });
                    };
                    reader.readAsArrayBuffer(file);
                });
            }
            document.getElementById('submitBtn').addEventListener('click', function() {
                var selectedOption = document.getElementById('dropdown').value;
                var file = document.getElementById('pdfInput').files[0];
                var sid = "<?php echo $sid; ?>";

                if (!selectedOption) {
                    alert('Please select a source.');
                    return;
                }
                if (!file) {
                    alert('Please select a PDF file.');
                    return;
                }

                extractTextFromPDF(file).then(function(extractedText) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var fileBase64 = event.target.result.split(',')[1];
                        console.log(typeof(extractedText));
                        var body = 'extractedTextURL=' + encodeURIComponent(extractedText) +
                            '&dropdown=' + encodeURIComponent(selectedOption) +
                            '&pdffile=' + encodeURIComponent(fileBase64) +
                            '&filename=' + encodeURIComponent(file.name) +
                            '&siddata=' + encodeURIComponent(sid);
                        console.log(body);

                        fetch('formsubmit.php/storebilldeatils', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: body
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.text();
                            })
                            .then(data => {
                                if (data == 'success') {
                                    alert("Invoice Uploaded Successfully")
                                    window.location.href = "account.php";
                                }
                                console.log('Success:', data);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    };
                    reader.readAsDataURL(file);
                }).catch(function(error) {
                    console.error('Error extracting text:', error);
                });
            });
        </script>
        <!--- code for getting text data form the pdf file ends here ---->

        <!----code for displying all the invoice start here ---->
        <script>
            if (typeof Tabulator !== 'undefined') {
                var results = <?php echo json_encode($invoices); ?>;
                var columns = [{
                        title: "User Name",
                        field: "name",
                        headerFilter: true
                    },
                    {
                        title: "Company Name",
                        field: "companyname",
                        headerFilter: true
                    },
                    {
                        title: "Invoice Number",
                        field: "invoicenumber",
                        headerFilter: true
                    },
                    {
                        title: "Invoice Upload Date",
                        field: "date",
                        headerFilter: true
                    },
                    {
                        title: "Invoice Upload Month",
                        field: "month",
                        headerFilter: true
                    },
                    {
                        title: "Invoice Upload Year",
                        field: "year",
                        headerFilter: true
                    },
                    {
                        title: "Invoice Date",
                        field: "invoicedate",
                        headerFilter: true,
                    },
                    {
                        title: "Amount",
                        field: "amount",
                        headerFilter: true
                    },
                    {
                        title: "Type of Invoice",
                        field: "invoiceactivity",
                        headerFilter: true
                    },
                    {
                        title: "Type of Serivce",
                        field: "service",
                        headerFilter: true
                    },
                    {
                        title: "File",
                        field: "filename",
                        headerFilter: true,
                        formatter: function(cell, formatterParams, onRendered) {
                            var filename = cell.getValue();
                            return `<a href="https://miphub.in/${filename}" target="_blank" style='color:black;'>${filename}</a>`;
                        }

                    }
                ];
                // code for deleting the invoice details
                <?php //if ($usertype == 'account' || $usertype == 'admin') : 
                ?>
                columns.push({
                    title: "Delete Invoice",
                    headerFilter: false,
                    formatter: function(cell, formatterParams, onRendered) {
                        return '<button type="button" class="btn btn-danger" style="width: 100%;">Delete</button>';
                    },
                    cellClick: function(e, cell) {
                        var userId = cell.getData().ivid;
                        // console.log(userId);
                        deleteInvoice(userId);
                    }
                });
                <?php //endif; 
                ?>

                //code for deleting the invoice details 
                function deleteInvoice(userId) {
                    fetch('formsubmit.php/deleteinvoice', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'userId=' + encodeURIComponent(userId)
                        })
                        .then(response => response.text())
                        .then(data => {
                            var datavalue = data.data;
                            console.log(datavalue);
                            if (datavalue == 'no') {
                                alert("Invoice not Deleted");
                            } else {
                                alert("Invoice Successfully Deleted");
                                window.location.href = '../account.php'
                            }
                        })
                        .catch(error => {
                            console.error('Error updating database:', error);
                        });
                }


                var pageSize = 10;
                var currentPage = 1;
                var table = new Tabulator("#allinvoice", {
                    data: results,
                    layout: "fitData",
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

            } else {
                console.error('Tabulator library not defined or not loaded.');
            }
        </script>
        <!--- code for all teh invoice ends here --->

        <!--code for uploading teh indentor start here -->
        <script>
            const apiUrl = 'formsubmit.php/indentor';
            let accumulatedText = '';

            function handleImage(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        Tesseract.recognize(
                            e.target.result,
                            'eng', {}
                        ).then(({
                            data: {
                                text
                            }
                        }) => {
                            accumulatedText += text + '\n';
                            // document.getElementById('output').innerText = accumulatedText;
                            resolve(accumulatedText);
                        }).catch(err => {
                            console.error('Error recognizing text:', err);
                            // document.getElementById('output').innerText = 'Error recognizing text. See console for details.';
                            reject(err);
                        });
                    };
                    reader.readAsDataURL(file);
                });
            }

            async function handlePdf(file) {
                const pdf = await pdfjsLib.getDocument(URL.createObjectURL(file)).promise;
                const page = await pdf.getPage(1);
                const viewport = page.getViewport({
                    scale: 1.5
                });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                await page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise;

                return new Promise((resolve, reject) => {
                    canvas.toBlob(blob => {
                        const imageFile = new File([blob], 'page.png', {
                            type: 'image/png'
                        });
                        handleImage(imageFile).then(resolve).catch(reject);
                    }, 'image/png');
                });
            }

            document.getElementById('fileInput').addEventListener('change', function(event) {
                accumulatedText = '';
                // document.getElementById('output').innerText = ''; 
            });

            document.getElementById('submitButton').addEventListener('click', async function() {
                const file = document.getElementById('fileInput').files[0];
                const amount = document.getElementById('amountInput').value;

                if (!file) {
                    alert('Please select a file.');
                    return;
                }

                if (!amount) {
                    alert('Please enter the amount.');
                    return;
                }

                try {
                    if (file.type.match('image.*')) {
                        await handleImage(file);
                    } else if (file.type === 'application/pdf') {
                        await handlePdf(file);
                    } else {
                        console.error('Invalid file type');
                        // document.getElementById('output').innerText = 'Invalid file type';
                        // return;
                    }

                    if (accumulatedText) {
                        // console.log(accumulatedText);
                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('amount', amount);
                        formData.append('extractedText', accumulatedText);

                        fetch(apiUrl, {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                alert("Indentor Uploaed Successfully");
                                window.location.href = "account.php";
                                // return response.text();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                        accumulatedText = '';
                    } else {
                        alert('Failed to extract text. Please try again.');
                    }

                } catch (error) {
                    console.error('Error processing file:', error);
                }
            });
        </script>
        <!----code for uploading the indntor end here  --->


        <!---code for dispalying all the indentor strat here --->
        <script>
            if (typeof Tabulator !== 'undefined') {
                var results = <?php echo json_encode($indentor); ?>;
                var columns = [{
                        title: "User Name",
                        field: "sigin_name",
                        headerFilter: true
                    },
                    {
                        title: "Indentor Name",
                        field: "indentorname",
                        headerFilter: true
                    },
                    {
                        title: "Document Number",
                        field: "documentno",
                        headerFilter: true
                    },
                    {
                        title: "Amoutn",
                        field: "amount",
                        headerFilter: true
                    },
                    {
                        title: "Cost Center/WBS",
                        field: "cost_center_wbs",
                        headerFilter: true
                    },
                    {
                        title: "Item",
                        field: "item",
                        headerFilter: true
                    },
                    {
                        title: "Vendor Ref No",
                        field: "vendor_invoice_ref",
                        headerFilter: true,
                    },
                    {
                        title: "Created On",
                        field: "created_on",
                        headerFilter: true
                    },
                    {
                        title: "Indentor Emp Id",
                        field: "indentor_emp_id",
                        headerFilter: true
                    },
                    {
                        title: "File Upload Date",
                        field: "uploadate",
                        headerFilter: true
                    },
                    {
                        title: "File",
                        field: "filelocation",
                        headerFilter: true,
                        formatter: function(cell, formatterParams, onRendered) {
                            var filename = cell.getValue();
                            return `<a href="https://miphub.in/${filename}" target="_blank" style='color:black;'>${filename}</a>`;
                        }

                    }
                ];
                // code for deleting the invoice details
                <?php //if ($usertype == 'account' || $usertype == 'admin') : 
                ?>
                //     columns.push({
                //     title: "Delete Invoice",
                //     headerFilter: false, 
                //     formatter: function(cell, formatterParams, onRendered) {
                //         return '<button type="button" class="btn btn-danger" style="width: 100%;">Delete</button>';
                //     },
                //     cellClick: function(e, cell) {
                //         var userId = cell.getData().ivid;
                //         // console.log(userId);
                //         deleteInvoice(userId);
                //     }
                // });
                <?php //endif; 
                ?>

                //code for deleting the invoice details 
                function deleteInvoice(userId) {
                    fetch('formsubmit.php/deleteinvoice', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'userId=' + encodeURIComponent(userId)
                        })
                        .then(response => response.text())
                        .then(data => {
                            var datavalue = data.data;
                            console.log(datavalue);
                            if (datavalue == 'no') {
                                alert("Invoice not Deleted");
                            } else {
                                alert("Invoice Successfully Deleted");
                                window.location.href = '../account.php'
                            }
                        })
                        .catch(error => {
                            console.error('Error updating database:', error);
                        });
                }


                var pageSize = 10;
                var currentPage = 1;
                var table = new Tabulator("#allindentor", {
                    data: results,
                    layout: "fitData",
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

            } else {
                console.error('Tabulator library not defined or not loaded.');
            }
        </script>
        <!---code for dispalying all the indentor end here --->



        <!-- Required vendors -->
        <script src="./vendor/global/global.min.js"></script>
        <script src="./js/quixnav-init.js"></script>
        <script src="./js/custom.min.js"></script>

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