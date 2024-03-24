<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,consultations.id as id,last_name
FROM consultations
JOIN patients ON consultations.patient_id = patients.id
WHERE consultations.is_active = 0 AND  consultations.is_deleted=0";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
    <div style="text-align: left; float: left;">
        <button type="button" id="openModalButton" class="btn btn-primary">
            Add Consultation
        </button>
    </div>

    <a href="archive_consultation.php">
        <button type="button" id="openModalButton" class="btn btn-danger ml-1">
            View Archive
        </button>
    </a>

    <a href="history_consultation.php">
        <button type="button" id="openModalButton" class="btn btn-warning ml-1">
            View History
        </button>
    </a>
    <br><br>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
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
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="patient">Select Patient</label>
                                    <input list="patients" class="form-control" name="patient_id" id="patient_id"
                                        required>
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
                                    <input type="hidden" name="serial_no" id="serial_no">


                                </div>

                                <script>
                                    // Add a JavaScript event listener to update the input field
                                    const patientInput = document.getElementById('patient_id');
                                    patientInput.addEventListener('input', function () {
                                        const selectedOption = document.querySelector('datalist#patients option[value="' + this.value + '"]');
                                        if (selectedOption) {
                                            this.value = selectedOption.innerText; // Update the input text
                                            patient_id = selectedOption.value; // Set patient_id to the value of the selected option (serial_no)
                                            $('#serial_no').val(patient_id);
                                        }
                                    });
                                </script>
                            </div>
                            <div class="col-sm">
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
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="">Checkup Date</label>
                                    <input type="date" class="form-control" id="checkup_date" name="checkup_date"
                                        required>
                                </div>
                            </div>
                        </div>
                        <script>
                            var today = new Date();
                            var dd = String(today.getDate()).padStart(2, '0');
                            var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                            var yyyy = today.getFullYear();

                            today = yyyy + '-' + mm + '-' + dd;
                            document.getElementById('checkup_date').min = today;
                        </script>


                        <div class="row">
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Subjective</label>
                                    <textarea class="form-control" id="subjective" name="subjective" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Objective</label>
                                    <textarea class="form-control" id="objective" name="objective" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Assessment</label>
                                    <textarea class="form-control" id="assessment" name="assessment" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Plan</label>
                                    <textarea class="form-control" id="plan" name="plan" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">

                                <hr>
                                <h5>PHYSICAL EXAMINATIONs</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Weight</label>
                                            <input type="nutextmber" class="form-control" id="weight" name="weight"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Blood Pressure</label>
                                            <input type="text" class="form-control" id="bp" name="bp" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Height</label>
                                            <input type="text" class="form-control" id="height" name="height" required>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Pulse Rate</label>
                                            <input type="text" class="form-control" id="pulse" name="pulse" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Skin</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalSkinRadio" name="skin" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="paleSkinRadio" name="skin" value="Pale"
                                                    class="radio-input" required>
                                                <label for="paleSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Pale</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="yellowishSkinRadio" name="skin"
                                                    value="Yellowish" class="radio-input" required>
                                                <label for="yellowishSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="hematomaSkinRadio" name="skin" value="Hematoma"
                                                    class="radio-input" required>
                                                <label for="hematomaSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Hematoma</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Extremities</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalRadio" name="extremities" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="edemaRadio" name="extremities" value="Edema"
                                                    class="radio-input" required>
                                                <label for="edemaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Edema</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="varicositiesRadio" name="extremities"
                                                    value="Varicosities" class="radio-input" required>
                                                <label for="varicositiesRadio" class="radio-label"
                                                    style="margin-left: 5px;">Varicosities</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Conjunctiva</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalConjunctivaRadio" name="conjunctiva"
                                                    value="Normal" class="radio-input" required>
                                                <label for="normalConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="paleConjunctivaRadio" name="conjunctiva"
                                                    value="Pale" class="radio-input" required>
                                                <label for="paleConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Pale</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="yellowishConjunctivaRadio" name="conjunctiva"
                                                    value="Yellowish" class="radio-input" required>
                                                <label for="yellowishConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Neck</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalNeckRadio" name="neck" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalNeckRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="enlargeLymphNodesRadio" name="neck"
                                                    value="Enlarge Lymph Nodes" class="radio-input" required>
                                                <label for="enlargeLymphNodesRadio" class="radio-label"
                                                    style="margin-left: 5px;">Enlarge Lymph Nodes</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <hr>
                        <h5>FAMILY HISTORY</h5>
                        <hr>
                        <div class="row">
                            <div class="col-sm">
                                <div class="row">
                                    <div class="col">
                                        <label for="medical_conditions">Does the client have any of the
                                            following?</label>
                                        <br>
                                        <div class="form-group">

                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_headaches"
                                                        name="medical_condition" value="severe_headaches">
                                                    <label class="checkbox-label">severe headaches/migraine</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="history_stroke_heart_attack_hypertension"
                                                        name="medical_condition"
                                                        value="history_stroke_heart_attack_hypertension">
                                                    <label class="checkbox-label">history of stroke / heart attack /
                                                        hypertension</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding"
                                                        name="medical_condition" value="hematoma_bruising_gum_bleeding">
                                                    <label class="checkbox-label">non-traumatic hematoma / frequent
                                                        bruising or gum bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="breast_cancer_breast_mass"
                                                        name="medical_condition" value="breast_cancer_breast_mass">
                                                    <label class="checkbox-label">current or history of breast
                                                        cancer/breast mass</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_chest_pain"
                                                        name="medical_condition" value="severe_chest_pain">
                                                    <label class="checkbox-label">severe chest pain</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="cough_more_than_14_days"
                                                        name="medical_condition" value="cough_more_than_14_days">
                                                    <label class="checkbox-label">cough for more than 14 days</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="checkbox-list">
                                                <br>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="jaundice" name="medical_condition"
                                                        value="jaundice">
                                                    <label class="checkbox-label">jaundice</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_bleeding"
                                                        name="medical_condition" value="vaginal_bleeding">
                                                    <label class="checkbox-label">unexplained vaginal bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_discharge"
                                                        name="medical_condition" value="vaginal_discharge">
                                                    <label class="checkbox-label">abnormal vaginal discharge</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="phenobarbital_rifampicin"
                                                        name="medical_condition" value="phenobarbital_rifampicin">
                                                    <label class="checkbox-label">intake of phenobarbital (anti-seizure)
                                                        or rifampicin (anti-TB)</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="smoker" name="medical_condition"
                                                        value="smoker">
                                                    <label class="checkbox-label">Is the client a SMOKER?</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="with_disability" name="medical_condition"
                                                        value="with_disability">
                                                    <label class="checkbox-label">With Disability?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>




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
                            <th>Serial Number</th>
                            <th>Patient Name</th>
                            <th>Subjective</th>
                            <th>Objective</th>
                            <th>Assessment</th>
                            <th>Plan</th>
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
                                    <td class="align-middle tago">
                                        <?php echo $row['id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['serial_no']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['last_name']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['subjective']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['objective']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['assessment']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['plan']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['checkup_date']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-success editbtn"
                                            data-row-id="<?php echo $row['id']; ?>">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                        <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i
                                                class="fas fa-trash"></i> Inactive</button>

                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle"></td>
                                <td class="align-middle">No Consultation Found</td>
                                <td class="align-middle">
                                <td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
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
                        <div class="row">


                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="">Select Doctor</label>
                                    <select class="form-control" name="doctor_id2" id="doctor_id2" required>
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
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="">Checkup Date</label>
                                    <input type="date" class="form-control" id="checkup_date2" name="checkup_date2"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Subjective</label>
                                    <textarea class="form-control" id="subjective2" name="subjective2" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Objective</label>
                                    <textarea class="form-control" id="objective2" name="objective2" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Assessment</label>
                                    <textarea class="form-control" id="assessment2" name="assessment2" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Plan</label>
                                    <textarea class="form-control" id="plan2" name="plan2" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">

                                <hr>
                                <h5>PHYSICAL EXAMINATION</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Weight</label>
                                            <input type="nutextmber" class="form-control" id="weight2" name="weight2"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Blood Pressure</label>
                                            <input type="text" class="form-control" id="bp2" name="bp2" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Height</label>
                                            <input type="text" class="form-control" id="height2" name="height2"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Pulse Rate</label>
                                            <input type="text" class="form-control" id="pulse2" name="pulse2" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Skin</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalSkinRadio2" name="skin2" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="paleSkinRadio2" name="skin2" value="Pale"
                                                    class="radio-input" required>
                                                <label for="paleSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Pale</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="yellowishSkinRadio2" name="skin2"
                                                    value="Yellowish" class="radio-input" required>
                                                <label for="yellowishSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="hematomaSkinRadio2" name="skin2"
                                                    value="Hematoma" class="radio-input" required>
                                                <label for="hematomaSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Hematoma</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Extremities</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalRadio2" name="extremities2" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="edemaRadio2" name="extremities2" value="Edema"
                                                    class="radio-input" required>
                                                <label for="edemaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Edema</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="varicositiesRadio2" name="extremities2"
                                                    value="Varicosities" class="radio-input" required>
                                                <label for="varicositiesRadio" class="radio-label"
                                                    style="margin-left: 5px;">Varicosities</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Conjunctiva</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalConjunctivaRadio2" name="conjunctiva2"
                                                    value="Normal" class="radio-input" required>
                                                <label for="normalConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="paleConjunctivaRadio2" name="conjunctiva2"
                                                    value="Pale" class="radio-input" required>
                                                <label for="paleConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Pale</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="yellowishConjunctivaRadio2" name="conjunctiva2"
                                                    value="Yellowish" class="radio-input" required>
                                                <label for="yellowishConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Neck</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalNeckRadio2" name="neck2" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalNeckRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="enlargeLymphNodesRadio2" name="neck2"
                                                    value="Enlarge Lymph Nodes" class="radio-input" required>
                                                <label for="enlargeLymphNodesRadio" class="radio-label"
                                                    style="margin-left: 5px;">Enlarge Lymph Nodes</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <hr>
                        <h5>FAMILY HISTORY</h5>
                        <hr>
                        <div class="row">
                            <div class="col-sm">
                                <div class="row">
                                    <div class="col">
                                        <label for="medical_conditions">Does the client have any of the
                                            following?</label>
                                        <br>
                                        <div class="form-group">

                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_headaches2"
                                                        name="medical_condition" value="severe_headaches">
                                                    <label class="checkbox-label">severe headaches/migraine</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox"
                                                        id="history_stroke_heart_attack_hypertension2"
                                                        name="medical_condition"
                                                        value="history_stroke_heart_attack_hypertension">
                                                    <label class="checkbox-label">history of stroke / heart attack /
                                                        hypertension</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding2"
                                                        name="medical_condition" value="hematoma_bruising_gum_bleeding">
                                                    <label class="checkbox-label">non-traumatic hematoma / frequent
                                                        bruising or gum bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="breast_cancer_breast_mass2"
                                                        name="medical_condition" value="breast_cancer_breast_mass">
                                                    <label class="checkbox-label">current or history of breast
                                                        cancer/breast mass</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_chest_pain2"
                                                        name="medical_condition" value="severe_chest_pain">
                                                    <label class="checkbox-label">severe chest pain</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="cough_more_than_14_days2"
                                                        name="medical_condition" value="cough_more_than_14_days">
                                                    <label class="checkbox-label">cough for more than 14 days</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="checkbox-list">
                                                <br>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="jaundice2" name="medical_condition"
                                                        value="jaundice">
                                                    <label class="checkbox-label">jaundice</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_bleeding2"
                                                        name="medical_condition" value="vaginal_bleeding">
                                                    <label class="checkbox-label">unexplained vaginal bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_discharge2"
                                                        name="medical_condition" value="vaginal_discharge">
                                                    <label class="checkbox-label">abnormal vaginal discharge</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="phenobarbital_rifampicin2"
                                                        name="medical_condition" value="phenobarbital_rifampicin">
                                                    <label class="checkbox-label">intake of phenobarbital (anti-seizure)
                                                        or rifampicin (anti-TB)</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="smoker2" name="medical_condition"
                                                        value="smoker">
                                                    <label class="checkbox-label">Is the client a SMOKER?</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="with_disability2"
                                                        name="medical_condition" value="with_disability">
                                                    <label class="checkbox-label">With Disability?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
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

            document.getElementById('openModalButton').addEventListener('click', function () {
                $('#addModal').modal('show'); // Show the modal
            });


            <?php if ($result->num_rows > 0): ?>
                var table = $('#tablebod').DataTable({
                    columnDefs: [
                        { targets: 0, data: 'id', visible: false },
                        { targets: 1, data: 'serial_no' },
                        { targets: 2, data: 'last_name' },
                        { targets: 3, data: 'subjective' },
                        { targets: 4, data: 'objective' },
                        { targets: 5, data: 'assessment' },
                        { targets: 6, data: 'plan' },
                        { targets: 7, data: 'checkup_date' },
                        {
                            targets: 8,
                            searchable: false,
                            data: null,
                            render: function (data, type, row) {
                                var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Update</button>';
                                var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-user-times"></i> Inactive</button>';
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
                        { targets: 0, data: 'id', visible: false },
                        { targets: 1, data: 'serial_no' },
                        { targets: 2, data: 'last_name' },
                        { targets: 3, data: 'subjective' },
                        { targets: 4, data: 'objective' },
                        { targets: 5, data: 'assessment' },
                        { targets: 6, data: 'plan' },
                        { targets: 7, data: 'checkup_date' },
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
                        { targets: 0, data: 'id', visible: false },
                        { targets: 1, data: 'serial_no' },
                        { targets: 2, data: 'last_name' },
                        { targets: 3, data: 'subjective' },
                        { targets: 4, data: 'objective' },
                        { targets: 5, data: 'assessment' },
                        { targets: 6, data: 'plan' },
                        { targets: 7, data: 'checkup_date' },
                        {
                            targets: 8,
                            searchable: false,
                            data: null,
                            render: function (data, type, row) {
                                var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Update</button>';
                                var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="bi bi-person-dash"></i> Inactive</button>';
                                return editButton + ' ' + deleteButton;
                            }
                        } // Action column
                    ],
                    // Set the default ordering to 'id' column in descending order
                    order: [[0, 'desc']]
                });

                // Get data from the form

                var patient_id = $('#serial_no').val();
                var subjective = $('#subjective').val();
                var objective = $('#objective').val();
                var assessment = $('#assessment').val();
                var plan = $('#plan').val();
                var checkup_date = $('#checkup_date').val();
                var doctor_id = $('#doctor_id').val();
                // 
                var weight = $('#weight').val();
                var bp = $('#bp').val();
                var height = $('#height').val();
                var pulse = $('#pulse').val();
                var extremities = $('input[name="extremities"]:checked').val()
                var skin = $('input[name="skin"]:checked').val();
                var conjunctiva = $('input[name="conjunctiva"]:checked').val();
                var neck = $('input[name="neck"]:checked').val();

                var severe_headaches = $('#severe_headaches').is(':checked') ? 'Yes' : 'No';
                var jaundice = $('#jaundice').is(':checked') ? 'Yes' : 'No';
                var history_stroke_heart_attack_hypertension = $('#history_stroke_heart_attack_hypertension').is(':checked') ? 'Yes' : 'No';
                var hematoma_bruising_gum_bleeding = $('#hematoma_bruising_gum_bleeding').is(':checked') ? 'Yes' : 'No';
                var breast_cancer_breast_mass = $('#breast_cancer_breast_mass').is(':checked') ? 'Yes' : 'No';
                var severe_chest_pain = $('#severe_chest_pain').is(':checked') ? 'Yes' : 'No';
                var cough_more_than_14_days = $('#cough_more_than_14_days').is(':checked') ? 'Yes' : 'No';
                var vaginal_bleeding = $('#vaginal_bleeding').is(':checked') ? 'Yes' : 'No';
                var vaginal_discharge = $('#vaginal_discharge').is(':checked') ? 'Yes' : 'No';
                var phenobarbital_rifampicin = $('#phenobarbital_rifampicin').is(':checked') ? 'Yes' : 'No';
                var smoker = $('#smoker').is(':checked') ? 'Yes' : 'No';
                var with_disability = $('#with_disability').is(':checked') ? 'Yes' : 'No';
                // 



                // AJAX request to send data to the server
                $.ajax({
                    url: 'action/add_consultation.php',
                    method: 'POST',
                    data: {
                        patient_id: patient_id,
                        subjective: subjective,
                        objective: objective,
                        assessment: assessment,
                        plan: plan,
                        doctor_id: doctor_id,
                        checkup_date: checkup_date,
                        weight: weight,
                        bp: bp,
                        height: height,
                        pulse: pulse,
                        skin: skin,
                        extremities: extremities,
                        conjunctiva: conjunctiva,
                        neck: neck,
                        severe_headaches: severe_headaches,
                        history_stroke_heart_attack_hypertension: history_stroke_heart_attack_hypertension,
                        hematoma_bruising_gum_bleeding: hematoma_bruising_gum_bleeding,
                        breast_cancer_breast_mass: breast_cancer_breast_mass,
                        severe_chest_pain: severe_chest_pain,
                        cough_more_than_14_days: cough_more_than_14_days,
                        vaginal_bleeding: vaginal_bleeding,
                        vaginal_discharge: vaginal_discharge,
                        phenobarbital_rifampicin: phenobarbital_rifampicin,
                        smoker: smoker,
                        jaundice: jaundice,
                        with_disability: with_disability,
                    },
                    success: function (response) {

                        if (response.trim() === 'Success') {


                            // Clear the form fields
                            $('#patient_id').val('');
                            $('#subjective').val('');
                            $('#objective').val('');
                            $('#assessment').val('');
                            $('#plan').val('');
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
                    title: 'Confirm Inactive',
                    text: 'Are you sure you want to Inactive this data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Inactive it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'action/delete_consultation.php',
                            method: 'POST',
                            data: { primary_id: deletedataId },
                            success: function (response) {
                                if (response === 'Success') {

                                    updateData();
                                    Swal.fire('Inactive', 'The Patient Consultation has been Inactive.', 'success');
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

                        console.log(editGetData.id);
                        $('#editModal #editdataId').val(editGetData.id);
                        $('#editModal #doctor_id2').val(editGetData.doctor_id);
                        $('#editModal #checkup_date2').val(editGetData.checkup_date);
                        $('#editModal #subjective2').val(editGetData.subjective);
                        $('#editModal #objective2').val(editGetData.objective);
                        $('#editModal #assessment2').val(editGetData.assessment);
                        $('#editModal #plan2').val(editGetData.plan);
                        $('#editModal #weight2').val(editGetData.weight);
                        $('#editModal #bp2').val(editGetData.bp);

                        $('#editModal #height2').val(editGetData.height);
                        $('#editModal #pulse2').val(editGetData.pulse);


                        if (editGetData.skin === "Normal") {
                            $('#normalSkinRadio2').prop('checked', true);
                        } else if (editGetData.skin === "Pale") {
                            $('#paleSkinRadio2').prop('checked', true);
                        } else if (editGetData.skin === "Yellowish") {
                            $('#yellowishSkinRadio2').prop('checked', true);
                        } else if (editGetData.skin === "Hematoma") {
                            $('#hematomaSkinRadio2').prop('checked', true);
                        }

                        if (editGetData.extremities === "Normal") {
                            $('#normalRadio2').prop('checked', true);
                        } else if (editGetData.extremities === "Edema") {
                            $('#edemaRadio2').prop('checked', true);
                        } else if (editGetData.extremities === "Varicosities") {
                            $('#varicositiesRadio2').prop('checked', true);
                        }

                        if (editGetData.conjunctiva === "Normal") {
                            $('#normalConjunctivaRadio2').prop('checked', true);
                        } else if (editGetData.conjunctiva === "Pale") {
                            $('#paleConjunctivaRadio2').prop('checked', true);
                        } else if (editGetData.conjunctiva === "Yellowish") {
                            $('#yellowishConjunctivaRadio2').prop('checked', true);
                        }

                        if (editGetData.neck === "Normal") {
                            $('#normalNeckRadio2').prop('checked', true);
                        } else if (editGetData.neck === "Enlarge Lymph Nodes") {
                            $('#enlargeLymphNodesRadio2').prop('checked', true);
                        }

                        if (editGetData.severe_headaches === 'Yes') {
                            $('#severe_headaches2').prop('checked', true);
                        } else {
                            $('#severe_headaches2').prop('checked', false);
                        }

                        if (editGetData.history_stroke_heart_attack_hypertension === 'Yes') {
                            $('#history_stroke_heart_attack_hypertension2').prop('checked', true);
                        } else {
                            $('#history_stroke_heart_attack_hypertension2').prop('checked', false);
                        }

                        if (editGetData.hematoma_bruising_gum_bleeding === 'Yes') {
                            $('#hematoma_bruising_gum_bleeding2').prop('checked', true);
                        } else {
                            $('#hematoma_bruising_gum_bleeding2').prop('checked', false);
                        }

                        if (editGetData.breast_cancer_breast_mass === 'Yes') {
                            $('#breast_cancer_breast_mass2').prop('checked', true);
                        } else {
                            $('#breast_cancer_breast_mass2').prop('checked', false);
                        }

                        if (editGetData.severe_chest_pain === 'Yes') {
                            $('#severe_chest_pain2').prop('checked', true);
                        } else {
                            $('#severe_chest_pain2').prop('checked', false);
                        }

                        if (editGetData.cough_more_than_14_days === 'Yes') {
                            $('#cough_more_than_14_days2').prop('checked', true);
                        } else {
                            $('#cough_more_than_14_days2').prop('checked', false);
                        }

                        if (editGetData.jaundice === 'Yes') {
                            $('#jaundice2').prop('checked', true);
                        } else {
                            $('#jaundice2').prop('checked', false);
                        }

                        if (editGetData.vaginal_bleeding === 'Yes') {
                            $('#vaginal_bleeding2').prop('checked', true);
                        } else {
                            $('#vaginal_bleeding2').prop('checked', false);
                        }

                        if (editGetData.vaginal_discharge === 'Yes') {
                            $('#vaginal_discharge2').prop('checked', true);
                        } else {
                            $('#vaginal_discharge2').prop('checked', false);
                        }

                        if (editGetData.phenobarbital_rifampicin === 'Yes') {
                            $('#phenobarbital_rifampicin2').prop('checked', true);
                        } else {
                            $('#phenobarbital_rifampicin2').prop('checked', false);
                        }

                        if (editGetData.smoker === 'Yes') {
                            $('#smoker2').prop('checked', true);
                        } else {
                            $('#smoker2').prop('checked', false);
                        }

                        if (editGetData.with_disability === 'Yes') {
                            $('#with_disability2').prop('checked', true);
                        } else {
                            $('#with_disability2').prop('checked', false);
                        }

                        $('#editModal').modal('show');
                    },
                    error: function (error) {
                        console.error('Error fetching  data: ' + error);
                    },
                });
            });

            $('#updateButton').click(function () {


                var editId = $('#editdataId').val();
                var subjective = $('#subjective2').val();
                var objective = $('#objective2').val();
                var assessment = $('#assessment2').val();
                var plan = $('#plan2').val();
                var doctor_id = $('#doctor_id2').val();
                var checkup_date = $('#checkup_date2').val();

                var extremities = $('input[name="extremities2"]:checked').val()
                var skin = $('input[name="skin2"]:checked').val();
                var conjunctiva = $('input[name="conjunctiva2"]:checked').val();
                var neck = $('input[name="neck2"]:checked').val();
                var breast = $('input[name="breast2"]:checked').val();
                var abdomen = $('input[name="abdomen2"]:checked').val()


                var jaundice = $('#jaundice2').is(':checked') ? 'Yes' : 'No';
                var severe_headaches = $('#severe_headaches2').is(':checked') ? 'Yes' : 'No';
                var history_stroke_heart_attack_hypertension = $('#history_stroke_heart_attack_hypertension2').is(':checked') ? 'Yes' : 'No';
                var hematoma_bruising_gum_bleeding = $('#hematoma_bruising_gum_bleeding2').is(':checked') ? 'Yes' : 'No';
                var breast_cancer_breast_mass = $('#breast_cancer_breast_mass2').is(':checked') ? 'Yes' : 'No';
                var severe_chest_pain = $('#severe_chest_pain2').is(':checked') ? 'Yes' : 'No';
                var cough_more_than_14_days = $('#cough_more_than_14_days2').is(':checked') ? 'Yes' : 'No';
                var vaginal_bleeding = $('#vaginal_bleeding2').is(':checked') ? 'Yes' : 'No';
                var vaginal_discharge = $('#vaginal_discharge2').is(':checked') ? 'Yes' : 'No';
                var phenobarbital_rifampicin = $('#phenobarbital_rifampicin2').is(':checked') ? 'Yes' : 'No';
                var smoker = $('#smoker2').is(':checked') ? 'Yes' : 'No';
                var with_disability = $('#with_disability2').is(':checked') ? 'Yes' : 'No';

                var weight = $('#weight2').val();
                var bp = $('#bp2').val();
                var height = $('#height2').val();
                var pulse = $('#pulse2').val();

                $.ajax({
                    url: 'action/update_consultation.php',
                    method: 'POST',
                    data: {
                        primary_id: editId,
                        subjective: subjective,
                        objective: objective,
                        assessment: assessment,
                        plan: plan,
                        doctor_id: doctor_id,
                        checkup_date: checkup_date,
                        weight: weight,
                        bp: bp,
                        height: height,
                        pulse: pulse,
                        skin: skin,
                        extremities: extremities,
                        conjunctiva: conjunctiva,
                        neck: neck,
                        severe_headaches: severe_headaches,
                        history_stroke_heart_attack_hypertension: history_stroke_heart_attack_hypertension,
                        hematoma_bruising_gum_bleeding: hematoma_bruising_gum_bleeding,
                        breast_cancer_breast_mass: breast_cancer_breast_mass,
                        severe_chest_pain: severe_chest_pain,
                        cough_more_than_14_days: cough_more_than_14_days,
                        vaginal_bleeding: vaginal_bleeding,
                        vaginal_discharge: vaginal_discharge,
                        phenobarbital_rifampicin: phenobarbital_rifampicin,
                        smoker: smoker,
                        jaundice: jaundice,
                        with_disability: with_disability


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