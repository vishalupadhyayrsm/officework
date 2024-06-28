<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Text Extractor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@4.10.0/dist/css/tabulator.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/popup.css">
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

        .tab-content {
            display: none;
        }

        .active-tab {
            display: block;
        }

        .red-row {
            color: red;
        }

        .green-row {
            color: green;
        }

        .not-editable-row,
        .disabled-cell {
            pointer-events: none;
            opacity: 0.5;
        }

        .disabled-row {
            opacity: 0.5;
            pointer-events: none;
        }

        .disabled-cell {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <span class="navbar-brand"> <?php echo $_SESSION['username']; ?></span>
            <div class="container">
                <div class="header-content">
                    <h2 class="model_name text-center">Machine Intelligence Program</h2>
                </div>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- code for the button start here  -->
            <div class="col-12 col-md-2" style="border-right:1px solid black;">
                <button onclick="showTab('tab1')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Invoice Details</button>
                <button onclick="showTab('tab2')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Upload Invoice</button>
            </div>
            <!-- code for the displaying the data start here  -->
            <div class="col-12 col-md-10">
                <div id="tab2" class="container tab-content ">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <h2 style="text-align:center;">PDF</h2>
                            <br>
                            <form method="post" action="formsubmit.php/storebilldeatils" class="form_data" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="pdfInput">Select Invoice:</label>
                                    <input type="file" class="form-control" id="pdfInput" name="invoice" accept=".pdf">
                                </div>
                                <br>
                                <button type="" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- code for displaying the invoice data start here  -->
                <div id="tab1" class="container tab-content active-tab">
                    <div class="row">
                        <div class="col-md-12 ">
                            <h2 class="mb-4 all_heading" style="text-align:center;">Invoice</h2>
                            <div id="invoice"></div>
                        </div>
                    </div>
                </div>
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

        if (typeof Tabulator !== 'undefined') {
            // Fetch data from API asynchronously
            fetch('formsubmit.php/invoice')
                .then(response => response.json())
                .then(data => {
                    var columns = [{
                            title: "S.No.",
                            field: "ivid",
                            headerFilter: true
                        },
                        {
                            title: "Invoice Number",
                            field: "invoicenumber",
                            headerFilter: true
                        },
                        {
                            title: "Invoice Date",
                            field: "date",
                            headerFilter: true
                        }
                    ];
                    var pageSize = 10;
                    var currentPage = 1;
                    var table = new Tabulator("#invoice", {
                        data: data,
                        layout: "fitcolumn",
                        columns: columns,
                        pagination: "local",
                        paginationSize: pageSize,
                        paginationSizeSelector: [10, 15, 30],
                        paginationInitialPage: currentPage,
                    });

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
                })
                .catch(error => {
                    console.error('Error fetching data from API:', error);
                });
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>
</body>

</html>