<?php
// Include your database configuration file
include_once('../../../config.php');


$sql = "SELECT *,prenatal_subjective.id as id,patients.first_name as first_name,patients.last_name  as last_name
FROM prenatal_subjective
JOIN patients ON prenatal_subjective.patient_id = patients.id
JOIN midwife ON midwife.id = prenatal_subjective.nurse_id
JOIN prenatal_consultation ON prenatal_consultation.prenatal_subjective_id = prenatal_subjective.id
WHERE midwife.user_id = $user_id AND prenatal_consultation.medicine IS NULL AND prenatal_subjective.is_deleted = 0";

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
