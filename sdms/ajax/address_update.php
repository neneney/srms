<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sid = $_POST['rowId'];
    $province = $_POST['province1'];
    $city = $_POST['city1'];
    $barangay = $_POST['barangay1'];
    $village = $_POST['village1'];

    $sql = "UPDATE students SET province=:province, city=:city, barangay=:barangay, `village-house-no`=:village WHERE id=:sid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':province', $province, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':barangay', $barangay, PDO::PARAM_STR);
    $query->bindParam(':village', $village, PDO::PARAM_STR);
    $query->bindParam(':sid', $sid, PDO::PARAM_INT);
    $result = $query->execute();

    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Updated successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong, please try again later.';
    }
    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
