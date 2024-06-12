<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['remove_cert'])) {
  $cert_id = $_POST['cert_id'];
  $deleteQuery = $dbh->prepare("DELETE FROM student_cert WHERE id = :cert_id");
  $deleteQuery->bindParam(':cert_id', $cert_id, PDO::PARAM_INT);
  $deleteQuery->execute();
}

$eid2 = $_POST['edit_id2'];
$ret2 = mysqli_query($con, "SELECT * FROM students WHERE id='$eid2'");
while ($row = mysqli_fetch_array($ret2)) {
?>
  <button style="float: right; margin-bottom: 20px" type="button" class="btn btn-info" data-toggle="modal" data-target="#certificateModal">View Certificate</button>
  <button style="float: right; margin-bottom: 20px; margin-right: 10px;" type="button" class="btn btn-info" data-toggle="modal" data-target="#enrollmentModal">View Enrollment History</button>
  <?php
  $enrollment_sql = "SELECT c.name, c.title, c.type, c.`educ-level`, c.strand, c.teacher, c.`start-date`, c.`end-date`, c.`start_time`, c.`end_time`, c.`code`
                               FROM class_enrollment ce 
                               JOIN classes c ON ce.class_id = c.code 
                               WHERE ce.student_id = :student_id AND ce.status = 'active'";
  $enrollment_query = $dbh->prepare($enrollment_sql);
  $enrollment_query->bindParam(':student_id', $row['studentno'], PDO::PARAM_INT);
  $enrollment_query->execute();
  $enrollment = $enrollment_query->fetch(PDO::FETCH_ASSOC);
  ?>
  <table class="table table-bordered">
    <tr>
      <td colspan="2" class="text-center">
        <img class="img-circle" src="studentimages/<?php echo htmlentities($row['studentImage']); ?>" width="150" height="150" class="user-image" alt="User profile picture" onerror="this.onerror=null; this.src='studentimages/placeholder.jpg';">
      </td>
    </tr>
    <tr>
      <td><strong>Student ID:</strong></td>
      <td><?php echo htmlentities($row['studentno']); ?></td>
    </tr>

    <tr>
      <td><strong>Last Name:</strong></td>
      <td><?php echo htmlentities($row['last-name']); ?></td>
    </tr>
    <tr>
      <td><strong>First Name:</strong></td>
      <td><?php echo htmlentities($row['first-name']); ?></td>
    </tr>
    <tr>
      <td><strong>Middle Name:</strong></td>
      <td><?php echo htmlentities($row['middle-name']); ?></td>
    </tr>
    <?php if (!empty($row['suffix'])) { ?>
      <tr>
        <td><strong>Suffix:</strong></td>
        <td><?php echo htmlentities($row['suffix']); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td><strong>Sex:</strong></td>
      <td><?php echo htmlentities($row['gender']); ?></td>
    </tr>
    <tr>
      <td><strong>Age:</strong></td>
      <td><?php echo htmlentities($row['age']); ?></td>
    </tr>
    <tr>
      <td><strong>Last School Attended:</strong></td>
      <td><?php echo htmlentities($row['last_school']); ?></td>
    </tr>
  </table>
  </div>
  <h4 style="margin-bottom: 10px; font-weight: 600;">Class Enrollment Details</h4>
  <hr>
  <table class="table table-bordered">
    <?php if ($enrollment) { ?>
      <tr>
        <td><strong>Class Code:</strong></td>
        <td><?php echo htmlentities($enrollment['code']); ?></td>

        <td><strong>Class Name:</strong></td>
        <td><?php echo htmlentities($enrollment['name']); ?></td>
      </tr>
      <tr>
        <td><strong>Educational level:</strong></td>
        <td><?php echo htmlentities($enrollment['educ-level']); ?></td>

        <?php if (!empty($enrollment['strand'])) { ?>
          <td><strong>Class Title:</strong></td>
          <td><?php echo htmlentities($enrollment['strand']); ?></td>
      </tr>
    <?php } ?>
    <?php if (!empty($enrollment['title'])) { ?>

      <td><strong>Class Title:</strong></td>
      <td><?php echo htmlentities($enrollment['title']); ?></td>
      </tr>
    <?php } ?>
    <?php if (!empty($enrollment['type'])) { ?>
      <td><strong>Class Title:</strong></td>
      <td><?php echo htmlentities($enrollment['type']); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td><strong>Class start date:</strong></td>
      <td><?php echo htmlentities($enrollment['start-date']); ?></td>
      <td><strong>Class end date:</strong></td>
      <td><?php echo htmlentities($enrollment['end-date']); ?></td>
    </tr>
    <tr>
      <td><strong>Class start time:</strong></td>
      <td><?php echo htmlentities($enrollment['start_time']); ?></td>
      <td><strong>Class end time:</strong></td>
      <td><?php echo htmlentities($enrollment['end_time']); ?></td>
    </tr>
  <?php } else { ?>
    <tr>
      <td colspan="2"><strong>Student is not enrolled in any class.</strong></td>
    </tr>
  <?php } ?>
  </table>
  <h4 style="margin-bottom: 10px; font-weight: 600;">Parent/Guardian Information</h4>
  <hr>

  <?php
  $parentID = $row['parent_id'];
  $_SESSION['parentID'] = $parentID;
  $sql = "SELECT * FROM parent WHERE id = :parentID";
  $parentQuery = $dbh->prepare($sql);
  $parentQuery->bindParam(':parentID', $parentID, PDO::PARAM_INT);
  $parentQuery->execute();
  $parentRow = $parentQuery->fetch(PDO::FETCH_ASSOC);
  ?>
  <table class="table table-bordered">
    <tr>
      <td><strong>Last Name:</strong></td>
      <td><?php echo htmlentities($parentRow['last_name']); ?></td>
    </tr>
    <tr>
      <td><strong>First Name:</strong></td>
      <td><?php echo htmlentities($parentRow['first_name']); ?></td>
    </tr>
    <tr>
      <td><strong>Middle Name:</strong></td>
      <td><?php echo htmlentities($parentRow['middle_name']); ?></td>
    </tr>
    <?php if (!empty($parentRow['suffix'])) { ?>
      <tr>
        <td><strong>Suffix:</strong></td>
        <td><?php echo htmlentities($parentRow['suffix']); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td><strong>Relationship:</strong></td>
      <td><?php echo htmlentities($parentRow['relationship']); ?></td>
    </tr>
    <tr>
      <td><strong>Occupation:</strong></td>
      <td><?php echo htmlentities($parentRow['occupation']); ?></td>
    </tr>
    <tr>
      <td><strong>Phone No.:</strong></td>
      <td>0<?php echo htmlentities($parentRow['contact-no']); ?></td>
    </tr>
    <tr>
      <td><strong>Email:</strong></td>
      <td><?php echo htmlentities($parentRow['email']); ?></td>
    </tr>
  </table>
  </div>
  <h4 style="margin-bottom: 10px; font-weight: 600;">Address</h4>
  <hr>

  <?php
  $provCode = $row['province'];
  $allProvincesQuery = $dbh->query("SELECT * FROM refprovince WHERE provCode =  $provCode");
  $provRow = $allProvincesQuery->fetch(PDO::FETCH_ASSOC);
  $cityCode = $row['city'];
  $brgyCode = $row['barangay'];
  ?>
  <table class="table table-bordered">
    <tr>
      <td><strong>Province:</strong></td>
      <td><?php echo htmlentities($provRow['provDesc']); ?></td>
    </tr>
    <tr>
      <td><strong>City:</strong></td>
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
      <td><strong>Barangay:</strong></td>
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
    </tr>
    <tr>
      <td><strong>Village & House No.:</strong></td>
      <td><?php echo htmlentities($row['village-house-no']); ?></td>
    </tr>
  </table>

  <div class="modal-footer ">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="generatePDF()">Print</button>
  </div>

  <!-- Modal for Viewing Certificates -->
  <div class="modal fade" id="certificateModal" tabindex="-1" role="dialog" aria-labelledby="certificateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="certificateModalLabel">Certificates</h5>
          <button type="button" class="close" id="closeCertificateModal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php
          $certQuery = $dbh->prepare("SELECT id, image FROM student_cert WHERE student_id = :student_id");
          $certQuery->bindParam(':student_id', $row['id'], PDO::PARAM_INT);
          $certQuery->execute();
          $certificates = $certQuery->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <div style="max-height: 600px; overflow-y: auto;">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Certificate Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($certificates as $cert) { ?>
                  <tr>
                    <td>
                      <a href="student_cert/<?php echo htmlentities($cert['image']); ?>" target="_blank">
                        <img src="student_cert/<?php echo htmlentities($cert['image']); ?>" class="img-fluid mb-2" alt="Student Certificate" style="max-width: 150px;">
                      </a>
                    </td>
                    <td>
                      <form method="post" onsubmit="return confirmRemove();" style="display: inline;">
                        <input type="hidden" name="cert_id" value="<?php echo $cert['id']; ?>">
                        <button type="submit" name="remove_cert" class="btn btn-danger btn-sm">Remove</button>
                      </form>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <script>
            function confirmRemove() {
              return confirm('Are you sure you want to remove this certificate?');
            }
          </script>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Viewing Enrollment History -->
  <div class="modal fade " id="enrollmentModal" tabindex="-1" role="dialog" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="enrollmentModalLabel">Enrollment History</h5>
          <button type="button" id="closeEnrollmentModal" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php
          try {
            // Ensure the connection to the database is successful
            if (!$dbh) {
              throw new Exception("Database connection failed");
            }

            // Ensure the student ID exists
            $student_id = $row['studentno'];
            if (!$student_id) {
              throw new Exception("Student ID not found");
            }

            // Prepare and execute the query
            $historyQuery = $dbh->prepare("
            SELECT 
                eh.class_id, 
                c.name, 
                c.`educ-level`, 
                c.teacher, 
                c.strand, 
                c.title, 
                c.type, 
                eh.enrolled_at ,
                eh.status,
                eh.remarks
            FROM 
                enrollment_history eh 
            JOIN 
                classes c 
            ON 
                eh.class_id = c.code 
            WHERE 
                eh.student_id = :student_id
        ");
            $historyQuery->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $historyQuery->execute();
            $enrollments = $historyQuery->fetchAll(PDO::FETCH_ASSOC);



            // Check if any enrollment records are found
            if (!$enrollments) {
              throw new Exception("No enrollment history found for the student");
            }
          ?>

            <div style="max-height: 600px; overflow-y: auto;">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Class Name</th>
                    <th>Education Level</th>
                    <th>Instructor</th>
                    <th>Enrolled at</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($enrollments as $enrollment) { ?>
                    <tr>
                      <td><?php echo htmlentities($enrollment['name']); ?></td>
                      <td><?php echo htmlentities($enrollment['educ-level']); ?></td>
                      <td><?php echo htmlentities($enrollment['teacher']); ?></td>
                      <td><?php echo htmlentities($enrollment['enrolled_at']); ?></td>
                      <td><?php echo htmlentities($enrollment['remarks']); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

          <?php
          } catch (Exception $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>


  <script>
    function generatePDF() {
      var classId = "<?php echo $eid2; ?>";
      window.open("student_pdf.php?class_id=" + classId, '_blank');
    }


    function confirmRemove() {
      return confirm('Are you sure you want to remove this certificate?');
    }


    $(document).ready(function() {
      $('#closeCertificateModal').click(function() {
        $('#certificateModal').modal('hide');
      });
    });

    $('#closeEnrollmentModal').click(function() {
      $('#enrollmentModal').modal('hide');
    });
  </script>

<?php
}
?>