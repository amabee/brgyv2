<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,fp_information.id as id,patients.first_name as first_name,patients.last_name as last_name,nurses.first_name as first_name2,nurses.last_name as last_name2
FROM fp_information
JOIN patients ON fp_information.patient_id = patients.id
JOIN nurses ON fp_information.nurse_id = nurses.id WHERE fp_information.is_deleted = 1";


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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Family Planning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">

                        <h5>I PERSONAL INFORMATION</h5>
                        <hr>

                        <div class="row">
                            <div class="col-4">
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


                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Select Nurse</label>
                                    <select class="form-control" name="nurse_id" id="nurse_id" required>
                                        <option value="" disabled selected hidden>Select A Nurse</option>
                                        <?php

                                        // Query to fetch patients from the database
                                        $sql2 = "SELECT id, first_name, last_name FROM nurses
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


                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">No. of Living Children</label>
                                    <input type="text" class="form-control" id="no_of_children" name="no_of_children"
                                        required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Average Monthly Income</label>
                                    <input type="number" class="form-control" id="income" name="income" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="plan_to_have_more_children">Plan to Have More Children?</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="plan_to_have_more_children"
                                            name="plan_to_have_more_children" value="Yes" class="radio-input" required>
                                        <label for="" class="radio-label" style="margin-left: 5px;">Yes</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="plan_to_have_more_children"
                                            name="plan_to_have_more_children" value="No" class="radio-input" required>
                                        <label for="" class="radio-label">No</label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Type of Client</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="client_type" name="client_type" value="New Acceptor"
                                            class="radio-input" required>
                                        <label for="" class="radio-label" style="margin-left: 5px;">New Acceptor</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type" name="client_type" value="Changing Method"
                                            class="radio-input" required>
                                        <label for="" class="radio-label">Changing Method</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type" name="client_type" value="Changing Clinic"
                                            class="radio-input" required>
                                        <label for="" class="radio-label">Changing Clinic</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type" name="client_type" value="Dropout/Restart"
                                            class="radio-input" required>
                                        <label for="" class="radio-label">Dropout/Restart</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Reason for FP</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="reason_for_fp" name="reason_for_fp" value="spacing"
                                            class="radio-input" required>
                                        <label for="" class="radio-label" style="margin-left: 5px;">New Acceptor</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="reason_for_fp" name="reason_for_fp" value="limiting"
                                            class="radio-input" required>
                                        <label for="" class="radio-label">Changing Method</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <h5>II MEDICAL HISTORY</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <label for="medical_conditions">Does the client have any of the
                                            following?</label>
                                        <br>
                                        <div class="form-group">

                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_headaches" name="severe_headaches"
                                                        value="severe_headaches">
                                                    <label class="checkbox-label">severe headaches/migraine</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="history_stroke_heart_attack_hypertension"
                                                        name="history_stroke_heart_attack_hypertension"
                                                        value="history_stroke_heart_attack_hypertension">
                                                    <label class="checkbox-label">history of stroke / heart attack /
                                                        hypertension</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding"
                                                        name="hematoma_bruising_gum_bleeding"
                                                        value="hematoma_bruising_gum_bleeding">
                                                    <label class="checkbox-label">non-traumatic hematoma / frequent
                                                        bruising or gum bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="breast_cancer_breast_mass"
                                                        name="breast_cancer_breast_mass"
                                                        value="breast_cancer_breast_mass">
                                                    <label class="checkbox-label">current or history of breast
                                                        cancer/breast mass</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_chest_pain"
                                                        name="severe_chest_pain" value="severe_chest_pain">
                                                    <label class="checkbox-label">severe chest pain</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="cough_more_than_14_days"
                                                        name="cough_more_than_14_days" value="cough_more_than_14_days">
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
                                                    <input type="checkbox" id="jaundice" name="jaundice"
                                                        value="jaundice">
                                                    <label class="checkbox-label">jaundice</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_bleeding" name="vaginal_bleeding"
                                                        value="vaginal_bleeding">
                                                    <label class="checkbox-label">unexplained vaginal bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_discharge"
                                                        name="vaginal_discharge" value="vaginal_discharge">
                                                    <label class="checkbox-label">abnormal vaginal discharge</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="phenobarbital_rifampicin"
                                                        name="phenobarbital_rifampicin"
                                                        value="phenobarbital_rifampicin">
                                                    <label class="checkbox-label">intake of phenobarbital (anti-seizure)
                                                        or rifampicin (anti-TB)</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="smoker" name="smoker" value="smoker">
                                                    <label class="checkbox-label">Is the client a SMOKER?</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="with_disability" name="with_disability"
                                                        value="with_disability">
                                                    <label class="checkbox-label">With Disability?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <h5>III OBSTERICAL HISTORY</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">No of Pregnancies</label>
                                            <input type="number" class="form-control" id="no_of_pregnancies"
                                                name="no_of_pregnancies" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Date of Last Delivery</label>
                                            <input type="date" class="form-control" id="date_of_last_delivery"
                                                name="date_of_last_delivery" required>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Last Menstrual Period</label>
                                            <input type="date" class="form-control" id="last_period" name="last_period"
                                                required>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Type of Last Delivery</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="type_of_last_delivery"
                                                    name="type_of_last_delivery" value="Vaginal" class="radio-input"
                                                    required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Vaginal</label>
                                            </div>
                                            <div style="display: inline-block;">
                                                <input type="radio" id="type_of_last_delivery"
                                                    name="type_of_last_delivery" value="Cesarean Section"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label">Cesarean Section</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Menstrual Flow</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="mens_type" name="mens_type" value="Scanty"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Scanty</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="mens_type" name="mens_type" value="Moderate"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Moderate</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="mens_type" name="mens_type" value="Heavy"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Heavy</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <h5>IV RISK FOR SEXUALITY TRANSMITTED INFECTIONS</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="medical_conditions">Does the client have any of the
                                                following?</label>
                                            <br>
                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="abnormal_discharge"
                                                        name="medical_condition" value="abnormal_discharge">
                                                    <label class="checkbox-label">abnormal discharge from the genital
                                                        area</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="genital_sores_ulcers"
                                                        name="medical_condition" value="genital_sores_ulcers">
                                                    <label class="checkbox-label">sores or ulcers in the genital
                                                        area</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="genital_pain_burning_sensation"
                                                        name="medical_condition" value="genital_pain_burning_sensation">
                                                    <label class="checkbox-label">pain or burning sensation in the
                                                        genital area</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">

                                            <br>
                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="treatment_for_sti"
                                                        name="medical_condition" value="treatment_for_sti">
                                                    <label class="checkbox-label">history of treatment for sexually
                                                        transmitted infections</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="hiv_aids_pid" name="medical_condition"
                                                        value="hiv_aids_pid">
                                                    <label class="checkbox-label">HIV/AIDS/Pelvic inflammatory
                                                        disease</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                            <!-- other col -->
                            <div class="col-12">

                                <hr>
                                <h5>V RISK FOR VIOLENCE AGAINST WOMEN</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="relationship_status">Please indicate the following:</label>
                                            <br>
                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="unpleasant_relationship"
                                                        name="relationship_status" value="unpleasant_relationship">
                                                    <label class="checkbox-label">Create an unpleasant relationship with
                                                        partner</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="partner_does_not_approve"
                                                        name="relationship_status" value="partner_does_not_approve">
                                                    <label class="checkbox-label">Partner does not approve of the visit
                                                        to FP clinic</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <br>
                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="domestic_violence"
                                                        name="relationship_status" value="domestic_violence">
                                                    <label class="checkbox-label">History of domestic violence or
                                                        VAW</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <hr>
                                <h5>VI PHYSICAL EXAMINATION</h5>
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
                                                <input type="radio" id="skin" name="skin" value="Normal"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="skin" name="skin" value="Pale"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label" style="margin-left: 5px;">Pale</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="skin" name="skin" value="Yellowish"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="skin" name="skin" value="Hematoma"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Hematoma</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Extremities</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="extremities" name="extremities" value="Normal"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="extremities" name="extremities" value="Edema"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Edema</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="extremities" name="extremities"
                                                    value="Varicosities" class="radio-input" required>
                                                <label for="" class="radio-label"
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
                                                <input type="radio" id="conjunctiva" name="conjunctiva" value="Normal"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="conjunctiva" name="conjunctiva" value="Pale"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label" style="margin-left: 5px;">Pale</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="conjunctiva" name="conjunctiva"
                                                    value="Yellowish" class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Neck</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="neck" name="neck" value="Normal"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="neck" name="neck" value="Enlarge Lymph Nodes"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label" style="margin-left: 5px;">Enlarge
                                                    Lymph Nodes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Breast</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="breast" name="breast" value="Normal"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="breast" name="breast" value="Mass"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label" style="margin-left: 5px;">Mass</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="breast" name="breast" value="Nipple Discharge"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label" style="margin-left: 5px;">Nipple
                                                    Discharge</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Abdomen</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="abdomen" name="abdomen" value="Normal"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="abdomen" name="abdomen" value="Abdominal Mass"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label" style="margin-left: 5px;">Abdominal
                                                    Mass</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="abdomen" name="abdomen" value="Varicosities"
                                                    class="radio-input" required>
                                                <label for="" class="radio-label"
                                                    style="margin-left: 5px;">Varicosities</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
















                        <!-- <div class="form-group">
                        <label for="">Select Nurse</label>
                        <select class="form-control" name="nurse_id" id="nurse_id" required>
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
                        <select class="form-control" name="method" id="method" required>
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
                        <input type="text" class="form-control" id="serial" name="serial" required>
                    </div> -->

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
                            <th>Checkup Date</th>
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
                                        <?php echo $row['checkup_date']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i
                                                class="fas fa-check"></i> Set as Active</button>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle"></td>
                                <td class="align-middle">No Family Planning Found</td>
                                <td class="align-middle">
                                <td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Family Planning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editdataId" name="primary_id">

                        <h5>I PERSONAL INFORMATION</h5>
                        <hr>




                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Select Nurse</label>
                                    <select class="form-control" name="nurse_id2" id="nurse_id2" required>
                                        <option value="" disabled selected hidden>Select A Nurse</option>
                                        <?php

                                        // Query to fetch patients from the database
                                        $sql2 = "SELECT id, first_name, last_name FROM nurses
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

                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">No. of Living Children</label>
                                    <input type="text" class="form-control" id="no_of_children2" name="no_of_children"
                                        required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Average Monthly Income</label>
                                    <input type="number" class="form-control" id="income2" name="income" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="plan_to_have_more_children">Plan to Have More Children?</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="plan_to_have_more_children_yes"
                                            name="plan_to_have_more_children2" value="Yes" class="radio-input" required>
                                        <label for="plan_to_have_more_children_yes" class="radio-label"
                                            style="margin-left: 5px;">Yes</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="plan_to_have_more_children_no"
                                            name="plan_to_have_more_children2" value="No" class="radio-input" required>
                                        <label for="plan_to_have_more_children_no" class="radio-label">No</label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Type of Client</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="client_type_new" name="client_type2"
                                            value="New Acceptor" class="radio-input" required>
                                        <label for="client_type_new" class="radio-label" style="margin-left: 5px;">New
                                            Acceptor</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_change" name="client_type2"
                                            value="Changing Method" class="radio-input" required>
                                        <label for="client_type_change" class="radio-label">Changing Method</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_change_clinic" name="client_type2"
                                            value="Changing Clinic" class="radio-input" required>
                                        <label for="client_type_change_clinic" class="radio-label">Changing
                                            Clinic</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_dropout_restart" name="client_type2"
                                            value="Dropout/Restart" class="radio-input" required>
                                        <label for="client_type_dropout_restart"
                                            class="radio-label">Dropout/Restart</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Reason for FP</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="reason_for_fp_spacing" name="reason_for_fp2"
                                            value="spacing" class="radio-input" required>
                                        <label for="reason_for_fp_spacing" class="radio-label"
                                            style="margin-left: 5px;">Spacing</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="reason_for_fp_limiting" name="reason_for_fp2"
                                            value="limiting" class="radio-input" required>
                                        <label for="reason_for_fp_limiting" class="radio-label">Limiting</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <h5>II MEDICAL HISTORY</h5>
                                <hr>
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

                                <hr>
                                <h5>III OBSTERICAL HISTORY</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">No of Pregnancies</label>
                                            <input type="number" class="form-control" id="no_of_pregnancies2"
                                                name="no_of_pregnancies" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Date of Last Delivery</label>
                                            <input type="date" class="form-control" id="date_of_last_delivery2"
                                                name="date_of_last_delivery" required>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Last Menstrual Period</label>
                                            <input type="date" class="form-control" id="last_period2" name="last_period"
                                                required>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Type of Last Delivery</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="vaginalRadio" name="type_of_last_delivery2"
                                                    value="Vaginal" class="radio-input" required>
                                                <label for="vaginalRadio" class="radio-label"
                                                    style="margin-left: 5px;">Vaginal</label>
                                            </div>
                                            <div style="display: inline-block;">
                                                <input type="radio" id="cesareanRadio" name="type_of_last_delivery2"
                                                    value="Cesarean Section" class="radio-input" required>
                                                <label for="cesareanRadio" class="radio-label">Cesarean Section</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-4">
                                        <label for="">Menstrual Flow</label>
                                        <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="scantyRadio" name="mens_type2" value="Scanty"
                                                class="radio-input" required>
                                            <label for="scantyRadio" class="radio-label"
                                                style="margin-left: 5px;">Scanty</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="moderateRadio" name="mens_type2" value="Moderate"
                                                class="radio-input" required>
                                            <label for="moderateRadio" class="radio-label"
                                                style="margin-left: 5px;">Moderate</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="heavyRadio" name="mens_type2" value="Heavy"
                                                class="radio-input" required>
                                            <label for="heavyRadio" class="radio-label"
                                                style="margin-left: 5px;">Heavy</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <h5>IV RISK FOR SEXUALITY TRANSMITTED INFECTIONS</h5>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="medical_conditions">Does the client have any of the
                                            following?</label>
                                        <br>
                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="abnormal_discharge2"
                                                    name="abnormal_discharge" value="abnormal_discharge">
                                                <label class="checkbox-label">abnormal discharge from the genital
                                                    area</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="genital_sores_ulcers2"
                                                    name="genital_sores_ulcers" value="genital_sores_ulcers">
                                                <label class="checkbox-label">sores or ulcers in the genital
                                                    area</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="genital_pain_burning_sensation2"
                                                    name="genital_pain_burning_sensation"
                                                    value="genital_pain_burning_sensation">
                                                <label class="checkbox-label">pain or burning sensation in the genital
                                                    area</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">

                                        <br>
                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="treatment_for_sti2" name="treatment_for_sti"
                                                    value="treatment_for_sti">
                                                <label class="checkbox-label">history of treatment for sexually
                                                    transmitted infections</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="hiv_aids_pid2" name="hiv_aids_pid"
                                                    value="hiv_aids_pid">
                                                <label class="checkbox-label">HIV/AIDS/Pelvic inflammatory
                                                    disease</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <!-- other col -->
                        <div class="col-12">

                            <hr>
                            <h5>V RISK FOR VIOLENCE AGAINST WOMEN</h5>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="relationship_status">Please indicate the following:</label>
                                        <br>

                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="unpleasant_relationship2"
                                                    name="unpleasant_relationship" value="unpleasant_relationship">
                                                <label class="checkbox-label">Create an unpleasant relationship with
                                                    partner</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="partner_does_not_approve2"
                                                    name="partner_does_not_approve" value="partner_does_not_approve">
                                                <label class="checkbox-label">Partner does not approve of the visit to
                                                    FP clinic</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <br>
                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="domestic_violence2" name="domestic_violence"
                                                    value="domestic_violence">
                                                <label class="checkbox-label">History of domestic violence or
                                                    VAW</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <hr>
                            <h5>VI PHYSICAL EXAMINATION</h5>
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
                                        <input type="text" class="form-control" id="height2" name="height2" required>
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
                                            <input type="radio" id="normalSkinRadio" name="skin2" value="Normal"
                                                class="radio-input" required>
                                            <label for="normalSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="paleSkinRadio" name="skin2" value="Pale"
                                                class="radio-input" required>
                                            <label for="paleSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Pale</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="yellowishSkinRadio" name="skin2" value="Yellowish"
                                                class="radio-input" required>
                                            <label for="yellowishSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Yellowish</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="hematomaSkinRadio" name="skin2" value="Hematoma"
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
                                            <input type="radio" id="normalRadio" name="extremities2" value="Normal"
                                                class="radio-input" required>
                                            <label for="normalRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="edemaRadio" name="extremities2" value="Edema"
                                                class="radio-input" required>
                                            <label for="edemaRadio" class="radio-label"
                                                style="margin-left: 5px;">Edema</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="varicositiesRadio" name="extremities2"
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
                                            <input type="radio" id="normalConjunctivaRadio" name="conjunctiva2"
                                                value="Normal" class="radio-input" required>
                                            <label for="normalConjunctivaRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="paleConjunctivaRadio" name="conjunctiva2"
                                                value="Pale" class="radio-input" required>
                                            <label for="paleConjunctivaRadio" class="radio-label"
                                                style="margin-left: 5px;">Pale</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="yellowishConjunctivaRadio" name="conjunctiva2"
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
                                            <input type="radio" id="normalNeckRadio" name="neck2" value="Normal"
                                                class="radio-input" required>
                                            <label for="normalNeckRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="enlargeLymphNodesRadio" name="neck2"
                                                value="Enlarge Lymph Nodes" class="radio-input" required>
                                            <label for="enlargeLymphNodesRadio" class="radio-label"
                                                style="margin-left: 5px;">Enlarge Lymph Nodes</label>
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Breast</label>
                                        <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="normalBreastRadio" name="breast2" value="Normal"
                                                class="radio-input" required>
                                            <label for="normalBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="massBreastRadio" name="breast2" value="Mass"
                                                class="radio-input" required>
                                            <label for="massBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Mass</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="nippleDischargeBreastRadio" name="breast2"
                                                value="Nipple Discharge" class="radio-input" required>
                                            <label for="nippleDischargeBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Nipple Discharge</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Abdomen</label>
                                        <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="normalAbdomenRadio" name="abdomen2" value="Normal"
                                                class="radio-input" required>
                                            <label for="normalAbdomenRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdominalMassRadio" name="abdomen2"
                                                value="Abdominal Mass" class="radio-input" required>
                                            <label for="abdominalMassRadio" class="radio-label"
                                                style="margin-left: 5px;">Abdominal Mass</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="varicositiesAbdomenRadio" name="abdomen2"
                                                value="Varicosities" class="radio-input" required>
                                            <label for="varicositiesAbdomenRadio" class="radio-label"
                                                style="margin-left: 5px;">Varicosities</label>
                                        </div>
                                    </div>
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



        <?php if ($result->num_rows > 0): ?>
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'serial_no' },
                    { targets: 2, data: 'last_name' },
                    { targets: 3, data: 'checkup_date' },
                    {
                        targets: 4,
                        searchable: false,
                        data: null,
                        render: function (data, type, row) {
                            var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                            var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                            return deleteButton;
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
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'serial_no' },
                    { targets: 2, data: 'last_name' },
                    { targets: 3, data: 'checkup_date' },
                    {
                        targets: 4,
                        searchable: false,
                        data: null,
                        render: function (data, type, row) {
                            var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                            var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                            return deleteButton;
                        }
                    } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });


            // Get data from the form

            // Capture the values of the additional fields and checkboxes
            var patient_id = $('#serial_no2').val();
            var nurse_id = $('#nurse_id').val();
            var serial = $('#serial').val();
            var method = $('#method').val();
            var no_of_children = $('#no_of_children').val();
            var income = $('#income').val();
            var plan_to_have_more_children = $('#plan_to_have_more_children').val();
            var client_type = $('#client_type').val();
            var reason_for_fp = $('#reason_for_fp').val();
            var severe_headaches = $('#severe_headaches').is(':checked') ? 'Yes' : 'No';
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

            // Include the fields for fp_obstetrical_history
            var no_of_pregnancies = $('#no_of_pregnancies').val();
            var date_of_last_delivery = $('#date_of_last_delivery').val();
            var last_period = $('#last_period').val();
            var type_of_last_delivery = $('#type_of_last_delivery').val();
            var mens_type = $('#mens_type').val();

            // Include the fields for fp_physical_examination
            var weight = $('#weight').val();
            var bp = $('#bp').val();
            var height = $('#height').val();
            var pulse = $('#pulse').val();
            var skin = $('#skin').val();
            var extremities = $('#extremities').val();
            var conjunctiva = $('#conjunctiva').val();
            var neck = $('#neck').val();
            var breast = $('#breast').val();
            var abdomen = $('#abdomen').val();
            console.log(patient_id);
            // AJAX request to send data to the server
            $.ajax({
                url: 'action/add_family.php',
                method: 'POST',
                data: {
                    patient_id: patient_id,
                    nurse_id: nurse_id,
                    serial: serial,
                    method: method,
                    no_of_children: no_of_children,
                    income: income,
                    plan_to_have_more_children: plan_to_have_more_children,
                    client_type: client_type,
                    reason_for_fp: reason_for_fp,
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
                    with_disability: with_disability,
                    no_of_pregnancies: no_of_pregnancies,
                    date_of_last_delivery: date_of_last_delivery,
                    last_period: last_period,
                    type_of_last_delivery: type_of_last_delivery,
                    mens_type: mens_type,
                    weight: weight,
                    bp: bp,
                    height: height,
                    pulse: pulse,
                    skin: skin,
                    extremities: extremities,
                    conjunctiva: conjunctiva,
                    neck: neck,
                    breast: breast,
                    abdomen: abdomen
                },
                success: function (response) {
                    if (response.trim() === 'Success') {
                        // Clear the form fields
                        $('#patient_id').val('');
                        $('#nurse_id').val('');
                        $('#serial').val('');
                        $('#method').val('');
                        $('#no_of_children').val('');
                        $('#income').val('');
                        $('#plan_to_have_more_children').val('');
                        $('#client_type').val('');
                        $('#reason_for_fp').val('');

                        // Clear the checkboxes
                        $('.checkbox-list input[type="checkbox"]').prop('checked', false);

                        // Clear the additional input fields
                        $('#weight').val('');
                        $('#bp').val('');
                        $('#height').val('');
                        $('#pulse').val('');
                        $('#skin').val('');
                        $('#extremities').val('');
                        $('#conjunctiva').val('');
                        $('#neck').val('');
                        $('#breast').val('');
                        $('#abdomen').val('');



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
                text: 'Are you sure you want to activate this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, activate it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'action/active.php',
                        method: 'POST',
                        data: { primary_id: deletedataId },
                        success: function (response) {
                            if (response === 'Success') {

                                updateData();
                                Swal.fire('Activated', 'The Family Planning has been activated.', 'success');
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
                    $('#editModal #no_of_children2').val(editGetData.no_of_children);
                    $('#editModal #income2').val(editGetData.income);
                    $('#editModal #nurse_id2').val(editGetData.nurse_id);
                    $('#editModal #no_of_pregnancies2').val(editGetData.no_of_pregnancies);
                    $('#editModal #date_of_last_delivery2').val(editGetData.date_of_last_delivery);
                    $('#editModal #last_period2').val(editGetData.last_period);


                    // Assuming editGetData.plan_to_have_more_children contains the value "Yes" or "No"
                    if (editGetData.plan_to_have_more_children === "Yes") {
                        $('#plan_to_have_more_children_yes').prop('checked', true);
                    } else if (editGetData.plan_to_have_more_children === "No") {
                        $('#plan_to_have_more_children_no').prop('checked', true);
                    }

                    // Assuming editGetData.client_type contains the value like "New Acceptor", "Changing Method", etc.
                    if (editGetData.client_type === "New Acceptor") {
                        $('#client_type_new').prop('checked', true);
                    } else if (editGetData.client_type === "Changing Method") {
                        $('#client_type_change').prop('checked', true);
                    } else if (editGetData.client_type === "Changing Clinic") {
                        $('#client_type_change_clinic').prop('checked', true);
                    } else if (editGetData.client_type === "Dropout/Restart") {
                        $('#client_type_dropout_restart').prop('checked', true);
                    }

                    // Assuming editGetData.reason_for_fp contains the value like "spacing" or "limiting"
                    if (editGetData.reason_for_fp === "spacing") {
                        $('#reason_for_fp_spacing').prop('checked', true);
                    } else if (editGetData.reason_for_fp === "limiting") {
                        $('#reason_for_fp_limiting').prop('checked', true);
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

                    // Check the appropriate radio button based on the value
                    if (editGetData.type_of_last_delivery === "Vaginal") {
                        $('#vaginalRadio').prop('checked', true);
                    } else if (editGetData.type_of_last_delivery === "Cesarean Section") {
                        $('#cesareanRadio').prop('checked', true);
                    }


                    if (editGetData.mens_type === "Scanty") {
                        $('#scantyRadio').prop('checked', true);
                    } else if (editGetData.mens_type === "Moderate") {
                        $('#moderateRadio').prop('checked', true);
                    } else if (editGetData.mens_type === "Heavy") {
                        $('#heavyRadio').prop('checked', true);
                    }

                    if (editGetData.abnormal_discharge === 'Yes') {
                        $('#abnormal_discharge2').prop('checked', true);
                    } else {
                        $('#abnormal_discharge2').prop('checked', false);
                    }

                    if (editGetData.genital_sores_ulcers === 'Yes') {
                        $('#genital_sores_ulcers2').prop('checked', true);
                    } else {
                        $('#genital_sores_ulcers2').prop('checked', false);
                    }

                    if (editGetData.genital_pain_burning_sensation === 'Yes') {
                        $('#genital_pain_burning_sensation2').prop('checked', true);
                    } else {
                        $('#genital_pain_burning_sensation2').prop('checked', false);
                    }


                    if (editGetData.treatment_for_sti === 'Yes') {
                        $('#treatment_for_sti2').prop('checked', true);
                    } else {
                        $('#treatment_for_sti2').prop('checked', false);
                    }

                    if (editGetData.hiv_aids_pid === 'Yes') {
                        $('#hiv_aids_pid2').prop('checked', true);
                    } else {
                        $('#hiv_aids_pid2').prop('checked', false);
                    }

                    if (editGetData.treatment_for_sti === 'Yes') {
                        $('#treatment_for_sti2').prop('checked', true);
                    } else {
                        $('#treatment_for_sti2').prop('checked', false);
                    }

                    if (editGetData.hiv_aids_pid === 'Yes') {
                        $('#hiv_aids_pid2').prop('checked', true);
                    } else {
                        $('#hiv_aids_pid2').prop('checked', false);
                    }


                    if (editGetData.unpleasant_relationship === 'Yes') {
                        $('#unpleasant_relationship2').prop('checked', true);
                    } else {
                        $('#unpleasant_relationship2').prop('checked', false);
                    }

                    if (editGetData.partner_does_not_approve === 'Yes') {
                        $('#partner_does_not_approve2').prop('checked', true);
                    } else {
                        $('#partner_does_not_approve2').prop('checked', false);
                    }

                    if (editGetData.domestic_violence === 'Yes') {
                        $('#domestic_violence2').prop('checked', true);
                    } else {
                        $('#domestic_violence2').prop('checked', false);
                    }


                    $('#editModal #weight2').val(editGetData.weight);
                    $('#editModal #bp2').val(editGetData.bp);
                    $('#editModal #height2').val(editGetData.height);
                    $('#editModal #pulse2').val(editGetData.pulse);

                    // Check the appropriate radio button based on the value
                    if (editGetData.extremities === "Normal") {
                        $('#normalRadio').prop('checked', true);
                    } else if (editGetData.extremities === "Edema") {
                        $('#edemaRadio').prop('checked', true);
                    } else if (editGetData.extremities === "Varicosities") {
                        $('#varicositiesRadio').prop('checked', true);
                    }



                    // Check the appropriate radio button based on the value
                    if (editGetData.skin === "Normal") {
                        $('#normalSkinRadio').prop('checked', true);
                    } else if (editGetData.skin === "Pale") {
                        $('#paleSkinRadio').prop('checked', true);
                    } else if (editGetData.skin === "Yellowish") {
                        $('#yellowishSkinRadio').prop('checked', true);
                    } else if (editGetData.skin === "Hematoma") {
                        $('#hematomaSkinRadio').prop('checked', true);
                    }




                    // Check the appropriate radio button based on the value
                    if (editGetData.conjunctiva === "Normal") {
                        $('#normalConjunctivaRadio').prop('checked', true);
                    } else if (editGetData.conjunctiva === "Pale") {
                        $('#paleConjunctivaRadio').prop('checked', true);
                    } else if (editGetData.conjunctiva === "Yellowish") {
                        $('#yellowishConjunctivaRadio').prop('checked', true);
                    }




                    // Check the appropriate radio button based on the value
                    if (editGetData.neck === "Normal") {
                        $('#normalNeckRadio').prop('checked', true);
                    } else if (editGetData.neck === "Enlarge Lymph Nodes") {
                        $('#enlargeLymphNodesRadio').prop('checked', true);
                    }



                    // Check the appropriate radio button based on the value
                    if (editGetData.breast === "Normal") {
                        $('#normalBreastRadio').prop('checked', true);
                    } else if (editGetData.breast === "Mass") {
                        $('#massBreastRadio').prop('checked', true);
                    } else if (editGetData.breast === "Nipple Discharge") {
                        $('#nippleDischargeBreastRadio').prop('checked', true);
                    }



                    // Check the appropriate radio button based on the value
                    if (editGetData.abdomen === "Normal") {
                        $('#normalAbdomenRadio').prop('checked', true);
                    } else if (editGetData.abdomen === "Abdominal Mass") {
                        $('#abdominalMassRadio').prop('checked', true);
                    } else if (editGetData.abdomen === "Varicosities") {
                        $('#varicositiesAbdomenRadio').prop('checked', true);
                    }
                    $('#editModal').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });

        $('#updateButton').click(function () {
            //jaba

            var editId = $('#editdataId').val();


            var abnormal_discharge = $('#abnormal_discharge2').val();
            var nurse_id = $('#nurse_id2').val();
            var serial = $('#serial2').val();
            var method = $('#method2').val();
            var no_of_children = $('#no_of_children2').val();
            var income = $('#income2').val();


            var plan_to_have_more_children = $("input[name='plan_to_have_more_children2']:checked").val();
            var client_type = $("input[name='client_type2']:checked").val();
            var reason_for_fp = $("input[name='reason_for_fp2']:checked").val();
            var type_of_last_delivery = $("input[name='type_of_last_delivery2']:checked").val();
            var mens_type = $("input[name='mens_type2']:checked").val();
            var skin = $("input[name='skin2']:checked").val();
            var extremities = $("input[name='extremities2']:checked").val();
            var conjunctiva = $("input[name='conjunctiva2']:checked").val();
            var neck = $("input[name='neck2']:checked").val();
            var breast = $("input[name='breast2']:checked").val();
            var abdomen = $("input[name='abdomen2']:checked").val();

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

            // Include the fields for fp_obstetrical_history
            var no_of_pregnancies = $('#no_of_pregnancies2').val();
            var date_of_last_delivery = $('#date_of_last_delivery2').val();
            var last_period = $('#last_period2').val();



            // Include the fields for fp_physical_examination
            var weight = $('#weight2').val();
            var bp = $('#bp2').val();
            var height = $('#height2').val();
            var pulse = $('#pulse2').val();

            // AJAX request to send data to the server
            $.ajax({
                url: 'action/update_family.php',
                method: 'POST',
                data: {
                    abnormal_discharge: abnormal_discharge,
                    primary_id: editId,
                    nurse_id: nurse_id,
                    serial: serial,
                    method: method,
                    no_of_children: no_of_children,
                    income: income,
                    plan_to_have_more_children: plan_to_have_more_children,
                    client_type: client_type,
                    reason_for_fp: reason_for_fp,
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
                    with_disability: with_disability,
                    no_of_pregnancies: no_of_pregnancies,
                    date_of_last_delivery: date_of_last_delivery,
                    last_period: last_period,
                    type_of_last_delivery: type_of_last_delivery,
                    mens_type: mens_type,
                    weight: weight,
                    bp: bp,
                    height: height,
                    pulse: pulse,
                    skin: skin,
                    extremities: extremities,
                    conjunctiva: conjunctiva,
                    neck: neck,
                    breast: breast,
                    abdomen: abdomen
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