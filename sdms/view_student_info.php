<style>
  @media print {

    /* Hide unnecessary elements */
    header,
    footer,
    nav,
    .no-print,
    .print-btn {
      display: none;
    }

    /* General print styles */
    body {
      font-size: 12pt;
      line-height: 1.5;
      color: #000;
      background: none;
    }

    /* Make the modal body fit to the page */
    #info_update2 {
      width: 100%;
      margin: 0;
      padding: 0;
    }

    /* Ensure images are displayed correctly */
    img {
      max-width: 100%;
      height: auto;
    }

    /* Adjust card layout for printing */
    .card {
      border: 1px solid #ccc;
      margin-bottom: 10px;
    }

    .card-body {
      padding: 10px;
    }

    /* Style headings */
    h3,
    h4 {
      text-align: center;
      margin-bottom: 10px;
    }

    /* Style lists */
    .list-group-item {
      border: none;
      padding: 5px 0;
    }

    /* Ensure full-width layout */
    .row {
      display: flex;
      flex-wrap: wrap;
    }

    .col-md-3,
    .col-md-4,
    .col-md-6,
    .col-md-9 {
      flex: 0 0 auto;
      width: 100%;
      max-width: 100%;
    }

    /* Ensure labels are displayed inline */
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 3px;
    }

    /* Style paragraphs */
    p {
      margin: 0 0 5px 0;
    }

    /* Adjust margins and paddings */
    .modal-body {
      padding: 20px;
    }

    .form-group {
      margin-bottom: 10px;
    }
  }
</style>
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$eid2 = $_POST['edit_id2'];
$ret2 = mysqli_query($con, "SELECT * FROM students WHERE id='$eid2'");
while ($row = mysqli_fetch_array($ret2)) {
?>

  <div class="row">
    <div class="col-md-3">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="img-circle" src="studentimages/<?php echo htmlentities($row['studentImage']); ?>" width="150" height="150" class="user-image" alt="User profile picture">
          </div>
          <h3 class="profile-username text-center"><?php echo $row['name']; ?></h3>
          <p class="text-muted text-center"><strong></strong></p>
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <?php
              $fullName = htmlentities($row['first-name']) . ' ' .
                htmlentities($row['middle-name']) . ' ' .
                htmlentities($row['last-name']) . ' ' .
                htmlentities($row['suffix']);
              ?>
              <b>Full Name</b> <a style="display:block; text-align: center;"><?php echo $fullName; ?></a>
            </li>
            <li class="list-group-item">
              <b>Enrolled In</b> <a style="display:block; text-align: center;">
                <?php
                if (isset($row['program'])) {
                  echo htmlentities($row['program']);
                } else {
                  echo htmlentities($row['gradelevel']);
                }
                ?>
              </a>
            </li>
          </ul>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-md-9 d-flex flex-column">
      <div class="card flex-grow-1 d-flex flex-column">
        <div class="card-body flex-grow-1 d-flex flex-column">
          <div class="tab-content flex-grow-1">
            <h4 style="margin-bottom: 10px;">Student Information</h4>
            <hr>
            <div class="active tab-pane flex-grow-1 d-flex flex-column" id="studentinfo">
              <div class="row flex-grow-1">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="regno">Student ID</label>
                    <p><?php echo htmlentities($row['studentno']); ?></p>
                  </div>
                </div>
              </div>
              <div class="row flex-grow-1">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <p><?php echo htmlentities($row['last-name']); ?></p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="first-name">First Name</label>
                    <p><?php echo htmlentities($row['first-name']); ?></p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="middle-name">Middle Name</label>
                    <p><?php echo htmlentities($row['middle-name']); ?></p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="suffix">Suffix</label>
                    <p><?php echo htmlentities($row['suffix']); ?></p>
                  </div>
                </div>
              </div>
              <div class="row flex-grow-1">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Sex</label>
                    <p><?php echo htmlentities($row['gender']); ?></p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Age</label>
                    <p><?php echo htmlentities($row['age']); ?></p>
                  </div>
                </div>
              </div>
            </div>
            <h4 style="margin-bottom: 10px;">Parent/Guardian Information</h4>
            <hr>
            <div class="tab-pane flex-grow-1 d-flex flex-column" id="parentinfo">
              <?php
              $parentID = $row['parent_id'];
              $_SESSION['parentID'] = $parentID;
              $sql = "SELECT * FROM parent WHERE id = :parentID";
              $parentQuery = $dbh->prepare($sql);
              $parentQuery->bindParam(':parentID', $parentID, PDO::PARAM_INT);
              $parentQuery->execute();
              $parentRow = $parentQuery->fetch(PDO::FETCH_ASSOC);
              ?>
              <div class="row flex-grow-1">
                <div class="form-group col-md-3">
                  <label for="p_last_name">Last Name</label>
                  <p><?php echo htmlentities($parentRow['last_name']); ?></p>
                </div>
                <div class="form-group col-md-3">
                  <label for="p_first_name">First Name</label>
                  <p><?php echo htmlentities($parentRow['first_name']); ?></p>
                </div>
                <div class="form-group col-md-3">
                  <label for="p_middle_name">Middle Name</label>
                  <p><?php echo htmlentities($parentRow['middle_name']); ?></p>
                </div>
                <div class="form-group col-md-3">
                  <label for="p_suffix">Suffix</label>
                  <p><?php echo htmlentities($parentRow['suffix']); ?></p>
                </div>
              </div>
              <div class="row flex-grow-1">
                <div class="form-group col-md-3">
                  <label for="relationship">Relationship</label>
                  <p><?php echo htmlentities($parentRow['relationship']); ?></p>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <p><?php echo htmlentities($parentRow['occupation']); ?></p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Phone No.</label>
                    <p>0<?php echo htmlentities($parentRow['contact-no']); ?></p>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Email</label>
                    <p><?php echo htmlentities($parentRow['email']); ?></p>
                  </div>
                </div>
              </div>
            </div>
            <h4 style="margin-bottom: 10px;">Address</h4>
            <hr>
            <!-- /.tab-pane -->
            <div class="tab-pane flex-grow-1 d-flex flex-column" id="addressinfo">
              <?php
              $provCode = $row['province'];
              $allProvincesQuery = $dbh->query("SELECT * FROM refprovince where provCode =  $provCode");
              $provRow = $allProvincesQuery->fetch(PDO::FETCH_ASSOC);
              $cityCode = $row['city'];
              $brgyCode = $row['barangay'];
              ?>
              <div class="row flex-grow-1">
                <div class="form-group col-md-6">
                  <label for="Province">Province</label>
                  <p><?php echo htmlentities($provRow['provDesc']); ?></p>
                </div>
                <div class="form-group col-md-6">
                  <label for="City">City</label>
                  <p>
                    <?php
                    $allCitiesQuery = $dbh->query("SELECT * FROM refcitymun WHERE provCode = '{$provCode}'");
                    while ($cityRow = $allCitiesQuery->fetch(PDO::FETCH_ASSOC)) {
                      if ($cityRow['citymunCode'] == $cityCode) {
                        echo htmlentities($cityRow['citymunDesc']);
                        break;
                      }
                    }
                    ?>
                  </p>
                </div>
              </div>
              <div class="row flex-grow-1">
                <div class="form-group col-md-6">
                  <label for="Barangay">Barangay</label>
                  <p>
                    <?php
                    $allBarangaysQuery = $dbh->query("SELECT * FROM refbrgy WHERE citymunCode = '{$cityCode}'");
                    while ($brgyRow = $allBarangaysQuery->fetch(PDO::FETCH_ASSOC)) {
                      if ($brgyRow['brgyCode'] == $brgyCode) {
                        echo htmlentities($brgyRow['brgyDesc']);
                        break;
                      }
                    }
                    ?>
                  </p>
                </div>
                <div class="form-group col-md-6">
                  <label for="village">Village & House No.</label>
                  <p><?php echo htmlentities($row['village-house-no']); ?></p>
                </div>
              </div>
            </div>
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>

<?php
}
?>


<script>
  function printCert() {
    var elements = document.querySelectorAll('#info_update2');
    if (elements.length > 0) {
      var printContents = '';
      elements.forEach(function(element) {
        printContents += element.innerHTML + '<br>';
      });
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    } else {
      console.error('Elements with id "info_update2" not found.');
    }
  }
</script>