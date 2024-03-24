<?php
// Include your database configuration file
include_once('../../../config.php');

$primary_id = $_POST['primary_id'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
try {
    // Start a transaction
    $conn->begin_transaction();

    // Update the nurses table
    $nursesUpdateSql = "UPDATE nurses SET first_name=?, last_name=?, birthdate=?, address=? WHERE id=?";
    $nursesStmt = $conn->prepare($nursesUpdateSql);
    $nursesStmt->bind_param("ssssi", $firstName, $lastName, $birthdate, $address, $primary_id);

    // Update the users table (assuming you also want to update the username and password)
    $usersUpdateSql = "UPDATE users SET username=?, password=? WHERE id=(SELECT user_id FROM nurses WHERE id=?)";
    $usersStmt = $conn->prepare($usersUpdateSql);
    $usersStmt->bind_param("ssi", $username, $hashed_password, $primary_id);

    // Execute both update statements
    $nursesUpdateSuccess = $nursesStmt->execute();
    $usersUpdateSuccess = $usersStmt->execute();

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
