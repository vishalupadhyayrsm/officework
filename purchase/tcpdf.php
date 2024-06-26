<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Text Extractor</title>
    <!-- Include pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
</head>

<body>
    <h1>PDF Text Extractor</h1>
    <input type="file" id="pdfInput" accept=".pdf">
    <select id="dropdown">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
        <option value="option4">Option 4</option>
    </select>
    <button id="submitBtn">Submit</button>
    <div id="pdfText"></div>

    <script>
        // code for reading teh text from teh pdf file and 
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
                    var extractedData = [];
                    var previousLineEndsWithColon = false;
                    var previousKey = '';

                    textContent.items.forEach(function(item) {
                        var str = item.str.trim();

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

                    var jsonData = extractedData;
                    console.log(typeof(jsonData)); // Should log 'object'
                    console.log('Extracted Data:', extractedData);
                    displayExtractedData(jsonData); // Display extracted data on the webpage

                }).catch(function(reason) {
                    console.error('Error extracting text:', reason);
                });
            };
            reader.readAsArrayBuffer(file);
        });

        document.getElementById('submitBtn').addEventListener('click', function() {
            var selectedOption = document.getElementById('dropdown').value;
            var jsonData = document.getElementById('pdfText').textContent;

            var data = {
                dropdownValue: selectedOption,
                extractedData: JSON.parse(jsonData) // Ensure JSON parsing here if jsonData is JSON string
            };
            console.log(data);

            fetch('your_php_endpoint.php', {
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

        function displayExtractedData(data) {
            var jsonData = JSON.stringify(data, null, 2);
            document.getElementById('pdfText').textContent = jsonData;
        }
    </script>
</body>

</html>