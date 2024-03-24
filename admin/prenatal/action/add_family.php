<?php
// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Include your database configuration file
include_once('../../../config.php');
session_start();

// Function to sanitize user input
function sanitizeInput($input)
{
    // Allow only specific HTML tags (in this case, <h1> is allowed)
    $allowedTags = '<h1>';
    return htmlspecialchars(strip_tags(trim($input), $allowedTags), ENT_QUOTES, 'UTF-8');
}

// Function to validate and sanitize user input for SQL queries
function validateAndSanitizeInput($input)
{
    // Implement additional validation if needed
    return sanitizeInput($input);
}

// Get data from the POST request for prenatal_subjective
$patient_id = validateAndSanitizeInput($_POST['patient_id']);
$height = validateAndSanitizeInput($_POST['height']);
$weight = validateAndSanitizeInput($_POST['weight']);
$temperature = validateAndSanitizeInput($_POST['temperature']);
$pr = validateAndSanitizeInput($_POST['pr']);
$rr = validateAndSanitizeInput($_POST['rr']);
$bp = validateAndSanitizeInput($_POST['bp']);
$menarche = validateAndSanitizeInput($_POST['menarche']);
$lmp = validateAndSanitizeInput($_POST['lmp']);
$gravida = validateAndSanitizeInput($_POST['gravida']);
$para = validateAndSanitizeInput($_POST['para']);
$fullterm = validateAndSanitizeInput($_POST['fullterm']);
$preterm = validateAndSanitizeInput($_POST['preterm']);
$abortion = validateAndSanitizeInput($_POST['abortion']);
$stillbirth = validateAndSanitizeInput($_POST['stillbirth']);
$alive = validateAndSanitizeInput($_POST['alive']);
$hgb = validateAndSanitizeInput($_POST['hgb']);
$ua = validateAndSanitizeInput($_POST['ua']);
$vdrl = validateAndSanitizeInput($_POST['vdrl']);

// Checkboxes
$forceps_delivery = isset($_POST['forceps_delivery']) ? 'Yes' : 'No';
$smoking = isset($_POST['smoking']) ? 'Yes' : 'No';
$allergy_alcohol_intake = isset($_POST['allergy_alcohol_intake']) ? 'Yes' : 'No';
$previous_cs = isset($_POST['previous_cs']) ? 'Yes' : 'No';
$consecutive_miscarriage = isset($_POST['consecutive_miscarriage']) ? 'Yes' : 'No';
$ectopic_pregnancy_h_mole = isset($_POST['ectopic_pregnancy_h_mole']) ? 'Yes' : 'No';
$pp_bleeding = isset($_POST['pp_bleeding']) ? 'Yes' : 'No';
$baby_weight_gt_4kgs = isset($_POST['baby_weight_gt_4kgs']) ? 'Yes' : 'No';
$asthma = isset($_POST['asthma']) ? 'Yes' : 'No';
$goiter = isset($_POST['goiter']) ? 'Yes' : 'No';
$premature_contraction = isset($_POST['premature_contraction']) ? 'Yes' : 'No';
$obesity = isset($_POST['obesity']) ? 'Yes' : 'No';
$heart_disease = isset($_POST['heart_disease']) ? 'Yes' : 'No';

$date = date('Y-m-d');
$doctor_id = $_SESSION['user_id'];

// Prepare and execute the SQL statement to insert into prenatal_subjective
$sql1 = "INSERT INTO prenatal_subjective (patient_id, height, weight, temperature, pr, rr, bp, menarche, lmp, gravida, para, fullterm, preterm, abortion, stillbirth, alive, hgb, ua, vdrl, forceps_delivery, smoking, allergy_alcohol_intake, previous_cs, consecutive_miscarriage, ectopic_pregnancy_h_mole, pp_bleeding, baby_weight_gt_4kgs, asthma, goiter, premature_contraction, obesity, heart_disease, checkup_date, doctor_id) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param(
    "ssssssssssssssssssssssssssssssssss",
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
    $doctor_id
);


if ($stmt1->execute()) {
    // Get the last inserted ID
    $lastInsertedId = $conn->insert_id;

    // Get data from the POST request for prenatal_diagnosis
    $edc = validateAndSanitizeInput($_POST['edc']);
    $aog = validateAndSanitizeInput($_POST['aog']);
    $date_of_last_delivery = validateAndSanitizeInput($_POST['date_of_last_delivery']);
    $place_of_last_delivery = validateAndSanitizeInput($_POST['place_of_last_delivery']);
    $tt1 = validateAndSanitizeInput($_POST['tt1']);
    $tt2 = validateAndSanitizeInput($_POST['tt2']);
    $tt3 = validateAndSanitizeInput($_POST['tt3']);
    $tt4 = validateAndSanitizeInput($_POST['tt4']);
    $tt5 = validateAndSanitizeInput($_POST['tt5']);

    // Checkboxes for prenatal_diagnosis
    $multiple_sex_partners = isset($_POST['multiple_sex_partners']) ? 'Yes' : 'No';
    $unusual_discharges = isset($_POST['unusual_discharges']) ? 'Yes' : 'No';
    $itching_sores_around_vagina = isset($_POST['itching_sores_around_vagina']) ? 'Yes' : 'No';
    $tx_for_stis_in_the_past = isset($_POST['tx_for_stis_in_the_past']) ? 'Yes' : 'No';
    $pain_burning_sensation = isset($_POST['pain_burning_sensation']) ? 'Yes' : 'No';
    $ovarian_cyst = isset($_POST['ovarian_cyst']) ? 'Yes' : 'No';
    $myoma_uteri = isset($_POST['myoma_uteri']) ? 'Yes' : 'No';
    $placenta_previa = isset($_POST['placenta_previa']) ? 'Yes' : 'No';
    $still_birth = isset($_POST['still_birth']) ? 'Yes' : 'No';
    $pre_eclampsia = isset($_POST['pre_eclampsia']) ? 'Yes' : 'No';
    $eclampsia = isset($_POST['eclampsia']) ? 'Yes' : 'No';
    $premature_contraction = isset($_POST['premature_contraction']) ? 'Yes' : 'No';
    $hpn = isset($_POST['hpn']) ? 'Yes' : 'No';
    $uterine_myomectomy = isset($_POST['uterine_myomectomy']) ? 'Yes' : 'No';
    $thyroid_disorder = isset($_POST['thyroid_disorder']) ? 'Yes' : 'No';
    $epilepsy = isset($_POST['epilepsy']) ? 'Yes' : 'No';
    $height_less_than_145cm = isset($_POST['height_less_than_145cm']) ? 'Yes' : 'No';
    $family_history_gt_36cm = isset($_POST['family_history_gt_36cm']) ? 'Yes' : 'No';

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