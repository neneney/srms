<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<style>
    p {
        margin: 0;
    }
</style>
<?php

$eid2 = $_POST['edit_id2'];
$ret2 = $dbh->prepare("SELECT * FROM classes WHERE id = :id");
$ret2->bindParam(':id', $eid2, PDO::PARAM_STR);
$ret2->execute();
$class = $ret2->fetch(PDO::FETCH_ASSOC);
if ($class) {
?>

    <div class="row card-body" id="print">
        <div class="col-md-12">


            <h4>Class Details</h4>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><b>Class Code:</b> <?php echo htmlentities($class['code']); ?></p>
                    <p><b>Class Name:</b> <?php echo htmlentities($class['name']); ?></p>
                    <p><b>Education Level:</b> <?php echo htmlentities($class['educ-level']); ?></p>
                    <?php if (isset($class["strand"]) && !empty($class["strand"])) { ?>
                        <p><strong>Strand:</strong> <?php echo htmlentities($class['strand']); ?></p>
                    <?php } ?>

                </div>
                <div class="col-md-6">
                    <p><b>Title:</b> <?php echo htmlentities($class['title']); ?></p>
                    <?php if (isset($class["type"]) && !empty($class["type"])) { ?>
                        <p><strong>Type:</strong> <?php echo htmlentities($class['type']); ?></p>
                    <?php } ?>
                    <p><b>Teacher:</b> <?php echo htmlentities($class['teacher']); ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="status_filter">Filter by Status:</label>
                    <select class="form-control" id="status_filter" name="status_filter">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                        <option value="withdrawn">Withdrawn</option>
                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <label for="remarks_filter">Filter by Remarks:</label>
                    <select class="form-control" id="remarks_filter" name="remarks_filter">
                        <option value="">All</option>
                        <option value="excellent">Excellent</option>
                        <option value="good">Good</option>
                        <option value="satisfactory">Satisfactory</option>
                        <option value="needs improvement">Needs Improvement</option>
                        <option value="none">None</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <h5 style="margin-top: 50px"></h5>
                </div>
            </div>
            <form method="POST" id="studentRec">
                <div class="alert alert-success" style="display: none;">
                </div>
                <div class="alert alert-danger" style="display: none;">
                </div>
                <table class="table" id="students_table">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Full Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Default query to fetch students
                        $query = "SELECT s.studentno, s.`first-name`, s.`middle-name`, s.`last-name`, s.suffix, s.age, s.gender, ce.status, ce.remarks
                              FROM class_enrollment ce
                              JOIN students s ON ce.student_id = s.studentno
                              WHERE ce.class_id = :class_code";

                        $ret3 = $dbh->prepare($query);
                        $ret3->bindParam(':class_code', $class['code'], PDO::PARAM_STR);
                        $ret3->execute();
                        $students = $ret3->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($students as $student) {
                            // Fetch and concatenate the student's name parts
                            $fullName = htmlentities($student['first-name']) . ' ' .
                                htmlentities($student['middle-name']) . ' ' .
                                htmlentities($student['last-name']) . ' ' .
                                htmlentities($student['suffix']);
                        ?>
                            <tr>
                                <td><?php echo htmlentities($student['studentno']); ?></td>
                                <td><?php echo $fullName; ?></td>
                                <td><?php echo htmlentities($student['age']); ?></td>
                                <td><?php echo htmlentities($student['gender']); ?></td>
                                <td>
                                    <select class="form-control" name="status_<?php echo htmlentities($student['studentno']); ?>">

                                        <option value="active" <?php if ($student['status'] == 'active') echo 'selected'; ?>>Active</option>
                                        <option value="inactive" <?php if ($student['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                                        <option value="graduated" <?php if ($student['status'] == 'graduated') echo 'selected'; ?>>Graduated</option>
                                        <option value="withdrawn" <?php if ($student['status'] == 'withdrawn') echo 'selected'; ?>>Withdrawn</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="remarks_<?php echo htmlentities($student['studentno']); ?>">
                                        <option value="excellent" <?php if (empty($student['remarks']) || $student['remarks'] == 'excellent') echo 'selected'; ?>>Excellent</option>
                                        <option value="good" <?php if ($student['remarks'] == 'good') echo 'selected'; ?>>Good</option>
                                        <option value="satisfactory" <?php if ($student['remarks'] == 'satisfactory') echo 'selected'; ?>>Satisfactory</option>
                                        <option value="needs improvement" <?php if ($student['remarks'] == 'needs improvement') echo 'selected'; ?>>Needs Improvement</option>
                                        <option value="none" <?php if ($student['remarks'] == 'none') echo 'selected' ?>>None</option>
                                    </select>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <input type="hidden" name="class_code" value="<?php echo htmlentities($class['code']); ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="generatePDF()">Print</button>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("studentRec").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission
            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/student_records.php", true);
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
                                }, 2000);
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
                                parseErrorAlert[1].style.display = "none";
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
        document.getElementById('status_filter').addEventListener('change', filterStudents);
        document.getElementById('remarks_filter').addEventListener('change', filterStudents);

        function filterStudents() {
            var statusFilter = document.getElementById('status_filter').value;
            var remarksFilter = document.getElementById('remarks_filter').value;
            var classCode = "<?php echo $class['code']; ?>";

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_filtered_students.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('students_table').getElementsByTagName('tbody')[0].innerHTML = xhr.responseText;
                }
            };
            xhr.send('class_code=' + classCode + '&status_filter=' + statusFilter + '&remarks_filter=' + remarksFilter);
        }

        function generatePDF() {
            var classId = "<?php echo $eid2; ?>";
            var statusFilter = document.getElementById('status_filter').value;
            var remarksFilter = document.getElementById('remarks_filter').value;

            // Redirect to class_pdf.php with class ID and filter values as query parameters
            window.location.href = "class_pdf.php?class_id=" + classId + "&status_filter=" + statusFilter + "&remarks_filter=" + remarksFilter;
        }
    </script>
<?php
}
?>