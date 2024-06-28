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
    <!-- Include pdf.js library -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script> -->
    <script src="pdf.min.js"></script>
    <script src="pdf.worker.js"></script>
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

        /* code for updating the tabel based on color start here  */
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
            <!-- code for teh button start here  -->
            <div class="col-12 col-md-2" style="border-right:1px solid black;">
                <button onclick="showTab('tab1')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Invoice Details</button>
                <button onclick="showTab('tab2')" class="btn btn-primary order_status_button click_here_button btn-lg mb-2">Upload Invoice</button>
            </div>
            <!-- code for  the displaying the data start here  -->
            <div class="col-12 col-md-10">
                <div id="tab2" class="container tab-content ">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <h2 style="text-align:center;">PDF</h2>
                            <br>
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
                                </select>
                            </div><br>

                            <div class="form-group">
                                <label for="pdfInput">Select Invoice:</label>
                                <input type="file" class="form-control" id="pdfInput" accept=".pdf">
                            </div><br>
                            <button id="submitBtn" class="btn btn-success">Submit</button>
                            <div id="pdfText" style="display:none;"></div>
                        </div>
                    </div>
                </div>

                <!-- code for dispalying the invoice data start here  -->
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
        function extractTextFromPDF(file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var arrayBuffer = event.target.result;

                // Using PDF.js to load and extract text content from the PDF
                pdfjsLib.getDocument(arrayBuffer).promise.then(function(pdf) {
                    // Fetching text content from all pages
                    var pagesPromises = [];
                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        pagesPromises.push(pdf.getPage(pageNum));
                    }
                    return Promise.all(pagesPromises);
                }).then(function(pages) {
                    // Extract text from all pages
                    var pageTextPromises = pages.map(function(page) {
                        return page.getTextContent().then(function(textContent) {
                            return textContent.items.map(function(item) {
                                return item.str;
                            }).join(' ');
                        });
                    });
                    return Promise.all(pageTextPromises);
                }).then(function(pageTexts) {
                    // Concatenate text from all pages
                    extractedText = pageTexts.join(' ');

                    // Log extracted text to console (for verification)
                    console.log('Extracted Text:', extractedText);
                    sendTextToPHP(extractedText);
                    // Example: Ask a question to GPT API
                    // askQuestionToGPT('What information do I need to find in this document?');
                }).catch(function(reason) {
                    console.error('Error extracting text:', reason);
                });
            };
            // Read the PDF file as an ArrayBuffer
            reader.readAsArrayBuffer(file);
        }

        function sendTextToPHP(extractedText) {
            // Example: Adjust URL and headers based on your PHP endpoint
            var apiUrl = 'formsubmit.php/storebilldeatils';
            // console.log("extractedText :  ", extractedText)
            // var requestData = {
            //     "extractedText": extractedText
            // };

            fetch('formsubmit.php/storebilldeatils', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'extractedTextURL=' + encodeURIComponent(extractedText)
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    var datavalue = data.data;
                    console.log(datavalue);
                    // if (datavalue == 'no') {
                    //     alert("User Successfully Disapproved");
                    // } else {
                    //     alert("User Successfully Approved");
                    // }
                })
                .catch(error => {
                    console.error('Error updating database:', error);
                });


            // fetch(apiUrl, {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json'
            //         },
            //         body: JSON.stringify(requestData)
            //     })
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error('Network response was not ok');
            //         }
            //         return response.json();
            //     })
            //     .then(data => {
            //         console.log('Success:', data);
            //         // Handle success response from PHP if needed
            //     })
            //     .catch(error => {
            //         console.error('Error:', error);
            //     });
        }



        let extractedData = [];
        document.getElementById('pdfInput').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (!file) {
                console.error('No file selected.');
                return;
            }
            extractTextFromPDF(file);

            fetch('formsubmit.php/storebilldeatils', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            /* here staring reading the pdf file  */
            // var reader = new FileReader();
            // reader.onload = function(event) {
            //     var arrayBuffer = event.target.result;

            //     pdfjsLib.getDocument(arrayBuffer).promise.then(function(pdf) {
            //         return pdf.getPage(1);
            //     }).then(function(page) {
            //         return page.getTextContent();
            //     }).then(function(textContent) {
            //         console.log(textContent);
            //         extractedData = [];
            //         var previousLineEndsWithColon = false;
            //         var previousKey = '';
            //         var selectedOption = document.getElementById('dropdown').value;



            //         /* here based on differnt type fo pdf file gteeing need  data from teh array   */
            //         switch (selectedOption) {
            //             case 'dmart':
            //                 if (str.endsWith(':')) {
            //                     previousKey = str.substring(0, str.length - 1).trim();
            //                     previousLineEndsWithColon = true;
            //                 } else if (previousLineEndsWithColon) {
            //                     var value = str.trim();
            //                     extractedData.push({
            //                         key: previousKey,
            //                         value: value
            //                     });
            //                     previousLineEndsWithColon = false;
            //                     previousKey = '';
            //                 }
            //                 break;
            //             case 'ola':
            //                 textContent.items.forEach(function(item, index) {
            //                     var str = item.str.trim();
            //                     if (str === 'Total Payable') {
            //                         var nextStr = '';
            //                         var nextNextStr = '';
            //                         if (index + 1 < textContent.items.length) {
            //                             nextStr = textContent.items[index + 1].str.trim();
            //                         }
            //                         if (index + 2 < textContent.items.length) {
            //                             nextNextStr = textContent.items[index + 2].str.trim();
            //                         }
            //                         var balanceValue = nextStr + ' ' + nextNextStr;
            //                         extractedData.push({
            //                             key: 'Balance',
            //                             value: balanceValue
            //                         });
            //                     } else if (str === 'Date') {
            //                         var nextStr = '';
            //                         if (index + 1 < textContent.items.length) {
            //                             nextStr = textContent.items[index + 1].str.trim();
            //                         }

            //                         extractedData.push({
            //                             key: 'Date',
            //                             value: nextStr
            //                         });
            //                     } else if (str.startsWith('CRN')) {
            //                         extractedData.push({
            //                             key: 'Invoice',
            //                             value: str
            //                         });
            //                     }
            //                 });
            //                 break;
            //             case 'credence':
            //                 textContent.items.forEach(function(item, index) {
            //                     var str = item.str.trim();
            //                     if (['Date', 'Invoice No.', 'Balance'].includes(str)) {
            //                         var nextStr = '';
            //                         for (var i = index + 1; i < textContent.items.length; i++) {
            //                             nextStr = textContent.items[i].str.trim();
            //                             if (nextStr !== '') {
            //                                 break;
            //                             }
            //                         }
            //                         if (nextStr !== '') {
            //                             extractedData.push({
            //                                 key: str,
            //                                 value: nextStr
            //                             });
            //                         }
            //                     }
            //                 });
            //                 break;
            //             case 'bl':
            //                 textContent.items.forEach(function(item, index) {
            //                     var str = item.str.trim();
            //                     if (index === 73) {
            //                         var concatStr = '';
            //                         if (textContent.items[93]) {
            //                             concatStr = textContent.items[93].str.trim();
            //                         }
            //                         extractedData.push({
            //                             key: str,
            //                             value: concatStr
            //                         });
            //                     } else if (str === 'Grand Total') {
            //                         var nextStr = '';
            //                         if (index + 1 < textContent.items.length) {
            //                             nextStr = textContent.items[index + 1].str.trim();
            //                             if (nextStr === '' && index + 2 < textContent.items.length) {
            //                                 nextStr = textContent.items[index + 2].str.trim();
            //                             }
            //                         }
            //                         extractedData.push({
            //                             key: str,
            //                             value: nextStr
            //                         });
            //                     } else if (['Date', 'InvoiceNo', 'Balance'].includes(str)) {
            //                         var nextStr = '';
            //                         for (var i = index + 1; i < textContent.items.length; i++) {
            //                             nextStr = textContent.items[i].str.trim();
            //                             if (nextStr !== '') {
            //                                 break;
            //                             }
            //                         }
            //                         if (nextStr !== '') {
            //                             extractedData.push({
            //                                 key: str,
            //                                 value: nextStr
            //                             });
            //                         }
            //                     } else {

            //                     }
            //                 });
            //                 break;
            //             case 'dgk':
            //                 break;
            //             default:
            //                 textContent.items.forEach(function(item) {
            //                     var str = item.str.trim();
            //                     console.log(str);
            //                     if (str.endsWith(':')) {
            //                         previousKey = str.substring(0, str.length - 1).trim();
            //                         previousLineEndsWithColon = true;
            //                     } else if (previousLineEndsWithColon) {
            //                         var value = str.trim();
            //                         extractedData.push({
            //                             key: previousKey,
            //                             value: value
            //                         });
            //                         previousLineEndsWithColon = false;
            //                         previousKey = '';
            //                     }
            //                 });
            //                 break;
            //         }

            //         console.log('Extracted Data:', extractedData);
            //     }).catch(function(reason) {
            //         console.error('Error extracting text:', reason);
            //     });
            // };
            // reader.readAsArrayBuffer(file);
        });

        document.getElementById('submitBtn').addEventListener('click', function() {
            var selectedOption = document.getElementById('dropdown').value;

            var data = {
                dropdownValue: selectedOption,
                extractedData: extractedData
            };
            console.log(data);


            /* code for sending the final data to api */
            fetch('formsubmit.php/invoice', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

    <!-- code for dispalying the invoice data start here  -->
    <script>
        if (typeof Tabulator !== 'undefined') {
            // Fetch data from API asynchronously
            fetch('formsubmit.php/invoice')
                .then(response => response.json())
                .then(data => {
                    // console.log(data);
                    var columns = [{
                        title: "S.No.",
                        field: "ivid",
                        headerFilter: true
                    }, {
                        title: "Invoice Number",
                        field: "invoicenumber",
                        headerFilter: true
                    }, {
                        title: "Invoice Date",
                        field: "date",
                        headerFilter: true
                    }];
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
                })
                .catch(error => {
                    console.error('Error fetching data from API:', error);
                });
        } else {
            console.error('Tabulator library not defined or not loaded.');
        }
    </script>


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
    </script>
</body>

</html>