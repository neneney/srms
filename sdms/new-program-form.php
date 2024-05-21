<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $type = $_POST['type'];
  $code = $_POST['code'];

  $sql = "INSERT INTO programs (name, `course-code`,  program_type) VALUES (:name,:code, :type)"; // Corrected column name to program_type
  $query = $dbh->prepare($sql);
  $query->bindParam(':name', $name, PDO::PARAM_STR);
  $query->bindParam(':code', $code, PDO::PARAM_STR);
  $query->bindParam(':type', $type, PDO::PARAM_STR); // Changed parameter name to match the binding
  $query->execute();
  $lastInsertId = $dbh->lastInsertId();
  if ($lastInsertId) {
    echo "<script>alert('Registered successfully');</script>";
    echo "<script>window.location.href ='program_list.php'</script>";
  } else {
    echo "<script>alert('Something went wrong. Please try again');</script>";
  }
}

?>



<form role="form" id="" method="post" enctype="multipart/form-data" class="form-horizontal">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-4 ">
        <label for="feFirstName">Course Name</label>
        <input type="text" name="name" class="form-control" placeholder="Course Name" value="" required>
      </div>
      <div class="form-group col-md-4">
        <label for="feFirstName">Course Code</label>
        <input type="text" name="code" class="form-control" placeholder="Course Code" value="" required>
      </div>
      <div class="form-group col-md-4">
        <label class="" for="register1-email">Type:</label>
        <select name="type" class="form-control" required>
          <option value="">Select Type</option>
          <option value="General Education">General Education</option>
          <option value="Specialized">Specialized</option>
          <option value="Technical and Vocational Course">Technical and Vocational Course</option>
          <option value="Professional Development Courses">Professional Development Courses</option>
        </select>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="modal-footer text-right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</form>