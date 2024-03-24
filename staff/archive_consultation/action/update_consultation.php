<?php
// Include your database configuration file
include_once('../../../config.php');

$primary_id = $_POST['primary_id'];
$description = $_POST['description'];
$checkup_date = $_POST['checkup_date'];
$doctor_id = $_POST['doctor_id'];

try {
    // Start a transaction
    $conn->begin_transaction();


    $consultationUpdateSql = "UPDATE consultations SET  description=?, checkup_date=?, doctor_id=? WHERE id=?";
    $consultationStmt = $conn->prepare($consultationUpdateSql);
    $consultationStmt->bind_param("sssi", $description, $checkup_date, $doctor_id, $primary_id);


    // Execute both update statements
    $consultationUpdateSuccess = $consultationStmt->execute();


    if ($consultationUpdateSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $consultationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>
