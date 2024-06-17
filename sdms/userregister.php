<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
}
if ($_SESSION['permission'] !== "Admin") {
  header('location: dashboard.php');
}
if (isset($_GET['delid'])) {
  $rid = intval($_GET['delid']);
  $sql = "update tblusers set status='0' where id=:rid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':rid', $rid, PDO::PARAM_STR);
  $query->execute();
  echo "<script>window.location.href = 'userregister.php'</script>";
}
?>
<?php @include("includes/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
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
              <!-- <h1>DataTables</h1> -->
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Register</li>
              </ol>
            </div>
          </div>
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <?php
                  $sql = "SELECT id from tblusers";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $count = $query->rowCount();
                  ?>
                  <h3 class=""><?php echo htmlentities($count); ?></h3>
                  <p>Total Users</p>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <?php
                  $sql = "SELECT id from tblusers where sex='Male'";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $count = $query->rowCount();
                  ?>
                  <h3 class=""><?php echo htmlentities($count); ?></h3>
                  <p>Male</p>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <?php
                  $sql = "SELECT id from tblusers where sex='Female'";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $count = $query->rowCount();
                  ?>
                  <h3 class=""><?php echo htmlentities($count); ?></h3>
                  <p>Female</p>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <?php
                  $sql = "SELECT id from tblusers  where status='1'";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $count = $query->rowCount();
                  ?>
                  <h3 class=""><?php echo htmlentities($count); ?></h3>

                  <p>Active Users</p>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section><!-- /.section -->
      <!-- /.content-wrapper -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="">

          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Register New user</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#delete"></i> See blocked users
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deposit"><i class="fas fa-plus"></i> Register New User
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="modal fade" id="deposit">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Register New User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- <p>One fine body&hellip;</p> -->
                        <?php @include("newuser-form.php"); ?>
                      </div>
                      <!-- <div class="modal-footer ">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div> -->
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <div class="modal fade" id="delete">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Blocked User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- <p>One fine body&hellip;</p> -->
                        <?php @include("blockedusers.php"); ?>
                      </div>
                      <div class="modal-footer ">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <div id="editData" class="modal fade">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit User's Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="info_update">
                        <!-- <p>One fine body&hellip;</p> -->
                        <?php @include("edituser-form.php"); ?>
                      </div>

                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                </div>

                <div class="card-body">
                  <!-- Block User Modal -->
                  <div class="modal fade" id="blockModal" tabindex="-1" role="dialog" aria-labelledby="blockModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="blockModalLabel">Confirm Block</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Do you really want to block this user?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                          <a href="#" id="confirmBlock" class="btn btn-danger">Block</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Permission</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $aid = $_SESSION['cpmsaid'];
                      $usertype = $_SESSION['usertype'];
                      $property = $_SESSION['property'];
                      $sql = "SELECT * from tblusers where status='1'";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);

                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                          <tr>
                            <td class="text-center"><?php echo htmlentities($row->name); ?> <?php echo htmlentities($row->lastname); ?></td>
                            <td class="text-center"><?php echo htmlentities($row->username); ?></td>
                            <td class="text-center"><?php echo htmlentities($row->permission); ?></td>
                            <td class="text-center">
                              <a style="color:white;" class="btn btn-primary btn-sm edit_data" id="<?php echo ($row->id); ?>" title="click for edit">Edit</a>
                              <a class="btn btn-danger btn-sm text-center block-btn" href="#" data-id="<?php echo ($row->id); ?>" title="click for block">Block</a>
                            </td>
                          </tr>

                      <?php
                        }
                      } ?>
                    </tbody>

                  </table>
                </div>
                <!-- /.card-body -->
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php @include("includes/foot.php"); ?>
  <!-- page script -->
  <script type="text/javascript">
    $(document).ready(function() {
      $(document).on('click', '.edit_data', function() {
        var edit_id = $(this).attr('id');
        $.ajax({
          url: "edituser-form.php",
          type: "post",
          data: {
            edit_id: edit_id
          },
          success: function(data) {
            $("#info_update").html(data);
            $("#editData").modal('show');
          }
        });
      });
    });
    document.addEventListener('DOMContentLoaded', function() {
      // Get all input elements of type text
      var textInputs = document.querySelectorAll('input[type="text"]');

      // Function to capitalize the first letter of each word
      function capitalizeWords(input) {
        if (input.classList.contains('no-capitalize')) {
          return; // Do nothing if the input has the class 'no-capitalize'
        }
        let words = input.value.split(' ');
        for (let i = 0; i < words.length; i++) {
          if (words[i].length > 0) {
            words[i] = words[i][0].toUpperCase() + words[i].substring(1);
          }
        }
        input.value = words.join(' ');
      }

      // Add event listeners to each text input element
      textInputs.forEach(function(input) {
        input.addEventListener('input', function() {
          capitalizeWords(input);
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Attach click event listener to all block buttons
      document.querySelectorAll('.block-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
          event.preventDefault(); // Prevent default link behavior
          var userId = this.getAttribute('data-id');
          // Update the confirmBlock button href with the correct user ID
          document.getElementById('confirmBlock').setAttribute('href', 'userregister.php?delid=' + userId);
          // Show the modal
          $('#blockModal').modal('show');
        });
      });
    });
  </script>

</body>

</html>