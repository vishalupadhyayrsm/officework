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
    <!-- Include pdf.js library -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script> -->
    <script src="pdf.min.js"></script>
    <script src="pdf.worker.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-2" style="border-right:1px solid black;">
            </div>
            <div class="col-12 col-md-10">
                <div id="" class="container tab-content active-tab">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <h2 style="text-align:center;">PDF Text Extractor</h2>
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
            </div>
        </div>
    </div>

    <script>
        let extractedData = [];

        document.getElementById('pdfInput').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (!file) {
                console.error('No file selected.');
                return;
            }

            var reader = new FileReader();
            reader.onload = function(event) {
                var arrayBuffer = event.target.result;

                pdfjsLib.getDocument(arrayBuffer).promise.then(function(pdf) {
                    return pdf.getPage(1);
                }).then(function(page) {
                    return page.getTextContent();
                }).then(function(textContent) {
                    extractedData = [];
                    var previousLineEndsWithColon = false;
                    var previousKey = '';
                    var selectedOption = document.getElementById('dropdown').value;

                    console.log(textContent);

                    switch (selectedOption) {
                        case 'dmart':
                            if (str.endsWith(':')) {
                                previousKey = str.substring(0, str.length - 1).trim();
                                previousLineEndsWithColon = true;
                            } else if (previousLineEndsWithColon) {
                                var value = str.trim();
                                extractedData.push({
                                    key: previousKey,
                                    value: value
                                });
                                previousLineEndsWithColon = false;
                                previousKey = '';
                            }
                            break;
                        case 'ola':
                            textContent.items.forEach(function(item, index) {
                                var str = item.str.trim();

                                // Handle Total Payable
                                if (str === 'Total Payable') {
                                    var nextStr = '';
                                    var nextNextStr = '';

                                    // Check the next two items if they exist
                                    if (index + 1 < textContent.items.length) {
                                        nextStr = textContent.items[index + 1].str.trim();
                                    }
                                    if (index + 2 < textContent.items.length) {
                                        nextNextStr = textContent.items[index + 2].str.trim();
                                    }

                                    // Concatenate next two strings
                                    var balanceValue = nextStr + ' ' + nextNextStr;
                                    extractedData.push({
                                        key: 'Balance',
                                        value: balanceValue
                                    });
                                }
                                // Handle Date
                                else if (str === 'Date') {
                                    var nextStr = '';

                                    // Check the next item
                                    if (index + 1 < textContent.items.length) {
                                        nextStr = textContent.items[index + 1].str.trim();
                                    }

                                    extractedData.push({
                                        key: 'Date',
                                        value: nextStr
                                    });
                                }
                                // Handle CRN
                                else if (str.startsWith('CRN')) {
                                    extractedData.push({
                                        key: 'Invoice',
                                        value: str
                                    });
                                }
                            });

                            break;
                        case 'credence':
                            textContent.items.forEach(function(item, index) {
                                var str = item.str.trim();
                                if (['Date', 'Invoice No.', 'Balance'].includes(str)) {
                                    var nextStr = '';
                                    for (var i = index + 1; i < textContent.items.length; i++) {
                                        nextStr = textContent.items[i].str.trim();
                                        if (nextStr !== '') {
                                            break;
                                        }
                                    }
                                    if (nextStr !== '') {
                                        extractedData.push({
                                            key: str,
                                            value: nextStr
                                        });
                                    }
                                }
                            });
                            break;
                        case 'bl':
                            textContent.items.forEach(function(item, index) {
                                var str = item.str.trim();
                                if (index === 73) {
                                    var concatStr = '';
                                    if (textContent.items[93]) {
                                        concatStr = textContent.items[93].str.trim();
                                    }
                                    extractedData.push({
                                        key: str,
                                        value: concatStr
                                    });
                                } else if (str === 'Grand Total') {
                                    var nextStr = '';
                                    if (index + 1 < textContent.items.length) {
                                        nextStr = textContent.items[index + 1].str.trim();
                                        if (nextStr === '' && index + 2 < textContent.items.length) {
                                            nextStr = textContent.items[index + 2].str.trim();
                                        }
                                    }
                                    extractedData.push({
                                        key: str,
                                        value: nextStr
                                    });
                                } else if (['Date', 'InvoiceNo', 'Balance'].includes(str)) {
                                    var nextStr = '';
                                    for (var i = index + 1; i < textContent.items.length; i++) {
                                        nextStr = textContent.items[i].str.trim();
                                        if (nextStr !== '') {
                                            break;
                                        }
                                    }
                                    if (nextStr !== '') {
                                        extractedData.push({
                                            key: str,
                                            value: nextStr
                                        });
                                    }
                                } else {

                                }
                            });
                            break;
                        case 'dgk':

                            break;
                        default:
                            textContent.items.forEach(function(item) {
                                var str = item.str.trim();
                                console.log(str);
                                if (str.endsWith(':')) {
                                    previousKey = str.substring(0, str.length - 1).trim();
                                    previousLineEndsWithColon = true;
                                } else if (previousLineEndsWithColon) {
                                    var value = str.trim();
                                    extractedData.push({
                                        key: previousKey,
                                        value: value
                                    });
                                    previousLineEndsWithColon = false;
                                    previousKey = '';
                                }
                            });
                            break;
                    }

                    console.log('Extracted Data:', extractedData);
                }).catch(function(reason) {
                    console.error('Error extracting text:', reason);
                });
            };
            reader.readAsArrayBuffer(file);
        });

        document.getElementById('submitBtn').addEventListener('click', function() {
            var selectedOption = document.getElementById('dropdown').value;

            var data = {
                dropdownValue: selectedOption,
                extractedData: extractedData
            };
            console.log(data);

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
                    // Optionally handle success response
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle error
                });
        });
    </script>
</body>

</html>