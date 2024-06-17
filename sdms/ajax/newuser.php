<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $permission = trim($_POST['permission']);
    $sex = trim($_POST['sex']); // Assuming 'sex' is from a dropdown or radio button

    $password1 = $_POST['password'];
    $password2 = $_POST['password1'];

    // Validate password match
    if ($password1 != $password2) {
        $response['status'] = 'error';
        $response['message'] = 'Passwords do not match.';
        echo json_encode($response);
        exit();
    }

    // Hash the password
    $password = md5($password1);

    // Check if username already exists
    $sql_check_username = "SELECT COUNT(*) FROM tblusers WHERE username = :username";
    $query_check_username = $dbh->prepare($sql_check_username);
    $query_check_username->bindParam(':username', $username, PDO::PARAM_STR);
    $query_check_username->execute();
    $count_username = $query_check_username->fetchColumn();

    if ($count_username > 0) {
        $response['status'] = 'error';
        $response['message'] = 'Username already exists. Please choose a different username.';
        echo json_encode($response);
        exit();
    }

    // Insert new user if username is available
    $sql = "INSERT INTO tblusers(name, username, password, status, sex, lastname, permission) 
            VALUES(:name, :username, :password, :status, :sex, :lastname, :permission)";
    $query = $dbh->prepare($sql);
    $status = 1; // Assuming new users are active by default

    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':sex', $sex, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':permission', $permission, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);

    $result = $query->execute();

    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'User registered successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong. Please try again later.';
    }

    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
