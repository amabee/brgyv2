<?php
// Include your database configuration file
include_once('../../../config.php');

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Function to validate and sanitize user input for SQL queries
function validateAndSanitizeInput($input)
{
    // Implement additional validation if needed
    return sanitizeInput($input);
}

// Get updated patient data from the POST request and sanitize it
$patientId = (isset($_POST['patient_id'])) ? validateAndSanitizeInput($_POST['patient_id']) : null;
$description = (isset($_POST['description'])) ? validateAndSanitizeInput($_POST['description']) : '';
$title = (isset($_POST['title'])) ? validateAndSanitizeInput($_POST['title']) : '';
$date = date('Y-m-d'); // Adjust the format according to your needs
$time = date('H:i:s'); // Adjust the format according to your needs

try {
    // Validate that $patientId is not empty before proceeding with the update
    if (empty($patientId)) {
        throw new Exception('Invalid or missing patient ID');
    }

    // Update patient data in the database
    $sql = "UPDATE announcements SET description=?, title=?, date=?, time=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $description, $title, $date, $time, $patientId);

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