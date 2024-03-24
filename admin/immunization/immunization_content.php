<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,immunization.id as id,patients.first_name as first_name,patients.last_name as last_name
FROM immunization
JOIN patients ON immunization.patient_id = patients.id
JOIN nurses ON nurses.id = immunization.nurse_id
WHERE immunization.mmr_remarks IS NULL AND immunization.is_deleted = 0";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">


<div style="text-align: left; float: left;">
        <button type="button" id="openModalButton" class="btn btn-primary" style="display:none">
        Add Child Immunization Record
        </button>
    </div>

<br><br>


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Child Immunization Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm">
        
        <h5>IMMUNIZATION RECORD</h5>
        <hr>

               <div class="row">
                    <div class="col">
                        <div class="form-group">
                                <label for="">Select Patient</label>
                                <select class="form-control" name="patient_id" id="patient_id" required>
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
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-3">
                        <label for="">Bakuna</label>
                    </div>

                    <div class="col-1">
                        <label for="">Doses</label>
                    </div>

                    <div class="col-6">
                        <label for="">Petsa ng Bakuna</label>
                    </div>
                    
                    <div class="col-2">
                        <label for="">Remarks</label>
                    </div>
             </div>


                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>BCG Vaccine</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>At Birth</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <input type="date" class="form-control" id="bgc_date" name="bgc_date" required>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="bgc_remarks" name="bgc_remarks" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Hepatitis B Vaccine</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>At Birth</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <input type="date" class="form-control" id="hepa_date" name="hepa_date" required>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="hepa_remarks" name="hepa_remarks" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Pentavalent Vaccine (DPT-Hep B-HIB)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>At Birth</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="pentavalent_date1" name="pentavalent_date1" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pentavalent_date2" name="pentavalent_date2" required>         
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pentavalent_date3" name="pentavalent_date3" required>
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="pentavalent_remarks" name="pentavalent_remarks" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Oral Polio Vaccine (OPV)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>1½,2½,3½ Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="oral_date1" name="oral_date1" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="oral_date2" name="oral_date2" required>         
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="oral_date3" name="oral_date3" required>
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="oral_remarks" name="oral_remarks" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Inactivated Polio Vaccine (IPV)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>3½ and 9 Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="ipv_date1" name="ipv_date1" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="ipv_date2" name="ipv_date2" required>         
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="ipv_remarks" name="ipv_remarks" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Pneumococcal Conjugate Vaccine (PCV)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>1½,2½,3½ Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="pcv_date1" name="pcv_date1" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pcv_date2" name="pcv_date2" required>         
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pcv_date3" name="pcv_date3" required>         
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="pcv_remarks" name="pcv_remarks" required>
                        </div>
                    </div>
             </div>
<hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Measles,Mumps,Rubella Vaccine (MMR)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>1½,2½,3½ Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="mmr_date1" name="mmr_date1" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="mmr_date2" name="mmr_date2" required>         
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="mmr_remarks" name="mmr_remarks" required>
                        </div>
                    </div>
             </div>

             


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                <button type="submit" class="btn btn-primary" id="addButton">Save</button>
            </div>
        </div>  </div>  </div>
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
                                <td class="align-middle"><?php echo $row['last_name']; ?></td>
                                <td class="align-middle"><?php echo $row['checkup_date']; ?></td>
                                <td class="align-middle">                                <button type="button" class="btn btn-success editbtn" data-row-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-edit"></i> Update Immunization Record
                                </button>
                                  <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Immunization Found</td>
                                <td class="align-middle"></td>
                                <td class="align-middle"><td>
                            
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Immunization</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                <input type="hidden" id="editdataId" name="primary_id">
                      <!-- Form fields go here -->
                            
        <h5>IMMUNIZATION RECORD</h5>
        <hr>
                      <div class="row">
                    <div class="col">
                        <div class="form-group">
                                <label for="">Select Patient</label>
                                <select class="form-control" name="patient_id2" id="patient_id2" required>
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
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-3">
                        <label for="">Bakuna</label>
                    </div>

                    <div class="col-1">
                        <label for="">Doses</label>
                    </div>

                    <div class="col-6">
                        <label for="">Petsa ng Bakuna</label>
                    </div>
                    
                    <div class="col-2">
                        <label for="">Remarks</label>
                    </div>
             </div>


                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>BCG Vaccine</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>At Birth</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <input type="date" class="form-control" id="bgc_date2" name="bgc_date2" required>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="bgc_remarks2" name="bgc_remarks2" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Hepatitis B Vaccine</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>At Birth</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <input type="date" class="form-control" id="hepa_date2" name="hepa_date2" required>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="hepa_remarks2" name="hepa_remarks2" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Pentavalent Vaccine (DPT-Hep B-HIB)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>At Birth</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="pentavalent_date12" name="pentavalent_date12" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pentavalent_date22" name="pentavalent_date22" required>         
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pentavalent_date32" name="pentavalent_date32" required>
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="pentavalent_remarks2" name="pentavalent_remarks2" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Oral Polio Vaccine (OPV)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>1½,2½,3½ Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="oral_date12" name="oral_date12" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="oral_date22" name="oral_date22" required>         
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="oral_date32" name="oral_date32" required>
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="oral_remarks2" name="oral_remarks2" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Inactivated Polio Vaccine (IPV)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>3½ and 9 Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="ipv_date12" name="ipv_date12" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="ipv_date22" name="ipv_date22" required>         
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="ipv_remarks2" name="ipv_remarks2" required>
                        </div>
                    </div>
             </div>
             <hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Pneumococcal Conjugate Vaccine (PCV)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>1½,2½,3½ Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="pcv_date12" name="pcv_date12" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pcv_date22" name="pcv_date22" required>         
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="pcv_date32" name="pcv_date32" required>         
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="pcv_remarks2" name="pcv_remarks2" required>
                        </div>
                    </div>
             </div>
<hr>
             <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Measles,Mumps,Rubella Vaccine (MMR)</p>
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="form-group">
                            <p>1½,2½,3½ Months</p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                              <div class="row">
                              <div class="col">
                                           <input type="date" class="form-control" id="mmr_date12" name="mmr_date12" required>
                                    </div>
                                    <div class="col">
                                            <input type="date" class="form-control" id="mmr_date22" name="mmr_date22" required>         
                                    </div>
                              </div>
                            </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <input type="text" class="form-control" id="mmr_remarks2" name="mmr_remarks2" required>
                        </div>
                    </div>
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
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Update Immunization Record</button>';
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
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Update Immunization Record</button>';
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
var bgc_date = $('#bgc_date').val();
var bgc_remarks = $('#bgc_remarks').val();
var hepa_date = $('#hepa_date').val();
var hepa_remarks = $('#hepa_remarks').val();
var pentavalent_date1 = $('#pentavalent_date1').val();
var pentavalent_date2 = $('#pentavalent_date2').val();
var pentavalent_date3 = $('#pentavalent_date3').val();
var pentavalent_remarks = $('#pentavalent_remarks').val();
var oral_date1 = $('#oral_date1').val();
var oral_date2 = $('#oral_date2').val();
var oral_date3 = $('#oral_date3').val();
var oral_remarks = $('#oral_remarks').val();
var ipv_date1 = $('#ipv_date1').val();
var ipv_date2 = $('#ipv_date2').val();
var ipv_remarks = $('#ipv_remarks').val();
var pcv_date1 = $('#pcv_date1').val();
var pcv_date2 = $('#pcv_date2').val();
var pcv_date3 = $('#pcv_date3').val();
var pcv_remarks = $('#pcv_remarks').val();
var mmr_date1 = $('#mmr_date1').val();
var mmr_date2 = $('#mmr_date2').val();
var mmr_remarks = $('#mmr_remarks').val();

// AJAX request to send data to the server
$.ajax({
    url: 'action/add_family.php',
    method: 'POST',
    data: {
        patient_id: patient_id,
        bgc_date: bgc_date,
        bgc_remarks: bgc_remarks,
        hepa_date: hepa_date,
        hepa_remarks: hepa_remarks,
        pentavalent_date1: pentavalent_date1,
        pentavalent_date2: pentavalent_date2,
        pentavalent_date3: pentavalent_date3,
        pentavalent_remarks: pentavalent_remarks,
        oral_date1: oral_date1,
        oral_date2: oral_date2,
        oral_date3: oral_date3,
        oral_remarks: oral_remarks,
        ipv_date1: ipv_date1,
        ipv_date2: ipv_date2,
        ipv_remarks: ipv_remarks,
        pcv_date1: pcv_date1,
        pcv_date2: pcv_date2,
        pcv_date3: pcv_date3,
        pcv_remarks: pcv_remarks,
        mmr_date1: mmr_date1,
        mmr_date2: mmr_date2,
        mmr_remarks: mmr_remarks,
    },
    success: function (response) {
        if (response.trim() === 'Success') {
            // Clear the form fields
            $('#patient_id').val('');
            $('#bgc_date').val('');
            $('#bgc_remarks').val('');
            $('#hepa_date').val('');
            $('#hepa_remarks').val('');
            $('#pentavalent_date1').val('');
            $('#pentavalent_date2').val('');
            $('#pentavalent_date3').val('');
            $('#pentavalent_remarks').val('');
            $('#oral_date1').val('');
            $('#oral_date2').val('');
            $('#oral_date3').val('');
            $('#oral_remarks').val('');
            $('#ipv_date1').val('');
            $('#ipv_date2').val('');
            $('#ipv_remarks').val('');
            $('#pcv_date1').val('');
            $('#pcv_date2').val('');
            $('#pcv_date3').val('');
            $('#pcv_remarks').val('');
            $('#mmr_date1').val('');
            $('#mmr_date2').val('');
            $('#mmr_remarks').val('');
    

                    updateData();
                    $('#addModal').modal('hide');

                // Remove the modal backdrop manually
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                    // Show a success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Immunization added successfully',
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
                        Swal.fire('Deleted', 'The Immunization has been deleted.', 'success');
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
            $('#editModal #patient_id2').val(editGetData.patient_id);
            $('#editModal #bgc_date2').val(editGetData.bgc_date);
            $('#editModal #bgc_remarks2').val(editGetData.bgc_remarks);

            $('#editModal #hepa_date2').val(editGetData.hepa_date);
            $('#editModal #hepa_remarks2').val(editGetData.hepa_remarks);

            $('#editModal #pentavalent_date12').val(editGetData.pentavalent_date1);
            $('#editModal #pentavalent_date22').val(editGetData.pentavalent_date2);
            $('#editModal #pentavalent_date32').val(editGetData.pentavalent_date3);
            $('#editModal #pentavalent_remarks2').val(editGetData.pentavalent_remarks);

            $('#editModal #oral_date12').val(editGetData.oral_date1);
            $('#editModal #oral_date22').val(editGetData.oral_date2);
            $('#editModal #oral_date32').val(editGetData.oral_date3);
            $('#editModal #oral_remarks2').val(editGetData.oral_remarks);

            $('#editModal #ipv_date12').val(editGetData.ipv_date1);
            $('#editModal #ipv_date22').val(editGetData.ipv_date2);
            $('#editModal #ipv_remarks2').val(editGetData.ipv_remarks);

            $('#editModal #pcv_date12').val(editGetData.pcv_date1);
            $('#editModal #pcv_date22').val(editGetData.pcv_date2);

            $('#editModal #pcv_date32').val(editGetData.pcv_date3);
            $('#editModal #pcv_remarks2').val(editGetData.pcv_remarks);

            $('#editModal #mmr_date12').val(editGetData.mmr_date1);
            $('#editModal #mmr_date22').val(editGetData.mmr_date2);
            $('#editModal #mmr_remarks2').val(editGetData.mmr_remarks);


        

       
            $('#editModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching  data: ' + error);
        },
    });
});

$('#updateButton').click(function () {
    var editId = $('#editdataId').val();
    var bgc_date = $('#bgc_date2').val();
    var bgc_remarks = $('#bgc_remarks2').val();
    var hepa_date = $('#hepa_date2').val();
    var hepa_remarks = $('#hepa_remarks2').val();
    var pentavalent_date1 = $('#pentavalent_date12').val();
    var pentavalent_date2 = $('#pentavalent_date22').val();
    var pentavalent_date3 = $('#pentavalent_date32').val();
    var pentavalent_remarks = $('#pentavalent_remarks2').val();
    var oral_date1 = $('#oral_date12').val();
    var oral_date2 = $('#oral_date22').val();
    var oral_date3 = $('#oral_date32').val();
    var oral_remarks = $('#oral_remarks2').val();
    var ipv_date1 = $('#ipv_date12').val();
    var ipv_date2 = $('#ipv_date22').val();
    var ipv_remarks = $('#ipv_remarks2').val();
    var pcv_date1 = $('#pcv_date12').val();
    var pcv_date2 = $('#pcv_date22').val();
    var pcv_date3 = $('#pcv_date32').val();
    var pcv_remarks = $('#pcv_remarks2').val();
    var mmr_date1 = $('#mmr_date12').val();
    var mmr_date2 = $('#mmr_date22').val();
    var mmr_remarks = $('#mmr_remarks2').val();

    $.ajax({
        url: 'action/update_family.php',
        method: 'POST',
        data: {
            primary_id: editId,
            bgc_date: bgc_date,
            bgc_remarks: bgc_remarks,
            hepa_date: hepa_date,
            hepa_remarks: hepa_remarks,
            pentavalent_date1: pentavalent_date1,
            pentavalent_date2: pentavalent_date2,
            pentavalent_date3: pentavalent_date3,
            pentavalent_remarks: pentavalent_remarks,
            oral_date1: oral_date1,
            oral_date2: oral_date2,
            oral_date3: oral_date3,
            oral_remarks: oral_remarks,
            ipv_date1: ipv_date1,
            ipv_date2: ipv_date2,
            ipv_remarks: ipv_remarks,
            pcv_date1: pcv_date1,
            pcv_date2: pcv_date2,
            pcv_date3: pcv_date3,
            pcv_remarks: pcv_remarks,
            mmr_date1: mmr_date1,
            mmr_date2: mmr_date2,
            mmr_remarks: mmr_remarks,
        },
        success: function (response) {
            if (response.trim() === 'Success') {
                if (response === 'Success') {
                      
                      updateData();
                      Swal.fire('Updated', 'The Immunization has been updated.', 'success');
                  } else {
                      Swal.fire('Error', 'Error deleting data: ' + response, 'error');
                  }
                $('#editModal').modal('hide');
                // You may also want to refresh or update the data on your page.
            } else {
                // Handle error response if needed.
                console.error('Error updating data: ' + response);
            }
        },
        error: function (error) {
            console.error('Error updating data: ' + error);
        },
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