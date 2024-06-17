<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = $_SESSION['sid'];

    $name = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $sql = "update tblusers set name=:name,username=:username,lastname=:lastname where id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
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
