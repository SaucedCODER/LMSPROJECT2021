<?php
error_reporting(0);
include "connection/oopconnection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Button to trigger the modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signupModal">
    Open Signup Modal
</button>

<!-- Signup Modal -->
<div class="modal" id="signupModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Signup Form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form>
                    <!-- Input fields with skyblue border on focus -->
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="G-mail">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Residence Address">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Official Address">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Mobile No.">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Landline No.">
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <input type="radio" name="gender" value="Male"> Male
                        <input type="radio" name="gender" value="Female"> Female
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Student ID">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password">
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Sign Up</button>
            </div>

        </div>
    </div>
</div>

<!-- Add Bootstrap JS and jQuery links -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
