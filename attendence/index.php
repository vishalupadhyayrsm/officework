<?php
session_start();
include 'dbconfig.php';
if (isset($_SESSION['user_email'])) {
    $usertype = $_SESSION['usertype'];
    $email = $_SESSION['user_email'];
    $userid = $_SESSION['userid'];

    if ($usertype == 'admin') {
        $sql = "SELECT us.userid,us.userapproved, us.username, us.field, us.lab,pd.pid, pd.productname,pd.datetime, pd.productlink, pd.productprice, pd.quantity, pd.urgency,pd.addedcart,pd.orderstatus,
             pd.addedcartdate,pd.addedby,pd.handedover
             FROM user AS us JOIN product AS pd ON us.userid = pd.userid";
    } else {
        $sql = "SELECT us.userid,us.username, us.field, us.lab, pd.productname,pd.datetime, pd.productlink, pd.productprice, pd.quantity, pd.urgency,pd.addedcart,pd.orderstatus,pd.handedover
     FROM user AS us JOIN product AS pd ON us.userid = pd.userid WHERE us.email = :email";
    }

    $stmt = $conn->prepare($sql);

    if ($usertype == 'user') {
        $stmt->bindParam(':email', $email);
    }

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Attendance Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php
    $usertype = "User";
    ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <span class="navbar-brand">Welcome: <?php echo $usertype; ?></span>
            <div class="container">
                <div class="header-content">
                    <h2 class="model_name text-center">Leave Application Form</h2>
                </div>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>
    <br>
    <div class="tabs">
        <button onclick="showTab('tab1')" class="btn btn-primary order_status_button click_here_button">Order Here</button>
        <button onclick="showTab('tab2')" class="btn btn-primary order_status_button click_here_button">Order Status</button>
    </div>

    <div id="tab1" class="container tab-content active-tab">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mb-4">Date Input Form</h2>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $startDate = $_POST['start_date'];
                    $endDate = $_POST['end_date'];
                    $reason = $_POST['reason'];

                    echo '<div class="alert alert-info">';
                    echo "<h4>Your Input:</h4>";
                    echo "Start Date: " . htmlspecialchars($startDate) . "<br>";
                    echo "End Date: " . htmlspecialchars($endDate) . "<br>";
                    echo "Reason: " . htmlspecialchars($reason) . "<br>";
                    echo '</div>';
                }
                ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <input type="text" class="form-control" id="reason" name="reason" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div id="tab2" class="container tab-content">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mb-4">Displaying all the leave</h2>
                <?php
                echo '<table style="color: white; border-collapse: collapse; width: 100%; border: 1px solid white;">
                    <tr>
                        <th style="border: 1px solid white;">User Name</th>
                        <th style="border: 1px solid white;">Approved/Disapproved User</th>
                        <th style="border: 1px solid white;">Product Name</th>
                        <th style="border: 1px solid white;">Order Date</th>
                        <th style="border: 1px solid white;">Product Url</th>
                        <th style="border: 1px solid white;">Product Urgency</th>
                        <th style="border: 1px solid white;">Product Quantity</th>
                        <th style="border: 1px solid white;">Added to Cart</th>
                        <th style="border: 1px solid white;">Added to Cart Date</th>
                        <th style="border: 1px solid white;">Added By</th>
                        <th style="border: 1px solid white;">Handed Over</th>
                    </tr>';

                if ($results) {
                    foreach ($results as $result) {
                        echo '<tr>';
                        echo '<td style="border: 1px solid white;">' . htmlspecialchars("hello") . '</td>';
                        echo '<td style="border: 1px solid white;">';
                        if ($result['userapproved'] == 'no') {
                            echo '<button type="button" onclick="sendApprovalStatus(\'yes\', \'' . $result['userid'] . '\')" class="btn btn-danger approved_button1">Approved User</button>';
                        } else {
                            echo '<button type="button" onclick="sendApprovalStatus(\'no\', \'' . $result['userid'] . '\')" class="btn btn-success approved_button2">Disapproved User</button>';
                        }
                        echo '</td>';

                        echo '<td style="border: 1px solid white;">' . htmlspecialchars($result['productname']) . '</td>';
                        echo '<td style="border: 1px solid white;">' . htmlspecialchars($result['datetime']) . '</td>';
                        echo '<td style="border: 1px solid white;"><a href="' . htmlspecialchars($result['productlink']) . '">' . htmlspecialchars($result['productlink']) . '</a></td>';
                        echo '<td style="border: 1px solid white;">' . htmlspecialchars($result['urgency']) . '</td>';
                        echo '<td style="border: 1px solid white;">' . htmlspecialchars($result['quantity']) . '</td>';

                        /* code for displaying the added to cart data  */
                        echo '<td style="border: 1px solid white;">';
                        if ($usertype == 'admin' || $usertype == 'purchaseteam') {
                            if ($result['addedcart'] == 'no') {
                                echo '<button type="button" class="btn btn-primary cart-button  button_data" pid="' . htmlspecialchars($result["pid"]) . '" username="' . htmlspecialchars($usertype) . '" onclick="handleButtonClick(this)">Add To Cart</button>';
                            } else {
                                echo htmlspecialchars($result['addedcart']);
                            }
                        } else {
                            echo htmlspecialchars($result['addedcart']);
                        }
                        echo '</td>';
                        echo '<td style="border: 1px solid white;">' . htmlspecialchars($result['addedcartdate']) . '</td>';
                        echo '<td style="border: 1px solid white;">' . htmlspecialchars($result['addedby']) . '</td>';
                        // echo '<td style="border: 1px solid white;">' . htmlspecialchars($result['orderstatus']) . '</td>';
                        echo '<td style="border: 1px solid white;">';

                        /* code for dispalying the handedover data  */
                        if (($usertype == 'admin' || $usertype == 'purchaseteam')) {

                            if ($result['handedover'] == '') {
                                echo '<input type="text" style="width:120px;margin:10px;" class="handed_over" data-userid="' . htmlspecialchars($result['userid']) . '" placeholder="Handed Over" onkeypress="handleEnterKey(event)">';
                            } else {
                                echo htmlspecialchars($result['handedover']);
                            }
                        } else {
                            echo htmlspecialchars($result['handedover']);
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No results found.</td></tr>';
                }

                echo '</table>';
                ?>
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
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>