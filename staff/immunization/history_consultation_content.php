<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,prenatal_subjective.id as id,patients.first_name as first_name,patients.last_name as last_name
FROM prenatal_subjective
JOIN patients ON prenatal_subjective.patient_id = patients.id
JOIN prenatal_consultation ON prenatal_consultation.prenatal_subjective_id = prenatal_subjective.id
JOIN midwife ON midwife.id = prenatal_consultation.midwife_id";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
    <button type="button" class="btn btn-primary" onclick="goBack()">
        <i class="fa fa-arrow-circle-left"></i> Back
    </button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <br><br>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Consultation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <!-- Form fields go here -->
                        <div class="form-group">
                            <label for="patient">Select Patient</label>
                            <input list="patients" class="form-control" name="patient_id" id="patient_id" required>
                            <datalist id="patients">
                                <?php
                                // Query to fetch patients from the database
                                $sql2 = "SELECT serial_no, first_name, last_name FROM patients ORDER BY id DESC";
                                $result2 = $conn->query($sql2);

                                if ($result2->num_rows > 0) {
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $patientSerialNo = $row2['serial_no'];
                                        $firstName = $row2['first_name'];
                                        $lastName = $row2['last_name'];

                                        // Output an option element for each patient with the serial_no as the value
                                        echo "<option value='$patientSerialNo'>$firstName $lastName</option>";
                                    }
                                } else {
                                    echo "<option disabled>No patients found</option>";
                                }
                                ?>
                            </datalist>
                            <input type="hidden" name="serial_no2" id="serial_no2">


                        </div>

                        <script>
                            // Add a JavaScript event listener to update the input field
                            const patientInput = document.getElementById('patient_id');
                            patientInput.addEventListener('input', function () {
                                const selectedOption = document.querySelector('datalist#patients option[value="' + this.value + '"]');
                                if (selectedOption) {
                                    this.value = selectedOption.innerText; // Update the input text
                                    patient_id = selectedOption.value; // Set patient_id to the value of the selected option (serial_no)
                                    $('#serial_no2').val(patient_id);
                                }
                            });
                        </script>


                        <div class="form-group">
                            <label for="">Select Doctor</label>
                            <select class="form-control" name="doctor_id" id="doctor_id" required>
                                <option value="" disabled selected hidden>Select Doctor</option>
                                <?php

                                // Query to fetch patients from the database
                                $sql2 = "SELECT id, first_name, last_name FROM superadmins ORDER BY id DESC";
                                $result2 = $conn->query($sql2);

                                if ($result2->num_rows > 0) {
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $patientId = $row2['id'];
                                        $firstName = $row2['first_name'];
                                        $lastName = $row2['last_name'];

                                        // Output an option element for each patient
                                        echo "<option value='$patientId'>$firstName $lastName</option>";
                                    }
                                } else {
                                    echo "<option disabled>No Doctor Found</option>";
                                }

                                // Close the database connection
                                
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Checkup Date</label>
                            <input type="date" class="form-control" id="checkup_date" name="checkup_date" required>
                        </div>

                        <script>
                            // Get the current date
                            var today = new Date();

                            // Calculate the date for tomorrow
                            today.setDate(today.getDate() + 1);

                            // Format the date to match the input type="date" format (YYYY-MM-DD)
                            var tomorrow = today.toISOString().split('T')[0];

                            // Set the minimum date for the input element
                            document.getElementById('checkup_date').min = tomorrow;
                        </script>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="closeModalButton">Close</button>
                    <button type="submit" class="btn btn-primary" id="addButton">Save</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .tago {
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="tablebod" class="table table-head-fixed text-nowrap table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th class="tago">No.</th>
                            <th>Nurse Name</th>
                            <th>Description</th>
                            <th>Diagnosis</th>
                            <th>Medicine</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td class="align-middle tago">
                                        <?php echo $row['id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['last_name']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['description']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['diagnosis']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['medicine']; ?>
                                    </td>

                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Consultation Found</td>
                                <td class="align-middle"></td>
                                <td class="align-middle">
                                <td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>

                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal edit -->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Consultation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">

                        <input type="hidden" id="editdataId" name="primary_id">
                        <!-- Form fields go here -->

                        <div class="form-group">
                            <label for="">Select Doctor</label>
                            <select class="form-control" name="doctor_id" id="editDoctor" required>
                                <option value="" disabled selected hidden>Select Doctor</option>
                                <?php

                                // Query to fetch patients from the database
                                $sql2 = "SELECT id, first_name, last_name FROM superadmins ORDER BY id DESC";
                                $result2 = $conn->query($sql2);

                                if ($result2->num_rows > 0) {
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $patientId = $row2['id'];
                                        $firstName = $row2['first_name'];
                                        $lastName = $row2['last_name'];

                                        // Output an option element for each patient
                                        echo "<option value='$patientId'>$firstName $lastName</option>";
                                    }
                                } else {
                                    echo "<option disabled>No Doctor Found</option>";
                                }

                                // Close the database connection
                                
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Checkup Date</label>
                            <input type="date" class="form-control" id="editCheckup" name="checkup_date" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateButton">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {




        <?php if ($result->num_rows > 0): ?>
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
                    // {
                    //     targets: 5,
                    //     searchable: false,
                    //     data: null,
                    //     render: function (data, type, row) {
                    //         var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                    //         var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                    //         // return  deleteButton;
                    //     }
                    // } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php else: ?>
            // Initialize DataTable without the "Action" column when no rows are found
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php endif; ?>

        $('#addButton').click(function () {

            console.log(patient_id);
            table.destroy(); // Destroy the existing DataTable
            table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
                    // {
                    //     targets: 5,
                    //     searchable: false,
                    //     data: null,
                    //     render: function (data, type, row) {
                    //         var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                    //         var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                    //         //    return deleteButton;
                    //     }
                    // } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });

            // Get data from the form

            var patient_id = $('#serial_no2').val();
            var description = $('#description').val();
            var checkup_date = $('#checkup_date').val();
            var doctor_id = $('#doctor_id').val();

            console.log(patient_id);

            // AJAX request to send data to the server
            $.ajax({
                url: 'action/add_consultation.php',
                method: 'POST',
                data: {
                    patient_id: patient_id,
                    description: description,
                    doctor_id: doctor_id,
                    checkup_date: checkup_date,
                },
                success: function (response) {

                    if (response.trim() === 'Success') {


                        // Clear the form fields
                        $('#patient_id').val('');
                        $('#description').val('');
                        $('#doctor_id').val('');
                        $('#checkup_date').val('');

                        updateData();
                        $('#addModal').modal('hide');

                        // Remove the modal backdrop manually
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Show a success SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Consultation added successfully',
                        });

                    } else {
                        // Show an error SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error adding data: ' + response,
                        });
                    }
                },
                error: function (error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding data: ' + error,
                    });
                },

            });
        });


        function updateData() {
            $.ajax({
                url: 'action/get_active.php',
                method: 'GET',
                success: function (data) {
                    // Assuming the server returns JSON data, parse it
                    var get_data = JSON.parse(data);

                    // Clear the DataTable and redraw with new data
                    table.clear().rows.add(get_data).draw();
                },
                error: function (error) {
                    // Handle errors
                    console.error('Error retrieving data: ' + error);
                }
            });
        }

        // Delete button click event
        $('#tablebod').on('click', '.deletebtn', function () {
            var deletedataId = $(this).data('id');

            // Confirm the deletion with a SweetAlert dialog
            Swal.fire({
                title: 'Confirm Activation',
                text: 'Are you sure you want to active this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, set it as active'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'action/active.php',
                        method: 'POST',
                        data: { primary_id: deletedataId },
                        success: function (response) {
                            if (response === 'Success') {

                                updateData();
                                Swal.fire('Activated', 'The Consultation has been activated.', 'success');
                            } else {
                                Swal.fire('Error', 'Error deleting data: ' + response, 'error');
                            }
                        },
                        error: function (error) {
                            Swal.fire('Error', 'Error deleting data: ' + error, 'error');
                        }
                    });
                }
            });
        });



        // Edit button click event
        $('#tablebod').on('click', '.editbtn', function () {
            var editId = $(this).data('row-id');
            console.log(editId);
            $.ajax({
                url: 'action/get_consultation_by_id.php', // 
                method: 'POST',
                data: { primary_id: editId },
                success: function (data) {

                    var editGetData = data;


                    $('#editModal #editdataId').val(editGetData.id);
                    $('#editModal #editDescription').val(editGetData.description);
                    $('#editModal #editCheckup').val(editGetData.checkup_date);
                    $('#editModal #editDoctor').val(editGetData.doctor_id);

                    $('#editModal').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });

        $('#updateButton').click(function () {


            var editId = $('#editdataId').val();
            var description = $('#editDescription').val();
            var doctor_id = $('#editDoctor').val();
            var checkup_date = $('#editCheckup').val();

            $.ajax({
                url: 'action/update_consultation.php',
                method: 'POST',
                data: {
                    primary_id: editId,
                    description: description,
                    doctor_id: doctor_id,
                    checkup_date: checkup_date,
                },
                success: function (response) {
                    // Handle the response
                    if (response === 'Success') {
                        updateData();
                        $('#editModal').modal('hide');
                        // Remove the modal backdrop manually
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Show a success Swal notification
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Consultation updated successfully',
                        });
                    } else {
                        // Show an error Swal notification
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating data: ' + response,
                        });
                    }
                },
                error: function (error) {
                    // Show an error Swal notification for AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating data: ' + error,
                    });
                }
            });
        });



    });


</script>
<script>
    // Set the timeout duration (in milliseconds)
    var inactivityTimeout = 360000; // 10 seconds

    // Track user activity
    var activityTimer;

    function resetTimer() {
        clearTimeout(activityTimer);
        activityTimer = setTimeout(logout, inactivityTimeout);
    }

    function logout() {
        // Redirect to logout PHP script
        window.location.href = '../action/logout.php';
    }

    // Add event listeners to reset the timer on user activity
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);

    // Initialize the timer on page load
    resetTimer();
</script>