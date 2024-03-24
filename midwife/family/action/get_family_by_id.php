<?php
// Include your database configuration file
include_once('../../../config.php');


$dataId = $_POST['primary_id'];

try {
 
    $sql = "SELECT *,fp_information.id as id
    FROM fp_information
    JOIN patients ON fp_information.patient_id = patients.id
    JOIN nurses ON fp_information.nurse_id = nurses.id
    WHERE fp_information.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dataId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $myData = $result->fetch_assoc();

  
        header('Content-Type: application/json');
        echo json_encode($myData);
    } else {
        throw new Exception('Error fetching  data: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>
