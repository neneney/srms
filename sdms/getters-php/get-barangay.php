<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

$city_id = $_GET['city_id'];
$sql = "SELECT * FROM refbrgy WHERE citymunCode = $city_id";
$result = $con->query($sql);

$barangays = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $barangays[] = $row;
    }
}

$con->close();

echo json_encode($barangays);
