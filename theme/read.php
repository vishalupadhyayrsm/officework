<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR with Tesseract.js and PDF.js</title>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
</head>

<body>
    <input type="file" id="fileInput" accept="image/*,application/pdf">
    <div id="output"></div>

    <script>
        const apiUrl = 'formsubmit.php/indentor';

        async function sendTextToApi(text) {
            console.log(text);
            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        text: encodeURIComponent(text)
                    })

                });
                //  console.log(body);
                const result = await response.text();
                console.log('Response from API:', result);
            } catch (error) {
                console.error('Error sending text to API:', error);
            }
        }
        let accumulatedText = '';
        async function handleImage(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                Tesseract.recognize(
                    e.target.result,
                    'eng', {
                        logger: info => console.log(info)
                    }
                ).then(({
                    data: {
                        text
                    }
                }) => {
                    console.log(typeof(text))
                    accumulatedText += text + '\n';
                    document.getElementById('output').innerText = accumulatedText;
                    var body = 'extractedTextURL=' + encodeURIComponent(accumulatedText);
                    // console.log(body);           

                    fetch('formsubmit.php/indentor', {
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


                }).catch(err => {
                    console.error('Error recognizing text:', err);
                    document.getElementById('output').innerText = 'Error recognizing text. See console for details.';
                });
            };
            reader.readAsDataURL(file);
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

            canvas.toBlob(blob => {
                const imageFile = new File([blob], 'page.png', {
                    type: 'image/png'
                });
                handleImage(imageFile);
            }, 'image/png');
        }

        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.type.match('image.*')) {
                    handleImage(file);
                } else if (file.type === 'application/pdf') {
                    handlePdf(file);
                } else {
                    console.error('Invalid file type');
                    document.getElementById('output').innerText = 'Invalid file type';
                }
            } else {
                console.error('No file selected');
                document.getElementById('output').innerText = 'No file selected';
            }
        });
    </script>
</body>

</html>