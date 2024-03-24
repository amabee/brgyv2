<?php
// Include your database configuration file
include_once('../../../config.php');
try {
   
    $dataId = $_POST['primary_id'];

    // Update the not_approve column to 1 instead of deleting
    $sql = "UPDATE family_plannings SET not_approved = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dataId);

    if ($stmt->execute()) {
        // Successful update
        echo 'Success';
    } else {
        // Error handling
        throw new Exception('Error updating data: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    echo 'Error: ' . $e->getMessage();
}
?>
