<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT * FROM announcements WHERE is_deleted = 1 ORDER BY id DESC";


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

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="addPatientForm">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
                <div id="title_error" class="error"></div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                <div id="description_error" class="error"></div>
            </div>
        </div>
    </div>

</form>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                <button type="button" class="btn btn-primary" id="addPatientButton">Save</button>
            </div>
        </div>
    </div>
</div>
<style>
    .tago{
        display: none;
    }
</style>
    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="patientTableBody" class="table table-head-fixed text-nowrap table-striped" >
                    <thead class="thead-light">
                        <tr>
                        <th class="tago">ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                            <td class="align-middle tago"><?php echo $row['id']; ?></td>
                                <td class="align-middle"><?php echo $row['title']; ?></td>
                                <td class="align-middle"><?php echo $row['description']; ?></td>
                                <td class="align-middle">
                                <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>
                                  
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
  <tr>
  <td class="align-middle"></td>
  <td class="align-middle">No Announcement Found</td>
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
                <input type="hidden" id="editPatientId" name="patient_id">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" class="form-control" id="editTitle" name="editTitle" required>
                <div id="editTitle_error" class="error"></div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Description</label>
                <textarea class="form-control" id="editDescription" name="editDescription" rows="3" required></textarea>
                <div id="editDescription_error" class="error"></div>
            </div>
        </div>
    </div>

</form>
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

  

 // Check if there are rows in the PHP-generated table
 <?php if ($result->num_rows > 0): ?>
        var table = $('#patientTableBody').DataTable({
            columnDefs: [
                { targets: 0, data: 'id', visible: false },
                { targets: 1, data: 'title' },
                { targets: 2, data: 'description' },
                {
                    targets: 3,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-patient-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                        return  deleteButton;
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
                { targets: 0, data: 'id', visible: false },
                { targets: 1, data: 'title' },
                { targets: 2, data: 'description' },
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
                { targets: 0, data: 'id', visible: false },
                { targets: 1, data: 'title' },
                { targets: 2, data: 'description' },
                {
                    targets: 3,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-patient-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                        return  deleteButton;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
        // Get data from the form

                            $('.error').text('');

                    // Get data from the form
                    var description = $('#description').val();
                    var title = $('#title').val();






                    // Validate input fields
                    var isValid = true;

                    if (description.trim() === '') {
                        $('#description_error').text('Field is required');
                        isValid = false;
                    }

                    if (title.trim() === '') {
                        $('#title_error').text('Field is required');
                        isValid = false;
                    }



                    if (isValid) {
        // AJAX request to send data to the server
        $.ajax({
            url: 'action/add_patient.php',
            method: 'POST',
            data: {
                description: description,
                title: title
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
                text: 'Announcement added successfully',
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
            text: 'Error adding announcement: ' + error,
        });
            },

        });
    }
    });

    // Function to update the patient table
    function updatePatientTable() {
        $.ajax({
            url: 'action/get_active.php',
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
            title: 'Confirm Activation',
            text: 'Are you sure you want to activate this announcement?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, activate it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to delete the patient
                $.ajax({
                    url: 'action/active.php',
                    method: 'POST',
                    data: { patient_id: patientId },
                    success: function (response) {
                        if (response === 'Success') {
                            // Patient deleted successfully, update the table
                            updatePatientTable();
                            Swal.fire('Deleted', 'The announcement has been activated.', 'success');
                        } else {
                            Swal.fire('Error', 'Error deleting announcement: ' + response, 'error');
                        }
                    },
                    error: function (error) {
                        Swal.fire('Error', 'Error deleting announcement: ' + error, 'error');
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
            $('#editPatientModal #editPatientId').val(patientData.id);
            $('#editPatientModal #editTitle').val(patientData.title);
            $('#editPatientModal #editDescription').val(patientData.description);

            // Show the Edit Patient Modal
            $('#editPatientModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching announcement data: ' + error);
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
    var title = $('#editTitle').val();
    var description = $('#editDescription').val();

    var isValid = true;

    if (patientId.trim() === '') {
        $('#editPatientId_error').text('Field is required');
        isValid = false;
    }

    if (description.trim() === '') {
        $('#editDescription_error').text('Field is required');
        isValid = false;
    }
    if (title.trim() === '') {
        $('#editTitle_error').text('Field is required');
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
            description: description,
            title: title,
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