<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,prenatal_subjective.id as id,patients.first_name as first_name,patients.last_name  as last_name
FROM prenatal_subjective
JOIN prenatal_consultation ON prenatal_consultation.prenatal_subjective_id = prenatal_subjective.id
JOIN patients ON prenatal_subjective.patient_id = patients.id
JOIN midwife ON midwife.id = prenatal_subjective.nurse_id
JOIN users ON users.id = midwife.user_id
WHERE users.id = $user_id AND prenatal_consultation.medicine IS NULL AND prenatal_subjective.is_deleted = 0";

//  AND 

$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
<button type="button" id="openModalButton" class="btn btn-primary" style="display:none">
  Add Prental Record
</button>

<br><br>


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
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
    patientInput.addEventListener('input', function() {
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
                            <label for="">Select Midwife</label>
                            <select class="form-control" name="nurse_id" id="nurse_id" required>
                                <option value="" disabled selected hidden>Select Midwife</option>
                                <?php

                                // Query to fetch patients from the database
                                $sql2 = "SELECT id, first_name, last_name FROM midwife
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

        <h5>II SUBJECTIVE/OBJECTIVE</h5>
    <hr>
    <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Height</label>
                    <input type="text" class="form-control" id="height" name="height" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Weight</label>
                    <input type="text" class="form-control" id="weight" name="weight" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Temperature</label>
                    <input type="text" class="form-control" id="temperature" name="temperature" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">PR</label>
                    <input type="text" class="form-control" id="pr" name="pr" required>
                </div>
            </div>
        
     </div>


     <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">RR</label>
                    <input type="text" class="form-control" id="rr" name="rr" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">BP</label>
                    <input type="text" class="form-control" id="bp" name="bp" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Menarche</label>
                    <input type="text" class="form-control" id="menarche" name="menarche" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">LMP</label>
                    <input type="text" class="form-control" id="lmp" name="lmp" required>
                </div>
            </div>
        
     </div>

 


     
     <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Gravida</label>
                    <input type="text" class="form-control" id="gravida" name="gravida" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Para</label>
                    <input type="text" class="form-control" id="para" name="para" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Fullterm</label>
                    <input type="text" class="form-control" id="fullterm" name="fullterm" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Preterm</label>
                    <input type="text" class="form-control" id="preterm" name="preterm" required>
                </div>
            </div>
        
     </div>

         
     <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="">Abortion</label>
                    <input type="text" class="form-control" id="abortion" name="abortion" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">Stillbirth</label>
                    <input type="text" class="form-control" id="stillbirth" name="stillbirth" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">Alive</label>
                    <input type="text" class="form-control" id="alive" name="alive" required>
                </div>
            </div>
            <div class="col-3">
             
            </div>
        
     </div>
    
     <label for="">Lab Results</label>
     <div class="row">
     
            <div class="col-3">
                <div class="form-group">
                    <label for="">HGB</label>
                    <input type="text" class="form-control" id="hgb" name="hgb" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">U/A</label>
                    <input type="text" class="form-control" id="ua" name="ua" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">VDRL/RPR</label>
                    <input type="text" class="form-control" id="vdrl" name="vdrl" required>
                </div>
            </div>
            <div class="col-3">
             
            </div>
        
     </div>


     <div class="row">
    <div class="col">
        <label for="medical_conditions">Does the client have any of the following?</label>
        <br>
        <div class="form-group">
            <div class="checkbox-list">
            <div class="checkbox-item">
                    <input type="checkbox" id="forceps_delivery" name="forceps_delivery" value="forceps_delivery">
                    <label class="checkbox-label">Forceps Delivery</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="smoking" name="smoking" value="smoking">
                    <label class="checkbox-label">Smoking</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="allergy_alcohol_intake" name="allergy_alcohol_intake" value="allergy_alcohol_intake">
                    <label class="checkbox-label">Allergy to Alcohol Intake</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="previous_cs" name="previous_cs" value="previous_cs">
                    <label class="checkbox-label">Previous Cesarean Section (CS)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="consecutive_miscarriage" name="consecutive_miscarriage" value="consecutive_miscarriage">
                    <label class="checkbox-label">3 Consecutive Miscarriages</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="ectopic_pregnancy_h_mole" name="ectopic_pregnancy_h_mole" value="ectopic_pregnancy_h_mole">
                    <label class="checkbox-label">Ectopic Pregnancy or Hydatidiform Mole within the last 12 months</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="pp_bleeding" name="pp_bleeding" value="pp_bleeding">
                    <label class="checkbox-label">Postpartum Bleeding</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <br>
        <div class="form-group">
            <div class="checkbox-list">
             
                <div class="checkbox-item">
                    <input type="checkbox" id="baby_weight_gt_4kgs" name="baby_weight_gt_4kgs" value="baby_weight_gt_4kgs">
                    <label class="checkbox-label">Baby Weight > 4kgs</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="asthma" name="asthma" value="asthma">
                    <label class="checkbox-label">Asthma</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="goiter" name="goiter" value="goiter">
                    <label class="checkbox-label">Goiter</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="premature_contraction" name="premature_contraction" value="premature_contraction">
                    <label class="checkbox-label">Premature Contractions</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="dm" name="dm" value="dm">
                    <label class="checkbox-label">Diabetes Mellitus (DM)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="heart_disease" name="heart_disease" value="heart_disease">
                    <label class="checkbox-label">Heart Disease</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="obesity" name="obesity" value="obesity">
                    <label class="checkbox-label">Obesity</label>
                </div>
            </div>
        </div>
    </div>
</div>


<hr>

<h5>III ASSESSMENT/DIAGNOSIS</h5>
<hr>
<div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">EDC</label>
                    <input type="text" class="form-control" id="edc" name="edc" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">AOG</label>
                    <input type="text" class="form-control" id="aog" name="aog" required>
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
                    <label for="">Place of Last Delivery</label>
                    <input type="text" class="form-control" id="place_of_last_delivery" name="place_of_last_delivery" required>
                </div>
            </div>
        
</div>

<label for="">TT Injections</label>
<div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">TT1</label>
                    <input type="text" class="form-control" id="tt1" name="tt1" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT2</label>
                    <input type="text" class="form-control" id="tt2" name="tt2" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT3</label>
                    <input type="text" class="form-control" id="tt3" name="tt3" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT4</label>
                    <input type="text" class="form-control" id="tt4" name="tt4" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT5</label>
                    <input type="text" class="form-control" id="tt5" name="tt5" required>
                </div>
            </div>
        
</div>


<label for="">STI Risk</label>
<div class="row">
    <div class="col">
      
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="multiple_sex_partners" name="multiple_sex_partners" value="multiple_sex_partners">
                    <label class="checkbox-label">Multiple Sex Partners</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="unusual_discharges" name="unusual_discharges" value="unusual_discharges">
                    <label class="checkbox-label">Unusual Discharges from Vagina</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="itching_sores_around_vagina" name="itching_sores_around_vagina" value="itching_sores_around_vagina">
                    <label class="checkbox-label">Itching/Sores in or Around the Vagina</label>
                </div>
            </div>
        </div>
    </div>
 
    <div class="col">
    <br>
    
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="tx_for_stis_in_the_past" name="tx_for_stis_in_the_past" value="tx_for_stis_in_the_past">
                    <label class="checkbox-label">Treatment for STI's in the Past</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="pain_burning_sensation" name="pain_burning_sensation" value="pain_burning_sensation">
                    <label class="checkbox-label">Pain/Burning Sensation</label>
                </div>
                <!-- Add more conditions here if needed -->
            </div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col">
        <label for="family_history_conditions">Hx of the following:</label>
        <br>
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="ovarian_cyst" name="ovarian_cyst" value="ovarian_cyst">
                    <label class="checkbox-label">Ovarian Cyst</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="myoma_uteri" name="myoma_uteri" value="myoma_uteri">
                    <label class="checkbox-label">Myoma Uteri</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="placenta_previa" name="placenta_previa" value="placenta_previa">
                    <label class="checkbox-label">Placenta Previa</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="still_birth" name="still_birth" value="still_birth">
                    <label class="checkbox-label">Still Birth</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="pre_eclampsia" name="pre_eclampsia" value="pre_eclampsia">
                    <label class="checkbox-label">Pre-Eclampsia</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="eclampsia" name="eclampsia" value="eclampsia">
                    <label class="checkbox-label">Eclampsia</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="premature_contraction" name="premature_contraction" value="premature_contraction">
                    <label class="checkbox-label">Premature Contraction</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <br>
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="hpn" name="hpn" value="hpn">
                    <label class="checkbox-label">Hypertension (HPN)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="uterine_myomectomy" name="uterine_myomectomy" value="uterine_myomectomy">
                    <label class="checkbox-label">Uterine Myomectomy</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="thyroid_disorder" name="thyroid_disorder" value="thyroid_disorder">
                    <label class="checkbox-label">Thyroid Disorder</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="epilepsy" name="epilepsy" value="epilepsy">
                    <label class="checkbox-label">Epilepsy</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="height_less_than_145cm" name="height_less_than_145cm" value="height_less_than_145cm">
                    <label class="checkbox-label">Height < 145cm</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="family_history_gt_36cm" name="family_history_gt_36cm" value="family_history_gt_36cm">
                    <label class="checkbox-label">Family History of Gestational Diabetes (>36cm)</label>
                </div>
            </div>
        </div>
    </div>
</div>








        </div>
   

     


                </form>
          
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
                                <td class="align-middle">
                                <a href="history_consultation.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-warning ml-1">View History</button></a>

                                
                                <button type="button" class="btn btn-info editbtn" data-row-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-eye"></i> View Record
                                </button>
                                <button type="button" class="btn btn-success editbtn2" data-row-id="<?php echo $row['id']; ?>"><i class="fas fa-edit"></i> Add Consultation </button>
                         
                                  <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Prental Found</td>
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
                <h5 class="modal-title" id="exampleModalLabel"> Prental Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                <div class="row">
            
                
                <div class="col-4">
                    <div class="form-group">
                   
                            <label for="">Select Midwife</label>
                            <select class="form-control" name="nurse_id2" id="nurse_id2" required>
                                <option value="" disabled selected hidden>Select Midwife</option>
                                <?php

                                // Query to fetch patients from the database
                                $sql2 = "SELECT id, first_name, last_name FROM midwife
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

        <h5>II SUBJECTIVE/OBJECTIVE</h5>
    <hr>
    <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Height</label>
                    <input type="text" class="form-control" id="height2" name="height2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Weight</label>
                    <input type="text" class="form-control" id="weight2" name="weight2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Temperature</label>
                    <input type="text" class="form-control" id="temperature2" name="temperature2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">PR</label>
                    <input type="text" class="form-control" id="pr2" name="pr2" required>
                </div>
            </div>
        
     </div>


     <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">RR</label>
                    <input type="text" class="form-control" id="rr2" name="rr2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">BP</label>
                    <input type="text" class="form-control" id="bp2" name="bp2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Menarche</label>
                    <input type="text" class="form-control" id="menarche2" name="menarche2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">LMP</label>
                    <input type="text" class="form-control" id="lmp2" name="lmp2" required>
                </div>
            </div>
        
     </div>



     
     <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Gravida</label>
                    <input type="text" class="form-control" id="gravida2" name="gravida2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Para</label>
                    <input type="text" class="form-control" id="para2" name="para2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Fullterm</label>
                    <input type="text" class="form-control" id="fullterm2" name="fullterm2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Preterm</label>
                    <input type="text" class="form-control" id="preterm2" name="preterm2" required>
                </div>
            </div>
        
     </div>

         
     <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="">Abortion</label>
                    <input type="text" class="form-control" id="abortion2" name="abortion2" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">Stillbirth</label>
                    <input type="text" class="form-control" id="stillbirth2" name="stillbirth2" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">Alive</label>
                    <input type="text" class="form-control" id="alive2" name="alive2" required>
                </div>
            </div>
            <div class="col-3">
             
            </div>
        
     </div>
    
     <label for="">Lab Results</label>
     <div class="row">
     
            <div class="col-3">
                <div class="form-group">
                    <label for="">HGB</label>
                    <input type="text" class="form-control" id="hgb2" name="hgb2" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">U/A</label>
                    <input type="text" class="form-control" id="ua2" name="ua2" required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="">VDRL/RPR</label>
                    <input type="text" class="form-control" id="vdrl2" name="vdrl2" required>
                </div>
            </div>
            <div class="col-3">
             
            </div>
        
     </div>


     <div class="row">
    <div class="col">
        <label for="medical_conditions">Does the client have any of the following?</label>
        <br>
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                        <input type="checkbox" id="forceps_delivery2" name="medical_condition" value="forceps_delivery">
                        <label class="checkbox-label">Forceps Delivery</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="smoking2" name="medical_condition" value="smoking">
                        <label class="checkbox-label">Smoking</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="allergy_alcohol_intake2" name="medical_condition" value="allergy_alcohol_intake">
                        <label class="checkbox-label">Allergy to Alcohol Intake</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="previous_cs2" name="medical_condition" value="previous_cs">
                        <label class="checkbox-label">Previous Cesarean Section (CS)</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="consecutive_miscarriage2" name="medical_condition" value="consecutive_miscarriage">
                        <label class="checkbox-label">3 Consecutive Miscarriages</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="ectopic_pregnancy_h_mole2" name="medical_condition" value="ectopic_pregnancy_h_mole">
                        <label class="checkbox-label">Ectopic Pregnancy or Hydatidiform Mole within the last 12 months</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="pp_bleeding2" name="medical_condition" value="pp_bleeding">
                        <label class="checkbox-label">Postpartum Bleeding</label>
                    </div>
            </div>
        </div>
    </div>
    <div class="col">
        <br>
        <div class="form-group">
            <div class="checkbox-list">
             
      
                <div class="checkbox-item">
                    <input type="checkbox" id="baby_weight_gt_4kgs2" name="medical_condition" value="baby_weight_gt_4kgs">
                    <label class="checkbox-label">Baby Weight > 4kgs</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="asthma2" name="medical_condition" value="asthma">
                    <label class="checkbox-label">Asthma</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="goiter2" name="medical_condition" value="goiter">
                    <label class="checkbox-label">Goiter</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="premature_contraction2" name="medical_condition" value="premature_contraction">
                    <label class="checkbox-label">Premature Contractions</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="dm2" name="medical_condition" value="dm">
                    <label class="checkbox-label">Diabetes Mellitus (DM)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="heart_disease2" name="medical_condition" value="heart_disease">
                    <label class="checkbox-label">Heart Disease</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="obesity2" name="medical_condition" value="obesity">
                    <label class="checkbox-label">Obesity</label>
                </div>
            </div>
        </div>
    </div>
</div>


<hr>

<h5>III ASSESSMENT/DIAGNOSIS</h5>
<hr>
<div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">EDC</label>
                    <input type="text" class="form-control" id="edc2" name="edc2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">AOG</label>
                    <input type="text" class="form-control" id="aog2" name="aog2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Date of Last Delivery</label>
                    <input type="date" class="form-control" id="date_of_last_delivery2" name="date_of_last_delivery2" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">Place of Last Delivery</label>
                    <input type="text" class="form-control" id="place_of_last_delivery2" name="place_of_last_delivery" required>
                </div>
            </div>
        
</div>

<label for="">TT Injections</label>
<div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">TT1</label>
                    <input type="text" class="form-control" id="tt12" name="tt12" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT2</label>
                    <input type="text" class="form-control" id="tt22" name="tt22" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT3</label>
                    <input type="text" class="form-control" id="tt32" name="tt32" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT4</label>
                    <input type="text" class="form-control" id="tt42" name="tt42" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">TT5</label>
                    <input type="text" class="form-control" id="tt52" name="tt52" required>
                </div>
            </div>
        
</div>


<label for="">STI Risk</label>
<div class="row">
    <div class="col">
      
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="multiple_sex_partners2" name="medical_condition" value="multiple_sex_partners">
                    <label class="checkbox-label">Multiple Sex Partners</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="unusual_discharges2" name="medical_condition" value="unusual_discharges">
                    <label class="checkbox-label">Unusual Discharges from Vagina</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="itching_sores_around_vagina2" name="medical_condition" value="itching_sores_around_vagina">
                    <label class="checkbox-label">Itching/Sores in or Around the Vagina</label>
                </div>
            </div>
        </div>
    </div>
 
    <div class="col">
    <br>
    
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="tx_for_stis_in_the_past2" name="medical_condition" value="tx_for_stis_in_the_past">
                    <label class="checkbox-label">Treatment for STI's in the Past</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="pain_burning_sensation2" name="medical_condition" value="pain_burning_sensation">
                    <label class="checkbox-label">Pain/Burning Sensation</label>
                </div>
                <!-- Add more conditions here if needed -->
            </div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col">
        <label for="family_history_conditions">Hx of the following:</label>
        <br>
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="ovarian_cyst2" name="family_history_condition" value="ovarian_cyst">
                    <label class="checkbox-label">Ovarian Cyst</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="myoma_uteri2" name="family_history_condition" value="myoma_uteri">
                    <label class="checkbox-label">Myoma Uteri</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="placenta_previa2" name="family_history_condition" value="placenta_previa">
                    <label class="checkbox-label">Placenta Previa</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="still_birth2" name="family_history_condition" value="still_birth">
                    <label class="checkbox-label">Still Birth</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="pre_eclampsia2" name="family_history_condition" value="pre_eclampsia">
                    <label class="checkbox-label">Pre-Eclampsia</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="eclampsia2" name="family_history_condition" value="eclampsia">
                    <label class="checkbox-label">Eclampsia</label>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col">
        <br>
        <div class="form-group">
            <div class="checkbox-list">
                <div class="checkbox-item">
                    <input type="checkbox" id="hpn2" name="family_history_condition" value="hpn">
                    <label class="checkbox-label">Hypertension (HPN)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="uterine_myomectomy2" name="family_history_condition" value="uterine_myomectomy">
                    <label class="checkbox-label">Uterine Myomectomy</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="thyroid_disorder2" name="family_history_condition" value="thyroid_disorder">
                    <label class="checkbox-label">Thyroid Disorder</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="epilepsy2" name="family_history_condition" value="epilepsy">
                    <label class="checkbox-label">Epilepsy</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="height_less_than_145cm2" name="family_history_condition" value="height_less_than_145cm">
                    <label class="checkbox-label">Height < 145cm</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="family_history_gt_36cm2" name="family_history_condition" value="family_history_gt_36cm">
                    <label class="checkbox-label">Family History of Gestational Diabetes (>36cm)</label>
                </div>
            </div>
        </div>
    </div>








        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prenatal Consultation</h5>
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
                <button type="button" class="btn btn-primary" id="updateButton2">Update</button>
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
                        var viewRec = '<a href="history_consultation.php?id=' + row.id + '"><button type="button" class="btn btn-warning ml-1">View History</button></a>';
                        var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i> View Record</button>';
                        var addButton = '<button type="button" class="btn btn-success editbtn2" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Add Consultation </button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return viewRec + ' ' + editButton + ' ' + addButton+' ' + deleteButton;
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
                        var viewRec = '<a href="history_consultation.php?id=' + row.id + '"><button type="button" class="btn btn-warning ml-1">View History</button></a>';
                        var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i> View Record</button>';
                        var addButton = '<button type="button" class="btn btn-success editbtn2" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Add Consultation </button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return viewRec + ' ' + editButton + ' ' + addButton+' ' + deleteButton;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });

        console.log("row.id:", row.id);
        // Get data from the form

        var patient_id = $('#serial_no2').val();
var nurse_id = $('#nurse_id').val();
var serial = $('#serial').val();
var method = $('#method').val();

// Additional fields for prenatal_subjective
var height = $('#height').val();
var weight = $('#weight').val();
var temperature = $('#temperature').val();
var pr = $('#pr').val();
var rr = $('#rr').val();
var bp = $('#bp').val();
var menarche = $('#menarche').val();
var lmp = $('#lmp').val();
var gravida = $('#gravida').val();
var para = $('#para').val();
var fullterm = $('#fullterm').val();
var preterm = $('#preterm').val();
var abortion = $('#abortion').val();
var stillbirth = $('#stillbirth').val();
var alive = $('#alive').val();
var hgb = $('#hgb').val();
var ua = $('#ua').val();
var vdrl = $('#vdrl').val();
// Additional fields for prenatal_diagnosis
var edc = $('#edc').val();
var aog = $('#aog').val();
var date_of_last_delivery = $('#date_of_last_delivery').val();
var place_of_last_delivery = $('#place_of_last_delivery').val();
var tt1 = $('#tt1').val();
var tt2 = $('#tt2').val();
var tt3 = $('#tt3').val();
var tt4 = $('#tt4').val();
var tt5 = $('#tt5').val();


var forceps_delivery = $('#forceps_delivery').is(':checked') ? 'Yes' : 'No';
var smoking = $('#smoking').is(':checked') ? 'Yes' : 'No';
var allergy_alcohol_intake = $('#allergy_alcohol_intake').is(':checked') ? 'Yes' : 'No';
var previous_cs = $('#previous_cs').is(':checked') ? 'Yes' : 'No';
var consecutive_miscarriage = $('#consecutive_miscarriage').is(':checked') ? 'Yes' : 'No';
var ectopic_pregnancy_h_mole = $('#ectopic_pregnancy_h_mole').is(':checked') ? 'Yes' : 'No';
var pp_bleeding = $('#pp_bleeding').is(':checked') ? 'Yes' : 'No';
var baby_weight_gt_4kgs = $('#baby_weight_gt_4kgs').is(':checked') ? 'Yes' : 'No';
var asthma = $('#asthma2').is(':checked') ? 'Yes' : 'No';
var premature_contraction = $('#premature_contraction').is(':checked') ? 'Yes' : 'No';
var dm = $('#dm').is(':checked') ? 'Yes' : 'No';
var heart_disease = $('#heart_disease').is(':checked') ? 'Yes' : 'No';
var obesity = $('#obesity').is(':checked') ? 'Yes' : 'No';
var goiter = $('#goiter').is(':checked') ? 'Yes' : 'No';

// Checkboxes for prenatal_diagnosis
var multiple_sex_partners = $('#multiple_sex_partners').is(':checked') ? 'Yes' : 'No';
var unusual_discharges = $('#unusual_discharges').is(':checked') ? 'Yes' : 'No';
var itching_sores_around_vagina = $('#itching_sores_around_vagina').is(':checked') ? 'Yes' : 'No';
var tx_for_stis_in_the_past = $('#tx_for_stis_in_the_past').is(':checked') ? 'Yes' : 'No';
var pain_burning_sensation = $('#pain_burning_sensation').is(':checked') ? 'Yes' : 'No';
var ovarian_cyst = $('#ovarian_cyst').is(':checked') ? 'Yes' : 'No';
var myoma_uteri = $('#myoma_uteri').is(':checked') ? 'Yes' : 'No';
var placenta_previa = $('#placenta_previa').is(':checked') ? 'Yes' : 'No';
var still_birth = $('#still_birth').is(':checked') ? 'Yes' : 'No';
var pre_eclampsia = $('#pre_eclampsia').is(':checked') ? 'Yes' : 'No';
var eclampsia = $('#eclampsia').is(':checked') ? 'Yes' : 'No';
var premature_contraction = $('#premature_contraction').is(':checked') ? 'Yes' : 'No';
var hpn = $('#hpn').is(':checked') ? 'Yes' : 'No';
var uterine_myomectomy = $('#uterine_myomectomy').is(':checked') ? 'Yes' : 'No';
var thyroid_disorder = $('#thyroid_disorder').is(':checked') ? 'Yes' : 'No';
var epilepsy = $('#epilepsy').is(':checked') ? 'Yes' : 'No';
var height_less_than_145cm = $('#height_less_than_145cm').is(':checked') ? 'Yes' : 'No';
var family_history_gt_36cm = $('#family_history_gt_36cm').is(':checked') ? 'Yes' : 'No';

// AJAX request to send data to the server
$.ajax({
    url: 'action/add_family.php',
    method: 'POST',
    data: {
        patient_id: patient_id,
        nurse_id: nurse_id,
        serial: serial,
        method: method,
        dm: dm,
        // Include the additional fields for prenatal_subjective
        height: height,
        weight: weight,
        temperature: temperature,
        pr: pr,
        rr: rr,
        bp: bp,
        menarche: menarche,
        lmp: lmp,
        gravida: gravida,
        para: para,
        fullterm: fullterm,
        preterm: preterm,
        abortion: abortion,
        stillbirth: stillbirth,
        alive: alive,
        hgb: hgb,
        ua: ua,
        vdrl: vdrl,
        forceps_delivery: forceps_delivery,
        smoking: smoking,
        allergy_alcohol_intake: allergy_alcohol_intake,
        previous_cs: previous_cs,
        consecutive_miscarriage: consecutive_miscarriage,
        ectopic_pregnancy_h_mole: ectopic_pregnancy_h_mole,
        pp_bleeding: pp_bleeding,
        baby_weight_gt_4kgs: baby_weight_gt_4kgs,
        asthma: asthma,
        premature_contraction: premature_contraction,
        dm: dm,
        heart_disease: heart_disease,
        obesity: obesity,
        goiter: goiter,
        // Include the additional fields for prenatal_diagnosis
        edc: edc,
        aog: aog,
        date_of_last_delivery: date_of_last_delivery,
        place_of_last_delivery: place_of_last_delivery,
        tt1: tt1,
        tt2: tt2,
        tt3: tt3,
        tt4: tt4,
        tt5: tt5,
        // Include checkboxes for prenatal_diagnosis
        multiple_sex_partners: multiple_sex_partners,
        unusual_discharges: unusual_discharges,
        itching_sores_around_vagina: itching_sores_around_vagina,
        tx_for_stis_in_the_past: tx_for_stis_in_the_past,
        pain_burning_sensation: pain_burning_sensation,
        ovarian_cyst: ovarian_cyst,
        myoma_uteri: myoma_uteri,
        placenta_previa: placenta_previa,
        still_birth: still_birth,
        pre_eclampsia: pre_eclampsia,
        eclampsia: eclampsia,
        premature_contraction: premature_contraction,
        hpn: hpn,
        uterine_myomectomy: uterine_myomectomy,
        thyroid_disorder: thyroid_disorder,
        epilepsy: epilepsy,
        height_less_than_145cm: height_less_than_145cm,
        family_history_gt_36cm: family_history_gt_36cm,
    },
    success: function (response) {
        if (response.trim() === 'Success') {
            // Clear the form fields
            $('#patient_id').val('');
            $('#nurse_id').val('');
            $('#serial').val('');
            $('#method').val('');

            // Clear the additional fields
            $('#height').val('');
            $('#weight').val('');
            $('#temperature').val('');
            $('#pr').val('');
            $('#rr').val('');
            $('#bp').val('');
            $('#menarche').val('');
            $('#lmp').val('');
            $('#gravida').val('');
            $('#para').val('');
            $('#fullterm').val('');
            $('#preterm').val('');
            $('#abortion').val('');
            $('#stillbirth').val('');
            $('#alive').val('');
            $('#hgb').val('');
            $('#ua').val('');
            $('#vdrl').val('');
            $('#edc').val('');
            $('#aog').val('');
            $('#date_of_last_delivery').val('');
            $('#place_of_last_delivery').val('');
            $('#tt1').val('');
            $('#tt2').val('');
            $('#tt3').val('');
            $('#tt4').val('');
            $('#tt5').val('');

            // Clear the checkboxes
            $('.checkbox-list input[type="checkbox"]').prop('checked', false);
 


                    updateData();
                    $('#addModal').modal('hide');

                // Remove the modal backdrop manually
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                    // Show a success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Prenatal added successfully',
                    });
            
                } else {
                    console.log(response);
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
                        Swal.fire('Deleted', 'The Prental has been deleted.', 'success');
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
            $('#editModal #nurse_id2').val(editGetData.nurse_id);
            
            $('#editModal #height2').val(editGetData.height);
            $('#editModal #weight2').val(editGetData.weight);
            $('#editModal #temperature2').val(editGetData.temperature);
            $('#editModal #pr2').val(editGetData.pr);
            $('#editModal #rr2').val(editGetData.rr);
            $('#editModal #bp2').val(editGetData.bp);
            $('#editModal #menarche2').val(editGetData.menarche);
            $('#editModal #lmp2').val(editGetData.lmp);
            $('#editModal #gravida2').val(editGetData.gravida);
            $('#editModal #para2').val(editGetData.para);
            $('#editModal #fullterm2').val(editGetData.fullterm);
            $('#editModal #preterm2').val(editGetData.preterm);
            $('#editModal #abortion2').val(editGetData.abortion);
            $('#editModal #stillbirth2').val(editGetData.stillbirth);
            $('#editModal #alive2').val(editGetData.alive);
            $('#editModal #hgb2').val(editGetData.hgb);
            $('#editModal #ua2').val(editGetData.ua);
            $('#editModal #vdrl2').val(editGetData.vdrl);


            if (editGetData.forceps_delivery === 'Yes') {
                $('#forceps_delivery2').prop('checked', true);
            } else {
                $('#forceps_delivery2').prop('checked', false);
            }

            if (editGetData.smoking === 'Yes') {
                $('#smoking2').prop('checked', true);
            } else {
                $('#smoking2').prop('checked', false);
            }

            if (editGetData.allergy_alcohol_intake === 'Yes') {
                $('#allergy_alcohol_intake2').prop('checked', true);
            } else {
                $('#allergy_alcohol_intake2').prop('checked', false);
            }

            
            if (editGetData.previous_cs === 'Yes') {
                $('#previous_cs2').prop('checked', true);
            } else {
                $('#previous_cs2').prop('checked', false);
            }

            if (editGetData.consecutive_miscarriage === 'Yes') {
                $('#consecutive_miscarriage2').prop('checked', true);
            } else {
                $('#consecutive_miscarriage2').prop('checked', false);
            }

              
            if (editGetData.ectopic_pregnancy_h_mole === 'Yes') {
                $('#ectopic_pregnancy_h_mole2').prop('checked', true);
            } else {
                $('#ectopic_pregnancy_h_mole2').prop('checked', false);
            }

            if (editGetData.pp_bleeding === 'Yes') {
                $('#pp_bleeding2').prop('checked', true);
            } else {
                $('#pp_bleeding2').prop('checked', false);
            }

            if (editGetData.baby_weight_gt_4kgs === 'Yes') {
                $('#baby_weight_gt_4kgs2').prop('checked', true);
            } else {
                $('#baby_weight_gt_4kgs2').prop('checked', false);
            }

            if (editGetData.asthma === 'Yes') {
                $('#asthma2').prop('checked', true);
            } else {
                $('#asthma2').prop('checked', false);
            }

            if (editGetData.ectopic_pregnancy_h_mole === 'Yes') {
                $('#ectopic_pregnancy_h_mole2').prop('checked', true);
            } else {
                $('#ectopic_pregnancy_h_mole2').prop('checked', false);
            }

            if (editGetData.premature_contraction === 'Yes') {
                $('#premature_contraction2').prop('checked', true);
            } else {
                $('#premature_contraction2').prop('checked', false);
            }

            if (editGetData.dm === 'Yes') {
                $('#dm2').prop('checked', true);
            } else {
                $('#dm2').prop('checked', false);
            }

            if (editGetData.heart_disease === 'Yes') {
                $('#heart_disease2').prop('checked', true);
            } else {
                $('#heart_disease2').prop('checked', false);
            }

            if (editGetData.obesity === 'Yes') {
                $('#obesity2').prop('checked', true);
            } else {
                $('#obesity2').prop('checked', false);
            }

            if (editGetData.goiter === 'Yes') {
                $('#goiter2').prop('checked', true);
            } else {
                $('#goiter2').prop('checked', false);
            }


            $('#editModal #edc2').val(editGetData.edc);
            $('#editModal #aog2').val(editGetData.aog);
            $('#editModal #date_of_last_delivery2').val(editGetData.date_of_last_delivery);
            $('#editModal #place_of_last_delivery2').val(editGetData.place_of_last_delivery);

            $('#editModal #tt12').val(editGetData.tt1);
            $('#editModal #tt22').val(editGetData.tt2);
            $('#editModal #tt32').val(editGetData.tt3);
            $('#editModal #tt42').val(editGetData.tt4);
            $('#editModal #tt52').val(editGetData.tt5);

            if (editGetData.multiple_sex_partners === 'Yes') {
                $('#multiple_sex_partners2').prop('checked', true);
            } else {
                $('#multiple_sex_partners2').prop('checked', false);
            }

            if (editGetData.unusual_discharges === 'Yes') {
                $('#unusual_discharges2').prop('checked', true);
            } else {
                $('#unusual_discharges2').prop('checked', false);
            }

            if (editGetData.itching_sores_around_vagina === 'Yes') {
                $('#itching_sores_around_vagina2').prop('checked', true);
            } else {
                $('#itching_sores_around_vagina2').prop('checked', false);
            }

            if (editGetData.tx_for_stis_in_the_past === 'Yes') {
                $('#tx_for_stis_in_the_past2').prop('checked', true);
            } else {
                $('#tx_for_stis_in_the_past2').prop('checked', false);
            }

            if (editGetData.pain_burning_sensation === 'Yes') {
                $('#pain_burning_sensation2').prop('checked', true);
            } else {
                $('#pain_burning_sensation2').prop('checked', false);
            }

            if (editGetData.ovarian_cyst === 'Yes') {
                $('#ovarian_cyst2').prop('checked', true);
            } else {
                $('#ovarian_cyst2').prop('checked', false);
            }

            if (editGetData.myoma_uteri === 'Yes') {
                $('#myoma_uteri2').prop('checked', true);
            } else {
                $('#myoma_uteri2').prop('checked', false);
            }

            if (editGetData.placenta_previa === 'Yes') {
                $('#placenta_previa2').prop('checked', true);
            } else {
                $('#placenta_previa2').prop('checked', false);
            }

            if (editGetData.still_birth === 'Yes') {
                $('#still_birth2').prop('checked', true);
            } else {
                $('#still_birth2').prop('checked', false);
            }

            if (editGetData.pre_eclampsia === 'Yes') {
                $('#pre_eclampsia2').prop('checked', true);
            } else {
                $('#pre_eclampsia2').prop('checked', false);
            }

            if (editGetData.eclampsia === 'Yes') {
                $('#eclampsia2').prop('checked', true);
            } else {
                $('#eclampsia2').prop('checked', false);
            }


            if (editGetData.hpn === 'Yes') {
                $('#hpn2').prop('checked', true);
            } else {
                $('#hpn2').prop('checked', false);
            }

            if (editGetData.uterine_myomectomy === 'Yes') {
                $('#uterine_myomectomy2').prop('checked', true);
            } else {
                $('#uterine_myomectomy2').prop('checked', false);
            }

            if (editGetData.thyroid_disorder === 'Yes') {
                $('#thyroid_disorder2').prop('checked', true);
            } else {
                $('#thyroid_disorder2').prop('checked', false);
            }

            if (editGetData.epilepsy === 'Yes') {
                $('#epilepsy2').prop('checked', true);
            } else {
                $('#epilepsy2').prop('checked', false);
            }

            if (editGetData.height_less_than_145cm === 'Yes') {
                $('#height_less_than_145cm2').prop('checked', true);
            } else {
                $('#height_less_than_145cm2').prop('checked', false);
            }

            if (editGetData.family_history_gt_36cm === 'Yes') {
                $('#family_history_gt_36cm2').prop('checked', true);
            } else {
                $('#family_history_gt_36cm2').prop('checked', false);
            }
            
            
            
            
            
            

            $('#editModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching  data: ' + error);
        },
    });
});


$('#tablebod').on('click', '.editbtn2', function () {
    var editId = $(this).data('row-id');

    $.ajax({
        url: 'action/get_consultation_by_id.php', // 
        method: 'POST',
        data: { primary_id: editId },
        success: function (data) {
            console.log(data);
            var editGetData = data; 
            

            $('#editModal2 #editdataId').val(editGetData.id);
            $('#editModal2 #editDescription').val(editGetData.description);
            $('#editModal2 #editDiagnosis').val(editGetData.diagnosis);
            $('#editModal2 #editMedicine').val(editGetData.medicine);
           
            $('#editModal2').modal('show');
        },
        error: function (error) {
            console.error('Error fetching  data: ' + error);
        },
    });
});


$('#updateButton2').click(function () {
   

   var editId = $('#editdataId').val();
   console.log(editId);
   var description = $('#editDescription').val();
   var diagnosis = $('#editDiagnosis').val();
   var medicine = $('#editMedicine').val();

 
   $.ajax({
       url: 'action/update_family2.php',
       method: 'POST',
       data: {
           primary_id: editId,
           description: description,
           diagnosis: diagnosis,
           medicine: medicine,
       },
       success: function (response) {
           // Handle the response
           if (response === 'Success') {
               updateData();
               $('#editModal2').modal('hide');
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

$('#updateButton').click(function () {
   

    var editId = $('#editdataId').val();
var nurse_id = $('#nurse_id2').val();
var height = $('#height2').val();
var weight = $('#weight2').val();
var temperature = $('#temperature2').val();
var pr = $('#pr2').val();
var rr = $('#rr2').val();
var bp = $('#bp2').val();
var menarche = $('#menarche2').val();
var lmp = $('#lmp2').val();
var gravida = $('#gravida2').val();
var para = $('#para2').val();
var fullterm = $('#fullterm2').val();
var preterm = $('#preterm2').val();
var abortion = $('#abortion2').val();
var stillbirth = $('#stillbirth2').val();
var alive = $('#alive2').val();
var hgb = $('#hgb2').val();
var ua = $('#ua2').val();
var vdrl = $('#vdrl2').val();

var forceps_delivery = $('#forceps_delivery2').is(':checked') ? 'Yes' : 'No';
var smoking = $('#smoking2').is(':checked') ? 'Yes' : 'No';
var allergy_alcohol_intake = $('#allergy_alcohol_intake2').is(':checked') ? 'Yes' : 'No';
var previous_cs = $('#previous_cs2').is(':checked') ? 'Yes' : 'No';
var consecutive_miscarriage = $('#consecutive_miscarriage2').is(':checked') ? 'Yes' : 'No';
var ectopic_pregnancy_h_mole = $('#ectopic_pregnancy_h_mole2').is(':checked') ? 'Yes' : 'No';
var pp_bleeding = $('#pp_bleeding2').is(':checked') ? 'Yes' : 'No';
var baby_weight_gt_4kgs = $('#baby_weight_gt_4kgs2').is(':checked') ? 'Yes' : 'No';
var asthma = $('#asthma2').is(':checked') ? 'Yes' : 'No';
var premature_contraction = $('#premature_contraction2').is(':checked') ? 'Yes' : 'No';
var dm = $('#dm2').is(':checked') ? 'Yes' : 'No';
var heart_disease = $('#heart_disease2').is(':checked') ? 'Yes' : 'No';
var obesity = $('#obesity2').is(':checked') ? 'Yes' : 'No';
var goiter = $('#goiter2').is(':checked') ? 'Yes' : 'No';



var edc = $('#edc2').val();
console.log(edc);
var aog = $('#aog2').val();
var date_of_last_delivery = $('#date_of_last_delivery2').val();
var place_of_last_delivery = $('#place_of_last_delivery2').val();
var tt1 = $('#tt12').val();
var tt2 = $('#tt22').val();
var tt3 = $('#tt32').val();
var tt4 = $('#tt42').val();
var tt5 = $('#tt52').val();

var multiple_sex_partners = $('#multiple_sex_partners2').is(':checked') ? 'Yes' : 'No';
var unusual_discharges = $('#unusual_discharges2').is(':checked') ? 'Yes' : 'No';
var itching_sores_around_vagina = $('#itching_sores_around_vagina2').is(':checked') ? 'Yes' : 'No';
var tx_for_stis_in_the_past = $('#tx_for_stis_in_the_past2').is(':checked') ? 'Yes' : 'No';
var pain_burning_sensation = $('#pain_burning_sensation2').is(':checked') ? 'Yes' : 'No';
var ovarian_cyst = $('#ovarian_cyst2').is(':checked') ? 'Yes' : 'No';
var myoma_uteri = $('#myoma_uteri2').is(':checked') ? 'Yes' : 'No';
var placenta_previa = $('#placenta_previa2').is(':checked') ? 'Yes' : 'No';
var still_birth = $('#still_birth2').is(':checked') ? 'Yes' : 'No';
var pre_eclampsia = $('#pre_eclampsia2').is(':checked') ? 'Yes' : 'No';
var eclampsia = $('#eclampsia2').is(':checked') ? 'Yes' : 'No';
var hpn = $('#hpn2').is(':checked') ? 'Yes' : 'No';
var uterine_myomectomy = $('#uterine_myomectomy2').is(':checked') ? 'Yes' : 'No';
var thyroid_disorder = $('#thyroid_disorder2').is(':checked') ? 'Yes' : 'No';
var epilepsy = $('#epilepsy2').is(':checked') ? 'Yes' : 'No';
var height_less_than_145cm = $('#height_less_than_145cm2').is(':checked') ? 'Yes' : 'No';
var family_history_gt_36cm = $('#family_history_gt_36cm2').is(':checked') ? 'Yes' : 'No';


// You can access or use these variables as needed in your code.

  
    $.ajax({
        url: 'action/update_family.php',
        method: 'POST',
        data: {
            primary_id: editId,
            nurse_id: nurse_id,
    height: height,
    weight: weight,
    temperature: temperature,
    pr: pr,
    rr: rr,
    bp: bp,
    menarche: menarche,
    lmp: lmp,
    gravida: gravida,
    para: para,
    fullterm: fullterm,
    preterm: preterm,
    abortion: abortion,
    stillbirth: stillbirth,
    alive: alive,
    hgb: hgb,
    ua: ua,
    vdrl: vdrl,
    forceps_delivery: forceps_delivery,
    smoking: smoking,
    allergy_alcohol_intake: allergy_alcohol_intake,
    previous_cs: previous_cs,
    consecutive_miscarriage: consecutive_miscarriage,
    ectopic_pregnancy_h_mole: ectopic_pregnancy_h_mole,
    pp_bleeding: pp_bleeding,
    baby_weight_gt_4kgs: baby_weight_gt_4kgs,
    asthma: asthma,
    premature_contraction: premature_contraction,
    dm: dm,
    heart_disease: heart_disease,
    obesity: obesity,
    goiter: goiter,
    edc: edc,
    aog: aog,
    date_of_last_delivery: date_of_last_delivery,
    place_of_last_delivery: place_of_last_delivery,
    tt1: tt1,
    tt2: tt2,
    tt3: tt3,
    tt4: tt4,
    tt5: tt5,
    multiple_sex_partners: multiple_sex_partners,
    unusual_discharges: unusual_discharges,
    itching_sores_around_vagina: itching_sores_around_vagina,
    tx_for_stis_in_the_past: tx_for_stis_in_the_past,
    pain_burning_sensation: pain_burning_sensation,
    ovarian_cyst: ovarian_cyst,
    myoma_uteri: myoma_uteri,
    placenta_previa: placenta_previa,
    still_birth: still_birth,
    pre_eclampsia: pre_eclampsia,
    eclampsia: eclampsia,
    hpn: hpn,
    uterine_myomectomy: uterine_myomectomy,
    thyroid_disorder: thyroid_disorder,
    epilepsy: epilepsy,
    height_less_than_145cm: height_less_than_145cm,
    family_history_gt_36cm: family_history_gt_36cm
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
                    text: 'Prental updated successfully',
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