<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Student</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="card-body">
                        <span style="color: brown">
                            <h5>Student details</h5>
                        </span>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="studentno">Student ID</label>
                                <input type="text" class="form-control" id="studentno" name="studentno" placeholder="Enter student No" required readonly>
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
                            <div class="form-group col-md-3">
                                <label for="grade">Student Educational Level</label>
                                <select class="form-control" id="levels" name="levels">
                                    <option value="">Select Educational Level</option>
                                    <option value="elementary">Elementary</option>
                                    <option value="Junior High">Junior High School</option>
                                    <option value="Senior High">Senior High School</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3" id="elementaryGrades" style="display:none;">
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
                            <div class="form-group col-md-3" id="middleGrades" style="display:none;">
                                <label for="middleGrade">Grade Levels</label>
                                <select class="form-control" id="middleGrade" name="jhs-level">
                                    <option value="">Select Grade</option>
                                    <option value="Grade 7">Grade 7</option>
                                    <option value="Grade 8">Grade 8</option>
                                    <option value="Grade 9">Grade 9</option>
                                    <option value="Grade 10">Grade 10</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3" id="highGrades" style="display:none;">
                                <label for="highGrade">Grade Levels</label>
                                <select class="form-control" id="highGrade" name="shs-level">
                                    <option value="">Select Grade</option>
                                    <option value="Grade 11">Grade 11</option>
                                    <option value="Grade 12">Grade 12</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3" id="elementaryClass" style="display:none;">
                                <label for="elementaryClasses">Class/Section</label>
                                <select class="form-control" id="elementaryClasses" name="elementary-class">
                                    <option value="">Select Class/Section</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3" id="middleClass" style="display:none;">
                                <label for="middleClasses">Class/Section</label>
                                <select class="form-control" id="middleClasses" name="jhs-class">
                                    <option value="">Select Class/Section</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3" id="highClass" style="display:none;">
                                <label for="highClasses">Class/Section</label>
                                <select class="form-control" id="highClasses" name="shs-class">
                                    <option value="">Select Class/Section</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-3" id="programs">
                                <label for="program">Vocational Course/Program</label>
                                <select class="form-control" id="program" name="program">
                                    <option value="">Select Course/Program</option>
                                    <?php foreach ($programs as $program) { ?>
                                        <option value="<?php echo $program['course-code']; ?>"><?php echo $program['name']; ?></option>
                                    <?php } ?>
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
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>