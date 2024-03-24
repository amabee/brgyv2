<?php
// Include your database configuration file
include_once('../../../config.php');
session_start();

// Get data from the POST request
$patient_id = $_POST['patient_id'];
$bgc_date = $_POST['bgc_date'];
$bgc_remarks = $_POST['bgc_remarks'];
$hepa_date = $_POST['hepa_date'];
$hepa_remarks = $_POST['hepa_remarks'];
$pentavalent_date1 = $_POST['pentavalent_date1'];
$pentavalent_date2 = $_POST['pentavalent_date2'];
$pentavalent_date3 = $_POST['pentavalent_date3'];
$pentavalent_remarks = $_POST['pentavalent_remarks'];
$oral_date1 = $_POST['oral_date1'];
$oral_date2 = $_POST['oral_date2'];
$oral_date3 = $_POST['oral_date3'];
$oral_remarks = $_POST['oral_remarks'];
$ipv_date1 = $_POST['ipv_date1'];
$ipv_date2 = $_POST['ipv_date2'];
$ipv_remarks = $_POST['ipv_remarks'];
$pcv_date1 = $_POST['pcv_date1'];
$pcv_date2 = $_POST['pcv_date2'];
$pcv_date3 = $_POST['pcv_date3'];
$pcv_remarks = $_POST['pcv_remarks'];
$mmr_date1 = $_POST['mmr_date1'];
$mmr_date2 = $_POST['mmr_date2'];
$mmr_remarks = $_POST['mmr_remarks'];

$date = date('Y-m-d');
$doctor_id = $_SESSION['user_id'];

$sql = "INSERT INTO immunization (patient_id, bgc_date, bgc_remarks, hepa_date, hepa_remarks, pentavalent_date1, pentavalent_date2, pentavalent_date3, pentavalent_remarks, oral_date1, oral_date2, oral_date3, oral_remarks, ipv_date1, ipv_date2, ipv_remarks, pcv_date1, pcv_date2, pcv_date3, pcv_remarks, mmr_date1, mmr_date2, mmr_remarks, checkup_date, doctor_id) 
VALUES (?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssssssssssssssss",
    $patient_id, $bgc_date, $bgc_remarks, $hepa_date, $hepa_remarks, $pentavalent_date1, $pentavalent_date2, $pentavalent_date3, $pentavalent_remarks, $oral_date1, $oral_date2, $oral_date3, $oral_remarks, $ipv_date1, $ipv_date2, $ipv_remarks, $pcv_date1, $pcv_date2, $pcv_date3, $pcv_remarks, $mmr_date1, $mmr_date2, $mmr_remarks, $date, $doctor_id);

if ($stmt->execute()) {
    // Successful insertion
    echo 'Success';
} else {
    // Error handling
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
