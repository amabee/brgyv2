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
$first_name = validateAndSanitizeInput($_POST['first_name']);
$last_name = validateAndSanitizeInput($_POST['last_name']);
$birthdate = validateAndSanitizeInput($_POST['birthdate']);
$address = validateAndSanitizeInput($_POST['address']);
$username = validateAndSanitizeInput($_POST['username']);
$password = validateAndSanitizeInput($_POST['password']);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Start a transaction to ensure data consistency
$conn->begin_transaction();
$role = 'midwife';

// Insert data into the "users" table
$user_sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("sss", $username, $hashed_password, $role);

if ($user_stmt->execute()) {
    // Get the last inserted user ID
    $user_id = $conn->insert_id;

    // Insert data into the "nurses" table with the user ID as a foreign key
    $nurse_sql = "INSERT INTO midwife (user_id, first_name, last_name, birthdate, address) VALUES (?, ?, ?, ?, ?)";
    $nurse_stmt = $conn->prepare($nurse_sql);
    $nurse_stmt->bind_param("sssss", $user_id, $first_name, $last_name, $birthdate, $address);

    if ($nurse_stmt->execute()) {
        // Commit the transaction if both inserts were successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction on failure
        $conn->rollback();
        echo 'Error: ' . $nurse_stmt->error;
    }

    $nurse_stmt->close();
} else {
    // Error handling for the "users" table insert
    echo 'Error: ' . $user_stmt->error;
}

// Close prepared statements and the database connection
$user_stmt->close();
$conn->close();
?>