<?php

session_start();
error_reporting(0);
include('includes/dbconnection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate of Enrollment</title>
  <!-- Bootstrap CSS -->

</head>

<body>
  <div class="container">
    <?php
    $eid2 = $_POST['edit_id2'];
    $ret2 = mysqli_query($con, "SELECT * FROM students WHERE id='$eid2'");
    while ($row = mysqli_fetch_array($ret2)) {
    ?>
      <div class="row">
        <div class="col-md-4">
          <img src="studentimages/<?php echo htmlentities($row['studentImage']); ?>" width="100" height="100">
        </div>
        <div class="col-md-8">
          <table>
            <tr>
              <th>Student Number</th>
              <td>&nbsp;<?php echo $row['studentno']; ?></td>
            </tr>
            <tr>
              <th>Names</th>
              <td><?php echo $row['studentName']; ?></td>
            </tr>
            <tr>
              <th>Contact No.</th>
              <td>0<?php echo $row['contactno']; ?></td>
            </tr>
            <tr>
              <th>Program</th>
              <td><?php echo $row['program']; ?></td>
            </tr>
            <tr>
              <th>Age</th>
              <td><?php echo $row['age']; ?></td>
            </tr>
            <tr>
              <th>Gender</th>
              <td><?php echo $row['gender']; ?></td>
            </tr>
            <tr>
              <th>Parent Name</th>
              <td><?php echo $row['parentName']; ?></td>
            </tr>
            <tr>
              <th>Relationship</th>
              <td><?php echo $row['relation']; ?></td>
            </tr>
            <tr>
              <th>Occupation</th>
              <td><?php echo $row['occupation']; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?php echo $row['email']; ?></td>
            </tr>
            <tr>
              <th>Address</th>
              <td><?php echo $row['village-house-no'] . ', ' . $row['barangay'] . ', ' . $row['city'] . ', ' . $row['province']; ?></td>
            </tr>
            <!-- Add more rows for other details -->
          </table>
        </div>
      </div>
      <hr>

      <!-- Button to Open Modal -->


      <!-- Modal -->
      <div id="certificateModal" style="visibility: hidden;">
        <?php @include("print-certificate.php") ?>
      </div>

    <?php
    } ?>
  </div>


</body>

</html>