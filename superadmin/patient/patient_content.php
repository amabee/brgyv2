<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT * FROM patients WHERE is_active = 0 AND is_deleted = 0 ORDER BY id DESC";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">

<div>
    <button type="button" id="openModalButton" class="btn btn-primary" style="display: inline-block;">Add Patient</button>
    <!-- <a href="../archive_consultation/archive_consultation.php" class="nav-link" style="display: inline-block;">
        <button type="button" class="btn btn-primary">View Archive Patient</button>
    </a> -->
</div>



<br><br>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="addPatientForm">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
                <div id="first_name_error" class="error"></div>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
                <div id="last_name_error" class="error"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" required>
                <div id="middle_name_error" class="error"></div>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="">Suffix</label>
                <input type="text" class="form-control" id="suffix" name="suffix" required>
                <div id="suffix_name_error" class="error"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Select Gender</label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value="" disabled selected hidden>Select a Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <div id="gender_error" class="error"></div>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="">Contact No</label>
                <input type="number" class="form-control" id="contact_no" name="contact_no" required>
                <div id="contact_error" class="error"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Civil Status</label>
                <select class="form-control" name="civil_status" id="civil_status" required>
                    <option value="" disabled selected hidden>Select a Civil Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
                <div id="civil_status_error" class="error"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                <div id="birthdate_error" class="error"></div>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="">Age</label>
                <p id="age" class="form-control"></p>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col">
    <div class="form-group">
        <label for="">Serial No</label>
        <input type="text" class="form-control" id="serial_no" name="serial_no" required readonly>
        <div id="serial_error" class="error"></div>
    </div>
</div>

        <div class="col">
            <div class="form-group">
                <label for="">Religion</label>
                <select class="form-control" name="religion" id="religion" required>
                    <option value="" disabled selected hidden>Select Religion</option>
                    <option value="Roman Catholic">Roman Catholic</option>
                    <option value="Muslim">Muslim</option>
                    <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                    <option value="Protestantism">Protestantism</option>
                    <option value="Other or Non-religious">Other or Non-religious</option>
                </select>
                <div id="religion_error" class="error"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                <div id="address_error" class="error"></div>
            </div>
        </div>
    </div>

</form>
                <script>
            function calculateAge() {
                const birthdate = new Date(document.getElementById("birthdate").value);
                const today = new Date();
                let age = today.getFullYear() - birthdate.getFullYear();

                // Check if the birthday has occurred this year
                if (
                    today.getMonth() < birthdate.getMonth() ||
                    (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())
                ) {
                    age--;
                }

                // Update the age display
                document.getElementById("age").innerText = age;
            }

            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Add 1 to month since it's zero-based
            const day = String(today.getDate()).padStart(2, '0');
            const maxDate = `${year}-${month}-${day}`;

            document.getElementById("birthdate").max = maxDate;

            // Attach the calculateAge function to the input's change event
            document.getElementById("birthdate").addEventListener("change", calculateAge);


             // Function to generate a random serial number
    function generateSerialNumber() {
        // Customize this function to generate a serial number 
        const serialNumber = "SN" + Math.floor(Math.random() * 1000000);
        return serialNumber;
    }

    // Generated serial number as the value of the input field
    document.getElementById("serial_no").value = generateSerialNumber();
        </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                <button type="button" class="btn btn-primary" id="addPatientButton">Save</button>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="patientTableBody" class="table table-head-fixed text-nowrap table-striped" >
                    <thead class="thead-light">
                        <tr>
                            <th>Serial No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Birthdate</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td class="align-middle"><?php echo $row['serial_no']; ?></td>
                                <td class="align-middle"><?php echo $row['first_name']; ?></td>
                                <td class="align-middle"><?php echo $row['last_name']; ?></td>
                                <td class="align-middle"><?php echo $row['birthdate']; ?></td>
                                <td class="align-middle"><?php echo $row['address']; ?></td>
                                <td class="align-middle">
                                <button type="button" class="btn btn-success editbtn" data-patient-id="<?php echo $row['serial_no']; ?>">
                    <i class="fas fa-edit"></i> Edit
                </button>
                                  <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
  <tr>
                                <td class="align-middle">No Patient Found</td>
                                <td class="align-middle"></td>
                                <td class="align-middle"><td>
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
<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPatientForm">
                    <!-- Form fields for editing patient details -->
                    <input type="hidden" id="editPatientId" name="patient_id">
                    <div class="form-group">
                        <label for="editFirstName">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                        <div id="editFirstName_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" name="last_name" required>
                        <div id="editLastName_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="editBirthdate">Birthdate</label>
                        <input type="date" class="form-control" id="editBirthdate" name="birthdate" required>
                        <div id="editBirthdate_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <textarea class="form-control" id="editAddress" name="address" rows="3" required></textarea>
                        <div id="editAddress_error" class="error"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updatePatientButton">Update</button>
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

    document.getElementById('openModalButton').addEventListener('click', function() {
  $('#addPatientModal').modal('show'); // Show the modal
});

 // Check if there are rows in the PHP-generated table
 <?php if ($result->num_rows > 0): ?>
        var table = $('#patientTableBody').DataTable({
            columnDefs: [
                { targets: 0, data: 'serial_no' },
                { targets: 1, data: 'first_name' },
                { targets: 2, data: 'last_name' },
                { targets: 3, data: 'birthdate' },
                { targets: 4, data: 'address' },
                {
                    targets: 5,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-patient-id="' + row.serial_no + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.serial_no + '"><i class="fas fa-trash"></i> Delete</button>';
                        return editButton + ' '+deleteButton ;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
    <?php else: ?>
        // Initialize DataTable without the "Action" column when no rows are found
        var table = $('#patientTableBody').DataTable({
            columnDefs: [
                { targets: 0, data: 'serial_no' },
                { targets: 1, data: 'first_name' },
                { targets: 2, data: 'last_name' },
                { targets: 3, data: 'birthdate' },
                { targets: 4, data: 'address' }
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
    <?php endif; ?>
    // Add Patient Button Click
    $('#addPatientButton').click(function () {

        //re declare
        table.destroy(); // Destroy the existing DataTable
        table = $('#patientTableBody').DataTable({
            columnDefs: [
                { targets: 0, data: 'serial_no' },
                { targets: 1, data: 'first_name' },
                { targets: 2, data: 'last_name' },
                { targets: 3, data: 'birthdate' },
                { targets: 4, data: 'address' },
                {
                    targets: 5,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-patient-id="' + row.serial_no + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.serial_no + '"><i class="fas fa-trash"></i> Delete</button>';
                        return editButton + ' '+deleteButton ;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
        // Get data from the form

                            $('.error').text('');

                    // Get data from the form
                    var first_name = $('#first_name').val();
                    var last_name = $('#last_name').val();
                    var birthdate = $('#birthdate').val();
                    var address = $('#address').val();

                    var middle_name = $('#middle_name').val();
                    var suffix = $('#suffix').val();
                    var gender = $('#gender').val();
                    var age = $('#age').val();

                    var contact_no = $('#contact_no').val();
                    var civil_status = $('#civil_status').val();
                    var religion = $('#religion').val();
                    var serial_no = $('#serial_no').val();

                    var religion = $('#religion').val();






                    // Validate input fields
                    var isValid = true;

                    if (first_name.trim() === '') {
                        $('#first_name_error').text('Field is required');
                        isValid = false;
                    }

                    if (last_name.trim() === '') {
                        $('#last_name_error').text('Field is required');
                        isValid = false;
                    }

                    if (birthdate.trim() === '') {
                        $('#birthdate_error').text('Field is required');
                        isValid = false;
                    }

                    if (address.trim() === '') {
                        $('#address_error').text('Field is required');
                        isValid = false;
                    }


                    if (isValid) {
        // AJAX request to send data to the server
        $.ajax({
            url: 'action/add_patient.php',
            method: 'POST',
            data: {
                first_name: first_name,
                last_name: last_name,
                birthdate: birthdate,
                address: address,
                middle_name:middle_name,
                suffix:suffix,
                gender:gender,
                age:age,
                contact_no:contact_no,
                civil_status:civil_status,
                religion:religion,
                serial_no:serial_no,
                religion:religion
            },
            success: function (response) {
                // Handle the response
                if (response === 'Success') {
                    // Clear the form fields
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#birthdate').val('');
                    $('#address').val('');

                    updatePatientTable();
                    $('#addPatientModal').modal('hide');

// Remove the modal backdrop manually
$('body').removeClass('modal-open');
$('.modal-backdrop').remove();
     // Show a success SweetAlert
     Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Patient added successfully',
            });

                } else {
                        // Show an error SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding patient: ' + response,
                    });
                }
            },
            error: function (error) {
                // Handle errors
                Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error adding patient: ' + error,
        });
            },

        });
    }
    });

    // Function to update the patient table
    function updatePatientTable() {
        $.ajax({
            url: 'action/get_patient.php',
            method: 'GET',
            success: function (data) {
                // Assuming the server returns JSON data, parse it
                var patients = JSON.parse(data);

                // Clear the DataTable and redraw with new data
                table.clear().rows.add(patients).draw();
            },
            error: function (error) {
                // Handle errors
                console.error('Error retrieving patients: ' + error);
            }
        });
    }

    // Delete button click event
    $('#patientTableBody').on('click', '.deletebtn', function () {
        var patientId = $(this).data('id');
console.log(patientId);
        // Confirm the deletion with a SweetAlert dialog
        Swal.fire({
            title: 'Confirm Delete',
            text: 'Are you sure you want to delete this patient?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to delete the patient
                $.ajax({
                    url: 'action/delete_patient.php',
                    method: 'POST',
                    data: { patient_id: patientId },
                    success: function (response) {
                        if (response === 'Success') {
                            // Patient deleted successfully, update the table
                            updatePatientTable();
                            Swal.fire('Deleted', 'The patient has been deleted.', 'success');
                        } else {
                            Swal.fire('Error', 'Error deleting patient: ' + response, 'error');
                        }
                    },
                    error: function (error) {
                        Swal.fire('Error', 'Error deleting patient: ' + error, 'error');
                    }
                });
            }
        });
    });



// Edit button click event
$('#patientTableBody').on('click', '.editbtn', function () {
    var patientId = $(this).data('patient-id');

    $.ajax({
        url: 'action/get_patient_by_id.php', // Replace with the actual URL to fetch patient data
        method: 'POST',
        data: { patient_id: patientId },
        success: function (data) {

            var patientData = data;


            // Populate the Edit Patient Modal with patient details
            $('#editPatientModal #editPatientId').val(patientData.serial_no);
            $('#editPatientModal #editFirstName').val(patientData.first_name);
            $('#editPatientModal #editLastName').val(patientData.last_name);
            $('#editPatientModal #editBirthdate').val(patientData.birthdate);
            $('#editPatientModal #editAddress').val(patientData.address);

            // Show the Edit Patient Modal
            $('#editPatientModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching patient data: ' + error);
        },
    });
});
// When the "Update" button in the update modal is clicked
// When the "Update" button in the update modal is clicked
$('#updatePatientButton').click(function () {
    event.preventDefault();
    $('.error').text('');
    // Get the updated patient data from the form
    var patientId = $('#editPatientId').val();
    var firstName = $('#editFirstName').val();
    var lastName = $('#editLastName').val();
    var birthdate = $('#editBirthdate').val();
    var address = $('#editAddress').val();

    var isValid = true;

    if (firstName.trim() === '') {
        $('#editFirstName_error').text('Field is required');
        isValid = false;
    }

    if (lastName.trim() === '') {
        $('#editLastName_error').text('Field is required');
        isValid = false;
    }

    if (birthdate.trim() === '') {
        $('#editBirthdate_error').text('Field is required');
        isValid = false;
    }

    if (address.trim() === '') {
        $('#editAddress_error').text('Field is required');
        isValid = false;
    }

    // Only proceed with AJAX request if all fields are valid
    if (isValid) {

    // Send an AJAX request to update the patient data
    $.ajax({
        url: 'action/update_patient.php',
        method: 'POST',
        data: {
            patient_id: patientId,
            first_name: firstName,
            last_name: lastName,
            birthdate: birthdate,
            address: address
        },
        success: function (response) {
            // Handle the response
            if (response === 'Success') {
                updatePatientTable();
                $('#editPatientModal').modal('hide');
                // Remove the modal backdrop manually
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                // Show a success Swal notification
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Patient updated successfully',
                });
            } else {
                // Show an error Swal notification
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating patient: ' + response,
                });
            }
        },
        error: function (error) {
            // Show an error Swal notification for AJAX errors
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error updating patient: ' + error,
            });
        }
    });
    }
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