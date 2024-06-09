<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $educ_level = $_POST['levels'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $type = $_POST['type'];
    $teacher = $_POST['teacher'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $strand = $_POST['strand'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    try {
        $sql = "INSERT INTO classes (`educ-level`, `strand`, `title`, `type`, `code`, `name`, `teacher`, `start-date`, `end-date`, `start_time`, `end_time`) 
        VALUES (:educ_level, :strand, :title, :type, :code, :name, :teacher, :start_date, :end_date, :start_time, :end_time)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':educ_level', $educ_level, PDO::PARAM_STR);
        $query->bindParam(':strand', $strand, PDO::PARAM_STR);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->bindParam(':code', $code, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $query->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $query->bindParam(':end_time', $end_time, PDO::PARAM_STR);
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
                    <option value="Elementary">Elementary</option>
                    <option value="Junior Highschool">Junior High School</option>
                    <option value="Senior Highschool">Senior High School</option>
                    <option value="Vocational Course">Vocational Course(TESDA)</option>
                    <option value="Others">Others</option>
                </select>
            </div>
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
            <div class="form-group col-md-6" id="title" style="display: none;">
                <label for="name">Course Title</label>
                <input type="text" id=titles name="title" class="form-control" placeholder="Course Title" value="">
            </div>
            <div class="form-group col-md-6" id="type" style="display: none;">
                <label for="name">Type</label>
                <input type="text" id="types" name="type" class="form-control" placeholder="Type" value="">
            </div>
            <div class="form-group col-md-6">
                <label for="Teacher">Teacher/Instructor</label>
                <input type="text" name="teacher" class="form-control" placeholder="Techer/Instructor" value="" required>
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
        <div class="row">
            <div class="form-group col-md-4">
                <label for="start_time">TIME: </label>
                <input type="time" name="start_time" class="form-control" placeholder="Starting Time" required>
            </div>
            <div class="form-group col-md-4 text-center">
                <p style="display: flex; align-items: center; justify-content: center; height: 100%; margin: 0; font-weight: bold;">TO</p>
            </div>
            <div class="form-group col-md-4">
                <label for="end_time">END TIME: </label>
                <input type="time" name="end_time" class="form-control" placeholder="Ending Time" required>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="modal-footer text-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
</form>