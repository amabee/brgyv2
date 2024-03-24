<?php
// Include your database configuration file
include_once('../../../config.php');
try {
   
    $dataId = $_POST['primary_id'];


    $sql = "DELETE FROM staffs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dataId);

    if ($stmt->execute()) {
        // Successful deletion
        echo 'Success';
    } else {
        // Error handling
        throw new Exception('Error deleting data: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    echo 'Error: ' . $e->getMessage();
}
?>
