<?php
include 'dbconfig.php';
$sid = 17;
$sql = "SELECT `cid`, `sid`, `piname`, `username`,`start_date`,`end_date`,`certificatestatus`, `collegename`, `workdone`,`filelocation` FROM `certificate` where sid=:sid ";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':sid', $sid);
$stmt->execute();
$certificate = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($certificate);
$finalurl = 'https://miphub.in/' . htmlspecialchars($certificate[0]['filelocation']) . "#toolbar=0";
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
    <style>
        label {
            color: black;
        }

        iframe {
            height: 600px;
        }

        body {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>
</head>

<body>
    <div id="main-wrapper">
        <?php include 'sidebar.php' ?>
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <?php  //if ($usertype != 'hr' && $usertype != 'intern') { 
                    ?>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View Certificate</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!--code for if teh certifciate is ok or not -->

                                    <!----code for displaying the certificate start here  --->
                                    <div class="col-xl-12 col-lg-8">
                                        <!--<div id="leave"></div>-->
                                        <iframe class="col-xl-12 col-lg-8" src="<?php echo $finalurl; ?>"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">View Certificate</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!--code for if teh certifciate is ok or not -->

                                    <!----code for displaying the certificate start here  --->
                                    <div class="col-xl-12 col-lg-8">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php  //} 
                    ?>
                    <div>
                    </div>

                </div>


            </div>
        </div>
        <!-- code for main body ends here  -->

        <!-- code for footer start here  -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright MIP <a href="#" target="_blank"></a>2024</p>
            </div>
        </div>
        <!-- code for footer ends here  -->

    </div>
    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable print screen (Ctrl+P) and other keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && (event.key === 'p' || event.key === 's' || event.key === 'a')) {
                event.preventDefault();
            }
        });

        document.getElementById('confirmButton').addEventListener('click', function() {
            alert("It's OK");
        });

        document.getElementById('changeButton').addEventListener('click', function() {
            var changes = prompt("Enter the changes needed:");
            if (changes) {
                alert("Changes requested: " + changes);
            }
        });
    </script>

    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>
    <!-- Vectormap -->
    <script src="./vendor/raphael/raphael.min.js"></script>
    <script src="./vendor/morris/morris.min.js"></script>
    <script src="./vendor/circle-progress/circle-progress.min.js"></script>
    <script src="./vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="./vendor/gaugeJS/dist/gauge.min.js"></script>
    <!--  flot-chart js -->
    <script src="./vendor/flot/jquery.flot.js"></script>
    <script src="./vendor/flot/jquery.flot.resize.js"></script>
    <!-- Owl Carousel -->
    <script src="./vendor/owl-carousel/js/owl.carousel.min.js"></script>
    <!-- Counter Up -->
    <script src="./vendor/jqvmap/js/jquery.vmap.min.js"></script>
    <script src="./vendor/jqvmap/js/jquery.vmap.usa.js"></script>
    <script src="./vendor/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="./js/dashboard/dashboard-1.js"></script>

</body>

</html>