<?php
// Include your database configuration file
include_once('../../../config.php');
session_start();

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Get data from the POST request and sanitize/validate it
$patient_id = (isset($_POST['patient_id'])) ? sanitizeInput($_POST['patient_id']) : '';
$description = (isset($_POST['description'])) ? sanitizeInput($_POST['description']) : '';
$diagnosis = (isset($_POST['diagnosis'])) ? sanitizeInput($_POST['diagnosis']) : '';
$medicine = (isset($_POST['medicine'])) ? sanitizeInput($_POST['medicine']) : '';
$date = date('Y-m-d');
$doctor_id = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : '';

try {
    // Validate that required fields are not empty before proceeding with the insertion
    if (empty($patient_id) || empty($description) || empty($diagnosis) || empty($medicine) || empty($doctor_id)) {
        throw new Exception('Invalid or missing data');
    }

    // Insert consultation data into the database
    $sql = "INSERT INTO consultations (patient_id, description, diagnosis, medicine, checkup_date, doctor_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $patient_id, $description, $diagnosis, $medicine, $date, $doctor_id);

    if ($stmt->execute()) {
        // Successful insertion
        echo 'Success';
    } else {
        throw new Exception('Error inserting consultation: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>