<?php
session_start();
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the class ID from the POST request
    $class_id = $_POST['edit_id3'];
    $student_ids = $_POST['existing_students'];

    // Check if student IDs are provided
    if (empty($student_ids)) {
        echo json_encode(['status' => 'error', 'message' => 'No students selected for enrollment.']);
        exit();
    }

    // Retrieve the class code using the class ID
    $class_code_query = "SELECT code FROM classes WHERE id = ?";
    $stmt = $con->prepare($class_code_query);
    $stmt->bind_param('i', $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Class not found.']);
        exit();
    }

    $class = $result->fetch_assoc();
    $class_code = $class['code'];

    // Enroll each student in the class using the class code
    foreach ($student_ids as $student_id) {
        // Check if the student is already enrolled in the class
        $check_query = "SELECT * FROM class_enrollment WHERE student_id = ?";
        $stmt_check = $con->prepare($check_query);
        $stmt_check->bind_param('i', $student_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows == 0) {
            // If the student is not already enrolled, insert the record
            $insert_query = "INSERT INTO class_enrollment (class_id, student_id,status, remarks) VALUES (?, ?,'active'. 'Incomplete')";
            $stmt_insert = $con->prepare($insert_query);
            $stmt_insert->bind_param('ii', $class_code, $student_id);
            $stmt_insert->execute();
            $stmt_insert->close();
        } else {
            // If the student is already enrolled, update the record
            $update_query = "UPDATE class_enrollment SET class_id = ?, student_id = ?, status = 'active', remarks = 'Incomplete' WHERE student_id = ?";
            $stmt_update = $con->prepare($update_query);
            $stmt_update->bind_param('iii', $class_code, $student_id, $student_id);
            $stmt_update->execute();
            $stmt_update->close();

            $log_query = "INSERT INTO enrollment_history (student_id, class_id, remarks) VALUES (?, ?, 'Incomplete')";
            $stmt_log = $con->prepare($log_query);
            $stmt_log->bind_param('ii', $student_id, $class_code);
            $stmt_log->execute();
            $stmt_log->close();
        }
        $stmt_check->close();
    }

    echo json_encode(['status' => 'success', 'message' => 'Selected students enrolled successfully.']);
}
