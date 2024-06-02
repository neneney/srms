<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $code = $_POST['code'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $teacher = $_POST['teacher'];

  $sql = "INSERT INTO programs (name, `course-code`, start_date, end_date, teacher) 
            VALUES (:name, :code, :start_date, :end_date, :teacher)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':name', $name, PDO::PARAM_STR);
  $query->bindParam(':code', $code, PDO::PARAM_STR);
  $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
  $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
  $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);

  if ($query->execute()) {
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
      <div class="form-group col-md-6">
        <label for="code">Course Code</label>
        <input id="code" type="text" name="code" class="form-control" placeholder="Course Code" value="" required readonly>
      </div>
      <div class="form-group col-md-6 ">
        <label for="feFirstName">Course Title</label>
        <input type="text" name="name" class="form-control" placeholder="Course Name" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="start_date">Starting Date</label>
        <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Starting Date" value="" required>
      </div>
      <div class="form-group col-md-6">
        <label for="end_date">End Date</label>
        <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Ending Date" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="teacher">Teacher/Instructor</label>
        <input id="code" type="text" name="teacher" class="form-control" placeholder="Teacher/Instructor" value="" required>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="modal-footer text-right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</form>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var currentYear = new Date().getFullYear().toString();
    var randomNumber = Math.floor(10000 + Math.random() * 90000);
    var code = currentYear + randomNumber;
    document.getElementById("code").value = code;
  });
</script>