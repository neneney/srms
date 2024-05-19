<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

$sql = "SELECT provDesc, provCode FROM refprovince ORDER BY provDesc ASC";
$result = $con->query($sql);

$provinces = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $provinces[] = $row;
    }
}

$con->close();

echo json_encode($provinces);

// Output the JSON data

// Log the JSON data to the console using JavaScript
