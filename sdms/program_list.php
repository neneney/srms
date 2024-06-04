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
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">New Course</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php @include("new-program-form.php"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="editData" class="modal fade">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Course's Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="info_update">
                                                <?php @include("edit-program-form.php"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="editData2" class="modal fade">
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
                                        </div>
                                    </div>
                                </div>
                                <div id="editData3" class="modal fade">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Enroll Student</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="info_update3">
                                                <?php @include("enroll-student-form.php"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-header -->

                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Course Code</th>
                                                <th>Course Title</th>
                                                <th>Teacher/Instructor</th>
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
                                                    <td style="text-align: center;"><?php echo htmlentities($row['teacher']); ?></td>
                                                    <td style="text-align: center;">
                                                        <a class="edit_data btn btn-primary btn-sm" style="color: white;" id="<?php echo ($row["ID"]); ?>" title="Edit">Edit</a>
                                                        <a class="edit_data2 btn btn-success btn-sm" style="color: white;" id="<?php echo ($row["ID"]); ?>" title="View">View</a>
                                                        <a class="btn btn-sm btn-info editdata3" style="color: white;" id="<?php echo $row['ID'] ?>">Enroll</a>
                                                        <?php if ($_SESSION['permission'] == "Admin") { ?>
                                                            <a href="program_list.php?ID=<?php echo $row['ID'] ?>&dels=delete" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm">Delete</a>
                                                        <?php } ?>
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
    <script>
        $(document).ready(function() {
            // Edit Course modal logic
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

            // View Course modal logic
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

            // Enroll Student modal logic
            $(document).on('click', '.editdata3', function() {
                var edit_id3 = $(this).attr('id');
                $.ajax({
                    url: "enroll-student-form.php",
                    type: "post",
                    data: {
                        edit_id3: edit_id3
                    },
                    success: function(data) {
                        $("#info_update3").html(data);
                        $("#editData3").modal('show');
                        populateProvinceDropdown(); // Populate the province dropdown when the modal is shown
                    }
                });
            });

            // Print table function
            window.printTable = function() {
                var printContents = document.getElementById('info_update2').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            };

            // Populate dropdowns function
            function populateDropdown(select, options, placeholder = "Select an option") {
                select.innerHTML = `<option value="">${placeholder}</option>`;
                options.forEach(option => {
                    const opt = document.createElement("option");
                    opt.value = option.provCode || option.citymunCode || option.brgyCode; // Adjust keys based on your JSON structure
                    opt.textContent = option.provDesc || option.citymunDesc || option.brgyDesc; // Adjust keys based on your JSON structure
                    select.appendChild(opt);
                });
            }

            // Fetch data for dropdowns function
            function fetchDropdownData(url, callback) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => callback(data))
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Populate province dropdown
            function populateProvinceDropdown() {
                const provinceSelect = document.getElementById('province');
                const citySelect = document.getElementById('city');
                const barangaySelect = document.getElementById('barangay');

                fetchDropdownData('getters-php/get-province.php', function(provinces) {
                    populateDropdown(provinceSelect, provinces, "Select Province");
                });

                provinceSelect.addEventListener('change', function() {
                    const selectedProvinceId = this.value;
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>'; // Reset barangay dropdown

                    if (selectedProvinceId) {
                        fetchDropdownData(`getters-php/get-cities.php?province_id=${selectedProvinceId}`, function(cities) {
                            populateDropdown(citySelect, cities, "Select City");
                        });
                    }
                });

                citySelect.addEventListener('change', function() {
                    const selectedCityId = this.value;
                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                    if (selectedCityId) {
                        fetchDropdownData(`getters-php/get-barangay.php?city_id=${selectedCityId}`, function(barangays) {
                            populateDropdown(barangaySelect, barangays, "Select Barangay");
                        });
                    }
                });
            }

            // Generate Student ID and calculate age
            function generateStudentIdAndCalculateAge() {
                const currentYear = new Date().getFullYear();
                const randomNumber = Math.floor(Math.random() * 1000000);
                const studentId = `${currentYear}${randomNumber}`;
                const IDfield = document.getElementById('studentnos');
                IDfield.value = studentId;

                const birthdateField = document.getElementById('birthdate');
                const ageField = document.getElementById('age');

                birthdateField.addEventListener('input', function() {
                    const birthdate = new Date(birthdateField.value);
                    const age = calculateAge(birthdate);

                    if (age <= 0) {
                        alert("Please enter a valid birthdate.");
                        birthdateField.value = '';
                        ageField.value = '';
                    } else {
                        ageField.value = age;
                    }
                });

                function calculateAge(birthdate) {
                    const today = new Date();
                    let age = today.getFullYear() - birthdate.getFullYear();
                    const monthDifference = today.getMonth() - birthdate.getMonth();

                    // If the birth date hasn't occurred yet this year, subtract one from age
                    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdate.getDate())) {
                        age--;
                    }

                    return age;
                }
            }

            // Attach generateStudentIdAndCalculateAge to modal show event
            $(document).on('show.bs.modal', '#editData3', generateStudentIdAndCalculateAge);
        });

        function validateEndDate() {
            var startDate = document.getElementById("start_date").value;
            var endDate = document.getElementById("end_date").value;


            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);

            // Compare the dates
            if (endDateObj < startDateObj) {

                alert("End date cannot be before the start date");

                document.getElementById("end_date").value = "";
            }
        }
        document.getElementById("end_date").addEventListener("change", validateEndDate);
        document.addEventListener('DOMContentLoaded', function() {
            // Get all input elements of type text
            var textInputs = document.querySelectorAll('input[type="text"]');

            // Function to capitalize the first letter of each word
            function capitalizeWords(input) {
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
    </script>
</body>

</html>