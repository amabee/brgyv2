<?php
include_once('../../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query the database to check if the user exists
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $role = $row["role"];

        // Redirect based on the user's role
        switch ($role) {
            case "admin":
                header("Location: ../admin/dashboard.php");
                break;
            case "superadmin":
                header("Location: superadmin.php");
                break;
            case "nurse":
                header("Location: nurse.php");
                break;
            case "staff":
                header("Location: staff.php");
                break;
            default:
                echo "Invalid role!";
                break;
        }
    } else {
        echo "Invalid username or password!";
    }
}

$conn->close();
?>
