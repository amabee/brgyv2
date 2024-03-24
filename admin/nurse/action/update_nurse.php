<?php

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Include your database configuration file
include_once ('../../../config.php');

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

$primary_id = validateAndSanitizeInput($_POST['primary_id']);
$firstName = validateAndSanitizeInput($_POST['first_name']);
$lastName = validateAndSanitizeInput($_POST['last_name']);
$birthdate = validateAndSanitizeInput($_POST['birthdate']);
$address = validateAndSanitizeInput($_POST['address']);
$username = validateAndSanitizeInput($_POST['username']);
$password = validateAndSanitizeInput($_POST['password']);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Start a transaction
    $conn->begin_transaction();

    // Update the nurses table
    $nursesUpdateSql = "UPDATE nurses SET first_name=?, last_name=?, birthdate=?, address=? WHERE id=?";
    $nursesStmt = $conn->prepare($nursesUpdateSql);
    $nursesStmt->bind_param("ssssi", $firstName, $lastName, $birthdate, $address, $primary_id);

    if (empty ($password)) {
        // Update users table with username only
        $usersUpdateSql = "UPDATE users SET username=? WHERE id=(SELECT user_id FROM nurses WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        $usersStmt->bind_param("si", $username, $primary_id);
        $usersUpdateSuccess = $usersStmt->execute();
    } else {
        // Update users table with username and password
        $usersUpdateSql = "UPDATE users SET username=?, password=? WHERE id=(SELECT user_id FROM nurses WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        $usersStmt->bind_param("ssi", $username, $hashed_password, $primary_id);
        $usersUpdateSuccess = $usersStmt->execute();
    }

    // Execute both update statements
    $nursesUpdateSuccess = $nursesStmt->execute();

    if ($nursesUpdateSuccess && $usersUpdateSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $nursesStmt->close();
    $usersStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}

?>