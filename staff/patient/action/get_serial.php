<?php
// Connect to your database (replace your_db_host, your_db_username, your_db_password, and your_db_name with your actual database details)
$conn = new mysqli("localhost", "root", "", "brgy");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Get the current year
$currentYear = date("y");
$defaultSerial = $currentYear . "0001";

// Query to get the latest serial number using prepared statement
$sql = "SELECT MAX(serial_no) AS max_serial FROM patients";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Query preparation failed: " . htmlspecialchars($conn->error));
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Get the latest serial number
    $latestSerial = $row["max_serial"];

    // Extract year from the latest serial number
    $latestYear = substr($latestSerial, 0, 2);

    // Check if the latest serial number is from the current year
    if ($latestYear == $currentYear) {
        // Increment the counting part
        $newCount = intval(substr($latestSerial, -4)) + 1;
        $newSerial = $currentYear . sprintf("%04d", $newCount);
    } else {
        // If the latest serial number is from a different year, start from 0001
        $newSerial = $currentYear . "0001";
    }
} else {
    // If there are no records, use the default serial number
    $newSerial = $defaultSerial;
}

// Close the database connection
$stmt->close();
$conn->close();

// Return the new serial number after using htmlspecialchars
echo htmlspecialchars($newSerial);
?>