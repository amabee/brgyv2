<?php
// Include your database configuration file
include_once('../../../config.php');


$sql = "SELECT *,consultations.id as id,CONCAT(patients.first_name, ' ', patients.last_name) AS full_name
FROM consultations
JOIN patients ON consultations.patient_id = patients.id
JOIN admins ON admins.id = consultations.doctor_id
WHERE consultations.is_active = 0 AND admins.user_id = $user_id AND consultations.is_print = 0" ;

$result = $conn->query($sql);

$myData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $myData[] = $row;
    }
}

// Close the database connection
$conn->close();


echo json_encode($myData);
?>
