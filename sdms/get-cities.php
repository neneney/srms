<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


$province_id = $_GET['province_id'];
$sql = "SELECT citymunDesc, citymunCode FROM refcitymun WHERE provCode = $province_id";
$result = $con->query($sql);

$cities = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
}

$con->close();

echo json_encode($cities);
