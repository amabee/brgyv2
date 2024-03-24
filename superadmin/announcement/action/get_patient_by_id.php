<?php
// Include your database configuration file
include_once('../../../config.php');

// Get the patient ID from the POST request
$patientId = $_POST['patient_id'];

try {
    // Fetch patient data from the database by ID
    $sql = "SELECT * FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patientId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $patientData = $result->fetch_assoc();

        // Return the patient data as JSON
        header('Content-Type: application/json');
        echo json_encode($patientData);
    } else {
        throw new Exception('Error fetching announcement data: ' . $stmt->error);
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
