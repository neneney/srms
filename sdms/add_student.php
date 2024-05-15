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
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $suffix = $_POST['suffix'];
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
    $sql = "INSERT INTO students (studentno, `last-name`, `first-name`, `middle-name`, suffix , age, gender, email, program, parentName, relation, occupation, province, city, barangay, `village-house-no`, contactno, nextphone, studentImage) VALUES (:studentno, :lastname, :firstname, :middlename, :suffix, :age, :sex, :email, :program, :parentname, :relation, :occupation, :country, :district, :state, :village, :phone, :nextphone, :photo)";
    $query = $dbh->prepare($sql);

    // Bind parameters
    $query->bindParam(':studentno', $studentno, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $query->bindParam(':middlename', $middlename, PDO::PARAM_STR);
    $query->bindParam(':suffix', $suffix, PDO::PARAM_STR);
    $query->bindParam(':age', $age, PDO::PARAM_INT);
    $query->bindParam(':sex', $sex, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':program', $program, PDO::PARAM_STR);
    $query->bindParam(':parentname', $parentname, PDO::PARAM_STR);
    $query->bindParam(':relation', $relation, PDO::PARAM_STR);
    $query->bindParam(':occupation', $occupation, PDO::PARAM_STR);
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
                  <form role="form" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <span style="color: brown">
                        <h5>Student details</h5>
                      </span>
                      <hr>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="studentno">Student ID</label>
                          <input type="text" class="form-control" id="studentno" name="studentno" placeholder="Enter student No" required>
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
                          <label for="age">Age</label>
                          <input type="number" class="form-control" id="age" name="age" placeholder="age" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="sex">Sex</label>
                          <select type="select" class="form-control" id="sex" name="sex" required>
                            <option>Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4">
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
                          <label for="grade">Educational Level</label>
                          <select class="form-control" id="levels" name="levels" required>
                            <option value="">Select Educational Level</option>
                            <option value="elementary">Elementary</option>
                            <option value="Junior High">Junior High School</option>
                            <option value="Senior High">Senior High School</option>
                            <option value="Vocational">Vocational Level</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3" id="programs" style="display:none;">
                          <label for="program">Vocational Course/Program</label>
                          <select class="form-control" id="program" name="gradeLevel" required>
                            <option>Select Course/Program</option>
                            <?php foreach ($programs as $program) { ?>
                              <option value="<?php echo $program['name']; ?>"><?php echo $program['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group col-md-3" id="elementaryGrades" style="display:none;">
                          <label for="elementaryGrade">Grade Levels</label>
                          <select class="form-control" id="elementaryGrade" name="gradeLevel">
                            <option value="">Select Grade</option>
                            <option value="Grade 1">Grade 1</option>
                            <option value="Grade 2">Grade 2</option>
                            <option value="Grade 3">Grade 3</option>
                            <option value="Grade 4">Grade 4</option>
                            <option value="Grade 5">Grade 5</option>
                            <option value="Grade 6">Grade 6</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3" id="middleGrades" style="display:none;">
                          <label for="middleGrade">Grade Levels</label>
                          <select class="form-control" id="middleGrade" name="gradeLevel">
                            <option value="">Select Grade</option>
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3" id="highGrades" style="display:none;">
                          <label for="highGrade">Grade Levels</label>
                          <select class="form-control" id="highGrade" name="gradeLevel">
                            <option value="">Select Grade</option>
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4" id="strand" style="display:none;">
                          <label for="strand">Strand</label>
                          <select class="form-control" id="strand" name="strand">
                            <option value="">Select Strand</option>
                            <option value="abm">ABM - Accountancy, Business and Management </option>
                            <option value="stem">STEM - Science, Technology, Engineering and Mathematics (STEM)</option>
                            <option value="humss">HUMSS - Humanities and Social Sciences </option>
                            <option value="gas">GAS - General Academic Strand </option>
                            <option value="ict">ICT - Information Communication Technology </option>
                            <option value="he">HE - Home Economics </option>
                          </select>
                        </div>
                      </div>
                      <div class="row">


                      </div>
                      <hr>
                      <span style="color: brown">
                        <h5>Parent/Guardian details</h5>
                      </span>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="parent-f-name">Last Name</label>
                          <input type="text" class="form-control" id="parentname" name="parent-l-name" placeholder="Enter Last Name" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="parent-l-name">First Name</label>
                          <input type="text" class="form-control" id="parentname" name="parent-f-name" placeholder="Enter First Name" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="parent-m-name">Middle Name</label>
                          <input type="text" class="form-control" id="parentname" name="parent-m-name" placeholder="Enter Middle Name" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="parent-suffix">Suffix</label>
                          <input type="text" class="form-control" id="parentname" name="parent-suffix" placeholder="Enter Suffix" required>
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
                            <option value="Other">Other</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="nextphone">Phone Number</label>
                          <input type="text" class="form-control" id="nextphone" name="nextphone" placeholder="Phone Number" required>
                        </div>
                      </div>
                      <div class="row">
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
      <?php @include("includes/foot.php"); ?>
    </div>

    <!-- ./wrapper -->
    <script>
      document.getElementById('levels').addEventListener('change', function() {
        const selectedGrade = this.value;
        document.getElementById('elementaryGrades').style.display = 'none';
        document.getElementById('middleGrades').style.display = 'none';
        document.getElementById('highGrades').style.display = 'none';
        document.getElementById('strand').style.display = 'none';
        document.getElementById('programs').style.display = 'none';

        if (selectedGrade === 'elementary') {
          document.getElementById('elementaryGrades').style.display = 'block';
          document.getElementById('strand').style.display = 'none';
        } else if (selectedGrade === 'Junior High') {
          document.getElementById('middleGrades').style.display = 'block';
          document.getElementById('strand').style.display = 'none';
        } else if (selectedGrade === 'Senior High') {
          document.getElementById('highGrades').style.display = 'block';
          document.getElementById('strand').style.display = 'block';
        } else if (selectedGrade === "Vocational") {
          document.getElementById('programs').style = 'block';
          document.getElementById('strand').style.display = 'none';
        }
      });

      function fetchOptions(url, callback) {
        fetch(url)
          .then(response => response.json())
          .then(data => callback(data))
          .catch(error => console.error('Error fetching data:', error));
      }

      document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');

        function populateDropdown(select, options, placeholder = "Select an option") {
          select.innerHTML = `<option value="">${placeholder}</option>`;
          options.forEach(option => {
            const opt = document.createElement("option");
            opt.value = option.provCode; // Assuming provCode is the ID
            opt.textContent = option.provDesc;
            select.appendChild(opt);
          });
        }

        function fetchDropdownData(url, callback) {
          fetch(url)
            .then(response => response.json())
            .then(data => callback(data))
            .catch(error => console.error('Error fetching data:', error));
        }

        // Fetch and populate the province dropdown
        fetchDropdownData('get-province.php', function(provinces) {
          populateDropdown(provinceSelect, provinces);
        });

        provinceSelect.addEventListener('change', function() {
          const selectedProvinceId = this.value;
          citySelect.innerHTML = '<option value="">Select City</option>'; // Clear existing options

          if (selectedProvinceId) {
            // Fetch city data based on selected province ID
            fetchDropdownData(`get-cities.php?province_id=${selectedProvinceId}`, function(cities) {
              cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.citymunCode;
                option.textContent = city.citymunDesc;
                citySelect.appendChild(option);
              });
            });
          }
        });
        citySelect.addEventListener('change', function() {
          barangaySelect.innerHTML = "<option value=''>Select Barangay </option>"
          if (this.value) {
            fetchDropdownData(`get-barangay.php?city_id=${this.value}`, function(barangays) {
              barangays.forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay.brgyCode;
                option.textContent = barangay.brgyDesc;
                barangaySelect.appendChild(option);
              });
            });
          }
        });

      });
    </script>
  </body>

  </html>
<?php
} ?>