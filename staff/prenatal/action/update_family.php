<?php
// Include your database configuration file
include_once('../../../config.php');

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

$primary_id = sanitizeInput($_POST['primary_id']);
$nurse_id = sanitizeInput($_POST['nurse_id']);
$height = sanitizeInput($_POST['height']);
$weight = sanitizeInput($_POST['weight']);
$temperature = sanitizeInput($_POST['temperature']);
$pr = sanitizeInput($_POST['pr']);
$rr = sanitizeInput($_POST['rr']);
$bp = sanitizeInput($_POST['bp']);
$menarche = sanitizeInput($_POST['menarche']);
$lmp = sanitizeInput($_POST['lmp']);
$gravida = sanitizeInput($_POST['gravida']);
$para = sanitizeInput($_POST['para']);
$fullterm = sanitizeInput($_POST['fullterm']);
$preterm = sanitizeInput($_POST['preterm']);
$abortion = sanitizeInput($_POST['abortion']);
$stillbirth = sanitizeInput($_POST['stillbirth']);
$alive = sanitizeInput($_POST['alive']);
$hgb = sanitizeInput($_POST['hgb']);
$ua = sanitizeInput($_POST['ua']);
$vdrl = sanitizeInput($_POST['vdrl']);

// Checkboxes - Map to "Yes" or "No"
$forceps_delivery = isset($_POST['forceps_delivery']) ? 'Yes' : 'No';
$smoking = isset($_POST['smoking']) ? 'Yes' : 'No';
$allergy_alcohol_intake = isset($_POST['allergy_alcohol_intake']) ? 'Yes' : 'No';
$previous_cs = isset($_POST['previous_cs']) ? 'Yes' : 'No';
$consecutive_miscarriage = isset($_POST['consecutive_miscarriage']) ? 'Yes' : 'No';
$ectopic_pregnancy_h_mole = isset($_POST['ectopic_pregnancy_h_mole']) ? 'Yes' : 'No';
$pp_bleeding = isset($_POST['pp_bleeding']) ? 'Yes' : 'No';
$baby_weight_gt_4kgs = isset($_POST['baby_weight_gt_4kgs']) ? 'Yes' : 'No';
$asthma = isset($_POST['asthma']) ? 'Yes' : 'No';
$premature_contraction = isset($_POST['premature_contraction']) ? 'Yes' : 'No';
$dm = isset($_POST['dm']) ? 'Yes' : 'No';
$heart_disease = isset($_POST['heart_disease']) ? 'Yes' : 'No';
$obesity = isset($_POST['obesity']) ? 'Yes' : 'No';
$goiter = isset($_POST['goiter']) ? 'Yes' : 'No';

$edc = sanitizeInput($_POST['edc']);
$aog = sanitizeInput($_POST['aog']);
$date_of_last_delivery = sanitizeInput($_POST['date_of_last_delivery']);
$place_of_last_delivery = sanitizeInput($_POST['place_of_last_delivery']);
$tt1 = sanitizeInput($_POST['tt1']);
$tt2 = sanitizeInput($_POST['tt2']);
$tt3 = sanitizeInput($_POST['tt3']);
$tt4 = sanitizeInput($_POST['tt4']);
$tt5 = sanitizeInput($_POST['tt5']);
$multiple_sex_partners = sanitizeInput($_POST['multiple_sex_partners']);
$unusual_discharges = sanitizeInput($_POST['unusual_discharges']);
$itching_sores_around_vagina = sanitizeInput($_POST['itching_sores_around_vagina']);
$tx_for_stis_in_the_past = sanitizeInput($_POST['tx_for_stis_in_the_past']);
$pain_burning_sensation = sanitizeInput($_POST['pain_burning_sensation']);
$ovarian_cyst = sanitizeInput($_POST['ovarian_cyst']);
$myoma_uteri = sanitizeInput($_POST['myoma_uteri']);
$placenta_previa = sanitizeInput($_POST['placenta_previa']);
$still_birth = sanitizeInput($_POST['still_birth']);
$pre_eclampsia = sanitizeInput($_POST['pre_eclampsia']);
$eclampsia = sanitizeInput($_POST['eclampsia']);
$hpn = sanitizeInput($_POST['hpn']);
$uterine_myomectomy = sanitizeInput($_POST['uterine_myomectomy']);
$thyroid_disorder = sanitizeInput($_POST['thyroid_disorder']);
$epilepsy = sanitizeInput($_POST['epilepsy']);
$height_less_than_145cm = sanitizeInput($_POST['height_less_than_145cm']);
$family_history_gt_36cm = sanitizeInput($_POST['family_history_gt_36cm']);

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
    $familyStmt->bind_param(
        "sssssssssssssssssssssssssssssssssi",
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
        multiple_sex_partners=?, unusual_discharges=?, itching_sores_around_vagina=?, tx_for_stis_in_the_past=?, pain_burning_sensation=?, 
        ovarian_cyst=?, myoma_uteri=?, placenta_previa=?, still_birth=?, pre_eclampsia=?, eclampsia=?, premature_contraction=?, hpn=?, 
        uterine_myomectomy=?, thyroid_disorder=?, epilepsy=?, height_less_than_145cm=?, family_history_gt_36cm=? WHERE prenatal_subjective_id=?";
        $familyStmt2 = $conn->prepare($familyUpdateSql2);
        $familyStmt2->bind_param(
            "sssssssssssssssssssssssssssi",
            $edc,
            $aog,
            $date_of_last_delivery,
            $place_of_last_delivery,
            $tt1,
            $tt2,
            $tt3,
            $tt4,
            $tt5,
            $multiple_sex_partners,
            $unusual_discharges,
            $itching_sores_around_vagina,
            $tx_for_stis_in_the_past,
            $pain_burning_sensation,
            $ovarian_cyst,
            $myoma_uteri,
            $placenta_previa,
            $still_birth,
            $pre_eclampsia,
            $eclampsia,
            $premature_contraction,
            $hpn,
            $uterine_myomectomy,
            $thyroid_disorder,
            $epilepsy,
            $height_less_than_145cm,
            $family_history_gt_36cm,
            $primary_id
        );

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