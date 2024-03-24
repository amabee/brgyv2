<?php
// Include your database configuration file
include_once('../../../config.php');


$sql = "SELECT *,family_plannings.id as id
FROM family_plannings
JOIN patients ON family_plannings.patient_id = patients.id
JOIN nurses ON family_plannings.nurse_id = nurses.id";

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
