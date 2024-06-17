<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = $_POST['rowId'];
    $permission = $_POST['permission'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $sex = $_POST['sex'];

    $password = $_POST['password'];
    $password1 = $_POST['password1'];

    if (!empty($password)) {
        if ($password !== $password1) {
            $response['status'] = 'error';
            $response['message'] = 'Passwords do not match.';
            echo json_encode($response);
            exit();
        }

        // Hash the new password
        $hashed_password = md5($password1);

        // Update the user profile with the new password
        $sql = "UPDATE tblusers SET name=:name, username=:username, lastname=:lastname, permission=:permission, password=:password, sex=:sex WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    } else {
        // Update the user profile without changing the password
        $sql = "UPDATE tblusers SET name=:name, username=:username, lastname=:lastname, permission=:permission, sex=:sex WHERE id=:eid";
        $query = $dbh->prepare($sql);
    }

    // Bind parameters and execute the query
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':permission', $permission, PDO::PARAM_STR);
    $query->bindParam(':sex', $sex, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $result = $query->execute();

    if ($result) {
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
