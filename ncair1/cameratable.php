<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    // $serial_number = $_POST
    // Database connection parameters
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "device_management_system";

    // Create a connection to the database
    $conn = new mysqli($host, $user, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Fetch data from camera table
    $sql = "SELECT * FROM camera";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Close the statement and connection
    // $stmt->close();
    $conn->close();
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tabulator CSS -->
    <link href="https://unpkg.com/tabulator-tables@5.2.7/dist/css/tabulator.min.css" rel="stylesheet">
    <style>
        .tabulator {
            height: 800px;
            width: fit-content;
            /* Set a height for the table */
        }
    </style>
</head>

<body>
    <!-- Add the container for the Tabulator table -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div id="camera-table"></div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--  Tabulator JS -->
    <script src="https://unpkg.com/tabulator-tables@5.2.7/dist/js/tabulator.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create Tabulator table
            var table = new Tabulator("#camera-table", {
                data: <?php echo json_encode($data); ?>, // Load data from PHP
                layout: "fitColumns", // Fit columns to width of table
                columns: [ // Define the table columns
                    // {
                    //     title: "sno.",
                    //     field: "sno.",
                    //     sorter: "string",
                    //     width: 150,
                    //     editor: true
                    // },
                    {
                        title: "Camera Name",
                        field: "CameraName",
                        // sorter: "string",
                        width: 150,
                        editor: true
                    },
                    {
                        title: "Category",
                        field: "category",
                        // sorter: "string",
                        width: 150,
                        editor: true
                    },
                    {
                        title: "Configuration",
                        field: "configuration",
                        // sorter: "string",
                        width: 150,
                        editor: true
                    },
                    {
                        title: "IpAddress",
                        field: "ip",
                        // sorter: "string",
                        width: 150,
                        editor: true
                    },
                    {
                        title: "Monitor",
                        field: "monitor",
                        // sorter: "string",
                        width: 150,
                        editor: true
                    },
                    {
                        title: "Status",
                        field: "status",
                        // sorter: "string",
                        width: 150,
                        editor: true
                    },
                    {
                        title: "Remark",
                        field: "remark",
                        // sorter: "string",
                        width: 150,
                        editor: true
                    },
                ],
            });
        });
    </script>
</body>

</html>