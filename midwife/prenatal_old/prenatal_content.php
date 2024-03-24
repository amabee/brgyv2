<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,prenatal_subjective.id as id,patients.first_name as first_name,patients.last_name as last_name
FROM prenatal_subjective
JOIN midwife ON midwife.user_id = prenatal_subjective.nurse_id
JOIN patients ON prenatal_subjective.patient_id = patients.id
WHERE  midwife.user_id = $user_id" ;




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
                                <button type="button" class="btn btn-info editbtn" data-row-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button type="button" class="btn btn-success editbtn" data-row-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-edit"></i> Add Consultation
                                </button>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Prental</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                <div class="row">
                <div class="col-4">
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
                    <input type="checkbox" id="forceps_delivery" name="medical_condition" value="forceps_delivery">
                    <label class="checkbox-label">Forceps Delivery</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="smoking" name="medical_condition" value="smoking">
                    <label class="checkbox-label">Smoking</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="allergy_alcohol_intake" name="medical_condition" value="allergy_alcohol_intake">
                    <label class="checkbox-label">Allergy to Alcohol Intake</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="previous_cs" name="medical_condition" value="previous_cs">
                    <label class="checkbox-label">Previous Cesarean Section (CS)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="consecutive_miscarriage" name="medical_condition" value="consecutive_miscarriage">
                    <label class="checkbox-label">3 Consecutive Miscarriages</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="ectopic_pregnancy_h_mole" name="medical_condition" value="ectopic_pregnancy_h_mole">
                    <label class="checkbox-label">Ectopic Pregnancy or Hydatidiform Mole within the last 12 months</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="pp_bleeding" name="medical_condition" value="pp_bleeding">
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
                    <input type="checkbox" id="baby_weight_gt_4kgs" name="medical_condition" value="baby_weight_gt_4kgs">
                    <label class="checkbox-label">Baby Weight > 4kgs</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="asthma" name="medical_condition" value="asthma">
                    <label class="checkbox-label">Asthma</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="goiter" name="medical_condition" value="goiter">
                    <label class="checkbox-label">Goiter</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="premature_contraction" name="medical_condition" value="premature_contraction">
                    <label class="checkbox-label">Premature Contractions</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="dm" name="medical_condition" value="dm">
                    <label class="checkbox-label">Diabetes Mellitus (DM)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="heart_disease" name="medical_condition" value="heart_disease">
                    <label class="checkbox-label">Heart Disease</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="obesity" name="medical_condition" value="obesity">
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
                    <input type="checkbox" id="multiple_sex_partners" name="medical_condition" value="multiple_sex_partners">
                    <label class="checkbox-label">Multiple Sex Partners</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="unusual_discharges" name="medical_condition" value="unusual_discharges">
                    <label class="checkbox-label">Unusual Discharges from Vagina</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="itching_sores_around_vagina" name="medical_condition" value="itching_sores_around_vagina">
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
                    <input type="checkbox" id="tx_for_stis_in_the_past" name="medical_condition" value="tx_for_stis_in_the_past">
                    <label class="checkbox-label">Treatment for STI's in the Past</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="pain_burning_sensation" name="medical_condition" value="pain_burning_sensation">
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
                    <input type="checkbox" id="ovarian_cyst" name="family_history_condition" value="ovarian_cyst">
                    <label class="checkbox-label">Ovarian Cyst</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="myoma_uteri" name="family_history_condition" value="myoma_uteri">
                    <label class="checkbox-label">Myoma Uteri</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="placenta_previa" name="family_history_condition" value="placenta_previa">
                    <label class="checkbox-label">Placenta Previa</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="still_birth" name="family_history_condition" value="still_birth">
                    <label class="checkbox-label">Still Birth</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="pre_eclampsia" name="family_history_condition" value="pre_eclampsia">
                    <label class="checkbox-label">Pre-Eclampsia</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="eclampsia" name="family_history_condition" value="eclampsia">
                    <label class="checkbox-label">Eclampsia</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="premature_contraction" name="family_history_condition" value="premature_contraction">
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
                    <input type="checkbox" id="hpn" name="family_history_condition" value="hpn">
                    <label class="checkbox-label">Hypertension (HPN)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="uterine_myomectomy" name="family_history_condition" value="uterine_myomectomy">
                    <label class="checkbox-label">Uterine Myomectomy</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="thyroid_disorder" name="family_history_condition" value="thyroid_disorder">
                    <label class="checkbox-label">Thyroid Disorder</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="epilepsy" name="family_history_condition" value="epilepsy">
                    <label class="checkbox-label">Epilepsy</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="height_less_than_145cm" name="family_history_condition" value="height_less_than_145cm">
                    <label class="checkbox-label">Height < 145cm</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="family_history_gt_36cm" name="family_history_condition" value="family_history_gt_36cm">
                    <label class="checkbox-label">Family History of Gestational Diabetes (>36cm)</label>
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
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        var addButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Add Consultation</button>';
                                         
                                         return editButton + ' ' + addButton +' '+ deleteButton;
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
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        var addButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Add Consultation</button>';
                                         
                                         return editButton + ' ' + addButton +' '+ deleteButton;
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