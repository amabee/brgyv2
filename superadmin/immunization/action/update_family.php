<?php
// Include your database configuration file
include_once('../../../config.php');

$primary_id = $_POST['primary_id'];
$description = $_POST['description'];
$nurse_id = $_POST['nurse_id'];
$checkup_date = $_POST['checkup_date'];

try {
    // Start a transaction
    $conn->begin_transaction();

    $immunizationUpdateSql = "UPDATE immunization SET description=?, nurse_id=?, checkup_date=? WHERE id=?";
    $immunizationStmt = $conn->prepare($immunizationUpdateSql);
    $immunizationStmt->bind_param("sssi", $description, $nurse_id, $checkup_date, $primary_id);

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
