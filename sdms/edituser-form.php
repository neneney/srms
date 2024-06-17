<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


?>
<div class="card-body">
  <form role="form" id="editUser" method="post" enctype="multipart/form-data" class="form-horizontal">
    <?php
    $eid = $_POST['edit_id'];
    $sql = "SELECT * from tblusers   where id=:eid ";
    $query = $dbh->prepare($sql);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
      foreach ($results as $row) {
        $_SESSION['edid'] = $row->id;
    ?>
        <div class="alert alert-success" style="display: none;">
        </div>
        <div class="alert alert-danger" style="display: none;">
        </div>
        <div class="row">
          <div class="form-group col-md-6 ">
            <label for="name">First Name</label>
            <input type="hidden" name="rowId" value="<?php echo $row->id ?>">
            <input type="text" name="name" class="form-control" id="name" value="<?php echo $row->name; ?>" required>
          </div>
          <div class="form-group col-md-6 ">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo $row->lastname; ?>" required>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6 ">
            <label for="username">User Name</label>
            <input type="text" name="username" class="form-control" id="username" value="<?php echo $row->username; ?>">
          </div>
          <div class="form-group col-md-6 ">
            <label for="permission">Permission</label>
            <input type="text" name="permission" class="form-control" id="permission" value="<?php echo $row->permission; ?>" readonly="" required>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label for="feFirstName">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" value="">
          </div>
          <div class="form-group col-md-6">
            <label for="feLastName">Confirm Password</label>
            <input type="password" name="password1" class="form-control" placeholder="Confirm Password" value="">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label for="sex">Sex</label>
            <select name="sex" class="form-control" required>
              <option value="Male" <?php if ($row->sex == 'Male') echo 'selected'; ?>>Male</option>
              <option value="Female" <?php if ($row->sex == 'Female') echo 'selected'; ?>>Female</option>
            </select>
          </div>
        </div>
    <?php
      }
    } ?>

    <div class="modal-footer text-right" style="float: right;">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="submit" name="update" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
<script>
  document.getElementById("editUser").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/edituser.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          try {
            var response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
              // Show success alert
              var successAlert = document.querySelectorAll(".alert-success");
              successAlert[1].innerHTML = response.message;
              successAlert[1].style.display = "block";
              setTimeout(function() {
                successAlert[1].style.display = "none";
                location.reload();
              }, 3000);
            } else if (response.status === "error") {
              // Show error alert
              var errorAlert = document.querySelectorAll(".alert-danger");
              errorAlert[1].innerHTML = response.message;
              errorAlert[1].style.display = "block";
              setTimeout(function() {
                errorAlert[1].style.display = "none";
              }, 3000);
            } else {
              // Show a generic error message if the response is not properly formatted
              var genericErrorAlert = document.querySelectorAll(".alert-danger");
              genericErrorAlert[1].innerHTML = "Unexpected response from server. Please try again.";
              genericErrorAlert[1].style.display = "block";
              setTimeout(function() {
                genericErrorAlert[1].style.display = "none";
              }, 3000);
            }
          } catch (error) {
            // Log the error to the console
            console.error("Error parsing JSON response:", error);

            // Show a generic error message if there's an issue parsing the JSON response
            var parseErrorAlert = document.querySelectorAll(".alert-danger");
            parseErrorAlert[1].innerHTML = "Error occurred while processing server response: " + error.message;
            parseErrorAlert[1].style.display = "block";
            setTimeout(function() {
              parseErrorAlert.style.display = "none";
            }, 3000);
          }
        } else {
          // Show error alert if there is any issue with the Ajax request
          var requestErrorAlert = document.querySelectorAll(".alert-danger");
          requestErrorAlert[1].innerHTML = "Error occurred while processings your request. Please try again.";
          requestErrorAlert[1].style.display = "block";
          setTimeout(function() {
            requestErrorAlert[1].style.display = "none";
          }, 3000);
        }
      }
    };
    xhr.send(formData);
  });
</script>