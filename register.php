<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
        integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <style>
        body {
            background: url('assets/images/register.png') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <h1 class="text-center font-weight-semibold mt-4" style="margin-top: 20px;">Register</h1>
    <form action="register.php" method="POST">
        <div class="container" style="background-color: #94b8b8; padding: 30px; border-radius: 10px; margin-top: 40px;">
            <!-- Bootstrap form groups -->
            <div class="container-fluid">
                <div class="form-group">
                    <label for="serial_number">Serial Number</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number"
                        placeholder="Serial Number" readonly required>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" class="form-control" id="middlename" name="middlename"
                                placeholder="Middle Name" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="suffix">Suffix</label>
                            <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Suffix">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="contact_no">Contact No</label>
                            <input type="number" class="form-control" id="contact_no" name="contact_no"
                                placeholder="Contact No" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="civilStatus">Civil Status</label>
                            <select class="form-control" id="civilStatus" name="civilStatus" required>
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="Age" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate"
                                placeholder="Birthdate" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="religion">Religion</label>
                            <select class="form-control" id="religion" name="religion" required>
                                <option value="" disabled selected>Select Religion</option>
                                <option value="christianity">Roman Catholic</option>
                                <option value="islam">Muslim</option>
                                <option value="hinduism">Iglesia ni Cristo</option>
                                <option value="buddhism">Protestantism</option>
                                <option value="judaism">Other or Non-religous</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address"
                                required>
                        </div>
                    </div>
                </div>


                <!-- Add other fields as needed -->

                <div class="d-flex justify-content-between">
                    <a href="user.php" class="btn btn-secondary">Back</a>
                    <div>
                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                        <button type="button" class="btn btn-danger ml-2" onclick="clearForm()">Clear Entries</button>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <!-- Bootstrap and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script to clear form entries -->
    <script>
        function clearForm() {
            document.getElementById("serial_number").value = "";
            document.getElementById("firstname").value = "";
            document.getElementById("lastname").value = "";
            document.getElementById("middlename").value = "";
            document.getElementById("age").value = "";
            document.getElementById("contact_no").value = "";
            document.getElementById("civilStatus").value = "";
            document.getElementById("religion").value = "";
            document.getElementById("birthdate").value = "";
            document.getElementById("address").value = "";
        }
    </script>
</body>

</html>