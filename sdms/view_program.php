<?php

session_start();
error_reporting(0);
include('includes/dbconnection.php');

?>
<style>
    .header-logo {
        display: none;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .header-text {
        text-align: center;
    }

    .horizontal {
        margin-top: 40px;
        display: none;
    }

    @media print {
        .header-logo {
            display: flex;
        }

        h4 {
            margin-top: 40px;
        }

        .horizontal {
            display: block;

        }

        * {
            font-size: 24px;
        }

        table {
            text-align: center;
        }

        .modal-footer {
            display: none !important;
        }
    }
</style>
<div class="row card-body">
    <?php
    $eid2 = $_POST['edit_id2'];
    $ret2 = mysqli_query($con, "SELECT * FROM programs WHERE ID='$eid2'");



    while ($row = mysqli_fetch_array($ret2)) {
        $ret3 = mysqli_query($con, "SELECT s.studentno, s.`first-name`, s.`middle-name`, s.`last-name`, s.suffix, s.age, s.gender
                                    FROM course_enrollment ce
                                    JOIN students s ON ce.student_id = s.studentno
                                    WHERE ce.course_code = '" . $row['course-code'] . "'");
    ?>

        <div class="col-md-12">
            <div class="header-logo">
                <img src="company/bjmp_logo.png" alt="Logo" style="width: 100px; height: auto; margin-right: 20px;">
                <div class="header-text">
                    <p style="margin: 0;">Republic of the Philippines</p>
                    <h3 style="margin: 0;">Bureau of Jail Management and Penology</h3>
                    <p style="margin: 0;">Region IXA - Calabarzon</p>
                    <p style="margin: 0;">General Trias, Cavite</p>
                </div>
                <img src="company/als_logo.png" alt="Logo" style="width: 100px; height: auto; margin-left: 20px; margin-bottom: 20px;">
            </div>
            <hr class="horizontal">
            <p style="margin: 0;">Course Code: <?php echo $row['course-code']; ?></p>
            <p style="margin: 0;">Course Name: <?php echo $row['name']; ?></p>
            <p style="margin: 0;">Course Type: <?php echo $row['program_type']; ?></p>
            <p style="margin: 0; margin-bottom: 10px; margin-top:10px">Students Enrolled: </p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($student = mysqli_fetch_array($ret3)) {
                        // Fetch and concatenate the student's name parts
                        $fullName = htmlentities($student['first-name']) . ' ' .
                            htmlentities($student['middle-name']) . ' ' .
                            htmlentities($student['last-name']) . ' ' .
                            htmlentities($student['suffix']);
                    ?>
                        <tr>
                            <td><?php echo $student['studentno']; ?></td>
                            <td><?php echo $fullName; ?></td>
                            <td><?php echo $student['age']; ?></td>
                            <td><?php echo $student['gender']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="modal-footer text-right" style="float: right;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="printTable()">Print</button>
            </div>
        </div>
    <?php } ?>
</div>