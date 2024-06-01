
<?php
session_start();
include("includes/dbconnection.php");
date_default_timezone_set('Asia/Manila');
$ldate = date('d-m-Y h:i:s A', time());
$sid = $_SESSION['sid'];
$sql = "UPDATE userlog  SET logout=:ldate WHERE userID = '$sid' ORDER BY id DESC LIMIT 1";
$query = $dbh->prepare($sql);
$query->bindParam(':ldate', $ldate, PDO::PARAM_STR);
$query->execute();
$_SESSION['errmsg'] = "You have successfully logout";
unset($_SESSION['cpmsaid']);
session_destroy(); // destroy session
header("location:index.php");
?>