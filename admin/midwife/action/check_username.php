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

// Function to validate and sanitize user input for SQL queries
function validateAndSanitizeInput($input)
{
    return sanitizeInput($input);
}

// Check if the request is an AJAX request
if (isset($_POST['username'])) {
    $username = validateAndSanitizeInput($_POST['username']);

    // Query to check if the username already exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    // If the username exists, return an error
    if ($stmt->num_rows > 0) {
        echo "error";
    } else {
        echo "success";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>