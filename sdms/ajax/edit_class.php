<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = $_POST['rowId'];
    $code = $_POST['edit-code'];
    $name = $_POST['edit-name'];
    $educ_level = $_POST['edit-levels'];
    $teacher = $_POST['edit-teacher'];
    $start_date = $_POST['edit-start_date'];
    $end_date = $_POST['edit-end_date'];
    $strand = $_POST['strand'];
    $title = $_POST['e-title'];
    $type = $_POST['e-type'];
    $start_time = $_POST['e-start_time'];
    $end_time = $_POST['e-end_time'];

    $sql = "UPDATE classes 
        SET `educ-level` = :educ_level, 
            strand = :strand, 
            title = :title,
            type = :type,
            `code` = :code, 
            `name` = :name, 
            `teacher` = :teacher, 
            `start-date` = :start_date, 
            `end-date` = :end_date,
            start_time = :start_time,
            end_time = :end_time
        WHERE id = :eid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':educ_level', $educ_level, PDO::PARAM_STR);
    $query->bindParam(':strand', $strand, PDO::PARAM_STR);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':type', $type, PDO::PARAM_STR);
    $query->bindParam(':code', $code, PDO::PARAM_STR);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);
    $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    $query->bindParam(':start_time', $start_time, PDO::PARAM_STR);
    $query->bindParam(':end_time', $end_time, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_INT);

    $result = $query->execute();

    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Class updated successfully.';
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
