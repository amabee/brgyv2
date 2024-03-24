<?php
// Include your database configuration file
include_once('../../../config.php');


$sql = "SELECT * FROM staffs WHERE is_deleted = 0";
$result = $conn->query($sql);

$mydata = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mydata[] = $row;
    }
}

// Close the database connection
$conn->close();

echo json_encode($mydata);
?>
