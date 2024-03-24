<?php
// Include your database configuration file
include_once('../../../config.php');
session_start();

// Get data from the POST request
$patient_id = $_POST['patient_id'];
$subjective = $_POST['subjective'];
$objective = $_POST['objective'];
$assessment = $_POST['assessment'];
$plan = $_POST['plan'];
$diagnosis = $_POST['diagnosis'];
$medicine = $_POST['medicine'];
$date = date('Y-m-d');
$doctor_id = $_POST['doctor_id'];


$sql = "INSERT INTO consultations (patient_id, subjective, objective, assessment, plan, diagnosis, medicine,checkup_date,doctor_id) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $patient_id, $subjective, $objective, $assessment, $plan, $diagnosis, $medicine, $date, $doctor_id);

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