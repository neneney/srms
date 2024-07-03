<?php

session_start();
error_reporting(0);
include('includes/dbconnection.php');

?>



<div class="card-body">
  <!-- Main content -->
  <section class="content">
    <div class="alert alert-success" style="text-align:center; display: none;">
    </div>
    <div class="alert alert-danger" style="text-align:center; display: none;">
    </div>
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
                  <img class="img-circle" src="studentimages/<?php echo htmlentities($row['studentImage']); ?>" width="150" height="150" class="user-image" alt="User profile picture" onerror="this.onerror=null; this.src='studentimages/placeholder.jpg';">
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
                  <li class="nav-item"><a class="nav-link" href="#enrollment" data-toggle="tab">Enrollment</a></li>
                  <li class="nav-item"><a class="nav-link" href="#companyaddress" data-toggle="tab">Parent/Guardian</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Address</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change" data-toggle="tab">Update Image</a></li>
                  <li class="nav-item"><a class="nav-link" href="#cert" data-toggle="tab">Certifications</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <!-- tab pane -->
                  <div class="active tab-pane" id="companydetail">
                    <form role="form" method="post" id=studentInfo enctype="multipart/form-data" class="form-horizontal">
                      <input type="hidden" name="rowId" value="<?php echo $row['id']; ?>">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="regno">Student ID</label>
                            <input name="regno" class="form-control" name="regno" id="regno" value="<?php echo $row['studentno']; ?>" required readonly>
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

                      </div>

                      <div class="modal-footer text-right">
                        <button id="submit" type="submit" name="submit" class="btn btn-primary">Update</button>
                      </div>
                    </form>
                  </div>

                  <div class="tab-pane" id="enrollment">
                    <form role="form" id="enrollments" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <input type="hidden" name="rowNo" value="<?php echo $row['studentno']; ?>">
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label for="grade">Student Educational Level</label>
                          <select class="form-control" id="levels" name="levels">
                            <option value="">Select Educational Level</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Junior Highschool">Junior High School</option>
                            <option value="Senior Highschool">Senior High School</option>
                            <option value="Vocational Course">Vocational Course(TESDA)</option>
                            <option value="Others">Others</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4" id="class">
                          <label for="classes">Student Class</label>
                          <select class="form-control" id="classes" name="classes">
                            <option value="">Select Educational Level</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer text-right">
                        <button type="submit" name="enroll" class="btn btn-primary">Update</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  <!-- tab pane -->
                  <div class=" tab-pane" id="companyaddress">
                    <form role="form" id="parent_update" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <input type="hidden" name="parentID" value="<?php echo $row['parent_id']; ?>">
                      <?php
                      $parentID = $row['parent_id'];
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
                  <!-- /.tab pane -->

                  <!-- /.tab pane -->
                  <?php
                  $provCode = $row['province'];
                  $allProvincesQuery = $dbh->query("SELECT * FROM refprovince where provCode =  $provCode");
                  $provRow = $allProvincesQuery->fetch(PDO::FETCH_ASSOC);
                  $cityCode = $row['city'];
                  $brgyCode = $row['barangay'];

                  ?>
                  <div class="tab-pane" id="settings">
                    <form role="form" id="address" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="rowId" value="<?php echo $row['id']; ?>">
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
                  <div class=" tab-pane" id="change">
                    <form role="form" id="image" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <input type="hidden" name="rowId" value="<?php echo $row['id']; ?>">
                      <div class="row">
                        <div class="form-group col-md-8">
                          <label>Upload Image</label>
                          <input type="file" class="form-control" name="studentimage" value="" accept="image/*" required>
                        </div>

                      </div>
                      <div class="modal-footer text-right">
                        <button type="submit" name="save2" class="btn btn-primary">Update</button>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="cert">
                    <form role="form" id="certificate" method="post" enctype="multipart/form-data" class="form-horizontal">
                      <div class="row">
                        <div class="form-group col-md-8">
                          <label class="form-label">Upload certificates</label>
                          <input type="file" class="form-control" name="studentCert[]" accept=".pdf,image/*" multiple required>
                        </div>
                      </div>
                      <div class="modal-footer text-right">
                        <button type="submit" name="save3" class="btn btn-primary">Update</button>
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

<script>
  function getAjaxHandlerUrl(formId) {
    switch (formId) {
      case "studentInfo":
        return "ajax/student_info.php";
      case "parent_update":
        return "ajax/parent_update.php";
      case "enrollments":
        return "ajax/enrollment_update.php";
      case "address":
        return "ajax/address_update.php";
      case "image":
        return "ajax/image_update.php";
      case "certificate":
        return "ajax/update_cert.php"
      default:
        return "";
    }
  }
  document.querySelectorAll("form").forEach(function(form) {
    form.addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent form submission

      var formData = new FormData(this);
      formData.append("formId", this.id); // Append the form ID

      var xhr = new XMLHttpRequest();
      var ajaxHandler = getAjaxHandlerUrl(this.id); // Get the AJAX handler URL based on the form ID
      xhr.open("POST", ajaxHandler, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            try {
              var response = JSON.parse(xhr.responseText);

              if (response.status === "success") {
                // Show success alert
                var successAlert = document.querySelector(".alert-success");
                successAlert.innerHTML = response.message;
                successAlert.style.display = "block";
                setTimeout(function() {
                  successAlert.style.display = "none";
                  location.reload();
                }, 2000);
              } else if (response.status === "error") {
                // Show error alert
                var errorAlert = document.querySelector(".alert-danger");
                errorAlert.innerHTML = response.message;
                errorAlert.style.display = "block";
                setTimeout(function() {
                  errorAlert.style.display = "none";
                }, 3000);
              } else {
                // Show a generic error message if the response is not properly formatted
                var genericErrorAlert = document.querySelector(".alert-danger");
                genericErrorAlert.innerHTML = "Unexpected response from server. Please try again.";
                genericErrorAlert.style.display = "block";
                setTimeout(function() {
                  genericErrorAlert.style.display = "none";
                }, 3000);
              }
            } catch (error) {
              // Show a generic error message if there's an issue parsing the JSON response
              var parseErrorAlert = document.querySelector(".alert-danger");
              parseErrorAlert.innerHTML = "Error occurred while processing server response: " + error.message;
              parseErrorAlert.style.display = "block";
              setTimeout(function() {
                parseErrorAlert.style.display = "none";
              }, 3000);
            }
          } else {
            // Show error alert if there is any issue with the Ajax request
            var requestErrorAlert = document.querySelector(".alert-danger");
            requestErrorAlert.innerHTML = "Error occurred while processing your request. Please try again.";
            requestErrorAlert.style.display = "block";
            setTimeout(function() {
              requestErrorAlert.style.display = "none";
            }, 3000);
          }
        }
      };
      xhr.send(formData);
    });
  });



  document.getElementById('levels').addEventListener('change', function() {
    fetchAndPopulateClasses(this.value);
  });

  function fetchAndPopulateClasses(gradeLevel) {
    var classSelect = document.getElementById('class');
    var classesDropdown = document.getElementById('classes');

    if (gradeLevel !== "") {
      fetch('getters-php/get-classes.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'gradeLevel=' + encodeURIComponent(gradeLevel)
        })
        .then(response => response.json())
        .then(data => {
          classesDropdown.innerHTML = '<option value="">Select Class</option>';
          data.forEach(classItem => {
            var option = document.createElement('option');
            option.value = classItem.code;
            if (classItem['educ-level'] === "Vocational Course") {
              option.text = classItem.name + " (" + classItem.title + ")";
            } else if (classItem['educ-level'] === "Others") {
              option.text = classItem.name + " (" + classItem.type + ")";
            } else if (classItem['educ-level'] === "Senior Highschool") {
              option.text = classItem.name + " (" + classItem.strand + ")";
            } else {
              option.text = classItem.name;
            }
            classesDropdown.appendChild(option);
          });
          classSelect.style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
    } else {
      classSelect.style.display = 'none';
    }
  }
</script>