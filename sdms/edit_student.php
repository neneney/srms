<?php

session_start();
error_reporting(0);
include('includes/dbconnection.php');
$sql = "SELECT * FROM programs";
$query = $dbh->prepare($sql);
$query->execute();
$programs = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
  $sid = $_SESSION['edid'];
  $last_name = $_POST['last-name'];
  $middle_name = $_POST['middle-name'];
  $first_name = $_POST['first-name'];
  $suffix = $_POST['suffix'];
  $regno = $_POST['regno'];
  $sex = $_POST['sex'];
  $age = $_POST['age'];
  $sql = "UPDATE students SET `last-name`=:last_name,`first-name`=:first_name,`middle-name`=:middle_name,suffix=:suffix , studentno=:regno, gender=:sex, age=:age WHERE id=:sid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
  $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
  $query->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
  $query->bindParam(':suffix', $suffix, PDO::PARAM_STR);
  $query->bindParam(':regno', $regno, PDO::PARAM_STR);
  $query->bindParam(':sex', $sex, PDO::PARAM_STR);
  $query->bindParam(':age', $age, PDO::PARAM_STR);
  $query->bindParam(':sid', $sid, PDO::PARAM_STR);
  if ($query->execute()) {
    echo "<script>alert('Updated successfully.');</script>";
    echo "<script>window.location.href ='student_list.php'</script>";
  } else {
    echo "<script>alert('Something went wrong, please try again later');</script>";
  }
}


if (isset($_POST['save'])) {
  $pid = $_SESSION['parentID'];
  $p_first_name = $_POST['p_first_name'];
  $p_last_name = $_POST['p_last_name'];
  $p_middle_name = $_POST['p_middle_name'];
  $p_suffix = $_POST['p_suffix'];
  $relationship = $_POST['relationship'];
  $occupation = $_POST['occupation'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

  $sql = "UPDATE parent SET last_name = :last_name, first_name = :first_name, middle_name = :middle_name, suffix = :suffix, relationship = :relationship, occupation = :occupation, `contact-no` = :phone, email = :email WHERE id = :pid";
  $query = $dbh->prepare($sql);

  $query->bindParam(':last_name', $p_last_name, PDO::PARAM_STR);
  $query->bindParam(':first_name', $p_first_name, PDO::PARAM_STR);
  $query->bindParam(':middle_name', $p_middle_name, PDO::PARAM_STR);
  $query->bindParam(':suffix', $p_suffix, PDO::PARAM_STR);
  $query->bindParam(':relationship', $relationship, PDO::PARAM_STR);
  $query->bindParam(':occupation', $occupation, PDO::PARAM_STR);
  $query->bindParam(':phone', $phone, PDO::PARAM_STR);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':pid', $pid, PDO::PARAM_INT);

  if ($query->execute()) {
    echo "<script>alert('updated successfuly.');</script>";
    echo "<script>window.location.href ='student_list.php'</script>";
  } else {
    echo "<script>alert('something went wrong, please try again later');</script>";
  }
}

if (isset($_POST['pass'])) {
  $sid = $_SESSION['edid'];
  $province = $_POST['province1'];
  $city = $_POST['city1'];
  $barangay = $_POST['barangay1'];
  $village = $_POST['village1'];

  $sql = "UPDATE students SET province=:province, city=:city, barangay=:barangay, `village-house-no`=:village WHERE id=:sid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':province', $province, PDO::PARAM_STR);
  $query->bindParam(':city', $city, PDO::PARAM_STR);
  $query->bindParam(':barangay', $barangay, PDO::PARAM_STR);
  $query->bindParam(':village', $village, PDO::PARAM_STR);
  $query->bindParam(':sid', $sid, PDO::PARAM_INT);

  try {
    $query->execute();
    echo "<script>alert('Updated successfully.');</script>";
    echo "<script>window.location.href ='student_list.php'</script>";
  } catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
  }
}

if (isset($_POST['save2'])) {
  $sid = $_SESSION['edid'];
  $studentimage = $_FILES["studentimage"]["name"];
  move_uploaded_file($_FILES["studentimage"]["tmp_name"], "studentimages/" . $_FILES["studentimage"]["name"]);
  $sql = "update students set studentImage=:studentimage where id='$sid' ";
  $query = $dbh->prepare($sql);
  $query->bindParam(':studentimage', $studentimage, PDO::PARAM_STR);
  $query->execute();
  if ($query->execute()) {
    echo "<script>alert('updated successfuly.');</script>";
    echo "<script>window.location.href ='student_list.php'</script>";
  } else {
    echo "<script>alert('something went wrong, please try again later');</script>";
  }
}
?>



<div class="card-body">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <?php
        $eid = $_POST['edit_id'];
        $ret = mysqli_query($con, "select * from  students where id='$eid'");
        $cnt = 1;
        while ($row = mysqli_fetch_array($ret)) {
          $_SESSION['edid'] = $row['id'];
        ?>
          <div class="col-md-3">
            <!-- Profile Image -->
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
                    // Display the concatenated full name
                    ?>
                    <b>Full Name</b> <a style="display:block; text-align: center;"><?php echo $fullName; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Enrolled In</b> <a style="display:block; text-align: center;">
                      <?php
                      if (isset($row['program'])) {
                        echo $row['program'];
                      } else {
                        echo $row['gradelevel'];
                      }
                      ?>
                    </a>

                  </li>

                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#companydetail" data-toggle="tab">Student Info</a></li>
                  <li class="nav-item"><a class="nav-link" href="#companyaddress" data-toggle="tab">Parent/Guardian</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Address</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change" data-toggle="tab">Update Image</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="companydetail">
                    <form role="form" id="" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="regno">Student ID</label>
                            <input name="regno" class="form-control" name="regno" id="regno" value="<?php echo $row['studentno']; ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="companyname">Last Name</label>
                            <input name="last-name" class="form-control" name="studentname" id="studentname" value="<?php echo $row['last-name']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="companyname">First Name</label>
                            <input name="first-name" class="form-control" name="studentname" id="studentname" value="<?php echo $row['first-name']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="companyname">Middle Name</label>
                            <input name="middle-name" class="form-control" name="studentname" id="studentname" value="<?php echo $row['middle-name']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="companyname">Suffix</label>
                            <input name="suffix" class="form-control" name="studentname" id="studentname" value="<?php echo $row['suffix']; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Sex</label>
                            <select class="form-control" name="sex" required>
                              <option value="">Select Gender</option>
                              <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                              <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Age</label>
                            <input type="number" class="form-control" name="age" value="<?php echo $row['age']; ?>" required readonly>
                          </div>
                        </div>
                        <!-- <div class="form-group col-md-8">
                          <label for="program">Program</label>
                          <select class="form-control" id="program" name="program" required>
                            <option>Select Program</option>
                            <?php foreach ($programs as $program) { ?>
                              <option value="<?php echo $program['name']; ?>"><?php echo $program['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div> -->
                        <!-- /.col -->
                      </div>
                      <!-- /.card-body -->
                      <div class="modal-footer text-right">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  <div class=" tab-pane" id="companyaddress">
                    <form role="form" id="" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <?php
                      $parentID = $row['parent_id'];
                      $_SESSION['parentID'] = $parentID;
                      $sql = "SELECT * FROM parent WHERE id = :parentID";
                      $parentQuery = $dbh->prepare($sql);
                      $parentQuery->bindParam(':parentID', $parentID, PDO::PARAM_INT);
                      $parentQuery->execute();
                      $parentRow = $parentQuery->fetch(PDO::FETCH_ASSOC);
                      ?>

                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="p_last_name">Last Name</label>
                          <input name="p_last_name" class="form-control" id="p_last_name" value="<?php echo $parentRow['last_name']; ?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="p_first_name">First Name</label>
                          <input name="p_first_name" class="form-control" id="p_first_name" value="<?php echo $parentRow['first_name']; ?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="p_middle_name">Middle Name</label>
                          <input name="p_middle_name" class="form-control" id="p_middle_name" value="<?php echo $parentRow['middle_name']; ?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="p_suffix">Suffix</label>
                          <input name="p_suffix" class="form-control" id="p_suffix" value="<?php echo $parentRow['suffix']; ?>">
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="relationship">Relationship</label>
                          <select class="form-control" id="relationship" name="relationship" required>
                            <option>Select Relationship</option>
                            <option value="Father" <?php if ($parentRow['relationship'] == 'Father') echo 'selected'; ?>>Father</option>
                            <option value="Mother" <?php if ($parentRow['relationship'] == 'Mother') echo 'selected'; ?>>Mother</option>
                            <option value="Uncle" <?php if ($parentRow['relationship'] == 'Uncle') echo 'selected'; ?>>Uncle</option>
                            <option value="Aunt" <?php if ($parentRow['relationship'] == 'Aunt') echo 'selected'; ?>>Aunt</option>
                            <option value="Grandparent" <?php if ($parentRow['relationship'] == 'Grandparent') echo 'selected'; ?>>Grandparent</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" value="<?php echo $parentRow['occupation']; ?>" required>
                            <!-- <select class="form-control" id="occupation" name="occupation" required>
                              <option>Occupation</option>
                              <option value="Doctor" <?php if ($parentRow['occupation'] == 'Doctor') echo 'selected'; ?>>Doctor</option>
                              <option value="Engineer" <?php if ($parentRow['occupation'] == 'Engineer') echo 'selected'; ?>>Engineer</option>
                              <option value="Businessman" <?php if ($parentRow['occupation'] == 'Businessman') echo 'selected'; ?>>Businessman</option>
                              <option value="Teacher" <?php if ($parentRow['occupation'] == 'Teacher') echo 'selected'; ?>>Teacher</option>
                              <option value="Driver" <?php if ($parentRow['occupation'] == 'Driver') echo 'selected'; ?>>Driver</option>
                              <option value="Pilot" <?php if ($parentRow['occupation'] == 'Pilot') echo 'selected'; ?>>Pilot</option>
                              <option value="Software Developer" <?php if ($parentRow['occupation'] == 'Software Developer') echo 'selected'; ?>>Software Developer</option>
                              <option value="Farmer" <?php if ($parentRow['occupation'] == 'Farmer') echo 'selected'; ?>>Farmer</option>
                              <option value="Other" <?php if ($parentRow['occupation'] == 'Other') echo 'selected'; ?>>Other</option>
                            </select> -->
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Phone No.</label>
                            <input class="form-control" name="phone" type="number" value="0<?php echo $parentRow['contact-no']; ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="email" value="<?php echo $parentRow['email']; ?>">
                          </div>
                        </div>
                      </div>

                      <div class="modal-footer text-right">
                        <button type="submit" name="save" class="btn btn-primary">Update</button>
                      </div>
                    </form>
                  </div>

                  <!-- /.tab-pane -->

                  <div class=" tab-pane" id="change">
                    <div class="row">
                      <form role="form" id="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group">
                          <label>Upload Image</label>
                          <input type="file" class="" name="studentimage" value="" required>
                        </div>
                        <div class="modal-footer text-right">
                          <button type="submit" name="save2" class="btn btn-primary">Update</button>
                        </div>

                      </form>
                    </div>
                  </div>
                  <?php
                  $provCode = $row['province'];
                  $allProvincesQuery = $dbh->query("SELECT * FROM refprovince where provCode =  $provCode");
                  $provRow = $allProvincesQuery->fetch(PDO::FETCH_ASSOC);
                  $cityCode = $row['city'];
                  $brgyCode = $row['barangay'];

                  ?>
                  <div class="tab-pane" id="settings">
                    <form role="form" id="" method="post" enctype="multipart/form-data">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="Province">Province</label>
                          <select type="select" class="form-control" id="province1" name="province1" required>
                            <option value="">Select province</option>
                            <?php
                            if (!empty($provCode)) {
                              echo "<option value='{$provCode}' selected>{$provRow['provDesc']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="City">City</label>
                          <select type="select" class="form-control" id="city1" name="city1" required>
                            <option value="">Select City</option>
                            <?php
                            $allCitiesQuery = $dbh->query("SELECT * FROM refcitymun WHERE provCode = '{$provCode}'");
                            while ($cityRow = $allCitiesQuery->fetch(PDO::FETCH_ASSOC)) {
                              $selected = ($cityRow['citymunCode'] == $cityCode) ? 'selected' : '';
                              echo "<option value='{$cityRow['citymunCode']}' {$selected}>{$cityRow['citymunDesc']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="Barangay">Barangay</label>
                          <select type="select" class="form-control" id="barangay1" name="barangay1" required>
                            <option value="">Select Barangay</option>
                            <?php
                            $allBarangaysQuery = $dbh->query("SELECT * FROM refbrgy WHERE citymunCode = '{$cityCode}'");
                            while ($brgyRow = $allBarangaysQuery->fetch(PDO::FETCH_ASSOC)) {
                              $selected = ($brgyRow['brgyCode'] == $brgyCode) ? 'selected' : '';
                              echo "<option value='{$brgyRow['brgyCode']}' {$selected}>{$brgyRow['brgyDesc']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="village">Village & House No.</label>
                          <input value="<?php echo $row['village-house-no'] ?>" type="text" class="form-control" id="village" name="village1" placeholder="Village" required>
                        </div>
                      </div>



                      <div class="modal-footer text-right">
                        <button type="submit" name="pass" class="btn btn-primary">Update</button>
                      </div>

                    </form>
                  </div>

                  <!-- /.tab-pane -->
                <?php
              } ?>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
  </section>
  <!-- /.content -->
</div>