    <?php
    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');
    if (strlen($_SESSION['sid'] == 0)) {
        header('location:logout.php');
    }
    if (isset($_GET['dels'])) {
        mysqli_query($con, "delete from programs where ID = '" . $_GET['ID'] . "'");
        $_SESSION['delmsg'] = "program deleted !!";
    }
    ?>
    <!DOCTYPE html>
    <html>
    <?php @include("includes/head.php"); ?>

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
                                <h1>Vocational Courses</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Manage Courses</li>
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
                                        <h3 class="card-title">Manage Courses</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deposit"><i class="fas fa-plus"></i> New Course
                                            </button>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="deposit">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">New Course</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- <p>One fine body&hellip;</p> -->
                                                    <?php @include("new-program-form.php"); ?>
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
                                    <div id="editData" class="modal fade">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Course's Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="info_update">
                                                    <!-- <p>One fine body&hellip;</p> -->
                                                    <?php @include("edit-program-form.php"); ?>
                                                </div>

                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </div>
                                    <div id="editData2" class="modal fade" id="printTable">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Course Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="info_update2">
                                                    <?php @include("view_program.php"); ?>
                                                </div>
                                                <div class="modal-footer ">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" onclick="printTable()">Print</button>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </div>


                                    <!-- /.card-header -->

                                    <div class="card-body">

                                        <table id="example1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Course Code</th>
                                                    <th>Course Name</th>
                                                    <th>Course Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "select * from programs");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td style="text-align: center;"><?php echo htmlentities($row['course-code']); ?></td>
                                                        <td style="text-align: center;"><?php echo htmlentities($row['name']); ?></td>
                                                        <td style="text-align: center;"><?php echo htmlentities($row['program_type']); ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="edit_data btn btn-primary btn-sm" style="color: white;" id="<?php echo ($row["ID"]); ?>" title="click for edit">Edit</a>
                                                            <a class="edit_data2 btn btn-success btn-sm" style="color: white;" id="<?php echo ($row["ID"]); ?>" title="click for edit">View</a>
                                                            <a href="program_list.php?ID=<?php echo $row['ID'] ?>&dels=delete" onClick="return confirm('Are you sure you want to delete?')" class=" btn btn-danger btn-sm ">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $cnt++;
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

        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.edit_data', function() {
                    var edit_id = $(this).attr('id');
                    $.ajax({
                        url: "edit-program-form.php",
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
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.edit_data2', function() {
                    var edit_id2 = $(this).attr('id');
                    $.ajax({
                        url: "view_program.php",
                        type: "post",
                        data: {
                            edit_id2: edit_id2
                        },
                        success: function(data) {
                            $("#info_update2").html(data);
                            $("#editData2").modal('show');
                        }
                    });
                });
            });
        </script>
        <script>
            function printTable() {
                var printContents = document.getElementById('info_update2').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
    </body>

    </html>