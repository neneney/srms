<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;


// Database connection
include('includes/dbconnection.php');

// Get the class ID from the URL or POST
$classId = $_GET['class_id'];
$statusFilter = $_GET['status_filter'];
$remarksFilter = $_GET['remarks_filter'];

// Fetch class and student information based on the provided filters
$ret2 = $dbh->prepare("SELECT * FROM classes WHERE id = :id");
$ret2->bindParam(':id', $classId, PDO::PARAM_STR);
$ret2->execute();
$class = $ret2->fetch(PDO::FETCH_ASSOC);

// Construct the SQL query for fetching students with remarks filter
$query = "SELECT s.studentno, s.`first-name`, s.`middle-name`, s.`last-name`, s.suffix, s.age, s.gender, ce.status, ce.remarks
          FROM class_enrollment ce
          JOIN students s ON ce.student_id = s.studentno
          WHERE ce.class_id = :class_code";

// Apply filters if provided
if (!empty($statusFilter)) {
    $query .= " AND ce.status = :status_filter";
}
if (!empty($remarksFilter)) {
    $query .= " AND ce.remarks = :remarks_filter";
}

$ret3 = $dbh->prepare($query);
$ret3->bindParam(':class_code', $class['code'], PDO::PARAM_STR);

// Bind filter values if provided
if (!empty($statusFilter)) {
    $ret3->bindParam(':status_filter', $statusFilter, PDO::PARAM_STR);
}
if (!empty($remarksFilter)) {
    $ret3->bindParam(':remarks_filter', $remarksFilter, PDO::PARAM_STR);
}

$ret3->execute();
$students = $ret3->fetchAll(PDO::FETCH_ASSOC);


// Convert images to base64
function imgToBase64($path)
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

$bjmpLogoBase64 = imgToBase64(__DIR__ . '/company/bjmp_logo.png');
$alsLogoBase64 = imgToBase64(__DIR__ . '/company/als_logo.png');

// HTML content
$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid black; padding: 8px; text-align: left; }
    .header-logo { display: flex; align-items: center; justify-content: center; }
    .header-text { text-align: center; position: absolute; top: 0; left:27%;}
    .horizontal { margin-bottom: 20px; display: block; }
    p { margin: 0; }
    .logo { width: 100px; height: auto; }
</style>
<div class="header-logo">
    <img src="' . $bjmpLogoBase64 . '" alt="BJMP Logo" class="logo">
    <div class="header-text">
        <p style="margin: 0;">Republic of the Philippines</p>
        <h3 style="margin: 0;">Bureau of Jail Management and Penology</h3>
        <p style="margin: 0;">Region IXA - Calabarzon</p>
        <p style="margin: 0;">General Trias, Cavite</p>
    </div>  
    <img style="position: fixed; top: 0; right:0" src="' . $alsLogoBase64 . '" alt="ALS Logo" class="logo">
</div>
<hr class="horizontal" style="display: block;">
<h2>Class Information</h2>

    <div>';
$html .= '
    <div style="width: 50%; float: left;">
        <p><strong>Class Code:</strong> ' . htmlentities($class['code']) . '</p>
        <p><strong>Class Name:</strong> ' . htmlentities($class['name']) . '</p>
        <p><strong>Education Level:</strong> ' . htmlentities($class['educ-level']) . '</p>';

if (!empty($class['strand'])) {
    $html .= '<p><strong>Strand:</strong> ' . htmlentities($class['strand']) . '</p>';
}

$html .= '
    </div>
    <div style="width: 50%; float: right;">
        <p><strong>Title:</strong> ' . htmlentities($class['title']) . '</p>';

if (!empty($class['type'])) {
    $html .= '<p><strong>Type:</strong> ' . htmlentities($class['type']) . '</p>';
}

$html .= '
        <p><strong>Teacher:</strong> ' . htmlentities($class['teacher']) . '</p>
    </div>';


$html .= '<h3 style="position: relative; margin-top: 50px"></h3>
<table>
    <thead>
        <tr>
            <th>Student Number</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>';

foreach ($students as $student) {
    $fullName = htmlentities($student['first-name']) . ' ' . htmlentities($student['middle-name']) . ' ' . htmlentities($student['last-name']) . ' ' . htmlentities($student['suffix']);
    $html .= '<tr>
                <td>' . htmlentities($student['studentno']) . '</td>
                <td>' . $fullName . '</td>
                <td>' . htmlentities($student['age']) . '</td>
                <td>' . htmlentities($student['gender']) . '</td>
                <td>' . htmlentities($student['status']) . '</td>
                <td>' . htmlentities($student['remarks']) . '</td>
            </tr>';
}


$html .= '</tbody></table>';

// Instantiate and use the Dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Set the appropriate content-type header for PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="class_information.pdf"');

// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("class_information.pdf", array("Attachment" => 0));
