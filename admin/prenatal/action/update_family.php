<?php
// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Include your database configuration file
include_once('../../../config.php');

$primary_id = validateAndSanitizeInput($_POST['primary_id']);
$patient_id = 1; // Assuming you don't want to change this dynamically
$nurse_id = 4; // Assuming you don't want to change this dynamically
$serial = validateAndSanitizeInput($_POST['serial']);
$method = validateAndSanitizeInput($_POST['method']);

try {
    // Start a transaction
    $conn->begin_transaction();

    $familyUpdateSql = "UPDATE family_plannings SET patient_id=?, nurse_id=?, method=?, serial=? WHERE id=?";
    $familyStmt = $conn->prepare($familyUpdateSql);
    $familyStmt->bind_param("ssssi", $patient_id, $nurse_id, $method, $serial, $primary_id);

    // Execute both update statements
    $familyUpdateSuccess = $familyStmt->execute();

    if ($familyUpdateSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $familyStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}

// Function to sanitize user input
function sanitizeInput($input)
{
    // Allow only specific HTML tags (in this case, <h1> is allowed)
    $allowedTags = '<h1>';
    return htmlspecialchars(strip_tags(trim($input), $allowedTags), ENT_QUOTES, 'UTF-8');
}

// Function to validate and sanitize user input for SQL queries
function validateAndSanitizeInput($input)
{
    // Implement additional validation if needed
    return sanitizeInput($input);
}
?>