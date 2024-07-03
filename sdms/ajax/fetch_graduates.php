<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Fetch filters from the request
        $educ_level = isset($_POST['educ_level']) ? $_POST['educ_level'] : '';
        $date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
        $date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';

        // Build the SQL query with filters
        $query = "
            SELECT DISTINCT s.studentno, s.`first-name` AS first_name, s.`last-name` AS last_name, 
                            c.`educ-level` AS educ_level, c.title, c.type, c.strand, ce.graduated_at
            FROM enrollment_history ce 
            JOIN students s ON ce.student_id = s.studentno 
            JOIN classes c ON ce.class_id = c.code 
            WHERE ce.status = 'graduated'
        ";

        $conditions = [];
        $params = [];

        if (!empty($educ_level)) {
            $conditions[] = "c.`educ-level` LIKE :educ_level";
            $params[':educ_level'] = '%' . $educ_level . '%';
        }

        if (!empty($date_from)) {
            $conditions[] = "ce.graduated_at >= :date_from";
            $params[':date_from'] = $date_from;
        }

        if (!empty($date_to)) {
            $conditions[] = "ce.graduated_at <= :date_to";
            $params[':date_to'] = $date_to;
        }

        if (!empty($conditions)) {
            $query .= ' AND ' . implode(' AND ', $conditions);
        }

        $stmt = $dbh->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $graduated_students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($graduated_students)) {
            $response['status'] = 'no_results';
            $response['message'] = 'No graduates found for the selected filters.';
        } else {
            $response['status'] = 'success';
            $response['data'] = $graduated_students;
        }

        echo json_encode($response);
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong, please try again later.';
        $response['error'] = $e->getMessage(); // Include the actual error message
        echo json_encode($response);
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
