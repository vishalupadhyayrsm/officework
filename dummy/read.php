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

</head>

<body>
    <script>
        const pdfjsLib = window.pdfjsLib;

        function extractTextFromFirstPage(pdfUrl) {
            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                // Get the first page
                pdf.getPage(1).then(function(page) {
                    // Extract text content from the page
                    page.getTextContent().then(function(textContent) {
                        // Process the text items
                        const textItems = textContent.items;
                        let finalText = "";

                        for (let i = 0; i < textItems.length; i++) {
                            const item = textItems[i];
                            finalText += item.str + "\n";
                        }
                        console.log(finalText);
                    }).catch(function(error) {
                        console.error("Error extracting text content:", error);
                    });
                }).catch(function(error) {
                    console.error("Error getting the first page:", error);
                });
            }).catch(function(error) {
                console.error("Error loading the PDF document:", error);
            });
        }
        extractTextFromFirstPage('path/to/your/file.pdf');
    </script>
</body>

</html>