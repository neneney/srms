<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $name = $_POST['name'];
    if (isset($_POST['elementary-level'])) {
        $grade_level = $_POST['elementary-level'];
    } else if (isset($_POST['jhs-level'])) {
        $grade_level = $_POST['jhs-level'];
    } else if (isset($_POST['shs-level'])) {
        $grade_level = $_POST['shs-level'];
    }
    $teacher = $_POST['teacher'];
    $semester = $_POST['semester'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $educ_level = $_POST['levels'];

    try {
        $sql = "INSERT INTO classes (`grade-level`,`educ-level`, `code`, `name`, `teacher`, `start-date`, `end-date`, `semester`) 
                VALUES (:grade_level, :educ_level, :code, :name, :teacher, :start_date, :end_date, :semester)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':grade_level', $grade_level, PDO::PARAM_STR);
        $query->bindParam(':educ_level', $educ_level, PDO::PARAM_STR);
        $query->bindParam(':code', $code, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $query->bindParam(':semester', $semester, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            echo "<script>alert('Registered successfully');</script>";
            echo "<script>window.location.href ='classes.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>



<form role="form" id="" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="code">Class Code</label>
                <input type="text" name="code" class="form-control" placeholder="Class Code" value="" required>
            </div>
            <div class="form-group col-md-6">
                <label for="name">Class Name</label>
                <input type="text" name="name" class="form-control" placeholder="Class Name" value="" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="grade">Educational Level</label>
                <select class="form-control" id="levels" name="levels" required>
                    <option value="">Select Educational Level</option>
                    <option value="elementary">Elementary</option>
                    <option value="Junior High">Junior High School</option>
                    <option value="Senior High">Senior High School</option>
                </select>
            </div>
            <div class="form-group col-md-6" id="elementaryGrades" style="display:none;">
                <label for="elementaryGrade">Grade Levels</label>
                <select class="form-control" id="elementaryGrade" name="elementary-level">
                    <option value="">Select Grade</option>
                    <option value="Grade 1">Grade 1</option>
                    <option value="Grade 2">Grade 2</option>
                    <option value="Grade 3">Grade 3</option>
                    <option value="Grade 4">Grade 4</option>
                    <option value="Grade 5">Grade 5</option>
                    <option value="Grade 6">Grade 6</option>
                </select>
            </div>
            <div class="form-group col-md-6" id="middleGrades" style="display:none;">
                <label for="middleGrade">Grade Levels</label>
                <select class="form-control" id="middleGrade" name="jhs-level">
                    <option value="">Select Grade</option>
                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>
                </select>
            </div>
            <div class="form-group col-md-6" id="highGrades" style="display:none;">
                <label for="highGrade">Grade Levels</label>
                <select class="form-control" id="highGrade" name="shs-level">
                    <option value="">Select Grade</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="Teacher">Teacher/Instructor</label>
                <input type="text" name="teacher" class="form-control" placeholder="Techer/Instructor" value="" required>
            </div>
            <div class="form-group col-md-6">
                <label for="semester">Semester</label>
                <select type="select" class="form-control" id="semester" name="semester" required>
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
                <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Starting Date" value="" required>
            </div>
            <div class="form-group col-md-6">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Ending Date" value="" required>
            </div>
        </div>

    </div>
    <!-- /.card-body -->
    <div class="modal-footer text-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
</form>