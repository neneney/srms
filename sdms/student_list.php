<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
  header('location:logout.php');
}
$graduated_students = mysqli_query($con, "SELECT * FROM enrollment_history WHERE status = 'graduated'");
if (isset($_GET['del'])) {
  $student_id = $_GET['id'];

  // Fetch the studentno and parent_id from the students table
  $result = mysqli_query($con, "SELECT studentno, parent_id FROM students WHERE id = '$student_id'");
  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $studentno = $row['studentno'];
    $parent_id = $row['parent_id'];

    // Delete the enrollment(s) from the class_enrollment table using studentno
    $delete_enrollment_query = "DELETE FROM class_enrollment WHERE student_id = '$studentno'";
    mysqli_query($con, $delete_enrollment_query);

    // Delete the student from the students table
    $delete_student_query = "DELETE FROM students WHERE id = '$student_id'";
    mysqli_query($con, $delete_student_query);

    // Delete the parent data from the parent table
    $delete_parent_query = "DELETE FROM parent WHERE id = '$parent_id'";
    mysqli_query($con, $delete_parent_query);

    $_SESSION['delmsg'] = "Student data deleted !!";
  } else {
    $_SESSION['delmsg'] = "Error: Student not found!";
  }
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

  thead th {
    position: sticky;
    top: 0;
    background-color: white;
    /* Ensure the background color matches the table or page background */
    z-index: 1;
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
                <li class="breadcrumb-item active">Manage Students</li>
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
                  <div class="card-tools mr-3">
                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#graduatedModal"><i class="fas fa-graduation-cap"></i> Graduated Students
                    </button>
                  </div>
                </div>

                <div class="modal fade" id="graduatedModal" tabindex="-1" role="dialog" aria-labelledby="graduatedModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="graduatedModalLabel">Graduated Students</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Button to open the filter modal -->
                        <div class="text-right">
                          <button type="button" class="btn btn-primary mb-3 text-right" data-toggle="modal" data-target="#filterModal">
                            Filter
                          </button>
                        </div>
                        <div class="alert alert-success alert1" style="display: none;"></div>
                        <div class="alert alert-danger alert2" style="display: none;"></div>
                        <div style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
                          <table id="graduated-students-table" class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Student Number</th>
                                <th>Program</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Graduated at</th>
                              </tr>
                            </thead>
                            <tbody id="graduated-students-list">
                              <!-- Rows will be appended here by JavaScript -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Filter Modal -->
                <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Graduated Students</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="filter-form">
                          <div class="form-group">
                            <label for="filter-educ-level">Educational Level</label>
                            <select class="form-control" id="filter-educ-level">
                              <option value="">Select educational level</option>
                              <option value="Elementary">Elementary</option>
                              <option value="Junior Highschool">Junior High School</option>
                              <option value="senior highschool">Senior High School</option>
                              <option value="vocational">Vocational Course</option>
                              <option value="others">Others</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="filter-date-from">Graduated From</label>
                            <input type="date" class="form-control" id="filter-date-from">
                          </div>
                          <div class="form-group">
                            <label for="filter-date-to">Graduated To</label>
                            <input type="date" class="form-control" id="filter-date-to">
                          </div>
                          <button type="button" class="btn btn-primary" id="apply-filter">Apply Filter</button>
                          <button type="button" class="btn btn-secondary" id="reset-filter">Reset</button>
                        </form>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="editData" class="modal fade">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Student details</h5>
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
                    </div>
                  </div>
                </div>


                <div id="editData2" class="modal fade" id="printTable">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Student Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="info_update2" style="max-height: 80vh; overflow-y: auto;">
                        <?php @include("view_student_info.php"); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete this Student?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok">Delete</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-body mt-2 ">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="text-align: center;">Student Image</th>
                        <th style="text-align: center;">Student Number</th>
                        <th style="text-align: center;">Student Name</th>
                        <th style="text-align: center;">Student Gender</th>
                        <th style="text-align: center;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = mysqli_query($con, "SELECT * FROM students ORDER BY postingDate DESC");
                      while ($row = mysqli_fetch_array($query)) {
                      ?>
                        <tr>
                          <td style="text-align: center;" class="align-middle">
                            <a href="#" onclick="toggleImageSize(event)">
                              <img style="border-radius: 100%;" id="studentImage" src="studentimages/<?php echo htmlentities($row['studentImage']); ?>" width="40" height="40" alt="Student Image" onerror="this.onerror=null; this.src='studentimages/placeholder.jpg';">
                            </a>
                          </td>
                          <td style="text-align: center;"><?php echo htmlentities($row['studentno']); ?></td>
                          <td style="text-align: center;">
                            <?php
                            $fullName = htmlentities($row['first-name']) . ' ' .
                              htmlentities($row['middle-name']) . ' ' .
                              htmlentities($row['last-name']) . ' ' .
                              htmlentities($row['suffix']);
                            echo $fullName;
                            ?>
                          </td>
                          <td style="text-align: center;"><?php echo htmlentities($row['gender']); ?></td>
                          <td style="text-align: center;">
                            <button class="btn btn-primary btn-sm edit_data" id="<?php echo $row['id']; ?>" title="click for edit">Edit</button>
                            <button class="btn btn-success btn-sm edit_data2" id="<?php echo $row['id']; ?>" title="click for edit">View</button>
                            <?php if ($_SESSION['permission'] == "Admin") { ?>
                              <a href="#" data-href="student_list.php?id=<?php echo $row['id']; ?>&del=delete" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm">Delete</a>
                            <?php } ?>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
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
  <script>
    function printTable() {
      var printContents = document.getElementById('info_update2').innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }

    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
  </script>
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      var table = $('#graduated-students-table').DataTable();

      function fetchGraduatedStudents(filters = {}) {
        $.ajax({
          url: 'ajax/fetch_graduates.php', // Replace with your PHP file
          type: 'POST',
          data: filters,
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              table.clear();
              response.data.forEach(function(student) {
                var row = [];
                row.push(student.studentno);
                if (student.title && student.title.trim() !== '') {
                  row.push(student.educ_level + ' (' + student.title + ')');
                } else if (student.strand && student.strand.trim() !== '') {
                  row.push(student.educ_level + ' (' + student.strand + ')');
                } else if (student.type && student.type.trim() !== '') {
                  row.push(student.educ_level + ' (' + student.type + ')');
                } else {
                  row.push(student.educ_level);
                }
                row.push(student.first_name);
                row.push(student.last_name);
                row.push(student.graduated_at);
                table.row.add(row).draw();
              });
              // Show success alert
            } else if (response.status === 'no_results') {
              table.clear().draw();
            } else {
              // Show error alert
              $('.alert2').text(response.message + ' ' + response.error).show();
              $('.alert1').hide();
            }
          },
          error: function() {
            // Show error alert
            $('.alert2').text('Failed to fetch graduated students.').show();
            $('.alert1').hide();
          }
        });
      }

      // Fetch initial data when the main modal is shown
      $('#graduatedModal').on('show.bs.modal', function(e) {
        fetchGraduatedStudents();
      });

      // Apply filters and fetch data when the filter form is submitted
      $('#apply-filter').on('click', function() {
        var educLevel = $('#filter-educ-level').val();
        var dateFrom = $('#filter-date-from').val();
        var dateTo = $('#filter-date-to').val();

        var filters = {
          educ_level: educLevel,
          date_from: dateFrom,
          date_to: dateTo
        };

        // Close the filter modal
        $('#filterModal').modal('hide');

        // Fetch filtered data
        fetchGraduatedStudents(filters);
      });

      // Reset filters
      $('#reset-filter').on('click', function() {
        $('#filter-form')[0].reset();
      });
    });
  </script>


</body>

</html>