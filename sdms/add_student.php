<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
} else {
  $sql = "SELECT * FROM programs";
  $query = $dbh->prepare($sql);
  $query->execute();
  $programs = $query->fetchAll(PDO::FETCH_ASSOC);

  if (isset($_POST['submit'])) {
    $names = $_POST['names'];
    $age = $_POST['age'];
    $studentno = $_POST['studentno'];
    $sex = $_POST['sex'];
    $parentname = $_POST['parentname'];
    $relation = $_POST['relation'];
    $ocupation = $_POST['ocupation'];
    $email = $_POST['email'];
    $program = $_POST['program'];
    $phone = $_POST['phone'];
    $nextphone = $_POST['nextphone'];
    $country = $_POST['province'];
    $district = $_POST['city'];
    $state = $_POST['barangay'];
    $village = $_POST['village'];
    $photo = $_FILES["photo"]["name"];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "studentimages/" . $_FILES["photo"]["name"]);

    // Prepare SQL statement using PDO
    $sql = "INSERT INTO students (studentno, StudentName, age, gender, email, program, parentName, relation, occupation, province, city, barangay, `village-house-no`, contactno, nextphone, studentImage) VALUES (:studentno, :names, :age, :sex, :email, :program, :parentname, :relation, :ocupation, :country, :district, :state, :village, :phone, :nextphone, :photo)";
    $query = $dbh->prepare($sql);

    // Bind parameters
    $query->bindParam(':studentno', $studentno, PDO::PARAM_STR);
    $query->bindParam(':names', $names, PDO::PARAM_STR);
    $query->bindParam(':age', $age, PDO::PARAM_INT);
    $query->bindParam(':sex', $sex, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':program', $program, PDO::PARAM_STR);
    $query->bindParam(':parentname', $parentname, PDO::PARAM_STR);
    $query->bindParam(':relation', $relation, PDO::PARAM_STR);
    $query->bindParam(':ocupation', $ocupation, PDO::PARAM_STR);
    $query->bindParam(':country', $country, PDO::PARAM_STR);
    $query->bindParam(':district', $district, PDO::PARAM_STR);
    $query->bindParam(':state', $state, PDO::PARAM_STR);
    $query->bindParam(':village', $village, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':nextphone', $nextphone, PDO::PARAM_STR);
    $query->bindParam(':photo', $photo, PDO::PARAM_STR);

    // Execute the query
    if ($query->execute()) {
      echo "<script>
    alert('Student has been registered.');
  </script>";
      echo "<script>
    window.location.href = 'add_student.php'
  </script>";
    } else {
      echo "<script>
    alert('Something Went Wrong. Please try again.');
  </script>";
    }
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
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                  <form role="form" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <span style="color: brown">
                        <h5>Student details</h5>
                      </span>
                      <hr>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="studentno">Student No.</label>
                          <input type="text" class="form-control" id="studentno" name="studentno" placeholder="Enter student No" required>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="names">Names</label>
                          <input type="text" class="form-control" id="names" name="names" placeholder="Names" required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="age">Age</label>
                          <input type="text" class="form-control" id="age" name="age" placeholder="age" required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="sex">Sex</label>
                          <select type="select" class="form-control" id="sex" name="sex" required>
                            <option>Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-8">
                          <label for="program">Program</label>
                          <select class="form-control" id="program" name="program" required>
                            <option>Select Program</option>
                            <?php foreach ($programs as $program) { ?>
                              <option value="<?php echo $program['name']; ?>"><?php echo $program['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>


                        <div class="form-group col-md-4">
                          <label for="exampleInputFile">Student Photo</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="" name="photo" id="photo" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <span style="color: brown">
                        <h5>Parent details</h5>
                      </span>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="parentname">Parent Name.</label>
                          <input type="text" class="form-control" id="parentname" name="parentname" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="relation">Relationship</label>
                          <select type="select" class="form-control" id="relation" name="relation" required>
                            <option>Select Relationship</option>
                            <option value="Father">Father</option>
                            <option value="Mother">Mother</option>
                            <option value="Father">Uncle</option>
                            <option value="Mother">Ant</option>
                            <option value="Mother">Grand</option>
                          </select>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="age">Email</label>
                          <input type="text" class="form-control" id="email" name="email" placeholder="email" required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="sex">Ocupation</label>
                          <select type="select" class="form-control" id="ocupation" name="ocupation" required>
                            <option>occupation</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Engineer">Engineer</option>
                            <option value="Bussiness man">Bussiness man</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Driver">Driver</option>
                            <option value="Pilot">Pilot</option>
                            <option value="Software developer">Software developer</option>
                            <option value="Farmer">Farmer</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-3 offset-md-6">
                          <label for="phone1">Phone 1</label>
                          <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="nextphone">Phone 2</label>
                          <input type="text" class="form-control" id="nextphone" name="nextphone" placeholder="phone2" required>
                        </div>
                      </div>
                      <hr>
                      <span style="color: brown">
                        <h5>Address</h5>
                      </span>
                      <div class="row">
                        <div class="form-group col-md-3 ">
                          <label for="Province">Province</label>
                          <input type="text" class="form-control" id="diProvincestrict" name="province" placeholder="Province" required>
                        </div>
                        <div class="form-group col-md-3 ">
                          <label for="City">City</label>
                          <input type="text" class="form-control" id="City" name="city" placeholder="City" required>
                        </div>
                        <div class="form-group col-md-3 ">
                          <label for="Barangay">Barangay</label>
                          <input type="text" class="form-control" id="Barangay" name="barangay" placeholder="Barangay" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="village">Village & House No.</label>
                          <input type="text" class="form-control" id="village" name="village" placeholder="Village" required>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
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

    </div>

    <!-- ./wrapper -->
    <?php @include("includes/foot.php"); ?>
  </body>

  </html>
<?php
} ?>