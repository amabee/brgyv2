<?php

$hostname = "localhost"; // Replace with your database hostname
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "brgy"; // Replace with your database name

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
