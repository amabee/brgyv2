<?php
// Include your database configuration file
include_once('../../../config.php');

// Fetch the latest patient data from the "patients" table
$sql = "SELECT * FROM patients WHERE patients.is_deleted = 1";
$result = $conn->query($sql);

$patients = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the patient data as JSON
echo json_encode($patients);
?>
