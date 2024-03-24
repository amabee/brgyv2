<?php
// Include your database configuration file
include_once('../../../config.php');
try {
    // Get the patient ID from the POST request
    $patientId = $_POST['patient_id'];

    // Delete the patient from the "patients" table using prepared statements
    $sql = "DELETE FROM patients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patientId);

    if ($stmt->execute()) {
        // Successful deletion
        echo 'Success';
    } else {
        // Error handling
        throw new Exception('Error deleting patient: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    echo 'Error: ' . $e->getMessage();
}
?>
