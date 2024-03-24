<?php
// Include your database configuration file
include_once('../../../config.php');

$primary_id = $_POST['primary_id'];
$patient_id = $_POST['patient_id'];
$nurse_id = $_POST['nurse_id'];
$serial = $_POST['serial'];
$method = $_POST['method'];

try {
    // Start a transaction
    $conn->begin_transaction();


    $familyUpdateSql = "UPDATE family_plannings SET patient_id=?, nurse_id=?, method=?, serial=? WHERE id=?";
    $familyStmt = $conn->prepare($familyUpdateSql);
    $familyStmt->bind_param("ssssi", $patient_id, $nurse_id, $method, $serial, $primary_id);


    // Execute both update statements
    $familyUpdateSuccess = $familyStmt->execute();


    if ($familyUpdateSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $familyStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>
