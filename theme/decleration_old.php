<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MIP</title>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/logo.png">
    <link href="./vendor/jquery-steps/css/jquery.steps.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .text-label {
            color: black;
        }

        li {
            color: black;
        }
    </style>
</head>

<body>
    <div id="main-wrapper">
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back!</h4>
                            <p class="mb-0">Your business dashboard template</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Components</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form step</h4>
                            </div>
                            <div class="card-body">

                                <form method="post" action="formsubmit.php/deceleration" enctype="multipart/form-data" id="regForm" class="step-form-horizontal">
                                    <div>
                                        <h4>Personal Info</h4>
                                        <section>
                                            <div class="row">
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">IITB Email (if available):</label>
                                                        <div class="input-group">
                                                            <input type="email" class="form-control" id="name" name="iitbmail">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Employee No/Student Roll No:</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="emp_roll" name="emproll">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">University:</label>
                                                        <input type="text" class="form-control" id="university" name="univesity" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Aadhar Card:</label>
                                                        <input type="text" class="form-control" placeholder="Please enter 12 digite Aadhar card number" id="aadahr" name="adhar" pattern="\d{12}" maxlength="12" required>
                                                        <div class="invalid-feedback">
                                                            Please enter a valid 12-digit Aadhar Card number.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Gender:</label>
                                                        <select class="form-control" name="gender" required>
                                                            <option value="">Select</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Local Address (In case of IIT Bombay Student please provide your hostel details here):</label>
                                                        <input type="text" class="form-control" id="localadd" name="localadd" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Postal Code:</label>
                                                        <input type="number" class="form-control" id="localadd" name="localpostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Upload Image:</label>
                                                        <input type="file" class="form-control" id="image" name="profileimage" accept=".jpg, .jpeg, .png" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <h4>
                                            Emergency Contact Details (First Person)
                                        </h4>
                                        <section>
                                            <div class="row">
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Permanent Address:</label>
                                                        <input type="text" class="form-control" id="localadd" name="permadd" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Postal Code:</label>
                                                        <input type="number" class="form-control" id="permaadd" name="permapostalcode" required minlength="6" maxlength="6" pattern="\d{6}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Home Contact No:</label>
                                                        <input type="number" class="form-control" id="localadd" name="phone" required pattern="\d{10}" title="Please enter a 10-digit phone number">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Name:</label>
                                                        <input type="text" class="form-control" id="emergencyname1" name="emergencyname1" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Relationsip:</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="relationship1" name="relationship1" required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Contact No:</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="localadd" name="emephone1" required pattern="\d{10}" title="Please enter a 10-digit phone number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Contact address if different from above:</label>
                                                        <input type="text" class="form-control" id="localadd_emergency1" name="localadd_emergency1" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Postal Code:</label>
                                                        <input type="number" class="form-control" id="localpostalcode_emergency1" name="localpostalcode_emergency1" required minlength="6" maxlength="6" pattern="\d{6}">
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <h4>Emergency Contact Details (Second Person)</h4>
                                        <section>
                                            <div class="row">
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Name:</label>
                                                        <input type="text" class="form-control" id="emergencyname2" name="emergencyname2" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Relationsip:</label>
                                                        <input type="text" class="form-control" id="relationship2" name="relationship2" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="text-label">Are there any medical conditions we should know about in the case of an emergency:</label>
                                                        <input type="text" class="form-control" id="relationship" name="medicalcondition">
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <h4></h4>
                                        <section>
                                            <div class="row">
                                                <div class="form-group">
                                                    <ol>
                                                        <li>I will not, directly or indirectly, divulge any information connected with the project to any person(s) other than those
                                                            authorized by the principle investigator.
                                                        </li><br>
                                                        <li>
                                                            I shall keep and maintain systematic records of all data, results supplied by the client or generated in teh course of the project etc. and
                                                            will not divulge these to third party.
                                                        </li><br>
                                                        <li>
                                                            I shall not make / keep additional copies of any data / results / reports pertaining to the project without teh express permission of teh principle investigator.
                                                        </li><br>
                                                        <li>
                                                            I agree that all data generated in the project, paper/ drawings / computer software and other records in my possession pertaining to the project will
                                                            be the property of Indian Instittue of Technology Bombay and I shall have no claim on teh same and I will hand over all these documents to the project
                                                            investigator before I resign from or leave the project.
                                                        </li><br>
                                                        <li>
                                                            Even after my leaveing the institute / resignation / termination of appoinmanet, I will not disclose my confidential information pertainng to teh project
                                                            or otherwise made available to me during my tenure, to any third party.
                                                        </li><br>
                                                        <li>
                                                            I agree that all intellectual property generated through the project will be deemed assigned exclusively to National Center for Aerospace Innovation and Research,
                                                            Indian Institute of Technology Bombay for use / dissemination / transfer or licence for payment of royalty or transfer fee, as it may deem fit.
                                                        </li><br>
                                                    </ol>
                                                    <br>
                                                    <div class="form-group">
                                                        <p style='color:black;'>I have read teh above aggreement carefully and accept that this is a legally valid and binding obligation and hereby agree to the above.</p>
                                                        <input type="checkbox" class="form-check-input" id="termsCheck" name="termcheck" required>
                                                        <label class="form-check-label" for="termsCheck" style='color:black;'>
                                                            I agree to the above terms and conditions.
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">MIP</a>2024</p>
            </div>
        </div>


    </div>
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>



    <script src="./vendor/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="./vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="./js/plugins-init/jquery.validate-init.js"></script>
    <script src="./js/plugins-init/jquery-steps-init.js"></script>

</body>

</html>