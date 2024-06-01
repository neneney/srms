<?php
session_start();
include('includes/dbconnection.php');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM tblusers WHERE username=:username AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result) {
        if ($result->status == "1") {
            // Set session variables
            $_SESSION['sid'] = $result->id;
            $_SESSION['name'] = $result->name;
            $_SESSION['lastname'] = $result->lastname;
            $_SESSION['permission'] = $result->permission;
            $_SESSION['login'] = $username;

            $userId = $result->id;

            // Log user login details
            $uip = $_SERVER['REMOTE_ADDR'];
            $status = 1;
            $sql = "INSERT INTO userlog (userID, userip, status, username, name, lastname) VALUES (:userId, :uip, :status, :username, :name, :lastname)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':name', $result->name, PDO::PARAM_STR);
            $query->bindParam(':lastname', $result->lastname, PDO::PARAM_STR);
            $query->bindParam(':userId', $result->id, PDO::PARAM_STR);
            $query->bindParam(':uip', $uip, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_INT);
            $query->execute();

            echo json_encode(['status' => 'success', 'message' => 'Login successful!']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Your account was blocked. Please approach Admin']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Username or Password is incorrect']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}
