<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (isset($_POST['edit-submit'])) {
    $eid = $_SESSION['edid'];
    $code = $_POST['edit-code'];
    $name = $_POST['edit-name'];
    if (isset($_POST['edit-elementary-level'])) {
        $grade_level = $_POST['edit-elementary-level'];
    } else if (isset($_POST['edit-jhs-level'])) {
        $grade_level = $_POST['edit-jhs-level'];
    } else if (isset($_POST['edit-shs-level'])) {
        $grade_level = $_POST['edit-shs-level'];
    }
    $teacher = $_POST['edit-teacher'];
    $semester = $_POST['edit-semester'];
    $start_date = $_POST['edit-start_date'];
    $end_date = $_POST['edit-end_date'];
    $educ_level = $_POST['edit-levels'];

    try {
        $sql = "UPDATE classes SET `grade-level`=:grade_level, `educ-level`=:educ_level, `code`=:code, `name`=:name, `teacher`=:teacher, `start-date`=:start_date, `end-date`=:end_date, `semester`=:semester WHERE id=:eid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':grade_level', $grade_level, PDO::PARAM_STR);
        $query->bindParam(':educ_level', $educ_level, PDO::PARAM_STR);
        $query->bindParam(':code', $code, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $query->bindParam(':semester', $semester, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo "<script>alert('Edited successfully');</script>";
            echo "<script>window.location.href ='classes.php'</script>";
        } else {
            $errorInfo = $query->errorInfo();
            echo "<script>alert('Something went wrong: $errorInfo');</script>";
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<script>alert('Something went wrong: $error_message');</script>";
    }
}
?>



<form role="form" id="" method="post" enctype="multipart/form-data" class="form-horizontal">
    <?php
    $eid = $_POST['edit_id'];
    $sql = "SELECT * FROM classes WHERE ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $_SESSION['edid'] = $row['id'];
    ?>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="code">Class Code</label>
                    <input type="text" name="edit-code" class="form-control" placeholder="<?php echo $row['code']; ?>" value="<?php echo $row['code']; ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Class Name</label>
                    <input type="text" name="edit-name" class="form-control" placeholder="<?php echo $row['name']; ?>" value="<?php echo $row['name']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="grade">Educational Level</label>
                    <select class="form-control" id="e-levels" name="edit-levels" required>
                        <option value="">Select Educational Level</option>
                        <option value="elementary" <?php if ($row['educ-level'] === "elementary") echo "selected"; ?>>Elementary</option>
                        <option value="Junior High" <?php if ($row['educ-level'] === "Junior High") echo "selected"; ?>>Junior High School</option>
                        <option value="Senior High" <?php if ($row['educ-level'] === "Senior High") echo "selected"; ?>>Senior High School</option>
                    </select>
                </div>
                <div class="form-group col-md-6" id="e-elementaryGrades" <?php if ($row['educ-level'] !== "elementary") echo "style='display:none;'"; ?>>
                    <label for="elementaryGrade">Grade Levels</label>
                    <select class="form-control" id="e-elementaryGrade" name="edit-elementary-level">
                        <option value="">Select Grade</option>
                        <option value="Grade 1" <?php if ($row['grade-level'] === "Grade 1") echo "selected"; ?>>Grade 1</option>
                        <option value="Grade 2" <?php if ($row['grade-level'] === "Grade 2") echo "selected"; ?>>Grade 2</option>
                        <option value="Grade 3" <?php if ($row['grade-level'] === "Grade 3") echo "selected"; ?>>Grade 3</option>
                        <option value="Grade 4" <?php if ($row['grade-level'] === "Grade 4") echo "selected"; ?>>Grade 4</option>
                        <option value="Grade 5" <?php if ($row['grade-level'] === "Grade 5") echo "selected"; ?>>Grade 5</option>
                        <option value="Grade 6" <?php if ($row['grade-level'] === "Grade 6") echo "selected"; ?>>Grade 6</option>

                    </select>
                </div>
                <div class="form-group col-md-6" id="e-middleGrades" <?php if ($row['educ-level'] !== "Junior High") echo "style='display:none;'"; ?>>
                    <label for="middleGrade">Grade Levels</label>
                    <select class="form-control" id="e-middleGrade" name="edit-jhs-level">
                        <option value="">Select Grade</option>
                        <option value="Grade 7" <?php if ($row['grade-level'] === "Grade 7") echo "selected"; ?>>Grade 7</option>
                        <option value="Grade 8" <?php if ($row['grade-level'] === "Grade 8") echo "selected"; ?>>Grade 8</option>
                        <option value="Grade 9" <?php if ($row['grade-level'] === "Grade 9") echo "selected"; ?>>Grade 9</option>
                        <option value="Grade 10" <?php if ($row['grade-level'] === "Grade 10") echo "selected"; ?>>Grade 10</option>
                    </select>
                </div>
                <div class="form-group col-md-6" id="e-highGrades" <?php if ($row['educ-level'] !== "Senior High") echo "style='display:none;'"; ?>>
                    <label for="highGrade">Grade Levels</label>
                    <select class="form-control" id="e-highGrade" name="edit-shs-level">
                        <option value="">Select Grade</option>
                        <option value="Grade 11" <?php if ($row['grade-level'] === "Grade 11") echo "selected"; ?>>Grade 11</option>
                        <option value="Grade 12" <?php if ($row['grade-level'] === "Grade 12") echo "selected"; ?>>Grade 12</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="Teacher">Teacher/Instructor</label>
                    <input type="text" name="edit-teacher" class="form-control" placeholder="<?php echo $row['teacher']; ?>" value="<?php echo $row['teacher']; ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="semester">Semester</label>
                    <select type="select" class="form-control" id="semester" name="edit-semester" required>
                        <option>Select Semester</option>
                        <option value="1st Sem">1st Sem</option>
                        <option value="2nd Sem">2nd Sem</option>
                        <option value="3rd Sem">3rd Sem</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="start_date">Starting Date</label>
                    <input type="date" id="start_date" name="edit-start_date" class="form-control" value="<?php echo $row['start-date']; ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="edit-end_date" class="form-control" value="<?php echo $row['end-date']; ?>" required>
                </div>
            </div>

        </div>
        <!-- /.card-body -->
    <?php
    }
    ?>
    <div class="modal-footer text-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" name="edit-submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    document.getElementById('e-levels').addEventListener('change', function() {
        const selectedGrade = this.value;
        document.getElementById('e-elementaryGrades').style.display = 'none';
        document.getElementById('e-middleGrades').style.display = 'none';
        document.getElementById('e-highGrades').style.display = 'none';
        document.getElementById('e-elementaryGrade').removeAttribute('required');
        document.getElementById('e-middleGrade').removeAttribute('required');
        document.getElementById('e-highGrade').removeAttribute('required');

        if (selectedGrade === 'elementary') {
            document.getElementById('e-elementaryGrades').style.display = 'block';
            document.getElementById('e-elementaryGrade').setAttribute('required', 'required');
        } else if (selectedGrade === 'Junior High') {
            document.getElementById('e-middleGrades').style.display = 'block';
            document.getElementById('e-middleGrade').setAttribute('required', 'required');
        } else if (selectedGrade === 'Senior High') {
            document.getElementById('e-highGrades').style.display = 'block';
            document.getElementById('e-highGrade').setAttribute('required', 'required');
        }
    });
</script>