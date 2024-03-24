<?php
// Include your database configuration file
include_once('../../../config.php');

// Get data from the POST request
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];

$middle_name = $_POST['middle_name'];
$suffix = $_POST['suffix'];
$gender = $_POST['gender'];
$age = $_POST['age'];

$contact_no = $_POST['contact_no'];
$civil_status = $_POST['civil_status'];
$religion = $_POST['religion'];
$serial_no = $_POST['serial_no'];





$checkSql = "SELECT COUNT(*) FROM patients WHERE serial_no = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $serial_no);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    echo 'Error: Serial number already exists';
}else{
        // Insert data into the "patients" table
        // Check if a patient with the same first_name and serial_no already exists
        $checkSql = "SELECT COUNT(*) FROM patients WHERE first_name = ? AND last_name = ? AND serial_no = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("sss", $first_name,$last_name,  $serial_no);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // A patient with the same first_name and serial_no already exists
            echo 'Error: Patient with the same name exists';
        } else {
            // No duplicate found, proceed with the insertion
            $sql = "INSERT INTO patients (first_name, last_name, birthdate, address, middle_name, suffix, gender, age, contact_no, civil_status, religion, serial_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssss", $first_name, $last_name, $birthdate, $address, $middle_name, $suffix, $gender, $age, $contact_no, $civil_status, $religion, $serial_no);

            if ($stmt->execute()) {
                // Successful insertion
                echo 'Success';
            } else {
                // Error handling
                echo 'Error: ' . $conn->error;
            }
            $stmt->close();
        $conn->close();
        }
}


// Close the database connection

?>
