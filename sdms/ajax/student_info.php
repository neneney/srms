<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php'); // Ensure the correct path

$response = array(); // Initialize response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_POST['rowId'];

    $last_name = $_POST['last-name'];
    $middle_name = $_POST['middle-name'];
    $first_name = $_POST['first-name'];
    $suffix = $_POST['suffix'];
    $regno = $_POST['regno'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];

    $sql = "UPDATE students SET `last-name`=:last_name, `first-name`=:first_name, `middle-name`=:middle_name, suffix=:suffix, studentno=:regno, gender=:sex, age=:age WHERE id=:sid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $query->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
    $query->bindParam(':suffix', $suffix, PDO::PARAM_STR);
    $query->bindParam(':regno', $regno, PDO::PARAM_STR);
    $query->bindParam(':sex', $sex, PDO::PARAM_STR);
    $query->bindParam(':age', $age, PDO::PARAM_STR);
    $query->bindParam(':sid', $sid, PDO::PARAM_STR);

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
