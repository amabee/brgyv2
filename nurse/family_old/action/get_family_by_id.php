<?php
// Include your database configuration file
include_once('../../../config.php');


$dataId = $_POST['primary_id'];

try {
 
    $sql = "SELECT *,fp_information.id as id
    FROM fp_information
    JOIN fp_medical_history ON fp_medical_history.fp_information_id = fp_information.id
    JOIN fp_obstetrical_history ON fp_obstetrical_history.fp_information_id = fp_information.id
    JOIN fp_risk_for_sexuality ON fp_risk_for_sexuality.fp_information_id = fp_information.id
    JOIN fp_risk_for_violence_against_women ON fp_risk_for_violence_against_women.fp_information_id = fp_information.id
    JOIN fp_physical_examination ON fp_physical_examination.fp_information_id = fp_information.id
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
