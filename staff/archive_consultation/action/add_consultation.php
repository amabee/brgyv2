<?php
// Include your database configuration file
include_once('../../../config.php');
session_start();

// Get data from the POST request
$serial_no = $_POST['patient_id'];
$description = $_POST['description'];
$checkup_date = $_POST['checkup_date'];
$doctor_id = $_POST['doctor_id'];

// Query to find the patient_id based on the serial_no
$sql_patient_id = "SELECT id FROM patients WHERE serial_no = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);
$stmt_patient_id->bind_param("s", $serial_no);

if ($stmt_patient_id->execute()) {
    $stmt_patient_id->bind_result($patient_id);
    if ($stmt_patient_id->fetch()) {
        // Now you have the patient_id
        $stmt_patient_id->close();

        // Insert data into the consultations table
        $sql_insert = "INSERT INTO consultations (patient_id, description, checkup_date, doctor_id) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $patient_id, $description, $checkup_date, $doctor_id);

        if ($stmt_insert->execute()) {
            // Successful insertion
            echo 'Success';
        } else {
            // Error handling
            echo 'Error: ' . $conn->error;
        }
        $stmt_insert->close();
    } else {
        // Patient with the provided serial_no not found
        echo 'Error: Patient not found';
    }
} else {
    // Error executing the query
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
