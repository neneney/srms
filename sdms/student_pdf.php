<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Enable Dompdf options
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

ob_start();
session_start();
error_reporting(0);
include('includes/dbconnection.php');

function imgToBase64($path)
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

$bjmpLogoBase64 = imgToBase64(__DIR__ . '/company/bjmp_logo.png');
$alsLogoBase64 = imgToBase64(__DIR__ . '/company/als_logo.png');

$eid2 = $_GET['class_id'];
$ret2 = mysqli_query($con, "SELECT * FROM students WHERE id='$eid2'");
$row = mysqli_fetch_array($ret2);

// Fetch parent/guardian information
$parentId = $row['parent_id'];
$parentQuery = mysqli_query($con, "SELECT * FROM parent WHERE id='$parentId'");
$parentRow = mysqli_fetch_array($parentQuery);

// Fetch address information
$provCode = $row['province'];
$cityCode = $row['city'];
$brgyCode = $row['barangay'];

$provQuery = mysqli_query($con, "SELECT * FROM refprovince WHERE provCode='$provCode'");
$provRow = mysqli_fetch_array($provQuery);

// Fetch graduated programs/classes
$studentno = $row['studentno'];
$graduatedProgramsQuery = mysqli_query($con, "SELECT DISTINCT c.`educ-level`, c.title, c.type, c.strand, ce.graduated_at, ce.remarks 
                                              FROM enrollment_history ce 
                                              JOIN classes c ON ce.class_id = c.code 
                                              WHERE ce.student_id='$studentno' AND ce.status='graduated' AND ce.remarks='Completed'");
$graduatedPrograms = mysqli_fetch_all($graduatedProgramsQuery, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .logo {
            width: 100px;
            height: auto;
        }

        .header-logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-text {
            text-align: center;
            position: absolute;
            top: 0;
            left: 27%;
        }

        table {
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .no-border td {
            border: none;
        }
    </style>
</head>

<body>
    <div class="header-logo">
        <img src="<?php echo $bjmpLogoBase64 ?>" alt="BJMP Logo" class="logo">
        <div class="header-text">
            <p style="margin: 0;">Republic of the Philippines</p>
            <h3 style="margin: 0;">Bureau of Jail Management and Penology</h3>
            <p style="margin: 0;">Region IXA - Calabarzon</p>
            <p style="margin: 0;">General Trias, Cavite</p>
        </div>
        <img style="position: fixed; top: 0; right:0" src="<?php echo $alsLogoBase64 ?>" alt="ALS Logo" class="logo">
    </div>

    <h4 style="margin-bottom: 10px; font-weight: 600;">Student Information</h4>
    <hr>
    <table>
        <tr>
            <th>Student ID</th>
            <td><?php echo htmlentities($row['studentno']); ?></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?php echo htmlentities($row['last-name']); ?></td>
        </tr>
        <tr>
            <th>First Name</th>
            <td><?php echo htmlentities($row['first-name']); ?></td>
        </tr>
        <tr>
            <th>Middle Name</th>
            <td><?php echo htmlentities($row['middle-name']); ?></td>
        </tr>
        <?php if (!empty($row['suffix'])) { ?>
            <tr>
                <th>Suffix</th>
                <td><?php echo htmlentities($row['suffix']); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th>Sex</th>
            <td><?php echo htmlentities($row['gender']); ?></td>
        </tr>
        <tr>
            <th>Age</th>
            <td><?php echo htmlentities($row['age']); ?></td>
        </tr>
        <tr>
            <th>Last School Attended</th>
            <td><?php echo htmlentities($row['last_school']); ?></td>
        </tr>
    </table>

    <h4 style="margin-bottom: 10px; font-weight: 600;">Parent/Guardian Information</h4>
    <hr>
    <table>
        <tr>
            <th>Last Name</th>
            <td><?php echo htmlentities($parentRow['last_name']); ?></td>
        </tr>
        <tr>
            <th>First Name</th>
            <td><?php echo htmlentities($parentRow['first_name']); ?></td>
        </tr>
        <tr>
            <th>Middle Name</th>
            <td><?php echo htmlentities($parentRow['middle_name']); ?></td>
        </tr>
        <?php if (!empty($parentRow['suffix'])) { ?>
            <tr>
                <th>Suffix</th>
                <td><?php echo htmlentities($parentRow['suffix']); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th>Relationship</th>
            <td><?php echo htmlentities($parentRow['relationship']); ?></td>
        </tr>
        <tr>
            <th>Occupation</th>
            <td><?php echo htmlentities($parentRow['occupation']); ?></td>
        </tr>
        <tr>
            <th>Phone No.</th>
            <td>0<?php echo htmlentities($parentRow['contact-no']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlentities($parentRow['email']); ?></td>
        </tr>
    </table>

    <h4 style="margin-bottom: 10px; font-weight: 600;">Address</h4>
    <hr>
    <table style="margin-bottom: 160px;">
        <tr>
            <th>Province</th>
            <td><?php echo htmlentities($provRow['provDesc']); ?></td>
        </tr>
        <tr>
            <th>City</th>
            <td>
                <?php
                $cityQuery = mysqli_query($con, "SELECT * FROM refcitymun WHERE citymunCode='$cityCode'");
                $cityRow = mysqli_fetch_array($cityQuery);
                echo htmlentities($cityRow['citymunDesc']);
                ?>
            </td>
        </tr>
        <tr>
            <th>Barangay</th>
            <td>
                <?php
                $brgyQuery = mysqli_query($con, "SELECT * FROM refbrgy WHERE brgyCode='$brgyCode'");
                $brgyRow = mysqli_fetch_array($brgyQuery);
                echo htmlentities($brgyRow['brgyDesc']);
                ?>
            </td>
        </tr>
        <tr>
            <th>Village & House No.</th>
            <td><?php echo htmlentities($row['village-house-no']); ?></td>
        </tr>
    </table>

    <?php if (!empty($graduatedPrograms)) { ?>
        <h4 style="margin-bottom: 10px; font-weight: 600;">Completed Programs</h4>
        <hr>
        <table>
            <tr>
                <th>Program/Class</th>
                <th>Graduation Date</th>
            </tr>
            <?php foreach ($graduatedPrograms as $programRow) { ?>
                <tr>
                    <td>
                        <?php
                        if (!empty($programRow['title'])) {
                            echo htmlentities($programRow['educ-level'] . ' (' . $programRow['title'] . ')');
                        } elseif (!empty($programRow['strand'])) {
                            echo htmlentities($programRow['educ-level'] . ' (' . $programRow['strand'] . ')');
                        } elseif (!empty($programRow['type'])) {
                            echo htmlentities($programRow['educ-level'] . ' (' . $programRow['type'] . ')');
                        } else {
                            echo htmlentities($programRow['educ-level']);
                        }
                        ?>
                    </td>
                    <td><?php echo htmlentities($programRow['graduated_at']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</body>

</html>

<?php

$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("student_info.pdf", array("Attachment" => false));
?>