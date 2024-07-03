<?php
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $edit_id3 = $_POST['edit_id3'];
    $class_code_query = "SELECT code FROM classes WHERE id = ?";
    $stmt = $con->prepare($class_code_query);
    $stmt->bind_param('i', $edit_id3);
    $stmt->execute();
    $result = $stmt->get_result();


    $class = $result->fetch_assoc();
    $class_code = $class['code'];
    // Fetch the list of existing students not already enrolled in the class
    $query = "
        SELECT * FROM students 
        WHERE studentno NOT IN (
            SELECT student_id FROM class_enrollment WHERE class_id = ?
        )
        ORDER BY postingDate DESC
    ";

    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $class_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table id="studentsTable" class="table table-bordered table-hover">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="text-align: center;"><input type="checkbox" id="selectAll"> Select All</th>';
        echo '<th style="text-align: center;">Student Number</th>';
        echo '<th style="text-align: center;">Full Name</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            $studentNumber = htmlentities($row['studentno']);
            $fullName = htmlentities($row['first-name']) . ' ' .
                htmlentities($row['middle-name']) . ' ' .
                htmlentities($row['last-name']) . ' ' .
                htmlentities($row['suffix']);

            echo '<tr>';
            echo '<td style="text-align: center;"><input class="form-check-input" type="checkbox" name="existing_students[]" value="' . $studentNumber . '"></td>';
            echo '<td style="text-align: center;">' . $studentNumber . '</td>';
            echo '<td style="text-align: center;">' . $fullName . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No existing students found.';
    }
}
