<?php
// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Include your database configuration file
include_once('../../../config.php');

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Get data from the POST request and sanitize it
$primary_id = (isset($_POST['primary_id'])) ? sanitizeInput($_POST['primary_id']) : null;
$patient_id = (isset($_POST['patient_id'])) ? sanitizeInput($_POST['patient_id']) : null;
$description = (isset($_POST['description'])) ? sanitizeInput($_POST['description']) : '';
$diagnosis = (isset($_POST['diagnosis'])) ? sanitizeInput($_POST['diagnosis']) : '';
$medicine = (isset($_POST['medicine'])) ? sanitizeInput($_POST['medicine']) : '';

try {
    // Validate that required fields are not empty before proceeding with the update
    if (empty($primary_id) || empty($patient_id) || empty($description) || empty($diagnosis) || empty($medicine)) {
        throw new Exception('Invalid or missing data');
    }

    // Start a transaction
    $conn->begin_transaction();

    // Update the consultation data
    $consultationUpdateSql = "UPDATE consultations SET patient_id=?, description=?, diagnosis=?, medicine=? WHERE id=?";
    $consultationStmt = $conn->prepare($consultationUpdateSql);
    $consultationStmt->bind_param("ssssi", $patient_id, $description, $diagnosis, $medicine, $primary_id);

    // Execute the update statement
    $consultationUpdateSuccess = $consultationStmt->execute();

    if ($consultationUpdateSuccess) {
        // Commit the transaction if the update is successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if the update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statement
    $consultationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>