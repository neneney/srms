<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid']) == 0) {
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
    $parent_lastname = $_POST['parent-lastname'];
    $parent_firstname = $_POST['parent-firstname'];
    $parent_middlename = $_POST['parent-middlename'];
    $parent_suffix = $_POST['parent-suffix'];
    $relation = $_POST['relation'];
    $occupation = $_POST['occupation'];
    $email = $_POST['email'];
    $semail = $_POST['semail'];
    $sphone = $_POST['sphone'];
    $last_school = $_POST['last_school'];
    $phone = $_POST['phone'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $village = $_POST['village'];
    $strand = $_POST['strand'];
    $photo = $_FILES["photo"]["name"];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "studentimages/" . $_FILES["photo"]["name"]);

    if (!empty($_POST['elementary-level'])) {
      $gradelevel = $_POST['elementary-level'];
    } else if (!empty($_POST['jhs-level'])) {
      $gradelevel = $_POST['jhs-level'];
    } else if (!empty($_POST['shs-level'])) {
      $gradelevel = $_POST['shs-level'];
    } else {
      $gradelevel = null;
    }

    if (!empty($_POST['elementary-class'])) {
      $class_id = $_POST['elementary-class'];
    } else if (!empty($_POST['jhs-class'])) {
      $class_id = $_POST['jhs-class'];
    } else if (!empty($_POST['shs-class'])) {
      $class_id = $_POST['shs-class'];
    } else {
      $class_id = null;
    }
    $program = $_POST['program'];

    try {
      $dbh->beginTransaction();

      $sql_parent = "INSERT INTO parent (last_name, first_name, middle_name, suffix, relationship, occupation, email, `contact-no`) VALUES (:parent_lastname, :parent_firstname, :parent_middlename, :parent_suffix, :relation, :occupation, :email, :phone)";
      $query_parent = $dbh->prepare($sql_parent);
      $query_parent->bindParam(':parent_lastname', $parent_lastname, PDO::PARAM_STR);
      $query_parent->bindParam(':parent_firstname', $parent_firstname, PDO::PARAM_STR);
      $query_parent->bindParam(':parent_middlename', $parent_middlename, PDO::PARAM_STR);
      $query_parent->bindParam(':parent_suffix', $parent_suffix, PDO::PARAM_STR);
      $query_parent->bindParam(':relation', $relation, PDO::PARAM_STR);
      $query_parent->bindParam(':occupation', $occupation, PDO::PARAM_STR);
      $query_parent->bindParam(':email', $email, PDO::PARAM_STR);
      $query_parent->bindParam(':phone', $phone, PDO::PARAM_STR);
      $query_parent->execute();

      $parent_id = $dbh->lastInsertId();

      $sql_student = "INSERT INTO students (studentno, `last-name`, `first-name`, `middle-name`, suffix, age, gender, email, phone, parent_id, province, city, barangay, `village-house-no`, studentImage, last_school) 
            VALUES (:studentno, :lastname, :firstname, :middlename, :suffix, :age, :sex, :semail, :sphone, :parent_id, :province, :city, :barangay, :village, :photo, :last_school)";
      $query_student = $dbh->prepare($sql_student);
      $query_student->bindParam(':studentno', $studentno, PDO::PARAM_STR);
      $query_student->bindParam(':lastname', $lastname, PDO::PARAM_STR);
      $query_student->bindParam(':firstname', $firstname, PDO::PARAM_STR);
      $query_student->bindParam(':middlename', $middlename, PDO::PARAM_STR);
      $query_student->bindParam(':suffix', $suffix, PDO::PARAM_STR);
      $query_student->bindParam(':age', $age, PDO::PARAM_INT);
      $query_student->bindParam(':sex', $sex, PDO::PARAM_STR);
      $query_student->bindParam(':semail', $semail, PDO::PARAM_STR);
      $query_student->bindParam(':sphone', $sphone, PDO::PARAM_STR);
      $query_student->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
      $query_student->bindParam(':province', $province, PDO::PARAM_STR);
      $query_student->bindParam(':city', $city, PDO::PARAM_STR);
      $query_student->bindParam(':barangay', $barangay, PDO::PARAM_STR);
      $query_student->bindParam(':village', $village, PDO::PARAM_STR);
      $query_student->bindParam(':photo', $photo, PDO::PARAM_STR);
      $query_student->bindParam(':last_school', $last_school, PDO::PARAM_STR);
      $query_student->execute();

      if (isset($class_id)) {
        $class_sql = "INSERT INTO class_enrollment (student_id, class_id) VALUES (:studentno, :class_id)";
        $query_class = $dbh->prepare($class_sql);
        $query_class->bindParam(':studentno', $studentno, PDO::PARAM_STR);
        $query_class->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $query_class->execute();
      }

      if (!empty($program)) {
        $course_sql = "INSERT INTO course_enrollment (student_id, course_code) VALUES (:studentno, :program)";
        $query_course = $dbh->prepare($course_sql);
        $query_course->bindParam(':studentno', $studentno, PDO::PARAM_STR);
        $query_course->bindParam(':program', $program, PDO::PARAM_STR);
        $query_course->execute();
      }

      $dbh->commit();

      echo "<script>alert('Student has been registered.');</script>";
    } catch (Exception $e) {
      $dbh->rollBack();
      $error_message = $e->getMessage();
      echo $error_message;
      echo "<script>alert('Something Went Wrong. Please try again.');</script>";
    }
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
                <form role="form" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
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
                        <input type="text" class="form-control" id="semail" name="semail" placeholder="Email">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="sphone">Phone Number</label>
                        <input type="text" class="form-control" id="sphone" name="sphone" placeholder="Phone Number">
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="studentno">Last School Attended</label>
                        <input type="text" class="form-control" id="last_school" name="last_school" placeholder="Enter Last School Attended" required>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="grade">Student Educational Level</label>
                        <select class="form-control" id="levels" name="levels">
                          <option value="">Select Educational Level</option>
                          <option value="elementary">Elementary</option>
                          <option value="Junior High">Junior High School</option>
                          <option value="Senior High">Senior High School</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3" id="elementaryGrades" style="display:none;">
                        <label for="elementaryGrade">Grade Levels</label>
                        <select class="form-control" id="elementaryGrade" name="elementary-level">
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
                        <select class="form-control" id="middleGrade" name="jhs-level">
                          <option value="">Select Grade</option>
                          <option value="Grade 7">Grade 7</option>
                          <option value="Grade 8">Grade 8</option>
                          <option value="Grade 9">Grade 9</option>
                          <option value="Grade 10">Grade 10</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3" id="highGrades" style="display:none;">
                        <label for="highGrade">Grade Levels</label>
                        <select class="form-control" id="highGrade" name="shs-level">
                          <option value="">Select Grade</option>
                          <option value="Grade 11">Grade 11</option>
                          <option value="Grade 12">Grade 12</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3" id="elementaryClass" style="display:none;">
                        <label for="elementaryClasses">Class/Section</label>
                        <select class="form-control" id="elementaryClasses" name="elementary-class">
                          <option value="">Select Class/Section</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3" id="middleClass" style="display:none;">
                        <label for="middleClasses">Class/Section</label>
                        <select class="form-control" id="middleClasses" name="jhs-class">
                          <option value="">Select Class/Section</option>
                        </select>
                      </div>

                      <div class="form-group col-md-3" id="highClass" style="display:none;">
                        <label for="highClasses">Class/Section</label>
                        <select class="form-control" id="highClasses" name="shs-class">
                          <option value="">Select Class/Section</option>
                        </select>
                      </div>

                    </div>
                    <div class="row">
                      <div class="form-group col-md-3" id="programs">
                        <label for="program">Vocational Course/Program</label>
                        <select class="form-control" id="program" name="program">
                          <option value="">Select Course/Program</option>
                          <?php foreach ($programs as $program) { ?>
                            <option value="<?php echo $program['course-code']; ?>"><?php echo $program['name']; ?></option>
                          <?php } ?>
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
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="nextphone">Phone Number</label>
                        <input type="text" class="form-control" id="nextphone" name="phone" placeholder="Phone Number">
                      </div>
                      <div class="form-group col-md-2">
                        <label for="occupation">Ocupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" required>
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



</body>
<script defer src="build/js/add_student.js"></script>

</html>
<?php
?>