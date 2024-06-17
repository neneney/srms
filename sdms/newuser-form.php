<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


?>


<form role="form" id="newUser" method="post" enctype="multipart/form-data" class="form-horizontal">
  <div class="alert alert-success" style="display: none;">
  </div>
  <div class="alert alert-danger" style="display: none;">
  </div>
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
<script>
  document.getElementById("newUser").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/newuser.php", true);
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
</script>