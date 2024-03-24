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

session_start();

// Get data from the POST request
$patient_id = validateAndSanitizeInput($_POST['patient_id']);
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

$date = date('Y-m-d');
$doctor_id = $_SESSION['user_id'];

$sql = "INSERT INTO immunization (patient_id, bgc_date, bgc_remarks, hepa_date, hepa_remarks, pentavalent_date1, pentavalent_date2, pentavalent_date3, pentavalent_remarks, oral_date1, oral_date2, oral_date3, oral_remarks, ipv_date1, ipv_date2, ipv_remarks, pcv_date1, pcv_date2, pcv_date3, pcv_remarks, mmr_date1, mmr_date2, mmr_remarks, checkup_date, doctor_id) 
VALUES (?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?,   ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssssssssssssssssss",
    $patient_id,
    $bgc_date,
    $bgc_remarks,
    $hepa_date,
    $hepa_remarks,
    $pentavalent_date1,
    $pentavalent_date2,
    $pentavalent_date3,
    $pentavalent_remarks,
    $oral_date1,
    $oral_date2,
    $oral_date3,
    $oral_remarks,
    $ipv_date1,
    $ipv_date2,
    $ipv_remarks,
    $pcv_date1,
    $pcv_date2,
    $pcv_date3,
    $pcv_remarks,
    $mmr_date1,
    $mmr_date2,
    $mmr_remarks,
    $date,
    $doctor_id
);

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
?>