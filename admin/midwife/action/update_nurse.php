<?php
// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Include your database configuration file
include_once ('../../../config.php');

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

$primary_id = validateAndSanitizeInput($_POST['primary_id']);
$firstName = validateAndSanitizeInput($_POST['first_name']);
$lastName = validateAndSanitizeInput($_POST['last_name']);
$birthdate = validateAndSanitizeInput($_POST['birthdate']);
$address = validateAndSanitizeInput($_POST['address']);
$username = validateAndSanitizeInput($_POST['username']);
$password = validateAndSanitizeInput($_POST['password']);

try {
    // Start a transaction
    $conn->begin_transaction();

    // Update the midwife table
    $nursesUpdateSql = "UPDATE midwife SET first_name=?, last_name=?, birthdate=?, address=? WHERE id=?";
    $nursesStmt = $conn->prepare($nursesUpdateSql);
    $nursesStmt->bind_param("ssssi", $firstName, $lastName, $birthdate, $address, $primary_id);

    if (empty ($password)) {
        $usersUpdateSql = "UPDATE users SET username=? WHERE id=(SELECT user_id FROM midwife WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        $usersStmt->bind_param("si", $username, $primary_id);
        $usersStmt->execute();
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $usersUpdateSql = "UPDATE users SET username=?, password=? WHERE id=(SELECT user_id FROM midwife WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        $usersStmt->bind_param("ssi", $username, $hashed_password, $primary_id);
        $usersStmt->execute();
    }

    // Execute the nurses update statement
    $nursesUpdateSuccess = $nursesStmt->execute();

    // Execute the users update statement only if password is provided
    $usersUpdateSuccess = empty ($password) ? true : $usersStmt->execute();

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
    if (!empty ($password)) {
        $usersStmt->close();
    }

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>