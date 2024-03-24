<?php
// Include your database configuration file
include_once('../../../config.php');

$primary_id = $_POST['primary_id'];
$nurse_id = $_POST['nurse_id'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$temperature = $_POST['temperature'];
$pr = $_POST['pr'];
$rr = $_POST['rr'];
$bp = $_POST['bp'];
$menarche = $_POST['menarche'];
$lmp = $_POST['lmp'];
$gravida = $_POST['gravida'];
$para = $_POST['para'];
$fullterm = $_POST['fullterm'];
$preterm = $_POST['preterm'];
$abortion = $_POST['abortion'];
$stillbirth = $_POST['stillbirth'];
$alive = $_POST['alive'];
$hgb = $_POST['hgb'];
$ua = $_POST['ua'];
$vdrl = $_POST['vdrl'];


// Checkboxes - Map to "Yes" or "No"
$forceps_delivery = $_POST['forceps_delivery'];
$smoking = $_POST['smoking'];
$allergy_alcohol_intake = $_POST['allergy_alcohol_intake'];
$previous_cs = $_POST['previous_cs'];
$consecutive_miscarriage = $_POST['consecutive_miscarriage'];
$ectopic_pregnancy_h_mole = $_POST['ectopic_pregnancy_h_mole'];
$pp_bleeding = $_POST['pp_bleeding'];
$baby_weight_gt_4kgs = $_POST['baby_weight_gt_4kgs'];
$asthma = $_POST['asthma'];
$premature_contraction = $_POST['premature_contraction'];
$dm = $_POST['dm'];
$heart_disease = $_POST['heart_disease'];
$obesity = $_POST['obesity'];
$goiter = $_POST['goiter'];



$edc = $_POST['edc'];
$aog = $_POST['aog'];
$date_of_last_delivery = $_POST['date_of_last_delivery'];
$place_of_last_delivery = $_POST['place_of_last_delivery'];
$tt1 = $_POST['tt1'];
$tt2 = $_POST['tt2'];
$tt3 = $_POST['tt3'];
$tt4 = $_POST['tt4'];
$tt5 = $_POST['tt5'];
$multiple_sex_partners = $_POST['multiple_sex_partners'];
$unusual_discharges = $_POST['unusual_discharges'];
$itching_sores_around_vagina = $_POST['itching_sores_around_vagina'];
$tx_for_stis_in_the_past = $_POST['tx_for_stis_in_the_past'];
$pain_burning_sensation = $_POST['pain_burning_sensation'];
$ovarian_cyst = $_POST['ovarian_cyst'];
$myoma_uteri = $_POST['myoma_uteri'];
$placenta_previa = $_POST['placenta_previa'];
$still_birth = $_POST['still_birth'];
$pre_eclampsia = $_POST['pre_eclampsia'];
$eclampsia = $_POST['eclampsia'];
$hpn = $_POST['hpn'];
$uterine_myomectomy = $_POST['uterine_myomectomy'];
$thyroid_disorder = $_POST['thyroid_disorder'];
$epilepsy = $_POST['epilepsy'];
$height_less_than_145cm = $_POST['height_less_than_145cm'];
$family_history_gt_36cm = $_POST['family_history_gt_36cm'];


try {
    // Start a transaction
    $conn->begin_transaction();


    // Continue with your SQL update query
$familyUpdateSql = "UPDATE prenatal_subjective SET 
nurse_id=?, 
height=?, 
weight=?, 
temperature=?, 
pr=?, 
rr=?, 
bp=?, 
menarche=?, 
lmp=?, 
gravida=?, 
para=?, 
fullterm=?, 
preterm=?, 
abortion=?, 
stillbirth=?, 
alive=?, 
hgb=?, 
ua=?, 
vdrl=?, 
forceps_delivery=?, 
smoking=?, 
allergy_alcohol_intake=?, 
previous_cs=?, 
consecutive_miscarriage=?, 
ectopic_pregnancy_h_mole=?, 
pp_bleeding=?, 
baby_weight_gt_4kgs=?, 
asthma=?, 
premature_contraction=?, 
dm=?, 
heart_disease=?, 
obesity=?, 
goiter=?
WHERE id=?";
$familyStmt = $conn->prepare($familyUpdateSql);
$familyStmt->bind_param("sssssssssssssssssssssssssssssssssi",
$nurse_id, 
$height, 
$weight, 
$temperature, 
$pr, 
$rr, 
$bp, 
$menarche, 
$lmp, 
$gravida, 
$para, 
$fullterm, 
$preterm, 
$abortion, 
$stillbirth, 
$alive, 
$hgb, 
$ua, 
$vdrl, 
$forceps_delivery, 
$smoking, 
$allergy_alcohol_intake, 
$previous_cs, 
$consecutive_miscarriage, 
$ectopic_pregnancy_h_mole, 
$pp_bleeding, 
$baby_weight_gt_4kgs, 
$asthma, 
$premature_contraction, 
$dm, 
$heart_disease, 
$obesity, 
$goiter, 
$primary_id
);

    // Execute both update statements
    $familyUpdateSuccess = $familyStmt->execute();


    if ($familyUpdateSuccess) {
        // Commit the transaction if both updates are successful
   
    
        $familyUpdateSql2 = "UPDATE prenatal_diagnosis SET edc=?, aog=?, date_of_last_delivery=?, place_of_last_delivery=?, tt1=?, tt2=?, tt3=?, tt4=?, tt5=?, 
        multiple_sex_partners=?, unusual_discharges=?, itching_sores_around_vagina=?, tx_for_stis_in_the_past=?, pain_burning_sensation=?, ovarian_cyst=?, myoma_uteri=?, placenta_previa=?, still_birth=?, pre_eclampsia=?, eclampsia=?, premature_contraction=?, hpn=?, uterine_myomectomy=?, thyroid_disorder=?, epilepsy=?, height_less_than_145cm=?, family_history_gt_36cm=? WHERE prenatal_subjective_id=?";
        $familyStmt2 = $conn->prepare($familyUpdateSql2);
        $familyStmt2->bind_param("sssssssssssssssssssssssssssi", $edc, $aog, $date_of_last_delivery, $place_of_last_delivery, $tt1, $tt2, $tt3, $tt4, $tt5, 
        $multiple_sex_partners, $unusual_discharges, $itching_sores_around_vagina, $tx_for_stis_in_the_past, $pain_burning_sensation, 
        $ovarian_cyst, $myoma_uteri, $placenta_previa, $still_birth, $pre_eclampsia, $eclampsia, $premature_contraction, $hpn, 
        $uterine_myomectomy, $thyroid_disorder, $epilepsy, $height_less_than_145cm, $family_history_gt_36cm, $primary_id);
        
        // Execute the query
        $familyStmt2->execute();
        $conn->commit();
        echo 'Success';


    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $familyStmt->close();
    $familyStmt2->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>
