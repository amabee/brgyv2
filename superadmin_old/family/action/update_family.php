<?php
// Include your database configuration file
include_once('../../../config.php');

$primary_id = $_POST['primary_id'];

// Variables for updating fp_information table
$no_of_children = $_POST['no_of_children'];
$income = $_POST['income'];
$plan_to_have_more_children = $_POST['plan_to_have_more_children'];
$client_type = $_POST['client_type'];
$reason_for_fp = $_POST['reason_for_fp'];

// Variables for updating fp_medical_history table

$severe_headaches = $_POST['severe_headaches'];
$history_stroke_heart_attack_hypertension = $_POST['history_stroke_heart_attack_hypertension'];
$hematoma_bruising_gum_bleeding = $_POST['hematoma_bruising_gum_bleeding'];
$breast_cancer_breast_mass = $_POST['breast_cancer_breast_mass'];
$severe_chest_pain = $_POST['severe_chest_pain'];
$cough_more_than_14_days = $_POST['cough_more_than_14_days'];
$vaginal_bleeding = $_POST['vaginal_bleeding'];
$vaginal_discharge = $_POST['vaginal_discharge'];
$phenobarbital_rifampicin = $_POST['phenobarbital_rifampicin'];
$smoker = $_POST['smoker'];
$with_disability = $_POST['with_disability'];

// Variables for updating fp_obstetrical_history table
$no_of_pregnancies = $_POST['no_of_pregnancies'];
$date_of_last_delivery = $_POST['date_of_last_delivery'];
$last_period = $_POST['last_period'];
$type_of_last_delivery = $_POST['type_of_last_delivery'];
$mens_type = $_POST['mens_type'];

// // Variables for updating fp_risk_for_sexuality table
// $abnormal_discharge = $_POST['abnormal_discharge'];
// $genital_sores_ulcers = $_POST['genital_sores_ulcers'];
// $genital_pain_burning_sensation = $_POST['genital_pain_burning_sensation'];
// $treatment_for_sti = $_POST['treatment_for_sti'];
// $hiv_aids_pid = $_POST['hiv_aids_pid'];

// // Variables for updating fp_risk_for_violence_against_women table
// $unpleasant_relationship = $_POST['unpleasant_relationship'];
// $partner_does_not_approve = $_POST['partner_does_not_approve'];
// $domestic_violence = $_POST['domestic_violence'];

// Variables for updating fp_physical_examination table
$weight = $_POST['weight'];
$bp = $_POST['bp'];
$height = $_POST['height'];
$pulse = $_POST['pulse'];
$skin = $_POST['skin'];
$extremities = $_POST['extremities'];
$conjunctiva = $_POST['conjunctiva'];
$neck = $_POST['neck'];
$breast = $_POST['breast'];
$abdomen = $_POST['abdomen'];

try {
    // Start a transaction
    $conn->begin_transaction();

    // Update query for fp_information table
    $updateInfoSql = "UPDATE fp_information SET no_of_children=?, income=?, plan_to_have_more_children=?, client_type=?, reason_for_fp=? WHERE id=?";
    $updateInfoStmt = $conn->prepare($updateInfoSql);
    $updateInfoStmt->bind_param("sssssi", $no_of_children, $income, $plan_to_have_more_children, $client_type, $reason_for_fp, $primary_id);

    // Update query for fp_medical_history table
    $updateHistorySql = "UPDATE fp_medical_history SET severe_headaches=?, history_stroke_heart_attack_hypertension=?, hematoma_bruising_gum_bleeding=?, breast_cancer_breast_mass=?, severe_chest_pain=?, cough_more_than_14_days=?, vaginal_bleeding=?, vaginal_discharge=?, phenobarbital_rifampicin=?, smoker=?, with_disability=? WHERE id=?";
    $updateHistoryStmt = $conn->prepare($updateHistorySql);
    $updateHistoryStmt->bind_param("sssssssssssi", $severe_headaches, $history_stroke_heart_attack_hypertension, $hematoma_bruising_gum_bleeding, $breast_cancer_breast_mass, $severe_chest_pain, $cough_more_than_14_days, $vaginal_bleeding, $vaginal_discharge, $phenobarbital_rifampicin, $smoker, $with_disability, $primary_id);

    // Update query for fp_obstetrical_history table
    $updateObstetricalSql = "UPDATE fp_obstetrical_history SET no_of_pregnancies=?, date_of_last_delivery=?, last_period=?, type_of_last_delivery=?, mens_type=? WHERE id=?";
    $updateObstetricalStmt = $conn->prepare($updateObstetricalSql);
    $updateObstetricalStmt->bind_param("sssssi", $no_of_pregnancies, $date_of_last_delivery, $last_period, $type_of_last_delivery, $mens_type, $primary_id);

    // Update query for fp_risk_for_sexuality table
    // $updateRiskSql = "UPDATE fp_risk_for_sexuality SET abnormal_discharge=?, genital_sores_ulcers=?, genital_pain_burning_sensation=?, treatment_for_sti=?, hiv_aids_pid=? WHERE id=?";
    // $updateRiskStmt = $conn->prepare($updateRiskSql);
    // $updateRiskStmt->bind_param("sssssi", $abnormal_discharge, $genital_sores_ulcers, $genital_pain_burning_sensation, $treatment_for_sti, $hiv_aids_pid, $primary_id);

    // // Update query for fp_risk_for_violence_against_women table
    // $updateViolenceSql = "UPDATE fp_risk_for_violence_against_women SET unpleasant_relationship=?, partner_does_not_approve=?, domestic_violence=? WHERE id=?";
    // $updateViolenceStmt = $conn->prepare($updateViolenceSql);
    // $updateViolenceStmt->bind_param("sssii", $unpleasant_relationship, $partner_does_not_approve, $domestic_violence, $primary_id);

    // Update query for fp_physical_examination table
    $updateExaminationSql = "UPDATE fp_physical_examination SET weight=?, bp=?, height=?, pulse=?, skin=?, extremities=?, conjunctiva=?, neck=?, breast=?, abdomen=? WHERE id=?";
    $updateExaminationStmt = $conn->prepare($updateExaminationSql);
    $updateExaminationStmt->bind_param("ssssssssssi", $weight, $bp, $height, $pulse, $skin, $extremities, $conjunctiva, $neck, $breast, $abdomen, $primary_id);

    // Execute the update statements for all six tables
    $updateInfoSuccess = $updateInfoStmt->execute();
    $updateHistorySuccess = $updateHistoryStmt->execute();
    $updateObstetricalSuccess = $updateObstetricalStmt->execute();
    // $updateRiskSuccess = $updateRiskStmt->execute();
    // $updateViolenceSuccess = $updateViolenceStmt->execute();
    $updateExaminationSuccess = $updateExaminationStmt->execute();

    // if ($updateInfoSuccess && $updateHistorySuccess && $updateObstetricalSuccess && $updateRiskSuccess && $updateViolenceSuccess && $updateExaminationSuccess) {
       if ($updateInfoSuccess && $updateHistorySuccess && $updateObstetricalSuccess  && $updateExaminationSuccess) {
        // Commit the transaction if all updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $updateInfoStmt->close();
    $updateHistoryStmt->close();
    $updateObstetricalStmt->close();
    // $updateRiskStmt->close();
    // $updateViolenceStmt->close();
    $updateExaminationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>
