<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['edit-submit'])) {
    $eid = $_SESSION['edid'];
    $code = $_POST['edit-code'];
    $name = $_POST['edit-name'];
    $educ_level = $_POST['edit-levels'];
    $teacher = $_POST['edit-teacher'];
    $start_date = $_POST['edit-start_date'];
    $end_date = $_POST['edit-end_date'];
    $strand = $_POST['strand'];
    $title = $_POST['e-title'];
    $type = $_POST['e-type'];
    $start_time = $_POST['e-start_time'];
    $end_time = $_POST['e-end_time'];
    try {
        $sql = "UPDATE classes 
        SET `educ-level` = :educ_level, 
            strand = :strand, 
            title = :title,
            type = :type,
            `code` = :code, 
            `name` = :name, 
            `teacher` = :teacher, 
            `start-date` = :start_date, 
            `end-date` = :end_date,
            start_time = :start_time,
            end_time = :end_time
        WHERE id = :eid";

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
        $query->bindParam(':eid', $eid, PDO::PARAM_INT);

        $query->execute();

        if ($query->rowCount() > 0) {
            echo "<script>alert('Edited successfully');</script>";
            echo "<script>window.location.href ='classes.php'</script>";
        } else {
            $errorInfo = $query->errorInfo();
            echo "<script>alert('Something went wrong: " . $errorInfo[2] . "');</script>";
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
                    <input type="text" name="edit-code" class="form-control" placeholder="<?php echo $row['code']; ?>" value="<?php echo $row['code']; ?>" required readonly>
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
                        <option value="Elementary" <?php if ($row['educ-level'] === "Elementary") echo "selected"; ?>>Elementary</option>
                        <option value="Junior Highschool" <?php if ($row['educ-level'] === "Junior Highschool") echo "selected"; ?>>Junior High School</option>
                        <option value="Senior Highschool" <?php if ($row['educ-level'] === "Senior Highschool") echo "selected"; ?>>Senior High School</option>
                        <option value="Vocational Course" <?php if ($row['educ-level'] === "Vocational Course") echo "selected"; ?>>Vocational Course</option>
                        <option value="Others" <?php if ($row['educ-level'] === "Others") echo "selected"; ?>>Others</option>
                    </select>
                </div>


                <div class="form-group col-md-6" id="e-strands" <?php if (empty($row['strand'])) {
                                                                    echo 'style="display:none;"';
                                                                } else {
                                                                    echo 'style="display:block"';
                                                                }; ?>>
                    <label for="strand">Strand</label>
                    <select class="form-control" id="e-strand" name="strand">
                        <option value="">Select Strand</option>
                        <option <?php if ($row['strand'] === "abm") echo "selected"; ?> value="abm">ABM - Accountancy, Business and Management </option>
                        <option <?php if ($row['strand'] === "stem") echo "selected"; ?> value="stem">STEM - Science, Technology, Engineering and Mathematics (STEM)</option>
                        <option <?php if ($row['strand'] === "humss") echo "selected"; ?> value="humss">HUMSS - Humanities and Social Sciences </option>
                        <option <?php if ($row['strand'] === "gas") echo "selected"; ?> value="gas">GAS - General Academic Strand </option>
                        <option <?php if ($row['strand'] === "ict") echo "selected"; ?> value="ict">ICT - Information Communication Technology </option>
                        <option <?php if ($row['strand'] === "he") echo "selected"; ?> value="he">HE - Home Economics </option>
                    </select>
                </div>
                <div class="form-group col-md-6" id="e-title" <?php if (empty($row['title'])) {
                                                                    echo 'style="display:none;"';
                                                                } else {
                                                                    echo 'style="display:block"';
                                                                }; ?>>
                    <label for="name">Course Title</label>
                    <input type="text" name="e-title" class="form-control" placeholder="Course Title" value="<?php echo $row['title'] ?>">
                </div>
                <div class="form-group col-md-6" id="e-type" <?php if (empty($row['type'])) {
                                                                    echo 'style="display:none;"';
                                                                } else {
                                                                    echo 'style="display:block"';
                                                                }; ?>>
                    <label for="name">Type</label>
                    <input type="text" name="e-type" class="form-control" placeholder="Type" value="<?php echo $row['type'] ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="Teacher">Teacher/Instructor</label>
                    <input type="text" name="edit-teacher" class="form-control" placeholder="<?php echo $row['teacher']; ?>" value="<?php echo $row['teacher']; ?>" required>
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
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="start_time">TIME: </label>
                    <input type="time" name="e-start_time" class="form-control" placeholder="Starting Time" value="<?php echo $row['start_time'] ?>" required>
                </div>
                <div class="form-group col-md-4 text-center">
                    <p style="display: flex; align-items: center; justify-content: center; height: 100%; margin: 0; font-weight: bold;">TO</p>
                </div>
                <div class="form-group col-md-4">
                    <label for="end_time">END TIME: </label>
                    <input type="time" name="e-end_time" class="form-control" placeholder="Ending Time" value="<?php echo $row['end_time'] ?>" required>
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
        var e_title = document.getElementById('e-title');
        var e_type = document.getElementById('e-type');


        document.getElementById('e-strands').style.display = 'none';
        document.getElementById('e-strand').removeAttribute('required');
        document.getElementById('e-strand').value = null;

        e_title.style.display = "none";
        e_title.removeAttribute('required');
        e_title.value = null;

        e_type.style.display = "none";
        e_type.removeAttribute('required');
        e_type.value = null;

        // Show and set required attribute based on selected grade
        if (selectedGrade === 'Senior Highschool') {
            document.getElementById('e-strands').style.display = 'block';
            document.getElementById('e-strand').setAttribute('required', 'required');
        } else if (selectedGrade === 'Vocational Course') {
            e_title.style.display = "block";
            e_title.setAttribute('required', 'required');
        } else if (selectedGrade === 'Others') {
            e_type.style.display = 'block';
            e_type.setAttribute('required', 'required');
        }
    });
</script>