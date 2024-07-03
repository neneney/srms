<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


?>



<form role="form" id="newClassForm" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="card-body">
        <div class="alert alert-success" style="display: none; text-align: center;">
        </div>
        <div class="alert alert-danger" style="display: none; text-align: center;">
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="code">Program Code</label>
                <input id="code" type="text" name="code" class="form-control" placeholder="Class Code" value="" required readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="name">Program Name</label>
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
                    <option value="ABM">ABM - Accountancy, Business and Management </option>
                    <option value="STEM">STEM - Science, Technology, Engineering and Mathematics (STEM)</option>
                    <option value="HUMSS">HUMSS - Humanities and Social Sciences </option>
                    <option value="GAS">GAS - General Academic Strand </option>
                    <option value="ICT">ICT - Information Communication Technology </option>
                    <option value="HE">HE - Home Economics </option>
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

<script>
    document.getElementById("newClassForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_class.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === "success") {
                            // Show success alert
                            var successAlert = document.querySelector(".alert-success");
                            successAlert.innerHTML = response.message;
                            successAlert.style.display = "block";
                            setTimeout(function() {
                                successAlert.style.display = "none";
                                location.reload();
                            }, 3000);
                        } else if (response.status === "error") {
                            // Show error alert
                            var errorAlert = document.querySelector(".alert-danger");
                            errorAlert.innerHTML = response.message;
                            errorAlert.style.display = "block";
                            setTimeout(function() {
                                errorAlert.style.display = "none";
                            }, 3000);
                        } else {
                            // Show a generic error message if the response is not properly formatted
                            var genericErrorAlert = document.querySelector(".alert-danger");
                            genericErrorAlert.innerHTML = "Unexpected response from server. Please try again.";
                            genericErrorAlert.style.display = "block";
                            setTimeout(function() {
                                genericErrorAlert.style.display = "none";
                            }, 3000);
                        }
                    } catch (error) {
                        // Log the error to the console
                        console.error("Error parsing JSON response:", error);

                        // Show a generic error message if there's an issue parsing the JSON response
                        var parseErrorAlert = document.querySelector(".alert-danger");
                        parseErrorAlert.innerHTML = "Error occurred while processing server response: " + error.message;
                        parseErrorAlert.style.display = "block";
                        setTimeout(function() {
                            parseErrorAlert.style.display = "none";
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
</script>