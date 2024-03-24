<?php
// Start the session
session_start();
include_once('../../config.php');
// Assuming you have a database connection named $conn

// Get the user_id from the session if available
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

// Log logout information to the logs table
if ($user_id) {
    date_default_timezone_set('Asia/Manila');
   $logout_time = date("Y-m-d h:i:s a");
    $logout_date = date("Y-m-d");
    $logout_type = "logout";

    $sql = "INSERT INTO logs (user_id, time, date, type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isss", $user_id, $logout_time, $logout_date, $logout_type);

        if ($stmt->execute()) {
            // Successful insertion
            echo 'Logout Success';
        } else {
            // Error handling for execute
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        // Error handling for prepare
        echo 'Error preparing statement: ' . $conn->error;
    }
}

// Destroy all session data
session_destroy();

// Redirect to the login page after logout
header("Location: ../../index.php");
exit;
?>
