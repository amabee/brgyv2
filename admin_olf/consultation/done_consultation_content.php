<?php
// Include your database configuration file
include_once('../../config.php');



$sql = "SELECT *,consultations.id as id,CONCAT(patients.first_name, ' ', patients.last_name) AS full_name
FROM consultations
JOIN patients ON consultations.patient_id = patients.id
JOIN admins ON admins.id = consultations.doctor_id
WHERE consultations.is_active = 0 AND admins.user_id = $user_id AND consultations.is_print = 1" ;


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
<div style="text-align: left; float: left;">
        <button type="button" id="openModalButton" class="btn btn-primary" style="display:none">
            Add Consultation
        </button>
    </div>
  

<br><br>


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="">Select Patient</label>
                        <select class="form-control" name="patient_id" id="patient_id" required>
                            <option value="" disabled selected hidden>Select a patient</option>
                            <?php

                            // Query to fetch patients from the database
                            $sql2 = "SELECT id, first_name, last_name FROM patients ORDER BY id DESC";
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
                        <label for="">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Diagnosis</label>
                        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Prescription</label>
                        <textarea class="form-control" id="medicine" name="medicine" rows="3" required></textarea>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                <button type="submit" class="btn btn-primary" id="addButton">Save</button>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="tablebod" class="table table-head-fixed text-nowrap table-striped" >
                    <thead class="thead-light">
                        <tr>
                        <th>ID</th>
                            <th>Patient Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                            <td class="align-middle"><?php echo $row['id']; ?></td>
                                <td class="align-middle"><?php echo $row['full_name']; ?></td>
                                <td class="align-middle"><?php echo $row['description']; ?></td>
                                <td class="align-middle"><?php echo $row['checkup_date']; ?></td>
                                <td class="align-middle">
                                <button type="button" class="btn btn-success editbtn" data-row-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-eye"></i> View Consultation
                                </button>
                                  <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>
                            <form method="POST" action="generate-receipt.php?id=<?php echo $row['id']; ?>"><button type="submit" class="btn  btn-primary mt-2 printbtn"><i class="fa fa-file"></i> Generate Prescription</button></form>
                            <form method="POST" action="generate-referral.php?id=<?php echo $row['id']; ?>"><button type="submit" class="btn  btn-info mt-2 referralbtn"><i class="fas fa-file-alt"></i> Generate Referral</button></form>
                            
                        </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Consultation Found</td>
                                <td class="align-middle"></td>
                                <td class="align-middle"><td>
                                <td class="align-middle"></td>
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Diagnosis</label>
                        <textarea class="form-control" id="editDiagnosis" name="diagnosis" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Prescription</label>
                        <textarea class="form-control" id="editMedicine" name="medicine" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
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
                { targets: 2, data: 'description' },
                { targets: 3, data: 'checkup_date' },
                {
                    targets: 4,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i>  View Consultation</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        var receiptButton = '<form method="POST" action="generate-receipt.php?id=' + row.id + '"><button type="submit" class="btn btn-primary mt-2 printbtn"><i class="fa fa-file"></i> Generate Prescription</button></form>';
                        var referralButton = '<form method="POST" action="generate-referral.php?id=<?php echo $row['id']; ?>"><button type="submit" class="btn  btn-info mt-2 referralbtn"><i class="fas fa-file"></i> Generate Referral</button></form>';
                            
    return editButton + ' ' + deleteButton+' '+receiptButton + referralButton;
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
                { targets: 2, data: 'description' },
                { targets: 3, data: 'checkup_date' },
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
                { targets: 2, data: 'description' },
                { targets: 3, data: 'checkup_date' },
                {
                    targets: 4,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i>  View Consultation</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        var receiptButton = '<form method="POST" action="generate-receipt.php?id=' + row.id + '"><button type="submit" class="btn btn-primary mt-2 printbtn"><i class="fa fa-file"></i> Generate Prescription</button></form>';
                        var referralButton = '<form method="POST" action="generate-referral.php?id=<?php echo $row['id']; ?>"><button type="submit" class="btn  btn-info mt-2 referralbtn"><i class="fas fa-file"></i> Generate Referral</button></form>';
                            
    return editButton + ' ' + deleteButton+' '+receiptButton + referralButton;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
        
        // Get data from the form

        var patient_id = $('#patient_id').val();
        var description = $('#description').val();
        var diagnosis = $('#diagnosis').val();
        var medicine = $('#medicine').val();

        // AJAX request to send data to the server
        $.ajax({
            url: 'action/add_consultation.php',
            method: 'POST',
            data: {
                patient_id: patient_id,
                description: description,
                diagnosis: diagnosis,
                medicine: medicine,
            },
            success: function (response) {
           
                if (response.trim() === 'Success') {


                    // Clear the form fields
                    $('#patient_id').val('');
                    $('#description').val('');
                    $('#diagnosis').val('');
                    $('#medicine').val('');

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
            url: 'action/get_consultation.php',
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
                url: 'action/delete_consultation.php',
                method: 'POST',
                data: { primary_id: deletedataId },
                success: function (response) {
                    if (response === 'Success') {
                      
                        updateData();
                        Swal.fire('Deleted', 'The Consultation has been deleted.', 'success');
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
            $('#editModal #editPatient_id').val(editGetData.patient_id);
            $('#editModal #editDescription').val(editGetData.description);
            $('#editModal #editDiagnosis').val(editGetData.diagnosis);
            $('#editModal #editMedicine').val(editGetData.medicine);
           
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
    var description = $('#editDescription').val();
    var diagnosis = $('#editDiagnosis').val();
    var medicine = $('#editMedicine').val();
  
    $.ajax({
        url: 'action/update_consultation.php',
        method: 'POST',
        data: {
            primary_id: editId,
            patient_id: patient_id,
            description: description,
            diagnosis: diagnosis,
            medicine: medicine,
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

