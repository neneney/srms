<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
  $password1 = ($_POST['password']);
  $password2 = ($_POST['password1']);

  if ($password1 != $password2) {
    echo "<script>alert('Password and Confirm Password Field do not match  !!');</script>";
  } else {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $permission = $_POST['permission'];
    $sex = $_POST['sex']; // New line for handling sex input
    $password = md5($_POST['password']);
    $status = 1;

    // Check if username already exists
    $sql_check_username = "SELECT COUNT(*) FROM tblusers WHERE username = :username";
    $query_check_username = $dbh->prepare($sql_check_username);
    $query_check_username->bindParam(':username', $username, PDO::PARAM_STR);
    $query_check_username->execute();
    $count_username = $query_check_username->fetchColumn();

    if ($count_username > 0) {
      echo "<script>alert('Username already exists. Please choose a different username');</script>";
    } else {
      // Insert new user if username is available
      $sql = "INSERT INTO tblusers(name, username, password, status, sex, lastname, permission) VALUES(:name, :username, :password, :status, :sex, :lastname, :permission)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':name', $name, PDO::PARAM_STR);
      $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
      $query->bindParam(':sex', $sex, PDO::PARAM_STR);
      $query->bindParam(':status', $status, PDO::PARAM_STR);
      $query->bindParam(':username', $username, PDO::PARAM_STR);
      $query->bindParam(':permission', $permission, PDO::PARAM_STR);
      $query->bindParam(':password', $password, PDO::PARAM_STR);
      $query->execute();
      $lastInsertId = $dbh->lastInsertId();

      if ($lastInsertId) {
        echo "<script>alert('Registered successfully');</script>";
        echo "<script>window.location.href ='userregister.php'</script>";
      } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
      }
    }
  }
}
?>


<form role="form" id="" method="post" enctype="multipart/form-data" class="form-horizontal">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-6">
        <label for="feFirstName">First Name</label>
        <input type="text" name="name" class="form-control" placeholder="First Name" value="" required>
      </div>
      <div class="form-group col-md-6">
        <label for="feLastName">Lastname</label>
        <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="feLastName">Username</label>
        <input type="text" name="username" class="form-control no-capitalize" placeholder="Username" value="" required>
      </div>
      <div class="form-group col-md-6">
        <label class="" for="register1-email">Permission:</label>
        <select name="permission" class="form-control" required>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="feFirstName">Sex</label>
        <select name="sex" class="form-control" required>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="feFirstName">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="feLastName">Confirm Password</label>
        <input type="password" name="password1" class="form-control" placeholder="Confirm Password" value="" required>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="modal-footer text-right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</form>