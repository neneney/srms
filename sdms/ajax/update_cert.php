<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_SESSION['edid'];
    $studentCert = $_FILES["studentCert"]["name"];

    // Ensure the upload directory exists
    $target_dir = "student_cert/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Move the uploaded file
    move_uploaded_file($_FILES["studentCert"]["tmp_name"], $target_dir . $studentCert);

    // Insert the record into the database
    $sql = "INSERT INTO student_cert (image, student_id) VALUES (:studentCert, :sid)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':studentCert', $studentCert, PDO::PARAM_STR);
    $query->bindParam(':sid', $sid, PDO::PARAM_INT);

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
