<?php
if (isset($_SESSION['user_email'])) {
  $usertype = $_SESSION['usertype'];
  $email = $_SESSION['user_email'];
  $userid = $_SESSION['userid'];
  if ($usertype == 'admin') {
    $sql = "SELECT us.userid,us.userapproved, us.username,us.userfullname,us.email,us.phoneNo, us.field, us.lab, pd.pid ,pd.userId, pd.productname,pd.datetime, pd.productlink, pd.productprice,
            pd.tpprice,pd.quantity, pd.urgency,pd.addedcart,pd.orderstatus,pd.productstatus,
             pd.addedcartdate,pd.addedby,pd.handedover
             FROM user AS us JOIN product AS pd ON us.userid = pd.userid
             ORDER BY pd.pid DESC"; // Add ORDER BY clause here
  } elseif ($usertype == 'purchaseteam') {
    $sql = "SELECT us.userid,us.userapproved,us.username,us.userfullname,us.email,us.phoneNo, us.field, us.lab,pd.pid, pd.userId, pd.productname,pd.datetime, pd.productlink, pd.productprice,
    pd.tpprice,pd.quantity, pd.urgency, pd.addedcart,pd.handedover,pd.orderstatus,pd.productstatus,
     pd.addedcartdate,pd.addedby FROM user AS us JOIN product AS pd ON us.userid = pd.userid
     ORDER BY pd.pid DESC"; // Add ORDER BY clause here
  } else {
    $sql = "SELECT us.userid,us.username,us.userfullname,us.email,us.phoneNo, us.field, us.lab, pd.productname,pd.datetime, pd.productlink, pd.productprice,pd.addedcartdate,pd.addedby,
    pd.tpprice,pd.quantity, pd.urgency,pd.addedcart,pd.orderstatus,pd.productstatus,pd.handedover
     FROM user AS us JOIN product AS pd ON us.userid = pd.userid WHERE us.email = :email
     ORDER BY pd.pid DESC"; // Add ORDER BY clause here
  }

  $stmt = $conn->prepare($sql);

  if ($usertype == 'user') {
    $stmt->bindParam(':email', $email);
  }

  $stmt->execute();

  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // echo "not logged in";
    header("Location: login.php");
    exit();
  }
?>
