<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentno = $_POST['rowNo'];
    $class_id = $_POST['classes'];
    $status = "active";
    $remarks = "none";
    $sql1 = "SELECT * FROM class_enrollment WHERE student_id = :studentno";
    $query1 = $dbh->prepare($sql1);
    $query1->bindParam(':studentno', $studentno, PDO::PARAM_INT);
    $query1->execute();
    $enrollment = $query1->fetch(PDO::FETCH_ASSOC);

    if ($enrollment) {
        $class_sql = "UPDATE class_enrollment SET class_id = :class_id, status = :status, remarks = :remarks WHERE student_id = :studentno";
    } else {
        $class_sql = "INSERT INTO class_enrollment (student_id, class_id, status, remarks) VALUES (:studentno, :class_id, :status, :remarks)";
    }

    $query = $dbh->prepare($class_sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $query->bindParam(':studentno', $studentno, PDO::PARAM_INT);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':remarks', $remarks, PDO::PARAM_STR);
    $result = $query->execute();

    if ($result) {
        // Insert the new enrollment into the enrollment_history table
        $enrollment_sql = "INSERT INTO enrollment_history (student_id, class_id, status, remarks) VALUES (:studentno, :class_id, :status, :remarks)";
        $enrollment_class = $dbh->prepare($enrollment_sql);
        $enrollment_class->bindParam(':studentno', $studentno, PDO::PARAM_INT);
        $enrollment_class->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $enrollment_class->bindParam(':status', $status, PDO::PARAM_STR);
        $enrollment_class->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $enrollment_class->execute();

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
