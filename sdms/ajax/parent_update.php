<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = $_POST['parentID'];
    $p_first_name = $_POST['p_first_name'];
    $p_last_name = $_POST['p_last_name'];
    $p_middle_name = $_POST['p_middle_name'];
    $p_suffix = $_POST['p_suffix'];
    $relationship = $_POST['relationship'];
    $occupation = $_POST['occupation'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $sql = "UPDATE parent SET last_name = :last_name, first_name = :first_name, middle_name = :middle_name, suffix = :suffix, relationship = :relationship, occupation = :occupation, `contact-no` = :phone, email = :email WHERE id = :pid";
    $query = $dbh->prepare($sql);

    $query->bindParam(':last_name', $p_last_name, PDO::PARAM_STR);
    $query->bindParam(':first_name', $p_first_name, PDO::PARAM_STR);
    $query->bindParam(':middle_name', $p_middle_name, PDO::PARAM_STR);
    $query->bindParam(':suffix', $p_suffix, PDO::PARAM_STR);
    $query->bindParam(':relationship', $relationship, PDO::PARAM_STR);
    $query->bindParam(':occupation', $occupation, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':pid', $pid, PDO::PARAM_INT);
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
