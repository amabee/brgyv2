<?php
// Include your database configuration file
include_once('../../../config.php');


$sql = "SELECT *,family_plannings.id as id,patients.first_name as first_name,patients.last_name as last_name,nurses.first_name as first_name2,nurses.last_name as last_name2
FROM family_plannings
JOIN patients ON family_plannings.patient_id = patients.id
JOIN nurses ON family_plannings.nurse_id = nurses.id
WHERE family_plannings.is_active = 0 AND family_plannings.not_approved = 0";

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
