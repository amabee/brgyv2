<?php
// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Include your database configuration file
include_once('../../../config.php');

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

try {
    // Start a transaction
    $conn->begin_transaction();

    // Get data from the POST request and validate/sanitize
    $primary_id = validateAndSanitizeInput($_POST['primary_id']);
    $bgc_date = validateAndSanitizeInput($_POST['bgc_date']);
    $bgc_remarks = validateAndSanitizeInput($_POST['bgc_remarks']);
    $hepa_date = validateAndSanitizeInput($_POST['hepa_date']);
    $hepa_remarks = validateAndSanitizeInput($_POST['hepa_remarks']);
    $pentavalent_date1 = validateAndSanitizeInput($_POST['pentavalent_date1']);
    $pentavalent_date2 = validateAndSanitizeInput($_POST['pentavalent_date2']);
    $pentavalent_date3 = validateAndSanitizeInput($_POST['pentavalent_date3']);
    $pentavalent_remarks = validateAndSanitizeInput($_POST['pentavalent_remarks']);
    $oral_date1 = validateAndSanitizeInput($_POST['oral_date1']);
    $oral_date2 = validateAndSanitizeInput($_POST['oral_date2']);
    $oral_date3 = validateAndSanitizeInput($_POST['oral_date3']);
    $oral_remarks = validateAndSanitizeInput($_POST['oral_remarks']);
    $ipv_date1 = validateAndSanitizeInput($_POST['ipv_date1']);
    $ipv_date2 = validateAndSanitizeInput($_POST['ipv_date2']);
    $ipv_remarks = validateAndSanitizeInput($_POST['ipv_remarks']);
    $pcv_date1 = validateAndSanitizeInput($_POST['pcv_date1']);
    $pcv_date2 = validateAndSanitizeInput($_POST['pcv_date2']);
    $pcv_date3 = validateAndSanitizeInput($_POST['pcv_date3']);
    $pcv_remarks = validateAndSanitizeInput($_POST['pcv_remarks']);
    $mmr_date1 = validateAndSanitizeInput($_POST['mmr_date1']);
    $mmr_date2 = validateAndSanitizeInput($_POST['mmr_date2']);
    $mmr_remarks = validateAndSanitizeInput($_POST['mmr_remarks']);

    $immunizationUpdateSql = "UPDATE immunization SET  bgc_date=?, bgc_remarks=?, hepa_date=?, hepa_remarks=?, pentavalent_date1=?, pentavalent_date2=?, pentavalent_date3=?, pentavalent_remarks=?, oral_date1=?, oral_date2=?, oral_date3=?, oral_remarks=?, ipv_date1=?, ipv_date2=?, ipv_remarks=?, pcv_date1=?, pcv_date2=?, pcv_date3=?, pcv_remarks=?, mmr_date1=?, mmr_date2=?, mmr_remarks=? WHERE id=?";
    $immunizationStmt = $conn->prepare($immunizationUpdateSql);
    $immunizationStmt->bind_param("ssssssssssssssssssssssi", $bgc_date, $bgc_remarks, $hepa_date, $hepa_remarks, $pentavalent_date1, $pentavalent_date2, $pentavalent_date3, $pentavalent_remarks, $oral_date1, $oral_date2, $oral_date3, $oral_remarks, $ipv_date1, $ipv_date2, $ipv_remarks, $pcv_date1, $pcv_date2, $pcv_date3, $pcv_remarks, $mmr_date1, $mmr_date2, $mmr_remarks, $primary_id);

    // Execute the update statement
    $immunizationUpdateSuccess = $immunizationStmt->execute();

    if ($immunizationUpdateSuccess) {
        // Commit the transaction if the update is successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if the update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statement
    $immunizationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>