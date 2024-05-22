<style>
  .header-logo {
    display: none !important;
    align-items: center !important;
    justify-content: center !important;
    margin-bottom: 20px !important;
  }

  .header-text {
    text-align: center !important;
  }

  .horizontal {
    margin-top: 40px !important;
    display: none !important;
  }

  @media print {
    * {
      font-size: 20px !important;
    }

    .b-print {
      margin-bottom: 20px !important;

    }

    .a-print {
      display: none !important;
    }

    .row-print {
      display: grid !important;
      grid-template-columns: 1fr 1fr 1fr 1fr !important;
      align-items: center !important;
      padding-bottom: 5px !important;
      margin-bottom: 10px !important;
    }

    user-image {
      height: 200px !important;
    }

    .header-logo {
      display: flex !important;
    }

    h4 {
      margin-top: 40px !important;
    }

    .horizontal {
      display: block !important;

    }

    * {
      font-size: 24px !important;
    }

    table {
      text-align: center !important;
    }

    .img-print {
      border-radius: 10px !important;
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

      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="img-circle img-print" src="studentimages/<?php echo htmlentities($row['studentImage']); ?>" width="150" height="150" class="user-image" alt="User profile picture">
          </div>
          <h3 class="profile-username text-center"><?php echo $row['name']; ?></h3>
          <p class="text-muted text-center"><strong></strong></p>
          <ul class="list-group list-group-unbordered mb-3 b-print">
            <li class="list-group-item a-print">
              <?php
              $fullName = htmlentities($row['first-name']) . ' ' .
                htmlentities($row['middle-name']) . ' ' .
                htmlentities($row['last-name']) . ' ' .
                htmlentities($row['suffix']);
              ?>
              <b>Full Name</b> <a class="a-print" style="display:block; text-align: center;"><?php echo $fullName; ?></a>
            </li>
            <li class="list-group-item a-print">
              <b>Enrolled In</b> <a class="a-print" style="display:block; text-align: center;">
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
            <h4 style="margin-bottom: 10px; font-weight: 600;">Student Information</h4>
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
              <div class="row flex-grow-1 row-print">
                <div class="col-md-3 ">
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
              <div class="row flex-grow-1 row-print">
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
            <h4 style="margin-bottom: 10px; font-weight: 600;">Parent/Guardian Information</h4>
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
              <div class="row flex-grow-1 row-print">
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
              <div class="row flex-grow-1 row-print">
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
            <h4 style="margin-bottom: 10px; font-weight: 600;">Address</h4>
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
              <div class="row flex-grow-1 row-print">
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
              <div class="row flex-grow-1 row-print">
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