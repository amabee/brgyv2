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

// Get data from the POST request and sanitize it
$description = validateAndSanitizeInput($_POST['description']);
$title = validateAndSanitizeInput($_POST['title']);
$date = date('Y-m-d'); // Adjust the format according to your needs
$time = date('H:i:s'); // Adjust the format according to your needs

// Prepare and execute the SQL query
$sql = "INSERT INTO announcements (description, title, date, time) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $description, $title, $date, $time);

if ($stmt->execute()) {
    // Successful insertion
    echo 'Success';
} else {
    // Error handling
    echo 'Error: ' . $conn->error;
}

$stmt->close();
$conn->close();
?>