  <?php
  session_start();
  error_reporting(0);
  include('includes/dbconnection.php');
  if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
  }
  if (isset($_GET['del'])) {
    mysqli_query($con, "delete from students where id = '" . $_GET['id'] . "'");
    $_SESSION['delmsg'] = "student deleted !!";
  }
  ?>
  <!DOCTYPE html>
  <html>
  <?php @include("includes/head.php"); ?>
  <style>
    .enlarged-image {
      width: 500px;
      height: auto;
      cursor: pointer;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>

  <body class="hold-transition sidebar-mini">
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
                <h1>Student Details</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Manange Students</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Manage Students</h3>
                    <div class="card-tools">
                      <a href="add_student.php"><button type="button" class="btn btn-sm btn-primary"><span style="color: #fff;"><i class="fas fa-plus"></i> New Students</span>
                        </button> </a>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div id="editData" class="modal fade">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Student details</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="info_update">
                          <?php @include("edit_student.php"); ?>
                        </div>
                        <div class="modal-footer ">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  </div>
                  <!--   end modal -->

                  <div id="editData2" class="modal fade">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Student Details</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="info_update2">
                          <?php @include("view_student_info.php"); ?>
                        </div>
                        <div class="modal-footer ">

                          <div class="modal-footer">
                            <!-- Print Button -->
                            <button type="button" class="btn btn-primary" onclick="printCert()">Print Certificate</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  </div>
                  <!--   end modal -->


                  <div class="card-body mt-2 ">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Student Image</th>
                          <th>Student Number</th>
                          <th>Student Name</th>

                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $query = mysqli_query($con, "select * from students order by postingDate desc");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td><?php echo htmlentities($cnt); ?></td>
                            <td style="text-align: center;" class="align-middle">
                              <a href="#" onclick="toggleImageSize(event)">
                                <img id="studentImage" src="studentimages/<?php echo htmlentities($row['studentImage']); ?>" width="40" height="40">
                              </a>
                            </td>
                            <td style="text-align: center;"><?php echo htmlentities($row['studentno']); ?></td>
                            <td style="text-align: center;"><?php echo htmlentities($row['studentName']); ?>
                              <?php
                              // Fetch and concatenate the student's name parts
                              $fullName = htmlentities($row['first-name']) . ' ' .
                                htmlentities($row['middle-name']) . ' ' .
                                htmlentities($row['last-name']) . ' ' .
                                htmlentities($row['suffix']);
                              // Display the concatenated full name
                              echo $fullName;
                              ?></td>

                            <td style="text-align: center;">
                              <button class=" btn btn-primary btn-sm edit_data" id="<?php echo  $row['id']; ?>" title="click for edit">Edit</i></button>
                              <button class=" btn btn-success btn-sm edit_data2" id="<?php echo  $row['id']; ?>" title="click for edit">View</i></button>
                              <a href="student_list.php?id=<?php echo $row['id'] ?>&del=delete" onClick="return confirm('Are you sure you want to delete?')" class=" btn btn-danger btn-sm ">Delete</a>

                            </td>
                          </tr>
                        <?php $cnt = $cnt + 1;
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

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>

    <!-- ./wrapper -->
    <?php @include("includes/foot.php"); ?>
    <script defer src="build/js/student_list.js"></script>
  </body>

  </html>