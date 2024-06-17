<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminid = $_POST['Id'];
    $cpassword = md5($_POST['password']);
    $newpassword = md5($_POST['password1']);
    $confirmpass = md5($_POST['password2']);
    $sql = "SELECT id FROM tblusers WHERE id=:adminid and Password=:cpassword";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminid', $adminid, PDO::PARAM_STR);
    $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        if ($newpassword === $confirmpass) {
            $con = "update tblusers set Password=:newpassword where id=:adminid";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':adminid', $adminid, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $result = $chngpwd1->execute();

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
            $response['message'] = 'Passwords does not match';
            echo json_encode($response);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Current Password is Incorrect';
        echo json_encode($response);
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
