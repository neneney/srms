<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_POST['rowId'];
    $studentimage = $_FILES["studentimage"]["name"];
    move_uploaded_file($_FILES["studentimage"]["tmp_name"], "../studentimages/" . $_FILES["studentimage"]["name"]);
    $sql = "update students set studentImage=:studentimage where id='$sid' ";
    $query = $dbh->prepare($sql);
    $query->bindParam(':studentimage', $studentimage, PDO::PARAM_STR);
    if ($query->execute()) {
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
