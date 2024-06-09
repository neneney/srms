<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$class_id = $_POST['edit_id3'];
$sql = "SELECT * FROM classes WHERE id = :class_id";
$query = $dbh->prepare($sql);
$query->bindParam(':class_id', $class_id, PDO::PARAM_INT);
$query->execute();
$classes = $query->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['class-code'] = $classes[0]['code'];

if (isset($_POST['submit1'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $suffix = $_POST['suffix'];
    $age = $_POST['age'];
    $studentno = $_POST['studentno'];
    $sex = $_POST['sex'];
    $parent_lastname = $_POST['parent-lastname'];
    $parent_firstname = $_POST['parent-firstname'];
    $parent_middlename = $_POST['parent-middlename'];
    $parent_suffix = $_POST['parent-suffix'];
    $relation = $_POST['relation'];
    $occupation = $_POST['occupation'];
    $email = $_POST['email'];
    $semail = $_POST['semail'];
    $sphone = $_POST['sphone'];
    $last_school = $_POST['last_school'];
    $phone = $_POST['phone'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $village = $_POST['village'];
    $strand = $_POST['strand'];
    $photo = $_FILES["photo"]["name"];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "studentimages/" . $_FILES["photo"]["name"]);

    $class = $_POST['class'];

    $check_sql = "SELECT COUNT(*) AS count FROM students WHERE `last-name` = :lastname AND `first-name` = :firstname AND `middle-name` = :middlename AND suffix = :suffix";
    $check_query = $dbh->prepare($check_sql);
    $check_query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $check_query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $check_query->bindParam(':middlename', $middlename, PDO::PARAM_STR);
    $check_query->bindParam(':suffix', $suffix, PDO::PARAM_STR);
    $check_query->execute();
    $count = $check_query->fetch(PDO::FETCH_ASSOC)['count'];

    if ($count > 0) {
        // Student with the same name already exists, show error message or take appropriate action
        echo "<script>alert('Student with the same name already exists.');</script>";
    } else {
        try {
            $dbh->beginTransaction();

            $sql_parent = "INSERT INTO parent (last_name, first_name, middle_name, suffix, relationship, occupation, email, `contact-no`) VALUES (:parent_lastname, :parent_firstname, :parent_middlename, :parent_suffix, :relation, :occupation, :email, :phone)";
            $query_parent = $dbh->prepare($sql_parent);
            $query_parent->bindParam(':parent_lastname', $parent_lastname, PDO::PARAM_STR);
            $query_parent->bindParam(':parent_firstname', $parent_firstname, PDO::PARAM_STR);
            $query_parent->bindParam(':parent_middlename', $parent_middlename, PDO::PARAM_STR);
            $query_parent->bindParam(':parent_suffix', $parent_suffix, PDO::PARAM_STR);
            $query_parent->bindParam(':relation', $relation, PDO::PARAM_STR);
            $query_parent->bindParam(':occupation', $occupation, PDO::PARAM_STR);
            $query_parent->bindParam(':email', $email, PDO::PARAM_STR);
            $query_parent->bindParam(':phone', $phone, PDO::PARAM_STR);
            $query_parent->execute();

            $parent_id = $dbh->lastInsertId();

            $sql_student = "INSERT INTO students (studentno, `last-name`, `first-name`, `middle-name`, suffix, age, gender, email, phone, parent_id, province, city, barangay, `village-house-no`, studentImage, last_school) 
            VALUES (:studentno, :lastname, :firstname, :middlename, :suffix, :age, :sex, :semail, :sphone, :parent_id, :province, :city, :barangay, :village, :photo, :last_school)";
            $query_student = $dbh->prepare($sql_student);
            $query_student->bindParam(':studentno', $studentno, PDO::PARAM_STR);
            $query_student->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $query_student->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $query_student->bindParam(':middlename', $middlename, PDO::PARAM_STR);
            $query_student->bindParam(':suffix', $suffix, PDO::PARAM_STR);
            $query_student->bindParam(':age', $age, PDO::PARAM_INT);
            $query_student->bindParam(':sex', $sex, PDO::PARAM_STR);
            $query_student->bindParam(':semail', $semail, PDO::PARAM_STR);
            $query_student->bindParam(':sphone', $sphone, PDO::PARAM_STR);
            $query_student->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
            $query_student->bindParam(':province', $province, PDO::PARAM_STR);
            $query_student->bindParam(':city', $city, PDO::PARAM_STR);
            $query_student->bindParam(':barangay', $barangay, PDO::PARAM_STR);
            $query_student->bindParam(':village', $village, PDO::PARAM_STR);
            $query_student->bindParam(':photo', $photo, PDO::PARAM_STR);
            $query_student->bindParam(':last_school', $last_school, PDO::PARAM_STR);
            $query_student->execute();

            $status = "active";
            $remarks = "none";

            if (!empty($class)) {
                $class_sql = "INSERT INTO class_enrollment (student_id, class_id, status, remarks) VALUES (:studentno, :class_id, :status, :remarks)";
                $query_class = $dbh->prepare($class_sql);
                $query_class->bindParam(':studentno', $studentno, PDO::PARAM_STR);
                $query_class->bindParam(':class_id', $class, PDO::PARAM_INT);
                $query_class->bindParam(':status', $status, PDO::PARAM_STR);
                $query_class->bindParam(':remarks', $remarks, PDO::PARAM_STR);
                $query_class->execute();
            }


            $dbh->commit();

            echo "<script>alert('Student has been enrolled.');</script>";
        } catch (Exception $e) {
            $dbh->rollBack();
            $error_message = $e->getMessage();
            echo $error_message;
            echo "<script>alert('Something Went Wrong. Please try again.');</script>";
        }
    }
}

?>


<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Enroll Student in <?php echo $classes[0]['name']; ?></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <span style="color: brown">
                            <h5>Student details</h5>
                        </span>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="studentno">Student ID</label>
                                <input type="text" class="form-control" id="studentnos" name="studentno" placeholder="Enter student No" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="studentno">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="studentno">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="studentno">Middle Name</label>
                                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter Middle Name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="studentno">Suffix(Optional)</label>
                                <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Enter Suffix">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="birthdate">Birthdate</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Birthdate" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" placeholder="age" required readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sex">Sex</label>
                                <select type="select" class="form-control" id="sex" name="sex" required>
                                    <option>Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="exampleInputFile">Student Photo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="" name="photo" id="photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="semail">Email</label>
                                <input type="text" class="form-control" id="semail" name="semail" placeholder="Email">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sphone">Phone Number</label>
                                <input type="text" class="form-control" id="sphone" name="sphone" placeholder="Phone Number">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="studentno">Last School Attended</label>
                                <input type="text" class="form-control" id="last_school" name="last_school" placeholder="Enter Last School Attended" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3" id="programs" style="display: block;">
                                <label for="program">Class/Section</label>
                                <!-- <input value="<?php echo $_SESSION['class-code'] ?>" type="text" class="form-control" id="program3" name="class" required readonly> -->
                                <select class="form-control" id="program" name="class" readonly>

                                    <option value="<?php echo $_SESSION['class-code']; ?>" selected><?php echo $classes[0]['name']; ?></option>

                                </select>
                            </div>
                        </div>
                        <hr>
                        <span style="color: brown">
                            <h5>Address</h5>
                        </span>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="Province">Province</label>
                                <select type="select" class="form-control" id="province" name="province" required>
                                    <option value="">Select province</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="City">City</label>
                                <select type="select" class="form-control" id="city" name="city" required>
                                    <option value="">Select City</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="City">Barangay</label>
                                <select type="select" class="form-control" id="barangay" name="barangay" required>
                                    <option value="">Select Barangay</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="village">Village & House No.</label>
                                <input type="text" class="form-control" id="village" name="village" placeholder="Village" required>
                            </div>
                        </div>

                        <div class="row">
                        </div>
                        <hr>
                        <span style="color: brown">
                            <h5>Parent/Guardian Details</h5>
                        </span>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="parent-f-name">Last Name</label>
                                <input type="text" class="form-control" id="parentname" name="parent-lastname" placeholder="Enter Last Name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="parent-l-name">First Name</label>
                                <input type="text" class="form-control" id="parentname" name="parent-firstname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="parent-m-name">Middle Name</label>
                                <input type="text" class="form-control" id="parentname" name="parent-middlename" placeholder="Enter Middle Name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="parent-suffix">Suffix(Optional)</label>
                                <input type="text" class="form-control" id="parentname" name="parent-suffix" placeholder="Enter Suffix">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="relation">Relationship</label>
                                <select type="select" class="form-control" id="relation" name="relation" required>
                                    <option>Select Relationship</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Father">Uncle</option>
                                    <option value="Mother">Aunt</option>
                                    <option value="Mother">Grand parent</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="age">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nextphone">Phone Number</label>
                                <input type="text" class="form-control" id="nextphone" name="phone" placeholder="Phone Number">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="occupation">Ocupation</label>
                                <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Occupation" required>
                            </div>
                        </div>



                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" name="submit1" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>