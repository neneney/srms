<?php

session_start();
error_reporting(0);
include('includes/dbconnection.php');

?>
<div class="row card-body">
    <?php
    $eid2 = $_POST['edit_id2'];
    $ret2 = mysqli_query($con, "SELECT * FROM programs WHERE ID='$eid2'");



    while ($row = mysqli_fetch_array($ret2)) {
        $ret3 = mysqli_query($con, "SELECT * from students WHERE program = '" . $row['name'] . "'");
    ?>
        <div class="col-md-12">
            <h4>Students Enrolled in <?php echo $row['name']; ?></h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Names</th>
                        <th>Contact No.</th>
                        <th>Age</th>
                        <th>Gender</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($student = mysqli_fetch_array($ret3)) {
                    ?>
                        <tr>
                            <td><?php echo $student['studentno']; ?></td>
                            <td><?php echo $student['studentName']; ?></td>
                            <td>0<?php echo $student['contactno']; ?></td>
                            <td><?php echo $student['age']; ?></td>
                            <td><?php echo $student['gender']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <hr>
    <?php
    } ?>
</div>