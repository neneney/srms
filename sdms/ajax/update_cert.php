<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = $_SESSION['edid'];
    $files = $_FILES['studentCert'];

    // Allowed file types
    $allowed_file_types = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];

    // Ensure the upload directory exists
    $target_dir = "student_cert/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $response = [];
    $response['status'] = 'success';
    $response['message'] = 'Updated successfully.';
    $response['errors'] = [];

    // Loop through each file and handle the upload
    for ($i = 0; $i < count($files['name']); $i++) {
        $studentCert = $files['name'][$i];
        $file_ext = strtolower(pathinfo($studentCert, PATHINFO_EXTENSION));

        // Validate file type
        if (in_array($file_ext, $allowed_file_types)) {
            $target_file = $target_dir . basename($studentCert);

            // Move the uploaded file
            if (move_uploaded_file($files['tmp_name'][$i], $target_file)) {
                // Insert the record into the database
                $sql = "INSERT INTO student_cert (image, student_id) VALUES (:studentCert, :sid)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':studentCert', $studentCert, PDO::PARAM_STR);
                $query->bindParam(':sid', $sid, PDO::PARAM_INT);

                if (!$query->execute()) {
                    $response['status'] = 'error';
                    $response['message'] = 'Some files were not uploaded successfully.';
                    $response['errors'][] = 'Failed to insert ' . $studentCert . ' into the database.';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Some files were not uploaded successfully.';
                $response['errors'][] = 'Failed to move ' . $studentCert . ' to target directory.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid file type detected.';
            $response['errors'][] = 'File type ' . $file_ext . ' not allowed for ' . $studentCert . '.';
        }
    }

    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
