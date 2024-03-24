<?php
// Include your database configuration file
include_once('../../../config.php');

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

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

// Get data from the POST request and sanitize it
$first_name = validateAndSanitizeInput($_POST['first_name']);
$last_name = validateAndSanitizeInput($_POST['last_name']);

$address = validateAndSanitizeInput($_POST['address']);
$middle_name = validateAndSanitizeInput($_POST['middle_name']);
$suffix = validateAndSanitizeInput($_POST['suffix']);
$gender = validateAndSanitizeInput($_POST['gender']);
$age = validateAndSanitizeInput($_POST['age']);
$contact_no = validateAndSanitizeInput($_POST['contact_no']);
$civil_status = validateAndSanitizeInput($_POST['civil_status']);
$religion = validateAndSanitizeInput($_POST['religion']);
$serial_no = validateAndSanitizeInput($_POST['serial_no']);

// Get the user's birthdate from the form
$birthdate = validateAndSanitizeInput($_POST['birthdate']);

// Create a DateTime object for the user's birthdate
$birthDateObj = new DateTime($birthdate);

// Get the current date
$currentDateObj = new DateTime();

// Calculate the interval between the user's birthdate and the current date
$interval = $currentDateObj->diff($birthDateObj);

// Get the years from the interval
$age = $interval->y;

// Check if a patient with the same first_name, last_name, and middle_name already exists
$checkSql = "SELECT COUNT(*) FROM patients WHERE first_name = ? AND last_name = ? AND middle_name = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("sss", $first_name, $last_name, $middle_name);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    // A patient with the same first_name, last_name, and middle_name already exists
    echo 'Error: Patient with the same name exists';
} else {
    // No duplicate found, proceed with the insertion
    $sql = "INSERT INTO patients (first_name, last_name, birthdate, address, middle_name, suffix, gender, age, contact_no, civil_status, religion, serial_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", $first_name, $last_name, $birthdate, $address, $middle_name, $suffix, $gender, $age, $contact_no, $civil_status, $religion, $serial_no);

    if ($stmt->execute()) {
        // Successful insertion
        echo 'Success';
    } else {
        // Error handling
        error_log('Error: Database error - ' . $stmt->error);
        echo 'Error: Database error';
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>