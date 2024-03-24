<?php
// Include your database configuration file
include_once('../../../config.php');

// Get data from the POST request
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];

// Insert data into the "patients" table
$sql = "INSERT INTO patients (first_name, last_name, birthdate, address) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $first_name, $last_name, $birthdate, $address);

if ($stmt->execute()) {
    // Successful insertion
    echo 'Success';
} else {
    // Error handling
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
