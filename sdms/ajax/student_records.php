<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
$class_code = $_POST['class_code'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dbh->beginTransaction();

        // Fetch all students enrolled in the class
        $stmt = $dbh->prepare("SELECT student_id FROM class_enrollment WHERE class_id = :class_code");
        $stmt->bindParam(':class_code', $class_code, PDO::PARAM_STR);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($students as $student) {
            $studentno = $student['student_id'];
            $status = $_POST['status_' . $studentno];
            $remarks = $_POST['remarks_' . $studentno];

            // Update status and remarks in the database
            $query = "UPDATE class_enrollment SET status = :status, remarks = :remarks WHERE class_id = :class_code AND student_id = :studentno";
            $updateStmt = $dbh->prepare($query);
            $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
            $updateStmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
            $updateStmt->bindParam(':class_code', $class_code, PDO::PARAM_STR);
            $updateStmt->bindParam(':studentno', $studentno, PDO::PARAM_STR);
            $updateStmt->execute();

            $query1 = "UPDATE enrollment_history SET status = :status, remarks = :remarks WHERE class_id = :class_code AND student_id = :studentno";
            $updateStmt1 = $dbh->prepare($query1);
            $updateStmt1->bindParam(':status', $status, PDO::PARAM_STR);
            $updateStmt1->bindParam(':remarks', $remarks, PDO::PARAM_STR);
            $updateStmt1->bindParam(':class_code', $class_code, PDO::PARAM_STR);
            $updateStmt1->bindParam(':studentno', $studentno, PDO::PARAM_STR);
            $updateStmt1->execute();
        }

        $dbh->commit();
        $response['status'] = 'success';
        $response['message'] = 'Updated successfully.';
        echo json_encode($response);
    } catch (Exception $e) {
        $dbh->rollBack();
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong, please try again later.';
        echo json_encode($response);
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
