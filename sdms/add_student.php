<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid']) == 0) {
  header('location:logout.php');
}
?>



<!DOCTYPE html>
<html>
<?php @include("includes/head.php"); ?>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php @include("includes/header.php"); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php @include("includes/sidebar.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Add Student</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row ">
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Student</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" id=addStudentForm enctype="multipart/form-data">
                  <div class="card-body">
                    <span style="color: brown">
                      <h5>Student details</h5>
                    </span>
                    <hr>
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="studentno">Student ID</label>
                        <input type="text" class="form-control" id="studentno" name="studentno" placeholder="Enter student No" required readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="studentno">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" required>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="studentno">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" required>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="studentno">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter Middle Name" required>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="studentno">Suffix(Optional)</label>
                        <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Enter Suffix">
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Birthdate" required>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="age" required readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="sex">Sex</label>
                        <select type="select" class="form-control" id="sex" name="sex" required>
                          <option>Select Sex</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3">
                        <label for="exampleInputFile">Student Photo</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="" name="photo" id="photo">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="semail">Email</label>
                        <input type="email" class="form-control" id="semail" name="semail" placeholder="Email">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="sphone">Phone Number</label>
                        <input type="number" class="form-control" id="sphone" name="sphone" placeholder="Phone Number">
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="studentno">Last School Attended</label>
                        <input type="text" class="form-control" id="last_school" name="last_school" placeholder="Enter Last School Attended" required>
                      </div>
                    </div>

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
                    <hr>
                    <span style="color: brown">
                      <h5>Address</h5>
                    </span>
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="Province">Province</label>
                        <select type="select" class="form-control" id="province" name="province" required>
                          <option value="">Select province</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="City">City</label>
                        <select type="select" class="form-control" id="city" name="city" required>
                          <option value="">Select City</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="City">Barangay</label>
                        <select type="select" class="form-control" id="barangay" name="barangay" required>
                          <option value="">Select Barangay</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="village">Village & House No.</label>
                        <input type="text" class="form-control" id="village" name="village" placeholder="Village" required>
                      </div>
                    </div>

                    <div class="row">
                    </div>
                    <hr>
                    <span style="color: brown">
                      <h5>Parent/Guardian Details</h5>
                    </span>

                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="parent-f-name">Last Name</label>
                        <input type="text" class="form-control" id="parentname" name="parent-lastname" placeholder="Enter Last Name" required>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="parent-l-name">First Name</label>
                        <input type="text" class="form-control" id="parentname" name="parent-firstname" placeholder="Enter First Name" required>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="parent-m-name">Middle Name</label>
                        <input type="text" class="form-control" id="parentname" name="parent-middlename" placeholder="Enter Middle Name" required>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="parent-suffix">Suffix(Optional)</label>
                        <input type="text" class="form-control" id="parentname" name="parent-suffix" placeholder="Enter Suffix">
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="relation">Relationship</label>
                        <select type="select" class="form-control" id="relation" name="relation" required>
                          <option>Select Relationship</option>
                          <option value="Father">Father</option>
                          <option value="Mother">Mother</option>
                          <option value="Father">Uncle</option>
                          <option value="Mother">Aunt</option>
                          <option value="Mother">Grand parent</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="age">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="nextphone">Phone Number</label>
                        <input type="number" class="form-control" id="nextphone" name="phone" placeholder="Phone Number">
                      </div>
                      <div class="form-group col-md-2">
                        <label for="occupation">Ocupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" required>
                      </div>
                    </div>



                  </div>
                  <!-- /.card-body -->
                  <div class="alert alert-success" style="display: none;">
                  </div>
                  <div class="alert alert-danger" style="display: none;">
                  </div>
                  <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php @include("includes/footer.php"); ?>
    <?php @include("includes/foot.php"); ?>
  </div>



</body>
<script defer src="build/js/add_student.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("addStudentForm").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent form submission
      var formData = new FormData(this);

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/add_student_ajax.php", true);
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
                }, 3000);
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
              // Log the error to the console
              console.error("Error parsing JSON response:", error);

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
            requestErrorAlert.innerHTML = "Error occurred while processings your request. Please try again.";
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
</script>




</html>
<?php
?>