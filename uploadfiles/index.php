<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="month">Joining as :</label>
                <select class="form-control" id="month" name="producttype">
                    <option value="">Select</option>
                    <option value="Amazon">Amazon</option>
                    <option value="Vendor">Vendor</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="name">Product Brief:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="product">
            </div>
            <div class="mb-3">
                <label for="email">Date:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter date" name="date">
            </div>
            <div class="mb-3">
                <label for="file">Upload File:</label>
                <input type="file" class="form-control" id="file" name="uploadedfile">
            </div>
            <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
            <a href="login.php" class="btn btn-secondary">Login</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function submitForm() {
            // Get form elements
            const form = document.getElementById('uploadForm');
            const productType = document.getElementById('month').value;
            const product = document.getElementById('name').value;
            const date = document.getElementById('email').value;
            const fileInput = document.getElementById('file');

            if (!fileInput.files.length) {
                alert('Please select a file to upload');
                return;
            }

            // Get the selected file
            const file = fileInput.files[0];
            const originalFilename = file.name;
            const fileExtension = originalFilename.split('.').pop();
            const safeProduct = product.replace(/[^A-Za-z0-9_\-]/g, '_');
            const finalFilename = `${safeProduct}_${date}_${productType}.${fileExtension}`;

            // Create FormData object
            const formData = new FormData(form);
            formData.append('newfilename', finalFilename);

            // Remove the original file entry and add the modified file entry
            formData.delete('uploadedfile');
            formData.append('uploadedfile', file, finalFilename);

            // Send the form data using fetch
            fetch('main.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Handle the response from the server
                    console.log(data);
                    alert('Form submitted successfully');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error submitting form');
                });
        }
    </script>



    </script>
</body>

</html>