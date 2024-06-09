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
            <th>First Name</th>
            <td><?php echo htmlentities($row['first-name']); ?></td>
            <th>Middle Name</th>
            <td><?php echo htmlentities($row['middle-name']); ?></td>
            <?php if (!empty($row['suffix'])) { ?>
                <th>Suffix</th>
                <td><?php echo htmlentities($row['suffix']); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <th>Sex</th>
            <td><?php echo htmlentities($row['gender']); ?></td>
            <th>Age</th>
            <td><?php echo htmlentities($row['age']); ?></td>
            <th>Last School Attended</th>
            <td colspan="3"><?php echo htmlentities($row['last_school']); ?></td>
        </tr>
    </table>

    <h4 style="margin-bottom: 10px; font-weight: 600;">Parent/Guardian Information</h4>
    <hr>
    <table>
        <tr>
            <th>Last Name</th>
            <td><?php echo htmlentities($parentRow['last_name']); ?></td>
            <th>First Name</th>
            <td><?php echo htmlentities($parentRow['first_name']); ?></td>
            <th>Middle Name</th>
            <td><?php echo htmlentities($parentRow['middle_name']); ?></td>
            <?php if (!empty($parentRow['suffix'])) { ?>
                <th>Suffix</th>
                <td><?php echo htmlentities($parentRow['suffix']); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <th>Relationship</th>
            <td><?php echo htmlentities($parentRow['relationship']); ?></td>
            <th>Occupation</th>
            <td><?php echo htmlentities($parentRow['occupation']); ?></td>
            <th>Phone No.</th>
            <td colspan="3">0<?php echo htmlentities($parentRow['contact-no']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td colspan="7"><?php echo htmlentities($parentRow['email']); ?></td>
        </tr>
    </table>

    <h4 style="margin-bottom: 10px; font-weight: 600;">Address</h4>
    <hr>
    <table>
        <tr>
            <th>Province</th>
            <td><?php echo htmlentities($provRow['provDesc']); ?></td>
            <th>City</th>
            <td>
                <?php
                $allCitiesQuery = $dbh->query("SELECT * FROM refcitymun WHERE provCode = '{$provCode}'");
                while ($cityRow = $allCitiesQuery->fetch(PDO::FETCH_ASSOC)) {
                    if ($cityRow['citymunCode'] == $cityCode) {
                        echo htmlentities($cityRow['citymunDesc']);
                        break;
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>Barangay</th>
            <td>
                <?php
                $allBarangaysQuery = $dbh->query("SELECT * FROM refbrgy WHERE citymunCode = '{$cityCode}'");
                while ($brgyRow = $allBarangaysQuery->fetch(PDO::FETCH_ASSOC)) {
                    if ($brgyRow['brgyCode'] == $brgyCode) {
                        echo htmlentities($brgyRow['brgyDesc']);
                        break;
                    }
                }
                ?>
            </td>
            <th>Village & House No.</th>
            <td colspan="5"><?php echo htmlentities($row['village-house-no']); ?></td>
        </tr>
    </table>

</body>

</html>

<?php

$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("student_info.pdf", array("Attachment" => false));
?>