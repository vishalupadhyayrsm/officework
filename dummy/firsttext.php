<?php

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
    <script src="pdf.min.js"></script>
    <script src="pdf.worker.js"></script>
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

                <!-- code for dispalying the user details, certificate  and resign list start here  -->
                <div class="row">
                    <!-- code for dispalying the amozon prodcut order details start here -->
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
                                console.log(extractedText);
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
                            var fileBase64 = event.target.result.split(',')[1]; // Get Base64 part

                            var body = 'extractedTextURL=' + encodeURIComponent(extractedText) +
                                '&dropdown=' + encodeURIComponent(selectedOption) +
                                '&pdffile=' + encodeURIComponent(fileBase64) +
                                '&filename=' + encodeURIComponent(file.name) +
                                '&siddata=' + encodeURIComponent(sid);

                            fetch('formsubmit.php/storebills', {
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
                    <?php if ($usertype == 'account' || $usertype == 'admin') : ?>
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
                    <?php endif; ?>

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

            <!--  flot-chart js -->
            <script src="./vendor/flot/jquery.flot.js"></script>
            <script src="./vendor/flot/jquery.flot.resize.js"></script>

            <!-- Owl Carousel -->
            <script src="./vendor/owl-carousel/js/owl.carousel.min.js"></script>

            <!-- Counter Up -->
            <script src="./vendor/jqvmap/js/jquery.vmap.min.js"></script>
            <script src="./vendor/jqvmap/js/jquery.vmap.usa.js"></script>
            <script src="./vendor/jquery.counterup/jquery.counterup.min.js"></script>


            <script src="./js/dashboard/dashboard-1.js"></script>





</body>

</html>