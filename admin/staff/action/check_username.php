<?php
// Include your database configuration file
include_once('../../../config.php');

// Check if the request is an AJAX request
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Query to check if the username already exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query); // Change $mysqli to $conn
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    // If the username exists, return an error
    if ($stmt->num_rows > 0) {
        echo "success";
    } else {
        echo "error";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close(); // Change $mysqli to $conn
}
?>
