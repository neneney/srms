<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $educ_level = $_POST['levels'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    if ($educ_level === "elementary") {
        $grade_level = $_POST['elementary-level'];
    } else if ($educ_level === "Junior High") {
        $grade_level = $_POST['jhs-level'];
    } else if ($educ_level === "Senior High") {
        $grade_level = $_POST['shs-level'];
    }
    $teacher = $_POST['teacher'];
    $grading = $_POST['grading'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $strand = $_POST['strand'];

    try {
        $sql = "INSERT INTO classes (`grade-level`,`educ-level`,  `strand`, `code`, `name`, `teacher`, `start-date`, `end-date`, `grading`) 
                VALUES (:grade_level, :educ_level, :strand, :code, :name, :teacher, :start_date, :end_date, :grading)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':grade_level', $grade_level, PDO::PARAM_STR);
        $query->bindParam(':educ_level', $educ_level, PDO::PARAM_STR);
        $query->bindParam(':strand', $strand, PDO::PARAM_STR);
        $query->bindParam(':code', $code, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $query->bindParam(':grading', $grading, PDO::PARAM_STR);

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
                <input id="code" type="text" name="code" class="form-control" placeholder="Class Code" value="" required readonly>
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
            <div class="form-group col-md-6" id="strands" style="display:none;">
                <label for="strand">Strand</label>
                <select class="form-control" id="strand" name="strand">
                    <option value="">Select Strand</option>
                    <option value="abm">ABM - Accountancy, Business and Management </option>
                    <option value="stem">STEM - Science, Technology, Engineering and Mathematics (STEM)</option>
                    <option value="humss">HUMSS - Humanities and Social Sciences </option>
                    <option value="gas">GAS - General Academic Strand </option>
                    <option value="ict">ICT - Information Communication Technology </option>
                    <option value="he">HE - Home Economics </option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="Teacher">Teacher/Instructor</label>
                <input type="text" name="teacher" class="form-control" placeholder="Techer/Instructor" value="" required>
            </div>
            <div class="form-group col-md-6">
                <label for="grading">Grading</label>
                <select type="select" class="form-control" id="grading" name="grading" required>
                    <option>Select Grading</option>
                    <option value="1st grading">1st grading</option>
                    <option value="2nd grading">2nd grading</option>
                    <option value="3rd grading">3rd grading</option>
                    <option value="4th grading">4th grading</option>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentYear = new Date().getFullYear().toString();
        var randomNumber = Math.floor(10000 + Math.random() * 90000);
        var code = currentYear + randomNumber;
        document.getElementById("code").value = code;
    });
</script>