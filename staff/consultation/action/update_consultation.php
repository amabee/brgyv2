<?php
// Include your database configuration file
include_once('../../../config.php');

// Function to sanitize user input
function sanitizeInput($input)
{
    // Allow only specific HTML tags (in this case, <h1> is allowed)
    $allowedTags = '<h1>';
    return htmlspecialchars(strip_tags(trim($input), $allowedTags), ENT_QUOTES, 'UTF-8');
}

$primary_id = sanitizeInput($_POST['primary_id']);
$subjective = sanitizeInput($_POST['subjective']);
$objective = sanitizeInput($_POST['objective']);
$assessment = sanitizeInput($_POST['assessment']);
$plan = sanitizeInput($_POST['plan']);
$checkup_date = sanitizeInput($_POST['checkup_date']);
$doctor_id = sanitizeInput($_POST['doctor_id']);

$severe_headaches = sanitizeInput($_POST['severe_headaches']);
$history_stroke_heart_attack_hypertension = sanitizeInput($_POST['history_stroke_heart_attack_hypertension']);
$hematoma_bruising_gum_bleeding = sanitizeInput($_POST['hematoma_bruising_gum_bleeding']);
$breast_cancer_breast_mass = sanitizeInput($_POST['breast_cancer_breast_mass']);
$severe_chest_pain = sanitizeInput($_POST['severe_chest_pain']);
$cough_more_than_14_days = sanitizeInput($_POST['cough_more_than_14_days']);
$vaginal_bleeding = sanitizeInput($_POST['vaginal_bleeding']);
$vaginal_discharge = sanitizeInput($_POST['vaginal_discharge']);
$phenobarbital_rifampicin = sanitizeInput($_POST['phenobarbital_rifampicin']);
$smoker = sanitizeInput($_POST['smoker']);
$jaundice = sanitizeInput($_POST['jaundice']);
$with_disability = sanitizeInput($_POST['with_disability']);

$weight = sanitizeInput($_POST['weight']);
$bp = sanitizeInput($_POST['bp']);
$height = sanitizeInput($_POST['height']);
$pulse = sanitizeInput($_POST['pulse']);
$skin = sanitizeInput($_POST['skin']);
$extremities = sanitizeInput($_POST['extremities']);
$conjunctiva = sanitizeInput($_POST['conjunctiva']);
$neck = sanitizeInput($_POST['neck']);

try {
    // Start a transaction
    $conn->begin_transaction();

    $consultationUpdateSql = "UPDATE consultations SET  subjective=?, objective=?, assessment=?, plan=?, checkup_date=?, doctor_id=? WHERE id=?";
    $consultationStmt = $conn->prepare($consultationUpdateSql);
    $consultationStmt->bind_param("ssssssi", $subjective, $objective, $assessment, $plan, $checkup_date, $doctor_id, $primary_id);

    $updateHistorySql = "UPDATE fp_medical_history SET severe_headaches=?, history_stroke_heart_attack_hypertension=?, hematoma_bruising_gum_bleeding=?, breast_cancer_breast_mass=?, severe_chest_pain=?, cough_more_than_14_days=?, vaginal_bleeding=?, vaginal_discharge=?, phenobarbital_rifampicin=?, smoker=?, with_disability=?, jaundice=? WHERE consultation_id=?";
    $updateHistoryStmt = $conn->prepare($updateHistorySql);
    $updateHistoryStmt->bind_param("ssssssssssssi", $severe_headaches, $history_stroke_heart_attack_hypertension, $hematoma_bruising_gum_bleeding, $breast_cancer_breast_mass, $severe_chest_pain, $cough_more_than_14_days, $vaginal_bleeding, $vaginal_discharge, $phenobarbital_rifampicin, $smoker, $with_disability, $jaundice, $primary_id);

    $updateExaminationSql = "UPDATE fp_physical_examination SET weight=?, bp=?, height=?, pulse=?, skin=?, extremities=?, conjunctiva=?, neck=?, breast=?, abdomen=? WHERE consultation_id=?";
    $updateExaminationStmt = $conn->prepare($updateExaminationSql);
    $updateExaminationStmt->bind_param("ssssssssssi", $weight, $bp, $height, $pulse, $skin, $extremities, $conjunctiva, $neck, $breast, $abdomen, $primary_id);

    // Execute both update statements
    $consultationUpdateSuccess = $consultationStmt->execute();
    $updateHistorySuccess = $updateHistoryStmt->execute();
    $updateExaminationSuccess = $updateExaminationStmt->execute();

    if ($consultationUpdateSuccess && $updateHistorySuccess && $updateExaminationSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $consultationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>