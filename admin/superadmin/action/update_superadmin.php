<?php
// Include your database configuration file
include_once ('../../../config.php');

$primary_id = $_POST['primary_id'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // Start a transaction
    $conn->begin_transaction();

    // Update the superadmins table
    $adminsUpdateSql = "UPDATE superadmins SET first_name=?, last_name=?, birthdate=?, address=? WHERE id=?";
    $adminsStmt = $conn->prepare($adminsUpdateSql);
    $adminsStmt->bind_param("ssssi", $firstName, $lastName, $birthdate, $address, $primary_id);

    // Initialize variable to track users update success
    $usersUpdateSuccess = false;

    // Check if password is provided
    if (!empty ($password)) {
        // If password is provided, update the users table with username and password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $usersUpdateSql = "UPDATE users SET username=?, password=? WHERE id=(SELECT user_id FROM superadmins WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        $usersStmt->bind_param("ssi", $username, $hashed_password, $primary_id);
        $usersUpdateSuccess = $usersStmt->execute();
    } else {
        // If password is not provided, update the users table with username only
        $usersUpdateSql = "UPDATE users SET username=? WHERE id=(SELECT user_id FROM superadmins WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        $usersStmt->bind_param("si", $username, $primary_id);
        $usersUpdateSuccess = $usersStmt->execute();
    }

    // Execute the admins update statement
    $adminsUpdateSuccess = $adminsStmt->execute();

    if ($adminsUpdateSuccess && $usersUpdateSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $adminsStmt->close();
    $usersStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}

?>