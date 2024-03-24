<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,family_plannings.id as id,patients.first_name as first_name,patients.last_name as last_name,nurses.first_name as first_name2,nurses.last_name as last_name2
FROM family_plannings
JOIN patients ON family_plannings.patient_id = patients.id
JOIN nurses ON family_plannings.nurse_id = nurses.id
WHERE family_plannings.is_active = 0 AND family_plannings.not_approved = 1";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
<hr>
<div class="row">
    <div class="col">
        <h5>Patient List</h5>
        <form method="POST" action="generate-patient.php">
        <button type="submit" class="btn btn-primary">Generate List of Patients</button>
        </form>
    </div>
    <div class="col">
        <h5>Consultation List</h5>
        <form method="POST" action="generate-consultation.php">
        <button type="submit" class="btn btn-primary">Generate List of Consultation Checkups</button>
        </form>
    </div>
</div>

<br>
<hr>
<div class="row">
    <div class="col">
        <h5>Family Planning List</h5>
        <form method="POST" action="generate-family.php">
        <button type="submit" class="btn btn-primary">Generate List of Family Planning Checkups</button>
        </form>
    </div>
    <div class="col">
        <h5>Prenatal List</h5>
        <form method="POST" action="generate-prenatal.php">
        <button type="submit" class="btn btn-primary">Generate List of Prenatal Checkups</button>
        </form>
    </div>
</div>

<br>
<hr>
<div class="row">
    <div class="col">
        <h5>Immunization</h5>
        <form method="POST" action="generate-immunization.php">
        <button type="submit" class="btn btn-primary">Generate List of Immunization Checkups</button>
        </form>
    </div>
</div>

<hr>
<div class="row">
    <div class="col">
        <h5>FHSIS Report</h5>
        <form method="POST" action="generate-fhsis.php">
        <button type="submit" class="btn btn-primary">Generate FHSIS Report</button>
        </form>
    </div>
</div>




    <!-- modal edit -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Family Planning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                <input type="hidden" id="editdataId" name="primary_id">
                      <!-- Form fields go here -->
                      <div class="form-group">
                        <label for="">Select Patient</label>
                        <select class="form-control" name="patient_id" id="editPatient_id" required>
                            <option value="" disabled selected hidden>Select a patient</option>
                            <?php

                            // Query to fetch patients from the database
                            $sql2 = "SELECT id, first_name, last_name FROM patients
                            WHERE is_active = 0 ORDER BY id DESC";
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
                                echo "<option disabled>No patients found</option>";
                            }

                            // Close the database connection
                          
                            ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="">Select Nurse</label>
                        <select class="form-control" name="nurse_id" id="editNurse_id" required>
                            <option value="" disabled selected hidden>Select a nurse</option>
                            <?php

                            $sql3 = "SELECT id, first_name, last_name FROM nurses
                            WHERE is_active = 0 ORDER BY id DESC";
                            $result3 = $conn->query($sql3);

                            if ($result3->num_rows > 0) {
                                while ($row3 = $result3->fetch_assoc()) {
                                    $nurseId = $row3['id'];
                                    $firstName2 = $row3['first_name'];
                                    $lastName2 = $row3['last_name'];

                                    // Output an option element for each patient
                                    echo "<option value='$nurseId'>$firstName2 $lastName2</option>";
                                }
                            } else {
                                echo "<option disabled>No nurse found</option>";
                            }

                            // Close the database connection
                          
                            ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="">Select Method</label>
                        <select class="form-control" name="method" id="editMethod" required>
                            <option value="" disabled selected hidden>Select a method</option>
                            <option value="Barrier Method">Barrier Method</option>
                            <option value="Hormonal Method">Hormonal Method</option>
                            <option value="Intrauterine Device">Intrauterine Device</option>
                            <option value="Permanent Method">Permanent Method</option>
                            <option value="Fertility Awareness Method">Fertility Awareness Method</option>
                            <option value="Emergency Contraception">Emergency Contraception</option>
                            <option value="Lactational Amenorrhea Method (LAM)">Lactational Amenorrhea Method (LAM)</option>
                            <option value="Withdrawal Method">Withdrawal Method</option>
                            <option value="Spermicides">Spermicides</option>
                            <option value="Sterilization">Sterilization</option>
                            <option value="Natural Methods">Natural Methods</option>
                            <option value="Male and Female Contraceptive Devices">Male and Female Contraceptive Devices</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="">Serial No.</label>
                        <input type="text" class="form-control" id="editSerial" name="serial" required>
                    </div>
                </form>
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

    document.getElementById('openModalButton').addEventListener('click', function() {
  $('#addModal').modal('show'); // Show the modal
});
    

    <?php if ($result->num_rows > 0): ?>
        var table = $('#tablebod').DataTable({
            columnDefs: [
                { targets: 0, data: 'id' },
                { targets: 1, data: 'last_name' },
                { targets: 2, data: 'checkup_date' },
                {
                    targets: 3,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return editButton + ' ' + deleteButton;
                    }
                } // Action column
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
                { targets: 2, data: 'checkup_date' },
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
    <?php endif; ?>


    $('#addButton').click(function () {

        table.destroy(); // Destroy the existing DataTable
        table = $('#tablebod').DataTable({
            columnDefs: [
                { targets: 0, data: 'id' },
                { targets: 1, data: 'last_name' },
                { targets: 2, data: 'checkup_date' },
                {
                    targets: 3,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return editButton + ' ' + deleteButton;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });

        
        // Get data from the form

        var patient_id = $('#patient_id').val();
        var nurse_id = $('#nurse_id').val();
        var serial = $('#serial').val();
        var method = $('#method').val();

        // AJAX request to send data to the server
        $.ajax({
            url: 'action/add_family.php',
            method: 'POST',
            data: {
                patient_id: patient_id,
                nurse_id: nurse_id,
                serial: serial,
                method: method,
            },
            success: function (response) {
           
                if (response.trim() === 'Success') {


                    // Clear the form fields
                    $('#patient_id').val('');
                    $('#nurse_id').val('');
                    $('#serial').val('');
                    $('#method').val('');

                    updateData();
                    $('#addModal').modal('hide');

                // Remove the modal backdrop manually
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                    // Show a success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Family Planning added successfully',
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
            url: 'action/get_family.php',
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
        title: 'Confirm Delete',
        text: 'Are you sure you want to delete this data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'action/delete_family.php',
                method: 'POST',
                data: { primary_id: deletedataId },
                success: function (response) {
                    if (response === 'Success') {
                      
                        updateData();
                        Swal.fire('Deleted', 'The Family Planning has been deleted.', 'success');
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
        url: 'action/get_family_by_id.php', // 
        method: 'POST',
        data: { primary_id: editId },
        success: function (data) {
          
            var editGetData = data; 
            
            console.log(editGetData);
            $('#editModal #editdataId').val(editGetData.id);
            $('#editModal #editPatient_id').val(editGetData.patient_id);
            $('#editModal #editNurse_id').val(editGetData.nurse_id);
            $('#editModal #editMethod').val(editGetData.method);
            $('#editModal #editSerial').val(editGetData.serial);
            $('#editModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching  data: ' + error);
        },
    });
});

$('#updateButton').click(function () {
   

    var editId = $('#editdataId').val();
    var patient_id = $('#editPatient_id').val();
    var nurse_id = $('#editNurse_id').val();
    var method = $('#editMethod').val();
    var serial = $('#editSerial').val();
  
    $.ajax({
        url: 'action/update_family.php',
        method: 'POST',
        data: {
            primary_id: editId,
            patient_id: patient_id,
            nurse_id: nurse_id,
            method: method,
            serial: serial,
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
                    text: 'Family Planning updated successfully',
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