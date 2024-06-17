<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
} else {
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
      <div class="content-wrapper">
        <br>
        <div class="col-lg-12">
          <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Update User Profile</h6>
            </div>
            <div class="card-body">
              <form method="post" id="profileForm">

                <?php
                $eid = $_SESSION['sid'];
                $sql = "SELECT * from tblusers   where id=:eid ";
                $query = $dbh->prepare($sql);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                $cnt = 1;
                if ($query->rowCount() > 0) {
                  foreach ($results as $row) {
                ?>
                    <div class="container rounded bg-white mt-5">
                      <div class="row">
                        <div class="col-md-4 border-right">
                          <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <?php
                            if ($row->userimage == "avatar15.jpg") { ?>
                              <img class="rounded-circle mt-5" src="staff_images/avatar15.jpg" width="90">
                            <?php
                            } else { ?>
                              <img class="rounded-circle mt-5" src="staff_images/<?php echo $row->userimage; ?>" width="90">
                            <?php
                            } ?><span class="font-weight-bold"><?php echo $row->name; ?> <?php echo $row->lastname; ?></span><span class="text-black-50"><?php echo $row->email; ?></span><span><?php echo $row->mobilenumber; ?></span>
                            <div class="mt-3">
                              <a href="update_userimage.php?id=<?php echo $id; ?>">Edit Image</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                              <div class="d-flex flex-row align-items-center back"><i style="display: none;" class="fa fa-long-arrow-left mr-1 mb-1"></i>
                              </div>
                              <a href="changepassword.php" class="text-right">Change Password</a>
                            </div>
                            <div class="alert alert-success" style="display: none;">
                            </div>
                            <div class="alert alert-danger" style="display: none;">
                            </div>
                            <div class="row mt-2">
                              <div class="col-md-6"><input type="text" class="form-control" name="firstname" value="<?php echo $row->name; ?>" required='true'></div>
                              <div class="col-md-6"><input type="text" class="form-control" value="<?php echo $row->lastname; ?> " name="lastname" required></div>
                            </div>
                            <div class="row mt-3">
                              <div class="col-md-6">
                                <label class="form-group">User Name</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $row->username; ?>" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-group">Permission</label>
                                <input type="text" class="form-control" name="permission" value="<?php echo $row->permission; ?>" readonly="true">
                              </div>
                            </div>

                            <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit" name="submit">Update Profile</button></div>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php
                  }
                } ?>
              </form>
            </div>
          </div>
        </div>

        <!-- /.content-header -->
      </div>
      <!-- /.content-wrapper -->
      <?php @include("includes/foot.php"); ?>
      <?php @include("includes/footer.php"); ?>
      <script>
        document.getElementById("profileForm").addEventListener("submit", function(event) {
          event.preventDefault(); // Prevent form submission
          var formData = new FormData(this);

          var xhr = new XMLHttpRequest();
          xhr.open("POST", "ajax/profile_update.php", true);
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