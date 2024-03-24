<?php
// Include your database configuration file
include_once('../../../config.php');

// Get data from the POST request
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];

// Start a transaction to ensure data consistency
$conn->begin_transaction();
$role = 'nurse';
// Insert data into the "users" table
$user_sql = "INSERT INTO users (username, password,role) VALUES (?,?,?)";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("sss", $username, $password,$role);

if ($user_stmt->execute()) {
    // Get the last inserted user ID
    $user_id = $conn->insert_id;

    // Insert data into the "nurses" table with the user ID as a foreign key
    $nurse_sql = "INSERT INTO nurses (user_id, first_name, last_name, birthdate, address) VALUES (?, ?, ?, ?, ?)";
    $nurse_stmt = $conn->prepare($nurse_sql);
    $nurse_stmt->bind_param("sssss", $user_id, $first_name, $last_name, $birthdate, $address);

    if ($nurse_stmt->execute()) {
        // Commit the transaction if both inserts were successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction on failure
        $conn->rollback();
        echo 'Error: ' . $nurse_stmt->error;
    }

    $nurse_stmt->close();
} else {
    // Error handling for the "users" table insert
    echo 'Error: ' . $user_stmt->error;
}

// Close prepared statements and the database connection
$user_stmt->close();
$conn->close();
?>
