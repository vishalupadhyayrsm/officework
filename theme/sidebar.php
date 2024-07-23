<?php
session_start();
// include 'dbconfig.php';
$usertype = $_SESSION['usertype'];
// echo $usertype;
?>

<div class="nav-header">
    <a href="" class="brand-logo">
        <img class="logo-abbr" src="./images/logo.png" alt="">
        <img class="logo-compact" src="./images/mip.png" alt="">
        <img class="brand-title" src="./images/mip.png" alt="">
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>


<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="search_bar dropdown">
                        <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                            <i class="mdi mdi-magnify"></i>
                        </span>
                        <!-- code for search bar start here  -->
                        <div class="dropdown-menu p-0 m-0">
                            <form>
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>
                </div>

                <ul class="navbar-nav header-right">
                    <!--<li class="nav-item dropdown notification_dropdown">-->
                    <!--    <a class="nav-link" href="#" role="button" data-toggle="dropdown">-->
                    <!--        <i class="mdi mdi-bell"></i>-->
                    <!--        <div class="pulse-css"></div>-->
                    <!--    </a>-->
                    <!-- code for dispaying the notification start here  -->
                    <!--    <div class="dropdown-menu dropdown-menu-right">-->
                    <!--        <ul class="list-unstyled">-->
                    <!--            <li class="media dropdown-item">-->
                    <!--                <span class="success"><i class="ti-user"></i></span>-->
                    <!--                <div class="media-body">-->
                    <!--                    <a href="#">-->
                    <!--                        <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully-->
                    <!--                        </p>-->
                    <!--                    </a>-->
                    <!--                </div>-->
                    <!--                <span class="notify-time">3:20 am</span>-->
                    <!--            </li>-->
                    <!--            <li class="media dropdown-item">-->
                    <!--                <span class="primary"><i class="ti-shopping-cart"></i></span>-->
                    <!--                <div class="media-body">-->
                    <!--                    <a href="#">-->
                    <!--                        <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>-->
                    <!--                    </a>-->
                    <!--                </div>-->
                    <!--                <span class="notify-time">3:20 am</span>-->
                    <!--            </li>-->
                    <!--            <li class="media dropdown-item">-->
                    <!--                <span class="danger"><i class="ti-bookmark"></i></span>-->
                    <!--                <div class="media-body">-->
                    <!--                    <a href="#">-->
                    <!--                        <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.-->
                    <!--                        </p>-->
                    <!--                    </a>-->
                    <!--                </div>-->
                    <!--                <span class="notify-time">3:20 am</span>-->
                    <!--            </li>-->
                    <!--            <li class="media dropdown-item">-->
                    <!--                <span class="primary"><i class="ti-heart"></i></span>-->
                    <!--                <div class="media-body">-->
                    <!--                    <a href="#">-->
                    <!--                        <p><strong>David</strong> purchased Light Dashboard 1.0.</p>-->
                    <!--                    </a>-->
                    <!--                </div>-->
                    <!--                <span class="notify-time">3:20 am</span>-->
                    <!--            </li>-->
                    <!--            <li class="media dropdown-item">-->
                    <!--                <span class="success"><i class="ti-image"></i></span>-->
                    <!--                <div class="media-body">-->
                    <!--                    <a href="#">-->
                    <!--                        <p><strong> James.</strong> has added a<strong>customer</strong> Successfully-->
                    <!--                        </p>-->
                    <!--                    </a>-->
                    <!--                </div>-->
                    <!--                <span class="notify-time">3:20 am</span>-->
                    <!--            </li>-->
                    <!--        </ul>-->
                    <!-- code for notification ends here  -->
                    <!-- code for see all the notification start here nad i have to add the link -->
                    <!--        <a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i></a>-->
                    <!--    </div>-->
                    <!--</li>-->
                    <!-- code for getting dropdown list start here  -->
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-account"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!--<a href="./profile.php" class="dropdown-item">-->
                            <!--    <i class="icon-user"></i>-->
                            <!--    <span class="ml-2">Profile </span>-->
                            <!--</a>-->
                            <!--<a href="./email-inbox.html" class="dropdown-item">-->
                            <!--    <i class="icon-envelope-open"></i>-->
                            <!--    <span class="ml-2">Inbox </span>-->
                            <!--</a>-->
                            <a href="./logout.php" class="dropdown-item">
                                <i class="icon-key"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>


<?php
// Split the $usertype string into an array of roles
$usertypeArray = array_map('trim', explode(',', $usertype));
?>

<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-single-04"></i><span class="nav-text" style='color:white;'>Dashboard</span></a>
                <ul aria-expanded="false">
                    <li><a href="./user.php">Dashboard</a></li>
                    <?php if (in_array('hr', $usertypeArray) || in_array('admin', $usertypeArray)) : ?>
                        <li><a href="./home.php">HR</a></li>
                    <?php endif; ?>
                    <?php if (in_array('staff', $usertypeArray) || in_array('intern', $usertypeArray) || in_array('student', $usertypeArray)) : ?>
                        <!-- Add specific items for these roles if needed -->
                    <?php endif; ?>
                    <?php if (in_array('purchase', $usertypeArray) || in_array('admin', $usertypeArray)) : ?>
                        <li><a href="./inventory.php">Amazon</a></li>
                    <?php endif; ?>
                    <?php if (in_array('account', $usertypeArray)) : ?>
                        <li><a href="./account.php">Account</a></li>
                        <!--<li><a href="./home.php">HR</a></li>-->
                    <?php endif; ?>
                    <?php if (in_array('admin', $usertypeArray)) : ?>
                        <li><a href="./account.php">Account</a></li>
                    <?php endif; ?>
                    <?php if (in_array('admin', $usertypeArray) || in_array('cash', $usertypeArray)) : ?>
                        <li><a href="./cash.php">Cash</a></li>
                    <?php endif; ?>
                    <li><a href="./applyleave.php">All Application</a></li>
                    <?php if (in_array('systemadmin', $usertypeArray) || in_array('admin', $usertypeArray)) : ?>
                        <!-- <li><a href="./systemregister.php">System Registration</a></li> -->
                    <?php endif; ?>
                    <li><a href="/system">System</a></li>
                    <li><a href="./resign.php">Exit Formalities</a></li>
                </ul>
            </li>
            <li class="nav-label">User Details</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-app-store"></i><span class="nav-text" style='color:white;'>Profile</span></a>
                <ul aria-expanded="false">
                    <li><a href="./userprofile.php">Profile</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>