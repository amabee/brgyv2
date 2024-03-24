<?php
// Include your database configuration file
include_once('../../../config.php');

// Get updated patient data from the POST request
$patientId = $_POST['patient_id'];
$description = $_POST['description'];
$title = $_POST['title'];

try {
    // Update patient data in the database
    $sql = "UPDATE announcements SET description=?, title=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $description, $title, $patientId);

    if ($stmt->execute()) {
        // Successful update
        echo 'Success';
    } else {
        throw new Exception('Error updating patient: ' . $stmt->error);
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
