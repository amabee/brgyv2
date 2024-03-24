<?php
// Include your database configuration file
include_once('../../../config.php');

// Get data from the POST request
$description = $_POST['description'];
$title = $_POST['title'];
$date = $_POST['date'];
$time = $_POST['time'];

$sql = "INSERT INTO announcements (description, title,date,time) VALUES (?, ?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $description, $title, $date, $time);

if ($stmt->execute()) {
    // Successful insertion
    echo 'Success';
} else {
    // Error handling
    echo 'Error: ' . $conn->error;
}
$stmt->close();
$conn->close();


// Close the database connection

?>
