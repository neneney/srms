<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $educ_level = $_POST['levels'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $type = $_POST['type'];
    $teacher = $_POST['teacher'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $strand = $_POST['strand'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];


    $sql = "INSERT INTO classes (`educ-level`, `strand`, `title`, `type`, `code`, `name`, `teacher`, `start-date`, `end-date`, `start_time`, `end_time`) 
    VALUES (:educ_level, :strand, :title, :type, :code, :name, :teacher, :start_date, :end_date, :start_time, :end_time)";

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
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $response['status'] = 'success';
        $response['message'] = 'Class Added successfully.';
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
