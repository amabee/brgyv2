<?php
// Include your database configuration file
include_once('../../../config.php');


$sql = "SELECT *,fp_information.id as id,patients.first_name as first_name,patients.last_name as last_name,nurses.first_name as first_name2,nurses.last_name as last_name2
FROM fp_information
JOIN patients ON fp_information.patient_id = patients.id
JOIN nurses ON fp_information.nurse_id = nurses.id
JOIN fp_consultation ON fp_consultation.fp_information_id = fp_information.id
WHERE  fp_information.is_deleted = 0";
;

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
