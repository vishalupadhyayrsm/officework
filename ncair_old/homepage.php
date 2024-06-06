<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/homepage.css">
    <script src="homepage.js"></script>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">About</a>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-center mb-3">
                <button class="btn btn-primary tab-button active" onclick="openTab(event, 'CAMERA')">CAMERA</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'NUC')">NUC</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'MONITOR')">MONITOR</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'LAPTOP')">LAPTOP</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'STANDALONE_SYSTEM')">STANDALONE SYSTEM</button>
                <button class="btn btn-primary tab-button" onclick="openTab(event, 'SERVER')">SERVER</button>
            </div>
        </div>

        <div id="CAMERA" class="tab-content" style="display: block;">
            <form action="camera.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="processor">Processor:</label>
                    <input type="text" class="form-control" id="processor" name="processor">
                </div>
                <div class="form-group">
                    <label for="ssd">SSD:</label>
                    <input type="text" class="form-control" id="ssd" name="ssd">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="location_user">Location/User:</label>
                    <input type="text" class="form-control" id="location_user" name="location_user">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="NUC" class="tab-content">
            <form action="nuc.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="processor">Processor:</label>
                    <input type="text" class="form-control" id="processor" name="processor">
                </div>
                <div class="form-group">
                    <label for="ssd">SSD:</label>
                    <input type="text" class="form-control" id="ssd" name="ssd">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="location_user">Location/User:</label>
                    <input type="text" class="form-control" id="location_user" name="location_user">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="MONITOR" class="tab-content">
            <form action="monitor.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="processor">Processor:</label>
                    <input type="text" class="form-control" id="processor" name="processor">
                </div>
                <div class="form-group">
                    <label for="ssd">SSD:</label>
                    <input type="text" class="form-control" id="ssd" name="ssd">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="location_user">Location/User:</label>
                    <input type="text" class="form-control" id="location_user" name="location_user">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="LAPTOP" class="tab-content">
            <form action="laptop.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="processor">Processor:</label>
                    <input type="text" class="form-control" id="processor" name="processor">
                </div>
                <div class="form-group">
                    <label for="ssd">SSD:</label>
                    <input type="text" class="form-control" id="ssd" name="ssd">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="location_user">Location/User:</label>
                    <input type="text" class="form-control" id="location_user" name="location_user">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="STANDALONE_SYSTEM" class="tab-content">
            <form action="standalone_system.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="processor">Processor:</label>
                    <input type="text" class="form-control" id="processor" name="processor">
                </div>
                <div class="form-group">
                    <label for="ssd">SSD:</label>
                    <input type="text" class="form-control" id="ssd" name="ssd">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="location_user">Location/User:</label>
                    <input type="text" class="form-control" id="location_user" name="location_user">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div id="SERVER" class="tab-content">
            <form action="server.php" method="POST">
                <div class="form-group">
                    <label for="serial_number">Serial Number:</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="configuration">Configuration:</label>
                    <input type="text" class="form-control" id="configuration" name="configuration">
                </div>
                <div class="form-group">
                    <label for="processor">Processor:</label>
                    <input type="text" class="form-control" id="processor" name="processor">
                </div>
                <div class="form-group">
                    <label for="ssd">SSD:</label>
                    <input type="text" class="form-control" id="ssd" name="ssd">
                </div>
                <div class="form-group">
                    <label for="ip">IP:</label>
                    <input type="text" class="form-control" id="ip" name="ip">
                </div>
                <div class="form-group">
                    <label for="location_user">Location/User:</label>
                    <input type="text" class="form-control" id="location_user" name="location_user">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>