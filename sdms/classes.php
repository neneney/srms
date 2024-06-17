<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
}
if (isset($_GET['dels'])) {
    mysqli_query($con, "delete from classes where ID = '" . $_GET['ID'] . "'");
    $_SESSION['delmsg'] = "class deleted !!";
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
                            <h1>Classes</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Manage Classes</li>
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
                                    <h3 class="card-title">Manage Classes</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deposit"><i class="fas fa-plus"></i> New class
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="deposit">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">New Classes</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- <p>One fine body&hellip;</p> -->
                                                <?php @include("new-class-form.php"); ?>
                                            </div>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="editData" class="modal fade">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Classes Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="info_update">
                                                <!-- <p>One fine body&hellip;</p> -->
                                                <?php @include("edit-class-form.php"); ?>
                                            </div>

                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </div>
                                <div id="editData2" class="modal fade" id="printTable">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Classes Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="info_update2">
                                                <?php @include("view_class.php"); ?>
                                            </div>

                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
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
                                                <?php @include("enroll_student_class.php"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Confirm Delete Modal -->
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
                                                Are you sure you want to delete this Class?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <a class="btn btn-danger btn-ok">Delete</a>
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
                                                <th class="text-center">Class Code</th>
                                                <th class="text-center">Class Name</th>
                                                <th class="text-center">Class Teacher</th>
                                                <th class="text-center">Educational Level</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "select * from classes order by id desc");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td style="text-align: center;"><?php echo htmlentities($row['code']); ?></td>
                                                    <td style="text-align: center;"><?php echo htmlentities($row['name']); ?></td>
                                                    <td style="text-align: center;"><?php echo htmlentities($row['teacher']); ?></td>
                                                    <td style="text-align: center;"><?php echo htmlentities($row['educ-level']); ?></td>
                                                    <td style="text-align: center;">
                                                        <a class="edit_data btn btn-primary btn-sm" style="color: white;" id="<?php echo ($row["id"]); ?>" title="click for edit">Edit</a>
                                                        <a class="edit_data2 btn btn-success btn-sm" style="color: white;" id="<?php echo ($row["id"]); ?>" title="click for view">View</a>
                                                        <a class="btn btn-sm btn-info editdata3" style="color: white;" id="<?php echo ($row["id"]); ?>">Enroll</a>
                                                        <?php if ($_SESSION['permission'] == "Admin") { ?>
                                                            <a href="#" data-href="classes.php?ID=<?php echo $row['id']; ?>&dels=delete" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-sm">Delete</a>
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
    <!-- Ensure jQuery and Bootstrap JS are included -->


    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.edit_data', function() {
                var edit_id = $(this).attr('id');
                $.ajax({
                    url: "edit-class-form.php",
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
        $(document).ready(function() {
            $(document).on('click', '.edit_data2', function() {
                var edit_id2 = $(this).attr('id');
                $.ajax({
                    url: "view_class.php",
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
        $(document).on('click', '.editdata3', function() {
            var edit_id3 = $(this).attr('id');
            $.ajax({
                url: "enroll_student_class.php",
                type: "post",
                data: {
                    edit_id3: edit_id3
                },
                success: function(data) {
                    $("#info_update3").html(data);
                    $("#editData3").modal('show');
                    populateProvinceDropdown();
                }
            });
        });
        // Populate dropdown function
        function populateDropdown(select, options, placeholder = "Select an option") {
            select.innerHTML = `<option value="">${placeholder}</option>`;
            options.forEach(option => {
                const opt = document.createElement("option");
                opt.value = option.provCode || option.citymunCode || option.brgyCode;
                opt.textContent = option.provDesc || option.citymunDesc || option.brgyDesc;
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

            let selectedBarangay; // Variable to store selected barangay

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

            function populateBarangay(select, options, placeholder = "Select an option") {
                select.innerHTML = `<option value="">${placeholder}</option>`;
                options.forEach(option => {
                    const opt = document.createElement("option");
                    opt.value = option.brgyCode;
                    opt.textContent = option.brgyDesc;
                    select.appendChild(opt);
                });
            }
            citySelect.addEventListener('change', function() {
                const selectedCityId = this.value;
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                if (selectedCityId) {
                    fetchDropdownData(`getters-php/get-barangay.php?city_id=${selectedCityId}`, function(barangays) {
                        populateBarangay(barangaySelect, barangays, "Select Barangay");
                    });
                }
            });


            barangaySelect.addEventListener('change', function() {
                selectedBarangay = this.value; // Store the selected barangay value
                console.log('Selected Barangay:', selectedBarangay); // Log the selected barangay for verification
                // You can also call a function or perform an action with the selectedBarangay value here
            });
        }

        // Initialize the dropdown population
        populateProvinceDropdown();

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
        document.getElementById('levels').addEventListener('change', function() {
            const selectedGrade = this.value;
            document.getElementById('strands').style.display = 'none';
            document.getElementById('strand').removeAttribute('required');
            var title = document.getElementById("title");
            var type = document.getElementById("type");
            title.style.display = "none";
            document.getElementById('titles').removeAttribute('required')
            type.style.display = "none";
            document.getElementById('types').removeAttribute('required');


            if (selectedGrade === 'Senior Highschool') {
                document.getElementById('strands').style.display = 'block';
                document.getElementById('strand').setAttribute('required', 'required');
            } else if (selectedGrade === "Vocational Course") {
                title.style.display = "block";
                document.getElementById('titles').setAttribute('required', 'required');
            } else if (selectedGrade === "Others") {
                type.style.display = "block";
                document.getElementById('types').setAttribute('required', 'required');
            }
        });

        // Validate that the end date is not before the start date
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

        // Validate that the start date is not in the past
        function validateStartDate() {
            var startDate = document.getElementById("start_date").value;
            var startDateObj = new Date(startDate);
            var today = new Date();

            // Set time to 00:00:00 to compare only dates, not times
            today.setHours(0, 0, 0, 0);

            // Compare the dates
            if (startDateObj < today) {
                alert("Enter a valid starting date");
                document.getElementById("start_date").value = "";
            }
        }

        // Update the minimum value of the end date based on the start date
        function updateEndDateMin() {
            var startDate = document.getElementById("start_date").value;
            document.getElementById("end_date").min = startDate;
        }

        function updateStartDateMin() {
            var today = new Date();


            var yyyy = today.getFullYear();
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var dd = String(today.getDate()).padStart(2, '0');

            var formattedToday = `${yyyy}-${mm}-${dd}`;

            document.getElementById('start_date').min = formattedToday;
        }
        updateStartDateMin();
        document.getElementById("end_date").addEventListener("blur", validateEndDate);
        document.getElementById("start_date").addEventListener("blur", validateStartDate);
        document.getElementById("start_date").addEventListener("input", updateEndDateMin);




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
        document.addEventListener('DOMContentLoaded', function() {
            var currentYear = new Date().getFullYear().toString();
            var randomNumber = Math.floor(10000 + Math.random() * 90000);
            var code = currentYear + randomNumber;
            document.getElementById("code").value = code;
        });
    </script>
</body>

</html>