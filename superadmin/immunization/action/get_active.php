<?php
// Include your database configuration file
include_once('../../../config.php');


$sql = "SELECT *,immunization.id as id,patients.first_name as first_name,patients.last_name as last_name
FROM immunization
JOIN patients ON immunization.patient_id = patients.id WHERE immunization.is_deleted = 1";


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
