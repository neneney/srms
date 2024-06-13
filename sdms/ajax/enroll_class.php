<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $suffix = $_POST['suffix'];
    $age = $_POST['age'];
    $studentno = $_POST['studentno'];
    $sex = $_POST['sex'];
    $parent_lastname = $_POST['parent-lastname'];
    $parent_firstname = $_POST['parent-firstname'];
    $parent_middlename = $_POST['parent-middlename'];
    $parent_suffix = $_POST['parent-suffix'];
    $relation = $_POST['relation'];
    $occupation = $_POST['occupation'];
    $email = $_POST['email'];
    $semail = $_POST['semail'];
    $sphone = $_POST['sphone'];
    $last_school = $_POST['last_school'];
    $phone = $_POST['phone'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $village = $_POST['village'];
    $strand = $_POST['strand'];
    $photo = $_FILES["photo"]["name"];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "studentimages/" . $_FILES["photo"]["name"]);

    $class = $_POST['class'];

    $check_sql = "SELECT COUNT(*) AS count FROM students WHERE `last-name` = :lastname AND `first-name` = :firstname AND `middle-name` = :middlename AND suffix = :suffix";
    $check_query = $dbh->prepare($check_sql);
    $check_query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $check_query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $check_query->bindParam(':middlename', $middlename, PDO::PARAM_STR);
    $check_query->bindParam(':suffix', $suffix, PDO::PARAM_STR);
    $check_query->execute();
    $count = $check_query->fetch(PDO::FETCH_ASSOC)['count'];

    if ($count > 0) {
        // Student with the same name already exists, show error message or take appropriate action
        $response['status'] = 'error';
        $response['message'] = 'Student with the same name already exists.';
    } else {
        try {
            $dbh->beginTransaction();

            $sql_parent = "INSERT INTO parent (last_name, first_name, middle_name, suffix, relationship, occupation, email, `contact-no`) VALUES (:parent_lastname, :parent_firstname, :parent_middlename, :parent_suffix, :relation, :occupation, :email, :phone)";
            $query_parent = $dbh->prepare($sql_parent);
            $query_parent->bindParam(':parent_lastname', $parent_lastname, PDO::PARAM_STR);
            $query_parent->bindParam(':parent_firstname', $parent_firstname, PDO::PARAM_STR);
            $query_parent->bindParam(':parent_middlename', $parent_middlename, PDO::PARAM_STR);
            $query_parent->bindParam(':parent_suffix', $parent_suffix, PDO::PARAM_STR);
            $query_parent->bindParam(':relation', $relation, PDO::PARAM_STR);
            $query_parent->bindParam(':occupation', $occupation, PDO::PARAM_STR);
            $query_parent->bindParam(':email', $email, PDO::PARAM_STR);
            $query_parent->bindParam(':phone', $phone, PDO::PARAM_STR);
            $query_parent->execute();

            $parent_id = $dbh->lastInsertId();

            $sql_student = "INSERT INTO students (studentno, `last-name`, `first-name`, `middle-name`, suffix, age, gender, email, phone, parent_id, province, city, barangay, `village-house-no`, studentImage, last_school) 
            VALUES (:studentno, :lastname, :firstname, :middlename, :suffix, :age, :sex, :semail, :sphone, :parent_id, :province, :city, :barangay, :village, :photo, :last_school)";
            $query_student = $dbh->prepare($sql_student);
            $query_student->bindParam(':studentno', $studentno, PDO::PARAM_STR);
            $query_student->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $query_student->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $query_student->bindParam(':middlename', $middlename, PDO::PARAM_STR);
            $query_student->bindParam(':suffix', $suffix, PDO::PARAM_STR);
            $query_student->bindParam(':age', $age, PDO::PARAM_INT);
            $query_student->bindParam(':sex', $sex, PDO::PARAM_STR);
            $query_student->bindParam(':semail', $semail, PDO::PARAM_STR);
            $query_student->bindParam(':sphone', $sphone, PDO::PARAM_STR);
            $query_student->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
            $query_student->bindParam(':province', $province, PDO::PARAM_STR);
            $query_student->bindParam(':city', $city, PDO::PARAM_STR);
            $query_student->bindParam(':barangay', $barangay, PDO::PARAM_STR);
            $query_student->bindParam(':village', $village, PDO::PARAM_STR);
            $query_student->bindParam(':photo', $photo, PDO::PARAM_STR);
            $query_student->bindParam(':last_school', $last_school, PDO::PARAM_STR);
            $query_student->execute();

            $status = "active";
            $remarks = "none";

            if (!empty($class)) {
                $class_sql = "INSERT INTO class_enrollment (student_id, class_id, status, remarks) VALUES (:studentno, :class_id, :status, :remarks)";
                $query_class = $dbh->prepare($class_sql);
                $query_class->bindParam(':studentno', $studentno, PDO::PARAM_STR);
                $query_class->bindParam(':class_id', $class, PDO::PARAM_INT);
                $query_class->bindParam(':status', $status, PDO::PARAM_STR);
                $query_class->bindParam(':remarks', $remarks, PDO::PARAM_STR);
                $query_class->execute();
            }

            if (!empty($class)) {
                $enrollment_sql = "INSERT INTO enrollment_history (student_id, class_id, status, remarks) VALUES (:studentno, :class_id, :status, :remarks)";
                $enrollment_class = $dbh->prepare($enrollment_sql);
                $enrollment_class->bindParam(':studentno', $studentno, PDO::PARAM_STR);
                $enrollment_class->bindParam(':class_id', $class, PDO::PARAM_INT);
                $enrollment_class->bindParam(':status', $status, PDO::PARAM_STR);
                $enrollment_class->bindParam(':remarks', $remarks, PDO::PARAM_STR);
                $enrollment_class->execute();
            }
            $dbh->commit();

            $response['status'] = 'success';
            $response['message'] = 'Student added successfully.';
        } catch (Exception $e) {
            $dbh->rollBack();
            $response['status'] = 'error';
            $response['message'] = 'Failed to add student. Please try again.';
        }
    }
    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
