<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $gradeLevel = $_POST['gradeLevel'];

    $sql = "SELECT * FROM classes WHERE `educ-level` = :gradeLevel";
    $query = $dbh->prepare($sql);
    $query->bindParam(':gradeLevel', $gradeLevel, PDO::PARAM_STR);
    $query->execute();
    $classes = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($classes);
}
