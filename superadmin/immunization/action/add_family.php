<?php
// Include your database configuration file
include_once('../../../config.php');
session_start();

// Get data from the POST request
$serial_no = $_POST['patient_id'];
$description = $_POST['description'];
$nurse_id = $_POST['nurse_id'];
$checkup_date = $_POST['checkup_date'];

$date = date('Y-m-d');
$doctor_id = $_SESSION['user_id'];

$sql_patient_id = "SELECT id FROM patients WHERE serial_no = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);
$stmt_patient_id->bind_param("s", $serial_no);

if ($stmt_patient_id->execute()) {
    $stmt_patient_id->bind_result($patient_id);
    if ($stmt_patient_id->fetch()) {
        // Now you have the patient_id
        $stmt_patient_id->close();

        $sql = "INSERT INTO immunization (patient_id, description, nurse_id,checkup_date) 
        VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss",
            $patient_id, $description, $nurse_id, $checkup_date);

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
    } else {
        // Patient with the provided serial_no not found
        echo 'Error: Patient not found';
    }
} else {
    // Error executing the query
    echo 'Error: ' . $conn->error;
}


?>
