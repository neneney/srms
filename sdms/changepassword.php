<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
  }
?>

  <?php @include("includes/head.php"); ?>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <?php @include("includes/header.php"); ?>
      <!-- /.navbar -->
      <!-- Side bar and Menu -->
      <?php @include("includes/sidebar.php"); ?>
      <!-- /.sidebar and menu -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper ">
        <br>
        <div class="card pt-3" style="display: flex; align-items: center; justify-content: center;">
          <div class="col-md-10">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <div class="card-body">
                <div class="d-flex flex-row align-items-center back"><i style="cursor: pointer;" id="backbtn" class="fa fa-long-arrow-left mr-1 mb-1"></i>
                </div>
                <!-- Date -->

                <form role="form" id="changePass" method="post" enctype="multipart/form-data" class="form-horizontal">

                  <div class="card-body">
                    <div class="alert alert-success" style="display: none;">
                    </div>
                    <div class="alert alert-danger" style="display: none;">
                    </div>
                    <div class="form-group  ">
                      <label for="exampleInputPassword1">Current Password</label>
                      <input type="hidden" name="Id" value="<?php echo $_SESSION['sid'] ?>">
                      <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                    </div>
                    <div class="form-group  ">
                      <label for="exampleInputPassword1">New Password</label>
                      <input type="password" name="password1" class="form-control" id="exampleInputPassword1" required>
                    </div>
                    <div class="form-group ">
                      <label for="exampleInputPassword1">Confirm password</label>
                      <input type="password" name="password2" class="form-control" id="exampleInputPassword1">
                    </div>
                  </div>
              </div>
              <div class="modal-footer text-right">
                <!-- <button class="btn btn-info" onclick="goBack()">Back</button> -->
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>

              </form>

            </div>

            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
    </div>
    <!-- /.content-wrapper -->
    <?php @include("includes/footer.php"); ?>
    <?php @include("includes/foot.php"); ?>
    <script>
      var back = document.getElementById('backbtn');
      back.addEventListener('click', goBack);

      function goBack() {
        window.history.back();
      }

      document.getElementById("changePass").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/changepass.php", true);
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
  </body>

  </html>
<?php
} ?>