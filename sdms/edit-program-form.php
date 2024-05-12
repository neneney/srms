<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['update'])) {
  $eid = $_SESSION['edid'];
  $name = $_POST['name'];
  $program_type = $_POST['program_type'];

  $sql = "UPDATE programs SET name=:name, program_type=:program_type WHERE ID=:eid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':name', $name, PDO::PARAM_STR);
  $query->bindParam(':program_type', $program_type, PDO::PARAM_STR);
  $query->bindParam(':eid', $eid, PDO::PARAM_STR);
  $query->execute();
  echo '<script>alert("Updated successfully")</script>';
  echo "<script>window.location.href ='program_list.php'</script>";
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
          <label for="name">Program Name</label>
          <input type="text" name="name" class="form-control" id="name" value="<?php echo $row['name']; ?>" required>
        </div>
        <div class="form-group col-md-6">
          <label for="program_type">Program Type</label>
          <select name="program_type" class="form-control" id="program_type" required>
            <option value="">Select Program Type</option>
            <option value="General Education" <?php if ($row['program_type'] == 'General Education') echo 'selected'; ?>>General Education</option>
            <option value="Specialized" <?php if ($row['program_type'] == 'Specialized') echo 'selected'; ?>>Specialized</option>
            <option value="Technical and Vocational Course" <?php if ($row['program_type'] == 'Technical and Vocational Course') echo 'selected'; ?>>Technical and Vocational Course</option>
            <option value="Professional Development Courses" <?php if ($row['program_type'] == 'Professional Development Courses') echo 'selected'; ?>>Professional Development Courses</option>
            <!-- Add more options as needed -->
          </select>
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