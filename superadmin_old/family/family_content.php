<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,fp_information.id as id,patients.first_name as first_name,patients.last_name as last_name,nurses.first_name as first_name2,nurses.last_name as last_name2
FROM fp_information
JOIN patients ON fp_information.patient_id = patients.id
JOIN nurses ON fp_information.nurse_id = nurses.id";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
<button type="button" id="openModalButton" class="btn btn-primary" style="display:none">
  Add Family Planning
</button>


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="col-6">
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
        

            <div class="row">
            
            <div class="col-4">
               <div class="form-group">
                       <label for="">No. of Living Children</label>
                       <input type="text" class="form-control" id="no_of_children" name="no_of_children" required>
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
                        <input type="radio" id="plan_to_have_more_children" name="plan_to_have_more_children" value="Yes" class="radio-input" required>
                        <label for="" class="radio-label" style="margin-left: 5px;">Yes</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="plan_to_have_more_children" name="plan_to_have_more_children" value="No" class="radio-input" required>
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
                        <input type="radio" id="client_type" name="client_type" value="New Acceptor" class="radio-input" required>
                        <label for="" class="radio-label" style="margin-left: 5px;">New Acceptor</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="client_type" name="client_type" value="Changing Method" class="radio-input" required>
                        <label for="" class="radio-label">Changing Method</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="client_type" name="client_type" value="Changing Clinic" class="radio-input" required>
                        <label for="" class="radio-label">Changing Clinic</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="client_type" name="client_type" value="Dropout/Restart" class="radio-input" required>
                        <label for="" class="radio-label">Dropout/Restart</label>
                    </div>
                </div>
           </div>

           <div class="col">
                <div class="form-group">
                    <label for="">Reason for FP</label>
                    <br>
                    <div style="display: inline-block;" class="mt-1">
                        <input type="radio" id="reason_for_fp" name="reason_for_fp" value="spacing" class="radio-input" required>
                        <label for="" class="radio-label" style="margin-left: 5px;">New Acceptor</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="reason_for_fp" name="reason_for_fp" value="limiting" class="radio-input" required>
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
                    <label for="medical_conditions">Does the client have any of the following?</label>
                            <br>
                        <div class="form-group">
                         
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="severe_headaches" name="severe_headaches" value="severe_headaches">
                                    <label class="checkbox-label">severe headaches/migraine</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="history_stroke_heart_attack_hypertension" name="history_stroke_heart_attack_hypertension" value="history_stroke_heart_attack_hypertension">
                                    <label class="checkbox-label">history of stroke / heart attack / hypertension</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding" name="hematoma_bruising_gum_bleeding" value="hematoma_bruising_gum_bleeding">
                                    <label class="checkbox-label">non-traumatic hematoma / frequent bruising or gum bleeding</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="breast_cancer_breast_mass" name="breast_cancer_breast_mass" value="breast_cancer_breast_mass">
                                    <label class="checkbox-label">current or history of breast cancer/breast mass</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="severe_chest_pain" name="severe_chest_pain" value="severe_chest_pain">
                                    <label class="checkbox-label">severe chest pain</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="cough_more_than_14_days" name="cough_more_than_14_days" value="cough_more_than_14_days">
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
                                    <input type="checkbox" id="jaundice" name="jaundice" value="jaundice">
                                    <label class="checkbox-label">jaundice</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="vaginal_bleeding" name="vaginal_bleeding" value="vaginal_bleeding">
                                    <label class="checkbox-label">unexplained vaginal bleeding</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="vaginal_discharge" name="vaginal_discharge" value="vaginal_discharge">
                                    <label class="checkbox-label">abnormal vaginal discharge</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="phenobarbital_rifampicin" name="phenobarbital_rifampicin" value="phenobarbital_rifampicin">
                                    <label class="checkbox-label">intake of phenobarbital (anti-seizure) or rifampicin (anti-TB)</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="smoker" name="smoker" value="smoker">
                                    <label class="checkbox-label">Is the client a SMOKER?</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="with_disability" name="with_disability" value="with_disability">
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
                            <input type="number" class="form-control" id="no_of_pregnancies" name="no_of_pregnancies" required>
                        </div>
                        </div>
                        <div class="col">
                        <div class="form-group">
                            <label for="">Date of Last Delivery</label>
                            <input type="date" class="form-control" id="date_of_last_delivery" name="date_of_last_delivery" required>
                        </div>
                        </div>
                        
                    
                    <div class="col">
                                <div class="form-group">
                                    <label for="">Last Menstrual Period</label>
                                    <input type="date" class="form-control" id="last_period" name="last_period" required>
                                </div>
                    </div>
                        
                </div>

                
                <div class="row">
                    <div class="col-4">
                            <div class="form-group">
                            <label for="">Type of Last Delivery</label>
                            <br>
                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="type_of_last_delivery" name="type_of_last_delivery" value="Vaginal" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Vaginal</label>
                                </div>
                                <div style="display: inline-block;">
                                    <input type="radio" id="type_of_last_delivery" name="type_of_last_delivery" value="Cesarean Section" class="radio-input" required>
                                    <label for="" class="radio-label">Cesarean Section</label>
                                </div>
                          </div>
                    </div>

                    
                    <div class="col-4">
                            <div class="form-group">
                            <label for="">Menstrual Flow</label>
                            <br>
                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="mens_type" name="mens_type" value="Scanty" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Scanty</label>
                                </div>
                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="mens_type" name="mens_type" value="Moderate" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Moderate</label>
                                </div>

                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="mens_type" name="mens_type" value="Heavy" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Heavy</label>
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
                            <label for="medical_conditions">Does the client have any of the following?</label>
                            <br>
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="abnormal_discharge" name="medical_condition" value="abnormal_discharge">
                                    <label class="checkbox-label">abnormal discharge from the genital area</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="genital_sores_ulcers" name="medical_condition" value="genital_sores_ulcers">
                                    <label class="checkbox-label">sores or ulcers in the genital area</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="genital_pain_burning_sensation" name="medical_condition" value="genital_pain_burning_sensation">
                                    <label class="checkbox-label">pain or burning sensation in the genital area</label>
                                </div>
                            </div>
                        </div>
                            </div>
                            <div class="col">
                            <div class="form-group">
                          
                            <br>
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="treatment_for_sti" name="medical_condition" value="treatment_for_sti">
                                    <label class="checkbox-label">history of treatment for sexually transmitted infections</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="hiv_aids_pid" name="medical_condition" value="hiv_aids_pid">
                                    <label class="checkbox-label">HIV/AIDS/Pelvic inflammatory disease</label>
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
                                    <input type="checkbox" id="unpleasant_relationship" name="relationship_status" value="unpleasant_relationship">
                                    <label class="checkbox-label">Create an unpleasant relationship with partner</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="partner_does_not_approve" name="relationship_status" value="partner_does_not_approve">
                                    <label class="checkbox-label">Partner does not approve of the visit to FP clinic</label>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <br>
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="domestic_violence" name="relationship_status" value="domestic_violence">
                                    <label class="checkbox-label">History of domestic violence or VAW</label>
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
                            <input type="nutextmber" class="form-control" id="weight" name="weight" required>
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
                                            <input type="radio" id="skin" name="skin" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="skin" name="skin" value="Pale" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Pale</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="skin" name="skin" value="Yellowish" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Yellowish</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="skin" name="skin" value="Hematoma" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Hematoma</label>
                                        </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                    <label for="">Extremities</label>
                                    <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="extremities" name="extremities" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="extremities" name="extremities" value="Edema" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Edema</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="extremities" name="extremities" value="Varicosities" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Varicosities</label>
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
                                            <input type="radio" id="conjunctiva" name="conjunctiva" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="conjunctiva" name="conjunctiva" value="Pale" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Pale</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="conjunctiva" name="conjunctiva" value="Yellowish" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Yellowish</label>
                                        </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                    <label for="">Neck</label>
                                    <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="neck" name="neck" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="neck" name="neck" value="Enlarge Lymph Nodes" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Enlarge Lymph Nodes</label>
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
                                            <input type="radio" id="breast" name="breast" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="breast" name="breast" value="Mass" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Mass</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="breast" name="breast" value="Nipple Discharge" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Nipple Discharge</label>
                                        </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                    <label for="">Abdomen</label>
                                    <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdomen" name="abdomen" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdomen" name="abdomen" value="Abdominal Mass" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Abdominal Mass</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdomen" name="abdomen" value="Varicosities" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Varicosities</label>
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
                                <td class="align-middle">
                                <button type="button" class="btn btn-info editbtn" data-row-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Family Planning Found</td>
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
                       <label for="">No. of Living Children</label>
                       <input type="text" class="form-control" id="no_of_children2" name="no_of_children" required>
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
                        <input type="radio" id="plan_to_have_more_children2" name="plan_to_have_more_children" value="Yes" class="radio-input" required>
                        <label for="" class="radio-label" style="margin-left: 5px;">Yes</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="plan_to_have_more_children2" name="plan_to_have_more_children" value="No" class="radio-input" required>
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
                        <input type="radio" id="client_type2" name="client_type" value="New Acceptor" class="radio-input" required>
                        <label for="" class="radio-label" style="margin-left: 5px;">New Acceptor</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="client_type2" name="client_type" value="Changing Method" class="radio-input" required>
                        <label for="" class="radio-label">Changing Method</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="client_type2" name="client_type" value="Changing Clinic" class="radio-input" required>
                        <label for="" class="radio-label">Changing Clinic</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="client_type2" name="client_type" value="Dropout/Restart" class="radio-input" required>
                        <label for="" class="radio-label">Dropout/Restart</label>
                    </div>
                </div>
           </div>

           <div class="col">
                <div class="form-group">
                    <label for="">Reason for FP</label>
                    <br>
                    <div style="display: inline-block;" class="mt-1">
                        <input type="radio" id="reason_for_fp2" name="reason_for_fp" value="spacing" class="radio-input" required>
                        <label for="" class="radio-label" style="margin-left: 5px;">New Acceptor</label>
                    </div>
                    <div style="display: inline-block;">
                        <input type="radio" id="reason_for_fp2" name="reason_for_fp" value="limiting" class="radio-input" required>
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
                    <label for="medical_conditions">Does the client have any of the following?</label>
                            <br>
                        <div class="form-group">
                         
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="severe_headaches2" name="medical_condition" value="severe_headaches">
                                    <label class="checkbox-label">severe headaches/migraine</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="history_stroke_heart_attack_hypertension2" name="medical_condition" value="history_stroke_heart_attack_hypertension">
                                    <label class="checkbox-label">history of stroke / heart attack / hypertension</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding2" name="medical_condition" value="hematoma_bruising_gum_bleeding">
                                    <label class="checkbox-label">non-traumatic hematoma / frequent bruising or gum bleeding</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="breast_cancer_breast_mass2" name="medical_condition" value="breast_cancer_breast_mass">
                                    <label class="checkbox-label">current or history of breast cancer/breast mass</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="severe_chest_pain2" name="medical_condition" value="severe_chest_pain">
                                    <label class="checkbox-label">severe chest pain</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="cough_more_than_14_days2" name="medical_condition" value="cough_more_than_14_days">
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
                                    <input type="checkbox" id="jaundice2" name="medical_condition" value="jaundice">
                                    <label class="checkbox-label">jaundice</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="vaginal_bleeding2" name="medical_condition" value="vaginal_bleeding">
                                    <label class="checkbox-label">unexplained vaginal bleeding</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="vaginal_discharge2" name="medical_condition" value="vaginal_discharge">
                                    <label class="checkbox-label">abnormal vaginal discharge</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="phenobarbital_rifampicin2" name="medical_condition" value="phenobarbital_rifampicin">
                                    <label class="checkbox-label">intake of phenobarbital (anti-seizure) or rifampicin (anti-TB)</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="smoker2" name="medical_condition" value="smoker">
                                    <label class="checkbox-label">Is the client a SMOKER?</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="with_disability2" name="medical_condition" value="with_disability">
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
                            <input type="number" class="form-control" id="no_of_pregnancies2" name="no_of_pregnancies" required>
                        </div>
                        </div>
                        <div class="col">
                        <div class="form-group">
                            <label for="">Date of Last Delivery</label>
                            <input type="date" class="form-control" id="date_of_last_delivery2" name="date_of_last_delivery" required>
                        </div>
                        </div>
                        
                    
                    <div class="col">
                                <div class="form-group">
                                    <label for="">Last Menstrual Period</label>
                                    <input type="date" class="form-control" id="last_period2" name="last_period" required>
                                </div>
                    </div>
                        
                </div>

                
                <div class="row">
                    <div class="col-4">
                            <div class="form-group">
                            <label for="">Type of Last Delivery</label>
                            <br>
                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="type_of_last_delivery2" name="type_of_last_delivery" value="Vaginal" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Vaginal</label>
                                </div>
                                <div style="display: inline-block;">
                                    <input type="radio" id="type_of_last_delivery2" name="type_of_last_delivery" value="Cesarean Section" class="radio-input" required>
                                    <label for="" class="radio-label">Cesarean Section</label>
                                </div>
                          </div>
                    </div>

                    
                    <div class="col-4">
                            <div class="form-group">
                            <label for="">Menstrual Flow</label>
                            <br>
                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="mens_type2" name="mens_type" value="Scanty" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Scanty</label>
                                </div>
                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="mens_type2" name="mens_type" value="Moderate" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Moderate</label>
                                </div>

                                <div style="display: inline-block;" class="mt-1">
                                    <input type="radio" id="mens_type2" name="mens_type" value="Heavy" class="radio-input" required>
                                    <label for="" class="radio-label" style="margin-left: 5px;">Heavy</label>
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
                            <label for="medical_conditions">Does the client have any of the following?</label>
                            <br>
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="abnormal_discharge2" name="abnormal_discharge" value="abnormal_discharge">
                                    <label class="checkbox-label">abnormal discharge from the genital area</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="genital_sores_ulcers2" name="genital_sores_ulcers" value="genital_sores_ulcers">
                                    <label class="checkbox-label">sores or ulcers in the genital area</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="genital_pain_burning_sensation2" name="genital_pain_burning_sensation" value="genital_pain_burning_sensation">
                                    <label class="checkbox-label">pain or burning sensation in the genital area</label>
                                </div>
                            </div>
                        </div>
                            </div>
                            <div class="col">
                            <div class="form-group">
                          
                            <br>
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="treatment_for_sti2" name="treatment_for_sti" value="treatment_for_sti">
                                    <label class="checkbox-label">history of treatment for sexually transmitted infections</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="hiv_aids_pid2" name="hiv_aids_pid" value="hiv_aids_pid">
                                    <label class="checkbox-label">HIV/AIDS/Pelvic inflammatory disease</label>
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
                                    <input type="checkbox" id="unpleasant_relationship2" name="unpleasant_relationship" value="unpleasant_relationship">
                                    <label class="checkbox-label">Create an unpleasant relationship with partner</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="partner_does_not_approve2" name="partner_does_not_approve" value="partner_does_not_approve">
                                    <label class="checkbox-label">Partner does not approve of the visit to FP clinic</label>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <br>
                            <div class="checkbox-list">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="domestic_violence2" name="domestic_violence" value="domestic_violence">
                                    <label class="checkbox-label">History of domestic violence or VAW</label>
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
                            <input type="nutextmber" class="form-control" id="weight2" name="weight" required>
                        </div>
                        </div>

                        <div class="col">
                        <div class="form-group">
                            <label for="">Blood Pressure</label>
                            <input type="text" class="form-control" id="bp2" name="bp" required>
                        </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label for="">Height</label>
                            <input type="text" class="form-control" id="height2" name="height" required>
                        </div>
                        </div>

                        <div class="col">
                        <div class="form-group">
                            <label for="">Pulse Rate</label>
                            <input type="text" class="form-control" id="pulse2" name="pulse" required>
                        </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                    <label for="">Skin</label>
                                    <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="skin2" name="skin" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="skin2" name="skin" value="Pale" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Pale</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="skin2" name="skin" value="Yellowish" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Yellowish</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="skin2" name="skin" value="Hematoma" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Hematoma</label>
                                        </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                    <label for="">Extremities</label>
                                    <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="extremities2" name="extremities" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="extremities2" name="extremities" value="Edema" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Edema</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="extremities2" name="extremities" value="Varicosities" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Varicosities</label>
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
                                            <input type="radio" id="conjunctiva2" name="conjunctiva" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="conjunctiva2" name="conjunctiva" value="Pale" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Pale</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="conjunctiva2" name="conjunctiva" value="Yellowish" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Yellowish</label>
                                        </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                    <label for="">Neck</label>
                                    <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="neck2" name="neck" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="neck2" name="neck" value="Enlarge Lymph Nodes" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Enlarge Lymph Nodes</label>
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
                                            <input type="radio" id="breast2" name="breast" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="breast2" name="breast" value="Mass" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Mass</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="breast2" name="breast" value="Nipple Discharge" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Nipple Discharge</label>
                                        </div>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                    <label for="">Abdomen</label>
                                    <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdomen2" name="abdomen" value="Normal" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdomen2" name="abdomen" value="Abdominal Mass" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Abdominal Mass</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdomen2" name="abdomen" value="Varicosities" class="radio-input" required>
                                            <label for="" class="radio-label" style="margin-left: 5px;">Varicosities</label>
                                        </div>
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
                        var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i> View</button>';
                        return editButton;
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
                        var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i> View</button>';
                        return editButton;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });

        
        // Get data from the form

      // Capture the values of the additional fields and checkboxes
      var patient_id = $('#patient_id').val();
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
            $('#editModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching  data: ' + error);
        },
    });
});

$('#updateButton').click(function () {
   
var editId =  $('#editdataId').val();


var abnormal_discharge = $('#abnormal_discharge2').val();
var nurse_id = $('#nurse_id2').val();
var serial = $('#serial2').val();
var method = $('#method2').val();
var no_of_children = $('#no_of_children2').val();
var income = $('#income2').val();
var plan_to_have_more_children = $('#plan_to_have_more_children2').val();
var client_type = $('#client_type2').val();
var reason_for_fp = $('#reason_for_fp2').val();
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
var type_of_last_delivery = $('#type_of_last_delivery2').val();
var mens_type = $('#mens_type2').val();

// Include the fields for fp_physical_examination
var weight = $('#weight2').val();
var bp = $('#bp2').val();
var height = $('#height2').val();
var pulse = $('#pulse2').val();
var skin = $('#skin2').val();
var extremities = $('#extremities2').val();
var conjunctiva = $('#conjunctiva2').val();
var neck = $('#neck2').val();
var breast = $('#breast2').val();
var abdomen = $('#abdomen2').val();

// AJAX request to send data to the server
$.ajax({
    url: 'action/update_family.php',
    method: 'POST',
    data: {
        abnormal_discharge:abnormal_discharge,
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