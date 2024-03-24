<?php
// Include your database configuration file
include_once('../../../config.php');
session_start();
// Function to sanitize input data
function sanitize_input($input)
{
    return filter_var($input, FILTER_SANITIZE_STRING);
}

// Get data from the POST request for prenatal_subjective
$patient_id = sanitize_input($_POST['patient_id']);
$height = sanitize_input($_POST['height']);
$weight = sanitize_input($_POST['weight']);
$temperature = sanitize_input($_POST['temperature']);
$pr = sanitize_input($_POST['pr']);
$rr = sanitize_input($_POST['rr']);
$bp = sanitize_input($_POST['bp']);
$menarche = sanitize_input($_POST['menarche']);
$lmp = sanitize_input($_POST['lmp']);
$gravida = sanitize_input($_POST['gravida']);
$para = sanitize_input($_POST['para']);
$fullterm = sanitize_input($_POST['fullterm']);
$preterm = sanitize_input($_POST['preterm']);
$abortion = sanitize_input($_POST['abortion']);
$stillbirth = sanitize_input($_POST['stillbirth']);
$alive = sanitize_input($_POST['alive']);
$hgb = sanitize_input($_POST['hgb']);
$ua = sanitize_input($_POST['ua']);
$vdrl = sanitize_input($_POST['vdrl']);
$nurse_id = sanitize_input($_POST['nurse_id']);
$date = date('Y-m-d');
$forceps_delivery = sanitize_input($_POST['forceps_delivery']);
$smoking = sanitize_input($_POST['smoking']);
$allergy_alcohol_intake = sanitize_input($_POST['allergy_alcohol_intake']);
$previous_cs = sanitize_input($_POST['previous_cs']);
$consecutive_miscarriage = sanitize_input($_POST['consecutive_miscarriage']);
$ectopic_pregnancy_h_mole = sanitize_input($_POST['ectopic_pregnancy_h_mole']);
$pp_bleeding = sanitize_input($_POST['pp_bleeding']);
$baby_weight_gt_4kgs = sanitize_input($_POST['baby_weight_gt_4kgs']);
$asthma = sanitize_input($_POST['asthma']);
$premature_contraction = sanitize_input($_POST['premature_contraction']);
$dm = sanitize_input($_POST['dm']);
$heart_disease = sanitize_input($_POST['heart_disease']);
$obesity = sanitize_input($_POST['obesity']);
$goiter = sanitize_input($_POST['goiter']);



$sql_patient_id = "SELECT id FROM patients WHERE serial_no = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);
$stmt_patient_id->bind_param("s", $patient_id);
if ($stmt_patient_id->execute()) {
    $stmt_patient_id->bind_result($patient_id);
    if ($stmt_patient_id->fetch()) {
        // Now you have the patient_id
        $stmt_patient_id->close();

    } else {
        // Patient with the provided serial_no not found
        echo 'Error: Patient not found';
    }
} else {
    // Error executing the query
    echo 'Error: ' . $conn->error;
}

// Prepare and execute the SQL statement to insert into prenatal_subjective
$sql1 = "INSERT INTO prenatal_subjective (patient_id, height, weight, temperature, pr, rr, bp, menarche, lmp, gravida, para, fullterm, preterm, abortion, stillbirth, alive, hgb, ua, vdrl, forceps_delivery, smoking, allergy_alcohol_intake, previous_cs, consecutive_miscarriage, ectopic_pregnancy_h_mole, pp_bleeding, baby_weight_gt_4kgs, asthma, goiter, premature_contraction, obesity, heart_disease, checkup_date, doctor_id,nurse_id,dm) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param(
    "ssssssssssssssssssssssssssssssssssss",
    $patient_id,
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
    $goiter,
    $premature_contraction,
    $obesity,
    $heart_disease,
    $date,
    $doctor_id,
    $nurse_id,
    $dm
);


if ($stmt1->execute()) {
    // Get the last inserted ID
    $lastInsertedId = $conn->insert_id;

    $sql7 = "INSERT INTO prenatal_consultation (prenatal_subjective_id,patient_id,midwife_id,checkup_date)
    VALUES (?,?,?,?)";
    $stmt7 = $conn->prepare($sql7);
    $stmt7->bind_param("dsss", $lastInsertedId, $patient_id, $nurse_id, $date);
    $stmt7->execute();

    // Get data from the POST request for prenatal_diagnosis
    $edc = $_POST['edc'];
    $aog = $_POST['aog'];
    $date_of_last_delivery = $_POST['date_of_last_delivery'];
    $place_of_last_delivery = $_POST['place_of_last_delivery'];
    $tt1 = $_POST['tt1'];
    $tt2 = $_POST['tt2'];
    $tt3 = $_POST['tt3'];
    $tt4 = $_POST['tt4'];
    $tt5 = $_POST['tt5'];

    // Checkboxes for prenatal_diagnosis
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

    // Prepare and execute the SQL statement to insert into prenatal_diagnosis
// Prepare and execute the SQL statement to insert into prenatal_diagnosis
    $sql2 = "INSERT INTO prenatal_diagnosis (prenatal_subjective_id, patient_id, edc, aog, date_of_last_delivery, place_of_last_delivery, tt1, tt2, tt3, tt4, tt5, multiple_sex_partners, unusual_discharges, itching_sores_around_vagina, tx_for_stis_in_the_past, pain_burning_sensation, ovarian_cyst, myoma_uteri, placenta_previa, still_birth, pre_eclampsia, eclampsia, premature_contraction, hpn, uterine_myomectomy, thyroid_disorder, epilepsy, height_less_than_145cm, family_history_gt_36cm) 
VALUES (?, ?, ?, ?, ?,  ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,    ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,  ?, ?, ?, ?)";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param(
        "dssssssssssssssssssssssssssss",
        $lastInsertedId,
        $patient_id,
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
        $family_history_gt_36cm
    );


    if ($stmt2->execute()) {
        // Successful insertion for prenatal_diagnosis
        echo 'Success';
    } else {
        // Error handling for prenatal_diagnosis
        echo 'Error: ' . $conn->error;
    }

    // Close the database connection for prenatal_diagnosis
    $stmt2->close();
} else {
    // Error handling for prenatal_subjective
    echo 'Error: ' . $conn->error;
}

// Close the database connection for prenatal_subjective
$stmt1->close();
$conn->close();
?>