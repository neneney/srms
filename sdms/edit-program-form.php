<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['update'])) {
  $eid = $_SESSION['edid'];
  $name = $_POST['name'];
  $code = $_POST['code'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $teacher = $_POST['teacher'];

  // Perform any necessary validation here before updating the database
  if (empty($name) || empty($code) || empty($start_date) || empty($end_date) || empty($teacher)) {
    echo '<script>alert("All fields are required")</script>';
  } else {
    $sql = "UPDATE programs SET name=:name, `course-code`=:code, start_date=:start_date, end_date=:end_date, teacher=:teacher WHERE ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':code', $code, PDO::PARAM_STR);
    $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);

    if ($query->execute()) {
      echo '<script>alert("Updated successfully")</script>';
      echo "<script>window.location.href ='program_list.php'</script>";
    } else {
      echo '<script>alert("Something went wrong. Please try again")</script>';
    }
  }
}
?>

<div class="card-body">
  <form role="form" method="post" enctype="multipart/form-data" class="form-horizontal">

    <?php
    $eid = $_POST['edit_id'];
    $sql = "SELECT * FROM programs WHERE ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $_SESSION['edid'] = $row['ID'];
    ?>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="code">Course Code</label>
          <input id="code" type="text" name="code" class="form-control" placeholder="Course Code" value="<?php echo $row['course-code']; ?>" required readonly>
        </div>
        <div class="form-group col-md-6">
          <label for="feFirstName">Course Title</label>
          <input type="text" name="name" class="form-control" placeholder="Course Name" value="<?php echo $row['name']; ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="start_date">Starting Date</label>
          <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Starting Date" value="<?php echo $row['start_date']; ?>" required>
        </div>
        <div class="form-group col-md-6">
          <label for="end_date">End Date</label>
          <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Ending Date" value="<?php echo $row['end_date']; ?>" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="teacher">Teacher/Instructor</label>
          <input id="teacher" type="text" name="teacher" class="form-control" placeholder="Teacher/Instructor" value="<?php echo $row['teacher']; ?>" required>
        </div>
      </div>
    <?php
    }
    ?>
    <div class="modal-footer text-right" style="float: right;">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="submit" name="update" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>