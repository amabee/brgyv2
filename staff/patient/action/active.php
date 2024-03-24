<?php
// Include your database configuration file
include_once('../../../config.php');

try {
    // Validate and sanitize user input
    $dataId = isset($_POST['patient_id']) ? intval($_POST['patient_id']) : 0;

    // Check if $dataId is a valid integer
    if ($dataId <= 0) {
        throw new Exception('Invalid input for patient_id');
    }

    // Update the is_deleted column instead of deleting
    $sql = "UPDATE patients SET is_deleted = 0 WHERE serial_no = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters with proper data type
    $stmt->bind_param("i", $dataId);

    if ($stmt->execute()) {
        // Successful update
        echo 'Success';
    } else {
        // Error handling
        throw new Exception('Error updating data: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    echo 'Error: ' . $e->getMessage();
}
?>